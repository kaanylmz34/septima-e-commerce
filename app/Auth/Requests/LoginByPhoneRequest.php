<?php

namespace App\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;
use App\Auth\Objects\AuthCredentialsObject;
use App\Auth\Services\LoginService;

class LoginByPhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Telefon girişi
        $authCredentialsObject = new AuthCredentialsObject(method: 'phone', $this->only('phone'));

        $loginService = new LoginService();
        if (!$loginService->loginWithPhone($authCredentialsObject))
        {
            RateLimiter::hit($this->throttleKey());
        }
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'phone' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);

    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('phone')).'|'.$this->ip();
    }
}