<?php

/**
 * Decorator: wraps a Priceable and applies a discount via Strategy.
 * Uses Strategy pattern for the discount calculation (percentage or fixed).
 */
class DiscountDecorator extends ProductDecorator
{
    private DiscountStrategy $strategy;

    public function __construct(Priceable $component, ?DiscountStrategy $strategy = null)
    {
        parent::__construct($component);
        $this->strategy = $strategy ?? new PercentageDiscountStrategy(10);
    }

    public function getPrice(): float
    {
        $basePrice = $this->component->getPrice();
        return $this->strategy->apply($basePrice, 1);
    }

    public function getDescription(): string
    {
        return $this->component->getDescription() . ' (' . $this->strategy->getDescription() . ')';
    }
}
