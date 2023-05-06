<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://cdn.tiny.cloud/1/p8y5shd5vcv2u35b0t6f7coi9hyfxw5cz4smpg9pohlgckks/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="/panel/css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div id="menuAdmina" class="bocznemenu">
  <a href="javascript:void(0)" class="przyciskZamknij" onclick="zamknijMenu()">&times;</a>
  <a href="/panel/">Home</a>
  <a href="strony.php">Strony</a>
  <?php 
$zapytanie = "SELECT * FROM ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1";
try {
    $wykonaneZapytanie = $connection->query($zapytanie);
  } catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }
  $pobraneUstawienia = mysqli_fetch_assoc($wykonaneZapytanie);
  $blogWlaczony=$pobraneUstawienia['czy_blog'];
if($blogWlaczony==1){
?>
  <a href="blog.php">Blog</a>
<?php
}
?>
  <a href="ustawienia.php">Ustawienia</a>
  <a href="ustawienia-seo.php">SEO</a>
  <a href="uzytkownicy.php">Użytkownicy</a>
  <a href="przekierowania.php">Przekierowania</a>
  <a href="zdjecia.php">Zdjęcia</a>
</div>
<!-- Use any element to open the bocznemenu -->
<nav class="sticky-navbar navbar navbar-dark" style="background-color: #111;">
<div class="container-fluid">
<span id="menuAdmina" onclick="otworzMenu()"><i style="font-size:32px;color:#818181;"class="bi bi-arrow-bar-right"></i></span></a>
<div class="row vertical-align">
<span>Zalogowałeś się jako<b>
<?php
global $sesja;
echo $sesja;
?>
</b>
</span>
<form action="" method="post">
<input class="btn btn-info ml-4" type="submit" name="wyloguj" value="Wyloguj" />
</form>
</div>
</div>
</nav>
<?php
if(isset($_POST['wyloguj']))
{
    session_destroy();
    header("Location: /logowanie");
}
?>