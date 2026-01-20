<?php

abstract class Controller
{
    private array $observers = [];

    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    protected function notify(string $event, $data = null): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    protected function render(string $view, array $data = [])
    {
        extract($data);
        // Paths are relative to index.php
        require_once 'views/layout/header.php';
        require_once "views/$view.php";
    }

    protected function redirect(string $route)
    {
        // FIX: Prepend 'index.php?' to make the URL valid
        header("Location: index.php?$route");
        exit;
    }
}