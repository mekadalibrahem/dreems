<?php

use App\Core\Helper\Helper;

include_once(Helper::views_path() . '/layouts/header.php');

?>
<div class="container mt-4">
    <div class="card admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">تأكيد تحقيق الحلم العشوائي</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> تم اختيار الحلم التالي بشكل عشوائي بناءً على الشروط المحددة.
            </div>

            <div class="dream-preview mb-4">
                <h4>معلومات الحلم</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>الاسم:</strong> <?php ec($randomDream->full_name); ?></p>
                        <p><strong>المبلغ:</strong> <?php ec($randomDream->amount); ?> ل.س</p>
                        <p><strong>تاريخ الإرسال:</strong> <?php echo date('Y-m-d', strtotime($randomDream->created_at)); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>وصف الحلم:</strong></p>
                        <p><?php ec($randomDream->description); ?></p>

                        <?php if (!empty($randomDream->image_path)): ?>


                            <div class="mt-3">
                                <img
                                    alt="صورة الحلم"
                                    class="img-fluid rounded"
                                    style="max-height: 200px;"
                                    src="<?php print(config('app.app_url') . ':8003/storage/uploads/' . $randomDream->image_path); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admin/dashboard" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> العودة واختيار حلم آخر
                </a>


                <form action="/admin/dream/accept" method="POST">
                    <input type="hidden" name="id" value="<?php echo $randomDream->id; ?>">
                    <button type="submit" class="btn btn-fulfill confirm-fulfill">
                        <i class="fas fa-magic me-1"></i> تحقيق هذا الحلم
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php
include_once(Helper::views_path() . '/layouts/footer.php');
?>