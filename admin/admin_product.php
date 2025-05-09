<?php
session_start();
include("../php/config.php");

// التأكد من صلاحيات المدير
// if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
//     header("Location: ../login.php");
//     exit;
// }


// إنشاء رمز CSRF إذا لم يكن موجوداً بالفعل
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_msg   = "";
$success_msg = "";

// معالجة حذف منتج عند استقبال معرّف الحذف عبر GET مع رمز CSRF
if (isset($_GET['delete']) && !empty($_GET['delete']) && isset($_GET['csrf_token']) && $_GET['csrf_token'] === $_SESSION['csrf_token']) {
    $deleteId = intval($_GET['delete']);
    $stmtDel = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmtDel->bind_param("i", $deleteId);
    if ($stmtDel->execute()) {
        $success_msg = "تم حذف المنتج بنجاح.";
    } else {
        $error_msg = "حدث خطأ أثناء حذف المنتج.";
    }
    $stmtDel->close();
}

// معالجة إضافة منتج جديد عند تقديم النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_product') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_msg = "فشل التحقق من الهوية.";
    } else {
        // استلام وتنظيف المدخلات
        $product_name      = trim($_POST['product_name']);
        $product_desc      = trim($_POST['product_desc']);
        $product_price     = floatval($_POST['product_price']);
        $product_quantity  = intval($_POST['product_quantity']); // حقل الكمية الجديد
        $product_image     = ""; // القيمة الافتراضية إذا لم يتم رفع صورة

        if (empty($product_name) || empty($product_desc) || $product_price <= 0 || $product_quantity < 0) {
            $error_msg = "يجب ملء جميع الحقول المطلوبة بشكل صحيح.";
        } else {
            // معالجة رفع صورة المنتج
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
                $file_tmp  = $_FILES['product_image']['tmp_name'];
                $file_name = $_FILES['product_image']['name'];
                $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($file_ext, $allowed_ext)) {
                    // إعادة تسمية الملف لمنع التعارض
                    $new_file_name = uniqid("PRD_", true) . "." . $file_ext;
                    $destination   = "../uploads/" . $new_file_name;
                    if (move_uploaded_file($file_tmp, $destination)) {
                        $product_image = $new_file_name;
                    } else {
                        $error_msg = "حدث خطأ أثناء تحميل صورة المنتج.";
                    }
                } else {
                    $error_msg = "صيغة صورة المنتج غير مدعومة! الصيغ المسموحة: jpg, jpeg, png, gif.";
                }
            }
            // إذا لم تحدث أخطاء ننتقل لإدراج المنتج
            if (empty($error_msg)) {
                $stmtAdd = $conn->prepare("INSERT INTO products (name, description, price, image, quantity) VALUES (?, ?, ?, ?, ?)");
                $stmtAdd->bind_param("ssdsi", $product_name, $product_desc, $product_price, $product_image, $product_quantity);
                if ($stmtAdd->execute()) {
                    $success_msg = "تمت إضافة المنتج بنجاح.";
                } else {
                    $error_msg = "حدث خطأ أثناء إضافة المنتج.";
                }
                $stmtAdd->close();
            }
        }
    }
}

// استعلام لاسترجاع قائمة المنتجات من قاعدة البيانات مع العمودين الجديدين (created_at و quantity)
$stmt = $conn->prepare("SELECT id, name, description, price, image, created_at, quantity FROM products ORDER BY id DESC");
$stmt->execute();
$products_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات | لوحة المدير</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body dir="rtl">
    <!-- شريط التنقل باستخدام Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_product.php">لوحة المدير</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_product.php">إدارة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="admin_users.php">إدارة المستخدمين</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="admin_contact.php">إدارة رسائل الإتصال</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php } ?>
        <?php if (!empty($success_msg)) { ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success_msg) ?>
            </div>
        <?php } ?>

        <!-- نموذج إضافة منتج جديد -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>إضافة منتج جديد</h4>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="action" value="add_product">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">اسم المنتج</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_desc" class="form-label">وصف المنتج</label>
                        <textarea class="form-control" name="product_desc" id="product_desc" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="product_price" class="form-label">سعر المنتج</label>
                            <input type="number" step="0.01" class="form-control" name="product_price" id="product_price" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_quantity" class="form-label">الكمية</label>
                            <input type="number" class="form-control" name="product_quantity" id="product_quantity" value="0" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_image" class="form-label">صورة المنتج</label>
                            <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">إضافة المنتج</button>
                </form>
            </div>
        </div>

        <!-- عرض قائمة المنتجات -->
        <div class="card">
            <div class="card-header">
                <h4>المنتجات الحالية</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>الوصف</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>تاريخ الإضافة</th>
                                <th>الصورة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($products_result->num_rows > 0) {
                                while ($product = $products_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars(substr($product['description'], 0, 50)) . "...</td>";
                                    echo "<td>" . number_format($product['price'], 2) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['created_at']) . "</td>";
                                    if (!empty($product['image'])) {
                                        echo "<td><img src='../uploads/" . htmlspecialchars($product['image']) . "' alt='صورة المنتج' class='product-img'></td>";
                                    } else {
                                        echo "<td>لا توجد صورة</td>";
                                    }
                                    echo "<td>";
                                    echo "<a href='edit_product.php?id=" . htmlspecialchars($product['id']) . "' class='btn btn-sm btn-info me-1'>تعديل</a>";
                                    echo "<a href='?delete=" . htmlspecialchars($product['id']) . "&csrf_token=" . htmlspecialchars($_SESSION['csrf_token']) . "' class='btn btn-sm btn-danger' onclick=\"return confirm('هل أنت متأكد من حذف هذا المنتج؟');\">حذف</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>لا توجد منتجات</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>