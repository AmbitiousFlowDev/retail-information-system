<?php

class OrderDirector
{
    public function createStandardOrder(
        OrderBuilder $builder,
        array $input
    ): array {
        return $builder
            ->setDate($input['order_date'] ?? null)
            ->setClient((int)($input['client_id'] ?? 0))
            ->setEmployee((int)($input['employee_id'] ?? 0))
            ->build();
    }
}


