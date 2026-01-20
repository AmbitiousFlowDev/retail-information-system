<?php

class DashboardController extends Controller
{
    use AuthTrait;

    public function index()
    {
        $this->requireAuth();
        $this->render('dashboard/index');
    }
}

