<?php
if(isset($_SERVER['SCRIPT_FILENAME']) && basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    header("Content-Type: text/html");
}
if(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'curl') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'wget') !== false)) {
    header("Location: /");
    exit;
}
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
                
                <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                    ?>
                </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $_SESSION['error_message']; 
                    unset($_SESSION['error_message']);
                    ?>
                </div>
                <?php endif; ?>
                
                <form action="process/save_dream.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dreamDescription" class="form-label">وصف حلمك</label>
                        <textarea class="form-control" id="dreamDescription" name="dreamDescription" rows="5" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dreamAmount" class="form-label">المبلغ المطلوب (ل.س)</label>
                        <input type="number" class="form-control" id="dreamAmount" name="dreamAmount" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dreamImage" class="form-label">صورة توضيحية (اختياري)</label>
                        <input type="file" class="form-control" id="dreamImage" name="dreamImage" accept="image/jpeg, image/jpg, image/png">
                        <div class="form-text">الصيغ المدعومة: JPG, PNG فقط - الحد الأقصى: 1 ميجابايت</div>
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

<?php include_once(Helper::views_path() . '/layouts/footer.php');
 ?>
