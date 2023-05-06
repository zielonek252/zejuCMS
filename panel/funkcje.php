<?php
session_start();
include '../admin/connect.php';
global $connection;
$sesja=$_SESSION['nazwaUsera'];
$idUsera=$_SESSION['idUsera'];
try{
$sprawdzUsera=$connection->query("SELECT haslo_uzytkownika from uzytkownicy where nazwa_uzytkownika='$sesja' AND id_uzytkownika='$idUsera'");
}catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
$row = mysqli_fetch_assoc($sprawdzUsera);
if($row==""){
    header("Location: /logowanie");
}
?>