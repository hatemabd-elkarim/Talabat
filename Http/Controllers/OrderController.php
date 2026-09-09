<?php

namespace Http\Controllers;

use Models\Order;
use Models\Restaurant;
use Core\App;
use Core\Session;
use Models\Coupon;


class OrderController
{
    public function showCustomerOrders()
    {
        $db = App::resolve('Core\Database');

        $customerId = $_SESSION['user']['id'] ?? null;

        if (!$customerId) {
            redirect('/login');
        }

        // هات كل أوردرات العميل مع اسم المطعم
        $orders = $db->query("
            SELECT
                o.id,
                o.total_price,
                o.status,
                o.payment_method,
                o.created_at,
                r.name AS restaurant_name,
                r.id   AS restaurant_id
            FROM orders o
            INNER JOIN restaurants r ON r.id = o.restaurant_id
            WHERE o.customer_id = :customer_id
            ORDER BY o.created_at DESC
        ", ['customer_id' => $customerId])->get();

        // هات الـ items بتاعت كل أوردر + الـ rating لو موجود
        foreach ($orders as &$order) {

            $items = $db->query("
                SELECT
                    p.name,
                    oi.quantity
                FROM order_items oi
                INNER JOIN products p ON p.id = oi.product_id
                WHERE oi.order_id = :order_id
            ", ['order_id' => $order['id']])->get();

            $order['items'] = array_map(function ($item) {
                return $item['name'] . ' x' . $item['quantity'];
            }, $items);

            $rating = $db->query("
                SELECT rating, comment
                FROM ratings
                WHERE customer_id = :customer_id
                AND restaurant_id = :restaurant_id
            ", [
                'customer_id'   => $customerId,
                'restaurant_id' => $order['restaurant_id']
            ])->find();

            $order['rating']  = $rating['rating']  ?? null;
            $order['review']  = $rating['comment'] ?? null;
        }
        unset($order);

        view('customer/orders/index.view.php', ['orders' => $orders]);
    }

    public function cart()
    {
        view('customer/cart.view.php');
    }

    /**
     * يعرض صفحة الـ Checkout/Payment
     * الكارت نفسه متخزن في localStorage عند العميل، فبنجيب هنا بس
     * عنوان التوصيل الحقيقي من قاعدة البيانات.
     */
    public function showCheckout()
    {
        $customerId = $_SESSION['user']['id'] ?? null;

        if (!$customerId) {
            redirect('/login');
        }

        $db = App::resolve('Core\Database');

        $user = $db->query("
            SELECT address_text FROM users WHERE id = :id
        ", ['id' => $customerId])->find();

        $address = $user['address_text'] ?? 'Set your address';

        view('customer/checkout.view.php', ['address' => $address]);
    }

    /**
     * بيستقبل بيانات الأوردر (JSON) من صفحة الـ checkout ويحفظه فعلياً
     * في جدولي orders و order_items.
     */
    public function placeOrder()
    {
        header('Content-Type: application/json');

        $customerId = $_SESSION['user']['id'] ?? null;

        if (!$customerId) {
            http_response_code(401);

            echo json_encode([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ]);

            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $items         = $input['items'] ?? [];
        $paymentMethod = $input['payment_method'] ?? 'COD';
        $coupon        = $input['coupon'] ?? null;

        if (empty($items)) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'السلة فاضية'
            ]);

            exit();
        }

        // All cart items should belong to the same restaurant
        $restaurantId = $items[0]['restaurantId'] ?? null;

        if (!$restaurantId) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'بيانات المطعم ناقصة'
            ]);

            exit();
        }

        $db = App::resolve('Core\Database');


        /*
     * Get restaurant delivery fee
     */

        $restaurant = $db->query("
        SELECT delivery_fee
        FROM restaurants
        WHERE id = :restaurant_id
          AND is_enabled = TRUE
    ", [
            'restaurant_id' => $restaurantId
        ])->find();

        if (!$restaurant) {
            http_response_code(400);

            echo json_encode([
                'success' => false,
                'message' => 'Restaurant not found'
            ]);

            exit();
        }

        $deliveryFee = (float) $restaurant['delivery_fee'];


        /*
     * Calculate subtotal
     */

        $subtotal = 0;

        foreach ($items as $item) {

            $price = (float) ($item['price'] ?? 0);
            $quantity = (int) ($item['qty'] ?? 0);

            if ($quantity <= 0) {
                http_response_code(400);

                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid quantity'
                ]);

                exit();
            }

            $subtotal += $price * $quantity;
        }


        /*
     * Apply coupon
     */

        $couponId = null;
        $discount = 0;

        if ($coupon && !empty($coupon['code'])) {

            $couponCode = strtoupper(trim($coupon['code']));

            $validCoupon = Coupon::findValidCoupon(
                $couponCode,
                $subtotal
            );

            if (!$validCoupon) {
                http_response_code(400);

                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid or expired coupon.'
                ]);

                exit();
            }

            $discount =
                ($subtotal * (float) $validCoupon['discount_percent']) / 100;

            if ($validCoupon['max_discount'] !== null) {

                $discount = min(
                    $discount,
                    (float) $validCoupon['max_discount']
                );
            }

            $couponId = $validCoupon['id'];
        }


        /*
     * Calculate final total
     */

        $total = max(
            0,
            $subtotal + $deliveryFee - $discount
        );


        /*
     * Create order
     */

        $db->query("
        INSERT INTO orders (
            customer_id,
            restaurant_id,
            coupon_id,
            total_price,
            status,
            payment_method
        )
        VALUES (
            :customer_id,
            :restaurant_id,
            :coupon_id,
            :total_price,
            'pending',
            :payment_method
        )
    ", [
            'customer_id'    => $customerId,
            'restaurant_id'  => $restaurantId,
            'coupon_id'      => $couponId,
            'total_price'    => $total,
            'payment_method' => $paymentMethod
        ]);

        $orderId = $db->connection->lastInsertId();


        /*
     * Create order items
     */

        foreach ($items as $item) {

            $db->query("
            INSERT INTO order_items (
                order_id,
                product_id,
                quantity,
                price
            )
            VALUES (
                :order_id,
                :product_id,
                :quantity,
                :price
            )
        ", [
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $item['price']
            ]);
        }


        echo json_encode([
            'success' => true,
            'order_id' => $orderId
        ]);

        exit();
    }

    public function updateOrderStatus()
    {
        $userId = (int) Session::get('user')['id'];

        $restaurant = Restaurant::findByOwnerId($userId);

        $orderId = (int) ($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        $updated = Order::updateOrderStatus(
            $orderId,
            $restaurant['id'],
            $status
        );

        header('Content-Type: application/json');

        echo json_encode([
            'success' => $updated,
            'status' => $status
        ]);
    }
}
