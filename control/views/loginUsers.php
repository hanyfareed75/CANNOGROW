<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>تسجيل الدخول</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e0f7fa);
      font-family: 'Tahoma', sans-serif;
    }
    .login-card {
      max-width: 450px;
      margin: auto;
      margin-top: 100px;
      border-radius: 1rem;
    }
    .form-control {
      border-radius: 0.5rem;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .btn-primary {
      border-radius: 0.5rem;
    }
    .btn-social {
      width: 100%;
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
    h3 {
      font-weight: bold;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="card login-card shadow-lg p-4">
      <div class="card-body">
        <h3 class="text-center text-primary mb-4">تسجيل الدخول</h3>

        <!-- OAuth Buttons -->
        <a href="/auth/google" class="btn btn-google btn-social">تسجيل الدخول بواسطة Google</a>
        <a href="/auth/github" class="btn btn-github btn-social">تسجيل الدخول بواسطة GitHub</a>

        <hr class="my-4">

        <!-- Manual Login Form -->
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">دخول</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
