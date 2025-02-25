<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App | Đồ Thể Thao</title>
    <!-- Bootstrap CSS -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/vi/thumb/1/1d/Manchester_City_FC_logo.svg/615px-Manchester_City_FC_logo.svg.png?20171110155930" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/view/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- Topbar -->
    <div class="topbar bg-dark text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="topbar-left">
                <a href="#" target="_blank" class="text-white">lyxuanhoai18@gmail.com</a>
                <a href="#" class="text-white ms-3" title="Trở thành Người bán Shopee">0935.975.736</a>
            </div>
            <div class="topbar-right">
                <a href="https://facebook.com/hoaily19.vn" target="_blank" class="text-white me-3" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://instagram.com/hoaily0602" target="_blank" class="text-white" title="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <br>
    <br>
        <!-- Header -->
    <header class="bg-white py-3 shadow-sm">
        <div class="container">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <a href="/">
                        <img src="uploads/products/logoshop.png" alt="Logo" width="120" class="logo">
                    </a>
                </h1>

                <!-- Menu Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">TRANG CHỦ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/products">SẢN PHẨM</a>
                            </li>
                            <?php if (isset($_SESSION['users']) && $_SESSION['users']['role'] === 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin">ADMIN</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>

                <!-- Search Bar -->
                <form class="d-flex me-3 search-bar" action="#" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <!-- User & Cart Section -->
                <div class="d-flex align-items-center user-section">
                    <a href="/carts" class="btn btn-outline-primary me-3 cart-btn">
                        <i class="fas fa-shopping-cart"></i> <span class="cart-count">0</span>
                    </a>
                    <?php if (!isset($_SESSION['users'])): ?>
                        <a href="/register" class="btn btn-primary me-2">Đăng Kí</a>
                        <a href="/login" class="btn btn-primary">Đăng Nhập</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?= $_SESSION['users']['name'] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="/profile/<?= $_SESSION['users']['id'] ?>">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="/orders">Đơn hàng</a></li>
                                <li><a class="dropdown-item" href="/tracking">Tra cứu đơn hàng</a></li>
                                <li><a class="dropdown-item" href="/logout">Đăng Xuất</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="main" style="min-height: calc(100vh - 100px);">
        <div class="container mt-3">
        @yield('content')
        </div>
    </main>
    <br>
    <br>
    <br>

    <!-- Footer -->
    <footer class="bg-info text-white py-5">
        <div class="container">
            <div class="row">
                <!-- Column 1: About -->
                <div class="col-md-4 mb-4">
                    <h5>About Us</h5>
                    <p class="text-white-50">TheThao is your go-to source for the latest sports news, updates, and insights. Stay connected with us for all things sports!</p>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">News</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Events</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Social Media -->
                <div class="col-md-4 mb-4">
                    <h5>Follow Us</h5>
                    <ul class="list-unstyled d-flex gap-3">
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-facebook fa-2x"></i></a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-twitter fa-2x"></i></a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-instagram fa-2x"></i></a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fab fa-youtube fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-4 pt-3 border-top border-white-50">
                <p class="mb-0 text-white-50">&copy; <?= date("Y") ?> TheThao. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
    /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

header {
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 15px 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

/* Logo */
.logo {
    transition: transform 0.3s ease;
}

.logo:hover {
    transform: scale(1.05);
}

/* Navbar Styles */
.navbar {
    padding: 0;
}

.navbar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin: 0 15px;
}

.nav-link {
    color: #333;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    padding: 10px 15px;
    transition: color 0.3s ease, background-color 0.3s ease;
}

.nav-link:hover, .nav-link.active {
    color: #EE4D2D;
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 5px;
}

.navbar-toggler {
    border: none;
    background-color: transparent;
}

.navbar-toggler-icon {
    color: #333;
    font-size: 24px;
}

/* Search Bar */
.search-bar {
    max-width: 300px;
}

.search-bar .form-control {
    border-radius: 20px 0 0 20px;
    border: 1px solid #ced4da;
    font-size: 14px;
}

.search-bar .btn-primary {
    border-radius: 0 20px 20px 0;
    background-color: #EE4D2D;
    border: none;
    padding: 0 15px;
    transition: background-color 0.3s ease;
}

.search-bar .btn-primary:hover {
    background-color: #742718;
}

/* User & Cart Section */
.user-section .btn {
    font-size: 14px;
    padding: 8px 15px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary {
    background-color: #EE4D2D;
    border: none;
}

.btn-primary:hover {
    background-color: #b23a22;
    transform: scale(1.05);
}

.btn-outline-primary {
    border-color: #EE4D2D;
    color: #EE4D2D;
}

.btn-outline-primary:hover {
    background-color: #b73f27;
    color: #ffffff;
    border-color: #ab3820;
}

.cart-btn {
    position: relative;
}

.cart-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 12px;
    line-height: 18px;
    text-align: center;
}

/* Dropdown Menu */
.dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

.dropdown-item {
    padding: 10px 20px;
    color: #333;
    transition: background-color 0.3s ease;
}

.dropdown-item:hover {
    background-color: #007bff;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar-nav {
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    .nav-item {
        margin: 5px 0;
    }

    .nav-link {
        padding: 8px 15px;
    }

    .search-bar {
        max-width: 200px;
        margin: 10px 0;
    }

    .user-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .user-section .btn {
        width: 100%;
        margin: 5px 0;
    }
}
</style>

</html>