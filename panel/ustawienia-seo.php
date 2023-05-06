<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
$zapytanie = "SELECT * FROM ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1";
try {
  $wykonaneZapytanie = $connection->query($zapytanie);
}
catch (Exception $e) {
  echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
$pobraneUstawienia = mysqli_fetch_assoc($wykonaneZapytanie);
$idUstawienia = $pobraneUstawienia['id_ustawienia'];
$czyHTTPS = $pobraneUstawienia['czy_https'];
$czyWWW = $pobraneUstawienia['czy_www'];
$kodGSC = $pobraneUstawienia['kod_gsc'];
$kodGTMHead = $pobraneUstawienia['kod_GTM_head'];
$kodGTMBody = $pobraneUstawienia['kod_GTM_body'];
$kodGA = $pobraneUstawienia['kod_GA'];
?>
<div class="mx-auto w-75 p-3" id="main">
  <form action="/panel/strony.php">
    <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
  </form>
  <h1 class="text-center h3">Ustawienia SEO</h1>
  <small id="nazwa_strony_help" class=" text-center form-text text-muted">Pamiętaj, aby być ostrożnym ze zmianami. W momencie, gdy Twoja domena osiągnie widoczność w wyszukiwarkach, ustawienie przekierowania z bez WWW na WWW może spowodować utratę widoczności ze względu na stworzenie nowych adresów URL.</small>
  <hr>
  <form method="post">
    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy posiadasz certyfikat SSL?</label>
      <select name="ssl" class="form-control" id="exampleFormControlSelect1">
        <?php
if ($czyHTTPS == 1) {
?>
          <option value="1">Tak</option>
          <option value="0">Nie</option>
        <?php
}
else {
?>
          <option value="0">Nie</option>
          <option value="1">Tak</option>
        <?php
}
?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy chcesz, aby każdy adres URL zaczynał się od www?</label>
      <select name="www_input" class="form-control" id="exampleFormControlSelect1">
        <?php
if ($czyWWW == 1) {
?>
          <option selected value="1">Tak</option>
          <option value="0">Nie</option>
        <?php
}
else {
?>
          <option selected value="0">Nie</option>
          <option value="1">Tak</option>
        <?php
}
?>
      </select>
    </div>

    <div class="form-group">
      <label>Kod weryfikacyjny Google Search Console</label>
      <input name="kod_gsc" type="text" value="<?php echo $kodGSC; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wklej kod z sekcji tag HTML z Google Search Console.">
      <small id="nazwa_strony_help" class="form-text text-muted">Skopiuj cały kod weryfikacyjny z <a href="https://search.google.com/search-console/about">Google Search Console</a> na przykład: <i>&lt;meta name="google-site-verification" content="KJ1vR3TsQgJJVuXqGuV-AHhGZ5gbrCcFEW-4mb2hQKk" /&gt;</i></small>
    </div>
    <hr>
    <h2 class="text-center mb-3" mt-3>Analityka</h2>

    <div class="form-group">
      <label>Kod Google Analytics</label>
      <input name="kod_ga" type="text" value="<?php echo $kodGA; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wklej kod śledzenia Google Analytics">
      <small id="nazwa_strony_help" class="form-text text-muted">Miej na uwadze to, że <a href="https://support.google.com/analytics/answer/11583528">Google ogłosiło, że 1 lipca 2023 roku Universal Analytics zostanie wycofane</a>. Zastanów się nad wdrożeniem Google Analytics 4.</small>
    </div>


    <div class="form-group">
      <label>Google Tag Manager w sekcji head</label>
      <input name="gtm_head" type="text" value="<?php echo $kodGTMHead; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wklej kod Google Tag Manager, który ma zostać zaimplementowany w sekcji head.">
      <small id="nazwa_strony_help" class="form-text text-muted">W powyższym miejscu wklej kod Google Tag Manager, który ma zostać zaimplementowany w sekcji head.</small>
    </div>
    <div class="form-group">
      <label>Google Tag Manager w sekcji body</label>
      <input name="gtm_body" type="text" value="<?php echo $kodGTMBody; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wklej kod Google Tag Manager, który ma zostać zaimplementowany w sekcji body.">
      <small id="nazwa_strony_help" class="form-text text-muted">W powyższym miejscu wklej kod Google Tag Manager, który ma zostać zaimplementowany w sekcji body.</small>
    </div>
    <div class="form-group">
      <input style="width:100%" type="submit" name="submit" class="btn btn-success" value="Zapisz">
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
  $nowyCzyHTTPS = $_POST['ssl'];
  $nowyCzyWWW = $_POST['www_input'];
  $nowyGSC = $_POST['kod_gsc'];
  $nowyGA = $_POST['kod_ga'];
  $nowyGTMbody = $_POST['gtm_body'];
  $nowyGTMhead = $_POST['gtm_head'];
  if ($nowyCzyHTTPS != $czyHTTPS || $nowyCzyWWW != $czyWWW || $nowyGSC != $kodGSC || $nowyGA != $kodGA || $nowyGTMbody != $kodGTMBody || $nowyGTMhead != $kodGTMHead) {
    wykonajZapytanie();
  }
  else {
?>
    <script type="text/javascript">
      alert('Wprowadzone ustawienia niczym nie różnią się od aktualnych.');
    </script>
  <?php
  }
}
function wykonajZapytanie()
{
  global $idUstawienia, $czyWWW, $connection, $nowyCzyHTTPS, $nowyCzyWWW, $nowyGA, $nowyGSC, $nowyGTMbody, $nowyGTMhead, $czyHTTPS;
  $https = "RewriteCond %{HTTPS} !=on
  RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]";
  $http = "RewriteCond %{HTTPS} on
  RewriteRule ^ http://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]";

  $www = "RewriteEngine On
  RewriteCond %{HTTP_HOST} !^www.
  RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]";
  $bezwww = "RewriteEngine On
  RewriteCond %{HTTP_HOST} ^www.(.*)$ [NC]
  RewriteRule ^(.*)$ http://%1/$1 [R=301,L]";

  if ($nowyCzyHTTPS != $czyHTTPS) {
    $htaccess = file_get_contents('../.htaccess');
    if ($czyHTTPS == "") {
      if ($nowyCzyHTTPS == 1) {
        $htaccess = str_replace('#PRZEKIEROWANIE HTTP/HTTPS', "#PRZEKIEROWANIE HTTP/HTTPS\n" . $https, $htaccess);
        file_put_contents('../.htaccess', $htaccess);
      }
      else if ($nowyCzyHTTPS == 0) {
        $htaccess = str_replace('#PRZEKIEROWANIE HTTP/HTTPS', "#PRZEKIEROWANIE HTTP/HTTPS\n" . $http, $htaccess);
        file_put_contents('../.htaccess', $htaccess);
      }
    }
    else if ($czyHTTPS != "") {
      $htaccess = file_get_contents('../.htaccess');
      if ($nowyCzyHTTPS == 1) {
        if ($czyHTTPS == 0) {
          $htaccess = str_replace($http, $https, $htaccess);
          file_put_contents('../.htaccess', $htaccess);
        }
        else if ($czyHTTPS == 1) {
        }
      }
      else if ($nowyCzyHTTPS == 0) {
        if ($czyHTTPS == 1) {
          $htaccess = str_replace($https, $http, $htaccess);
          file_put_contents('../.htaccess', $htaccess);
        }
        else if ($czyHTTPS == 0) {
        }
      }
    }
  }

  if ($nowyCzyWWW != $czyWWW) {
    $htaccess = file_get_contents('../.htaccess');
    if ($czyWWW == "") {
      if ($nowyCzyWWW == 1) {
        $htaccess = str_replace('#PRZEKIEROWANIE WWW/BEZ WWW', "#PRZEKIEROWANIE WWW/BEZ WWW\n" . $www, $htaccess);
        file_put_contents('../.htaccess', $htaccess);
      }
      else if ($nowyCzyWWW == 0) {
        $htaccess = str_replace('#PRZEKIEROWANIE WWW/BEZ WWW', "#PRZEKIEROWANIE WWW/BEZ WWW\n" . $bezwww, $htaccess);
        file_put_contents('../.htaccess', $htaccess);
      }
    }
    else if ($czyWWW != "") {
      if ($nowyCzyWWW == 0) {
        if ($czyWWW == 1) {
          $htaccess = str_replace($www, $bezwww, $htaccess);
          file_put_contents('../.htaccess', $htaccess);
        }
        else if ($czyWWW == 0) {
        }
      }
      else if ($nowyCzyWWW == 1) {
        if ($czyWWW == 0) {
          $htaccess = str_replace($bezwww, $www, $htaccess);
          file_put_contents('../.htaccess', $htaccess);
        }
        else if ($czyWWW == 1) {
        }
      }
    }
  }




  $zapytanie = "INSERT INTO ustawieniaseo (czy_https,czy_www,kod_gsc,kod_GTM_head,kod_GTM_body,kod_GA) VALUES('$nowyCzyHTTPS','$nowyCzyWWW','$nowyGSC','$nowyGTMhead','$nowyGTMbody','$nowyGA')";
  try {
    $connection->query($zapytanie);
  }
  catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }
  $zapytanie = "SELECT id_ustawienia FROM ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1";
  try {
    $wykonaneZapytanie = $connection->query($zapytanie);
  }
  catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }
  $pobierzId = mysqli_fetch_assoc($wykonaneZapytanie);
  if ($wykonaneZapytanie != $idUstawienia) {
?>
    <script type="text/javascript">
      alert('Zapisano ustawienia!');
    </script>
    echo "
    <meta http-equiv='refresh' content='0'>";
  <?php
  }
  else {
?>
    <script type="text/javascript">
      alert('Coś poszło nie tak!');
    </script>
<?php
  }
}
?>