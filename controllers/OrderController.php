<?php

class OrderController extends Controller
{
    use AuthTrait;

    private Order $order;
    private Client $client;
    private Employee $employee;

    public function __construct()
    {
        $this->order = new Order();
        $this->client = new Client();
        $this->employee = new Employee();
        $this->attach(new AuditObserver());
        $this->attach(new SyncLogObserver());
    }

    public function index()
    {
        $this->requireAccess('orders');
        $orders = $this->order->allWithDetails();
        $clients = $this->client->all();
        $employees = $this->employee->all();
        $user = Auth::user();
        $this->render('orders/index', compact('orders', 'clients', 'employees', 'user'));
    }

    public function create(array $data = [])
    {
        $this->requireAccess('orders');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $builder = new OrderBuilder();
            $orderId = $builder
                ->setOrderDate($data['order_date'] ?? date('Y-m-d'))
                ->setClientId((int) ($data['client_id'] ?? 0))
                ->setEmployeeId((int) ($data['employee_id'] ?? 0))
                ->build();

            $this->notify('order.created', [
                'order_id'  => $orderId,
                'client_id' => (int) ($data['client_id'] ?? 0),
            ]);
            $this->redirect('controller=Order&action=index');
        }
    }

    public function update(array $data = [])
    {
        $this->requireAccess('orders');
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
        $this->requireAccess('orders');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = (int) ($data['order_id'] ?? 0);
            $this->order->delete($orderId);
            $this->notify('order.deleted', ['order_id' => $orderId]);
            $this->redirect('controller=Order&action=index');
        }
    }

    public function exportPDF()
    {
        $this->requireAccess('orders');
        $orders = $this->order->allWithDetails();

        /** @var ReportInterface $report Adapter: FPDF wrapped by ReportInterface */
        $report = new FPDFReportAdapter();
        $report->addPage()
            ->setTitle('Orders List')
            ->setTableHeaders(['ID', 'Date', 'Client', 'Employee']);

        foreach ($orders as $order) {
            $report->addRow([
                $order['order_id'],
                date('Y-m-d', strtotime($order['order_date'])),
                $order['client_name'] ?? 'N/A',
                $order['employee_name'] ?? 'N/A',
            ]);
        }

        $report->setFooter('Generated on: ' . date('Y-m-d H:i:s'));
        $this->notify('order.exported', ['count' => count($orders), 'format' => 'PDF']);
        $report->outputToBrowser('orders_' . date('Y-m-d') . '.pdf');
    }
}