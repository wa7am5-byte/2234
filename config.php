<?php
session_start();

// بيانات الاتصال بقاعدة البيانات (غيرها حسب بيانات استضافتك المجانية)
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "ads_groups_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
