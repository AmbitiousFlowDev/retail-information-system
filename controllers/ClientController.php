<?php

require_once 'models/Client.php';
require_once 'controllers/Controller.php';

class ClientController extends Controller
{
    private Client $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store()
    {
        $this->model->create([
            'name'    => $_POST['name'],
            'address' => $_POST['address'],
            'cperson' => $_POST['cperson'] ?? null,
            'contact' => $_POST['contact'] ?? null,
            'status'  => 1
        ]);

        $this->redirect('index.php?page=clients');
    }

    public function update()
    {
        $this->model->update($_POST['id'], $_POST);
        $this->redirect('index.php?page=clients');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->redirect('index.php?page=clients');
    }
}
