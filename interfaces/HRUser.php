<?php

class HRUser extends UserProfile {
    public function getRole(): string {
        return "USER_HR";
    }
    public function canAccessDashboard(): bool {
        return true;
    }
}

