<?php

class AuditObserver implements Observer
{
    public function update(string $event, $data = null): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            return;
        }

        $description = $this->generateDescription($event, $data);

        $audit = new Audit();
        $audit->create([
            'action_type' => strtoupper($event),
            'action_date' => date('Y-m-d H:i:s'),
            'description' => $description,
            'user_id' => $user instanceof UserInterface ? $user->getId() : null
        ]);
    }

    private function generateDescription(string $event, $data): string
    {
        $user = $_SESSION['user'] ?? null;
        $username = ($user instanceof UserInterface) ? $user->getUsername() : 'Unknown User';

        switch ($event) {
            case 'user.login':
                return "User '{$username}' logged into the system";

            case 'user.logout':
                return "User '{$username}' logged out of the system";

            case 'product.created':
                $name = $data['name'] ?? 'Unknown Product';
                $category = $data['category'] ?? 'N/A';
                $price = $data['unit_price'] ?? 0;
                $stock = $data['stock_quantity'] ?? 0;
                return "Product '{$name}' created in category '{$category}' with price €{$price} and stock quantity {$stock}";

            case 'product.updated':
                $id = $data['product_id'] ?? 'N/A';
                $name = $data['name'] ?? 'Unknown Product';
                $category = $data['category'] ?? 'N/A';
                $price = $data['unit_price'] ?? 0;
                $stock = $data['stock_quantity'] ?? 0;
                return "Product ID {$id} '{$name}' updated - Category: '{$category}', Price: €{$price}, Stock: {$stock}";

            case 'product.deleted':
                $id = $data['product_id'] ?? 'N/A';
                return "Product ID {$id} was deleted (soft delete)";

            case 'product.price_updated':
                $id = $data['product_id'] ?? 'N/A';
                $price = $data['price'] ?? 0;
                return "Product ID {$id} price updated to €{$price}";

            case 'order.created':
                $orderId = $data['order_id'] ?? 'N/A';
                $clientId = $data['client_id'] ?? 'N/A';
                return "Order ID {$orderId} created for Client ID {$clientId}";

            case 'order.updated':
                $orderId = $data['order_id'] ?? 'N/A';
                return "Order ID {$orderId} was updated";

            case 'order.deleted':
                $orderId = $data['order_id'] ?? 'N/A';
                return "Order ID {$orderId} was deleted";

            case 'client.created':
                $name = ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '');
                $city = $data['city'] ?? 'N/A';
                return "Client '{$name}' from {$city} was created";

            case 'client.updated':
                $id = $data['client_id'] ?? 'N/A';
                $name = ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '');
                return "Client ID {$id} '{$name}' information was updated";

            case 'client.deleted':
                $id = $data['client_id'] ?? 'N/A';
                return "Client ID {$id} was deleted";

            case 'employee.created':
                $name = ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '');
                return "Employee '{$name}' was created";

            case 'employee.updated':
                $id = $data['employee_id'] ?? 'N/A';
                $name = ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '');
                return "Employee ID {$id} '{$name}' information was updated";

            case 'employee.deleted':
                $id = $data['employee_id'] ?? 'N/A';
                return "Employee ID {$id} was deleted";

            case 'user.created':
                $usernameData = $data['username'] ?? 'N/A';
                return "New user account '{$usernameData}' was created";

            case 'user.updated':
                $id = $data['user_id'] ?? 'N/A';
                $usernameData = $data['username'] ?? 'N/A';
                return "User account '{$usernameData}' (ID: {$id}) was updated";

            case 'user.deleted':
                $id = $data['user_id'] ?? 'N/A';
                return "User account ID {$id} was deleted";

            default:
                return "Event '{$event}' occurred - " . json_encode($data);
        }
    }
}