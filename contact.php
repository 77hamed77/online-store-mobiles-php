<?php
// إذا كنت ترغب بمعالجة بيانات النموذج في نفس الصفحة، يمكنك وضع الكود هنا
// أو يمكنك إرسال البيانات إلى ملف آخر (مثلاً send_contact.php)
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اتصل بنا | متجر إلكتروني</title>
    <!-- Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* تنسيق قسم البطل مع خلفية مميزة */
        .contact-header {
            background: url('images/contact-bg.jpg') no-repeat center center/cover;
            position: relative;
            padding: 100px 0;
            text-align: center;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
        }

        /* طبقة تغطية لتحسين تباين النص */
        .contact-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .contact-header h1,
        .contact-header p {
            position: relative;
            z-index: 2;
        }

        /* تنسيق نموذج الاتصال */
        .contact-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">حول</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم البطل (Hero Section) -->
    <header class="contact-header">
        <div class="container">
            <h1 class="display-4">اتصل بنا</h1>
            <p class="lead">نحن هنا للإستماع إليك. شاركنا آرائك واستفساراتك وسنكون سعداء بمساعدتك.</p>
        </div>
    </header>

    <!-- قسم نموذج الاتصال -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <h2 class="mb-4 text-center">أرسل لنا رسالتك</h2>
                        <form action="send_contact.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="أدخل اسمك كاملاً" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="أدخل بريدك الإلكتروني" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="أدخل موضوع الرسالة" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="أدخل رسالتك هنا" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">إرسال الرسالة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- تذييل الصفحة -->
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date("Y"); ?> متجرك. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- تضمين Bootstrap JS Bundle (يشمل Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>