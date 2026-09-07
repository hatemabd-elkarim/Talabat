<?php

namespace Models;

use Core\App;
use Core\Database;

class Coupon
{
    public static function all(): array
    {
        $db = App::resolve(Database::class);

        return $db->query(
            "SELECT *
             FROM coupons
             ORDER BY id DESC"
        )->get();
    }

    public static function find(int $id): ?array
    {
        $db = App::resolve(Database::class);

        $result = $db->query(
            "SELECT *
             FROM coupons
             WHERE id = :id",
            [
                'id' => $id
            ]
        )->find();

        return $result ?: null;
    }

    public static function findByCode(string $code): ?array
    {
        $db = App::resolve(Database::class);

        $result = $db->query(
            "SELECT *
             FROM coupons
             WHERE code = :code",
            [
                'code' => $code
            ]
        )->find();

        return $result ?: null;
    }

    public static function create(array $attributes): array
    {
        $db = App::resolve(Database::class);

        $db->query(
            "INSERT INTO coupons
            (
                code,
                discount_percent,
                max_discount,
                min_order,
                usage_limit,
                usage_count,
                expires_at,
                is_active
            )
            VALUES
            (
                :code,
                :discount_percent,
                :max_discount,
                :min_order,
                :usage_limit,
                0,
                :expires_at,
                :is_active
            )",
            [
                'code' => $attributes['code'],
                'discount_percent' => $attributes['discount_percent'],
                'max_discount' => $attributes['max_discount'],
                'min_order' => $attributes['min_order'],
                'usage_limit' => $attributes['usage_limit'],
                'expires_at' => $attributes['expires_at'],
                'is_active' => $attributes['is_active'],
            ]
        );

        $id = (int) $db->connection->lastInsertId();

        return self::find($id);
    }

    public static function update(int $id, array $attributes): ?array
    {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE coupons
             SET code = :code,
                 discount_percent = :discount_percent,
                 max_discount = :max_discount,
                 min_order = :min_order,
                 usage_limit = :usage_limit,
                 expires_at = :expires_at,
                 is_active = :is_active
             WHERE id = :id",
            [
                'code' => $attributes['code'],
                'discount_percent' => $attributes['discount_percent'],
                'max_discount' => $attributes['max_discount'],
                'min_order' => $attributes['min_order'],
                'usage_limit' => $attributes['usage_limit'],
                'expires_at' => $attributes['expires_at'],
                'is_active' => $attributes['is_active'],
                'id' => $id,
            ]
        );

        return self::find($id);
    }

    public static function updateStatus(
        int $id,
        int $isActive
    ): void {
        $db = App::resolve(Database::class);

        $db->query(
            "UPDATE coupons
             SET is_active = :is_active
             WHERE id = :id",
            [
                'is_active' => $isActive,
                'id' => $id,
            ]
        );
    }

    public static function delete(int $id): void
    {
        $db = App::resolve(Database::class);

        $db->query(
            "DELETE FROM coupons
             WHERE id = :id",
            [
                'id' => $id
            ]
        );
    }
}
