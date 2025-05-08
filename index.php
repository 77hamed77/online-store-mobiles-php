<?php
session_start();
include("php/config.php");

// استعلام لاسترجاع جميع المنتجات (يمكنك تعديل الاستعلام مع شروط أو ترتيب كما تشاء)
$stmt = $conn->prepare("SELECT id, name, description, price, image FROM products ORDER BY id DESC");
$stmt->execute();
$products_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنتجات الرئيسية | متجرك</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:#FFFFFF;
        }

        .product-card {
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">متجرك</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">عروض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">حول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">تسجيل الدخول</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container my-4">
        <div class="p-5 text-center bg-primary text-white rounded-3">
            <h1 class="display-4">مرحباً بكم في متجرك!</h1>
            <p class="lead">استعرض أفضل المنتجات لدينا وتمتع بتجربة تسوق فريدة.</p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container my-4">
        <div class="row">
            <?php if ($products_result->num_rows > 0): ?>
                <?php while ($product = $products_result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100">
                            <?php if (!empty($product['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($product['image']); ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product['name']); ?>">
                            <?php else: ?>
                                <img src="img/default-product.png" class="card-img-top product-img" alt="صورة افتراضية">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars(mb_substr($product['description'], 0, 100)); ?>...</p>
                                <p class="card-text fw-bold"><?= number_format($product['price'], 2); ?> ريال</p>
                                <a href="product.php?id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-primary mt-auto">المزيد</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">لا توجد منتجات متاحة حالياً.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y"); ?> متجرك. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>