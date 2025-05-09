<?php
session_start();
include("../php/config.php");

// التحقق من صلاحيات المدير؛ يجب على المدير أن يكون له دور "admin" أو قيمة مخصصة
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit;
// }

$error_msg = "";
$success_msg = "";

// معالجة حذف المستخدم (يتم تمرير معرف المستخدم عبر GET)
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $success_msg = "تم حذف المستخدم بنجاح.";
    } else {
        $error_msg = "حدث خطأ أثناء حذف المستخدم.";
    }
    $stmt->close();
    header("Location: admin_users.php");
    exit;
}

// معالجة النموذج للإضافة أو التعديل
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_user') {
        // إضافة مستخدم جديد
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        if (empty($username) || empty($email) || empty($password)) {
            $error_msg = "يجب ملء جميع الحقول عند الإضافة!";
        } else {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, pass) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_pass);
            if ($stmt->execute()) {
                $success_msg = "تمت إضافة المستخدم بنجاح.";
            } else {
                $error_msg = "حدث خطأ أثناء إضافة المستخدم.";
            }
            $stmt->close();
        }
    } elseif ($_POST['action'] == 'edit_user') {
        // تعديل بيانات مستخدم موجود
        $user_id  = intval($_POST['id']);
        $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
        if (empty($username) || empty($email)) {
            $error_msg = "يجب إدخال اسم المستخدم والبريد الإلكتروني.";
        } else {
            // إذا تم إدخال كلمة مرور جديد، نقوم بتحديثها أيضًا؛ وإلا نتركها دون تغيير.
            if (!empty($_POST['password'])) {
                $password = trim($_POST['password']);
                $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, pass = ? WHERE id = ?");
                $stmt->bind_param("sssi", $username, $email, $hashed_pass, $user_id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                $stmt->bind_param("ssi", $username, $email, $user_id);
            }
            if ($stmt->execute()) {
                $success_msg = "تم تحديث بيانات المستخدم بنجاح.";
            } else {
                $error_msg = "حدث خطأ أثناء تحديث بيانات المستخدم.";
            }
            $stmt->close();
        }
    }
}

// استعلام لاسترجاع جميع المستخدمين لترتيبهم في جدول
$sql = "SELECT id, username, email, last_login, role FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين | لوحة المدير</title>
    <!-- تضمين Bootstrap CSS (نسخة RTL لدعم اللغة العربية) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- شريط تنقل Bootstrap مع خلفية داكنة -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">لوحة المدير</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="admin_product.php">إدارة المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_users.php">إدارة المستخدمين</a>
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

    <div class="container mt-4">
        <h2 class="mb-4">إدارة المستخدمين</h2>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        <?php endif; ?>

        <!-- زر لإضافة مستخدم جديد (يفتح مودال الإضافة) -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
            إضافة مستخدم جديد
        </button>

        <!-- جدول عرض المستخدمين -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>آخر تسجيل دخول</th>
                        <th>الصلاحية</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['last_login']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <!-- زر تعديل: يفتح مودال التعديل الخاص بهذا المستخدم -->
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['id']; ?>">
                                    تعديل
                                </button>
                                <!-- زر حذف: يستخدم مع تأكيد -->
                                <a href="admin_users.php?delete=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">حذف</a>
                            </td>
                        </tr>

                        <!-- مودال تعديل المستخدم -->
                        <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">تعديل مستخدم</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="admin_users.php" method="post">
                                            <input type="hidden" name="action" value="edit_user">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <div class="mb-3">
                                                <label for="username<?php echo $user['id']; ?>" class="form-label">اسم المستخدم</label>
                                                <input type="text" class="form-control" id="username<?php echo $user['id']; ?>" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email<?php echo $user['id']; ?>" class="form-label">البريد الإلكتروني</label>
                                                <input type="email" class="form-control" id="email<?php echo $user['id']; ?>" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password<?php echo $user['id']; ?>" class="form-label">كلمة المرور (اختياري)</label>
                                                <input type="password" class="form-control" id="password<?php echo $user['id']; ?>" name="password" placeholder="اترك الحقل فارغاً إذا لم ترغب بالتغيير">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- مودال إضافة مستخدم جديد -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">إضافة مستخدم جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <form action="admin_users.php" method="post">
                        <input type="hidden" name="action" value="add_user">
                        <div class="mb-3">
                            <label for="newUsername" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="newUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="newEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إضافة المستخدم</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>