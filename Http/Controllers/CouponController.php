<?php

namespace Http\Controllers;

use Models\Coupon;
use Http\Forms\CouponForm;

class CouponController
{
    public function adminCoupons()
    {
        $coupons = Coupon::all();

        $activeCount = count(
            array_filter(
                $coupons,
                fn($coupon) => $coupon['is_active']
            )
        );

        view('admin/coupons.view.php', [
            'activePage' => 'a-coupons',
            'coupons' => $coupons,
            'activeCount' => $activeCount,
        ]);
    }

    public function storeCoupon()
    {
        $form = CouponForm::validate([
            'code' => strtoupper(trim($_POST['code'] ?? '')),
            'discount_percent' => $_POST['discount_percent'] ?? 0,
            'max_discount' => $_POST['max_discount'] ?? 0,
            'min_order' => $_POST['min_order'] ?? 0,
            'usage_limit' => $_POST['usage_limit'] ?? 0,
            'expires_at' => $_POST['expires_at'] ?? '',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        // Check duplicate code
        if (Coupon::findByCode($form->attributes['code'])) {
            $form->addError(
                'code',
                'This coupon code already exists'
            );

            $form->throwIfFailed();
        }

        $coupon = Coupon::create($form->attributes);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'coupon' => $coupon
        ]);
    }

    public function updateCoupon()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(422);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Coupon ID is required'
            ]);

            return;
        }

        $coupon = Coupon::find((int) $id);

        if (!$coupon) {
            http_response_code(404);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Coupon not found'
            ]);

            return;
        }

        $form = CouponForm::validate([
            'code' => strtoupper(trim($_POST['code'] ?? '')),
            'discount_percent' => $_POST['discount_percent'] ?? 0,
            'max_discount' => $_POST['max_discount'] ?? 0,
            'min_order' => $_POST['min_order'] ?? 0,
            'usage_limit' => $_POST['usage_limit'] ?? 0,
            'expires_at' => $_POST['expires_at'] ?? '',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        $existingCoupon = Coupon::findByCode(
            $form->attributes['code']
        );

        if (
            $existingCoupon &&
            (int) $existingCoupon['id'] !== (int) $id
        ) {
            $form->addError(
                'code',
                'This coupon code already exists'
            );

            $form->throwIfFailed();
        }

        $updatedCoupon = Coupon::update(
            (int) $id,
            $form->attributes
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'coupon' => $updatedCoupon
        ]);
    }

    public function updateCouponStatus()
    {
        parse_str(file_get_contents('php://input'), $data);

        $id = $data['id'] ?? null;
        $isActive = $data['is_active'] ?? null;

        if ($id === null || $isActive === null) {
            http_response_code(422);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Invalid data'
            ]);

            return;
        }

        Coupon::updateStatus(
            (int) $id,
            (int) $isActive
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true
        ]);
    }

    public function deleteCoupon()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            http_response_code(422);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Coupon ID is required'
            ]);

            return;
        }

        $coupon = Coupon::find((int) $id);

        if (!$coupon) {
            http_response_code(404);

            header('Content-Type: application/json');

            echo json_encode([
                'success' => false,
                'message' => 'Coupon not found'
            ]);

            return;
        }

        Coupon::delete((int) $id);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true
        ]);
    }
}
