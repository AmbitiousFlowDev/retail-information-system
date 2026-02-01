<?php

abstract class AbstractUser
{
    protected string $username;
    protected string $passwordHash;
    protected int $employeeId;
    protected string $category;

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password_hash' => $this->passwordHash,
            'user_category' => $this->category,
            'employee_id' => $this->employeeId
        ];
    }
}

