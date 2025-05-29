<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>تسجيل عميل جديد</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="./main.css" />

  <style>
    body {
      background: linear-gradient(to left, #f1f8ff, #e0f7fa);
      font-family: 'Tahoma', sans-serif;
    }

    .register-card {
      max-width: 500px;
      margin: auto;
      margin-top: 100px;
      border-radius: 1rem;
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .btn-social {
      width: 100%;
      text-align: center;
      margin-bottom: 10px;
      border-radius: 0.5rem;
    }

    .btn-google {
      background-color: #db4437;
      color: white;
    }

    .btn-github {
      background-color: #24292e;
      color: white;
    }

    .floating-home {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 999;
    }

    h3 {
      font-weight: bold;
    }
  </style>
</head>

<body>

  <!-- Home Button -->
  <a class="btn btn-primary floating-home" href="landingPage.php">الرئيسية</a>

  <!-- Main Card -->
  <div class="container">
    <div class="card register-card shadow-lg p-4">
      <div class="card-body">
        <h3 class="text-center text-success mb-4">تسجيل عميل جديد</h3>

        <!-- OAuth Buttons -->
        <a href="/auth/google" class="btn btn-google btn-social">التسجيل بواسطة Google</a>
        <a href="/auth/github" class="btn btn-github btn-social">التسجيل بواسطة GitHub</a>

        <hr class="my-4">

        <!-- Manual Registration -->
        <form action="register.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">اسم المستخدم</label>
            <input type="text" id="username" name="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" id="password" name="password" class="form-control" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success">تسجيل</button>
          </div>
        </form>

      </div>
    </div>
  </div>

</body>
</html>
