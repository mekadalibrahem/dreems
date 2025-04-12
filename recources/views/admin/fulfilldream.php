<?php

use App\Core\Helper\Helper;


include_once(Helper::views_path() . '/layouts/header.php');

?>

<div class="container mt-4">
    <div class="card admin-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">الأحلام المطابقة للشروط</h5>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h6>شروط البحث:</h6>
                <p>الحد الأدنى للمبلغ: <?php ec($minAmount); ?> ل.س | الحد الأعلى للمبلغ: <?php ec($maxAmount); ?> ل.س</p>
                <a href="/admin/dashboard" class="btn btn-secondary"><i class="fas fa-arrow-right me-1"></i> عودة للوحة التحكم</a>
            </div>

            <?php if (empty($matchingDreams)): ?>
                <div class="alert alert-info">
                    لم يتم العثور على أحلام تطابق الشروط المحددة.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <!-- TODO fix table  -  rows colors  -->
                    <table class="table admin-table">
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
                                    <td><?php ec($dream->full_name); ?></td>
                                    <td><?php ec($dream->description); ?></td>
                                    <td><?php ec($dream->amount); ?> ل.س</td>
                                    <td>
                                        <a href="fulfill_dream.php?id=<?php echo $dream->id; ?>" class="btn btn-sm btn-fulfill confirm-fulfill">
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
include_once(Helper::views_path() . '/layouts/footer.php');
?>