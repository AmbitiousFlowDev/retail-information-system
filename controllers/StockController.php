<?php
require_once 'models/Stock.php';
require_once 'controllers/Controller.php';

class StockController extends Controller
{
    private Stock $model;

    public function __construct()
    {
        $this->model = new Stock();
    }

    public function store()
    {
        $this->model->create([
            'item_id' => $_POST['item_id'],
            'quantity' => $_POST['quantity'],
            'unit' => $_POST['unit'] ?? 'pcs',
            'price' => $_POST['price'],
            'type' => $_POST['type']
        ]);

        $this->notify('stock.updated', $_POST);
        $this->redirect('index.php?page=stock');
    }

    public function index()
    {
        return $this->model->all();
    }
}