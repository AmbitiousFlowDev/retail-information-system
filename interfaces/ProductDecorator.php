<?php

abstract class ProductDecorator implements Priceable {
    protected Priceable $component;

    public function __construct(Priceable $component) {
        $this->component = $component;
    }
}

