<?php
session_start();
include("php/config.php");
// لإضافة اسم المستخدم في رأس الصفحة بعد تسجيل دخوله 
if (isset($_SESSION['username'])) {
    $username = "مرحباً " . $_SESSION['username'];
} else {
    $username = "تسجيل الدخول";
}
// لعرض سلة المنتجات للمستخدم بعد تسجيل دخوله
if (isset($_SESSION['username'])) {
    $name_cart = 'سلة المنتجات';
} else {
    $name_cart = "";
}
// عرض ملف المستخدم الشخصي بعد قيامه بستجيل الدخول 
if (isset($_SESSION['username'])) {
    $name_profile = "الصفحة الشخصية";
} else {
    $name_profile = "";
}
// عرض تسجيل الخروج للمستخدم بعد قيامه بعملية تسجيل الدخول 
if (isset($_SESSION['username'])) {
    $name_logout = 'تسجيل الخروج';
} else {
    $name_logout = "";
}
// استعلام لاسترجاع جميع المنتجات (يمكنك تعديل الاستعلام مع شروط أو ترتيب كما تشاء)
$stmt = $conn->prepare("SELECT id, name, description, price, image FROM products ORDER BY id DESC");
$stmt->execute();
$products_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية | متجر إلكتروني</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-p0vh/tEYSnG/QKoqmRX6Z4xgAE0TCJf9q2yzflP8uDzA9cifFOJCBa0L+Tv67gO2HGl6ETP7ZxgzGRcy2Mif2g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background: #FFFFFF;
        }

        .product-card {
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body dir="rtl">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- ms-auto : english | me-auto : arabic -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">عروض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">حول</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<a class='nav-link' href='#'> " . htmlspecialchars($username) . "</a>";
                        } else {
                            echo "<a class='nav-link' href='login.php'> " . htmlspecialchars($username) . "</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><?php echo htmlspecialchars($name_cart); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><?php echo htmlspecialchars($name_profile); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php"><?php echo htmlspecialchars($name_logout); ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container my-4">
        <!DOCTYPE html>
        <html lang="ar">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>الصفحة الرئيسية | متجر إلكتروني</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="css/style.css">
        </head>

        <body dir="rtl">
            <!-- باقي أجزاء الصفحة مثل الـ Navbar ... -->

            <!-- Hero Section - Carousel -->
            <div class="container my-4">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="الشريحة 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                            aria-label="الشريحة 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                            aria-label="الشريحة 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/bg_1_carousel.png" class="d-block w-100" alt="الشريحة الأولى">
                            <div class="carousel-caption d-none d-md-block text-success">
                                <h5>✨ اكتشف التكنولوجيا المتطورة بين يديك! ✨ هل تبحث عن الأداء العالي والتصميم الأنيق في جهاز واحد؟ نقدم لك مجموعة من أفضل الأجهزة الذكية التي تجمع بين السرعة، الأناقة، والابتكار لتلبية احتياجاتك اليومية.</h5>
                                <p>🔹 شاشة مذهلة توفر تجربة مشاهدة لا مثيل لها. 🔹 تصميم عصري يجمع بين القوة والراحة في الاستخدام. 🔹 أداء قوي لمواكبة مهامك اليومية بسرعة وكفاءة.
                                    💡 لا تفوّت الفرصة! احصل على جهازك الآن واستمتع بتجربة متطورة في عالم التكنولوجيا.</p>
                            </div>
                            
                        </div>
                        <div class="carousel-item">
                            <img src="images/bg_2_carousel.png" class="d-block w-100" alt="الشريحة الثانية">
                            <div class="carousel-caption d-none d-md-block text-light">
                                <h5>✨ اكتشف التكنولوجيا المتطورة بين يديك! ✨ هل تبحث عن الأداء العالي والتصميم الأنيق في جهاز واحد؟ نقدم لك مجموعة من أفضل الأجهزة الذكية التي تجمع بين السرعة، الأناقة، والابتكار لتلبية احتياجاتك اليومية.</h5>
                                <p>🔹 شاشة مذهلة توفر تجربة مشاهدة لا مثيل لها. 🔹 تصميم عصري يجمع بين القوة والراحة في الاستخدام. 🔹 أداء قوي لمواكبة مهامك اليومية بسرعة وكفاءة.
                                    💡 لا تفوّت الفرصة! احصل على جهازك الآن واستمتع بتجربة متطورة في عالم التكنولوجيا.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/bg_3_carousel.png" class="d-block w-100" alt="الشريحة الثالثة">
                            <div class="carousel-caption d-none d-md-block text-dark">
                                <h5>✨ اكتشف التكنولوجيا المتطورة بين يديك! ✨ هل تبحث عن الأداء العالي والتصميم الأنيق في جهاز واحد؟ نقدم لك مجموعة من أفضل الأجهزة الذكية التي تجمع بين السرعة، الأناقة، والابتكار لتلبية احتياجاتك اليومية.</h5>
                                <p>🔹 شاشة مذهلة توفر تجربة مشاهدة لا مثيل لها. 🔹 تصميم عصري يجمع بين القوة والراحة في الاستخدام. 🔹 أداء قوي لمواكبة مهامك اليومية بسرعة وكفاءة.
                                    💡 لا تفوّت الفرصة! احصل على جهازك الآن واستمتع بتجربة متطورة في عالم التكنولوجيا.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>
            </div>
    </div>
    <style>
        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3E%3Cpath d='M4.854 0.146a.5.5 0 1 0-.708.708L6.293 3H0.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 1 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3z'/%3E%3C/svg%3E");
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3E%3Cpath d='M4.854 0.146a.5.5 0 1 0-.708.708L6.293 3H0.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 1 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3z'/%3E%3C/svg%3E");
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23000' viewBox='0 0 8 8'%3E%3Cpath d='M4.854 0.146a.5.5 0 1 0-.708.708L6.293 3H0.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 1 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3z'/%3E%3C/svg%3E");
            /* عكس السهم أفقيًا */
            transform: scaleX(-1);
        }
    </style>

    <!-- Products Grid -->
    <div class="container my-4">
        <div class="row">
            <?php if ($products_result->num_rows > 0): ?>
                <?php while ($product = $products_result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100">
                            <?php if (!empty($product['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($product['image']); ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product['name']); ?>">
                            <?php else: ?>
                                <img src="img/default-product.png" class="card-img-top product-img" alt="صورة افتراضية">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars(mb_substr($product['description'], 0, 100)); ?>...</p>
                                <p class="card-text fw-bold"><?= number_format($product['price'], 2); ?> ريال</p>
                                <a href="product.php?id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-primary mt-auto">المزيد</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">لا توجد منتجات متاحة حالياً.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <!-- <footer class="bg-dark text-light text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y"); ?> متجرك. جميع الحقوق محفوظة.</p>
        </div>
    </footer> -->

    <!-- Footer Start -->
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
            <p class="mb-0 text-center text-light">&copy; <a href="#" class="text-light text-decoration-none">Hamid Muhammed</a>. All Rights Reserved.</p>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>