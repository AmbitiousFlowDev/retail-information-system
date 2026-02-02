<?php

class ProductComponent implements Priceable {
    private array $data;

    public function __construct(array $productData) {
        $this->data = $productData;
    }

    public function getPrice(): float {
        return (float) $this->data['unit_price'];
    }

    public function getDescription(): string {
        return $this->data['product_name'] ?? 'Product';
    }
}