

<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>

    <script src="js/main.js"></script>
    <link  href="./main.css" rel="stylesheet">
    <title>الأصناف</title>
  </head>
  <body>
    <?php include './components/navbar.php'; ?>
    <div class="container mt-5">
      
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">إضافة عميل</h3>

          <form method="POST"  id="itemForm" class="row g-3 needs-validation bg-light border rounded" >
            <div class="mb-3 col-md-6">
              <label for="$area_name" class="form-label">إسم المنطقة</label>
              <input
                type="text"
                name="$area_name"
                class="form-control"
                
                required
              />
            </div>

            <div class="mb-3 col-md-6">
              <label for=" $area_desc" class="form-label"> وصف </label>

              <input
                type="text"
                name=" $area_desc"
                class="form-control"
                id=" $mobile_1"
                
                required
              />
            </div>


           
            
            <div class="col-md-6">
              <label for="area" class="form-label">اختار النطاق</label>
              <select class="form-select" id="zone_id" name="zone">
                        
                 <?php foreach ($selecteditems as $selecteditems): ?>
                <option value=<?= htmlspecialchars($selecteditems['zone_id']) ?>><?= htmlspecialchars($selecteditems['zone_name']) ?></option>
                 <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary"value="submit">
              إضافة عميل جديد
            </button>
            <div id="message" class="mt-3">

            <?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Item added successfully!</p>
<?php endif; ?>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script></script>
    <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">إضافة عميل</h3>

    <table class="table  table-hover table-bordered table-striped table-sm table-responsive " id="userTable">
      <thead>

        <tr>
          <th scope="col">#</th>
          <th scope="col">اسم المنطقة</th>
          <th scope="col">وصف المنطقة</th>
          <th scope="col">اختار النطاق</th>

          

         
        </tr>
      </thead>
      
      <tbody>
       <?php if (empty($result)): ?>
        <p>No items found.</p>
        <p> ($er)</p>
    <?php else: ?>
        
                <?php foreach ($result as $result): ?>
                    <tr>
                      <td><?= htmlspecialchars($result['area_id']) ?></td>
                      <td><?= htmlspecialchars($result['area_name']) ?></td>
                      <td><?= htmlspecialchars($result['area_desc']) ?></td>
                      <td><?= htmlspecialchars($result['zone_id']) ?></td>
                    </tr>
                                  
                <?php endforeach; ?>
           
    <?php endif; ?>
  


      </tbody>
    </table>
    
    </div>
    </div>
    </div>
  </body>
</html>
