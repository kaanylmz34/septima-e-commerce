<?php

namespace App\Auth\Services;

use App\Auth\Objects\AuthCredentialsObject;
use App\Auth\Events\BeforeLoginEvent;
use App\Auth\Events\AfterLoginEvent;
use App\Auth\Events\LoginLockedOutEvent;
use Illuminate\Support\Facades\Auth;
use App\User\Models\User;

class LoginService
{

    public function __construct(
        public $fails = 0,
        public $locked = false,
    )
    {
        // Başlatıcı
        if (request()->session()->has('login_fails'))
            $this->fails = request()->session()->get('login_fails');

        if (request()->session()->has('login_locked'))
            $this->locked = request()->session()->get('login_locked');
    }

    public function loginWithEmail(AuthCredentialsObject $c)
    {
        $email = (string)$c->email;
        $password = (string)$c->password;

        if ($this->locked()) 
        {
            event(new LoginLockedOutEvent($email))
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

        if ($this->locked()) 
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
        
        $ok = Auth::login($user);

        if (!$ok)
        {
            $fails = $this->recordFailure($phone);
            $locked = $this->maybeLock($phone, $fails);

            if ($locked)
                event(new LoginLockedOutEvent($phone));
        }
        else
            $this->clearFailureState($phone);

        event(new AfterLoginEvent($c, $ok));

        return $authCredentialsObject;
    }

    public function isLocked(string $credentials): bool
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
