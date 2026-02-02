<?php

interface UserInterface
{
    public function getRole(): string;

    public function canAccessDashboard(): bool;

    /** @param string $resource One of: dashboard, products, orders, clients, employees, users, audit */
    public function canAccess(string $resource): bool;

    public function getUsername(): string;

    public function getId(): int;
}