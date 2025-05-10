<?php
session_start();
include("../php/config.php");

// التحقق من صلاحية المدير
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// استعلام لحساب مبيعات اليوم (باستخدام الـ CURDATE())
$queryDaily = "SELECT IFNULL(SUM(total),0) AS daily_total FROM orders WHERE DATE(created_at) = CURDATE()";
$resultDaily = mysqli_query($conn, $queryDaily) or die("Error fetching daily sales: " . mysqli_error($conn));
$dailyData = mysqli_fetch_assoc($resultDaily);
$daily_sales = $dailyData['daily_total'];

// استعلام لحساب مبيعات الأسبوع (باستخدام YEARWEEK مع نمط ISO)
$queryWeekly = "SELECT IFNULL(SUM(total),0) AS weekly_total FROM orders WHERE YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)";
$resultWeekly = mysqli_query($conn, $queryWeekly) or die("Error fetching weekly sales: " . mysqli_error($conn));
$weeklyData = mysqli_fetch_assoc($resultWeekly);
$weekly_sales = $weeklyData['weekly_total'];

// استعلام لحساب مبيعات الشهر (أي الطلبات التي تمت في نفس شهر وسنة اليوم)
$queryMonthly = "SELECT IFNULL(SUM(total),0) AS monthly_total FROM orders WHERE YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())";
$resultMonthly = mysqli_query($conn, $queryMonthly) or die("Error fetching monthly sales: " . mysqli_error($conn));
$monthlyData = mysqli_fetch_assoc($resultMonthly);
$monthly_sales = $monthlyData['monthly_total'];

// استعلام لحساب إجمالي عدد الطلبات (لكل الفترة)
$queryTotal = "SELECT COUNT(*) AS total_orders FROM orders";
$resultTotal = mysqli_query($conn, $queryTotal) or die("Error fetching total orders: " . mysqli_error($conn));
$totalData = mysqli_fetch_assoc($resultTotal);
$total_orders = $totalData['total_orders'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة إدارة المبيعات | المتجر</title>
    <!-- Bootstrap CSS (نسخة RTL) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #e4eef7;
        }

        .card-header {
            font-weight: bold;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #007bff, rgb(0, 38, 48));
            color: #fff;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .dashboard-header p {
            margin: 0;
            font-size: 1.25rem;
        }
    </style>
</head>

<body>

    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand active" href="admin_dashboard.php">لوحة الإدارة</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_product.php">إدارة المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_offers.php">إدارة العروض</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_orders.php">إدارة الطلبات</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_contact.php">إدارة رسائل الاتصال</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_users.php">إدارة الزبائن</a></li>
                    <li class="nav-item"><a class="nav-link" href="../php/logout.php">تسجيل الخروج</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- قسم رأس الصفحة -->
    <header class="dashboard-header">
        <div class="container">
            <h1>لوحة إدارة المبيعات</h1>
            <p>تحليل مبيعات اليوم، الأسبوع والشهر</p>
        </div>
    </header>

    <div class="container">
        <!-- مجموعة البطاقات الرئيسية -->
        <div class="row text-center mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-header">المبيعات اليومية</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo number_format($daily_sales); ?> ريال</h5>
                        <p class="card-text">مبيعات اليوم</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-header">المبيعات الأسبوعية</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo number_format($weekly_sales); ?> ريال</h5>
                        <p class="card-text">مبيعات هذا الأسبوع</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-header">المبيعات الشهرية</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo number_format($monthly_sales); ?> ريال</h5>
                        <p class="card-text">مبيعات هذا الشهر</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-header">إجمالي الطلبات</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_orders; ?></h5>
                        <p class="card-text">عدد الطلبات</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم الرسم البياني لتحليل المبيعات -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        تحليل المبيعات خلال الأسبوع
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- تضمين Chart.js من CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // مثال على بيانات الرسم البياني؛ استبدلها ببيانات استخراجها من قاعدة البيانات إن رغبت
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
                datasets: [{
                    label: 'المبيعات اليومية (بالريال)',
                    data: [<?php echo $daily_sales; ?>, 1800, 2000, 2200, 2100, 1900, 1700], // المثال هنا يُظهر استخدام القيمة اليومية مع بيانات ثابتة للباقي
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

</html>