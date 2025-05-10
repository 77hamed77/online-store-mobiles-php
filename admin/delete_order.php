<?php
session_start();
include("../php/config.php"); // تأكد من وجود ملف الاتصال بقاعدة البيانات

// التحقق من صلاحيات المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// التحقق من وجود معرّف الطلب في الرابط
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// إعداد وتنفيذ استعلام الحذف باستخدام جملة تحضير
$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    $message = "تم حذف الطلب بنجاح.";
} else {
    $message = "حدث خطأ أثناء حذف الطلب. يرجى المحاولة مرة أخرى.";
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حذف الطلب | لوحة الإدارة</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top:-28px">
        <div class="container">
            <a class="navbar-brand" href="#">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_orders.php">الطلبات</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="container">
        <div class="alert <?php echo (strpos($message, 'نجاح') !== false) ? 'alert-success' : 'alert-danger'; ?> text-center" role="alert">
            <?php echo $message; ?>
        </div>
        <div class="text-center">
            <a href="admin_orders.php" class="btn btn-primary">العودة إلى الطلبات</a>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>