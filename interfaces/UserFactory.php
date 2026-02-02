<?php

class UserFactory {
    public static function create(array $data): UserInterface {
        return match (strtolower($data['user_category'])) {
            'admin' => new AdminUser($data),
            'hr' => new HRUser($data),
            default => throw new Exception("Unknown Category"),
        };
    }
}