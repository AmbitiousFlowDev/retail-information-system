<?php

class TaxDecorator extends OrderDecorator
{
    private float $taxRate = 0.20; // 20%

    public function getTotal(): float
    {
        return $this->order->getTotal() * (1 + $this->taxRate);
    }

    public function getDescription(): string
    {
        return $this->order->getDescription() . " + TVA";
    }
}
