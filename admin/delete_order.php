<?php
session_start();
include("../php/config.php"); // Make sure this file contains your DB connection settings

// Check if the current user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// Check that an order ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Prepare the DELETE statement
$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    $message = "تم حذف المنتج بنجاح";
} else {
    $message = "حدث خطأ في عملية الحذف ، حاول مرة أخرى";
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حذف طلب | لوحة الإدارة</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #e4eef7;
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
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
            <h1>حذف الطلب</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="alert <?php echo (strpos($message, 'successfully') !== false) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            <?php echo $message; ?>
        </div>
        <div class="text-center">
            <a href="admin_orders.php" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>