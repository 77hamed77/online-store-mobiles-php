<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قوانين المتجر | متجر إلكتروني</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        /* قسم البطل (Hero Section) */
        .hero-section {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* تنسيق أقسام السياسات */
        .policy-section {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .policy-section h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        .policy-section ul {
            list-style: disc;
            padding-right: 20px;
        }

        .policy-section ul li {
            padding: 5px 0;
        }

        .bbgg {
            background: -webkit-linear-gradient(top, rgb(83, 164, 240), rgb(0, 0, 0), rgb(83, 164, 240));
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link active" href="policy.php">قوانين المتجر</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">حول المتجر</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم البطل -->
    <section class="hero-section bbgg">
        <div class="container">
            <h1 class="display-4 fw-bold">قوانين المتجر</h1>
            <p class="lead">سياسات واضحة لتجربة تسوق ناجحة وصحيحة</p>
        </div>
    </section>

    <!-- محتوى السياسات -->
    <section class="container mb-5">
        <!-- حالات الشراء الصحيحة -->
        <div class="policy-section">
            <h2>حالات الشراء الصحيحة</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">التأكد من صحة المعلومات المدخلة قبل تأكيد الطلب.</li>
                <li class="list-group-item">استخدام وسائل الدفع المعتمدة والآمنة.</li>
                <li class="list-group-item">تقديم معلومات التوصيل الصحيحة والكاملة.</li>
                <li class="list-group-item">تأكيد الطلب من خلال رسالة تأكيد بالبريد الإلكتروني أو الرسائل النصية.</li>
                <li class="list-group-item">اتباع الإرشادات المحددة عند استلام المنتج.</li>
            </ul>
        </div>

        <!-- حالات الشراء الخاطئة -->
        <div class="policy-section">
            <h2>حالات الشراء الخاطئة</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">إدخال معلومات خاطئة أو ناقصة تؤدي إلى فشل عملية التوصيل.</li>
                <li class="list-group-item">استخدام وسائل دفع غير معتمدة أو حدوث خطأ أثناء عملية الدفع.</li>
                <li class="list-group-item">عدم التأكد من مراجعة تفاصيل الطلب قبل تأكيده مما يؤدي إلى أخطاء في المنتجات المطلوبة.</li>
                <li class="list-group-item">محاولة التلاعب بالعروض أو السياسات للحصول على منتجات بطرق غير قانونية.</li>
                <li class="list-group-item">التكرار في إلغاء الطلبات بدون سبب وجيه مما يشكل عبئاً على المتجر.</li>
            </ul>
        </div>

        <!-- سياسة الإرجاع والاستبدال -->
        <div class="policy-section">
            <h2>سياسة الإرجاع والاستبدال</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">يمكن استرجاع أو استبدال المنتجات خلال 14 يومًا من تاريخ الاستلام.</li>
                <li class="list-group-item">يجب أن يكون المنتج بحالة جديدة وغير مستخدمة مع جميع الملحقات الأصلية.</li>
                <li class="list-group-item">يتم استرداد المبلغ وفقًا لوسيلة الدفع التي تم استخدامها في عملية الشراء.</li>
                <li class="list-group-item">بعض المنتجات قد تكون مستثناة من سياسة الاسترجاع حسب نوعها ووصفها عند الشراء.</li>
            </ul>
        </div>
    </section>

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