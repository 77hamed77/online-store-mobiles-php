<?php
session_start();
include("php/config.php");

// التأكد من أن المستخدم مسجل الدخول وإلا يتم إعادة توجيهه
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// استخدام عبارات التحضير لاسترجاع بيانات المستخدم بأمان
$stmt = $conn->prepare("SELECT id, username, email, pass, profile_pic, last_login FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    // إذا لم يتم العثور على المستخدم، يتم القيام بتسجيل الخروج
    header("Location: php/logout.php");
    exit;
}

$user = $result->fetch_assoc();

// تحديث بيانات الجلسة (اختياري) بناءً على أحدث معلومات من قاعدة البيانات
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];

$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي | المتجر الإلكتروني</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        /* تخصيص ألوان الخلفية والنصوص */
        .custom-navbar {
            color: rgba(76, 68, 182, 0.808) !important;
        }

        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color:rgb(214, 214, 214) !important;
        }

        .custom-navbar .nav-link:hover {
            color: #e0e0e0 !important;
        }

        /* بطاقة الملف الشخصي */
        .profile-container {
            max-width: 400px;
        }

        .profile-pic {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgb(83, 164, 240);
            box-shadow:  0 0 10px 2px rgb(83, 164, 240);
        }
        .bbgg{
            background: -webkit-linear-gradient(top  , rgb(83, 164, 240),rgb(0,0,0),rgb(83, 164, 240));
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- شريط التنقل باستخدام Bootstrap مع تخصيص الألوان -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"> LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="editProfile.php">تعديل الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="index.php">الصفحة الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- قسم البطل (Hero Section) -->
    <section class="hero-section bbgg " style="margin-bottom:20px; padding: 50px;">
        <div class="container text-light">
            <h1 class="display-5 fw-bold">صفحتك الشخصية </h1>
            <p class="lead">يمكنك مشاهدة بياناتك الشخصية هنا و أيضاً يمكنك التعديل عليها و إضافة صورة لك </p>
        </div>
    </section>

    <!-- المحتوى الرئيسي -->
    <main class="d-flex justify-content-center align-items-center my-5">
        <div class="card profile-container shadow-sm">
            <div class="card-body text-center">
                <?php if (!empty($user['profile_pic'])): ?>
                    <img src="uploads/<?= htmlspecialchars($user['profile_pic']); ?>" alt="صورة الملف الشخصي" class="profile-pic mb-3">
                <?php else: ?>
                    <img src="img/default-avatar.png" alt="الصورة الافتراضية" class="profile-pic mb-3">
                <?php endif; ?>
                <h2 class="card-title">مرحباً، <?= htmlspecialchars($user['username']); ?>!</h2>
                <p class="card-text">البريد الإلكتروني: <?= htmlspecialchars($user['email']); ?></p>
                <?php if (!empty($user['last_login'])): ?>
                    <p class="card-text">آخر تسجيل دخول: <?= htmlspecialchars($user['last_login']); ?></p>
                <?php endif; ?>
                <!-- يمكنك إضافة معلومات إضافية هنا -->
            </div>
        </div>
    </main>

    
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
    
    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>