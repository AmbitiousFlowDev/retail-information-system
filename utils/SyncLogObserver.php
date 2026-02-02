<?php

/**
 * Observer pattern: logs events to a simple log (e.g. for sync or debugging).
 * Demonstrates multiple observers attached to the same subject (Controller).
 */
class SyncLogObserver implements Observer
{
    private static array $log = [];

    public function update(string $event, $data = null): void
    {
        $entry = [
            'event' => $event,
            'time'  => date('Y-m-d H:i:s'),
            'data'  => $data,
        ];
        self::$log[] = $entry;
    }

    public static function getLog(): array
    {
        return self::$log;
    }

    public static function clearLog(): void
    {
        self::$log = [];
    }
}
