<?php
class AdminUser extends UserProfile
{
    public function getRole(): string
    {
        return "USER_ADMIN";
    }
    public function canAccessDashboard(): bool
    {
        return true;
    }
}

class HRUser extends UserProfile
{
    public function getRole(): string
    {
        return "USER_HR";
    }
    public function canAccessDashboard(): bool
    {
        return true;
    }
}

class CommercialUser extends UserProfile
{
    public function getRole(): string
    {
        return "USER_COMMERCIAL";
    }
    public function canAccessDashboard(): bool
    {
        return false;
    }
}
final class UserFactory {
    public static function create(array $userData): UserInterface {
        // Ensure we handle potential whitespace or case issues from the DB
        $role = trim(strtoupper($userData['role'] ?? ''));

        return match ($role) {
            'ADMIN'      => new AdminUser($userData),
            'HR'         => new HRUser($userData),
            'COMMERCIAL' => new CommercialUser($userData),
            // Fallback for your DB 'EMPLOYEE' category or others
            default      => throw new Exception("Invalid user role: " . $role),
        };
    }
}