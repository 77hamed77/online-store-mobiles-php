<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// إنشاء رمز CSRF إذا لم يكن موجوداً بالفعل
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_msg   = "";
$success_msg = "";

// استرجاع بيانات المستخدم الحالية من قاعدة البيانات مع عمود كلمة المرور للتحقق إذا احتاج التحديث
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT username, email, pass, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $currentUsername   = $user['username'];
    $currentEmail      = $user['email'];
    $currentHash       = $user['pass']; // التجزئة الحالية لكلمة المرور
    $currentProfilePic = $user['profile_pic'];
} else {
    header("Location: php/logout.php");
    exit;
}
$stmt->close();

// عند تقديم النموذج لتحديث البيانات
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // التحقق من رمز CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_msg = "فشل التحقق من الهوية. حاول مرة أخرى.";
    } else {
        // استلام وتنظيف المدخلات
        $username         = trim($_POST['username']);
        $email            = trim($_POST['email']);
        $current_password = trim($_POST['current_password']); // لفحص كلمة المرور الحالية في حال رغبة التغيير
        $new_password     = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        // التحقق من صحة الحقول الأساسية
        if (empty($username) || empty($email)) {
            $error_msg = "يجب ملء اسم المستخدم والبريد الإلكتروني!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "يرجى إدخال بريد إلكتروني صالح!";
        } else {
            // إذا حاول المستخدم تغيير كلمة المرور (أي إذا أدخل قيمة في أحد حقول تغيير كلمة المرور)
            if (!empty($new_password) || !empty($confirm_password)) {
                // يجب تعبئة الحقل الخاص بكلمة المرور الحالية للتحقق
                if (empty($current_password)) {
                    $error_msg = "يرجى إدخال كلمة المرور الحالية لتحديث كلمة المرور.";
                } elseif (empty($new_password) || empty($confirm_password)) {
                    $error_msg = "يرجى تعبئة كلمة المرور الجديدة وتأكيدها.";
                } elseif (strlen($new_password) < 6) {
                    $error_msg = "يجب أن تكون كلمة المرور الجديدة 6 أحرف على الأقل!";
                } elseif ($new_password !== $confirm_password) {
                    $error_msg = "كلمة المرور الجديدة وتأكيدها غير متطابقتين!";
                } else {
                    // التحقق من صحة كلمة المرور الحالية مقابل المخزنة (بعد التجزئة)
                    if (!password_verify($current_password, $currentHash)) {
                        $error_msg = "كلمة المرور الحالية غير صحيحة!";
                    }
                }
            }
            
            // إذا لم تحدث أي أخطاء ننتقل لمعالجة رفع الصورة وتحديث البيانات
            if (empty($error_msg)) {
                //----- بدء معالجة رفع الصورة -----
                // تعيين اسم الصورة إلى الموجود مسبقاً
                $profile_pic_name = $currentProfilePic;
                // التأكد من وجود تحميل لملف الصورة
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                    $file_tmp  = $_FILES['profile_pic']['tmp_name'];
                    $file_name = $_FILES['profile_pic']['name'];
                    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    
                    // تحديد الامتدادات المسموح بها
                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (in_array($file_ext, $allowed_ext)) {
                        // إعطاء اسم فريد للصورة وتحديد مسار التخزين
                        $new_file_name = uniqid("IMG_", true) . "." . $file_ext;
                        $destination   = "uploads/" . $new_file_name;
                        
                        if (move_uploaded_file($file_tmp, $destination)) {
                            $profile_pic_name = $new_file_name;
                        } else {
                            $error_msg = "حدث خطأ أثناء تحميل الصورة.";
                        }
                    } else {
                        $error_msg = "صيغة الصورة غير مدعومة! الصيغ المسموحة: jpg, jpeg, png, gif.";
                    }
                }
                //----- نهاية معالجة رفع الصورة -----
                if (empty($error_msg)) {
                    // تحديث بيانات المستخدم مع أو بدون تغيير كلمة المرور
                    if (!empty($new_password)) {
                        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, pass = ?, profile_pic = ? WHERE id = ?");
                        $stmt->bind_param("ssssi", $username, $email, $hashed_new_password, $profile_pic_name, $user_id);
                    } else {
                        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, profile_pic = ? WHERE id = ?");
                        $stmt->bind_param("sssi", $username, $email, $profile_pic_name, $user_id);
                    }
    
                    if ($stmt->execute()) {
                        $success_msg = "تم تحديث بياناتك بنجاح!";
                        // تحديث بيانات الجلسة
                        $_SESSION['username'] = $username;
                        $_SESSION['email']    = $email;
                    } else {
                        $error_msg = "حدث خطأ أثناء تحديث البيانات. حاول مرة أخرى.";
                    }
                    $stmt->close();
                }
            }
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
    <title>تعديل الملف الشخصي | متجر إلكتروني</title>
    <link rel="stylesheet" href="css/styleLogin.css">
</head>
<body style="direction: rtl;">
    <div class="nav">
        <div class="logo">
            <p><a href="profile.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="editProfile.php">تعديل الملف الشخصي</a>
            <a href="php/logout.php"><button class="btn">تسجيل الخروج</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php
            if (!empty($error_msg)) {
                echo "<div class='message error'><p>" . htmlspecialchars($error_msg) . "</p></div><br>";
            }
            if (!empty($success_msg)) {
                echo "<div class='message success'><p>" . htmlspecialchars($success_msg) . "</p></div><br>";
                echo "<a href='profile.php'><button class='btn'>الانتقال إلى الملف الشخصي</button></a>";
            }
            if (empty($success_msg)):
            ?>
            <header>تعديل الملف الشخصي</header>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- تضمين رمز CSRF -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
    
                <div class="field input">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" autocomplete="off" id="username" value="<?= htmlspecialchars($currentUsername); ?>" required>
                </div>
    
                <div class="field input">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" autocomplete="off" id="email" value="<?= htmlspecialchars($currentEmail); ?>" required>
                </div>
    
                <div class="field input">
                    <label for="profile_pic">صورة الملف الشخصي</label>
                    <input type="file" name="profile_pic" id="profile_pic" accept="image/*">
                </div>
    
                <hr style="margin: 20px 0;">
                <p style="text-align: center;">إذا كنت ترغب في تغيير كلمة المرور، يرجى تعبئة الحقول التالية</p>
    
                <div class="field input">
                    <label for="current_password">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" autocomplete="off" id="current_password" placeholder="أدخل كلمة المرور الحالية">
                </div>
    
                <div class="field input">
                    <label for="new_password">كلمة المرور الجديدة</label>
                    <input type="password" name="new_password" autocomplete="off" id="new_password" placeholder="أدخل كلمة المرور الجديدة">
                </div>
    
                <div class="field input">
                    <label for="confirm_password">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="confirm_password" autocomplete="off" id="confirm_password" placeholder="أعد إدخال كلمة المرور الجديدة">
                </div>
    
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="تحديث">
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
