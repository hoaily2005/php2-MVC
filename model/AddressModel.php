<?php
require_once "Database.php";

class AddressModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllAddress($user_id)
    {
        $query = "SELECT * FROM address WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create($user_id, $full_name, $phone, $address)
    {
        $query = "INSERT INTO address (user_id, full_name, phone, address) VALUES (:user_id, :full_name, :phone, :address)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    public function update($id, $full_name, $phone, $address)
    {
        $query = "UPDATE address SET full_name = :full_name, phone = :phone, address = :address WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
