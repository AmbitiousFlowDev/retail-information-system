<?php

/**
 * Strategy: no discount applied (pass-through).
 */
final class NoDiscountStrategy implements DiscountStrategy
{
    public function apply(float $price, int $quantity = 1): float
    {
        return $price * $quantity;
    }

    public function getDescription(): string
    {
        return 'No discount';
    }
}
