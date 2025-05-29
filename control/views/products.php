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
  <script src="../js/product.js" defer></script>
  <link href="./main.css" rel="stylesheet">
  <title>CANNIGROW Product</title>
</head>
<body>

<?php include __DIR__.'/../components/navbar.php'; ?>

<div class="container-fluid mt-4">

  <!-- نموذج إضافة منتج -->
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <h3 class="card-title mb-4">المنتجات</h3>

      <form method="POST" action="store_Product.php" id="storeForm"
            class="row g-3 needs-validation bg-light border rounded p-3">
        
        <div class="col-12 col-md-6">
          <label for="name_eng" class="form-label">الإسم بالإنجليزي</label>
          <input type="text" name="name_eng" class="form-control" id="name_eng" required />
        </div>

        <div class="col-12 col-md-6">
          <label for="name_ar" class="form-label">الإسم بالعربي</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar" required />
        </div>

        <div class="col-12 col-md-6">
          <label for="unit_price" class="form-label">سعر الوحدة</label>
          <input type="number" name="unit_price" class="form-control" id="unit_price" required />
        </div>

        <div class="col-12 col-md-6">
          <label for="description_ar" class="form-label">وصف المنتج</label>
          <input type="text" name="description_ar" class="form-control" id="description_ar" required />
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary w-100" onclick="addtostore()">إضافة منتج جديد</button>
        </div>

        <div id="message" class="mt-3"></div>
      </form>
    </div>
  </div>

  <!-- جدول المنتجات -->
  <?php if (!empty($products)): ?>
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-4">قائمة المنتجات</h5>

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>الإسم بالإنجليزي</th>
                <th>الإسم بالعربي</th>
                <th>سعر الوحدة</th>
                <th>وصف المنتج</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td><?= htmlspecialchars($product['product_id']) ?></td>
                  <td><?= htmlspecialchars($product['name_eng']) ?></td>
                  <td><?= htmlspecialchars($product['name_ar']) ?></td>
                  <td><?= htmlspecialchars($product['unit_price']) ?></td>
                  <td><?= htmlspecialchars($product['description_ar']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">لا توجد منتجات مضافة بعد.</div>
  <?php endif; ?>

</div>

</body>
</html>
