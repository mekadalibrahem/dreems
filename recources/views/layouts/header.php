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

use App\Core\Authentication\Auth;
use App\Core\Helper\Helper;
use App\Core\Helper\Session;

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Helper::config('app.app_name'); ?> -
    </title>


    <link rel="stylesheet" href="/css/app.css" />


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container containernav ">
            <a class="navbar-brand" href="/">
                <i class="fa fa-star-half-alt me-2"></i>
                <span class="fw-bold"><?php Helper::config('app.app_name'); ?></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php ec( is_url('/') ? 'active' : '' );  ?>" aria-current="page" href="/">الرئيسية</a>
                    </li>

                    <?php if (Auth::user() != null): ?>

                        <li class="nav-item">
                            <a class="nav-link  <?php ec( is_url('/admin/dashboard') ? 'active' : '' );  ?>" href="<?php ec('/admin/dashboard'); ?>">لوحة التحكم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?php ec( is_url('/admin/logout') ? 'active' : '' );  ?> " href="<?php ec('/admin/logout'); ?>">تسجيل الخروج</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex">
                    <a href="/dream/create" class="btn btn-success ms-2">
                        <i class="fas fa-plus-circle me-1"></i> أرسل حلمك
                    </a>
                </div>
            </div>
        </div>
    </nav>