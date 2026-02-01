<?php

interface OrderPrice
{
    public function getTotal(): float;
    public function getDescription(): string;
}

