<?php
require_once "Database.php";

class UserModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password, $phone, $address, $role = 'user')
    {
        $passwordHash = $this->hashPassword($password); 

        $query = "INSERT INTO users (name, email, password, phone, address, role) 
                  VALUES (:name, :email, :password, :phone, :address, :role)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function updateUser($id, $data)
    {
        $validRoles = ['user', 'admin'];
        if (!isset($data['role']) || !in_array($data['role'], $validRoles)) {
            return false;
        }
        $query = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);

        return $stmt->execute();
    }
    public function getLogin($email)
    {
        $query = "SELECT * FROM users WHERE email = :email ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
