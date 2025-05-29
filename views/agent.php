<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>مندوب شحن</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <script src="./views/js/agent.js" defer></script>
    <link href="./main.css" rel="stylesheet" />

    <!-- Add responsive styles -->
    <style>
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .table th,
            .table td {
                white-space: nowrap;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                flex-wrap: nowrap;
                align-items: center;
                justify-content: flex-start;
            }

            .action-btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                line-height: 1.2;
                border-radius: 0.2rem;
                white-space: nowrap;
                min-width: 40px;
            }

            .table td:last-child {
                min-width: 100px;
                padding: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__. '/../components/navbar.php'; ?>

    <!-- Update container classes for better responsiveness -->
    <div class="container-fluid container-lg px-3 px-lg-4 mt-4">
        <div class="card shadow-sm">
            <div class="card-body ">
                <h3 class="card-title h4 mb-4 text-center">إضافة مندوب</h3>

                <form method="POST" id="itemForm" class="row g-3 needs-validation bg-light border rounded p-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="agent_name" class="form-label">إسم المندوب</label>
                        <input type="text" 
                               name="agent_name" 
                               id="agent_name" 
                               class="form-control" 
                               required 
                               minlength="3"
                               pattern=".*\S+.*"
                               oninvalid="this.setCustomValidity('الرجاء إدخال اسم صحيح')"
                               oninput="this.setCustomValidity('')" />
                        <div class="invalid-feedback">
                            الرجاء إدخال اسم صحيح
                        </div>
                    </div>

                    <!-- Update all form groups with responsive classes -->
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="address" class="form-label">عنوان</label>
                        <input type="text" name="address" id="address" class="form-control" required />
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="mobile_1" class="form-label">رقم الجوال 1</label>
                        <input type="text" name="mobile_1" id="mobile_1" class="form-control" required />
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="mobile_2" class="form-label">رقم الجوال 2</label>
                        <input type="text" name="mobile_2" id="mobile_2" class="form-control" />
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <input type="text" name="notes" id="notes" class="form-control" />
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="area_id" class="form-label">اختار المنطقة</label>
                        <select class="form-select mb-2" id="area_id" name="area"  required>
                            <option selected disabled>-----اختار المنطقة-----</option>
                            <?php foreach ($selecteditems as $item): ?>
                            <option value="<?= htmlspecialchars($item['area_id']) ?>">
                                <?= htmlspecialchars($item['area_name']) ?> - <?= htmlspecialchars($item['governorate']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-primary w-100" id="addarea">
                            إضافة منطقة
                        </button>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" id="submit" class="btn btn-primary px-4 w-100 w-sm-auto">
                            إضافة مندوب جديد
                        </button>
                    </div>

                    <div id="message" class="col-12">
                        <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">تم إضافة المندوب بنجاح!</div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update tables container -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h3 class="h4 mb-3">المناطق المختارة</h3>
                <div class="table-responsive">
                    <div class="d-block d-md-none small text-muted mb-2">
                        ← اسحب الجدول للمزيد →
                    </div>
                    <table class="table table-hover table-bordered table-striped table-sm" id="areaTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم المنطقة</th>
                            </tr>
                        </thead>
                        <tbody id="areaTbody">
                            <!-- بيانات المناطق ستُضاف هنا -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h3 class="h4 mb-3">قائمة المندوبين</h3>
                <div class="table-responsive">
                    <div class="d-block d-md-none small text-muted mb-2">
                        ← اسحب الجدول للمزيد →
                    </div>
                    <table class="table table-hover table-bordered table-striped table-sm" id="agentsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="d-none d-md-table-cell">#</th>
                                <th scope="col">اسم المندوب</th>
                                <th scope="col" class="d-none d-md-table-cell">العنوان</th>
                                <th scope="col">رقم الجوال 1</th>
                                <th scope="col" class="d-none d-md-table-cell">رقم الجوال 2</th>
                                <th scope="col" class="d-none d-md-table-cell">ملاحظات</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="agentsTbody">
                            <!-- Agents data will be loaded here -->
                            <tr>
                                <td class="d-none d-md-table-cell">{id}</td>
                                <td>{agent_name}</td>
                                <td class="d-none d-md-table-cell">{address}</td>
                                <td>{mobile_1}</td>
                                <td class="d-none d-md-table-cell">{mobile_2}</td>
                                <td class="d-none d-md-table-cell">{notes}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button onclick="editAgent({id})"
                                            class="btn btn-primary action-btn" title="تعديل">
                                            <i class="fas fa-edit d-md-none"></i>
                                            <span class="d-none d-md-inline">تعديل</span>
                                        </button>
                                        <button onclick="deleteAgent({id})"
                                            class="btn btn-danger action-btn" title="حذف">
                                            <i class="fas fa-trash-alt d-md-none"></i>
                                            <span class="d-none d-md-inline">حذف</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update modal for better mobile display -->
    <div class="modal fade" id="editAgentModal" tabindex="-1" aria-labelledby="editAgentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAgentModalLabel">تعديل بيانات المندوب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAgentForm">
                        <input type="hidden" id="edit_agent_id">
                        <div class="mb-3">
                            <label for="edit_agent_name" class="form-label">اسم المندوب</label>
                            <input type="text" class="form-control" id="edit_agent_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">العنوان</label>
                            <input type="text" class="form-control" id="edit_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mobile_1" class="form-label">رقم الجوال 1</label>
                            <input type="text" class="form-control" id="edit_mobile_1" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mobile_2" class="form-label">رقم الجوال 2</label>
                            <input type="text" class="form-control" id="edit_mobile_2">
                        </div>
                        <div class="mb-3">
                            <label for="edit_notes" class="form-label">ملاحظات</label>
                            <input type="text" class="form-control" id="edit_notes">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="saveEditAgent">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
