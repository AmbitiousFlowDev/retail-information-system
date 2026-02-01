<?php

class ConcreteOrderBuilder implements OrderBuilder
{
    private array $data = [];

    public function setDate(?string $date): self
    {
        $this->data['order_date'] = $date ?? date('Y-m-d');
        return $this;
    }

    public function setClient(int $clientId): self
    {
        $this->data['client_id'] = $clientId;
        return $this;
    }

    public function setEmployee(int $employeeId): self
    {
        $this->data['employee_id'] = $employeeId;
        return $this;
    }

    public function build(): array
    {
        return $this->data;
    }
}
