<?php
// التحقق من أن الطلب تم عبر POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال المدخلات وتنظيفها
    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    $error   = "";
    $success = "";

    // التحقق من ملء كافة الحقول
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "يرجى ملء جميع الحقول بشكل صحيح.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "يرجى إدخال بريد إلكتروني صالح.";
    } else {
        // إعداد معطيات الرسالة (يمكنك تغيير البريد المستقبل هنا)
        $to      = "your-email@example.com"; // قم بتعديل البريد إلى بريد المستلم الصحيح
        $headers = "From: " . $email . "\r\n" .
            "Reply-To: " . $email . "\r\n" .
            "Content-Type: text/plain; charset=utf-8\r\n";
        $body    = "الاسم: " . $name . "\n" .
            "البريد الإلكتروني: " . $email . "\n" .
            "الموضوع: " . $subject . "\n\n" .
            "الرسالة:\n" . $message;

        // محاولة إرسال الرسالة عبر دالة mail (يمكنك تفعيل وتحسين هذا الجزء حسب إعدادات الخادم)
        if (mail($to, $subject, $body, $headers)) {
            $success = "تم إرسال رسالتك بنجاح! سنقوم بالرد عليك في أقرب وقت.";
        } else {
            $error = "حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى لاحقاً.";
        }
    }
} else {
    // في حال الوصول إلى الصفحة بدون إرسال بيانات النموذج، نقوم بإعادة التوجيه إلى صفحة الاتصال
    header("Location: contact.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إرسال الرسالة | متجر إلكتروني</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .message-box {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل (يمكنك تعديل الروابط حسب موقعك) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">LOGO</a>
        </div>
    </nav>

    <div class="container message-box">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $error; ?>
            </div>
            <div class="text-center">
                <a href="contact.php" class="btn btn-secondary">العودة إلى صفحة الاتصال</a>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $success; ?>
            </div>
            <div class="text-center">
                <a href="index.php" class="btn btn-primary">العودة إلى الصفحة الرئيسية</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>