<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال بيانات الدفع
    $cardname   = trim($_POST['cardname']);
    $cardnumber = trim($_POST['cardnumber']);
    $expdate    = trim($_POST['expdate']);
    $cvv        = trim($_POST['cvv']);
    $total      = floatval($_POST['total']);

    // تحقق بسيط من صحة الحقول
    if (empty($cardname) || empty($cardnumber) || empty($expdate) || empty($cvv) || $total <= 0) {
        $error_msg = "الرجاء ملء كافة الحقول بشكل صحيح.";
    } else {
        // هنا يمكنك دمج واجهة برمجة دفع (Payment Gateway API) لمعالجة الدفع.
        // سنقوم بمحاكاة نجاح الدفع:

        // (مثال اختياري) إدراج بيانات الطلب في قاعدة البيانات:
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $_SESSION['id'], $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();

        // مسح سلة المنتجات بعد نجاح الدفع
        $stmt_clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt_clear->bind_param("i", $_SESSION['id']);
        $stmt_clear->execute();
        $stmt_clear->close();

        $success_msg = "تمت معالجة الدفع بنجاح! تم دفع " . number_format($total, 2) . " ريال.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معالجة الدفع | متجرك</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f8f9fa;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background: #e4eef7;">
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">متجرك</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">سلة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger">
                <?php echo $error_msg; ?>
            </div>
        <?php elseif (!empty($success_msg)): ?>
            <div class="alert alert-success">
                <?php echo $success_msg; ?>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">العودة للرئيسية</a>
            </div>
        <?php else: ?>
            <!-- إذا وصل المستخدم لهذه الصفحة بدون إرسال بيانات الدفع، يتم إعادة التوجيه أو عرض رسالة -->
            <div class="alert alert-info text-center">
                لا توجد بيانات للدفع
            </div>
            <div class="text-center mt-4">
                <a href="cart.php" class="btn btn-primary">العودة إلى السلة</a>
            </div>
        <?php endif; ?>
    </div>

    
    <!-- Footer Start -->
    <footer>
        <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5 mt-5">
            <div class="row pt-5">
                <!-- القسم الأول: التواصل -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="text-uppercase text-light mb-4">التواصل</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-white ms-3"></i> سوريا - إدلب</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-white ms-3"></i>+963 949 399 738</p>
                    <p><i class="fa fa-envelope text-white ms-3"></i>info@example.com</p>
                    <h6 class="text-uppercase text-white py-2">تابعنا على المنصات الاجتماعية</h6>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-lg btn-dark btn-lg-square me-2" href="#"><i class="bi bi-twitter"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square me-2" href="#"><i class="bi bi-facebook"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square me-2" href="#"><i class="bi bi-linkedin"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square me-2" href="#"><i class="bi bi-instagram"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square me-2" href="#"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <!-- القسم الثاني: روابط مفيدة -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="text-uppercase text-light mb-4">روابط مفيدة</h4>
                    <div class="d-flex flex-column">
                        <a class="text-body mb-2" href="index.php"><i class="fa fa-angle-right text-white ms-2">الصفحة الرئيسية</i></a>
                        <a class="text-body mb-2" href="about.php"><i class="fa fa-angle-right text-white ms-2">حول الموقع</i></a>
                        <a class="text-body mb-2" href="contact.php"><i class="fa fa-angle-right text-white ms-2">تواصل معنا</i></a>
                        <a class="text-body mb-2" href="roles.php"><i class="fa fa-angle-right text-white ms-2">قوانين المتجر</i></a>
                        <a class="text-body mb-2" href="helps.php"><i class="fa fa-angle-right text-white ms-2">المساعدة</i></a>
                        <a class="text-body" href="#"><i class="fa fa-angle-right text-white ms-2"></i></a>
                    </div>
                </div>
                <!-- القسم الثالث: معرض الصور -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="text-uppercase text-light mb-4">معرض الصور للمنتجات</h4>
                    <div class="row mx-n1">
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile3Rbg.png" alt="Gallery 1"></a>
                        </div>
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile2Rbg.png" alt="Gallery 2"></a>
                        </div>
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile1Rbg.png" alt="Gallery 3"></a>
                        </div>
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile4Rbg.png" alt="Gallery 4"></a>
                        </div>
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile5Rbg.png" alt="Gallery 5"></a>
                        </div>
                        <div class="col-4 px-1 mb-2">
                            <a href="#"><img class="w-100" src="images/mobile6Rbg.png" alt="Gallery 6"></a>
                        </div>
                    </div>
                </div>
                <!-- القسم الرابع: النشرة البريدية -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="text-uppercase text-light mb-4">النشرة البريدية</h4>
                    <p class="mb-4">اشترك في النشرة البريدية للمتجر الإلكتروني لتحصل على اخر العروض و المنتجات</p>
                    <div class="w-100 mb-3">
                        <style>
                            /* لحقل الإدخال: الزوايا اليسرى مستديرة، واليمنى حادة */
                            .input-shared {
                                border-radius: 0 25px 25px 0;
                            }

                            /* للزر: الزوايا اليمنى مستديرة، واليسرى حادة */
                            .button-shared {
                                border-radius: 25px 0 0 25px;
                            }
                        </style>
                        <div class="d-flex">
                            <input type="text" class="form-control input-shared" placeholder="أدخل بريدك" />
                            <button class="btn btn-primary button-shared">اشتراك</button>
                        </div>

                    </div>
                    <i>شكرا ل زيارتكم متجرنا</i>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark py-4">
            <p class="mb-0 text-center text-light">&copy; <?= date("Y"); ?> متجر إلكتروني. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
    <!-- Footer End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>