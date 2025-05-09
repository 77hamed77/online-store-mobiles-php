<?php
// لعرض سلة المنتجات للمستخدم بعد تسجيل دخوله
if (isset($_SESSION['username'])) {
    $name_cart = 'سلة المنتجات';
} else {
    $name_cart = "";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حول الموقع | متجر إلكتروني</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* خلفية قسم البطل مع تأثير صورة تغطي كامل العرض */
        .about-hero {
            background: url('images/about-bg.jpg') no-repeat center center/cover;
            padding: 100px 0;
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        /* تنسيق عنوان الأقسام */
        .section-title {
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* بعض التعديلات الإضافية على الفقرات */
        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        /* تذييل الصفحة */

        .bbgg {
            background: -webkit-linear-gradient(top, rgb(83, 164, 240), rgb(0, 0, 0), rgb(83, 164, 240));
        }
    </style>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- شريط التنقل (اختياري) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">حول</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="help.php">المساعدة</a></li>
                    <li class="nav-item"><a class="nav-link " href="roles.php"> قوانين المتجر</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><?php echo htmlspecialchars($name_cart); ?></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم البطل (Hero Section) -->
    <section class="about-hero bbgg">
        <div class="container">
            <h1 class="display-4">من نحن</h1>
            <p class="lead">نحن نقدم أفضل تجربة تسوق إلكتروني تجمع بين الجودة والابتكار.</p>
        </div>
    </section>

    <!-- محتوى الصفحة -->
    <section class="about-content">
        <div class="container">
            <div class="row align-items-center">
                <!-- صورة توضيحية -->
                <div class="col-md-6 mb-4">
                    <img src="images/bg_5.jpeg" class="img-fluid rounded my-5" style="width: 550px;height:550px" alt="حول موقعنا">
                </div>
                <!-- تفاصيل حول الشركة -->
                <div class="col-md-6 " style="margin-top:-50px ;">
                    <h2 class="section-title">قصتنا</h2>
                    <p>بدأت رحلتنا منذ عدة سنوات بهدف تقديم حلول مبتكرة في عالم التجارة الإلكترونية. نمزج بين خدمة العملاء الفريدة والتكنولوجيا المتطورة لنضمن لك تجربة تسوق لا تُنسى.</p>
                    <h3 class="section-title">مهمتنا</h3>
                    <p>نسعى إلى تمكينك من الحصول على أفضل المنتجات بأعلى مستويات الجودة مع توفير تجربة شراء سلسة ومميزة.</p>
                    <h3 class="section-title">رؤيتنا</h3>
                    <p>نسعى لأن نكون الخيار الأول والرائد في مجال التجارة الإلكترونية وأن نبتكر باستمرار لنواكب احتياجات السوق وتطلعات العملاء.</p>
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