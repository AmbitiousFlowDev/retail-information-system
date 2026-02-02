<?php

/**
 * Factory pattern: creates the appropriate UserInterface implementation
 * based on user_category (ADMIN) or role_code (USER_HR, USER_COMMERCIAL, etc.).
 */
class AdminUser extends UserProfile
{
    public function getRole(): string
    {
        return 'USER_ADMIN';
    }

    public function canAccessDashboard(): bool
    {
        return true;
    }

    public function canAccess(string $resource): bool
    {
        return true; // Admin: full access
    }
}

class HRUser extends UserProfile
{
    public function getRole(): string
    {
        return 'USER_HR';
    }

    public function canAccessDashboard(): bool
    {
        return true;
    }

    /** HR: only Dashboard, Employees, Audit (no Users, Products, Orders, Clients). */
    public function canAccess(string $resource): bool
    {
        return in_array($resource, ['dashboard', 'employees', 'audit'], true);
    }
}

class CommercialUser extends UserProfile
{
    public function getRole(): string
    {
        return 'USER_COMMERCIAL';
    }

    public function canAccessDashboard(): bool
    {
        return true;
    }

    /** Commercial: only Dashboard, Products, Orders, Audit (no Clients, Employees, Users). */
    public function canAccess(string $resource): bool
    {
        return in_array($resource, ['dashboard', 'products', 'orders', 'audit'], true);
    }
}

class DirectionUser extends UserProfile
{
    public function getRole(): string
    {
        return 'USER_DIRECTION';
    }

    public function canAccessDashboard(): bool
    {
        return true;
    }

    public function canAccess(string $resource): bool
    {
        return true; // Direction: full access
    }
}

class PurchasingUser extends UserProfile
{
    public function getRole(): string
    {
        return 'USER_PURCHASING';
    }

    public function canAccessDashboard(): bool
    {
        return true;
    }

    public function canAccess(string $resource): bool
    {
        return true; // Purchasing: full access
    }
}

final class UserFactory
{
    public static function create(array $userData): UserInterface
    {
        $category = trim(strtoupper($userData['user_category'] ?? ''));
        $roleCode = trim(strtoupper($userData['role_code'] ?? ''));

        if ($category === 'ADMIN') {
            return new AdminUser($userData);
        }

        return match ($roleCode) {
            'USER_HR'         => new HRUser($userData),
            'USER_COMMERCIAL' => new CommercialUser($userData),
            'USER_DIRECTION'  => new DirectionUser($userData),
            'USER_PURCHASING' => new PurchasingUser($userData),
            default           => new CommercialUser($userData),
        };
    }
}