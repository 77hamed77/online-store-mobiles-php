<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// الحصول على معرّف المستخدم الحالي
$user_id = $_SESSION['id'];

// معالجة تحديث الكمية وحذف العناصر من السلة
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تحديث الكمية
    if (isset($_POST['update_cart'])) {
        $cart_id     = intval($_POST['cart_id']);
        $new_quantity = intval($_POST['quantity']);
        // إذا كانت الكمية أقل من 1، يمكن اعتبارها حذفاً
        if ($new_quantity <= 0) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cart_id, $user_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("iii", $new_quantity, $cart_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // حذف عنصر من السلة
    if (isset($_POST['remove_item'])) {
        $cart_id = intval($_POST['cart_id']);
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// استعلام لاسترجاع عناصر السلة للمستخدم الحالي مع بيانات المنتج
$stmt = $conn->prepare("
    SELECT 
      c.id AS cart_id,
      c.quantity,
      p.id AS product_id,
      p.name,
      p.price,
      p.image 
    FROM cart c JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}
$stmt->close();

// حساب الإجمالي الكلي
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة المنتجات | متجرك</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
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
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="products.php">سلة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">سلة المنتجات</h2>
        <?php if (count($cart_items) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>الصورة</th>
                            <th>اسم المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الإجمالي</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="80">
                                    <?php else: ?>
                                        <img src="img/default-product.png" alt="صورة افتراضية" width="80">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['name']); ?></td>
                                <td><?= number_format($item['price'], 2); ?> ريال</td>
                                <td>
                                    <form action="" method="post" class="d-flex align-items-center">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                                        <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']); ?>" min="1" class="form-control me-2" style="width: 100px;">
                                        <button type="submit" name="update_cart" class="btn btn-sm btn-info">تحديث</button>
                                    </form>
                                </td>
                                <td><?= number_format($item['price'] * $item['quantity'], 2); ?> ريال</td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من إزالة هذا المنتج؟');">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <h4>الإجمالي الكلي: <?= number_format($total, 2); ?> ريال</h4>
            </div>
            <div class="mt-4">
                <a href="checkout.php" class="btn btn-success">الانتقال إلى صفحة الدفع</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">لا توجد منتجات في سلة التسوق الخاصة بك.</div>
            <a href="index.php" class="btn btn-primary">العودة للتسوق</a>
        <?php endif; ?>
    </div>

    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>