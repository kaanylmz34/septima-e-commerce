<?php

namespace App\Auth\Services;

use App\Auth\Objects\AuthCredentialsObject;
use App\Auth\Events\BeforeLoginEvent;
use App\Auth\Events\AfterLoginEvent;
use App\Auth\Events\LoginLockedOutEvent;
use App\Auth\Events\OtpGeneratedEvent;
use Illuminate\Support\Facades\Auth;
use App\User\Models\User;

class LoginService
{

    public function __construct(
        public $fails = 0,
        public $locked = false,
        private $otp = null,
    )
    {
        // Başlatıcı
        if (request()->session()->has('login_fails'))
            $this->fails = request()->session()->get('login_fails');

        if (request()->session()->has('login_locked'))
            $this->locked = request()->session()->get('login_locked');

        if (request()->session()->has('otp'))
            $this->otp = request()->session()->get('otp');
    }

    public function loginWithEmail(AuthCredentialsObject $c)
    {
        $email = (string)$c->email;
        $password = (string)$c->password;

        if ($this->isLocked()) 
        {
            event(new LoginLockedOutEvent($email));
            return false;
        }

        event(new BeforeLoginEvent($c));

        $ok = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$ok)
        {
            $fails = $this->recordFailure($email);
            $locked = $this->maybeLock($email, $fails);

            if ($locked)
                event(new LoginLockedOutEvent($email));
        }
        else
            $this->clearFailureState($email);

        event(new AfterLoginEvent($c, $ok));

        return $authCredentialsObject;
    }

    public function loginWithPhone(AuthCredentialsObject $c)
    {
        $phone = (string)$c->phone;

        if ($this->isLocked()) 
        {
            event(new LoginLockedOutEvent($phone));
            return false;
        }

        event(new BeforeLoginEvent($c));

        $user = User::where('phone', $phone)->first();
        if (!$user) 
        {
            throw new \Exception('User not found');
        }

        try
        {
            $this->verifyOtpForPhoneLogin((string)$c->otp);
            
            $ok = Auth::login($user);

            return $authCredentialsObject;
        }
        catch (\Exception $e)
        {
            $fails = $this->recordFailure($phone);
            $locked = $this->maybeLock($phone, $fails);

            if ($locked)
                event(new LoginLockedOutEvent($phone));

            throw $e;
        }
        finally
        {
            event(new AfterLoginEvent($c, $ok ?? false));
        }
    }

    public function generateOtpForPhoneLogin(AuthCredentialsObject $c): int
    {
        // 6 haneli OTP oluştur
        $otp = rand(100000, 999999);
        $otpHash = hash_hmac('sha256', $otp, config('app.key'));

        // OTP'yi oturumda sakla
        request()->session()->put('otp_hash', $otpHash);
        request()->session()->put('otp_phone', (string)$c->phone);
        request()->session()->put('otp_generated_at', now());
        request()->session()->put('otp_expires_at', now()->addMinutes(5));
        request()->session()->put('otp_attempts', 0);

        event(new OtpGeneratedEvent($c->phone, $otp));

        return $otp;
    }

    public function verifyOtpForPhoneLogin(string $incomingOtp): bool
    {
        $session = request()->session();

        $expiresAt = $session->get('otp_expires_at');
        $phone = $session->get('otp_phone');
        $otpHash = $session->get('otp_hash');
        $attempts = (int) $session->get('otp_attempts', 0);

        // ERR_2000: OTP expired or not generated
        if (!$otpHash || !$expiresAt || now()->gte($expiresAt))
        {
            throw new \Exception('OTP expired or not generated', 2000);
            return false;
        }

        // ERR_2001: Too many attempts
        if ($attempts >= 5)
        {
            throw new \Exception('Too many attempts', 2001);
            return false;
        }

        $calc = hash_hmac('sha256', (string) $incomingOtp, config('app.key'));
        $match = hash_equals($otpHash, $calc);

        // Attempt sayacı güncelle
        $session->put('otp_attempts', $attempts + 1);

        if ($match) 
        {
            // Başarılı: OTP state temizle
            $session->forget(['otp_hash', 'otp_phone', 'otp_generated_at', 'otp_expires_at', 'otp_attempts']);
            return true;
        }

        return false;
    }

    public function isLocked(): bool
    {
        // Locking durumu (service katmanı)
        return $this->locked;
    }

    public function recordFailure(string $credentials): int
    {
        // Başarısız giriş denemesi kaydı (service katmanı)
        $this->fails += 1;
        request()->session()->put('login_fails', $this->fails);

        return $this->fails;
    }

    public function maybeLock(string $credentials, int $fails): bool
    {
        // Giriş kilitleme kontrolü (service katmanı)
        return $this->fails >= 5;
    }

    public function clearFailureState(string $credentials): void
    {
        // Başarısız giriş denemesi sayısını sıfırla (service katmanı)
        $this->fails = 0;
        $this->locked = false;

        request()->session()->forget('login_fails');
        request()->session()->forget('login_locked');
    }

}
