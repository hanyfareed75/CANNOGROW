<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>العملاء</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    <link href="./main.css" rel="stylesheet" />

    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Add custom script -->
    <script src="./views/js/customer.js" defer></script>
</head>

<body>
    <?php include __DIR__.'/../components/navbar.php'; ?>

    <div class="container-fluid container-lg mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4">إضافة عميل</h3>
                <form method="POST" id="customerForm" class="row g-3 needs-validation bg-light border rounded p-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="customer_name" class="form-label">إسم العميل</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="mobile_1" class="form-label">موبايل 1</label>
                        <input type="text" name="mobile_1" id="mobile_1" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="mobile_2" class="form-label">موبايل 2</label>
                        <input type="text" name="mobile_2" id="mobile_2" class="form-control" />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="address" class="form-label">عنوان التوصيل</label>
                        <input type="text" name="address" id="address" class="form-control" required />
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="area_id" class="form-label">اختار المنطقة</label>
                        <select class="form-select mb-2" id="area_id" name="area"  required>
                            <option selected disabled>-----اختار المنطقة-----</option>
                            <?php foreach ($selecteditems as $item): ?>
                            <option value="<?= htmlspecialchars($item['area_id']) ?>">
                                <?= htmlspecialchars($item['area_name']) ?> - <?= htmlspecialchars($item['governorate']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        
                    </div>
                    <div class="col-12">
                        <button type="submit" id="submit" class="btn btn-primary px-4">
                            إضافة عميل جديد
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h3 class="card-title mb-4">قائمة العملاء</h3>
                <div class="table-responsive">
                    <div class="d-block d-md-none small text-muted mb-2">
                        ← اسحب الجدول للمزيد →
                    </div>
                    <table class="table table-hover table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم العميل</th>
                                <th>موبايل 1</th>
                                <th>موبايل 2</th>
                                <th>عنوان التوصيل</th>
                           
                                <th>المنطقة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="customersTbody">
                            <!-- Data will be loaded by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل بيانات العميل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editCustomerForm">
                        <input type="hidden" id="edit_customer_id">
                        <div class="mb-3">
                            <label for="edit_customer_name" class="form-label">اسم العميل</label>
                            <input type="text" class="form-control" id="edit_customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mobile_1" class="form-label">موبايل 1</label>
                            <input type="text" class="form-control" id="edit_mobile_1" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mobile_2" class="form-label">موبايل 2</label>
                            <input type="text" class="form-control" id="edit_mobile_2">
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="edit_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="edit_email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_notes" class="form-label"> ملاحظات</label>
                            <input type="text" class="form-control" id="edit_notes">
                        </div>
                        <div class="mb-3">
                        <label for="edit_area_id" class="form-label">اختار المنطقة</label>
                        <select class="form-select mb-2" id="edit_area_id" name="edit_area_id"  required>
                            <option selected disabled>-----اختار المنطقة-----</option>
                            <?php foreach ($selecteditems as $item): ?>
                            <option value="<?= htmlspecialchars($item['area_id']) ?>">
                                <?= htmlspecialchars($item['area_name']) ?> - <?= htmlspecialchars($item['governorate']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                       
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="saveEditCustomer">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
