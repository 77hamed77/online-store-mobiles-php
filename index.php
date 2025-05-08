
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>الصفحة الرئيسية | متجر إلكتروني</title>
</head>
<body>
<div class="row">
<?php
require_once 'db_config.php';
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo '
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="'.$row['image'].'" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">'.$row['name'].'</h5>
                <p class="card-text">'.$row['description'].'</p>
                <p class="text-danger">السعر: $'.$row['price'].'</p>
            </div>
        </div>
    </div>';
}
?>
</div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>