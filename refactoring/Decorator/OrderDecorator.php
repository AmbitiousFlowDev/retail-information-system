<?php

abstract class OrderDecorator implements OrderPrice
{
    protected OrderPrice $order;

    public function __construct(OrderPrice $order)
    {
        $this->order = $order;
    }
}
