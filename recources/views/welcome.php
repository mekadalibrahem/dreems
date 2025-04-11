<?php

use App\Core\Helper\Helper;
use App\Models\Dream;

include_once(Helper::views_path() . '/layouts/header.php');
$dreams = Dream::all();
?>
<div class="container">
    <h2 class="mb-4 text-center">جميع الأحلام</h2>
    
    <?php if (empty($dreams)): ?>
    <div class="alert alert-info text-center">
        لم يتم إضافة أي أحلام بعد. كن أول من يشارك حلمه!
    </div>
    <?php else: ?>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($dreams as $dream): ?>
        <div class="col">
            <div class="card dream-card h-100 <?php ec(($dream->status ==='fulfilled') ? 'fulfilled-dream' : '')  ; ?>">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i> <?php ec($dream->full_name); ?>
                    <?php if ($dream->status === 'fulfilled'): ?>
                    <span class="badge bg-success float-end"><i class="fas fa-check-circle me-1"></i> تم التحقيق</span>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($dream->image_path)): ?>
                <div class="dream-image" style="background-image: url('<?php echo  config('app.app_url').':8003'.  '/storage/uploads/' . htmlspecialchars($dream->image_path); ?>')"></div>
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title text-primary"><?php ec($dream->description); ?></h5>
                    <p class="card-text"><?php ec($dream->description); ?></p>
                </div>
                
                <div class="card-footer">
                    <div class="dream-amount">
                        <i class="fas fa-money-bill-wave me-1"></i> <?php ec($dream->amount); ?> ل.س
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    
    
    <?php endif; ?>

    <div class="hero-section mt-5">
        <div class="container">
            <h1>
                <i class="fas fa-star-half-alt me-2"></i>
                DreamsUP - حقق أحلامك
            </h1>
            <p>منصة لمشاركة وتحقيق الأحلام، يمكنك مشاركة حلمك وقد يتم اختياره للتحقيق!</p>
            <a href="dream/create" class="btn btn-light">
                <i class="fas fa-plus-circle me-1"></i> شارك حلمك الآن
            </a>
        </div>
    </div>
</div>


<?php
include_once(Helper::views_path() . '/layouts/footer.php');

?>