<?php
session_start();
include("../php/config.php"); // تأكد من وجود ملف الاتصال بقاعدة البيانات

// التحقق من صلاحيات المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// استعلام لاسترجاع كافة الطلبات من جدول orders وترتيبها حسب تاريخ الإنشاء (الأحدث أولاً)
$query  = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $query) or die("حدث خطأ أثناء استرجاع الطلبات");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات | لوحة الإدارة</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table-responsive {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav"
                aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_product.php">إدارة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_orders.php">الطلبات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="admin_users.php">إدارة المستخدمين</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="admin_contact.php">إدارة رسائل الإتصال</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout.php">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="container">
        <h2 class="text-center mb-4">إدارة الطلبات</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>معرّف المستخدم</th>
                        <th>الإجمالي</th>
                        <th>تاريخ الطلب</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <!-- أمثلة على أزرار الإجراءات؛ يمكنك تعديلها حسب الحاجة -->
                                <a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">عرض</a>
                                <a href="delete_order.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                    حذف
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
    
    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>