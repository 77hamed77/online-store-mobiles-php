<?php
session_start();
include("../php/config.php"); // تأكد من إعداد ملف الاتصال بقاعدة البيانات

// التحقق من صلاحيات المسؤول
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// التحقق من وجود معرّف الطلب في URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// استعلام استرجاع تفاصيل الطلب
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    $error_message = "الطلب غير موجود!";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الطلب | لوحة الإدارة</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #e4eef7;
        }

        .card {
            margin-top: 30px;
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
<!-- اريد إضافة اسم المنتج و اسم الميتخدم الذي قام بالطلب -->

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_product.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_offers.php">إدارة العروض</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_orders.php">إدارة الطلبات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_contact.php">إدارة رسائل الاتصال</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_users.php">إدارة الزبائن</a></li>
                    <li class="nav-item"><a class="nav-link" href="../php/logout.php">تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="dashboard-header">
        <div class="container">
            <h1>تعديل الطلب</h1>
            <p>يمكنك تعديل كل بيانات الطلب</p>
        </div>
    </header>

    <div class="container">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-4" role="alert">
                <?php echo $error_message; ?>
            </div>
            <div class="text-center mt-3">
                <a href="admin_orders.php" class="btn btn-primary">العودة إلى الطلبات</a>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title">تفاصيل الطلب</h4>
                </div>
                <div class="card-body">
                    <p><strong>معرّف الطلب:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                    <p><strong>معرّف المستخدم:</strong> <?php echo htmlspecialchars($order['user_id']); ?></p>
                    <p><strong>الإجمالي:</strong> <?php echo htmlspecialchars($order['total']); ?></p>
                    <p><strong>تاريخ الطلب:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
                    <!-- يمكنك إضافة تفاصيل إضافية إذا قمت بتخزين معلومات أخرى للطلب مثل حالة الدفع أو عنوان الشحن -->
                </div>
                <div class="card-footer text-center">
                    <a href="admin_orders.php" class="btn btn-primary">العودة إلى الطلبات</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>