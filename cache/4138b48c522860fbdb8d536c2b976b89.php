<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
            echo isset($title) && !empty($title) ? $title . " | Admin" : "My App | Admin Dashboard";
        ?>
    </title>    <!-- Bootstrap CSS -->
    <link rel="icon" href="https://i.pinimg.com/originals/a0/d4/ea/a0d4eaba7e055708242b095e55329b6d.jpg" type="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #212529;
            color: white;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px 15px;
            display: block;
        }

        .sidebar .nav-link.active {
            background-color: #495057;
        }

        .container {
            display: flex;
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #212529;
            color: white;
            padding-top: 20px;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            width: 100%;
            flex: 1;
            padding: 20px;
        }

        .footer-content {
            margin-left: 180px;
            margin-top: 60px;
            width: 100%;
            flex: 1;
            padding: 20px;
        }
    </style>

</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">My App</h1>
                <div class="d-flex align-items-center">
                    <form class="d-flex me-3">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                    <?php if (!isset($_SESSION['users'])): ?>
                        <a href="/register" class="btn btn-outline-light ms-3">Đăng Kí</a>
                        <a href="/login" class="btn btn-light ms-3">Đăng Nhập</a>
                    <?php else: ?>
                        <p class="text-white mb-0 me-2">Xin chào, <?= $_SESSION['users']['name'] ?></p>
                        <a href="/logout" class="btn btn-danger ms-3">Đăng Xuất</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar">
                <div class="position-sticky pt-3">
                    <h1>Admin</h1>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/admin" class="nav-link active">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/products" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sản phẩm
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/admin/products">Danh sách sản phẩm</a></li>
                                <li><a class="dropdown-item" href="/admin/products/create">Thêm sản phẩm</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/category" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Danh mục
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/admin/category">Danh sách danh mục</a></li>
                                <li><a class="dropdown-item" href="/admin/category/create">Thêm danh mục</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/sizes" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kích cỡ
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/admin/sizes">Danh sách size</a></li>
                                <li><a class="dropdown-item" href="/admin/sizes/create">Thêm size</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/colors" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Màu sắc
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/admin/colors">Danh sách màu sắc</a></li>
                                <li><a class="dropdown-item" href="/admin/colors/create">Thêm màu sắc</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/orders" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Đơn Hàng
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/admin/orders">Danh sách đơn hàng</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/users" class="nav-link">Quản lí người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a href="/" class="nav-link">Quay lại trang chủ</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="main-content">

                <?php echo $__env->yieldContent('content'); ?>
                <div class="h-100vh">
                    <!-- nd -->
                </div>

            </main>
        </div>
    </div>

    <footer class="bg-dark text-white py-3 mt-4 footer-content">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y") ?> My App</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html><?php /**PATH D:\FPT Polytechnic\php2\view/layouts/admin.blade.php ENDPATH**/ ?>