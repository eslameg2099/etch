<?php


namespace App\Interfaces;


use App\Models\Orders\Order;

interface OrdersRepositoryInterface
{
    public function getAllOrders();

    public function getOrderById($id);

    public function createOrder($request);

    public function updateOrder($request, $id);

    public function deleteOrder($id);

    public function changeDelegate($order);

    public function startOrder(Order $order);

    public function cancelOrder(Order $order);
}
