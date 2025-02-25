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

    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function register($name, $email, $password, $phone)
    {
        $hashedPassword = $this->handlePass($password);

        $query = "INSERT INTO users (name, email, password, phone) 
              VALUES (:name, :email, :password, :phone)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone', $phone);

        return $stmt->execute();
    }

    public function handlePass($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


    public function registerGoogle($name, $email, $password = null, $phone = null, $authProvider = 'local')
    {
        $query = "INSERT INTO users (name, email, password, phone, auth_provider) 
                  VALUES (:name, :email, :password, :phone, :auth_provider)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':auth_provider', $authProvider);
        return $stmt->execute();
    }
    public function savePasswordResetToken($email, $token)
    {
        $expiry = time() + 3600;
        $query = "INSERT INTO password_resets (email, token, expires_at) 
                  VALUES (:email, :token, :expiry)
                  ON DUPLICATE KEY UPDATE token = :token, expires_at = :expiry";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiry', $expiry);
        return $stmt->execute();
    }


    public function getUserByToken($token)
    {
        $query = "SELECT users.* FROM users 
              JOIN password_resets ON users.email = password_resets.email 
              WHERE password_resets.token = :token AND password_resets.expires_at > :current_time 
              LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':current_time', time());
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deletePasswordResetToken($email)
    {
        $query = "DELETE FROM password_resets WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function validateResetToken($token)
    {
        $query = "SELECT * FROM password_resets WHERE token = :token AND expiry > :current_time LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':current_time', time());
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resetPassword($email, $hashedPassword)
    {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }


    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getUserRoleByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ? $result['role'] : null;
    }
    public function checkEmailExists($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateRole($id, $role, $name, $phone)
    {
        $query = "UPDATE users SET role = :role, name = :name, phone = :phone WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function updateProfile($id, $name, $phone)
    {
        $query = "UPDATE users SET name = :name, phone = :phone WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
