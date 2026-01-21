<?php

final class Product extends Model
{
    protected string $table = 'Product';
    protected string $primaryKey = 'product_id';

    public function updatePrice(int $id, float $price)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET unit_price = ?
            WHERE {$this->primaryKey} = ? AND deleted_at IS NULL
        ");

        return $stmt->execute([$price, $id]);
    }

    public function update(int $id, array $data)
    {
        $columns = array_keys($data);
        $assignments = implode(", ", array_map(fn($col) => "$col = :$col", $columns));

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s = :id AND deleted_at IS NULL",
            $this->table,
            $assignments,
            $this->primaryKey
        );

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }
}
