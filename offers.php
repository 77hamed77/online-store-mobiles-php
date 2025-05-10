<?php
// استدعاء ملف الإعدادات للاتصال بقاعدة البيانات
include("php/config.php");

// استعلام لاسترجاع كافة العروض من جدول offers وترتيبها حسب تاريخ الإنشاء (الأحدث أولاً)
$query  = "SELECT * FROM offers ORDER BY created_at DESC";
$result = mysqli_query($conn, $query) or die("حدث خطأ أثناء استرجاع العروض: " . mysqli_error($conn));
?>
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
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* تنسيق قسم البطل */
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
            position: relative;
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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card position-relative offer-card">
                            <!-- شارة الخصم -->
                            <span class="offer-badge">خصم <?php echo htmlspecialchars($row['discount']); ?>%</span>
                            <!-- صورة المنتج -->
                            <img src="<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top offer-img" alt="<?php echo htmlspecialchars($row['offer_name']); ?>">
                            <div class="card-body">
                                <!-- عنوان العرض -->
                                <h5 class="card-title offer-title"><?php echo htmlspecialchars($row['offer_name']); ?></h5>
                                <!-- وصف العرض -->
                                <p class="card-text"><?php echo htmlspecialchars($row['offer_description']); ?></p>
                                <a href="#" class="btn btn-primary">تعرف على المزيد</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>