<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>فاتورة</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

  <!-- Custom CSS and JS -->
  <link href="./main.css" rel="stylesheet">
  <script src="js/recipte.js" defer></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      max-width: 800px;
      margin: auto;
      margin-top: 30px;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    @media (max-width: 576px) {
      .fs-5 {
        font-size: 1.1rem !important;
      }

      h1, h2 {
        font-size: 1.5rem !important;
      }
    }
  </style>
</head>

<body>
  <div class="card border-5 border-warning shadow-sm">
    <div class="card-body">

      <div class="text-center mb-4">
        <img src="./assets/imgs/cannigrow.png" alt="Cannigrow" width="120" />
        <h1 class="mt-3">فاتورة</h1>
        <h2>CANNIGROW</h2>
      </div>

      <div class="mb-3">
        <ul class="list-unstyled text-end">
          <li id="customer_name" class="fw-bold">John Doe</li>
          <li id="order_id" class="text-muted">فاتورة رقم: <span class="text-black fw-bold">123456</span></li>
          <li id="created_at" class="text-muted">التاريخ: <span>--/--/----</span></li>
        </ul>
      </div>

      <hr />

      <div class="container px-0">
        <div class="row text-center fw-bold bg-light py-2 d-none d-md-flex">
          <div class="col">#</div>
          <div class="col-4">اسم المنتج</div>
          <div class="col">سعر الوحدة</div>
          <div class="col">الكمية</div>
          <div class="col">الإجمالي</div>
        </div>

        <!-- Table Body -->
        <div id="cartTableBody" class="mb-3">
          <!-- JS will populate this -->
        </div>

        <hr style="border: 2px solid black;" />

        <div class="row">
          <div class="col-12 text-end">
            <p id="order_value" class="fs-5 fw-bold">الإجمالي الكلي: 0.00</p>
          </div>
        </div>

        <hr style="border: 2px solid black;" />

        <p class="text-center my-4 fs-5">شكراً على ثقتكم الغالية</p>

        <div class="text-center mb-4">
          <u class="text-info">CANNIGROW</u>
        </div>

        <div class="text-center">
          <button class="btn btn-warning btn-lg w-100 fw-bold" id="confirmBtn">تأكيد الأوردر</button>
        </div>
      </div>
    </div>
  </div>

  <pre id="orderSummary" class="d-none"></pre>
</body>

</html>
