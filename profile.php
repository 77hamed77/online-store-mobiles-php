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
            background-color: rgba(76, 68, 182, 0.808) !important;
        }

        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color: #FFFFFF !important;
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
            border: 2px solid rgba(76, 68, 182, 0.808);
        }
    </style>
</head>

<body>
    <!-- شريط التنقل باستخدام Bootstrap مع تخصيص الألوان -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="editProfile.php">تعديل الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الصفحة الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>