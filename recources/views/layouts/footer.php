<?php
//TODO: IMPORT DATABASE

use App\Enums\DreamStatus;
use App\Models\Dream;

$fulfilledDreams = Dream::query()->status(DreamStatus::Approved->value)->get();

use App\Core\Helper\Helper;
?>

    <!-- //TODO : FIX MOVING TICKER JS CODE IN METHOD (setupNewTicker) -->
    <?php if (count($fulfilledDreams) > 0): ?>
    <div id="news-ticker" class="ticker-wrap">
        <div class="ticker-heading">
            <i class="fas fa-check-circle me-1"></i> أحلام تحققت
        </div>
        <div class="ticker-container">
            <div class="ticker-track">
                <?php foreach ($fulfilledDreams as $dream): ?>
                    <div class="ticker-item">
                        <span class="ticker-name"><?php ec($dream->full_name); ?></span>
                        <span class="ticker-amount"><?php ec($dream->amount); ?> ل.س</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif ?>

<!-- Footer -->
<footer class="footer py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <span class="copyright">
                    جميع الحقوق محفوظة &copy; <?php ec(' | ' . config('app.app_name') . ' ' . date('Y'));  ?>
                </span>
            </div>
        </div>
    </div>
</footer>

   
    <script src="/js/app.js"></script>
</body>

</html>