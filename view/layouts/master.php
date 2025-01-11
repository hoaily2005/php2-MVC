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
            <h1 class="h3">My App</h1>
            <nav>
                <a href="/" class="text-white me-3">Home</a>
                <a href="/products" class="text-white">Products</a>
                <a href="/category" class="text-white ms-3">Catetgory</a>
                <a href="/users" class="text-white ms-3">User</a>
                <a href="/register" class="text-white ms-3">Register</a>
                <a href="/login" class="text-white ms-3">Login</a>
            </nav>
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