<?php

/**
 * Strategy: subtract a fixed amount from the total (e.g. 5 EUR off).
 */
final class FixedAmountDiscountStrategy implements DiscountStrategy
{
    public function __construct(
        private readonly float $amount
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Discount amount must be non-negative');
        }
    }

    public function apply(float $price, int $quantity = 1): float
    {
        $total = $price * $quantity;
        return max(0, $total - $this->amount);
    }

    public function getDescription(): string
    {
        return sprintf('-€%s fixed discount', number_format($this->amount, 2));
    }
}
