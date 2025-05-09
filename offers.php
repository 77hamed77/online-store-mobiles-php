<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عروضنا | متجر إلكتروني</title>
    <!-- Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- أيقونات Bootstrap (اختياري) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* تنسيق عنوان الصفحة */
        .hero-section {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 60px 0;
            text-align: center;
        }

        /* تنسيق البطاقات */
        .offer-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
        }

        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .offer-img {
            height: 200px;
            object-fit: cover;
        }

        /* تنسيق شارة الخصم */
        .offer-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 5px;
            z-index: 10;
        }

        .offer-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .bbgg{
            background: -webkit-linear-gradient(top  , rgb(83, 164, 240),rgb(0,0,0),rgb(83, 164, 240));
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
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="offers.php">عروض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">حول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">تواصل معنا</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم البطل (Hero Section) -->
    <section class="hero-section bbgg">
        <div class="container">
            <h1 class="display-5 fw-bold">عروض مميزة</h1>
            <p class="lead">استفد من خصومات حصرية على أفضل المنتجات لفترة محدودة!</p>
        </div>
    </section>

    <!-- قسم العروض -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- بطاقة العرض 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 30%</span>
                        <img src="images/mobile1Rbg.png" class="card-img-top offer-img" alt="عرض 1">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 1</h5>
                            <p class="card-text">احصل على هذا المنتج بأفضل سعر مع خصم 30% لفترة محدودة.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
                <!-- بطاقة العرض 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 40%</span>
                        <img src="images/mobile2Rbg.png" class="card-img-top offer-img" alt="عرض 2">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 2</h5>
                            <p class="card-text">استفد من العرض الحصري على هذا المنتج المميز. العرض سارٍ لفترة قصيرة.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
                <!-- بطاقة العرض 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 25%</span>
                        <img src="images/mobile3Rbg.png" class="card-img-top offer-img" alt="عرض 3">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 3</h5>
                            <p class="card-text">لا تفوت فرصة الحصول على هذا العرض المذهل الذي يقدم خصم 25%.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- صف آخر من العروض (مثال إضافي) -->
            <div class="row">
                <!-- بطاقة العرض 4 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 35%</span>
                        <img src="images/mobile4Rbg.png" class="card-img-top offer-img" alt="عرض 4">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 4</h5>
                            <p class="card-text">تمتع بعرض مميز مع خصم 35% على أحدث إصداراتنا.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
                <!-- بطاقة العرض 5 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 50%</span>
                        <img src="images/mobile5Rbg.png" class="card-img-top offer-img" alt="عرض 5">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 5</h5>
                            <p class="card-text">انتهز الفرصة وحقق أكبر توفير مع خصم استثنائي يصل إلى 50%.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
                <!-- بطاقة العرض 6 -->
                <div class="col-md-4 mb-4">
                    <div class="card position-relative offer-card">
                        <span class="offer-badge">خصم 20%</span>
                        <img src="images/mobile6Rbg.png" class="card-img-top offer-img" alt="عرض 6">
                        <div class="card-body">
                            <h5 class="card-title offer-title">منتج مميز 6</h5>
                            <p class="card-text">احصل على هذا المنتج المميز مع توفير يصل إلى 20% لفترة محدودة.</p>
                            <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
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
                        <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white ms-2"></i> Private Policy</a>
                        <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white ms-2"></i> Term & Conditions</a>
                        <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white ms-2"></i> New Member Registration</a>
                        <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white ms-2"></i> Affiliate Programme</a>
                        <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white ms-2"></i> Return & Refund</a>
                        <a class="text-body" href="#"><i class="fa fa-angle-right text-white ms-2"></i> Help & FAQs</a>
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
            <p class="mb-0 text-light text-center">&copy; <?= date("Y"); ?> متجر إلكتروني. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>