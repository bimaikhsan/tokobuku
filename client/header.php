<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="#">Toko Buku</a>
<?php
    if (isset($_SESSION['username'])) {
        ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=beranda">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=keranjang">Keranjang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=logout">Logout</a>
        </li>
      </ul>
      <span class="navbar-text">
        <?=$_SESSION['email']?>
      </span>
        <?php
    }else{
        ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=beranda">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php?site=daftar">Daftar</a>
        </li>
      </ul>
        <?php
    }
?>

    </div>
  </div>
</nav>
