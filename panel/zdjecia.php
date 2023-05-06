<?php
include 'funkcje.php';
include 'nawigacja.php';
?>
<div class="mx-auto w-75 p-3" id="main">
    <div class="text-center mt-3"><h1>Zdjęcia</h1></div>
<div class="row py-4">
        <div class="col-lg-6 mx-auto">
<form method="post" enctype="multipart/form-data">
  Wybierz zdjęcie
  <input type="file" name="fileToUpload" class="form-control form-control-lg" id="formFileLg">
  <input type="hidden" name="<?php echo ini_get('session.upload_progress.prefix').ini_get('session.upload_progress.name'); ?>" value="myupload" />
  <input style="width:100%" class="mt-2 btn btn-secondary"type="submit" value="Dodaj zdjęcie na serwer" name="submit">
</form>
</div>
</div>
<div class="row">
<?php
$aktualnyLink=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$aktualnyLink=strtok($aktualnyLink,"/");
$strona = $aktualnyLink."//".$_SERVER['SERVER_NAME']."/img/";
$dirname="../img/";
$images = glob($dirname."*.*");
$i=0;
foreach($images as $image) {
    $zdjecie=$strona.basename($image);
    echo '
    <div class="mx-auto shadow-sm p-3 mb-5 bg-white rounded mt-2 col-sm-3 text-center"><p style="max-width:100%;word-wrap: break-word;">'.basename($image).'</p><br>
    <img style="max-width:100%" src="'.$image.'" /><br><button id="'.$i.'" class="btn btn-light mt-2" value="'.$zdjecie.'" onclick="skopiuj(this.id)">Skopiuj adres zdjęcia</button></div>';
$i++;
}
?>
</div>
</div>
<?php
$target_dir = "../img/";
if(isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "Plik nie jest zdjęciem.";
    $uploadOk = 0;
  }
  if ($uploadOk == 0) {
    echo "Dodawanie nie powiodło się.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      echo "<meta http-equiv='refresh' content='0'>";
    } else {
      echo "Wystąpił błąd poczas dodawania pliku.";
    }
  }
}
?>
<script>
function skopiuj(id){
const button=document.getElementById(id).value;
navigator.clipboard.writeText(button);
alert('Skopiowano')
}
</script>

