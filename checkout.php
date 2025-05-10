<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

// استعلام لاسترجاع عناصر السلة للمستخدم مع بيانات المنتج
$stmt = $conn->prepare("SELECT 
    c.quantity,
    p.name,
    p.price,
    p.image 
FROM cart c 
JOIN products p ON c.product_id = p.id 
WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الدفع | متجرك</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .payment-card,
        .summary-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }

        .card-title {
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>

<body dir="rtl" style="background: #e4eef7;">
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">LOGO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item "><a class="nav-link active" href="checkout.php">صفحة الدفع</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">سلة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <!-- عمود ملخص الطلب -->
            <div class="col-md-6 mb-4">
                <div class="card summary-card p-4">
                    <h4 class="card-title mb-3">ملخص الطلب</h4>
                    <?php if (!empty($cart_items)): ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($cart_items as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                        <small>الكمية: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <span><?php echo number_format($item['price'] * $item['quantity'], 2); ?> ريال</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-flex justify-content-between">
                            <strong>الإجمالي الكلي:</strong>
                            <strong><?php echo number_format($total, 2); ?> ريال</strong>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">السلة فارغة</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- عمود تفاصيل الدفع -->
            <div class="col-md-6">
                <div class="card payment-card p-4">
                    <h4 class="card-title mb-3">تفاصيل الدفع</h4>
                    <form action="process_payment.php" method="post">
                        <div class="mb-3">
                            <label for="cardname" class="form-label">اسم صاحب البطاقة</label>
                            <input type="text" class="form-control" id="cardname" name="cardname" placeholder="أدخل اسم صاحب البطاقة" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardnumber" class="form-label">رقم البطاقة</label>
                            <input type="text" class="form-control" id="cardnumber" name="cardnumber" placeholder="أدخل رقم البطاقة" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="expdate" class="form-label">تاريخ الإنتهاء</label>
                                <input type="text" class="form-control" id="expdate" name="expdate" placeholder="MM/YY" required>
                            </div>
                            <div class="col">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="أدخل CVV" required>
                            </div>
                        </div>
                        <!-- حقل مخفي لنقل إجمالي السعر -->
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <button type="submit" class="btn btn-primary w-100">ادفع الآن</button>
                    </form>
                </div>
            </div>
        </div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>