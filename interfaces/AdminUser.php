<?php

class AdminUser extends UserProfile {
    public function getRole(): string {
        return "USER_ADMIN";
    }
    public function canAccessDashboard(): bool {
        return true;
    }
}

