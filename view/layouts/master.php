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

    <!-- Header -->
    <header class="bg-white text-dark py-3 shadow-sm">
        <div class="container">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <h1 class="h3 mb-0">
                    <a href="/">
                        <img src="uploads/products/logoshop.png" alt="Logo" width="100">
                    </a>
                </h1>

                <!-- Menu Navigation -->
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/">TRANG CHỦ</a>
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
                    </div>
                </nav>

                <!-- Search Bar -->
                <form class="d-flex me-3" action="#" method="GET">
                    <input class="form-control me-6" type="search" name="query" placeholder="Tìm kiếm" aria-label="Search">
                </form>

                <!-- User & Cart Section -->
                <div class="d-flex align-items-center">
                    <a href="carts" class="btn btn-outline-dark me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <?php if (!isset($_SESSION['users'])): ?>
                        <a href="/register" class="btn btn-outline-dark me-2">Đăng Kí</a>
                        <a href="/login" class="btn btn-outline-dark">Đăng Nhập</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <!-- Icon user -->
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="/profile/<?= $_SESSION['users']['id'] ?>">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="/orders">Đơn hàng</a></li>
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
            <?= $content ?>
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
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    header {
        background-color: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
    }

    /* Navbar Styles */
    .navbar {
        padding: 0;
    }

    .navbar-nav {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .nav-item {
        margin-right: 20px;
    }

    .nav-link {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        padding: 5px 15px;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #007bff;
    }

    .navbar-toggler {
        border: none;
        background-color: transparent;
    }

    .navbar-toggler-icon {
        color: #333;
    }

    .navbar-collapse {
        justify-content: flex-end;
    }





    form button {
        background-color: transparent;
        border: none;
        color: #333;
        cursor: pointer;
        padding: 5px 10px;
    }

    /* User & Cart Section */
    header .d-flex {
        display: flex;
        align-items: center;
    }

    header .btn {
        padding: 5px 15px;
        font-size: 14px;
        margin-left: 10px;
    }

    header .dropdown-menu {
        min-width: 200px;
    }

    header .dropdown-item {
        padding: 10px;
        font-size: 14px;
        color: #333;
    }

    header .dropdown-item:hover {
        background-color: #007bff;
        color: white;
    }

    /* Footer Styles */
    footer {
        background-color: #17a2b8;
        color: white;
        text-align: center;
        padding: 15px 0;
    }

    footer p {
        margin: 0;
        font-size: 14px;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {

        /* Menu Navigation */
        .navbar-nav {
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
        }

        .nav-item {
            margin-right: 0;
            margin-bottom: 10px;
        }

        /* Search Bar */
        form .form-control {
            width: 180px;
        }

        /* User & Cart Section */
        header .d-flex {
            flex-direction: column;
            align-items: flex-start;
            margin-top: 10px;
        }

        header .d-flex a {
            margin-top: 10px;
        }

        header .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    /* Scrollbar Customization */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Topbar Styles */
    .topbar {
        background-color: #343a40;
        color: white;
    }

    .topbar .topbar-left a,
    .topbar .topbar-right a {
        font-size: 14px;
        color: white;
        text-decoration: none;
    }

    .topbar .topbar-left a:hover,
    .topbar .topbar-right a:hover {
        color: #ff5722;
    }

    .topbar .topbar-right a {
        margin-left: 15px;
    }
</style>

</html>