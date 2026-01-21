<?php


class AuthController extends Controller
{
    use AuthTrait;

    public function __construct()
    {
        // Attach AuditObserver to track authentication events
        $this->attach(new AuditObserver());
    }

    public function login(array $data)
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if ($this->authenticate($username, $password)) {
            $this->notify('user.login', $this->currentUser());
            $this->redirect('controller=Dashboard&action=index');
        } else {
            $error = "Invalid username or password";
            $this->render('auth/login', compact('error'));
        }
    }

    public function loginForm()
    {
        if ($this->checkAuth()) {
            $this->redirect('controller=Dashboard&action=index');
        }

        $this->render('auth/login');
    }

    public function logout()
    {
        $user = $this->currentUser();
        
        // Notify before logout to ensure user data is still in session
        $this->notify('user.logout', $user);
        
        // Now perform the actual logout
        unset($_SESSION['user']);
        session_destroy();
        
        $this->redirect('controller=Auth&action=loginForm');
    }
}
