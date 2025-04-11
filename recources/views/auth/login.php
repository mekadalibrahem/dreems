<?php

use App\Core\Helper\Helper;
use App\Models\Dream;

include_once(Helper::views_path() . '/layouts/header.php');
$dreams = Dream::all();
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="login-form">
                <div class="card-header text-center">
                    تسجيل الدخول للوحة التحكم
                </div>
                <div class="card-body">
                    <?php if (!empty($loginError)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $loginError; ?>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" method="post" action="/admin/login">
                        <div class="mb-3">
                            <label for="username" class="form-label">اسم المستخدم</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> تسجيل الدخول
                            </button>
                        </div>
                    </form>
                </div>
                <div class="text-center mt-3">
                    <a href="/" class="text-decoration-none">
                        <i class="fas fa-arrow-right me-1"></i> العودة إلى الموقع الرئيسي
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once(Helper::views_path() . '/layouts/footer.php');

?>