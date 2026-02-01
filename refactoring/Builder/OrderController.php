<?php

class OrderController extends Controller
{
    /// ... other methods
    public function create(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $builder = new ConcreteOrderBuilder();
            $director = new OrderDirector();

            $orderData = $director->createStandardOrder($builder, $data);
            $this->order->create($orderData);
            $this->redirect('controller=Order&action=index');
        }
    }
}
