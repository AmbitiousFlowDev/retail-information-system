<?php
require_once 'Controller.php';
require_once 'models/Product.php';

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {
        $products = $this->product->all();
        $this->render('products/index', compact('products'));
    }

    public function updatePrice(int $id, float $price)
    {
        $this->product->updatePrice($id, $price);
        $this->notify('product.price_updated', [
            'product_id' => $id,
            'price' => $price
        ]);
        $this->redirect('/products');
    }

    public function delete(int $id)
    {
        $this->product->delete($id);
        $this->notify('product.deleted', ['id' => $id]);
        $this->redirect('/products');
    }
}
