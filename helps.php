<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مساعدة المتجر | متجر إلكتروني</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        /* قسم البطل (Hero Section) */
        .hero-section {
            background: linear-gradient(135deg, #28a745, #218838);
            color: #fff;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 40px;
        }

        /* تنسيق العناوين داخل قسم المساعدة */
        .help-section h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        /* تنسيق أكورديون المساعدة */
        .accordion-item {
            border: none;
            margin-bottom: 10px;
        }

        .accordion-button {
            background-color: #fff;
            color: #333;
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e9ecef;
        }

        .bbgg {
            background: -webkit-linear-gradient(top, rgb(83, 164, 240), rgb(0, 0, 0), rgb(83, 164, 240));
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="background: #e4eef7;">
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">متجرك</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">حول المتجر</a></li>
                    <li class="nav-item"><a class="nav-link active" href="help.php">المساعدة</a></li>
                    <li class="nav-item"><a class="nav-link " href="roles.php"> قوانين المتجر</a></li>    
                    <li class="nav-item"><a class="nav-link" href="contact.php">اتصل بنا</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم البطل -->
    <section class="hero-section bbgg">
        <div class="container">
            <h1 class="display-4 fw-bold">مركز المساعدة</h1>
            <p class="lead">تعرف على كيفية إجراء عملية الشراء بشكل صحيح وتجنب الأخطاء الشائعة.</p>
        </div>
    </section>

    <!-- قسم محتوى المساعدة (أكورديون) -->
    <section class="container help-section mb-5">
        <div class="accordion" id="helpAccordion">
            <!-- كيفية الشراء الصحيح -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCorrect">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCorrect" aria-expanded="true" aria-controls="collapseCorrect">
                        كيفية الشراء الصحيح
                    </button>
                </h2>
                <div id="collapseCorrect" class="accordion-collapse collapse show" aria-labelledby="headingCorrect" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <li class="list-group-item">التأكد من صحة بياناتك الشخصية ومعلومات التوصيل قبل تأكيد الطلب.</li>
                            <li class="list-group-item">اختيار وسيلة الدفع الآمنة والمعتمدة لدى المتجر.</li>
                            <li class="list-group-item">قراءة الشروط والأحكام وسياسات الإرجاع والاستبدال.</li>
                            <li class="list-group-item">مراجعة تفاصيل الطلب والتأكد من الكميات والعروض المطبقة قبل الدفع.</li>
                            <li class="list-group-item">الحصول على تأكيد الطلب عبر البريد الإلكتروني أو الرسائل النصية.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- الأخطاء الشائعة وكيفية تجنبها -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingWrong">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseWrong" aria-expanded="false" aria-controls="collapseWrong">
                        الأخطاء الشائعة وكيفية تجنبها في الشراء
                    </button>
                </h2>
                <div id="collapseWrong" class="accordion-collapse collapse" aria-labelledby="headingWrong" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <li class="list-group-item">إدخال بيانات ناقصة أو خاطئة تؤدي إلى تأخير التوصيل أو إلغاء الطلب.</li>
                            <li class="list-group-item">استخدام وسائل دفع غير آمنة أو غير معتمدة مما قد يؤدي إلى مشاكل مالية.</li>
                            <li class="list-group-item">عدم مراجعة تفاصيل الطلب قبل التأكيد مما يؤدي إلى طلب منتجات أو كميات غير مرغوبة.</li>
                            <li class="list-group-item">عدم قراءة معلومات العروض والخصومات مما يفوت الاستفادة من أفضل الأسعار.</li>
                            <li class="list-group-item">إهمال التواصل مع خدمة العملاء عند وجود شكوك أو استفسارات قبل إتمام عملية الشراء.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- سياسات الدفع والإرجاع -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPayment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePayment" aria-expanded="false" aria-controls="collapsePayment">
                        سياسات الدفع والإرجاع
                    </button>
                </h2>
                <div id="collapsePayment" class="accordion-collapse collapse" aria-labelledby="headingPayment" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <ul class="list-group">
                            <li class="list-group-item">يتم قبول الدفع بواسطة البطاقات الائتمانية والتحويل البنكي والوسائل الإلكترونية الآمنة.</li>
                            <li class="list-group-item">يحق لك إلغاء الطلب أو تعديله قبل بدء عملية الشحن وفق الشروط المحددة من قبل المتجر.</li>
                            <li class="list-group-item">يمكنك استبدال أو إرجاع المنتجات خلال فترة محددة بعد الاستلام بشرط أن تكون في حالة جديدة وغير مستخدمة.</li>
                            <li class="list-group-item">يرجى مراجعة سياسة الإرجاع والاستبدال الخاصة بكل منتج قبل الشراء للتأكد من توافقها مع احتياجاتك.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="alert alert-info text-center">
        يمكنك التواصل معنا لنساعدك في حل مشكلتك
    </div>
    <div class="text-center mt-4">
        <a href="contact.php" class="btn btn-primary">تواصل معنا</a>
    </div>
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