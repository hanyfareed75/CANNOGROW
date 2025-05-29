<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <!-- Custom JS -->
    <script defer src="./views/js/accTrans.js"></script>
    <script defer src="js/main.js"></script>
    <link href="./main.css" rel="stylesheet" />
    <title>لقيود</title>

    <style>
        body {
            background-color: #f9fafb;
        }

        .card-title {
            color: #003366;
            font-weight: 600;
        }

        label {
            font-weight: 500;
            color: #003366;
        }

        .input-group-text.bg-green {
            background-color: #198754;
            /* bootstrap success green */
            color: white;
            font-weight: 600;
        }

        /* تحسين عرض الرقم في الشاشات الصغيرة */
        #gl_id {
            font-size: 1.25rem;
            padding: 0.375rem 0.75rem;
        }

        /* لجعل الجدول أفقياً على الشاشات الصغيرة مع تمرير أفقي */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title mb-4 text-center text-md-center">إضافة عملية</h3>

                <form method="POST" id="itemForm" class="row g-3 needs-validation bg-light border rounded p-3" novalidate>

                    <!-- رقم القيد/العملية -->
                    <div class="col-12 col-sm-4 col-md-2 mb-3">
                        <label class="input-group-text bg-green d-block text-center mb-2" for="gl_id">
                            رقم القيد/العملية
                        </label>
                        <span id="gl_id" name="trans_id" class="form-control bg-light text-center" readonly
                            aria-readonly="true">
                            <?= htmlspecialchars($result[0]['trans_id'] + 1) ?>
                        </span>
                    </div>

                    <!-- التاريخ -->
                    <div class="col-12 col-sm-8 col-md-4 mb-3">
                        <label for="trans_date" class="form-label">التاريخ</label>
                        <input type="date" name="trans_date" id="trans_date" class="form-control"
                            value="<?php echo (new DateTime())->format('Y-m-d'); ?>" required />
                        <div class="invalid-feedback">الرجاء اختيار التاريخ.</div>
                    </div>

                    <!-- رقم الفاتورة / البيان -->
                    <div class="col-12 col-md-6 mb-3">
                        <label for="invoice_id" class="form-label">رقم الفاتورة / البيان</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="رقم الفاتورة / البيان"
                                aria-label="رقم الفاتورة / البيان" name="invoice_id" id="invoice_id" />
                            <button type="button" class="btn btn-light fw-bold" id="gotoInvoice">تفاصيل فاتورة</button>
                        </div>
                    </div>

                    <!-- القيمة -->
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <label for="trans_value" class="form-label">القيمة</label>
                        <input type="number" name="trans_value" id="trans_value" class="form-control" step="0.01" required />
                        <div class="invalid-feedback">الرجاء إدخال قيمة صحيحة.</div>
                    </div>

                    <!-- الوصف -->
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <label for="trans_description" class="form-label">الوصف</label>
                        <input type="text" name="trans_description" id="trans_description" class="form-control" required />
                        <div class="invalid-feedback">الرجاء إدخال الوصف.</div>
                    </div>

                    <!-- من حساب -->
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="account_from" class="form-label">من حساب</label>
                        <select class="form-select" id="account_from" name="account_from" required>
                            <option value="" disabled selected>اختر الحساب</option>
                            <option value="1120">صندوق 2 امبابة</option>
                            <option value="1110">صندوق 1 العبور</option>
                        </select>
                        <div class="invalid-feedback">الرجاء اختيار الحساب.</div>
                    </div>

                    <!-- نوع القيد -->
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="account_type" class="form-label">اختار نوع القيد</label>
                        <select class="form-select" id="account_type" name="account_type" required>
                            <option value="" disabled selected>اختر نوع القيد</option>
                            <?php foreach ($selecteditems as $item): ?>
                                <option value="<?= htmlspecialchars($item['account_code']) ?>">
                                    <?= htmlspecialchars($item['account_name']) ?> --
                                    <?= htmlspecialchars($item['account_type']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">الرجاء اختيار نوع القيد.</div>
                    </div>

                    <!-- نوع الحركة -->
                    <div class="col-12 col-sm-6 col-md-4 mb-3">
                        <label for="transaction_movement" class="form-label">اختار نوع الحركة</label>
                        <select class="form-select" id="transaction_movement" name="transaction_movement" required>
                            <option value="" disabled selected>اختر نوع الحركة</option>
                            <option value="1">ايراد</option>
                            <option value="2">مصروف</option>
                        </select>
                        <div class="invalid-feedback">الرجاء اختيار نوع الحركة.</div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary px-4">إضافة قيد جديد</button>
                    </div>

                    <div id="message" class="mt-3 text-center">
                        <?php if (isset($_GET['success'])): ?>
                            <p class="text-success">تمت الإضافة بنجاح!</p>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4 text-center text-md-start">السجلات</h3>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">التاريخ</th>
                                    <th scope="col">القيمة</th>
                                    <th scope="col">الوصف</th>
                                    <th scope="col">نوع القيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($result)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد سجلات.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($result as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['trans_id']) ?></td>
                                            <td><?= htmlspecialchars($row['trans_date']) ?></td>
                                            <td><?= htmlspecialchars($row['trans_value']) ?></td>
                                            <td><?= htmlspecialchars($row['trans_description']) ?></td>
                                            <td><?= htmlspecialchars($row['trans_type']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    <script>
        // Bootstrap validation example
        (() => {
            'use strict';
            const form = document.querySelector('#itemForm');
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>

</body>

</html>
