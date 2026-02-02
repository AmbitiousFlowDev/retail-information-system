<?php

class TaxDecorator extends ProductDecorator {
    public function getPrice(): float {
        return $this->component->getPrice() * 1.20;
    }

    public function getDescription(): string {
        return $this->component->getDescription() . " (+ Tax)";
    }
}