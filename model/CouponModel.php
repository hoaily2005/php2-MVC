<?php

require_once 'Database.php';

class CouponModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createCoupon($code, $discount, $discount_type, $expiry_date, $usage_limit)
    {
        $query = "INSERT INTO coupons (code, discount, discount_type, expiry_date, is_active, used_count, usage_limit) 
                  VALUES (:code, :discount, :discount_type, :expiry_date, 1, 0, :usage_limit)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
        $stmt->bindParam(':discount_type', $discount_type, PDO::PARAM_STR);
        $stmt->bindParam(':expiry_date', $expiry_date, PDO::PARAM_STR);
        $stmt->bindParam(':usage_limit', $usage_limit, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false; 
            }
            throw $e;  
        }
    }

    public function updateCoupon($id, $code, $discount, $discount_type, $expiry_date, $usage_limit)
    {
        $query = "UPDATE coupons 
                  SET code = :code, discount = :discount, discount_type = :discount_type, expiry_date = :expiry_date, usage_limit = :usage_limit 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':discount', $discount, PDO::PARAM_INT);
        $stmt->bindParam(':discount_type', $discount_type, PDO::PARAM_STR);
        $stmt->bindParam(':expiry_date', $expiry_date, PDO::PARAM_STR);
        $stmt->bindParam(':usage_limit', $usage_limit, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCouponById($id)
    {
        $query = "SELECT * FROM coupons WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCoupon($code)
    {
        $query = "SELECT * FROM coupons WHERE code = :code AND expiry_date > NOW() AND is_active = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCoupons()
    {
        $query = "SELECT * FROM coupons ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCoupon($id)
    {
        $query = "DELETE FROM coupons WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
