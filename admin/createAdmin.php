<?php
// تأكد من تضمين الاتصال بقاعدة البيانات
include("../php/config.php");

$username = "Admin";
$email    = "admin@example.com";
$password = "123123"; // قم بتحديد كلمة المرور المطلوبة
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, pass, role) VALUES (?, ?, ?, ?)");
$role = "admin";
$stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "تم إنشاء حساب المدير بنجاح.";
} else {
    echo "حدث خطأ أثناء إنشاء الحساب.";
}
$stmt->close();
