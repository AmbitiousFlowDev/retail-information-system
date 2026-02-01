<?php

interface OrderBuilder
{
    public function setDate(?string $date): self;
    public function setClient(int $clientId): self;
    public function setEmployee(int $employeeId): self;
    public function build(): array;
}


