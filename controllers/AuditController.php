<?php

class AuditController extends Controller
{
    private Audit $audit;

    public function __construct()
    {
        $this->audit = new Audit();
    }

    public function index()
    {
        $audits = $this->audit->allWithUsers();
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }

    public function recent()
    {
        $limit = $_GET['limit'] ?? 50;
        $audits = $this->audit->recent((int)$limit);
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }

    public function byUser(int $userId)
    {
        $audits = $this->audit->byUser($userId);
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }
}
