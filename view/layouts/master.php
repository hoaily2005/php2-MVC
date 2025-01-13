<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "My App" ?></title>
    <!-- Bootstrap CSS -->
    <link rel="icon" href="https://i.pinimg.com/originals/a0/d4/ea/a0d4eaba7e055708242b095e55329b6d.jpg" type="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">My App</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link text-white">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/products" class="nav-link text-white">Products</a>
                        </li>
                        <li class="nav-item">
                            <a href="/category" class="nav-link text-white">Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="/users" class="nav-link text-white">User</a>
                        </li>
                    </ul>
                </nav>
                <div class="d-flex align-items-center">
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


    <main class="container my-4" style="min-height: calc(100vh - 200px);">
        <?= $content ?>
    </main>

    <footer class="bg-dark text-white py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y") ?> My App</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>