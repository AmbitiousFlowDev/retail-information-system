<?php
session_start();

// 1. Auto-load Controllers and Utilities
require_once 'utils/Auth.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/ClientController.php';
require_once 'controllers/StockController.php';
require_once 'controllers/OrderController.php';

// 2. Identify the request
$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? null;

// 3. Security Check: Protect all pages except login
if (!isset($_SESSION['user']) && $action !== 'login') {
    header('Location: login.php');
    exit;
}

// 4. Handle Actions (POST/Redirect logic)
// These usually perform a DB change and then redirect back to a page
if ($action) {
    switch ($action) {
        // Auth Actions
        case 'login':
            (new UserController())->login();
            break;
        case 'logout':
            (new UserController())->logout();
            break;

        // User CRUD
        case 'storeUser':
            (new UserController())->store();
            break;
        case 'deleteUser':
            (new UserController())->delete();
            break;

        // Product CRUD
        case 'storeProduct':
            (new ProductController())->store();
            break;
        case 'updateProduct':
            (new ProductController())->update();
            break;
        case 'deleteProduct':
            (new ProductController())->delete();
            break;

        // Client CRUD
        case 'storeClient':
            (new ClientController())->store();
            break;
        case 'updateClient':
            (new ClientController())->update();
            break;
        case 'deleteClient':
            (new ClientController())->delete();
            break;

        // Stock CRUD
        case 'storeStock':
            (new StockController())->store();
            break;

        // Order CRUD
        case 'storeOrder':
            (new OrderController())->store();
            break;
        case 'deleteOrder':
            (new OrderController())->delete();
            break;
    }
}

// 5. Handle Page Rendering (View logic)
// These calls trigger the render() method to show HTML
switch ($page) {
    case 'users':
        (new UserController())->index();
        break;

    case 'products':
        (new ProductController())->index();
        break;

    case 'clients':
        (new ClientController())->index();
        break;

    case 'stock':
        (new StockController())->index();
        break;

    case 'orders':
        (new OrderController())->index();
        break;

    case 'dashboard':
    default:
        // You can create a DashboardController later, 
        // for now, let's redirect to products
        (new ProductController())->index();
        break;
}