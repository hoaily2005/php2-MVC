<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "My App" ?> | Đồ Thể Thao</title>
    <!-- Bootstrap CSS -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/vi/thumb/1/1d/Manchester_City_FC_logo.svg/615px-Manchester_City_FC_logo.svg.png?20171110155930" type="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/view/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- top bar -->
    <div style="position: relative; z-index: 999; text-align: center;">
        <a href="#">
            <div class="top_bar" style="background-color: rgb(239, 255, 244); display: flex; align-items: center; justify-content: center;">
                <div class="top_bar_content" style="color: rgb(0, 171, 86); margin-right: 10px; text-decoration: none;"><a href="#" class="">Freeship đơn từ 45k, giảm nhiều hơn cùng</a></div>
                <picture class="webpimg-container">
                    <source type="image/webp" srcset="https://salt.tikicdn.com/ts/upload/a7/18/8c/910f3a83b017b7ced73e80c7ed4154b0.png">
                    <img srcset="https://salt.tikicdn.com/ts/upload/a7/18/8c/910f3a83b017b7ced73e80c7ed4154b0.png" class="styles__StyledImg-sc-p9s3t3-0 hWfTkr title-img" alt="icon" width="79" height="16" style="width: 79px; height: 16; opacity: 1;">
                </picture>
            </div>
        </a>
    </div>
    <!-- Header -->
    <header class="bg-white text-dark py-3 shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <h1 class="h3 mb-0">
                <a href="/">
                    <img src="uploads/products/Thethao.png" alt="Logo" width="100">
                </a>
            </h1>

            <!-- Menu Navigation -->
            <nav class="d-flex align-items-center">
                <ul class="nav me-3">
                    <li><a href="/" class="nav-link px-3 text-dark" style="font-size: 14px;">TRANG CHỦ</a></li>
                    <li><a href="#" class="nav-link px-3 text-dark" style="font-size: 14px;">SẢN PHẨM</a></li>
                    <li><a href="#" class="nav-link px-3 text-dark" style="font-size: 14px;">ĐƠN HÀNG</a></li>
                    <?php if (isset($_SESSION['users']) && $_SESSION['users']['role'] === 'admin'): ?>
                        <li><a href="/admin" class="nav-link px-3 text-dark" style="font-size: 14px;">ADMIN</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- Search Bar -->
            <form class="d-flex me-3" action="#" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <!-- User & Cart Section -->
            <div class="d-flex align-items-center">
                <a href="carts" class="btn btn-outline-dark me-3">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <?php if (!isset($_SESSION['users'])): ?>
                    <a href="/register" class="btn btn-outline-dark me-2">Đăng Kí</a>
                    <a href="/login" class="btn btn-dark">Đăng Nhập</a>
                <?php else: ?>
                    <p class="text-dark mb-0 me-2">Xin chào, <?= $_SESSION['users']['name'] ?></p>
                    <a href="/logout" class="btn btn-danger">Đăng Xuất</a>
                <?php endif; ?>
            </div>
        </div>
    </header>



    <main class="main" style="min-height: calc(100vh - 100px);">
        <div class="container mt-3">
            <?= $content ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-info text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between">
                <p>&copy; <?= date("Y") ?> TheThao. All rights reserved.</p>

            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>