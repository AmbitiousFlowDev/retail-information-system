<?php

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
        $this->attach(new AuditObserver());
    }

    public function index()
    {
        $products = $this->product->all();
        $user = Auth::user();
        $this->render('products/index', compact('products', 'user'));
    }

    public function create(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = [
                'name' => $data['name'] ?? '',
                'category' => $data['category'] ?? '',
                'unit_price' => $data['unit_price'] ?? 0,
                'stock_quantity' => $data['stock_quantity'] ?? 0
            ];

            $this->product->create($productData);
            $this->notify('product.created', $productData);
            $this->redirect('controller=Product&action=index');
        }
    }

    public function update(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($data['product_id'] ?? 0);
            
            $productData = [
                'name' => $data['name'] ?? '',
                'category' => $data['category'] ?? '',
                'unit_price' => $data['unit_price'] ?? 0,
                'stock_quantity' => $data['stock_quantity'] ?? 0
            ];

            $this->product->update($productId, $productData);
            $this->notify('product.updated', array_merge(['product_id' => $productId], $productData));
            $this->redirect('controller=Product&action=index');
        }
    }

    public function updatePrice(int $id, float $price)
    {
        $this->product->updatePrice($id, $price);
        $this->notify('product.price_updated', [
            'product_id' => $id,
            'price' => $price
        ]);
        $this->redirect('controller=Product&action=index');
    }

    public function delete(array $data = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($data['product_id'] ?? 0);
            $this->product->delete($productId);
            $this->notify('product.deleted', ['product_id' => $productId]);
            $this->redirect('controller=Product&action=index');
        }
    }

    public function exportPDF()
    {
        $products = $this->product->all();
        
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Products List', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table Header
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(37, 99, 235); // Blue
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'Name', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Category', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Price (EUR)', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Stock', 1, 1, 'C', true);
        
        // Table Data
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(240, 240, 240);
        
        $fill = false;
        foreach ($products as $product) {
            $pdf->Cell(15, 8, $product['product_id'], 1, 0, 'C', $fill);
            $pdf->Cell(60, 8, substr($product['name'], 0, 28), 1, 0, 'L', $fill);
            $pdf->Cell(50, 8, substr($product['category'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(30, 8, number_format($product['unit_price'], 2), 1, 0, 'R', $fill);
            $pdf->Cell(35, 8, $product['stock_quantity'], 1, 1, 'C', $fill);
            $fill = !$fill;
        }
        
        // Footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'C');
        
        $this->notify('product.exported', ['count' => count($products), 'format' => 'PDF']);
        
        $pdf->Output('D', 'products_' . date('Y-m-d') . '.pdf');
        exit;
    }
}
