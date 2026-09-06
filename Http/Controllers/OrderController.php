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
}