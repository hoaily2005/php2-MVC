<?php
require_once "Database.php";

class CartModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCart($user_id, $session_id)
    {
        if (!empty($user_id)) {
            $condition = "carts.user_id = :user_id";
        } else {
            $condition = "carts.cart_session = :cart_session";
        }

        $query = "SELECT carts.*, 
                     products.name, 
                     products.image,
                    --  products.id,
                     sizes.name AS size_name, 
                     colors.name AS color_name
              FROM carts
              INNER JOIN products_variants ON carts.sku = products_variants.sku
              INNER JOIN products ON products_variants.product_id = products.id
              INNER JOIN sizes ON products_variants.size_id = sizes.id
              INNER JOIN colors ON products_variants.color_id = colors.id
              WHERE $condition";

        $stmt = $this->conn->prepare($query);

        if (!empty($user_id)) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $session_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addCart($user_id, $cart_session, $sku, $quantity, $price)
    {
        $query = "INSERT INTO carts (user_id, cart_session, sku, quantity, price) VALUES (:user_id, :cart_session, :sku, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':cart_session', $cart_session);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    //Trường hợp thêm sp vào giỏ hàng khi chưang login và khi login thì hiển thị sản phẩm đã thêm lúc người dùng chưa login
    public function mergeCart($user_id, $session_id)
    {
        $query = "SELECT * FROM carts WHERE cart_session = :cart_session AND user_id IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_session', $session_id);
        $stmt->execute();
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($cart_items)) {
            $updateQuery = "UPDATE carts SET user_id = :user_id, cart_session = NULL WHERE cart_session = :cart_session";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':user_id', $user_id);
            $updateStmt->bindParam(':cart_session', $session_id);
            $updateStmt->execute();
        }
    }
    public function updateCart($user_id, $cart_session, $cart_id, $quantity)
    {
        $query = "UPDATE carts SET quantity = :quantity WHERE user_id = :user_id AND cart_session = :cart_session AND id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':cart_session', $cart_session);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }




    public function deleteCart($user_id, $session_id, $cart_id)
    {
        $condition = !empty($user_id) ? "user_id = :user_id" : "cart_session = :cart_session";

        $query = "DELETE FROM carts WHERE $condition AND id = :cart_id";
        $stmt = $this->conn->prepare($query);

        if (!empty($user_id)) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $session_id);
        }

        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteAll($user_id = null, $session_id = null)
    {
        $query = "DELETE FROM carts WHERE user_id = :user_id OR cart_session = :cart_session";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':cart_session', $session_id);
        return $stmt->execute();
    }


    public function clearCart($user_id)
    {
        $query = "DELETE FROM carts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}
