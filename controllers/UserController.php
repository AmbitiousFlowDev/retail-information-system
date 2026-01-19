<?php
require_once 'models/Utilisateur.php';
require_once 'utils/Auth.php';
require_once 'controllers/Controller.php';

class UserController extends Controller
{
    private Utilisateur $model;

    public function __construct()
    {
        $this->model = new Utilisateur();
    }

    public function login()
    {
        $username = $_POST['username'];
        if (Auth::attempt($username, $_POST['password'])) {
            $this->notify('user.login_success', $username);
            $this->redirect('index.php');
        }

        $this->notify('user.login_failed', $username);
        $this->redirect('login.php?error=1');
    }

    public function logout()
    {
        $user = Auth::user();
        Auth::logout();
        $this->notify('user.logout', $user);
        $this->redirect('login.php');
    }

    public function store()
    {
        $this->model->create($_POST);
        $this->notify('user.created', $_POST['username']);
        $this->redirect('index.php?page=users');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->notify('user.deleted', $_GET['id']);
        $this->redirect('index.php?page=users');
    }

    public function index()
    {
        return $this->model->all();
    }
}