<?php

use App\Core\Helper\Helper;

include_once(Helper::views_path() . '/layouts/header.php');
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
            <div class="card dream-card h-100 <?php echo $dream['status'] === 'fulfilled' ? 'fulfilled-dream' : ''; ?>">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($dream['full_name']); ?>
                    <?php if ($dream['status'] === 'fulfilled'): ?>
                    <span class="badge bg-success float-end"><i class="fas fa-check-circle me-1"></i> تم التحقيق</span>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($dream['image_path'])): ?>
                <div class="dream-image" style="background-image: url('<?php echo htmlspecialchars($dream['image_path']); ?>')"></div>
                <?php endif; ?>
                
                <div class="card-body">
                    <h5 class="card-title text-primary"><?php echo truncateText(htmlspecialchars($dream['description']), 30); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($dream['description']); ?></p>
                </div>
                
                <div class="card-footer">
                    <div class="dream-amount">
                        <i class="fas fa-money-bill-wave me-1"></i> <?php echo formatAmount($dream['amount']); ?> ل.س
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="mt-4">
        <?php echo generatePagination($page, $totalPages); ?>
    </div>
    
    <?php endif; ?>

    <div class="hero-section mt-5">
        <div class="container">
            <h1>
                <i class="fas fa-star-half-alt me-2"></i>
                DreamsUP - حقق أحلامك
            </h1>
            <p>منصة لمشاركة وتحقيق الأحلام، يمكنك مشاركة حلمك وقد يتم اختياره للتحقيق!</p>
            <a href="submit_dream" class="btn btn-light">
                <i class="fas fa-plus-circle me-1"></i> شارك حلمك الآن
            </a>
        </div>
    </div>
</div>


<?php
include_once(Helper::views_path() . '/layouts/footer.php');

?>