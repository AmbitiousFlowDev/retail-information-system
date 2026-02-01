<?php

class CSVExportStrategy implements ExportStrategy
{
    public function export(array $orders): void
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Client', 'Employee', 'Date']);

        foreach ($orders as $order) {
            fputcsv($output, [
                $order['order_id'],
                $order['client_name'],
                $order['employee_name'],
                $order['order_date']
            ]);
        }

        fclose($output);
    }
}
