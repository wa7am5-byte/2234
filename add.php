<?php
include 'config.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $category = $conn->real_escape_string($_POST['category']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $link = $conn->real_escape_string($_POST['link']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO items (title, category, platform, link, description) VALUES ('$title', '$category', '$platform', '$link', '$description')";
    if ($conn->query($sql)) {
        $msg = "<p style='color: #25d366;'>تم تقديم إعلانك بنجاح! سيتم مراجعته قبل النشر.</p>";
    } else {
        $msg = "<p style='color: #e74c3c;'>حدث خطأ، يرجى المحاولة لاحقاً.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة إعلان أو قروب جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>إضافة نشر جديد</h1>
    <a href="index.php" class="btn btn-accent">العودة للرئيسية</a>
</header>

<div class="container" style="max-width: 500px;">
    <?= $msg ?>
    <form method="POST">
        <label>العنوان:</label>
        <input type="text" name="title" required placeholder="مثال: قروب مصممي الجرافيك">

        <label>النوع:</label>
        <select name="category" required>
            <option value="group">قروب</option>
            <option value="ad">إعلان تجاري / خدمة</option>
        </select>

        <label>المنصة:</label>
        <select name="platform" required>
            <option value="whatsapp">واتساب</option>
            <option value="telegram">تليجرام</option>
            <option value="facebook">فيسبوك</option>
            <option value="other">أخرى</option>
        </select>

        <label>الرابط (URL):</label>
        <input type="url" name="link" required placeholder="https://chat.whatsapp.com/...">

        <label>الوصف:</label>
        <textarea name="description" rows="4" placeholder="تفاصيل الإعلان أو هدف القروب..."></textarea>

        <button type="submit" class="btn btn-primary" style="width: 100%;">إرسال للمراجعة</button>
    </form>
</div>

</body>
</html>
