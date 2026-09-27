<?php
include 'config.php';

$filter = isset($_GET['type']) ? $_GET['type'] : 'all';
$query = "SELECT * FROM items WHERE status = 'approved'";
if ($filter == 'group') { $query .= " AND category = 'group'"; }
elseif ($filter == 'ad') { $query .= " AND category = 'ad'"; }
$query .= " ORDER BY id DESC";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الإعلانات والقروبات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>دليل الإعلانات والقروبات</h1>
    <nav>
        <a href="index.php">الرئيسية</a>
        <a href="add.php" class="btn btn-primary">+ أضف إعلانك / قروبك</a>
        <a href="admin.php" style="color:#aaa; font-size:0.8rem;">لوحة التحكم</a>
    </nav>
</header>

<div class="container">
    <div style="margin-bottom: 20px; text-align: center;">
        <a href="index.php" class="btn btn-accent">الكل</a>
        <a href="index.php?type=group" class="btn btn-accent">القروبات فقط</a>
        <a href="index.php?type=ad" class="btn btn-accent">الإعلانات فقط</a>
    </div>

    <div class="grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div>
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <span style="font-size: 0.8rem; background: #333; padding: 3px 8px; border-radius: 4px;">
                            <?= $row['category'] == 'group' ? 'قروب' : 'إعلان' ?> (<?= strtoupper($row['platform']) ?>)
                        </span>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-primary" style="margin-top: 15px;">الانضمام / التفاصيل</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; grid-column: 1/-1;">لا توجد عناصر معروضة حالياً.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
