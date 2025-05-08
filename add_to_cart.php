<?php
session_start();
include("php/config.php");

// التأكد من تسجيل دخول المستخدم
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];

    // التأكد من وجود بيانات المنتج المرسلة
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = intval($_POST['product_id']);
        $quantity   = intval($_POST['quantity']);

        // التحقق من صحة القيم: يجب أن يكون معرف المنتج والكمية أكبر من الصفر
        if ($product_id > 0 && $quantity > 0) {
            // التحقق مما إذا كان المنتج موجودًا بالفعل في سلة المستخدم
            $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
            if ($stmt) {
                $stmt->bind_param("ii", $user_id, $product_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // تم إيجاد المنتج مسبقًا، لذا نقوم بتحديث الكمية
                    $row = $result->fetch_assoc();
                    $new_quantity = $row['quantity'] + $quantity;
                    $cart_id = $row['id'];

                    $stmt_update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                    if ($stmt_update) {
                        $stmt_update->bind_param("ii", $new_quantity, $cart_id);
                        $stmt_update->execute();
                        $stmt_update->close();
                    } else {
                        echo "خطأ في تحديث الكمية.";
                        exit;
                    }
                } else {
                    // لم يوجد، نقوم بإدراج سجل جديد في جدول السلة
                    $stmt_insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    if ($stmt_insert) {
                        $stmt_insert->bind_param("iii", $user_id, $product_id, $quantity);
                        $stmt_insert->execute();
                        $stmt_insert->close();
                    } else {
                        echo "خطأ في إدراج المنتج في السلة.";
                        exit;
                    }
                }
                $stmt->close();
                // إعادة التوجيه إلى صفحة عرض السلة بعد الإضافة
                header("Location: products.php");
                exit;
            } else {
                echo "خطأ في إعداد الاستعلام.";
                exit;
            }
        } else {
            echo "معرف المنتج أو الكمية غير صحيحة.";
            exit;
        }
    } else {
        echo "رجاءً تأكد من إدخال بيانات صحيحة.";
        exit;
    }
} else {
    // إذا لم تُرسل البيانات بطريقة POST، نُعيد التوجيه إلى الصفحة الرئيسية
    header("Location: index.php");
    exit;
}
