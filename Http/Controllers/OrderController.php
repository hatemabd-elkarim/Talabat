<?php

namespace Http\Controllers;

use Core\App;

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
            echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول أولاً']);
            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $items         = $input['items'] ?? [];
        $paymentMethod = $input['payment_method'] ?? 'COD';

        if (empty($items)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'السلة فاضية']);
            exit();
        }

        // بنفترض إن كل الأصناف في الكارت من نفس المطعم (زي أغلب تطبيقات التوصيل)
        $restaurantId = $items[0]['restaurantId'] ?? null;

        if (!$restaurantId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'بيانات المطعم ناقصة']);
            exit();
        }

        $deliveryFee = 15; // رسوم توصيل ثابتة مؤقتاً
        $total = $deliveryFee;
        foreach ($items as $item) {
            $total += (float) $item['price'] * (int) $item['qty'];
        }

        $db = App::resolve('Core\Database');

        $db->query("
            INSERT INTO orders (customer_id, restaurant_id, total_price, status, payment_method)
            VALUES (:customer_id, :restaurant_id, :total_price, 'pending', :payment_method)
        ", [
            'customer_id'    => $customerId,
            'restaurant_id'  => $restaurantId,
            'total_price'    => $total,
            'payment_method' => $paymentMethod,
        ]);

        $orderId = $db->connection->lastInsertId();

        foreach ($items as $item) {
            $db->query("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)
            ", [
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
            ]);
        }

        echo json_encode(['success' => true, 'order_id' => $orderId]);
        exit();
    }
}