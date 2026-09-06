<?php

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;

class RestaurantForm
{
    protected array $errors = [];

    public function __construct(public array $attributes)
    {
        $name = $attributes['name'] ?? '';
        $cuisine = $attributes['cuisine'] ?? '';
        $address = $attributes['address'] ?? '';
        $phone = $attributes['phone'] ?? '';
        $email = $attributes['email'] ?? '';
        $latitude = $attributes['latitude'] ?? '';
        $longitude = $attributes['longitude'] ?? '';

        if (!Validator::string($name, 3, 100)) {
            $this->addError(
                'name',
                'Restaurant name must be between 3 and 100 characters'
            );
        }

        if (!Validator::string($cuisine, 2, 100)) {
            $this->addError(
                'cuisine',
                'Cuisine must be between 2 and 100 characters'
            );
        }

        if ($address !== '' && !Validator::string($address, 3, 255)) {
            $this->addError(
                'address',
                'Address must be between 3 and 255 characters'
            );
        }

        if ($phone !== '' && !preg_match('/^01[0125][0-9]{8}$/', $phone)) {
            $this->addError(
                'phone',
                'Invalid Egyptian phone number'
            );
        }

        if ($email !== '' && !Validator::email($email)) {
            $this->addError(
                'email',
                'Please provide a valid email'
            );
        }

        if ($latitude === '' || !is_numeric($latitude)) {
            $this->addError(
                'latitude',
                'Latitude is required'
            );
        }

        if ($longitude === '' || !is_numeric($longitude)) {
            $this->addError(
                'longitude',
                'Longitude is required'
            );
        }

        if (
            isset($attributes['logo']) &&
            $attributes['logo']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $this->validateImage($attributes['logo'], 'logo');
        }

        if (
            isset($attributes['banner']) &&
            $attributes['banner']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $this->validateImage($attributes['banner'], 'banner');
        }
    }

    private function validateImage(array $image, string $field): void
    {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            $this->addError(
                $field,
                'Failed to upload image'
            );

            return;
        }

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        $mimeType = mime_content_type($image['tmp_name']);

        if (!in_array($mimeType, $allowedTypes, true)) {
            $this->addError(
                $field,
                'Image must be JPG, PNG, or WEBP'
            );
        }

        if ($image['size'] > 5 * 1024 * 1024) {
            $this->addError(
                $field,
                'Image must be less than 5MB'
            );
        }
    }

    public static function validate(array $attributes): static
    {
        $instance = new static($attributes);

        if ($instance->failed()) {
            $instance->throwIfFailed();
        }

        return $instance;
    }

    public function addError($key, $value)
    {
        $this->errors[$key] = $value;

        return $this;
    }

    public function failed(): bool
    {
        return !empty($this->errors);
    }

    public function throwIfFailed(): never
    {
        ValidationException::throw(
            $this->errors,
            $this->attributes
        );
    }
}
