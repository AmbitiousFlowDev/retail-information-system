<?php

require_once 'utils/Observer.php';

class AuditLogger implements Observer
{
    public function update(string $event, $data = null): void
    {
        $logEntry = date('Y-m-d H:i:s') . " - EVENT: [$event] - DATA: " . json_encode($data) . PHP_EOL;
        file_put_contents('app_audit.log', $logEntry, FILE_APPEND);
    }
}