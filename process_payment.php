<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال بيانات الدفع
    $cardname   = trim($_POST['cardname']);
    $cardnumber = trim($_POST['cardnumber']);
    $expdate    = trim($_POST['expdate']);
    $cvv        = trim($_POST['cvv']);
    $total      = floatval($_POST['total']);

    // تحقق بسيط من صحة الحقول
    if (empty($cardname) || empty($cardnumber) || empty($expdate) || empty($cvv) || $total <= 0) {
        $error_msg = "الرجاء ملء كافة الحقول بشكل صحيح.";
    } else {
        // هنا يمكنك دمج واجهة برمجة دفع (Payment Gateway API) لمعالجة الدفع.
        // سنقوم بمحاكاة نجاح الدفع:

        // (مثال اختياري) إدراج بيانات الطلب في قاعدة البيانات:
        // $stmt = $conn->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
        // $stmt->bind_param("id", $_SESSION['id'], $total);
        // $stmt->execute();
        // $order_id = $stmt->insert_id;
        // $stmt->close();

        // مسح سلة المنتجات بعد نجاح الدفع
        $stmt_clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt_clear->bind_param("i", $_SESSION['id']);
        $stmt_clear->execute();
        $stmt_clear->close();

        $success_msg = "تمت معالجة الدفع بنجاح! تم دفع " . number_format($total, 2) . " ريال.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معالجة الدفع | متجرك</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">متجرك</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
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

    <div class="container mt-5">
        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger">
                <?php echo $error_msg; ?>
            </div>
        <?php elseif (!empty($success_msg)): ?>
            <div class="alert alert-success">
                <?php echo $success_msg; ?>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">العودة للرئيسية</a>
            </div>
        <?php else: ?>
            <!-- إذا وصل المستخدم لهذه الصفحة بدون إرسال بيانات الدفع، يتم إعادة التوجيه أو عرض رسالة -->
            <div class="alert alert-info text-center">
                لا توجد بيانات للدفع
            </div>
            <div class="text-center mt-4">
                <a href="cart.php" class="btn btn-primary">العودة إلى السلة</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>