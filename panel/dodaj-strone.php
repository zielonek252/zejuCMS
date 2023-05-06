<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
$wyborNadrzednej=array();
try{
  $strony=$connection->query("SELECT tytul_strony,id_strony FROM STRONY WHERE id_nadrzednej_strony=0 AND czy_wyswietlic_w_menu=1");
}catch(Exception $e){
  echo $e->getCode().', komunikat:'.$e->getMessage();
}
while ($strona = mysqli_fetch_assoc($strony)){
  $wyborNadrzednej[]=$strona;
}
try{
  $adresyURL=$connection->query("SELECT url_strony FROM STRONY");
}catch(Exception $e){
  echo $e->getCode().', komunikat:'.$e->getMessage();
}
$tablicaAdresowUrl=array();
while ($adresURL = mysqli_fetch_assoc($adresyURL)){
  $tablicaAdresowUrl[]=$adresURL;
}
?>

<div class="mx-auto w-75 p-3" id="main">
  <form action="/panel/strony.php">
    <input style="width:100%" class="btn btn-success mb-4" type="submit" value="Powróć" />
  </form>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
      <label for="nazwa_strony_input">Nazwa strony</label>
      <input name="nazwa_strony" type="text" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę strony">
      <small id="nazwa_strony_help" class="form-text text-muted">Podaj nazwę, która ma wyświetlać się w menu.</small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Wybierz stronę nadrzędną</label>
      <select name="strona_nadrzedna" class="form-control" id="exampleFormControlSelect1">
        <option value="0">Główne menu</option>
        <?php
foreach($wyborNadrzednej as $strona){
  ?>
  echo $strona['tytul_strony'];
        <option value="
        <?php echo $strona['id_strony'];
        ?>
        ">
        <?php echo $strona['tytul_strony'];?>
      </option>
 <?php 
}
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy strona ma wyświetlać się w menu?</label>
      <select name="czy_wyswietlic_w_menu" class="form-control" id="exampleFormControlSelect1">
        <option value="1">Tak</option>
        <option value="0">Nie</option>
      </select>
    </div>

    <div class="form-group">
      <label for="kolejnosc_input">Kolejność w menu</label>
      <input name="kolejnosc_w_menu" type="text" class="form-control" id="kolejnosc_input" value="0" placeholder="Wpisz kolejność">
      <small id="kolejnosc_help" class="form-text text-muted">Domyślnie 0, wtedy strony wyświetlają się według kolejności dodania.</small>
    </div>

    <div class="form-group">
      <label for="uproszczony_input">Uproszczony url</label>
      <div class="input-group mb-2 mr-sm-2">
        <div class="input-group-prepend">
          <div class="input-group-text">/</div>
        </div>
        <input name="uproszczony_url" type="text" class="form-control" id="uproszczony_input" placeholder="Wpisz uproszczony adres url">
      </div>
      <small id="uproszczony_url_help" class="form-text text-muted">Podaj uproszczony adres strony na przykład: <i>nasza-oferta</i>. Nie używaj polskich znaków, ani spacji!</small>
    </div>

    <hr>
    <h5>SEO</h5>
    <div class="form-group">
      <label for="title_seo_input">Podaj tytuł strony dla wyszukiwarek</label>
      <input name="tytul_seo" type="text" class="form-control" id="title_seo_input" placeholder="Wpisz tytuł strony dla wyszukiwarek">
      <small id="title_seo" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>title</i> w sekcji <i>head</i>. Zalecana długość to 60 znaków <span id="przekroczenieTitle">(<span id="dlugosc_title">0</span>/60)</span>. </small>
    </div>
    <div class="form-group">
      <label for="md_input">Podaj opis strony</label>
      <textarea name="meta_desc" class="form-control" id="md_input" rows="3" placeholder="Wpisz meta description"></textarea>
      <small id="md_help" class="form-text text-muted">Podany wyżej tekst zostanie ustawiony w <i>meta description</i> w sekcji <i>head</i>. Zalecana długość to maksymalnie 155 znaków <span id="przekroczenieMetaDescription">(<span id="dlugosc_md">0</span>/155)</span>. </small>
    </div>

    <div class="form-group">
      <label for="md_input">Nagłówek <i>&lt;h1&gt;</i></label>
      <input name="naglowek_h1" type="text" class="form-control" id="nagl_h1" placeholder="Wpisz nagłówek <h1>">
      <small id="h1_help" class="form-text text-muted"></small>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">Czy strona ma być indeksowana przez wyszukiwarki?</label>
      <select name="czy_indeksowac" class="form-control" id="exampleFormControlSelect1">
        <option value="1">Tak</option>
        <option value="0">Nie</option>
      </select>
    </div>

    <hr>
    <h5>TREŚĆ</h5>
    <textarea name="content" id="abc">
    
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
<input style="width:100%"type="submit" name="submit" class="btn btn-success" value="Dodaj stronę">
                </div>
  </form>
</div>
<?php

if(isset($_POST['submit'])){
  $nazwaStrony = $_POST['nazwa_strony'];
  $stronaNadrzedna = $_POST['strona_nadrzedna'];
  $czyWyswietlicWMenu = $_POST['czy_wyswietlic_w_menu'];
  $kolejnoscMenu = $_POST['kolejnosc_w_menu'];
  $uproszczonyUrl = $_POST['uproszczony_url'];
  $tytulSeo = $_POST['tytul_seo'];
  $metaDesc = $_POST['meta_desc'];
  $czyIndeksowac = $_POST['czy_indeksowac'];
  $tresc = $_POST["content"];
  $naglowekH1 = $_POST["naglowek_h1"];
  $data=date("Y-m-d H:i");
  $bledy=array();
  $i=0;
walidacja();
}
function walidacja(){
  global $tablicaAdresowUrl,$adresURL, $czyIndeksowac,$data,$tresc,$connection, $metaDesc, $i,$nazwaStrony,$kolejnoscMenu,$uproszczonyUrl,$tytulSeo,$naglowekH1,$bledy,$stronaNadrzedna,$czyWyswietlicWMenu;
  if(strlen($nazwaStrony)==0){
$bledy[$i]="Wpisz nazwę strony";
$i++;
}

if(preg_match("/[^0-9]/", $kolejnoscMenu)==1){
  $bledy[$i]="Kolejność może zawierać tylko cyfry!";
  $i++;
  }
  if($kolejnoscMenu==""){
    $kolejnoscMenu=0;
  }
  if(strlen($uproszczonyUrl)==0){
    $bledy[$i]="Wpisz uproszczony adres URL";
    $i++;
  }else{
    $uproszczonyUrl = preg_replace('~[^\\pL\d-]+~u', '%', $uproszczonyUrl);
    $uproszczonyUrl = trim($uproszczonyUrl, "%");
    $uproszczonyUrl=preg_replace("[%]","",$uproszczonyUrl);
    $uproszczonyUrl = iconv('utf-8', 'ascii//TRANSLIT', $uproszczonyUrl);
    $uproszczonyUrl=preg_replace("[']","",$uproszczonyUrl);
    $uproszczonyUrl="/".$uproszczonyUrl;
    $uproszczonyUrl = strtolower($uproszczonyUrl);
  }

  foreach($tablicaAdresowUrl as $adresURL){
if($adresURL['url_strony']==$uproszczonyUrl){
  $bledy[$i]="Podany adres URL już istnieje!";
  $i++;
}
  }

if(strlen($tytulSeo==0)){
  $tytulSeo=$nazwaStrony." | ".$aktualnaStrona=$_SERVER['SERVER_NAME'];
}


if(strlen($naglowekH1==0)){
  $naglowekH1=$nazwaStrony;
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
    $zapytanie="INSERT INTO Strony (id_nadrzednej_strony, 
    czy_wyswietlic_w_menu,
    kolejnosc_w_menu,
    url_strony,
    tytul_strony,
    tytul_seo_strony,
    opis_seo_strony,
    indeksowalnosc_seo_strony,
    data_publikacji,
    zawartosc_strony,
    naglowek_h1) 
    VALUES ('$stronaNadrzedna',
    '$czyWyswietlicWMenu',
    '$kolejnoscMenu',
    '$uproszczonyUrl',
    '$nazwaStrony',
    '$tytulSeo',
    '$metaDesc',
    '$czyIndeksowac',
    '$data',
    '$tresc',
    '$naglowekH1')";
  $connection->query($zapytanie);
  }catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
  }
  ?>
<script type="text/javascript">
     alert('Dodano nową stronę!');
</script>
<?php
echo "nadrzędna strona: ".$stronaNadrzedna;
echo "czy wyświetlić w menu: ".$czyWyswietlicWMenu;
echo "kolejność w menu: ".$kolejnoscMenu;
echo "uproszczony adres URL: ".$uproszczonyUrl;
echo "nazwa strony: ".$nazwaStrony;
echo "tytuł seo: ".$tytulSeo;
echo "meta desc: ".$metaDesc;
echo 'czy indeksować? '.$czyIndeksowac;
echo "data: ".$data;
echo "treść: ".$tresc;
echo "nagłówek h1: ".$naglowekH1;
}
}
?>
<script src="/panel/js/walidacja-dodawania-stron.js"></script>
<script src="/panel/js/script.js"></script>
</body>
