<?php
require_once "Database.php";

class OrderModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getOrders()
    {
        $query = "SELECT o.id, o.total_price, o.payment_status, o.payment_method, o.shipping_address, o.created_at, o.updated_at, 
                         c.name AS product_name, c.image AS product_image, c.sku, p.name AS size_name, q.name AS color_name
                  FROM orders o
                  INNER JOIN carts c ON o.cart_id = c.id
                  INNER JOIN products_variants pv ON c.sku = pv.sku
                  INNER JOIN products p ON pv.product_id = p.id
                  INNER JOIN sizes s ON pv.size_id = s.id
                  INNER JOIN colors q ON pv.color_id = q.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($user_id, $payment_method, $payment_status, $shipping_address, $total_price)
    {
        $query = "INSERT INTO orders (user_id, payment_method, payment_status, shipping_address, total_price)
                  VALUES (:user_id, :payment_method, :payment_status, :shipping_address, :total_price)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':shipping_address', $shipping_address);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR); 

        return $stmt->execute();
    }

    
    public function addOrderItem($order_id, $sku, $price, $quantity)
    {
        
        $query = "SELECT id FROM products_variants WHERE sku = :sku";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

       
        if ($result) {
            $product_variant_id = $result['id'];  

            $query = "INSERT INTO order_items (order_id, product_variant_id, price, quantity)
                      VALUES (:order_id, :product_variant_id, :price, :quantity)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_variant_id', $product_variant_id);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);

            return $stmt->execute();
        } else {
            return false;
        }
    }


    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function deleteOrder($id)
    {
        $query = "DELETE FROM orders WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
