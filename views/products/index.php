<?php
/** @var array $products */
/** @var object $user */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .table-row-hover:hover td {
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="bg-gray-100 text-slate-800 font-sans antialiased">

    <div class="flex h-screen w-full">

        <?php include_once("views/layout/sidebar.php") ?>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-100">

            <!-- Header -->
            <header
                class="h-16 bg-white border-b border-gray-200 flex justify-between items-center px-6 shadow-sm z-10">
                <h1 class="text-xl font-semibold text-slate-800">Products</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600"><?= htmlspecialchars($user->username ?? 'Admin') ?></span>
                    <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-auto p-6 lg:p-8">

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">

                        <!-- Add Product Button -->
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm flex items-center gap-2 text-sm font-medium transition-colors w-full md:w-auto justify-center">
                            <i class="fa-solid fa-plus"></i> Add Product
                        </button>

                        <!-- Search -->
                        <div class="relative w-full md:max-w-md">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" placeholder="Search product..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-blue-500 text-sm">
                        </div>

                    </div>

                    <!-- Products Table -->
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold text-slate-600">ID</th>
                                <th class="px-6 py-3 font-semibold text-slate-600">Name</th>
                                <th class="px-6 py-3 font-semibold text-slate-600">Category</th>
                                <th class="px-6 py-3 font-semibold text-slate-600 text-center">Stock</th>
                                <th class="px-6 py-3 font-semibold text-slate-600 text-right">Price</th>
                                <th class="px-6 py-3 font-semibold text-slate-600">Status</th>
                                <th class="px-6 py-3 font-semibold text-slate-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($products as $product): ?>
                                <?php
                                // Determine status dynamically
                                $stock = (int) $product['stock_quantity'];
                                $status = $stock === 0 ? 'Out of Stock' : ($stock < 10 ? 'Low Stock' : 'In Stock');
                                $badgeClass = match ($status) {
                                    'In Stock' => 'bg-green-100 text-green-800',
                                    'Low Stock' => 'bg-orange-100 text-orange-800',
                                    'Out of Stock' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-900"><?= $product['product_id'] ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($product['category']) ?></td>
                                    <td class="px-6 py-4 text-slate-900 font-medium text-center"><?= $stock ?></td>
                                    <td class="px-6 py-4 text-slate-900 font-medium text-right">
                                        <?= number_format($product['unit_price'], 2, ',', ' ') ?> €
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>">
                                            <?= $status ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs flex items-center gap-1 transition-colors">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <button
                                                class="bg-red-600 hover:bg-red-700 text-white p-1.5 px-2 rounded text-xs transition-colors">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>