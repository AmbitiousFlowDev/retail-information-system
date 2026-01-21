<?php

class ClientController extends Controller
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->attach(new AuditObserver());
    }

    public function index()
    {
        $clients = $this->client->all();
        $user = Auth::user();
        $this->render('clients/index', compact('clients', 'user'));
    }

    public function create(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientData = [
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'address' => $data['address'] ?? '',
                'city' => $data['city'] ?? ''
            ];

            $this->client->create($clientData);
            $this->notify('client.created', $clientData);
            $this->redirect('controller=Client&action=index');
        }
    }

    public function update(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)($data['client_id'] ?? 0);
            
            $clientData = [
                'first_name' => $data['first_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'address' => $data['address'] ?? '',
                'city' => $data['city'] ?? ''
            ];

            $this->client->update($clientId, $clientData);
            $this->notify('client.updated', array_merge(['client_id' => $clientId], $clientData));
            $this->redirect('controller=Client&action=index');
        }
    }

    public function delete(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)($data['client_id'] ?? 0);
            $this->client->delete($clientId);
            $this->notify('client.deleted', ['client_id' => $clientId]);
            $this->redirect('controller=Client&action=index');
        }
    }

    public function exportPDF()
    {
        $clients = $this->client->all();
        
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Clients List', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table Header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(59, 130, 246); // Blue
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'First Name', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Last Name', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Address', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'City', 1, 1, 'C', true);
        
        // Table Data
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(240, 240, 240);
        
        $fill = false;
        foreach ($clients as $client) {
            $pdf->Cell(15, 8, $client['client_id'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 8, $client['first_name'], 1, 0, 'L', $fill);
            $pdf->Cell(40, 8, $client['last_name'], 1, 0, 'L', $fill);
            $pdf->Cell(50, 8, substr($client['address'] ?? '', 0, 25), 1, 0, 'L', $fill);
            $pdf->Cell(45, 8, $client['city'], 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        
        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'C');
        
        $this->notify('client.exported', ['count' => count($clients), 'format' => 'PDF']);
        
        $pdf->Output('D', 'clients_' . date('Y-m-d') . '.pdf');
        exit;
    }
}
