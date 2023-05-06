<?php
include 'admin/operacje-header.php';
global $connection;
global $logo;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow bg-white rounded">
  <a class="navbar-brand" href="/"><img style="width:200px" src="<?php echo $logo; ?>"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div style="padding-right:150px;" class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php
      include 'admin/operacje-menu.php';
      $aktualnaStrona = $_SERVER['REQUEST_URI'];
      $aktualnaStrona = strtok($aktualnaStrona, '?');
      $naglowek = $connection->query("SELECT naglowek_h1 FROM strony WHERE url_strony='$aktualnaStrona'");
      if (mysqli_num_rows($naglowek) != "") {
        $row = mysqli_fetch_assoc($naglowek);
        $naglowek = $row["naglowek_h1"];
      } else {
        $naglowek = $connection->query("SELECT tytul_wpisu FROM blog WHERE url_wpisu='$aktualnaStrona'");
        if (mysqli_num_rows($naglowek) != "") {
        $row = mysqli_fetch_assoc($naglowek);
        $naglowek = $row["tytul_wpisu"];
        }else{
          $naglowek="404 - Strona nie istnieje...";
        }
      }
      $zdjecieTlo = $connection->query("SELECT id_ustawienia, zdjecie_tlo FROM ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1");
      $row = mysqli_fetch_assoc($zdjecieTlo);
      $zdjecieTlo = $row["zdjecie_tlo"];
      ?>
    </ul>
</nav>
<section id="hero" class="d-flex align-items-center" style="background: url(<?php echo $zdjecieTlo; ?>) top left; width: 100%;">
  <div class="container" data-aos="zoom-out" data-aos-delay="100">
    <h1><?php echo strval($naglowek); ?></h1>
  </div>
</section>