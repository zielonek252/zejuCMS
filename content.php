<?php
include 'admin/connect.php';
global $connection;


$aktualny_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$aktualnaStrona=$_SERVER['REQUEST_URI'];
$aktualnaStrona=strtok($aktualnaStrona,'?');
try{
$tresc=$connection->query("SELECT zawartosc_strony from strony where url_strony='$aktualnaStrona'");
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
$row = mysqli_fetch_assoc($tresc);
$tresc=$row["zawartosc_strony"];
if(!strpos($aktualnaStrona,"blog")){
?>
<section class="content">
<?php
echo $tresc;
?>

</section>
<?php
}
