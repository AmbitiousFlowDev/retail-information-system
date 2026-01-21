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
        require_once "views/$view.php";
    }
    protected function redirect(string $route)
    {
        header("Location: index.php?$route");
        exit;
    }
}