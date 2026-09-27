<?php
include 'config.php';

// تسجيل الدخول
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $res = $conn->query("SELECT * FROM admins WHERE username='$user'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['admin'] = $row['username'];
        }
    }
}

// تسجيل الخروج
if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header("Location: admin.php");
}

// التحكم بالإعلانات (موافقة / حذف)
if (isset($_SESSION['admin'])) {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        if ($_GET['action'] == 'approve') {
            $conn->query("UPDATE items SET status='approved' WHERE id=$id");
        } elseif ($_GET['action'] == 'delete') {
            $conn->query("DELETE FROM items WHERE id=$id");
        }
        header("Location: admin.php");
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المبرمج</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>لوحة التحكم والإدارة</h1>
    <a href="index.php" class="btn btn-accent">الرئيسية</a>
</header>

<div class="container">

<?php if (!isset($_SESSION['admin'])): ?>
    <!-- نموذج تسجيل الدخول -->
    <div style="max-width: 400px; margin: 50px auto;">
        <h2>تسجيل دخول الآدمن</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة السر" required>
            <button type="submit" name="login" class="btn btn-primary" style="width:100%;">دخول</button>
        </form>
        <p style="color:#888; font-size:0.8rem;">الحساب الافتراضي: admin | كلمة السر: admin123</p>
    </div>

<?php else: ?>
    <!-- لوحة التحكم الحقيقية -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>مرحباً بك في لوحة الإدارة</h2>
        <a href="admin.php?logout=1" class="btn btn-danger">تسجيل الخروج</a>
    </div>

    <h3>الطلبات المعلقة (تنتظر الموافقة):</h3>
    <?php
    $pending = $conn->query("SELECT * FROM items WHERE status='pending' ORDER BY id DESC");
    ?>
    <table>
        <thead>
            <tr>
                <th>العنوان</th>
                <th>النوع</th>
                <th>المنصة</th>
                <th>الرابط</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = $pending->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><?= $p['category'] ?></td>
                <td><?= $p['platform'] ?></td>
                <td><a href="<?= htmlspecialchars($p['link']) ?>" target="_blank">معاينة</a></td>
                <td>
                    <a href="admin.php?action=approve&id=<?= $p['id'] ?>" class="btn btn-primary">موافقة</a>
                    <a href="admin.php?action=delete&id=<?= $p['id'] ?>" class="btn btn-danger">حذف</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3 style="margin-top: 40px;">العناصر المنشورة حالياً:</h3>
    <?php
    $approved = $conn->query("SELECT * FROM items WHERE status='approved' ORDER BY id DESC");
    ?>
    <table>
        <thead>
            <tr>
                <th>العنوان</th>
                <th>النوع</th>
                <th>المنصة</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            <?php while($a = $approved->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($a['title']) ?></td>
                <td><?= $a['category'] ?></td>
                <td><?= $a['platform'] ?></td>
                <td>
                    <a href="admin.php?action=delete&id=<?= $a['id'] ?>" class="btn btn-danger">حذف من الموقع</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php endif; ?>

</div>

</body>
</html>
