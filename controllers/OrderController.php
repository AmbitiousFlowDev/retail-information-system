<?php

class OrderController extends Controller
{
    private Order $order;
    private Client $client;
    private Employee $employee;

    public function __construct()
    {
        $this->order = new Order();
        $this->client = new Client();
        $this->employee = new Employee();
        $this->attach(new AuditObserver());
    }

    public function index()
    {
        $orders = $this->order->allWithDetails();
        $clients = $this->client->all();
        $employees = $this->employee->all();
        $user = Auth::user();
        $this->render('orders/index', compact('orders', 'clients', 'employees', 'user'));
    }

    public function create(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $builder = new OrderBuilder();

            $order = $builder
                ->setOrderDate($data['order_date'] ?? date('Y-m-d'))
                ->setClientId((int) ($data['client_id'] ?? 0))
                ->setEmployeeId((int) ($data['employee_id'] ?? 0))
                ->build();

            $this->notify('order.created', $order);
            $this->redirect('controller=Order&action=index');
        }
    }

    public function update(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int) ($data['order_id'] ?? 0);

            $orderData = [
                'order_date' => $data['order_date'] ?? date('Y-m-d'),
                'client_id' => (int) ($data['client_id'] ?? 0),
                'employee_id' => (int) ($data['employee_id'] ?? 0)
            ];

            $this->order->update($orderId, $orderData);
            $this->notify('order.updated', array_merge(['order_id' => $orderId], $orderData));
            $this->redirect('controller=Order&action=index');
        }
    }

    public function delete(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int) ($data['order_id'] ?? 0);
            $this->order->delete($orderId);
            $this->notify('order.deleted', ['order_id' => $orderId]);
            $this->redirect('controller=Order&action=index');
        }
    }

    public function exportPDF()
    {
        $orders = $this->order->allWithDetails();

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Orders List', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(249, 115, 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Date', 1, 0, 'C', true);
        $pdf->Cell(65, 10, 'Client', 1, 0, 'C', true);
        $pdf->Cell(70, 10, 'Employee', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(240, 240, 240);

        $fill = false;
        foreach ($orders as $order) {
            $pdf->Cell(20, 8, $order['order_id'], 1, 0, 'C', $fill);
            $pdf->Cell(35, 8, date('Y-m-d', strtotime($order['order_date'])), 1, 0, 'C', $fill);
            $pdf->Cell(65, 8, substr($order['client_name'] ?? 'N/A', 0, 30), 1, 0, 'L', $fill);
            $pdf->Cell(70, 8, substr($order['employee_name'] ?? 'N/A', 0, 30), 1, 1, 'L', $fill);
            $fill = !$fill;
        }

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'C');

        $this->notify('order.exported', ['count' => count($orders), 'format' => 'PDF']);

        $pdf->Output('D', 'orders_' . date('Y-m-d') . '.pdf');
        exit;
    }
}