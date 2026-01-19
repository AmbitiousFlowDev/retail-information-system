<?php
require_once 'models/Utilisateur.php';
require_once 'controllers/Controller.php';

class UserController extends Controller
{
    private Utilisateur $model;

    public function __construct()
    {
        $this->model = new Utilisateur();
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store()
    {
        $this->model->create($_POST);
        $this->redirect('index.php?page=users');
    }

    public function login()
    {
        $user = $this->model->login($_POST['username'], $_POST['password']);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            $this->redirect('index.php');
        }

        $this->redirect('login.php?error=1');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->redirect('index.php?page=users');
    }
}
