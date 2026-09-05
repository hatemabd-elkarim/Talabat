<?php

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;
use Models\User;

const MIN_NAME_LENGTH = 3;

class RegistrationForm
{
    protected array $errors = [];
    protected array $user = [];

    public function __construct(public array $attributes)
    {
        $name = $attributes['name'] ?? '';
        $email = $attributes['email'] ?? '';
        $password = $attributes['password'] ?? '';
        $confirmPassword = $attributes['confirm-password'] ?? '';
        $phone = $attributes['phone'] ?? '';
        $address = $attributes['address'] ?? '';

        if (! Validator::string($name, MIN_NAME_LENGTH, 100)) {
            $this->addError(
                'name',
                'Name must be between ' . MIN_NAME_LENGTH . ' and 100 charachters'
            );
        }

        if (! Validator::email($email)) {
            $this->addError(
                'email',
                'Please provide a valid email'
            );
        }

        if (! Validator::string($password, 8, 255)) {
            $this->addError(
                'password',
                'Password must be between 8 and 255 charachters'
            );
        }

        if ($password !== $confirmPassword) {
            $this->addError(
                'confirm-password',
                'Passwords do not match'
            );
        }

        if (!preg_match('/^01[0125][0-9]{8}$/', $phone)) {

            $this->addError(
                'phone',
                'Invalid Egyptian phone number'
            );
        }

        if (! Validator::string($address, 8, 255)) {
            $this->addError(
                'address',
                'Address must be between 8 and 255 charachters'
            );
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        if ($instance->failed()) {
            $instance->throwIfFailed();
        }

        return $instance;
    }

    public static function attempt($attributes)
    {
        $instance = static::validate($attributes);

        $email = $attributes['email'] ?? '';

        $user = User::findByEmail($email);

        if ($user) {
            $instance->addError(
                'email',
                'This email is already existed'
            );

            $instance->throwIfFailed();
        }

        $instance->user = User::create($attributes);

        return $instance;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function addError($key, $value)
    {
        $this->errors[$key] = $value;
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
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
