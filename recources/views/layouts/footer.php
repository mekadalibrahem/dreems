

<?php
//TODO: IMPORT DATABASE

use App\Models\Dream;

$fulfilledDreams = Dream::all();
// dd($fulfilledDreams);
use App\Core\Helper\Helper;
?>
    </div><!-- End main container -->

    <!-- //TODO : FIX MOVING TICKER JS CODE IN METHOD (setupNewTicker) -->
    Fulfilled Dreams Ticker - New Simpler Version
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
                        جميع الحقوق محفوظة &copy; <?php ec(' | ' . config('app.app_name') . ' ' . date('Y') ) ;  ?>
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
    
    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    
    <!-- Custom JS -->
    <script src="/js/app.js"></script>
</body>
</html>
