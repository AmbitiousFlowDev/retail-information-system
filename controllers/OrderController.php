<?php
require_once 'models/Order.php';
require_once 'controllers/Controller.php';

class OrderController extends Controller
{
    private Order $model;

    public function __construct()
    {
        $this->model = new Order();
    }

    public function store()
    {
        $this->model->create([
            'sales_code' => $_POST['sales_code'],
            'client' => $_POST['client'],
            'amount' => $_POST['amount'],
            'remarks' => $_POST['remarks'] ?? null,
            'stock_ids' => $_POST['stock_ids'] ?? null
        ]);

        $this->notify('order.placed', $_POST['sales_code']);
        $this->redirect('index.php?page=commandes');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->notify('order.cancelled', $_GET['id']);
        $this->redirect('index.php?page=commandes');
    }

    public function index()
    {
        return $this->model->all();
    }
}