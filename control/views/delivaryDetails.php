<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تفاصيل الأوردر</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
  <!-- Custom JS & CSS -->
  <script src="js/delivaryDetails.js" defer></script>
  <link href="./main.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-header h5 {
      font-weight: bold;
    }

    .btn-confirm {
      font-size: 1.2rem;
      padding: 12px;
    }

    @media (max-width: 576px) {
      .card-body p {
        font-size: 0.95rem;
      }

      .btn-confirm {
        font-size: 1rem;
        padding: 10px;
      }
    }
  </style>
</head>

<body class="bg-light">

  <div class="container py-4 px-3">

    <!-- المندوب -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">المندوب</h5>
      </div>
      <div class="card-body">
        <p><strong>اسم المندوب:</strong> <span id="agentNameValue">--</span></p>
        <p><strong>تليفون:</strong> <span id="agentPhone">--</span></p>
      </div>
    </div>

    <!-- العميل -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0">العميل</h5>
      </div>
      <div class="card-body">
        <p><strong>اسم العميل:</strong> <span id="cust_name">--</span></p>
        <p><strong>تليفون 1:</strong> <span id="mobile_1">--</span></p>
        <p><strong>تليفون 2:</strong> <span id="mobile_2">--</span></p>
        <p><strong>العنوان:</strong> <span id="address">--</span></p>
        <p><strong>المنطقة:</strong> <span id="areaname">--</span></p>
      </div>
    </div>

    <!-- الأوردرات -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-info text-white">
        <h5 class="mb-0">الأوردرات (عدد: <span id="orderCount">0</span>)</h5>
      </div>
      <div class="card-body">
        <div id="ordersContainer">
          <!-- المحتوى يتم تحميله من JS -->
        </div>
      </div>
    </div>

    <!-- زر التأكيد -->
    <div class="text-center">
      <button class="btn btn-primary btn-confirm w-100 fw-bold" id="confirmButton">تأكيد أوردر التوصيل</button>
    </div>

  </div>

</body>

</html>
