<?php

class ProductController extends Controller
{
    use AuthTrait;

    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
        $this->attach(new AuditObserver());
    }

    public function index()
    {
        $this->requireAccess('products');
        $products = $this->product->all();
        $user = Auth::user();
        $this->render('products/index', compact('products', 'user'));
    }

    public function create(array $data = [])
    {
        $this->requireAccess('products');
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
        $this->requireAccess('products');
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
        $this->requireAccess('products');
        $this->product->updatePrice($id, $price);
        $this->notify('product.price_updated', [
            'product_id' => $id,
            'price' => $price
        ]);
        $this->redirect('controller=Product&action=index');
    }

    public function delete(array $data = [])
    {
        $this->requireAccess('products');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($data['product_id'] ?? 0);
            $this->product->delete($productId);
            $this->notify('product.deleted', ['product_id' => $productId]);
            $this->redirect('controller=Product&action=index');
        }
    }

    public function exportPDF()
    {
        $this->requireAccess('products');
        $products = $this->product->all();

        /** @var ReportInterface $report Adapter: FPDF wrapped by ReportInterface */
        $report = new FPDFReportAdapter();
        $report->addPage()
            ->setTitle('Products List')
            ->setTableHeaders(['ID', 'Name', 'Category', 'Price (EUR)', 'Stock']);

        foreach ($products as $product) {
            $report->addRow([
                $product['product_id'],
                $product['name'],
                $product['category'],
                number_format($product['unit_price'], 2),
                $product['stock_quantity'],
            ]);
        }

        $report->setFooter('Generated on: ' . date('Y-m-d H:i:s'));
        $this->notify('product.exported', ['count' => count($products), 'format' => 'PDF']);
        $report->outputToBrowser('products_' . date('Y-m-d') . '.pdf');
    }
}
