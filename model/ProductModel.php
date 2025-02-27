<?php
require_once "Database.php";

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $description, $price, $image, $quantity, $category_id)
    {
        $sql = "INSERT INTO products (name, description, price, image, quantity, category_id) VALUES (:name, :description, :price, :image, :quantity, :category_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':category_id', $category_id);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function updateProduct($id, $name, $description, $price, $image, $quantity, $category_id)
    {
        $query = "UPDATE products SET name = :name, description = :description, price = :price, image = :image, quantity = :quantity, category_id = :category_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':category_id', $category_id);
        return $stmt->execute();
    }
    //lấy danh mụcmục
    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //lấy sản phẩm theo danh mục
    public function getProductsByCategory($categoryId)
    {
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteProductImage($productId)
    {
        $query = "DELETE FROM product_images WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function addProductImage($productId, $imageUrl, $isMain)
    {
        $query = "INSERT INTO product_images (product_id, image_url, is_main) VALUES (:product_id, :image_url, :is_main)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':image_url', $imageUrl);
        $stmt->bindParam(':is_main', $isMain);
        return $stmt->execute();
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getProductsFitter($categoryId, $priceRange, $sort)
    {
        $query = "SELECT * FROM products WHERE 1";

        if ($categoryId) {
            $query .= " AND category_id = :category_id";
        }

        if ($priceRange) {
            $priceParts = explode('-', $priceRange);
            if (count($priceParts) == 2) {
                $query .= " AND price BETWEEN :price_min AND :price_max";
            } else {
                $query .= " AND price >= :price_min";
            }
        }

        switch ($sort) {
            case 'name_asc':
                $query .= " ORDER BY name ASC";
                break;
            case 'name_desc':
                $query .= " ORDER BY name DESC";
                break;
            case 'price_asc':
                $query .= " ORDER BY price ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY price DESC";
                break;
            case 'newest':
                $query .= " ORDER BY created_at DESC";
                break;
            case 'oldest':
                $query .= " ORDER BY created_at ASC";
                break;
            default:
                $query .= " ORDER BY created_at DESC";
                break;
        }

        $stmt = $this->conn->prepare($query);

        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId);
        }

        if ($priceRange) {
            $priceParts = explode('-', $priceRange);
            if (count($priceParts) == 2) {
                $stmt->bindParam(':price_min', $priceParts[0]);
                $stmt->bindParam(':price_max', $priceParts[1]);
            } else {
                $stmt->bindParam(':price_min', $priceParts[0]);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSuggestions($query)
    {
        $query = "%" . $query . "%";
        $sql = "SELECT * FROM products WHERE name LIKE :query LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':query', $query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestSellingProducts()
    {
        $query = "SELECT p.name, SUM(oi.quantity) AS total_sold, SUM(oi.total_price) AS revenue
              FROM order_items oi
              INNER JOIN products_variants pv ON oi.product_variant_id = pv.id
              INNER JOIN products p ON pv.product_id = p.id
              GROUP BY p.name
              ORDER BY total_sold DESC
              LIMIT 3"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLeastSellingProducts()
    {
        $query = "SELECT p.name, SUM(oi.quantity) AS total_sold, SUM(oi.total_price) AS revenue
              FROM order_items oi
              INNER JOIN products_variants pv ON oi.product_variant_id = pv.id
              INNER JOIN products p ON pv.product_id = p.id
              GROUP BY p.name
              ORDER BY total_sold ASC
              LIMIT 3"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
