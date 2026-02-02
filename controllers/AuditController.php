<?php

class AuditController extends Controller
{
    use AuthTrait;

    private Audit $audit;

    public function __construct()
    {
        $this->audit = new Audit();
    }

    public function index()
    {
        $this->requireAccess('audit');
        $audits = $this->audit->allWithUsers();
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }

    public function recent()
    {
        $this->requireAccess('audit');
        $limit = $_GET['limit'] ?? 50;
        $audits = $this->audit->recent((int)$limit);
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }

    public function byUser(int $userId)
    {
        $this->requireAccess('audit');
        $audits = $this->audit->byUser($userId);
        $user = Auth::user();
        $this->render('audit/index', compact('audits', 'user'));
    }
}
