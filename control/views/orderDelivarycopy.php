<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تسليم أوردر</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <!-- Custom JS -->
    <script src="views/js/orderDelivary.js" defer></script>
     
    <link href="./main.css" rel="stylesheet" />
    <style>
        /* Base styles */
        :root {
            --primary-color: #003366;
            --secondary-color: #002244;
            --warning-bg: #fff3cd;
            --border-radius: 8px;
        }

        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: clamp(0.875rem, 2vw, 1rem);
            line-height: 1.5;
        }

        /* Card styles */
        .card {
            margin: 1rem;
            border-radius: var(--border-radius);
        }

        .card-title {
            background-color: var(--primary-color);
            color: white;
            padding: clamp(0.5rem, 3vw, 1rem);
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: clamp(1.2rem, 4vw, 1.6rem);
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 51, 102, 0.3);
            margin: 1rem 0;
        }

        /* Form elements */
        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            font-size: clamp(1rem, 2.5vw, 1.1rem);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            font-size: clamp(0.875rem, 2vw, 1rem);
            padding: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
        }

        /* Buttons */
        .btn {
            font-size: clamp(0.875rem, 2.5vw, 1.1rem);
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            width: min(100%, 300px);
        }

        /* Tables */
        .table-responsive {
            margin-top: 1rem;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
        }

        /* Custom elements */
        #delivaryfees {
            background-color: var(--warning-bg);
            font-weight: 700;
            text-align: center;
            border-width: 2px !important;
            max-width: 200px;
        }

        /* Responsive layout adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0.5rem;
            }

            .card-body {
                padding: 1rem;
            }

            .row {
                margin: 0;
                gap: 1rem;
            }

            .col-12 {
                padding: 0;
            }

            #creatdelivary {
                width: 100%;
                margin: 1rem 0;
                height: auto;
                padding: 0.5rem;
            }

            .table-responsive {
                border: 1px solid #dee2e6;
                border-radius: var(--border-radius);
            }

            select[multiple] {
                height: 150px !important;
            }

            .btn-primary {
                width: 100%;
                margin: 1rem 0;
            }
        }

        /* Small screen optimizations */
        @media (max-width: 576px) {
            .card-title {
                margin: 0.5rem 0;
            }

            .form-label {
                margin-top: 0.5rem;
            }

            .table {
                font-size: 0.75rem;
            }

            th, td {
                padding: 0.25rem !important;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <div class="container mt-4 mb-5">
        <div class="card shadow">
            <div class="card-body px-3 px-md-5">
            
                <h3 class="card-title">تسليم أوردر</h3>

                    <p class="text-muted
                <form method="POST" id="itemForm" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>" />
                    <input type="hidden" name="delivary_id" id="delivary_id" value="<?= htmlspecialchars($delivary_id) ?>" />

                    <!-- Date and Agent Section -->
                    <p class="text-muted mb-4">
                        <i class="bi bi-info-circle-fill"></i>
                        يرجى ملء التفاصيل التالية لتسليم الأوردرات. تأكد من اختيار المندوب الصحيح وتاريخ التسليم.
                    </p>


                <section class="mb-4 border border-2 border-primary rounded p-3">
                    <h5 class="text-primary mb-3">تفاصيل التسليم</h5>
                  
                <!-- Date and Agent section -->
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label for="delivaryDate" class="form-label">تاريخ</label>
                            <input type="date" name="delivaryDate" id="delivaryDate" class="form-control" required
                                value="<?php echo (new DateTime())->format('Y-m-d'); ?>" />
                            <div class="invalid-feedback">يرجى اختيار تاريخ صالح.</div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <label for="agentselect" class="form-label">المندوب</label>
                            <select class="form-select" id="agentselect" name="agent" required>
                                <option value="" selected disabled>-----اختار المندوب-----</option>
                                <?php foreach ($agents as $item): ?>
                                <option value="<?= htmlspecialchars($item['agent_id']) ?>">
                                    <?= htmlspecialchars($item['agent_name']) ?> -
                                    <?= htmlspecialchars($item['mobile_1']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار مندوب.</div>
                      
                    </div>
                    
                    <!-- Delivery Fee -->
                  
                        <div class="col-12 col-md-4">
                            <label for="delivaryfees" class="form-label">رسوم التوصيل</label>
                            <input type="number" name="delivaryfees" id="delivaryfees" min="0" value="50" step="0.01" required
                                class="form-control border border-warning border-3 rounded-pill fw-bold text-center" />
                            <div class="invalid-feedback">يرجى إدخال رسوم توصيل صحيحة.</div>
                        </div>
                        </section>
                
                        <section class="mb-4 border border-2 border-primary rounded p-3">
                    <!-- Order Selection and Tables -->
                    <div class="row mb-4 g-4">

                        <div class="col-12 col-md-7">
                            <label for="orderselect" class="form-label">اختار الأوردر</label>
                            <select class="form-select mb-3" id="orderselect" name="order" required>
                                <option value="" disabled selected>الاسم-المنطقة-عددالاوردرات-قيمة الاوردرات</option>
                                <?php foreach ($result as $item): ?>
                                <option value="<?= htmlspecialchars($item['cust_id']) ?>">
                                    <?= htmlspecialchars($item['cust_name']) ?> -
                                    <?= htmlspecialchars($item['area_name']) ?> -
                                    <?= htmlspecialchars($item['total_orders']) ?> -
                                    <?= htmlspecialchars($item['total_spent']) ?> جنية 
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار طلب واحد على الأقل.</div>

                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover table-bordered table-striped table-sm mb-3">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">رقم الأوردر</th>
                                            <th scope="col">اسم المنتج</th>
                                            <th scope="col">الكمية</th>
                                            <th scope="col">سعر الوحدة</th>
                                            <th scope="col">الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderTbody"></tbody>
                                </table>
                            </div>

                            <div class="mt-3 text-end">
                                <h5>إجمالي الفاتورة:
                                    <span class="fw-bold text-danger" id="totalPrice">0</span> جنيه مصري
                                </h5>
                            </div>
                        </div>
</section>
                        <!-- Delivery Add Button -->
                        <div class="col-12 col-md-1 d-flex justify-content-center align-items-start mt-3 mt-md-4">
                            <button type="button" id="creatdelivary" class="btn btn-light shadow-sm"
                                >اضافة </button>
                        </div>

                        <!-- Agent Table -->
                        <div class="col-12 col-md-4">
                            <label class="form-label">جدول المندوب</label>
                            <div class="table-responsive shadow-sm rounded">
                                <table class="table table-hover table-bordered table-striped table-sm">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">اسم المندوب</th>
                                            <th scope="col">رقم الأوردر</th>
                                            <th scope="col">المنطقة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="agentTbody"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="button" id="opendelivaryorder" 
    data-bs-toggle="modal" 
    data-bs-target="#delivaryDetails" 
    class="btn btn-primary px-5">
    إضافة أمر توصيل أوردر
</button>
                    </div>

                    <!-- Message -->
                    

                    <!-- Error Handling -->
                    <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>
                </form>
            </div>
            <div class="modal fade" id="delivaryDetails" tabindex="-1" aria-labelledby="editAgentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAgentModalLabel"> تفاصيل امر التوصيل</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle-fill"></i>
                    يرجى التأكد من صحة المعلومات قبل إضافة أمر التوصيل. يمكنك تعديل التفاصيل بعد الإضافة.
                </p>
            </div>

        </div>
    </div>

    <!-- Add loading spinner -->
    <div id="loadingSpinner" class="position-fixed top-50 start-50 translate-middle d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">جاري التحميل...</span>
        </div>
    </div>

    <script>
        // Form validation
        (() => {
            'use strict'
            
            function validateDelivery() {
                const agent_id = document.getElementById('agentselect').value;
                const order_id = document.getElementById('orderselect').value;
                const deliveryFees = document.getElementById('delivaryfees').value;
                const deliveryDate = document.getElementById('delivaryDate').value;

                if (!agent_id || !order_id || !deliveryFees || !deliveryDate) {
                    showError('جميع الحقول مطلوبة');
                    return false;
                }

                if (parseFloat(deliveryFees) < 0) {
                    showError('رسوم التوصيل يجب أن تكون قيمة موجبة');
                    return false;
                }

                return true;
            }

            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity() || !validateDelivery()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

</body>

</html>
