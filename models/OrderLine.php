<?php

require_once 'Model.php';

final class OrderLine extends Model
{
    protected string $table = 'OrderLine';

    public function findByOrderIdAndProductId(int $orderId, int $productId)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE order_id = ? AND product_id = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$orderId, $productId]);
        return $stmt->fetch();
    }

    /**
     * Creates an order line using Decorator (Tax, Discount) and Strategy (discount type).
     * ProductComponent = base price; DiscountDecorator uses DiscountStrategy; TaxDecorator adds tax.
     */
    public function createWithPriceLogic(array $data)
    {
        $product = new ProductComponent($data);

        if ($data['apply_discount'] ?? false) {
            $strategy = $this->resolveDiscountStrategy($data);
            $product = new DiscountDecorator($product, $strategy);
        }

        $product = new TaxDecorator($product);

        $data['unit_price'] = $product->getPrice();

        unset($data['apply_discount'], $data['description'], $data['discount_strategy'], $data['discount_percent'], $data['discount_amount']);

        $columns = array_keys($data);
        $placeholders = implode(", ", array_map(fn($col) => ":$col", $columns));
        $sql = "INSERT INTO {$this->table} (" . implode(", ", $columns) . ") VALUES ($placeholders)";
        
        return $this->db->prepare($sql)->execute($data);
    }

    private function resolveDiscountStrategy(array $data): DiscountStrategy
    {
        $type = $data['discount_strategy'] ?? 'percentage';
        if ($type === 'fixed' && isset($data['discount_amount'])) {
            return new FixedAmountDiscountStrategy((float) $data['discount_amount']);
        }
        $percent = (float) ($data['discount_percent'] ?? 10);
        return new PercentageDiscountStrategy($percent);
    }

    public function deleteByOrderIdAndProductId(int $orderId, int $productId)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET deleted_at = datetime('now')
            WHERE order_id = ? AND product_id = ?
        ");
        return $stmt->execute([$orderId, $productId]);
    }

    public function updateByOrderIdAndProductId(int $orderId, int $productId, array $data)
    {
        $columns = array_keys($data);
        $assignments = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = "
            UPDATE {$this->table}
            SET $assignments
            WHERE order_id = :order_id AND product_id = :product_id
              AND deleted_at IS NULL
        ";

        $stmt = $this->db->prepare($sql);
        $data['order_id'] = $orderId;
        $data['product_id'] = $productId;

        return $stmt->execute($data);
    }
}