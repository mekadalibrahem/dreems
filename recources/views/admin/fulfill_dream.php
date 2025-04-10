<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$database = new Database();

// Check if fulfilling a specific dream
if (isset($_GET['id'])) {
    $dreamId = (int)$_GET['id'];
    
    // Fulfill the dream
    $result = $database->fulfillDream($dreamId);
    
    if ($result) {
        $_SESSION['success_message'] = 'تم تحقيق الحلم بنجاح!';
    } else {
        $_SESSION['error_message'] = 'حدث خطأ أثناء تحقيق الحلم.';
    }
    
    // Redirect back to admin index
    header('Location: index.php');
    exit;
}

// Check if viewing dreams within criteria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_dreams'])) {
    // Get amount criteria
    $minAmount = !empty($_POST['minAmount']) ? (int)$_POST['minAmount'] : 0;
    $maxAmount = !empty($_POST['maxAmount']) ? (int)$_POST['maxAmount'] : 999999999;
    
    // Validate criteria
    if ($minAmount < 0) {
        $_SESSION['error_message'] = 'الحد الأدنى للمبلغ يجب أن يكون أكبر من أو يساوي صفر.';
        header('Location: index.php');
        exit;
    }
    
    if ($maxAmount <= 0) {
        $_SESSION['error_message'] = 'الحد الأقصى للمبلغ يجب أن يكون أكبر من صفر.';
        header('Location: index.php');
        exit;
    }
    
    if ($minAmount > $maxAmount) {
        $_SESSION['error_message'] = 'الحد الأدنى يجب أن يكون أقل من أو يساوي الحد الأقصى.';
        header('Location: index.php');
        exit;
    }
    
    // Get matching dreams
    $matchingDreams = $database->getMatchingDreams($minAmount, $maxAmount);
    
    // Display page with matching dreams
    include_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="card admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">الأحلام المطابقة للشروط</h5>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h6>شروط البحث:</h6>
                <p>الحد الأدنى للمبلغ: <?php echo formatAmount($minAmount); ?> ل.س | الحد الأعلى للمبلغ: <?php echo formatAmount($maxAmount); ?> ل.س</p>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-right me-1"></i> عودة للوحة التحكم</a>
            </div>
            
            <?php if (empty($matchingDreams)): ?>
            <div class="alert alert-info">
                لم يتم العثور على أحلام تطابق الشروط المحددة.
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped admin-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الاسم</th>
                            <th scope="col">الوصف</th>
                            <th scope="col">المبلغ</th>
                            <th scope="col">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matchingDreams as $index => $dream): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($dream['full_name']); ?></td>
                            <td><?php echo truncateText(htmlspecialchars($dream['description']), 50); ?></td>
                            <td><?php echo formatAmount($dream['amount']); ?> ل.س</td>
                            <td>
                                <a href="fulfill_dream.php?id=<?php echo $dream['id']; ?>" class="btn btn-sm btn-fulfill confirm-fulfill">
                                    <i class="fas fa-magic me-1"></i> تحقيق
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
    exit;
}

// Check if selecting a random dream based on criteria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_random'])) {
    // Get amount criteria
    $minAmount = !empty($_POST['minAmount']) ? (int)$_POST['minAmount'] : 0;
    $maxAmount = !empty($_POST['maxAmount']) ? (int)$_POST['maxAmount'] : 999999999;
    
    // Validate criteria
    if ($minAmount < 0) {
        $_SESSION['error_message'] = 'الحد الأدنى للمبلغ يجب أن يكون أكبر من أو يساوي صفر.';
        header('Location: index.php');
        exit;
    }
    
    if ($maxAmount <= 0) {
        $_SESSION['error_message'] = 'الحد الأقصى للمبلغ يجب أن يكون أكبر من صفر.';
        header('Location: index.php');
        exit;
    }
    
    if ($minAmount > $maxAmount) {
        $_SESSION['error_message'] = 'الحد الأدنى يجب أن يكون أقل من أو يساوي الحد الأقصى.';
        header('Location: index.php');
        exit;
    }
    
    // Get a random dream based on criteria
    $randomDream = $database->getRandomDream($minAmount, $maxAmount);
    
    if ($randomDream) {
        // Show the random dream and ask for confirmation
        include_once '../includes/header.php';
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
                                <p><strong>الاسم:</strong> <?php echo htmlspecialchars($randomDream['full_name']); ?></p>
                                <p><strong>المبلغ:</strong> <?php echo formatAmount($randomDream['amount']); ?> ل.س</p>
                                <p><strong>تاريخ الإرسال:</strong> <?php echo date('Y-m-d', strtotime($randomDream['created_at'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>وصف الحلم:</strong></p>
                                <p><?php echo htmlspecialchars($randomDream['description']); ?></p>
                                
                                <?php if (!empty($randomDream['image_path'])): ?>
                                <div class="mt-3">
                                    <img src="<?php echo htmlspecialchars($randomDream['image_path']); ?>" 
                                         alt="صورة الحلم" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i> العودة واختيار حلم آخر
                        </a>
                        
                        <form action="fulfill_dream.php" method="GET">
                            <input type="hidden" name="id" value="<?php echo $randomDream['id']; ?>">
                            <button type="submit" class="btn btn-fulfill confirm-fulfill">
                                <i class="fas fa-magic me-1"></i> تحقيق هذا الحلم
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        include_once '../includes/footer.php';
        exit;
    } else {
        $_SESSION['error_message'] = 'لم يتم العثور على أي حلم يطابق المعايير المحددة.';
        header('Location: index.php');
        exit;
    }
}

// If reached here, redirect to admin index
header('Location: index.php');
exit;
?>
