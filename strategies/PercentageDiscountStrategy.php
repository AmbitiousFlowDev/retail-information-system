<?php

/**
 * Strategy: apply a percentage discount (e.g. 10% off).
 */
final class PercentageDiscountStrategy implements DiscountStrategy
{
    public function __construct(
        private readonly float $percentage
    ) {
        if ($percentage < 0 || $percentage > 100) {
            throw new InvalidArgumentException('Percentage must be between 0 and 100');
        }
    }

    public function apply(float $price, int $quantity = 1): float
    {
        $total = $price * $quantity;
        return $total * (1 - $this->percentage / 100);
    }

    public function getDescription(): string
    {
        return sprintf('-%s%% discount', number_format($this->percentage, 0));
    }
}
