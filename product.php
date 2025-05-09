<?php
session_start();
include("php/config.php");

// التحقق من وجود معرّف المنتج في الرابط
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = intval($_GET['id']);

// استرجاع بيانات المنتج من قاعدة البيانات باستخدام عبارة تحضير
$stmt = $conn->prepare("SELECT id, name, description, price, image FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// التأكد من وجود المنتج
if ($result->num_rows === 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>المنتج غير موجود.</div></div>";
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> | تفاصيل المنتج</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img {
            max-height: 400px;
            object-fit: cover;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body dir="rtl">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">سلة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">الملف الشخصي</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم تفاصيل المنتج -->
    <div class="container mt-5">
        <div class="row">
            <!-- الصورة -->
            <div class="col-md-6">
                <?php if (!empty($product['image'])): ?>
                    <img src="uploads/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid product-img rounded">
                <?php else: ?>
                    <img src="img/default-product.png" alt="صورة افتراضية" class="img-fluid product-img rounded">
                <?php endif; ?>
            </div>
            <!-- تفاصيل المنتج -->
            <div class="col-md-6">
                <h1 class="mb-3"><?= htmlspecialchars($product['name']); ?></h1>
                <h4 class="text-primary mb-4"><?= number_format($product['price'], 2); ?> ريال</h4>
                <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
                <!-- زر إضافة إلى السلة -->
                <form action="add_to_cart.php" method="post" class="mt-4">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">الكمية</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-success">أضف إلى السلة</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer بسيط -->
    <footer class="bg-light text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y"); ?> متجرك. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>