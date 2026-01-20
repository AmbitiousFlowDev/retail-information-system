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
        require_once 'views/layout/header.php';
        require_once "views/$view.php";
        require_once 'views/layout/footer.php';
    }

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }
}