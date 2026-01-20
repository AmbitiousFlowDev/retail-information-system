<?php

class EmployeeController extends Controller
{
    private Employee $employee;

    public function __construct()
    {
        $this->employee = new Employee();
    }

    public function index()
    {
        $employees = $this->employee->all();
        $this->render('employees/index', compact('employees'));
    }

    public function delete(int $id)
    {
        $this->employee->delete($id);
        $this->notify('employee.deleted', ['id' => $id]);
        $this->redirect('/employees');
    }
}
