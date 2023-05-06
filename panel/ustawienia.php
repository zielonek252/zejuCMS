<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
$zapytanie = "SELECT * FROM ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1";
try {
    $wykonaneZapytanie = $connection->query($zapytanie);
  } catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }
  $pobraneUstawienia = mysqli_fetch_assoc($wykonaneZapytanie);
  $idUstawienia=$pobraneUstawienia['id_ustawienia'];
?>
<div class="mx-auto w-75 p-3" id="main">
  <form action="/panel/strony.php">
    <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
  </form>
  <h1 class="text-center h3">Ustawienia ogólne</h1>
  <form method="post">
  <div class="form-group">
      <label>Logo</label>
      <input name="logo_input" type="text" value="<?php echo $pobraneUstawienia["logo"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj bezpośredni adres URL do zdjęcia z logo lub ścieżkę. Jeśli nie wiesz skąd wziąć adres URL, przejdź do <a href="/panel/zdjecia.php">zakładki zdjęcia</a> w panelu.</small>
    </div>
    <div class="form-group">
      <label>Obrazek pod nagłówkiem &lt;h1&gt;</label>
      <input name="obrazek_pod_h1" type="text" value="<?php echo $pobraneUstawienia["zdjecie_tlo"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj bezpośredni adres URL do zdjęcia, które chcesz wyświetlić pod nagłówkiem &lt;h1&gt; lub ścieżkę. Jeśli nie wiesz skąd wziąć adres URL, przejdź do <a href="/panel/zdjecia.php">zakładki zdjęcia</a> w panelu.</small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy wlączyć moduł blogowy?</label>
      <select name="modul_blogowy" class="form-control" id="exampleFormControlSelect1">
      <?php
        if ($pobraneUstawienia['czy_blog'] == 1) {
        ?>
          <option value="1">Tak</option>
          <option value="0">Nie</option>
        <?php
        } else {
        ?>
          <option value="0">Nie</option>
          <option value="1">Tak</option>
        <?php
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label>Lokalizacja</label>
      <input name="lokalizacja" type="text" value="<?php echo $pobraneUstawienia["lokalizacja"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj lokalizację, która wyświetla się domyślnie nad stopką.</small>
    </div>
    <div class="form-group">
      <label>Numer telefonu</label>
      <input name="numer_telefonu" type="text" value="<?php echo $pobraneUstawienia["numer_telefonu"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj numer telefonu, który wyświetla się domyślnie nad stopką.</small>
    </div>
    <div class="form-group">
      <label>Mail</label>
      <input name="mail" type="text" value="<?php echo $pobraneUstawienia["mail"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj adres e-mail, która wyświetla się domyślnie nad stopką. Na ten adres również będą przychodziły wiadomości z formularza kontaktowego.</small>
    </div>
    <div class="form-group">
      <input style="width:100%"type="submit" name="submit" class="btn btn-success" value="Zapisz">
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $logo=$_POST['logo_input'];
    $zdjeciePodH1=$_POST['obrazek_pod_h1'];
    $modulBlogowy=$_POST['modul_blogowy'];
    $lokalizacja=$_POST['lokalizacja'];
    $numerTelefonu=$_POST['numer_telefonu'];
    $mail=$_POST['mail'];
$zapytanie="INSERT INTO ustawieniaogolne (logo,zdjecie_tlo,czy_blog,lokalizacja,mail,numer_telefonu) VALUES('$logo','$zdjeciePodH1','$modulBlogowy','$lokalizacja','$mail','$numerTelefonu')";
try{
    $connection->query($zapytanie);
}catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }

  if($modulBlogowy==1){
  $zapytanie="UPDATE strony SET indeksowalnosc_seo_strony='1',czy_wyswietlic_w_menu='1' WHERE id_strony='3'";
  try{
     $wykonaneZapytanie=$connection->query($zapytanie);
  }catch (Exception $e) {
      echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
  }else{
    $zapytanie="UPDATE strony SET indeksowalnosc_seo_strony='0',czy_wyswietlic_w_menu='0' WHERE id_strony='3'";
    try{
       $wykonaneZapytanie=$connection->query($zapytanie);
    }catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
      }
  }
  $zapytanie="SELECT id_ustawienia FROM ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1";
  try{
     $wykonaneZapytanie=$connection->query($zapytanie);
  }catch (Exception $e) {
      echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $pobierzId = mysqli_fetch_assoc($wykonaneZapytanie);
  if($wykonaneZapytanie!=$idUstawienia){
    ?>
    <script type="text/javascript">
     alert('Zapisano ustawienia!');
</script>
echo "<meta http-equiv='refresh' content='0'>";
<?php
  }else{
    ?>
    <script type="text/javascript">
     alert('Coś poszło nie tak!');
</script>
<?php
  }
}
?>