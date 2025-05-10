<?php
session_start();
include("../php/config.php"); // ملف الاتصال بقاعدة البيانات
// التحقق من صلاحية المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال وتنظيف المدخلات (باستثناء الصورة التي ستأتي عبر $_FILES)
    $offer_name        = trim($_POST['offer_name']);
    $discount          = trim($_POST['discount']);
    $offer_description = trim($_POST['offer_description']);

    // التحقق من ملء كافة الحقول
    if (empty($offer_name) || empty($discount) || empty($offer_description)) {
        $error = "يرجى ملء جميع الحقول.";
    } elseif (!is_numeric($discount)) {
        $error = "يرجى إدخال قيمة رقمية صحيحة للخصم.";
    } elseif (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] != 0) {
        $error = "يرجى اختيار صورة للعرض.";
    } else {
        // معالجة رفع الصورة
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['product_image']['name'];
        $file_tmp  = $_FILES['product_image']['tmp_name'];
        $file_size = $_FILES['product_image']['size'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed)) {
            $error = "صيغة الصورة غير مدعومة. الرجاء اختيار صورة بصيغة jpg, jpeg, png, gif.";
        } elseif ($file_size > 5 * 1024 * 1024) { // مثال: حجم الصورة يجب ألا يتجاوز 5MB
            $error = "حجم الصورة كبير جداً. الرجاء اختيار صورة أقل من 5MB.";
        } else {
            // التأكد من وجود مجلد التحميلات وإنشاؤه إن لم يكن موجوداً
            $uploads_dir = "../uploads";
            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }
            // إنشاء اسم جديد للصورة لتجنب تكرار الأسماء
            $new_file_name = uniqid("offer_") . '.' . $file_ext;
            $destination = $uploads_dir . "/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                // تأمين باقي البيانات قبل الإدخال في قاعدة البيانات
                $offer_name        = mysqli_real_escape_string($conn, $offer_name);
                $discount          = floatval($discount);
                $offer_description = mysqli_real_escape_string($conn, $offer_description);
                $destination       = mysqli_real_escape_string($conn, $destination);

                // إعداد استعلام الإدخال في جدول offers
                $stmt = $conn->prepare("INSERT INTO offers (offer_name, discount, product_image, offer_description, created_at) VALUES (?, ?, ?, ?, NOW())");
                if ($stmt) {
                    $stmt->bind_param("sdss", $offer_name, $discount, $destination, $offer_description);
                    if ($stmt->execute()) {
                        $success = "تم إضافة العرض بنجاح.";
                    } else {
                        $error = "حدث خطأ أثناء إضافة العرض. يرجى المحاولة مرة أخرى.";
                    }
                    $stmt->close();
                } else {
                    $error = "خطأ في إعداد الاستعلام.";
                }
            } else {
                $error = "حدث خطأ أثناء رفع الصورة.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عرض جديد | لوحة الإدارة</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

<body style="background: #e4eef7;">
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
            <h1>إضافة عرض </h1>
            <p>إضافة عرض جديد الى جدول العروضات</p>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">إضافة عرض جديد</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <!-- يجب إضافة enctype="multipart/form-data" للسماح برفع الملفات -->
            <form action="add_offer.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="offer_name" class="form-label">اسم العرض</label>
                    <input type="text" class="form-control" id="offer_name" name="offer_name" placeholder="أدخل اسم العرض" required>
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">الخصم (%)</label>
                    <input type="number" step="0.01" class="form-control" id="discount" name="discount" placeholder="أدخل نسبة الخصم" required>
                </div>
                <div class="mb-3">
                    <label for="product_image" class="form-label">صورة المنتج</label>
                    <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="offer_description" class="form-label">وصف العرض</label>
                    <textarea class="form-control" id="offer_description" name="offer_description" rows="4" placeholder="أدخل وصف العرض" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">إضافة العرض</button>
                </div>
            </form>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>