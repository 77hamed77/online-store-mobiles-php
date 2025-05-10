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
            background-color: #e4eef7
        }

        .container {
            margin-top: 50px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #007bff, rgb(0, 38, 48));
            color: #fff;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .dashboard-header p {
            margin: 0;
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top: -50px;">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_product.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_offers.php">إدارة العروض</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_orders.php">إدارة الطلبات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_contact.php">إدارة رسائل الاتصال</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_users.php">إدارة الزبائن</a></li>
                    <li class="nav-item"><a class="nav-link" href="../php/logout.php">تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- قسم رأس الصفحة -->
    <header class="dashboard-header">
        <div class="container">
            <h1>حذف العرض</h1>
            <!-- <p>تحليل مبيعات اليوم، الأسبوع والشهر</p> -->
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
    <div class="container">
        <div class="alert <?php echo (strpos($message, 'نجاح') !== false) ? 'alert-success' : 'alert-danger'; ?> text-center" role="alert">
            <?php echo $message; ?>
        </div>
        <div class="text-center">
            <a href="admin_offers.php" class="btn btn-primary">العودة إلى العروض</a>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>