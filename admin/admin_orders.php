<?php
session_start();
include("../php/config.php"); // تأكد من وجود ملف الاتصال بقاعدة البيانات

// التحقق من صلاحيات المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// استعلام لاسترجاع كافة الطلبات من جدول orders وترتيبها حسب تاريخ الإنشاء (الأحدث أولاً)
$query  = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $query) or die("حدث خطأ أثناء استرجاع الطلبات");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات | لوحة الإدارة</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table-responsive {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        .navbar-brand {
            font-weight: bold;
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

<body style="background: #e4eef7;">

    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top: -28px;">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_product.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link " href="admin_offers.php">إدارة العروض</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_orders.php">إدارة الطلبات</a></li>
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
            <h1>لوحة إدارة الطلبات</h1>
            <p>يمكنك رؤية و تعديل و إضافة و حذف الطلبات</p>
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
    <div class="container">
        <h2 class="text-center mb-4">إدارة الطلبات</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>معرّف المستخدم</th>
                        <th>الإجمالي</th>
                        <th>تاريخ الطلب</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <!-- أمثلة على أزرار الإجراءات؛ يمكنك تعديلها حسب الحاجة -->
                                <a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">عرض</a>
                                <a href="delete_order.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                    حذف
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>



    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>