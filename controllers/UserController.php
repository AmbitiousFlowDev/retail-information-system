<?php

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $users = $this->user->all();
        $this->render('users/index', compact('users'));
    }

    public function show(int $id)
    {
        $user = $this->user->find($id);
        $this->render('users/show', compact('user'));
    }

    public function store(array $data)
    {
        $this->user->create($data);
        $this->notify('user.created', $data);
        $this->redirect('/users');
    }

    public function delete(int $id)
    {
        $this->user->delete($id);
        $this->notify('user.deleted', ['id' => $id]);
        $this->redirect('/users');
    }

    public function restore(int $id)
    {
        $this->user->restore($id);
        $this->notify('user.restored', ['id' => $id]);
        $this->redirect('/users');
    }

    public function login(string $username, string $password)
    {
        $user = $this->user->findByCredentials($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            $this->notify('user.login', $user);
            $this->redirect('/dashboard');
        }

        $this->redirect('/login?error=1');
    }
}
