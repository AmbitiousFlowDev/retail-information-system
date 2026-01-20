<?php

final class DashboardController extends Controller
{
    use AuthTrait;
    public function index()
    {
        $this->requireAuth();

        $metrics = [
            'revenue' => $this->getTotalRevenue(),
            'orders_count' => $this->getOrdersCount(),
            'products_count' => $this->getProductsCount(),
            'clients_count' => $this->getClientsCount(),
        ];

        $recentOrders = $this->getRecentOrders();
        $auditLogs = $this->getAuditLogs();

        $this->render('dashboard/index', compact(
            'metrics',
            'recentOrders',
            'auditLogs'
        ));
    }
    private function getTotalRevenue(): float
    {
        $db = Connection::getInstance();

        $stmt = $db->query("
            SELECT SUM(ol.quantity * ol.unit_price) AS revenue
            FROM OrderLine ol
        ");

        return (float) ($stmt->fetch()['revenue'] ?? 0);
    }
    private function getOrdersCount(): int
    {
        $db = Connection::getInstance();

        return (int) $db
            ->query("SELECT COUNT(*) FROM `Order`")
            ->fetchColumn();
    }
    private function getProductsCount(): int
    {
        $db = Connection::getInstance();

        return (int) $db
            ->query("SELECT COUNT(*) FROM Product")
            ->fetchColumn();
    }
    private function getClientsCount(): int
    {
        $db = Connection::getInstance();

        return (int) $db
            ->query("SELECT COUNT(*) FROM Client")
            ->fetchColumn();
    }
    private function getRecentOrders(): array
    {
        $db = Connection::getInstance();

        $stmt = $db->query("
            SELECT
                o.order_id,
                CONCAT(c.first_name, ' ', c.last_name) AS client,
                o.order_date,
                SUM(ol.quantity * ol.unit_price) AS total
            FROM `Order` o
            JOIN Client c      ON c.client_id = o.client_id
            JOIN OrderLine ol  ON ol.order_id = o.order_id
            GROUP BY o.order_id
            ORDER BY o.order_date DESC
            LIMIT 5
        ");

        return $stmt->fetchAll();
    }
    private function getAuditLogs(): array
    {
        $db = Connection::getInstance();

        $stmt = $db->query("
            SELECT
                a.action_type,
                a.action_date,
                a.description,
                u.username
            FROM Audit a
            JOIN User u ON u.user_id = a.user_id
            ORDER BY a.action_date DESC
            LIMIT 5
        ");

        return $stmt->fetchAll();
    }
}
