<?php


class BaseOrder implements OrderPrice
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function getTotal(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return "Commande de base";
    }
}
