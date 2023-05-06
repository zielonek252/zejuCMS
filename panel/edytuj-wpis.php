<?php
include 'funkcje.php';
include 'nawigacja.php';
$idStronyGet = $_GET['pid'];
global $connection;
try{
  $wpis=$connection->query("SELECT * from blog where id_wpisu='$idStronyGet'");
}catch(Exception $e){
  echo $e->getCode().', komunikat:'.$e->getMessage();
}
$pobranyWpis = mysqli_fetch_assoc($wpis);
try{
  $URLblog=$connection->query("SELECT url_wpisu FROM blog");
  $URLstron=$connection->query("SELECT url_strony FROM strony");
}catch(Exception $e){
  echo $e->getCode().', komunikat:'.$e->getMessage();
}
$tablicaAdresowUrlBlog=array();
$tablicaAdresowUrlStron=array();
while ($adresyURLblog = mysqli_fetch_assoc($URLblog)){
  $tablicaAdresowUrlBlog[]=$adresyURLblog;
}
while ($adresyURLstron = mysqli_fetch_assoc($URLstron)){
  $tablicaAdresowUrlStron[]=$adresyURLstron;
}
?>

<div class="mx-auto w-75 p-3" id="main">
  <form action="/panel/blog.php">
  <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
  </form>
  <form method="post">
    <div class="form-group">
      <label for="nazwa_strony_input">Tytuł wpisu</label>
      <input name="tytul_wpisu" type="text" class="form-control" value="<?php echo $pobranyWpis['tytul_wpisu']?>"id="nazwa_strony_input" placeholder="Wpisz tytuł wpisu">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj tytuł wpisu</small>
    </div>

    <div class="form-group">
      <label for="nazwa_strony_input">Obrazek wyróżniający</label>
      <input name="obrazek_wyrozniajacy" type="text" value="<?php echo $pobranyWpis['obrazek_wyrozniajacy_wpisu']?>"class="form-control" id="nazwa_strony_input" placeholder="Wpisz adres URL zdjęcia">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj bezpośredni adres URL do zdjęcia z logo lub ścieżkę. Jeśli nie wiesz skąd wziąć adres URL, przejdź do <a href="/panel/zdjecia.php">zakładki zdjęcia</a> w panelu.</small>
    </div>

    <div class="form-group">
      <label for="uproszczony_input">Uproszczony url</label>
      <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
          <div class="input-group-text">/blog/</div>
        </div>
        <input value="<?php $url = $pobranyWpis['url_wpisu']; $url=preg_replace('[/blog/]','',$url);echo $url; ?>"name="uproszczony_url" type="text" class="form-control" id="uproszczony_input" placeholder="Wpisz uproszczony adres url wpisu">
      </div>
      <small id="uproszczony_url_help" class="form-text text-muted">Podaj uproszczony adres strony na przykład: <i>historia-dzialalnosci-naszej-firmy</i>. Nie używaj polskich znaków, ani spacji!</small>
    </div>

    <hr>
    <h5>SEO</h5>
    <div class="form-group">
      <label for="title_seo_input">Podaj tytuł wpisu dla wyszukiwarek</label>
      <input value="<?php echo $pobranyWpis['tytul_seo_wpisu'];?>"name="tytul_seo" type="text" class="form-control" id="title_seo_input" placeholder="Wpisz tytuł strony dla wyszukiwarek">
      <small id="title_seo" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>title</i> w sekcji <i>head</i>. Zalecana długość to 60 znaków <span id="przekroczenieTitle">(<span id="dlugosc_title">0</span>/60)</span>. </small>
    </div>
    <div class="form-group">
      <label for="md_input">Podaj opis wpisu</label>
      <textarea name="meta_desc" class="form-control" id="md_input" rows="3" placeholder="Wpisz meta description"><?php echo $pobranyWpis['opis_seo_wpisu'] ?></textarea>
      <small id="md_help" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>meta description</i> w sekcji <i>head</i>. Zalecana długość to maksymalnie 155 znaków <span id="przekroczenieMetaDescription">(<span id="dlugosc_md">0</span>/155)</span>. </small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy strona ma być indeksowana przez wyszukiwarki?</label>
      <select name="czy_indeksowac" class="form-control" id="exampleFormControlSelect1">
      <?php
        if ($pobranyWpis['indeksowalnosc_seo_wpisu'] == 1) {
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

    <hr>
    <h5>TREŚĆ</h5>
    <textarea name="content" id="abc">
    <?php echo $pobranyWpis['zawartosc_wpisu'];?>
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



<div class="form-group">
<input style="width:100%"type="submit" name="submit" class="btn btn-success" value="Zapisz">
                </div>
  </form>
</div>
<?php

if(isset($_POST['submit'])){
  $nazwaWpisu = $_POST['tytul_wpisu'];
  $obrazek=$_POST['obrazek_wyrozniajacy'];
  $uproszczonyUrl = $_POST['uproszczony_url'];
  $tytulSeo = $_POST['tytul_seo'];
  $metaDesc = $_POST['meta_desc'];
  $czyIndeksowac = $_POST['czy_indeksowac'];
  $tresc = $_POST["content"];
  $data=date("Y-m-d H:i");
  $bledy=array();
  $i=0;
walidacja();
}
function walidacja(){
  $i=0;
  global $tablicaAdresowUrlBlog,$obrazek,$tablicaAdresowUrlStron,$adresyURLblog,$adresyURLstron, $czyIndeksowac,$data,$tresc,$connection, $metaDesc, $nazwaWpisu,$uproszczonyUrl,$tytulSeo,$bledy,$idStronyGet;
  if(strlen($nazwaWpisu)==0){
$bledy[$i]="Wpisz nazwę strony";
$i++;
}

  if(strlen($uproszczonyUrl)==0){
    $bledy[$i]="Wpisz uproszczony adres URL";
    $i++;
  }else{
    $uproszczonyUrl=preg_replace('[/blog/]','',$uproszczonyUrl);
    $uproszczonyUrl = preg_replace('~[^\\pL\d-]+~u', '%', $uproszczonyUrl);
    $uproszczonyUrl = trim($uproszczonyUrl, "%");
    $uproszczonyUrl=preg_replace("[%]","",$uproszczonyUrl);
    $uproszczonyUrl = iconv('utf-8', 'ascii//TRANSLIT', $uproszczonyUrl);
    $uproszczonyUrl=preg_replace("[']","",$uproszczonyUrl);
    $uproszczonyUrl="/blog/".$uproszczonyUrl;
    $uproszczonyUrl = strtolower($uproszczonyUrl);
  }
  if(strlen($obrazek)==0){
    $obrazek="/img/placeholder.jpg";
  }

  foreach($tablicaAdresowUrlBlog as $adresyURLblog){
if($adresyURLblog['url_wpisu']==$uproszczonyUrl){

}
  }
  foreach($tablicaAdresowUrlStron as $adresyURLstron){
    if($adresyURLstron['url_strony']==$uproszczonyUrl){
      $bledy[$i]="Podany adres URL już istnieje!";
      $i++;
    }
      }

if(strlen($tytulSeo==0)){
  $tytulSeo=$nazwaWpisu." | ".$aktualnaStrona=$_SERVER['SERVER_NAME'];
}
if($i>0){
?>
<script type="text/javascript">
     alert(
      '<?php 
      foreach($bledy as $blad){
        echo $blad.'\n'; 
      }
        
        ?>'
      )
</script>
<?php
} else{
  try{
    $zapytanie="UPDATE blog 
    SET url_wpisu='$uproszczonyUrl',
    tytul_wpisu='$nazwaWpisu',
    tytul_seo_wpisu='$tytulSeo',
    opis_seo_wpisu='$metaDesc',
    indeksowalnosc_seo_wpisu='$czyIndeksowac',
    data_publikacji_wpisu='$data',
    zawartosc_wpisu='$tresc',
    obrazek_wyrozniajacy_wpisu='$obrazek' 
 WHERE id_wpisu='$idStronyGet'";
  $connection->query($zapytanie);
  }catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
  }
  ?>
<script type="text/javascript">
     alert('Zapisano wpis!');
</script>
<?php
}
echo "<meta http-equiv='refresh' content='0'>";
}
?>
<script src="/panel/js/walidacja-dodawania-stron.js"></script>
<script src="/panel/js/script.js"></script>
</body>
