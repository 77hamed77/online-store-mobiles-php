<?php
session_start();
include("php/config.php");

$error_msg = "";
$success_msg = "";

// إنشاء رمز CSRF إذا لم يكن موجوداً مسبقاً
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // التحقق من رمز CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_msg = "فشل التحقق من الهوية. حاول مرة أخرى.";
    } else {
        // استلام المدخلات وتنظيفها
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            $error_msg = "جميع الحقول مطلوبة!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "يرجى إدخال بريد إلكتروني صالح!";
        } elseif (strlen($password) < 6) {
            $error_msg = "يجب أن تكون كلمة المرور أطول من 6 أحرف!";
        } else {
            // استخدام عبارة التحضير لتفادي حقن SQL مع جلب عمود id أيضًا
            $stmt = $conn->prepare("SELECT id, username, email, pass FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // التحقق من كلمة المرور باستخدام password_verify
                    if (password_verify($password, $row['pass'])) {
                        // تخزين بيانات المستخدم في الجلسة بما في ذلك الـ id
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['email'] = $row['email'];
                        $success_msg = "تم تسجيل الدخول بنجاح!";

                        // استخدام معرف المستخدم الذي تم تعيينه حديثاً
                        $userId = $_SESSION['id'];
                        // تحديث تاريخ آخر تسجيل دخول
                        $updateQuery = "UPDATE users SET last_login = NOW() WHERE id = ?";
                        $stmt = $conn->prepare($updateQuery);
                        $stmt->bind_param("i", $userId);
                        $stmt->execute();
                    } else {
                        $error_msg = "البريد الإلكتروني أو كلمة المرور غير صحيحة!";
                    }
                } else {
                    $error_msg = "البريد الإلكتروني أو كلمة المرور غير صحيحة!";
                }
            } else {
                $error_msg = "حدث خطأ ما أثناء عملية تسجيل الدخول، حاول مرة أخرى.";
            }
            // التحقق من صلاحيات المدير: يجب أن يكون المستخدم مسجّل دخول كمدير
            if (isset($_SESSION['email']) || $_SESSION['email'] == 'admin@example.com') {
                header("Location: products.php");
                exit;
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
    <title>تسجيل الدخول | متجر إلكتروني</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            // عرض رسائل الأخطاء والنجاح
            if (!empty($error_msg)) {
                echo "<div class='message error'><p>{$error_msg}</p></div><br>";
            }
            if (!empty($success_msg)) {
                echo "<div class='message success'><p>{$success_msg}</p></div><br>";
                echo "<a href='products.php'><button class='btn'>الانتقال إلى الصفحة الرئيسية للمتجر</button></a>";
            }
            // عرض النموذج فقط إذا لم يكن تسجيل الدخول قد نجح
            if (empty($success_msg)):
            ?>
                <header style="direction: rtl;">تسجيل الدخول</header>
                <form style="direction: rtl;" action="" method="post">
                    <!-- تضمين رمز CSRF -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <div class="field input">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" autocomplete="off" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" id="email" required>
                    </div>

                    <div class="field input">
                        <label for="password">كلمة المرور</label>
                        <input type="password" name="password" autocomplete="off" id="password" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="تسجيل الدخول">
                    </div>

                    <div class="links">
                        ليس لديك حساب؟ <a href="register.php">سجل الآن</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>