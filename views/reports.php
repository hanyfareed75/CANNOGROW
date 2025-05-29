<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./main.css" rel="stylesheet">
    <title>التقارير</title>
</head>
<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#orders">
                                <i class="bi bi-cart"></i> تقرير الطلبات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#customers">
                                <i class="bi bi-people"></i> تقرير العملاء
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">لوحة التحكم</h1>
                </div>
                
                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">إجمالي المبيعات</h5>
                                <h2 id="totalSales">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">عدد العملاء</h5>
                                <h2 id="totalCustomers">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">عدد الطلبات</h5>
                                <h2 id="totalOrders">0</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Table -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">تقرير المبيعات</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="reportsTable">
                                <thead>
                                    <tr>
                                        <th>العميل</th>
                                        <th>عدد الطلبات</th>
                                        <th>إجمالي المبيعات</th>
                                        <th>آخر طلب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="position-fixed top-50 start-50 translate-middle d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">جاري التحميل...</span>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="./views/js/reports.js" defer></script>
   
    
</body>
</html>
