

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

    <title>الأصناف</title>
  </head>
  <body>
    <?php include './components/navbar.php'; ?>
    <div class="container mt-5">
      <a class="btn btn-primary position-floating bottom-0 end-0" id="goHome" href="landingPage.php">HOME</a>
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">إضافة صنف</h3>
    <?php include '../forms/itemsForm.php';?>
       
        </div>
      </div>
    </div>
    <script></script>
    <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title mb-4">إضافة صنف</h3>

    <table class="table  table-hover table-bordered table-striped table-sm table-responsive " id="userTable">
      <thead>

        <tr>
          <th scope="col">#</th>
          <th scope="col">اسم الصنف</th>
          <th scope="col">وحدة القياس</th>
          <th scope="col">الوصف</th>
        </tr>
      </thead>
      
      <tbody>
       <?php if (empty($items)): ?>
        <p>No items found.</p>
        <p> ($er)</p>
    <?php else: ?>
        
                <?php foreach ($items as $items): ?>
                    <tr>
                      <td><?= htmlspecialchars($items['item_id']) ?></td>
                        <td><?= htmlspecialchars($items['item_name']) ?></td>
                        <td><?= htmlspecialchars($items['measure']) ?></td>
         
                        
                        <td><?= htmlspecialchars($items['description']) ?></td>
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
