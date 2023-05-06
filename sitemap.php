<?php 
include 'admin/connect.php';
include 'header.php';
$aktualny_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$zapytanieStrony="SELECT * FROM strony where indeksowalnosc_seo_strony=1";
try{
    $stronyTab=array();
    $zapytanie=$connection->query($zapytanieStrony);
    while($strona=mysqli_fetch_assoc($zapytanie)){
$stronyTab[]=$strona;
    }
}catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}

$zapytanieBlog="SELECT * FROM blog where indeksowalnosc_seo_wpisu=1";
try{
    $blogTab=array();
    $zapytanie=$connection->query($zapytanieBlog);
    while($wpis=mysqli_fetch_assoc($zapytanie)){
$blogTab[]=$wpis;
    }
}catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
?>
    <div class="row">
        <div class="mx-auto p-1">
<table class="table">
    <thead>
        <tr>
            <th scope="col">Adres URL</th>
            <th></th>
            <th scope="col">Data ostatniej modyfikacji</th>
        </tr>
    </thead>
    <tbody>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
foreach($stronyTab as $strona){
?>
<tr>
  <url>
    <td colspan="2"><loc><a href="<?php echo $aktualny_link.$strona['url_strony']; ?>"><?php echo $aktualny_link.$strona['url_strony']; ?></a></loc></td>
    <td><lastmod><?php echo $strona['data_publikacji'];?></lastmod></td>
  </url>
</tr>
<?php
}
foreach($blogTab as $wpis){
?>
<tr>
  <url>
    <td colspan="2"><loc><a href="<?php echo $aktualny_link.$wpis['url_wpisu']; ?>"><?php echo $aktualny_link.$wpis['url_wpisu']; ?></a></loc></td>
    <td><lastmod><?php echo $wpis['data_publikacji_wpisu'];?></lastmod></td>
  </url>
</tr>
<?php
}
?>
</tbody>
</table>
</urlset>
</div>
</div>
