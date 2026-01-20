<?php
require_once __DIR__ . '/../../utils/Auth.php';
require_once __DIR__ . '/../../models/User.php';

// Check Authentication
if (!Auth::check()) {
    header('Location: ../auth/login.php');
    exit;
}

$user = Auth::user();

// -------------------------------------------------------------------------
// MOCK DATA FETCHING (Replace with actual Model calls)
// -------------------------------------------------------------------------
$metrics = [
    'revenue' => 45231.89,
    'orders_count' => 1250,
    'products_count' => 340,
    'clients_count' => 85,
];

$recentOrders = [
    ['id' => '#ORD-001', 'client' => 'Alice Johnson', 'date' => '2023-10-24', 'total' => 120.50, 'status' => 'Completed'],
    ['id' => '#ORD-002', 'client' => 'Bob Smith', 'date' => '2023-10-24', 'total' => 85.00, 'status' => 'Pending'],
    ['id' => '#ORD-003', 'client' => 'Charlie Brown', 'date' => '2023-10-23', 'total' => 210.20, 'status' => 'Shipped'],
    ['id' => '#ORD-004', 'client' => 'Diana Prince', 'date' => '2023-10-23', 'total' => 50.00, 'status' => 'Completed'],
    ['id' => '#ORD-005', 'client' => 'Evan Wright', 'date' => '2023-10-22', 'total' => 75.00, 'status' => 'Pending'],
];

$auditLogs = [
    ['id' => 101, 'user' => 'admin', 'action' => 'LOGIN', 'entity' => 'Auth', 'timestamp' => '2 mins ago'],
    ['id' => 102, 'user' => 'sales_rep', 'action' => 'CREATE', 'entity' => 'Order #1250', 'timestamp' => '15 mins ago'],
    ['id' => 103, 'user' => 'manager', 'action' => 'UPDATE', 'entity' => 'Product #340', 'timestamp' => '1 hour ago'],
    ['id' => 104, 'user' => 'admin', 'action' => 'DELETE', 'entity' => 'User #5', 'timestamp' => '3 hours ago'],
    ['id' => 105, 'user' => 'system', 'action' => 'BACKUP', 'entity' => 'Database', 'timestamp' => 'Yesterday'],
];
// -------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-slate-800 font-sans antialiased">

<div class="flex h-screen w-full">

    <?php include_once("views/layout/sidebar.php") ?>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex justify-between items-center px-6 lg:px-8">
            <h1 class="text-xl font-semibold text-slate-800">Overview</h1>
            
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600">Welcome, <strong><?= htmlspecialchars($user->username ?? 'Admin') ?></strong></span>
                <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>
            </div>
        </header>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-auto p-6 lg:p-8">
            
            <!-- 1. Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">$<?= number_format($metrics['revenue'], 2) ?></h3>
                    </div>
                    <div class="p-2 bg-green-50 text-green-600 rounded-md">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Orders</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= number_format($metrics['orders_count']) ?></h3>
                    </div>
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-md">
                        <i class="fa-solid fa-shopping-cart"></i>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Products</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= number_format($metrics['products_count']) ?></h3>
                    </div>
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-md">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Clients</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= number_format($metrics['clients_count']) ?></h3>
                    </div>
                    <div class="p-2 bg-orange-50 text-orange-600 rounded-md">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- 2. Tables Grid (Orders & Audit) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Recent Orders Table -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-slate-800">Recent Orders</h3>
                        <a href="../orders/index.php" class="text-xs font-medium text-blue-600 hover:underline">View All</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="py-2 pl-2 font-medium text-slate-500">ID</th>
                                    <th class="py-2 font-medium text-slate-500">Status</th>
                                    <th class="py-2 pr-2 text-right font-medium text-slate-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach($recentOrders as $order): ?>
                                <tr>
                                    <td class="py-3 pl-2">
                                        <div class="font-medium text-slate-800"><?= $order['id'] ?></div>
                                        <div class="text-xs text-slate-400"><?= $order['client'] ?></div>
                                    </td>
                                    <td class="py-3">
                                        <?php 
                                            $badgeClass = match($order['status']) {
                                                'Completed' => 'text-green-700 bg-green-50',
                                                'Pending'   => 'text-yellow-700 bg-yellow-50',
                                                'Shipped'   => 'text-blue-700 bg-blue-50',
                                                default     => 'text-gray-700 bg-gray-50'
                                            };
                                        ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $badgeClass ?>">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="py-3 pr-2 text-right text-slate-600 font-medium">
                                        $<?= number_format($order['total'], 2) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Audit Log Table -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-slate-800">System Audit Log</h3>
                        <span class="text-xs font-medium text-slate-400">Latest Activity</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="py-2 pl-2 font-medium text-slate-500">Action</th>
                                    <th class="py-2 font-medium text-slate-500">User</th>
                                    <th class="py-2 pr-2 text-right font-medium text-slate-500">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php foreach($auditLogs as $log): ?>
                                <tr>
                                    <td class="py-3 pl-2">
                                        <div class="font-medium text-slate-800"><?= $log['action'] ?></div>
                                        <div class="text-xs text-slate-400"><?= $log['entity'] ?></div>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded text-xs">
                                            <?= $log['user'] ?>
                                        </span>
                                    </td>
                                    <td class="py-3 pr-2 text-right text-slate-400 text-xs">
                                        <?= $log['timestamp'] ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

</body>
</html>