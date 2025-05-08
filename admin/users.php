<?php
session_start();
include("../php/config.php");

// التحقق من صلاحيات المدير: يجب أن يكون المستخدم مسجّل دخول كمدير
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    header("Location: login.php");
    exit;
}

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
        $product_name  = trim($_POST['product_name']);
        $product_desc  = trim($_POST['product_desc']);
        $product_price = floatval($_POST['product_price']);
        $product_image = ""; // القيمة الافتراضية في حال عدم رفع صورة

        // معالجة رفع الصورة إن وُجدت
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

        if (empty($error_msg)) {
            $stmtAdd = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
            // نستخدم التنسيق "ssds": s = string, d = double
            $stmtAdd->bind_param("ssds", $product_name, $product_desc, $product_price, $product_image);
            if ($stmtAdd->execute()) {
                $success_msg = "تمت إضافة المنتج بنجاح.";
            } else {
                $error_msg = "حدث خطأ أثناء إضافة المنتج.";
            }
            $stmtAdd->close();
        }
    }
}

// استعلام لاسترجاع المنتجات من قاعدة البيانات
$stmt = $conn->prepare("SELECT id, name, description, price, image FROM products ORDER BY id DESC");
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
</head>

<body>
    <!-- شريط التنقل باستخدام Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="users.php">لوحة المدير</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">المنتجات</a>
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
                    <div class="mb-3">
                        <label for="product_price" class="form-label">سعر المنتج</label>
                        <input type="number" step="0.01" class="form-control" name="product_price" id="product_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">صورة المنتج</label>
                        <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*">
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
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>اسم المنتج</th>
                                <th>الوصف</th>
                                <th>السعر</th>
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
                                    echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                                    if (!empty($product['image'])) {
                                        echo "<td><img src='../uploads/" . htmlspecialchars($product['image']) . "' alt='صورة المنتج' width='60'></td>";
                                    } else {
                                        echo "<td>لا توجد صورة</td>";
                                    }
                                    echo "<td>";
                                    // رابط تعديل المنتج (يمكنك إنشاء صفحة edit_product.php إذا رغبت)
                                    echo "<a href='edit_product.php?id=" . htmlspecialchars($product['id']) . "' class='btn btn-sm btn-info me-1'>تعديل</a>";
                                    // رابط حذف المنتج مع تمرير رمز CSRF
                                    echo "<a href='?delete=" . htmlspecialchars($product['id']) . "&csrf_token=" . htmlspecialchars($_SESSION['csrf_token']) . "' class='btn btn-sm btn-danger' onclick=\"return confirm('هل أنت متأكد من حذف هذا المنتج؟');\">حذف</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>لا توجد منتجات</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>