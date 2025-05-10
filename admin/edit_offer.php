<?php
session_start();
include("../php/config.php"); // يجب أن يحتوي على إعدادات الاتصال بقاعدة البيانات

// التحقق من صلاحية المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// التحقق من وجود معرف العرض في الرابط
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_offers.php");
    exit();
}

$offer_id = intval($_GET['id']);

// استرجاع بيانات العرض الحالي
$stmt = $conn->prepare("SELECT * FROM offers WHERE id = ?");
$stmt->bind_param("i", $offer_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $stmt->close();
    header("Location: admin_offers.php");
    exit();
}
$offer = $result->fetch_assoc();
$stmt->close();

$error   = "";
$success = "";
$old_image = $offer['product_image'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال وتنظيف المدخلات (باستثناء الصورة التي ستأتي عبر $_FILES)
    $offer_name        = trim($_POST['offer_name']);
    $discount          = trim($_POST['discount']);
    $offer_description = trim($_POST['offer_description']);

    // التحقق من ملء الحقول الأساسية
    if (empty($offer_name) || empty($discount) || empty($offer_description)) {
        $error = "يرجى ملء جميع الحقول المطلوبة.";
    } elseif (!is_numeric($discount)) {
        $error = "يرجى إدخال قيمة رقمية صحيحة للخصم.";
    } else {
        // معالجة رفع صورة جديدة إن تم اختيارها
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $allowed   = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['product_image']['name'];
            $file_tmp  = $_FILES['product_image']['tmp_name'];
            $file_size = $_FILES['product_image']['size'];
            $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed)) {
                $error = "صيغة الصورة غير مدعومة. الرجاء اختيار صورة بصيغة jpg, jpeg, png, أو gif.";
            } elseif ($file_size > 5 * 1024 * 1024) { // الحجم الأقصى 5 ميجابايت
                $error = "حجم الصورة كبير جداً. الرجاء اختيار صورة أقل من 5MB.";
            } else {
                $uploads_dir = "../uploads";
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0777, true);
                }
                $new_file_name = uniqid("offer_") . '.' . $file_ext;
                $destination   = $uploads_dir . "/" . $new_file_name;
                if (move_uploaded_file($file_tmp, $destination)) {
                    $new_image = $destination;
                    // في حال وجود صورة سابقة وحذفها مرغوب
                    if (file_exists($old_image) && $old_image != $new_image) {
                        @unlink($old_image);
                    }
                } else {
                    $error = "حدث خطأ أثناء رفع الصورة.";
                }
            }
        } else {
            // لم يتم رفع صورة جديدة، إذن نحتفظ بالصورة القديمة
            $new_image = $old_image;
        }

        // إذا لم يكن هناك أخطاء، نقوم بتحديث البيانات في قاعدة البيانات
        if (empty($error)) {
            // تأمين البيانات قبل الإدخال
            $offer_name_db        = mysqli_real_escape_string($conn, $offer_name);
            $offer_description_db = mysqli_real_escape_string($conn, $offer_description);
            $discount_db          = floatval($discount);
            $new_image_db         = mysqli_real_escape_string($conn, $new_image);

            $stmt = $conn->prepare("UPDATE offers SET offer_name = ?, discount = ?, product_image = ?, offer_description = ? WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("sdssi", $offer_name_db, $discount_db, $new_image_db, $offer_description_db, $offer_id);
                if ($stmt->execute()) {
                    $success = "تم تحديث العرض بنجاح.";
                    // تحديث بيانات العرض المحلي لتحديث النموذج إذا كان المستخدم يرغب بالاطلاع عليها
                    $offer['offer_name']        = $offer_name;
                    $offer['discount']          = $discount_db;
                    $offer['product_image']     = $new_image;
                    $offer['offer_description'] = $offer_description;
                    $old_image = $new_image;
                } else {
                    $error = "حدث خطأ أثناء تحديث البيانات. يرجى المحاولة مرة أخرى.";
                }
                $stmt->close();
            } else {
                $error = "خطأ في إعداد الاستعلام.";
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
    <title>تعديل العرض | لوحة الإدارة</title>
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
            margin-bottom: 30px;
        }

        .current-image {
            max-width: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل للإدارة -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_offers.php">العروض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_orders.php">الطلبات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_contact.php">رسائل الاتصال</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">تعديل العرض</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            <!-- ملاحظة: تأكد من وجود enctype="multipart/form-data" للسماح برفع الملفات -->
            <form action="edit_offer.php?id=<?php echo $offer_id; ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="offer_name" class="form-label">اسم العرض</label>
                    <input type="text" class="form-control" id="offer_name" name="offer_name" placeholder="أدخل اسم العرض" value="<?php echo htmlspecialchars($offer['offer_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">الخصم (%)</label>
                    <input type="number" step="0.01" class="form-control" id="discount" name="discount" placeholder="أدخل نسبة الخصم" value="<?php echo htmlspecialchars($offer['discount']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الصورة الحالية</label><br>
                    <img src="<?php echo htmlspecialchars($offer['product_image']); ?>" alt="الصورة الحالية" class="img-fluid current-image">
                </div>
                <div class="mb-3">
                    <label for="product_image" class="form-label">تغيير صورة المنتج</label>
                    <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                    <small class="text-muted">اترك الحقل فارغاً إذا كنت لا تريد تغيير الصورة.</small>
                </div>
                <div class="mb-3">
                    <label for="offer_description" class="form-label">وصف العرض</label>
                    <textarea class="form-control" id="offer_description" name="offer_description" rows="4" placeholder="أدخل وصف العرض" required><?php echo htmlspecialchars($offer['offer_description']); ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">تحديث العرض</button>
                </div>
            </form>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>