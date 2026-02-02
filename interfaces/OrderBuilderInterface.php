<?php

interface OrderBuilderInterface
{
    public function setOrderDate(string $date): self;
    public function setClientId(int $clientId): self;
    public function setEmployeeId(int $employeeId): self;
    public function build(): int;
}
