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
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- يمكنك استبدال ملف النمط بآخر خاص بالملف الشخصي إن رغبت -->
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>الملف الشخصي | المتجر الإلكتروني</title>
    <style>
        /* بعض التعديلات البسيطة للمظهر */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #f3f3f3;
        }
        .nav .logo p {
            font-size: 1.5em;
            font-weight: bold;
        }
        .right-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #333;
        }
        .right-links .btn {
            padding: 5px 10px;
            cursor: pointer;
        }
        main {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .profile-container {
            text-align: center;
            max-width: 400px;
            width: 100%;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .profile-pic {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #333;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Logo</p>
        </div>
        <div class="right-links">
            <a href="editProfile.php">تعديل الملف الشخصي</a>
            <a href="php/logout.php"><button class="btn">تسجيل الخروج</button></a>
        </div>
    </div>

    <main>
        <div class="profile-container">
            <?php if (!empty($user['profile_pic'])): ?>
                <img src="uploads/<?= htmlspecialchars($user['profile_pic']) ?>" alt="صورة الملف الشخصي" class="profile-pic">
            <?php else: ?>
                <img src="img/default-avatar.png" alt="الصورة الافتراضية" class="profile-pic">
            <?php endif; ?>

            <h1>مرحباً، <?= htmlspecialchars($user['username']); ?>!</h1>
            <p>البريد الإلكتروني: <?= htmlspecialchars($user['email']); ?></p>
            <?php if (!empty($user['last_login'])): ?>
                <p>آخر تسجيل دخول: <?= htmlspecialchars($user['last_login']); ?></p>
            <?php endif; ?>
            <!-- يمكنك إضافة معلومات إضافية مثل تاريخ الانضمام وغيرها هنا -->
        </div>
    </main>
</body>
</html>
