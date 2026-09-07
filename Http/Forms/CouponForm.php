<?php

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;
use Models\Coupon;

class CouponForm
{
    protected array $errors = [];

    public function __construct(public array $attributes)
    {
        $code = $attributes['code'] ?? '';
        $discount_percent = $attributes['discount_percent'] ?? 0;
        $maxDiscount = $attributes['max_discount'] ?? 0;
        $minOrder = $attributes['min_order'] ?? 0;
        $usageLimit = $attributes['usage_limit'] ?? 0;
        $expiresAt = $attributes['expires_at'] ?? '';

        if (!Validator::string($code, 3, 50)) {
            $this->addError(
                'code',
                'Coupon code must be between 3 and 50 characters'
            );
        }

        if (!is_numeric($discount_percent) || $discount_percent <= 0 || $discount_percent > 100) {
            $this->addError(
                'discount_percent',
                'Percentage discount must be between 0 and 100'
            );
        }


        if (!is_numeric($maxDiscount) || $maxDiscount < 0) {
            $this->addError(
                'max_discount',
                'Maximum discount cannot be negative'
            );
        }

        if (!is_numeric($minOrder) || $minOrder < 0) {
            $this->addError(
                'min_order',
                'Minimum order cannot be negative'
            );
        }

        if (!is_numeric($usageLimit) || $usageLimit < 0) {
            $this->addError(
                'usage_limit',
                'Usage limit cannot be negative'
            );
        }

        if ($expiresAt === '') {
            $this->addError(
                'expires_at',
                'Expiry date is required'
            );
        } elseif (strtotime($expiresAt) === false) {
            $this->addError(
                'expires_at',
                'Invalid expiry date'
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
