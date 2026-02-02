<?php

final class OrderBuilder implements OrderBuilderInterface
{
    private Order $orderModel;

    private array $data = [
        'order_date'  => null,
        'client_id'   => null,
        'employee_id' => null
    ];

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function setOrderDate(string $date): self
    {
        $this->data['order_date'] = $date;
        return $this;
    }

    public function setClientId(int $clientId): self
    {
        if ($clientId <= 0) {
            throw new InvalidArgumentException('Invalid client ID');
        }
        $this->data['client_id'] = $clientId;
        return $this;
    }

    public function setEmployeeId(int $employeeId): self
    {
        if ($employeeId <= 0) {
            throw new InvalidArgumentException('Invalid employee ID');
        }
        $this->data['employee_id'] = $employeeId;
        return $this;
    }

    public function build(): int
    {
        foreach ($this->data as $key => $value) {
            if ($value === null) {
                throw new RuntimeException("Missing required field: {$key}");
            }
        }

        return $this->orderModel->create($this->data);
    }
}
