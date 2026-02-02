<?php
interface UserInterface {
    public function getRole(): string;
    public function canAccessDashboard(): bool;
    public function getUsername(): string;
    public function getId(): int;
}