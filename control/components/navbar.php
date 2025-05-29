<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Canigrow</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">

        <!-- Correctly wrapped HOME link -->
        <li class="nav-item">
          <a class="nav-link" href="/managment/">HOME</a>
        </li>

        <!-- Manufacturing Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            تصنيع
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?recipe">وصـفات</a></li>
            <li><a class="dropdown-item" href="?items">أصـناف</a></li>
            <li><a class="dropdown-item" href="?store">مـخـزن</a></li>
          </ul>
        </li>

        <!-- Sales Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            مبيعات
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?products">منتـجـات</a></li>
            <li><a class="dropdown-item" href="?orders">أوامـر بيـع</a></li>
            <li><a class="dropdown-item" href="?customers">عمـلاء</a></li>
            <li><a class="dropdown-item" href="/views/complains.html">شكـاوى</a></li>
            <li><a class="dropdown-item" href="?agents">مندوب الشحن</a></li>
            <li><a class="dropdown-item" href="?orderDelivary">تسليم أوردر</a></li>
          </ul>
        </li>

        <!-- Accounts Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            حسابات
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?accTrans">اليومية</a></li>
            <li><a class="dropdown-item" href="/views/journal.html">دفتر أستاذ</a></li>
            <li><a class="dropdown-item" href="/views/gl.html">القيود</a></li>
          </ul>
        </li>

        <!-- Reports Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            تقارير
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/views/dailttrans.html">تقارير مخزن</a></li>
            <li><a class="dropdown-item" href="/views/journal.html">تقارير مبيعات</a></li>
            <li><a class="dropdown-item" href="/views/gl.html">تقارير حسابات</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
