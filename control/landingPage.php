<!DOCTYPE html>
<html lang="en">
<head>
  <title>Landing Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
  <link  href="./main.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Sofia', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      background-color: #343a40;
      min-width: 250px;
      padding: 15px;
      color: white;
    }

    .sidebar a {
      display: block;
      padding: 8px;
      color: #ffffff;
      text-decoration: none;
      border-radius: 4px;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .content {
      flex: 1;
      padding: 20px;
    }

    @media (max-width: 768px) {
      .d-flex {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        order: 2;
      }

      .content {
        order: 1;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Canigrow</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">

          <!-- Manufacturing Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              تصنيع
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?recipe">وصـفات</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?items">أصـناف</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?store">مـخـزن</a></li>
            </ul>
          </li>

          <!-- Sales Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              مبيعات
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?products">منتـجـات</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?orders">أوامـر بيـع</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?customers">عمـلاء</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/views/complains.html">شكـاوى</a></li>
              
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?agents">مندوب الشحن</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?orderDelivary">تسليم أوردر</a></li>
            </ul>
          </li>

          <!-- Accounts Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              حسابات
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?accTrans">اليومية</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/views/journal.html">دفتر أستاذ</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/views/gl.html">القيود</a></li>
            </ul>
          </li>

          <!-- Reports Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              تقارير
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/views/dailttrans.html">تقارير مخزن</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?reports">تقارير مبيعات</a></li>
              <li><a class="dropdown-item" href="https://cannigrow.free.nf/control/?reports">تقارير حسابات</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Layout -->
  <div class="d-flex flex-wrap ">
    <!-- Sidebar -->
   <!-- Sidebar -->
<div class="sidebar text-center custom_font" >
  <h1 class="text-white">القائمة الجانبية</h1>
  <hr>
  <h2 class="text-white">تصنيع</h2>
  <a href="https://cannigrow.free.nf/control/?recipe">وصـفات</a>
  <a href="https://cannigrow.free.nf/control/?items">أصـناف</a>
  <a href="https://cannigrow.free.nf/control/?store">مـخـزن</a>
  <hr>
  <h2 class="text-white">مبيعات</h2>
  <a href="https://cannigrow.free.nf/control/?products">منتـجـات</a>
  <a href="https://cannigrow.free.nf/control/?orders">أوامـر بيـع</a>
  <a href="https://cannigrow.free.nf/control/?customers">عمـلاء</a>
  <a href="https://cannigrow.free.nf/control/views/complains.html">شكـاوى</a>
 
  <a href="https://cannigrow.free.nf/control/?agents">مندوب الشحن</a>
  <a href="https://cannigrow.free.nf/control/?orderDelivary">تسليم أوردر</a>
  <hr>
  <h2 class="text-white">حسابات</h2>
  <a href="https://cannigrow.free.nf/control/?accTrans">اليومية</a>
  <a href="https://cannigrow.free.nf/control/views/journal.html">دفتر أستاذ</a>
  <a href="https://cannigrow.free.nf/control/views/gl.html">القيود</a>
  <hr>
  <h2 class="text-white">تقارير</h2>
  <a href="https://cannigrow.free.nf/control/views/dailttrans.html">تقارير مخزن</a>
  <a href="https://cannigrow.free.nf/control/?reports">تقارير مبيعات</a>
  <a href="https://cannigrow.free.nf/control/views/gl.html">تقارير حسابات</a>
</div>


    <!-- Content -->
    <div class="content">
    <h1 class="text-center mb-4">مرحباً بك في صفحة الإدارة</h1>
    
    <div class="container fw-bold fs-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row g-4">
                    <!-- Sales Card -->
                    <div class="col-sm-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center bg-warning ">
                                <i class="bi bi-cart fs-1 text-primary mb-3"></i>
                                <h5 class="card-title">مبيعات</h5>
                                <p class="card-text">إدارة المبيعات والطلبات والعملاء</p>
                                <a href="?orders" class="btn btn-primary">فتح</a>
                            </div>
                        </div>
                    </div>

                    <!-- Manufacturing Card -->
                    <div class="col-sm-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-gear fs-1 text-success mb-3"></i>
                                <h5 class="card-title">التصنيع</h5>
                                <p class="card-text">إدارة الوصفات والمخزون</p>
                                <a href="?recipe" class="btn btn-success">فتح</a>
                            </div>
                        </div>
                    </div>

                    <!-- Accounts Card -->
                    <div class="col-sm-6">
                        <div class="card h-100 shadow-sm bg-success">
                            <div class="card-body text-center">
                                <i class="bi bi-calculator fs-1 text-info mb-3"></i>
                                <h5 class="card-title">مشتريات</h5>
                                <p class="card-text">  لاجراء عملية شراء /  تسجيل مصروفات  </p>
                                <a href="?accTrans" class="btn btn-info">فتح</a>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Card -->
                    <div class="col-sm-6">
                        <div class="card h-100 shadow-sm bg-info">
                            <div class="card-body text-center">
                                <i class="bi bi-file-earmark-bar-graph fs-1 text-warning mb-3"></i>
                                <h5 class="card-title">التقارير</h5>
                                <p class="card-text">عرض وتحليل البيانات</p>
                                <a href="?reports" class="btn btn-warning">فتح</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  </div>

</body>
</html>
