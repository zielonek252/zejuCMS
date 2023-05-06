<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
$wyborNadrzednej = array();
$idStronyGet = $_GET['pid'];

try {
  $aktualnaStrona = $connection->query("SELECT * FROM STRONY WHERE id_strony='$idStronyGet'");
} catch (Exception $e) {
  echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
$pobranaStrona = mysqli_fetch_assoc($aktualnaStrona);


try {
  $strony = $connection->query("SELECT tytul_strony,id_strony FROM STRONY WHERE id_nadrzednej_strony=0 AND czy_wyswietlic_w_menu=1");
} catch (Exception $e) {
  echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
while ($strona = mysqli_fetch_assoc($strony)) {
  $wyborNadrzednej[] = $strona;
}
try {
  $adresyURL = $connection->query("SELECT url_strony FROM STRONY");
} catch (Exception $e) {
  echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
$tablicaAdresowUrl = array();
while ($adresURL = mysqli_fetch_assoc($adresyURL)) {
  $tablicaAdresowUrl[] = $adresURL;
}
?>

<div class="mx-auto w-75 p-3" id="main">
  <form action="/panel/strony.php">
    <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
  </form>
  <form method="post">
    <div class="form-group">
      <label for="nazwa_strony_input">Nazwa strony</label>
      <input name="nazwa_strony" type="text" value="<?php echo $pobranaStrona["tytul_strony"]; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj nazwę, która ma wyświetlać się w menu.</small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Wybierz stronę nadrzędną</label>
      <select name="strona_nadrzedna" class="form-control" id="exampleFormControlSelect1">
        <option value="<?php echo $pobranaStrona['id_nadrzednej_strony']?>"><?php if($pobranaStrona['id_nadrzednej_strony']==0){
          echo "Główne menu";
}else{
foreach($wyborNadrzednej as $strona){
  if($pobranaStrona['id_nadrzednej_strony']==$strona['id_strony']){
echo $strona['tytul_strony'];
  }
}
?>
</option>
<option value="0">Główne menu</option>
<?php
        }  

        foreach ($wyborNadrzednej as $strona) {
          if($strona['id_strony']!=$pobranaStrona['id_nadrzednej_strony']){
        ?>
          <option value="
        <?php echo $strona['id_strony'];
        ?>
        ">
            <?php echo $strona['tytul_strony']; ?>
          </option>
        <?php
        }
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy strona ma wyświetlać się w menu?</label>
      <select name="wyswietlic_w_menu" class="form-control" id="exampleFormControlSelect1">
          <option value="<?php echo $pobranaStrona['czy_wyswietlic_w_menu'];?>" selected><?php if($pobranaStrona['czy_wyswietlic_w_menu']==1){echo "Tak";}else{echo "Nie";}?></option>
          <option value="<?php if($pobranaStrona['czy_wyswietlic_w_menu']==1){echo "0";}else{echo "1";}?>"><?php if($pobranaStrona['czy_wyswietlic_w_menu']==1){echo "Nie";}else{echo "Tak";}?></option>
      </select>
    </div>

    <div class="form-group">
      <label for="kolejnosc_input">Kolejność w menu</label>
      <input name="kolejnosc_w_menu" type="text" class="form-control" id="kolejnosc_input" value="<?php echo $pobranaStrona['kolejnosc_w_menu'] ?>" placeholder="Wpisz kolejność">
      <small id="kolejnosc_help" class="form-text text-muted">Domyślnie 0, wtedy strony wyświetlają się według kolejności dodania.</small>
    </div>
    <?php
if($pobranaStrona['id_strony']!=1 && $pobranaStrona['id_strony']!=2&&$pobranaStrona['id_strony']!=3){
  ?>
    <div class="form-group">
      <label for="uproszczony_input">Uproszczony url</label>
      <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
          <div class="input-group-text">/</div>
        </div>
        <input name="uproszczony_url" type="text" class="form-control" value="<?php 
        $url=$pobranaStrona['url_strony'] ;
        $url  = preg_replace("[/]", "", $url);
        echo $url;
        ?>
        " id="uproszczony_input" placeholder="Wpisz uproszczony adres url">
      </div>
      <small id="uproszczony_url_help" class="form-text text-muted">Podaj uproszczony adres strony na przykład: <i>nasza-oferta</i>. Nie używaj polskich znaków, ani spacji!</small>
    </div>
    <?php
  }
  ?>
    <hr>
    <h5>SEO</h5>
    <div class="form-group">
      <label for="title_seo_input">Podaj tytuł strony dla wyszukiwarek</label>
      <input name="tytul_seo" type="text" class="form-control" value="<?php echo $pobranaStrona['tytul_seo_strony'] ?>" id="title_seo_input" placeholder="Wpisz tytuł strony dla wyszukiwarek">
      <small id="title_seo" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>title</i> w sekcji <i>head</i>. Zalecana długość to 60 znaków <span id="przekroczenieTitle">(<span id="dlugosc_title">0</span>/60)</span>. </small>
    </div>
    <div class="form-group">
      <label for="md_input">Podaj opis strony</label>
      <textarea name="meta_desc" class="form-control"  id="md_input" rows="3" placeholder="Wpisz meta description"><?php echo $pobranaStrona['opis_seo_strony'] ?></textarea>
      <small id="md_help" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>meta description</i> w sekcji <i>head</i>. Zalecana długość to maksymalnie 155 znaków <span id="przekroczenieMetaDescription">(<span id="dlugosc_md">0</span>/155)</span>. </small>
    </div>

    <div class="form-group">
      <label for="md_input">Nagłówek <i>&lt;h1&gt;</i></label>
      <input name="naglowek_h1" type="text" class="form-control" value="<?php echo $pobranaStrona['naglowek_h1'] ?>" id="nagl_h1" placeholder="Wpisz nagłówek <h1>">
      <small id="h1_help" class="form-text text-muted"></small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy strona ma być indeksowana przez wyszukiwarki?</label>
      <select name="czy_indeksowac" class="form-control" id="exampleFormControlSelect1">
      <?php
        if ($pobranaStrona['indeksowalnosc_seo_strony'] == 1) {
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

    <?php
if($pobranaStrona['id_strony']!=2&&$pobranaStrona['id_strony']!=3){
    ?>
        <hr>
    <h5>TREŚĆ</h5>
    <textarea name="content" id="abc">
    <?php echo $pobranaStrona['zawartosc_strony'] ?>

    </textarea>
    <script>
      tinymce.init({
        selector: 'textarea#abc',
        // plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
        // toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
        // toolbar_mode: 'floating',
        language: 'pl',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
      });
    </script>
<?php
}
?>

<hr>
    <div class="form-group">
      <input style="width:100%"type="submit" name="submit" class="btn btn-success" value="Zapisz">
    </div>
  </form>
</div>
<?php

if (isset($_POST['submit'])) {
  $nazwaStrony = $_POST['nazwa_strony'];
  $stronaNadrzedna = $_POST['strona_nadrzedna'];
  $czyWyswietlicWMenu = intval($_POST['wyswietlic_w_menu']);
  $kolejnoscMenu = $_POST['kolejnosc_w_menu'];
  $uproszczonyUrl = $_POST['uproszczony_url'];
  if($pobranaStrona['id_strony']==1){
    $uproszczonyUrl="";
  }
  if($pobranaStrona['id_strony']==2){
    $uproszczonyUrl="logowanie";
  }
  if($pobranaStrona['id_strony']==3){
    $uproszczonyUrl="blog";
  }
  $tytulSeo = $_POST['tytul_seo'];
  $metaDesc = $_POST['meta_desc'];
  $czyIndeksowac = $_POST['czy_indeksowac'];
  if($pobranaStrona['id_strony']==3){
    $tresc="";
  }
  if($pobranaStrona['id_strony']==2){
$tresc="";
  } else{
  $tresc = $_POST["content"];
}
?>

<?php
  $naglowekH1 = $_POST["naglowek_h1"];
  $data = date("Y-m-d H:i");
  $bledy = array();
  $i = 0;
  walidacja();
}
function walidacja()
{
  global $pobranaStrona,$idStronyGet,$tablicaAdresowUrl, $adresURL, $czyIndeksowac, $data, $tresc, $connection, $metaDesc, $i, $nazwaStrony, $kolejnoscMenu, $uproszczonyUrl, $tytulSeo, $naglowekH1, $bledy, $stronaNadrzedna, $czyWyswietlicWMenu;
  if (strlen($nazwaStrony) == 0) {
    $bledy[$i] = "Wpisz nazwę strony";
    $i++;
  }

  if (preg_match("/[^0-9]/", $kolejnoscMenu) == 1) {
    $bledy[$i] = "Kolejność może zawierać tylko cyfry!";
    $i++;
  }
  if ($kolejnoscMenu == "") {
    $kolejnoscMenu = 0;
  }
  if($czyWyswietlicWMenu=="0"){
    $czyWyswietlicWMenu=0;
  }else{
    $czyWyswietlicWMenu=1;
  }
  if($pobranaStrona['id_strony']!=1){
  if (strlen($uproszczonyUrl) == 0) {
    $bledy[$i] = "Wpisz uproszczony adres URL";
    $i++;
  } else {
    $uproszczonyUrl = preg_replace('~[^\\pL\d-]+~u', '%', $uproszczonyUrl);
    $uproszczonyUrl = trim($uproszczonyUrl, "%");
    $uproszczonyUrl = preg_replace("[%]", "", $uproszczonyUrl);
    $uproszczonyUrl = iconv('utf-8', 'ascii//TRANSLIT', $uproszczonyUrl);
    $uproszczonyUrl = preg_replace("[']", "", $uproszczonyUrl);
    $uproszczonyUrl = "/" . $uproszczonyUrl;
    $uproszczonyUrl = strtolower($uproszczonyUrl);
  }
}else{
  $uproszczonyUrl = "/" . $uproszczonyUrl;
}

  foreach ($tablicaAdresowUrl as $adresURL) {
    if($uproszczonyUrl==$pobranaStrona['url_strony']){
    
    }else
    if ($adresURL['url_strony'] == $uproszczonyUrl) {
      $bledy[$i] = "Podany adres URL już istnieje!";
      $i++;
    }
  }

  if (strlen($tytulSeo)==0) {
    $tytulSeo = $nazwaStrony . " | " . $aktualnaStrona = $_SERVER['SERVER_NAME'];
  }


  if (strlen($naglowekH1) == 0) {
    $naglowekH1 = $nazwaStrony;
  }
  if ($i > 0) {
?>
    <script type="text/javascript">
      alert(
        '<?php
          foreach ($bledy as $blad) {
            echo $blad . '\n';
          }
          ?>'
      )
    </script>
  <?php
  } else {
    try {
      $zapytanie = "UPDATE Strony
    SET id_nadrzednej_strony = '$stronaNadrzedna',
    czy_wyswietlic_w_menu = '$czyWyswietlicWMenu',
    kolejnosc_w_menu = '$kolejnoscMenu',
    url_strony = '$uproszczonyUrl',
    tytul_strony = '$nazwaStrony',
    tytul_seo_strony = '$tytulSeo',
    opis_seo_strony = '$metaDesc',
    indeksowalnosc_seo_strony = '$czyIndeksowac',
    data_publikacji = '$data',
    zawartosc_strony = '$tresc',
    naglowek_h1 = '$naglowekH1'
    WHERE id_strony = $idStronyGet";
      $connection->query($zapytanie);
    } catch (Exception $e) {
      echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
  ?>
    <script type="text/javascript">
      alert('Zapisano stronę!');
</script>
<?php
    echo "nadrzędna strona: " . $stronaNadrzedna;
    echo "czy wyświetlić w menu: " . $czyWyswietlicWMenu;
    echo "kolejność w menu: " . $kolejnoscMenu;
    echo "uproszczony adres URL: " . $uproszczonyUrl;
    echo "nazwa strony: " . $nazwaStrony;
    echo "tytuł seo: " . $tytulSeo;
    echo "meta desc: " . $metaDesc;
    echo 'czy indeksować? ' . $czyIndeksowac;
    echo "data: " . $data;
    echo "treść: " . $tresc;
    echo "nagłówek h1: " . $naglowekH1;
    echo "<meta http-equiv='refresh' content='0'>";
  }
}
?>
<script src="/panel/js/walidacja-dodawania-stron.js"></script>
<script src="/panel/js/script.js"></script>
</body>