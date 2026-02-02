<?php

/**
 * Strategy pattern: defines how a discount is applied to a price.
 * Implementations: percentage off, fixed amount off, etc.
 */
interface DiscountStrategy
{
    public function apply(float $price, int $quantity = 1): float;

    public function getDescription(): string;
}
