<?php

class DiscountDecorator extends ProductDecorator {
    public function getPrice(): float {
        return $this->component->getPrice() * 0.90;
    }

    public function getDescription(): string {
        return $this->component->getDescription() . " (-10% Discount)";
    }
}
