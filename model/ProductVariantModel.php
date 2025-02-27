<?php
require_once "Database.php";

class ProductVariantModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProductVariant()
    {
        $query = "SELECT * FROM products_variants";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductVariantsByProductId($productId)
    {
        $query = "SELECT pv.*, c.name as color_name, s.name as size_name
              FROM products_variants pv
              JOIN colors c ON pv.color_id = c.id
              JOIN sizes s ON pv.size_id = s.id
              WHERE pv.product_id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function checkDuplicateVariant($product_id, $color_id, $size_id, $exclude_id = null)
    {
        $sql = "SELECT COUNT(*) FROM products_variants WHERE product_id = ? AND color_id = ? AND size_id = ?";

        $params = [$product_id, $color_id, $size_id];

        if ($exclude_id) {
            $sql .= " AND id != ?";
            $params[] = $exclude_id;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }


    public function createVariant($product_id, $color_id, $size_id, $quantity, $price, $sku, $imagePath)
    {
        $sql = "INSERT INTO products_variants (product_id, color_id, size_id, quantity, price, sku, image) 
        VALUES (:product_id, :color_id, :size_id, :quantity, :price, :sku, :image)";


        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color_id', $color_id);
        $stmt->bindParam(':size_id', $size_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':image', $imagePath);

        return $stmt->execute();
    }


    public function updateVariant($id, $product_id, $color_id, $size_id, $quantity, $price, $sku, $image)
    {
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($image['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile;
            } else {
                $imagePath = null;
            }
        } else {
            $imagePath = null;
        }

        $stmt = $this->conn->prepare("UPDATE products_variants SET 
                                  product_id = :product_id, 
                                  color_id = :color_id, 
                                  size_id = :size_id, 
                                  quantity = :quantity, 
                                  price = :price, 
                                  sku = :sku, 
                                  image = :image 
                                  WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color_id', $color_id);
        $stmt->bindParam(':size_id', $size_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':image', $imagePath);
        return $stmt->execute();
    }

    public function getStock($sku)
    {
        $query = "SELECT quantity FROM products_variants WHERE sku = :sku";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['quantity'] ?? 0;
    }

    public function checkVariantExists($product_id, $color_id, $size_id)
    {
        $query = "SELECT * FROM products_variants WHERE product_id = :product_id AND color_id = :color_id AND size_id = :size_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color_id', $color_id);
        $stmt->bindParam(':size_id', $size_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteVariant($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products_variants WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getVariantById($id)
    {
        $sql = "SELECT * FROM products_variants WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function checkQuantity($variantId, $quantity)
    {
        $sql = "SELECT quantity FROM products_variants WHERE id = :variant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':variant_id', $variantId);
        $stmt->execute();

        $variant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($variant) {
            $currentQuantity = $variant['quantity'];

            if ($currentQuantity >= $quantity) {
                $newQuantity = $currentQuantity - $quantity;

                $updateSql = "UPDATE products_variants SET quantity = :new_quantity WHERE id = :variant_id";
                $updateStmt = $this->conn->prepare($updateSql);
                $updateStmt->bindParam(':new_quantity', $newQuantity);
                $updateStmt->bindParam(':variant_id', $variantId);
                $updateStmt->execute();

                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function increaseQuantity($variantId, $quantity)
    {
        $sql = "UPDATE products_variants 
            SET quantity = quantity + :quantity 
            WHERE id = :variant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':variant_id', $variantId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function decreaseStock($variantId, $quantity)
    {
        $sql = "UPDATE products_variants SET quantity = quantity - :quantity WHERE id = :variantId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':variantId', $variantId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        return $stmt->execute();
    }

    
}
