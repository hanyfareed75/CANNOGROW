<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تعديل الملف الشخصي</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background: #f0f2f5;
      font-family: 'Tahoma', sans-serif;
    }
    .profile-form {
      max-width: 700px;
      margin: 80px auto;
      padding: 30px;
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #0d6efd;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="profile-form">
      <h3 class="text-center text-primary mb-4">تعديل الملف الشخصي</h3>
      <form action="update-profile.php" method="POST" enctype="multipart/form-data">
        
        <!-- Avatar Upload -->
        <div class="text-center">
          <img src="https://via.placeholder.com/120" class="profile-img" id="avatarPreview" alt="صورة المستخدم">
          <div class="mb-3">
            <input type="file" class="form-control mt-2" name="avatar" accept="image/*" onchange="previewAvatar(event)">
          </div>
        </div>

        <!-- Name -->
        <div class="mb-3">
          <label for="name" class="form-label">الاسم الكامل</label>
          <input type="text" class="form-control" id="name" name="name" value="أحمد محمد" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">البريد الإلكتروني</label>
          <input type="email" class="form-control" id="email" name="email" value="ahmed@example.com" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
          <label for="phone" class="form-label">رقم الهاتف</label>
          <input type="text" class="form-control" id="phone" name="phone" value="01012345678">
        </div>

        <!-- City -->
        <div class="mb-4">
          <label for="city" class="form-label">المدينة</label>
          <input type="text" class="form-control" id="city" name="city" value="القاهرة">
        </div>

        <!-- Submit -->
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
        </div>

      </form>
    </div>
  </div>

  <script>
    function previewAvatar(event) {
      const reader = new FileReader();
      reader.onload = function () {
        document.getElementById('avatarPreview').src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

</body>
</html>
