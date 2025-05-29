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
  <script defer src="./views/js/recipe.js"></script>
  <link href="./main.css" rel="stylesheet">
  <title>الخلطات</title>
</head>
<body>

<?php include './components/navbar.php'; ?>

<div class="container-fluid mt-3">

  <!-- بطاقة الإضافة -->
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="card-title mb-4">إضافة خلطة</h3>

      <div class="row mb-4">
        <div class="col-12 col-md-6">
          <label for="product_id" class="form-label">اختار المنتج</label>
          <select class="form-select" id="product_id" name="product_id">
            <option>---Select----</option>
            <?php foreach ($selectedP as $selectedP): ?>
              <option value="<?= htmlspecialchars($selectedP['product_id']) ?>"><?= htmlspecialchars($selectedP['name_eng']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <form id="recipe-form" class="row g-3 needs-validation bg-light border rounded p-3">
        <div class="col-12 col-md-6">
          <label for="item_id" class="form-label">اختار الصنف</label>
          <select class="form-select" name="item_id" id="item_id">
            <option>---Select----</option>
            <?php foreach ($selectedI as $selectedI): ?>
              <option value="<?= htmlspecialchars($selectedI['item_id']) ?>"><?= htmlspecialchars($selectedI['item_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12 col-md-6">
          <label for="qty" class="form-label">الكمية</label>
          <input type="number" name="qty" class="form-control" id="qty" step="0.01" required />
          <label id="measure" name="measure" class="form-label"></label>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">ملاحظات</label>
          <input type="text" name="notes" class="form-control" id="notes" />
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">إضافة خلطة جديد</button>
          <div id="response-msg" class="mt-3"></div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- جدول الوصفات -->
<div class="container-fluid my-5">
  <button id="load-recipes" class="btn btn-primary mb-3">تحميل البيانات</button>
  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th>رقم الوصفة</th>
          <th>اسم المنتج</th>
          <th>اسم العنصر</th>
          <th>الكمية</th>
          <th>ملاحظات</th>
          <th>الغاء</th>
        </tr>
      </thead>
      <tbody id="recipe-table-body">
        <!-- سيتم ملء البيانات هنا -->
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
