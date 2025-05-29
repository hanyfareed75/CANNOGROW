 

          <form method="POST" action="store_item.php" id="itemForm" class="row g-3 needs-validation bg-light border rounded" >
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">إسم الصنف</label>
              <input
                type="text"
                name="item_name"
                class="form-control"
                id="name"
                placeholder=" فراخ مفروم"
                required
              />
            </div>

            <div class="mb-3 col-md-6">
              <label for="measure" class="form-label">وحدة القياس</label>

              <input
                type="text"
                name="measure"
                class="form-control"
                id="measure"
                placeholder=" كيلوجرام"
                required
              />
            </div>


            <div class="mb-3 col-md-6">
              <label for="description" class="form-label">وصف الصنف</label>
              <input
                type="text"
                name="description"
                class="form-control"
                id="description"
                placeholder="فراخ مفرومة مستوية "
              />
            </div>

            <button type="submit" class="btn btn-primary"value="submit">
              إضافة صنف جديد
            </button>
            <div id="message" class="mt-3">

            <?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Item added successfully!</p>
<?php endif; ?>
            </div>
          </form>
     