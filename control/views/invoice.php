<!DOCTYPE html>
<html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
       
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
<link  href="./main.css" rel="stylesheet">

        <title>CANNIGROW INVOICES</title>
    </head>

    <body>
        <?php include __DIR__ . '/../components/navbar.php'; ?>


        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">الفواتير</h3>

                    <form id="storeForm" method="POST" class="row g-3 needs-validation bg-light border rounded">
                        <div class="row">
                            <div class=" mb-2 col-md-2">
                                <span class="input-group-text bg-green" id='trans_id' name='trans_id'>رقم القيد/العملية
                                    <?= $_GET['$gl_id'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="qty" class="form-label">رقم الفاتورة /البيان</label>
                            <input type="text" name="qty" class="form-control" id="qty" value=<?= $_GET['$inv_id'] ?> />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tran_date" class="form-label">تاريخ الفاتورة</label>
                            <input type="date" name="tran_date" class="form-control" id="tran_date"
                                value="<?php echo (new DateTime())->format('Y-m-d'); ?>" required />
                        </div>

                        <div class='row'>
                            <div class="col-md-4">
                                <label for="item_id" class="form-label">اختار الصنف</label>
                                <select class="form-select" id="item_id" name="item_id">

                                    <?php foreach ($selecteditems as $selecteditems): ?>
                                    <option value=<?= htmlspecialchars($selecteditems['item_id']) ?>>
                                        <?= htmlspecialchars($selecteditems['item_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="qty" class="form-label">الكمية</label>
                                <input type="number" name="qty" class="form-control" id="qty" required />
                            </div>
                            <div class="col-md-4">
                                <label for="qty" class="form-label">القيمة</label>
                                <input type="number" name="qty" class="form-control" id="qty" required />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <input type="text" name="notes" class="form-control" id="notes" />
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" value="submit">
                                اضافة عملية
                            </button>


                        </div>
                        <div id="responseMessage" class="mt-3">
                            test
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form name="uploadform" id="uploadForm" method="POST">
            <div class="col-md-3 mb-4">
                <label class="form-label" for="customFile">تحميل صورة الفاتورة / البيان</label>
                <input type="file" id="invoice_photo" class="form-control" />
                <button type="submit" class="btn btn-primary" value="submit">
                    اضافة عملية
                </button>

            </div>

        </form>
        <script></script>
        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table" id="storeTable">
                        <thead>
                            <tr>
                                <th scope="col">رقم العملية</th>
                                <th scope="col">التاريخ</th>

                                <th scope="col">الصنف</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">العملية</th>
                                <th scope="col">ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($store)): ?>
                            <p>No Store Transactions found.</p>

                            <?php else: ?>

                            <?php foreach ($store as $store): ?>
                            <tr>
                                <td><?= htmlspecialchars($store['tran_id']) ?></td>
                                <td><?= htmlspecialchars($store['tran_date']) ?></td>
                                <td><?= htmlspecialchars($store['item_name']) ?></td>
                                <td><?= htmlspecialchars($store['qty']) ?></td>

                                <td><?= htmlspecialchars($store['trans']) ?></td>
                                <td><?= htmlspecialchars($store['notes']) ?></td>
                            </tr>

                            <?php endforeach; ?>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="./js/invoice.js" defer></script>
    </body>

</html>