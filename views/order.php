<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CANNIGROW ORDERS</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

  <!-- Custom JS -->
  <script src="./views/js/orders.js" defer></script>
  <link href="./main.css" rel="stylesheet">
  <style>
    #addorder {
      width: 200px;
      height: 200px;
      font-size: 1.2rem;
      border-radius: 50%;
      background-color: #28a745;
      color: white;
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.2s, box-shadow 0.2s;

    }
    #addorder:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    #addtocart {
      width: 200px;
      height: 50px;
      font-size: 1.2rem;
      border-radius: 5px;
      background-color:rgb(164, 192, 239);
      color: white;
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.2s, box-shadow 0.2s;

    }
    #addtocart:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #80bdff;
    }
    .form-select:focus {
      box-shadow: none;
      border-color: #80bdff;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .table th {
      background-color: #f8f9fa;
    }
    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #f2f2f2;
    }
    .table-striped tbody tr:nth-of-type(even) {
      background-color: #ffffff;
    }
    .table-bordered {
      border: 1px solid #dee2e6;
    }
    .table-bordered th, .table-bordered td {
      border: 1px solid #dee2e6;
    }
    .table-responsive {
      margin-top: 20px;
    }
    .card {
      border-radius: 10px;
    }
    .card-body {
      padding: 20px;
    }
    .card-title {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .form-label {
      font-weight: bold;
    }
    .form-control, .form-select {
      border-radius: 5px;
    }
    .btn {
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 1rem;
      font-weight: bold;
    }
    .btn:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transform: translateY(-2px);
    }
    .text-bg-success {
      background-color: #d4edda !important;
      color: #155724 !important;
    }
    .text-bg-warning {
      background-color: #fff3cd !important;
      color: #856404 !important;
    }
    .text-bg-danger {
      background-color: #f8d7da !important;
      color: #721c24 !important;
    }
    .text-bg-info {
      background-color: #d1ecf1 !important;
      color: #0c5460 !important;
    }
    .text-bg-primary {
      background-color: #cce5ff !important;
      color: #004085 !important;
    }
    .text-bg-secondary {
      background-color: #e2e3e5 !important;
      color: #383d41 !important;
    }
    .text-bg-light {
      background-color: #fefefe !important;
      color: #818182 !important;
    }
  </style>
</head>
<body>

<?php include __DIR__.'/../components/navbar.php'; ?>

<main class="container-fluid my-4">

  <!-- Order Info -->
  <section class="card shadow-sm mb-4">
    <div class="card-body">
      <h1 class="card-title mb-4 text-center">أوامر البيع</h1>

      <form class="row g-3 align-items-end">
        <div class="col-12 col-md-2">
          <label for="order_id" class="form-label">رقم الأمر</label>
          <input readonly id="order_id" name="order_id" class="form-control text-bg-success text-center fw-bold fs-5" required />
        </div>

        <div class="col-12 col-md-3">
          <label for="created_at" class="form-label">التاريخ</label>
          <input type="date" id="created_at" name="created_at" class="form-control"
            value="<?php echo (new DateTime())->format('Y-m-d'); ?>" required />
        </div>

        <div class="col-12 col-md-4">
          <label for="cust_id" class="form-label">العميل</label>
          <select id="cust_id" name="cust_id" class="form-select" required>
            <option value="" disabled selected>---- اختر ----</option>
            <?php foreach ($customers as $customer): ?>
              <option value="<?= htmlspecialchars($customer['cust_id']) ?>">
                <?= htmlspecialchars($customer['cust_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-6 col-md-2">
          <label for="sp_discounts" class="form-label fw-bold">٪ الخصم</label>
          <input type="number" id="sp_discounts" name="sp_discounts" min="0" max="100" step="0.01"
            value="0" class="form-control text-center fw-bold fs-5" />
        </div>

        <div class="col-6 col-md-3 d-flex flex-column">
          <label for="order_value" class="form-label fw-bold">القيمة الإجمالية</label>
          <input type="number" id="order_value" name="order_value" readonly step="0.01"
            value="0.00" class="form-control text-bg-warning text-center fw-bold fs-5 mb-2" />
        
        </div>

        <div id="message" class="mt-3"></div>
      </form>
    </div>
  </section>

  <!-- Add Product -->
  <section class="mb-5">
    <h3 class="mb-4">المنتجات</h3>

    <form id="productForm" class="row g-3 needs-validation bg-light border rounded p-3">
      <div class="col-12 col-md-6">
        <label for="product_id" class="form-label">اختار المنتج</label>
        <select id="product_id" name="product_id" class="form-select" required>
          <option value="" disabled selected>---- اختر ----</option>
          <?php foreach ($selecteditems as $item): ?>
            <option value="<?= htmlspecialchars($item['product_id']) ?>">
              <?= htmlspecialchars($item['name_eng']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-md-6">
        <label for="qty" class="form-label">الكمية</label>
        <input type="number" id="qty" name="qty" min='1' value="1" class="form-control" required />
      </div>

      <div class="col-12 col-md-6">
        <label for="total" class="form-label">المجموع (جنيه)</label>
        <input type="number" id="total" name="value" step="0.01" value="0" readonly class="form-control" />
      </div>

      <div class="col-12">
        <label for="notes" class="form-label">ملاحظات</label>
        <input type="text" id="notes" name="notes" class="form-control" placeholder="أدخل ملاحظات إضافية" />
      </div>

      <div class="col-12 d-flex justify-content-start">
        <button type="button" id="addtocart" class="btn ">إضافة منتج</button>
      </div>

    </form>
   
  </section>

  <!-- Cart Table -->
  <section>
    <div class="table-responsive">
      <table class="table table-striped table-bordered text-center align-middle" id="cartTable">
        <thead class="table-primary">
          <tr>
            <th>رقم تسلسلي</th>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>القيمة (جنيه)</th>
            <th>ملاحظات</th>
          </tr>
        </thead>
        <tbody id="cartTableBody">
          <!-- Dynamic rows -->
        </tbody>
      </table>
    </div>
  </section>
  <div class="col-12 d-flex justify-content-center m-3" >
       
    <button type="button" id="addorder" class="btn  " >إضافة أمر بيع</button>
    </div>
</main>

</body>
</html>
