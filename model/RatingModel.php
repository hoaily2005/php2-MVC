<?php

require_once 'Database.php';

class RatingModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Kiểm tra xem người dùng đã đánh giá sản phẩm chưa
    public function hasRated($productId, $userId)
    {
        $query = "SELECT COUNT(*) FROM ratings WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function addRating($productId, $userId, $rating, $comment = null)
    {
        $query = "INSERT INTO ratings (product_id, user_id, rating, comment) 
                  VALUES (:product_id, :user_id, :rating, :comment)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getRatingsByProduct($productId)
    {
        $query = "SELECT r.*, u.name AS name 
              FROM ratings r 
              LEFT JOIN users u ON r.user_id = u.id 
              WHERE r.product_id = :product_id 
              ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result !== false ? $result : [];
    }


    public function getAverageRating($productId)
    {
        $query = "SELECT AVG(rating) as average 
                  FROM ratings 
                  WHERE product_id = :product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['average'] !== NULL ? round($result['average'], 1) : 0;
    }
}
