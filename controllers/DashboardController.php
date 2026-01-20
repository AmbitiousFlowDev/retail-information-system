<?php


class DashboardController extends Controller
{
    use AuthTrait;

    public function index()
    {
        // 1. Security Check: Redirect to login if not authenticated
        $this->requireAuth();

        // 2. Load the view
        // You can pass stats data here later (e.g., total clients, sales)
        $this->render('dashboard');
    }
}

