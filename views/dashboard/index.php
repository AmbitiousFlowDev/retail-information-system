<?php
/** @var array $metrics */
/** @var array $recentOrders */
/** @var array $auditLogs */
/** @var object $user */
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
                    <span class="text-sm text-slate-600">
                        Welcome,
                        <strong><?= htmlspecialchars($user->username ?? 'Admin') ?></strong>
                    </span>
                    <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-auto p-6 lg:p-8">

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase">Total Revenue</p>
                            <h3 class="text-2xl font-bold mt-1">
                                $<?= number_format($metrics['revenue'], 2) ?>
                            </h3>
                        </div>
                        <div class="p-2 bg-green-50 text-green-600 rounded-md">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase">Total Orders</p>
                            <h3 class="text-2xl font-bold mt-1">
                                <?= number_format($metrics['orders_count']) ?>
                            </h3>
                        </div>
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-md">
                            <i class="fa-solid fa-shopping-cart"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase">Products</p>
                            <h3 class="text-2xl font-bold mt-1">
                                <?= number_format($metrics['products_count']) ?>
                            </h3>
                        </div>
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-md">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm flex justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase">Clients</p>
                            <h3 class="text-2xl font-bold mt-1">
                                <?= number_format($metrics['clients_count']) ?>
                            </h3>
                        </div>
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-md">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>

                </div>

                <!-- Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Recent Orders -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex justify-between mb-4">
                            <h3 class="font-semibold">Recent Orders</h3>
                            <a href="../orders/index.php" class="text-xs text-blue-600 hover:underline">View All</a>
                        </div>

                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 pl-2 text-left">ID</th>
                                    <th class="py-2 text-left">Status</th>
                                    <th class="py-2 pr-2 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">

                                <?php foreach ($recentOrders as $order): ?>
                                    <?php
                                    $badgeClass = match ($order['status']) {
                                        'Completed' => 'text-green-700 bg-green-50',
                                        'Pending' => 'text-yellow-700 bg-yellow-50',
                                        'Shipped' => 'text-blue-700 bg-blue-50',
                                        default => 'text-gray-700 bg-gray-50'
                                    };
                                    ?>
                                    <tr>
                                        <td class="py-3 pl-2">
                                            <div class="font-medium">#ORD-<?= $order['id'] ?></div>
                                            <div class="text-xs text-slate-400">
                                                <?= htmlspecialchars($order['client']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="px-2 py-0.5 rounded text-xs font-medium <?= $badgeClass ?>">
                                                <?= $order['status'] ?>
                                            </span>
                                        </td>
                                        <td class="py-3 pr-2 text-right font-medium">
                                            $<?= number_format($order['total'], 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Audit Logs -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                        <div class="flex justify-between mb-4">
                            <h3 class="font-semibold">System Audit Log</h3>
                            <span class="text-xs text-slate-400">Latest Activity</span>
                        </div>

                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 pl-2 text-left">Action</th>
                                    <th class="py-2 text-left">User</th>
                                    <th class="py-2 pr-2 text-right">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">

                                <?php foreach ($auditLogs as $log): ?>
                                    <tr>
                                        <td class="py-3 pl-2">
                                            <div class="font-medium"><?= $log['action'] ?></div>
                                            <div class="text-xs text-slate-400"><?= $log['entity'] ?? '' ?></div>
                                        </td>
                                        <td class="py-3">
                                            <span class="bg-slate-100 px-2 py-0.5 rounded text-xs">
                                                <?= $log['user'] ?>
                                            </span>
                                        </td>
                                        <td class="py-3 pr-2 text-right text-xs text-slate-400">
                                            <?= $log['created_at'] ?? '' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </main>
    </div>

</body>

</html>