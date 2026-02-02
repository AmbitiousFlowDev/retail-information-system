<?php

abstract class UserProfile implements UserInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getUsername(): string
    {
        return $this->data['username'] ?? 'Unknown';
    }

    public function getId(): int
    {
        return (int) ($this->data['user_id'] ?? 0);
    }

    /** Default: no access; subclasses override per role. */
    public function canAccess(string $resource): bool
    {
        return false;
    }
}