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

    public function getOrders($user_id)
    {
        $query = "SELECT oi.id, oi.price, oi.quantity, oi.total_price, 
                     pv.sku, p.name AS product_name, s.name AS size_name, c.name AS color_name, 
                     o.payment_status, o.payment_method, o.shipping_address, o.created_at, o.updated_at,
                     p.image AS product_image  
              FROM order_items oi
              INNER JOIN products_variants pv ON oi.product_variant_id = pv.id
              INNER JOIN products p ON pv.product_id = p.id
              INNER JOIN sizes s ON pv.size_id = s.id
              INNER JOIN colors c ON pv.color_id = c.id
              INNER JOIN orders o ON oi.order_id = o.id
              WHERE o.user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders()
    {
        $query = "SELECT o.id AS order_id, o.payment_status, o.payment_method, o.shipping_address, o.total_price, o.created_at, o.updated_at, 
                     oi.id AS order_item_id, oi.price, oi.quantity, oi.total_price AS item_total_price,
                     pv.sku, p.name AS product_name, s.name AS size_name, c.name AS color_name, 
                     p.image AS product_image
              FROM orders o
              INNER JOIN order_items oi ON o.id = oi.order_id
              INNER JOIN products_variants pv ON oi.product_variant_id = pv.id
              INNER JOIN products p ON pv.product_id = p.id
              INNER JOIN sizes s ON pv.size_id = s.id
              INNER JOIN colors c ON pv.color_id = c.id
              ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOrderById($id)
    {
        $query = "SELECT oi.id, oi.price, oi.quantity, oi.total_price, 
                     pv.sku, p.name AS product_name, s.name AS size_name, c.name AS color_name, 
                     o.payment_status, o.payment_method, o.shipping_address, o.created_at, o.updated_at,
                     p.image AS product_image
              FROM order_items oi
              INNER JOIN products_variants pv ON oi.product_variant_id = pv.id
              INNER JOIN products p ON pv.product_id = p.id
              INNER JOIN sizes s ON pv.size_id = s.id
              INNER JOIN colors c ON pv.color_id = c.id
              INNER JOIN orders o ON oi.order_id = o.id
              WHERE oi.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($user_id, $payment_method, $payment_status, $shipping_address, $total_price, $email, $phone, $name)
    {
        $query = "INSERT INTO orders (user_id, payment_method, payment_status, shipping_address, total_price, email, phone, name)
                  VALUES (:user_id, :payment_method, :payment_status, :shipping_address, :total_price, :email, :phone, :name)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':shipping_address', $shipping_address);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':name', $name);

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

    public function delete($id)
    {
        $query = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getUserEmail($order_id)
    {
        $query = "SELECT u.email FROM users u
              INNER JOIN orders o ON o.user_id = u.id
              WHERE o.id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['email'] : null;
    }

    public function updateOrderStatus($order_id, $status)
    {
        $sql = "UPDATE orders SET payment_status = :status WHERE id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $order_id);
        return $stmt->execute();
    }

    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.product_variant_id, oi.quantity, oi.price, pv.sku, pv.size_id, pv.color_id
            FROM order_items oi
            LEFT JOIN products_variants pv ON oi.product_variant_id = pv.id
            WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orderItems;
    }

    // Thống kê đơn hàng
    public function getSuccessfulOrders()
    {
        $query = "SELECT COUNT(o.id) AS total_successful_orders, SUM(o.total_price) AS total_revenue
              FROM orders o
              WHERE o.payment_status = 'completed'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFailedOrders()
    {
        $query = "SELECT COUNT(o.id) AS total_failed_orders, SUM(o.total_price) AS total_revenue
              FROM orders o
              WHERE o.payment_status = 'failed'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // chart doanh thu
    public function getWeeklyRevenue()
    {
        $query = "SELECT WEEK(o.created_at) AS week, SUM(o.total_price) AS total_revenue
              FROM orders o
              WHERE YEAR(o.created_at) = YEAR(CURRENT_DATE)
              GROUP BY WEEK(o.created_at)
              ORDER BY week";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEarningsForYear()
    {
        $query = "SELECT MONTH(o.created_at) AS month, SUM(o.total_price) AS total_revenue
              FROM orders o
              WHERE YEAR(o.created_at) = YEAR(CURRENT_DATE)
              GROUP BY MONTH(o.created_at)
              ORDER BY month";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
