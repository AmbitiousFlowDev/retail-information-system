<?php

final class AdminUser extends AbstractUser
{
    public function __construct(string $username, string $password, int $employeeId)
    {
        $this->username = $username;
        $this->passwordHash = md5($password);
        $this->employeeId = $employeeId;
        $this->category = 'ADMIN';
    }
}



