<?php
require_once 'models/Product.php';
require_once 'controllers/Controller.php';

class ProductController extends Controller
{
    private Product $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function store()
    {
        $this->model->create([
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'supplier_id' => $_POST['supplier_id'],
            'cost' => $_POST['cost'],
            'status' => 1
        ]);

        $this->notify('product.created', $_POST['name']);
        $this->redirect('index.php?page=produits');
    }

    public function update()
    {
        $this->model->update($_POST['id'], $_POST);
        $this->notify('product.updated', $_POST['id']);
        $this->redirect('index.php?page=produits');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->notify('product.deleted', $_GET['id']);
        $this->redirect('index.php?page=produits');
    }

    public function index()
    {
        return $this->model->all();
    }
}