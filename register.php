<?php
include("php/config.php");
session_start();

// إنشاء رمز CSRF إذا لم يكن موجوداً
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$username   = "";
$email      = "";
$error_msg  = "";
$success_msg = "";

// التحقق من أن الطلب من نوع POST وأن الزر "submit" قد تم الضغط عليه
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // التحقق من صحة رمز CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_msg = "فشل التحقق من الهوية. الرجاء إعادة تحميل الصفحة والمحاولة مرة أخرى.";
    } else {
        // استلام وتنظيف المدخلات
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        // التحقق من ملأ جميع الحقول
        if (empty($username) || empty($email) || empty($password)) {
            $error_msg = "جميع الحقول مطلوبة!";
        } 
        // التحقق من طول كلمة المرور
        elseif (strlen($password) < 6) {
            $error_msg = "يجب أن تتجاوز كلمة المرور 6 أحرف!";
        } 
        // التحقق من صحة البريد الإلكتروني
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "يرجى إدخال بريد إلكتروني صالح!";
        } 
        else {
            // التحقق مما إذا كان البريد الإلكتروني موجود مسبقاً باستخدام عبارة التحضير
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result(); // لتخزين عدد السجلات
            if ($stmt->num_rows > 0) {
                $error_msg = "هذا البريد مستخدم مسبقاً، يرجى اختيار بريد آخر!";
            } else {
                // تجزئة كلمة المرور قبل التخزين
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // إدراج بيانات المستخدم الجديد باستخدام عبارة التحضير
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO users(username, email, pass) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                if ($stmt->execute()) {
                    $success_msg = "تم التسجيل بنجاح! يمكنك الآن <a href='login.php'>تسجيل الدخول</a>.";
                    // يمكنك حذف رمز CSRF بعد النجاح، أو إعادة توليده
                    unset($_SESSION['csrf_token']);
                } else {
                    $error_msg = "حدث خطأ أثناء التسجيل. الرجاء المحاولة مرة أخرى.";
                }
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>تسجيل جديد | متجر إلكتروني</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header style="direction: rtl;">تسجيل جديد : </header>

            <?php
            // عرض رسائل الخطأ والنجاح
            if (!empty($error_msg)) {
                echo "<div class='message error'><p>$error_msg</p></div>";
            }
            if (!empty($success_msg)) {
                echo "<div class='message success'><p>$success_msg</p></div>";
            }
            ?>

            <!-- عرض النموذج فقط إذا لم يكن التسجيل موفقاً -->
            <?php if (empty($success_msg)) : ?>
            <form action="" method="post" style="direction: rtl;">
                <!-- تضمين رمز CSRF -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                
                <div class="field input">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" autocomplete="off" value="<?= htmlspecialchars($username) ?>" id="username" required>
                </div>

                <div class="field input">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" autocomplete="off" value="<?= htmlspecialchars($email) ?>" id="email" required>
                </div>

                <div class="field input">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" autocomplete="off" id="password" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="تسجيل جديد">
                </div>

                <div class="links">
                    لديك حساب مسبقاً؟ <a href="login.php">تسجيل الدخول</a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
