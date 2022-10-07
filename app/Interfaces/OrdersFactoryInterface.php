<?php


namespace App\Interfaces;


use App\Models\Orders\Order;

interface OrdersFactoryInterface
{
    public function __construct(Order $order , $delivery_cost);

    public function createOrder($request);

    public function updateOrder();

    public function createInvoice();

    public function getInvoice();

    public function SendOrderToClosestDelegates($expectUsers=null);

}
