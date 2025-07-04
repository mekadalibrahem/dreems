<?php

use App\Core\Helper\Helper;
use App\Enums\DreamStatus;
use App\Models\Dream;

include_once(Helper::views_path() . '/layouts/header.php');

?>

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
                    <form id="randomCriteriaForm" method="post" action="/admin/fulfill_dream">
                        <div class="d-flex justify-content-center align-items-center ">
                            <div class="row w-75">
                                <div class="col-md-6 offset-md-3">
                                    <div class="mb-4 text-center">
                                        <h5 class="mb-4">تحديد حدود المبلغ</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="minAmount" class="form-label">الحد الأدنى (ل.س)</label>
                                                <input type="number"
                                                    class="form-control <?php echo has_error('minAmount') ? 'is-invalid' : ''; ?>"
                                                    id="minAmount" name="minAmount" min="0"
                                                    value="<?php ec(old('minAmount')); ?>">
                                                <?php if (has_error('minAmount')): ?>
                                                    <div class="invalid-feedback"><?php ec(error('minAmount')); ?></div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="maxAmount" class="form-label">الحد الأقصى (ل.س)</label>
                                                <input type="number"
                                                    class="form-control <?php echo has_error('maxAmount') ? 'is-invalid' : ''; ?>"
                                                    id="maxAmount" name="maxAmount" min="1"
                                                    value="<?php ec(old('maxAmount')); ?>">
                                                <?php if (has_error('maxAmount')): ?>
                                                    <div class="invalid-feedback"><?php ec(error('maxAmount')); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="row">
                    <div class="d-flex justify-content-center align-items-center ">
                        <div class="w-auto d-flex flex-column align-items-center">
                            <div class="mb-4 w-auto d-flex gap-3">
                                <button type="submit" name="select_random" class="btn btn-fulfill btn-lg">
                                    <i class="fas fa-magic me-1"></i> اختيار عشوائي
                                </button>
                                <button type="submit" name="view_dreams" class="btn btn-secondary btn-lg">
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

                    <table class="table  admin-table">

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
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php ec($dream->full_name); ?></td>
                                    <td> <?php ec($dream->description); ?> </td>
                                    <td><?php ec($dream->amount); ?> ل.س</td>
                                    <td>
                                        <?php if ($dream->status === DreamStatus::Approved->value): ?>
                                            <span class="badge bg-success">تم التحقيق</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">معلق</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($dream->status === DreamStatus::Pending->value): ?>
                                            <div class="btn-group">
                                              
                                                <form action="/admin/dream/accept" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $dream->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-fulfill btn-admin confirm-fulfill me-1">
                                                        <i class="fas fa-magic"></i> تحقيق
                                                    </button>
                                                </form>
                                                <form action="/admin/dream/accept" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $dream->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger btn-admin delete-dream">
                                                        <i class="fas fa-trash-alt"></i> حذف
                                                    </button>
                                                </form>
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


            <?php endif; ?>
        </div>
    </div>
</div>
<?php
include_once(Helper::views_path() . '/layouts/footer.php');
?>