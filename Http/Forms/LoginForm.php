<?php

namespace Http\Forms;

use Core\ValidationException;
use Core\Validator;
use Models\User;

class LoginForm
{
    protected array $errors = [];
    protected ?array $user = null;

    public function __construct(
        public array $attributes
    ) {}

    public static function attempt(array $attributes): static
    {
        $instance = new static($attributes);

        $instance->validate();

        if ($instance->failed()) {
            $instance->throwIfFailed();
        }

        return $instance;
    }

    protected function validate(): void
    {
        if (! Validator::email($this->attributes['email'] ?? '')) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if (! Validator::string($this->attributes['password'] ?? '', 8, 255)) {
            $this->errors['password'] = 'Password must be between 8 and 255 characters.';
        }

        if ($this->failed()) {
            return;
        }

        $user = User::findByEmail($this->attributes['email']);

        if (! $user || ! password_verify($this->attributes['password'], $user['password'])) {
            $this->errors['Invalid_Credentials'] = 'No match found for the provided email and password.';
            return;
        }

        $this->user = $user;
    }

    public function user(): array
    {
        return $this->user;
    }

    public function failed(): bool
    {
        return ! empty($this->errors);
    }

    public function throwIfFailed(): never
    {
        ValidationException::throw(
            $this->errors,
            array_filter(
                $this->attributes,
                fn($key) => $key !== 'password',
                ARRAY_FILTER_USE_KEY
            )
        );
    }
}
