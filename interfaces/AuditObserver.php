<?php
require_once '../models/Audit.php';

class AuditObserver implements Observer
{
    public function update(string $event, $data = null): void
    {
        $audit = new Audit();
        $audit->create([
            'action_type' => $event,
            'action_date' => date('Y-m-d H:i:s'),
            'description' => json_encode($data),
            'user_id' => $_SESSION['user']['user_id'] ?? null
        ]);
    }
}
