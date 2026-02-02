<?php

interface UserInterface {
    public function getRole(): string;
    public function canAccessDashboard(): bool;
}