CREATE TABLE IF NOT EXISTS `items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(50) NOT NULL, -- 'group' أو 'ad'
  `platform` VARCHAR(50) NOT NULL, -- 'whatsapp', 'telegram', 'facebook', 'other'
  `link` TEXT NOT NULL,
  `description` TEXT,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL
);

-- إضافة حساب آدمن افتراضي: اسم المستخدم: admin | كلمة السر: admin123
INSERT INTO `admins` (`username`, `password`) VALUES 
('admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1f8z/7Tz/x/qfG1s2qL3n.2zUv.5L62'); 
