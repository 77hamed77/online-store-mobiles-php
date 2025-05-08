<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// استعلام لاسترجاع عناصر السلة للمستخدم مع بيانات المنتج
$stmt = $conn->prepare("SELECT 
    c.quantity,
    p.name,
    p.price,
    p.image 
FROM cart c 
JOIN products p ON c.product_id = p.id 
WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الدفع | متجرك</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .payment-card,
        .summary-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }

        .card-title {
            font-weight: bold;
        }
    </style>
</head>

<body dir="rtl">
    <!-- شريط التنقل -->
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
                        <a class="nav-link" href="cart.php">سلة المنتجات</a>
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

    <div class="container my-5">
        <div class="row">
            <!-- عمود ملخص الطلب -->
            <div class="col-md-6 mb-4">
                <div class="card summary-card p-4">
                    <h4 class="card-title mb-3">ملخص الطلب</h4>
                    <?php if (!empty($cart_items)): ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($cart_items as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                        <small>الكمية: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <span><?php echo number_format($item['price'] * $item['quantity'], 2); ?> ريال</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-flex justify-content-between">
                            <strong>الإجمالي الكلي:</strong>
                            <strong><?php echo number_format($total, 2); ?> ريال</strong>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">السلة فارغة</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- عمود تفاصيل الدفع -->
            <div class="col-md-6">
                <div class="card payment-card p-4">
                    <h4 class="card-title mb-3">تفاصيل الدفع</h4>
                    <form action="process_payment.php" method="post">
                        <div class="mb-3">
                            <label for="cardname" class="form-label">اسم صاحب البطاقة</label>
                            <input type="text" class="form-control" id="cardname" name="cardname" placeholder="أدخل اسم صاحب البطاقة" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardnumber" class="form-label">رقم البطاقة</label>
                            <input type="text" class="form-control" id="cardnumber" name="cardnumber" placeholder="أدخل رقم البطاقة" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="expdate" class="form-label">تاريخ الإنتهاء</label>
                                <input type="text" class="form-control" id="expdate" name="expdate" placeholder="MM/YY" required>
                            </div>
                            <div class="col">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="أدخل CVV" required>
                            </div>
                        </div>
                        <!-- حقل مخفي لنقل إجمالي السعر -->
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <button type="submit" class="btn btn-success w-100">ادفع الآن</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>