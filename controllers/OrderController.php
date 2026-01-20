<?php
require_once 'Controller.php';
require_once '../models/Order.php';

class OrderController extends Controller
{
    private Order $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function index()
    {
        $orders = $this->order->all();
        $this->render('orders/index', compact('orders'));
    }

    public function delete(int $id)
    {
        $this->order->delete($id);
        $this->notify('order.deleted', ['order_id' => $id]);
        $this->redirect('/orders');
    }
}
