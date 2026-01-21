<?php

class EmployeeController extends Controller
{
    private Employee $employee;
    private Role $role;

    public function __construct()
    {
        $this->employee = new Employee();
        $this->role = new Role();
        $this->attach(new AuditObserver());
    }

    public function index()
    {
        $employees = $this->employee->allWithRoles();
        $roles = $this->role->all();
        $user = Auth::user();
        $this->render('employees/index', compact('employees', 'roles', 'user'));
    }

    public function create(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeData = [
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'role_id' => (int)($data['role_id'] ?? 0)
            ];

            $this->employee->create($employeeData);
            $this->notify('employee.created', $employeeData);
            $this->redirect('controller=Employee&action=index');
        }
    }

    public function update(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeId = (int)($data['employee_id'] ?? 0);
            
            $employeeData = [
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'role_id' => (int)($data['role_id'] ?? 0)
            ];

            $this->employee->update($employeeId, $employeeData);
            $this->notify('employee.updated', array_merge(['employee_id' => $employeeId], $employeeData));
            $this->redirect('controller=Employee&action=index');
        }
    }

    public function delete(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeId = (int)($data['employee_id'] ?? 0);
            $this->employee->delete($employeeId);
            $this->notify('employee.deleted', ['employee_id' => $employeeId]);
            $this->redirect('controller=Employee&action=index');
        }
    }

    public function exportPDF()
    {
        $employees = $this->employee->allWithRoles();
        
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Employees List', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table Header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(99, 102, 241); // Indigo
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'First Name', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Last Name', 1, 0, 'C', true);
        $pdf->Cell(75, 10, 'Role', 1, 1, 'C', true);
        
        // Table Data
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(240, 240, 240);
        
        $fill = false;
        foreach ($employees as $employee) {
            $pdf->Cell(15, 8, $employee['employee_id'], 1, 0, 'C', $fill);
            $pdf->Cell(50, 8, $employee['first_name'], 1, 0, 'L', $fill);
            $pdf->Cell(50, 8, $employee['last_name'], 1, 0, 'L', $fill);
            $pdf->Cell(75, 8, $employee['role_code'] ?? 'N/A', 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'C');
        
        $this->notify('employee.exported', ['count' => count($employees), 'format' => 'PDF']);
        
        $pdf->Output('D', 'employees_' . date('Y-m-d') . '.pdf');
        exit;
    }
}
