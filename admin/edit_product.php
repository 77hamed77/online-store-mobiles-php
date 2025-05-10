<?php
session_start();
include("../php/config.php");


// التأكد من صلاحيات المدير
// if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
//     header("Location: ../login.php");
//     exit;
// }

// التحقق من وجود معرّف المنتج
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_product.php");
    exit;
}

$product_id = intval($_GET['id']);

$error_msg = "";
$success_msg = "";

// استرجاع بيانات المنتج من قاعدة البيانات
// لازم رجع السعة 
$stmt = $conn->prepare("SELECT name, description, price,quantity, image FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: admin/admin_product.php");
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// عند إرسال النموذج لتحديث البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = floatval($_POST['price']);
    $quantity    = intval($_POST['quantity']);
    $new_image   = $product['image']; // الصورة الحالية للمنتج

    // التحقق من صحة المدخلات
    if (empty($name) || empty($description) || empty($price) || empty($quantity)) {
        $error_msg = "يجب ملء جميع الحقول!";
    } elseif ($price <= 0) {
        $error_msg = "يجب أن يكون السعر أكبر من الصفر!";
    } elseif ($quantity <= 0) {
        $error_msg = " يجب ان تكون الكمية اكبر او تساوي الصفر";
    }
    // معالجة تحميل صورة جديدة إن وُجدت
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            // إعادة تسمية الملف لمنع التعارض
            $new_file_name = uniqid("PRD_", true) . "." . $file_ext;
            $destination   = "../uploads/" . $new_file_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                // حذف الصورة القديمة إذا كانت موجودة
                if (!empty($product['image']) && file_exists("../uploads/" . $product['image'])) {
                    unlink("../uploads/" . $product['image']);
                }
                $new_image = $new_file_name;
            } else {
                $error_msg = "حدث خطأ أثناء تحميل الصورة.";
            }
        } else {
            $error_msg = "صيغة الصورة غير مدعومة! الصيغ المسموحة: jpg, jpeg, png, gif.";
        }
    }

    // تحديث البيانات في حال عدم وجود أخطاء
    if (empty($error_msg)) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?,quantity = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssdisi", $name, $description, $price, $quantity, $new_image, $product_id);

        if ($stmt->execute()) {
            $success_msg = "تم تحديث المنتج بنجاح!";
        } else {
            $error_msg = "حدث خطأ أثناء تحديث البيانات.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتج | لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body{
            background: #e4eef7;
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

<body dir="rtl">
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="admin_product.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_offers.php">إدارة العروض</a></li>
                    <li class="nav-item"><a class="nav-link " href="admin_orders.php">إدارة الطلبات</a></li>
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
            <h1>تعديل المنتج</h1>
            <p>يمكنك تعديل كل بيانات المنتج</p>
        </div>
    </header>

    <div class="container mt-4">
        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
        <?php } ?>
        <?php if (!empty($success_msg)) { ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
        <?php } ?>

        <div class="card">
            <div class="card-header">
                <h4>تعديل المنتج</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف المنتج</label>
                        <textarea class="form-control" name="description" id="description" required><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">سعر المنتج</label>
                        <input type="number" step="0.01" class="form-control" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label"> كمية المنتج</label>
                        <input type="number" step="1" class="form-control" name="quantity" id="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة المنتج</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <?php if (!empty($product['image'])): ?>
                            <div class="mt-2">
                                <img src="../uploads/?= htmlspecialchars($product['image']) ?>" alt="صورة المنتج" width="100">
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">تحديث المنتج</button>
                    <a href="admin_product.php" class="btn btn-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>