<?php
// session_start();
// $basePath = '';
// if (!file_exists('config.php') && file_exists(__DIR__ . '/config.php')) {
//     $basePath = __DIR__ . '/';
// }
// require_once $basePath . 'config.php';
// require_once $basePath . 'db.php';
// require_once $basePath . 'functions.php';
// 

use App\Core\Helper\Helper;

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Helper::config('app.app_name'); ?> - 
    <?php //echo SITE_DESC; ?>
</title>
    
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/app.css" />
   

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container containernav ">
            <a class="navbar-brand" href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'admin/') !== false) ? '../' : ''; ?>index.php">
                <i class="fa fa-star-half-alt me-2"></i>
                <span class="fw-bold"><?php Helper::config('app.app_name'); ?></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'admin/') !== false) ? '../' : ''; ?>/">الرئيسية</a>
                    </li>
                    
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'admin/') === false) ? 'admin/' : ''; ?>index.php">لوحة التحكم</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'admin/') !== false) ? '../' : ''; ?>process/login.php?logout=1">تسجيل الخروج</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex">
                    <a href="<?php echo (strpos($_SERVER['REQUEST_URI'], 'admin/') !== false) ? '../' : ''; ?>submit_dream" class="btn btn-success ms-2">
                        <i class="fas fa-plus-circle me-1"></i> أرسل حلمك
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4 main-container">
