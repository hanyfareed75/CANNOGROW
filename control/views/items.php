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
  <link href="./main.css" rel="stylesheet">
  <script src="views/js/items.js" defer></script>
  <title>الأصناف</title>
</head>
<body>

<?php include './components/navbar.php'; ?>

<div class="container-fluid mt-4">

  <!-- نموذج إضافة صنف -->
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <h3 class="card-title mb-4">إضافة صنف</h3>

      <form method="POST" id="itemForm" class="row g-3 needs-validation bg-light border rounded p-3">

        <div class="col-12 col-md-6">
          <label for="name" class="form-label">إسم الصنف</label>
          <input
            type="text"
            name="item_name"
            class="form-control"
            id="name"
            placeholder="فراخ مفروم"
            required
          />
        </div>

        <div class="col-12 col-md-6">
          <label for="measure" class="form-label">وحدة القياس</label>
          <input
            type="text"
            name="measure"
            class="form-control"
            id="measure"
            placeholder="كيلوجرام"
            required
          />
        </div>

        <div class="col-12 col-md-6">
          <label for="description" class="form-label">وصف الصنف</label>
          <input
            type="text"
            name="description"
            class="form-control"
            id="description"
            placeholder="فراخ مفرومة مستوية"
          />
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">إضافة صنف جديد</button>
        </div>

        <div id="message" class="mt-3">
          <?php if (isset($_GET['success'])): ?>
            <p class="text-success">تمت إضافة الصنف بنجاح!</p>
          <?php endif; ?>
        </div>

      </form>
    </div>
  </div>

  <!-- جدول الأصناف -->
  <div class="card shadow-sm mb-5">
    <div class="card-body">
      <h3 class="card-title mb-4">الأصناف</h3>

      <!-- Add this before the table -->
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="البحث عن صنف...">
            <button class="btn btn-outline-secondary" type="button" id="searchBtn">
              <i class="bi bi-search"></i> بحث
            </button>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">اسم الصنف</th>
              <th scope="col">وحدة القياس</th>
              <th scope="col">الوصف</th>
              <!-- Add this column to table header -->
              <th scope="col">الإجراءات</th>
            </tr>
          </thead>
          <tbody id="itemTableBody">
            <?php if (empty($items)): ?>
              <tr>
                <td colspan="5" class="text-danger">لا توجد أصناف حاليًا.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($items as $items): ?>
                <tr>
                  <td><?= htmlspecialchars($items['item_id']) ?></td>
                  <td><?= htmlspecialchars($items['item_name']) ?></td>
                  <td><?= htmlspecialchars($items['measure']) ?></td>
                  <td><?= htmlspecialchars($items['description']) ?></td>
                  <!-- Add this in the items loop -->
                  <td>
                    <button class="btn btn-sm btn-primary edit-item" data-id="<?= $items['item_id'] ?>">
                      تعديل
                    </button>
                    <button class="btn btn-sm btn-danger delete-item" data-id="<?= $items['item_id'] ?>">
                      حذف
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Add pagination controls -->
      <div class="d-flex justify-content-between align-items-center mt-3">
          <div class="page-info">
              عرض <?= $startRecord ?> إلى <?= $endRecord ?> من <?= $totalRecords ?> صنف
          </div>
          <nav aria-label="Page navigation">
              <ul class="pagination">
                  <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                      <a class="page-link" href="?page=<?= $currentPage-1 ?>">السابق</a>
                  </li>
                  <!-- Add page numbers here -->
                  <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                      <a class="page-link" href="?page=<?= $currentPage+1 ?>">التالي</a>
                  </li>
              </ul>
          </nav>
      </div>

    </div>
  </div>

</div>
  



</body>
</html>
