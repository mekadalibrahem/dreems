<?php
// TODO : TAKE THIS
// session_start();
// require_once '../includes/config.php';
// require_once '../includes/db.php';
// require_once '../includes/functions.php';

// Check if user is logged in, if not display the login form
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}





// User is logged in, display admin dashboard

// Get current page for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Get ALL dreams for the current page (pendding and fulfilled)
$database = new Database();
$dreams = $database->getAllDreams($page, 10);
$totalDreams = $database->countAllDreams();
$totalPages = ceil($totalDreams / 10);

// Process success messages
$successMessage = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

// Process error messages
$errorMessage = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - <?php echo  config("APP.APP_NAME"); ?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-star-half-alt me-2"></i>
                <span class="fw-bold"><?php echo config("APP.APP_NAME"); ?></span> - لوحة التحكم
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">عرض الموقع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../process/login.php?logout=1">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">لوحة التحكم</h1>
        
        <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <!-- Dreams Management -->
        <!-- Random Dream Selection -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card admin-card">
                    <div class="card-header">
                        <h5 class="mb-0">اختيار حلم عشوائي للتحقيق</h5>
                    </div>
                    <div class="card-body">
                        <form id="randomCriteriaForm" method="post" action="fulfill_dream.php">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="minAmount" class="form-label">الحد الأدنى للمبلغ (ل.س)</label>
                                        <input type="number" class="form-control" id="minAmount" name="minAmount" min="0">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="maxAmount" class="form-label">الحد الأقصى للمبلغ (ل.س)</label>
                                        <input type="number" class="form-control" id="maxAmount" name="maxAmount" min="1">
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <div class="mb-3 w-100 d-flex">
                                        <button type="submit" name="select_random" class="btn btn-fulfill me-1">
                                            <i class="fas fa-magic me-1"></i> اختيار عشوائي
                                        </button>
                                        <button type="submit" name="view_dreams" class="btn btn-secondary">
                                            <i class="fas fa-list me-1"></i> عرض المطابق
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Dreams Management -->
        <div class="card admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">إدارة جميع الأحلام</h5>
            </div>
            <div class="card-body">
                <?php if (empty($dreams)): ?>
                <p class="text-center">لا توجد أحلام للعرض.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped admin-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">الوصف</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">الحالة</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dreams as $index => $dream): ?>
                            <tr>
                                <td><?php echo (($page - 1) * 10) + $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($dream['full_name']); ?></td>
                                <td><?php echo truncateText(htmlspecialchars($dream['description']), 50); ?></td>
                                <td><?php echo formatAmount($dream['amount']); ?> ل.س</td>
                                <td>
                                    <?php if ($dream['status'] === 'fulfilled'): ?>
                                    <span class="badge bg-success">تم التحقيق</span>
                                    <?php else: ?>
                                    <span class="badge bg-warning text-dark">معلق</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($dream['status'] === 'pending'): ?>
                                    <div class="btn-group">
                                        <a href="fulfill_dream.php?id=<?php echo $dream['id']; ?>" class="btn btn-sm btn-fulfill btn-admin confirm-fulfill me-1">
                                            <i class="fas fa-magic"></i> تحقيق
                                        </a>
                                        <a href="delete_dream.php?id=<?php echo $dream['id']; ?>" class="btn btn-sm btn-danger btn-admin delete-dream">
                                            <i class="fas fa-trash-alt"></i> حذف
                                        </a>
                                    </div>
                                    <?php else: ?>
                                    <span class="text-muted small">تم تحقيقه</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-3">
                    <?php echo generatePagination($page, $totalPages, 'index.php?page='); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
