<?php 

namespace Layouts;

?>


<aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex">
    <div>
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="fa-solid fa-layer-group text-blue-600 text-xl mr-2"></i>
            <span class="font-bold text-lg tracking-tight text-slate-900">RIS System</span>
        </div>
        <nav class="p-4 space-y-1">
            <a href="index.php" class="flex items-center px-4 py-2.5 bg-blue-50 text-blue-600 rounded-md">
                <i class="fa-solid fa-gauge w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Dashboard</span>
            </a>
            <a href="../orders/index.php"
                class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-gray-50 hover:text-slate-900 rounded-md transition-colors">
                <i class="fa-solid fa-cart-shopping w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Orders</span>
            </a>

            <a href="../products/index.php"
                class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-gray-50 hover:text-slate-900 rounded-md transition-colors">
                <i class="fa-solid fa-box w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Products</span>
            </a>

            <a href="../clients/index.php"
                class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-gray-50 hover:text-slate-900 rounded-md transition-colors">
                <i class="fa-solid fa-users w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Clients</span>
            </a>

            <a href="../employees/index.php"
                class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-gray-50 hover:text-slate-900 rounded-md transition-colors">
                <i class="fa-solid fa-id-badge w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Employees</span>
            </a>
            <a href="../users/index.php"
                class="flex items-center px-4 py-2.5 text-slate-600 hover:bg-gray-50 hover:text-slate-900 rounded-md transition-colors">
                <i class="fa-solid fa-shield-halved w-5 opacity-75"></i>
                <span class="font-medium text-sm ml-2">Users</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-gray-100">
        <a href="../auth/logout.php"
            class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 rounded-md transition-colors">
            <i class="fa-solid fa-arrow-right-from-bracket w-5"></i>
            <span class="font-medium text-sm ml-2">Logout</span>
        </a>
    </div>
</aside>