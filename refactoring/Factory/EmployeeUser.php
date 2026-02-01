<?php

final class UserFactory
{
    public static function create(
        string $type,
        string $username,
        string $password,
        int $employeeId
    ): AbstractUser {
        return match ($type) {
            'ADMIN' => new AdminUser($username, $password, $employeeId),
            'EMPLOYEE' => new EmployeeUser($username, $password, $employeeId),
            default => throw new InvalidArgumentException('Invalid user type')
        };
    }
}
