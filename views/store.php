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
  <script src="../js/store.js" defer></script>
  <link href="./main.css" rel="stylesheet">
  <title>CANNIGROW STORE</title>
</head>
<body>

<?php include './components/navbar.php'; ?>

<div class="container-fluid mt-3">

  <!-- بطاقة النموذج -->
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <h3 class="card-title mb-4">المخزن</h3>

      <form
        id="storeForm"
        method="POST"
        action="store_Store.php"
        class="row g-3 needs-validation bg-light border rounded p-3"
      >
        <div class="col-12 col-md-5">
          <label for="tran_date" class="form-label">تاريخ</label>
          <input
            type="date"
            name="tran_date"
            class="form-control"
            id="tran_date"
            value="<?php echo (new DateTime())->format('Y-m-d'); ?>"
            required
          />
        </div>

        <div class="col-12 col-md-5">
          <label for="item_id" class="form-label">اختار الصنف</label>
          <select class="form-select" id="item_id" name="item_id" required>
            <?php foreach ($selecteditems as $selecteditems): ?>
              <option value="<?= htmlspecialchars($selecteditems['item_id']) ?>">
                <?= htmlspecialchars($selecteditems['item_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12 col-md-2 d-flex align-items-end">
          <a class="btn btn-outline-secondary w-100" id="goHome" href="?items" target="new">
            إضافة صنف جديد
          </a>
        </div>

        <div class="col-12 col-md-6">
          <label for="qty" class="form-label">الكمية</label>
          <input type="number" name="qty" class="form-control" id="qty" required />
        </div>

        <div class="col-12 col-md-6">
          <label for="trans" class="form-label">العملية</label>
          <select class="form-select" id="trans" name="trans" required>
            <option value="">اختار العملية</option>
            <option value="وارد">وارد</option>
            <option value="صادر">صادر</option>
            <option value="هالك">هالك</option>
          </select>
        </div>

        <div class="col-12">
          <label for="notes" class="form-label">ملاحظات</label>
          <input type="text" name="notes" class="form-control" id="notes" />
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">إضافة عملية</button>
        </div>

        <div id="message" class="mt-3"></div>
      </form>
    </div>
  </div>

  <!-- جدول العمليات -->
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <h3 class="card-title mb-4">سجل العمليات</h3>

      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle" id="storeTable">
          <thead class="table-dark">
            <tr>
              <th>رقم العملية</th>
              <th>التاريخ</th>
              <th>الصنف</th>
              <th>الكمية</th>
              <th>العملية</th>
              <th>ملاحظات</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($store)): ?>
              <tr>
                <td colspan="6" class="text-danger">لا توجد عمليات مخزنية.</td>
              </tr>
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

</div>

</body>
</html>
