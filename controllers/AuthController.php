<?php

require_once 'Controller.php';
require_once '../traits/AuthTrait.php';

class AuthController extends Controller
{
    use AuthTrait;
    public function login(array $data)
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if ($this->authenticate($username, $password)) {
            $this->notify('user.login', $this->currentUser());
            $this->redirect('dashboard.php');
        } else {
            $error = "Invalid username or password";
            $this->render('auth/login', compact('error'));
        }
    }
    public function logout()
    {
        $user = $this->currentUser();
        $this->logout();
        $this->notify('user.logout', $user);
        $this->redirect('login.php');
    }
}
