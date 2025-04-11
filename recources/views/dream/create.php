<?php

use App\Core\Helper\Helper;

include_once(Helper::views_path() . '/layouts/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dream-form">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i> شارك حلمك
                </div>

                <!-- Success Message -->
                <?php if (flash_has('success_message')): ?>
                    <div class="alert alert-success">
                        <?php ec(flash_session('success_message')); ?>
                    </div>
                <?php endif; ?>



                <form action="/dream/store" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control <?php echo has_error('fullName') ? 'is-invalid' : ''; ?>" id="fullName" name="fullName" value="<?php ec(old('fullName')); ?>">
                        <?php if (has_error('fullName')): ?>
                            <div class="invalid-feedback"><?php ec(error('fullName')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="dreamDescription" class="form-label">وصف حلمك</label>
                        <textarea class="form-control <?php echo has_error('dreamDescription') ? 'is-invalid' : ''; ?>" id="dreamDescription" name="dreamDescription" rows="5" required><?php ec(old('dreamDescription')); ?></textarea>
                        <?php if (has_error('dreamDescription')): ?>
                            <div class="invalid-feedback"><?php ec(error('dreamDescription')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="dreamAmount" class="form-label">المبلغ المطلوب (ل.س)</label>
                        <input type="number" class="form-control <?php echo has_error('dreamAmount') ? 'is-invalid' : ''; ?>" id="dreamAmount" name="dreamAmount" value="<?php ec(old('dreamAmount')); ?>" required>
                        <?php if (has_error('dreamAmount')): ?>
                            <div class="invalid-feedback"><?php ec(error('dreamAmount')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="dreamImage" class="form-label">صورة توضيحية (اختياري)</label>
                        <input type="file" class="form-control <?php echo has_error('dreamImage') ? 'is-invalid' : ''; ?>" id="dreamImage" name="dreamImage" accept="image/jpeg, image/jpg, image/png">
                        <div class="form-text">الصيغ المدعومة: JPG, PNG فقط - الحد الأقصى: 1 ميجابايت</div>
                        <?php if (has_error('dreamImage')): ?>
                            <div class="invalid-feedback"><?php ec(error('dreamImage')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="image-preview-container">
                        <img id="imagePreview" src="#" alt="معاينة الصورة" />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> إرسال الحلم
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once(Helper::views_path() . '/layouts/footer.php'); ?>