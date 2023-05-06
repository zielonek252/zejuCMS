<?php
include 'connect.php';
if(isset($connection)){
    global $connection;
}else{
    header("Location: /admin/instalacja-1.php");
}



//ustawienia seo wybrane dla danej strony
$aktualny_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$aktualnaStrona=$_SERVER['REQUEST_URI'];
$aktualnaStrona=strtok($aktualnaStrona,'?');
try{
    $przekierowaniaTab=array();
    $przekierowania=$connection->query("SELECT * FROM przekierowania");
    while($przekierowanie=mysqli_fetch_assoc($przekierowania)){
$przekierowaniaTab[]=$przekierowanie;
    }
}catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
foreach($przekierowaniaTab as $przekierowanie){
if($przekierowanie['stary_url']==$aktualnaStrona){
    header("HTTP/1.1 301 Moved Permanently");
header('Location: '.$przekierowanie['nowy_url']);
exit();
}
}
try{
$titleAktualnejStrony=$connection->query("SELECT tytul_seo_strony from strony where url_strony='$aktualnaStrona'");
if(mysqli_num_rows($titleAktualnejStrony)!=""){
$row = mysqli_fetch_assoc($titleAktualnejStrony);
$liczbaZwrotek=mysqli_num_rows($titleAktualnejStrony);
if($liczbaZwrotek==0){
    $titleSeo="";
}else{
$titleSeo=$row["tytul_seo_strony"];
}
}else{
$titleAktualnejStrony=$connection->query("SELECT tytul_seo_wpisu from blog where url_wpisu='$aktualnaStrona'");
$row = mysqli_fetch_assoc($titleAktualnejStrony);
$liczbaZwrotek=mysqli_num_rows($titleAktualnejStrony);
if($liczbaZwrotek==0){
    $titleSeo="";
}else{
$titleSeo=$row["tytul_seo_wpisu"];
}
}
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
if($titleSeo==""){
    include '404.php';
}else{
try{
$metaDescStrony=$connection->query("SELECT opis_seo_strony from strony where url_strony='$aktualnaStrona'");
if(mysqli_num_rows($metaDescStrony)!=""){
$row = mysqli_fetch_assoc($metaDescStrony);
$descSeo=$row["opis_seo_strony"];
}else{
    $metaDescStrony=$connection->query("SELECT opis_seo_wpisu from blog where url_wpisu='$aktualnaStrona'");
    $row = mysqli_fetch_assoc($metaDescStrony);
$descSeo=$row["opis_seo_wpisu"];
    }
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}


try{
$czyIndeksowac=$connection->query("SELECT indeksowalnosc_seo_strony from strony where url_strony='$aktualnaStrona'");
if(mysqli_num_rows($czyIndeksowac)!=""){
$row = mysqli_fetch_assoc($czyIndeksowac);
$czyIndeksowac=$row["indeksowalnosc_seo_strony"];
}else{
    $czyIndeksowac=$connection->query("SELECT indeksowalnosc_seo_wpisu from blog where url_wpisu='$aktualnaStrona'");
    $row = mysqli_fetch_assoc($czyIndeksowac);
$czyIndeksowac=$row["indeksowalnosc_seo_wpisu"];
    }
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}

if($czyIndeksowac==0){
    $indeksowalna="noindex, follow";
}else if($czyIndeksowac==1){
    $indeksowalna="index, follow";
}
try{
    $wyroznionyObrazek=$connection->query("SELECT obrazek_wyrozniajacy_wpisu from blog where url_wpisu='$aktualnaStrona'");
if(mysqli_num_rows($wyroznionyObrazek)!=""){
    $row = mysqli_fetch_assoc($wyroznionyObrazek);
    $wyroznionyObrazek=$row["obrazek_wyrozniajacy_wpisu"];
}
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
}
try{
$wynik=$connection->query("SELECT * FROM ustawieniaseo");
} catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
if (mysqli_num_rows($wynik)>0) {
    try{
        $kodGSC=$connection->query("SELECT kod_gsc from ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1");
        } catch(Exception $e){
            echo $e->getCode().', komunikat:'.$e->getMessage();
        }
        $row = mysqli_fetch_assoc($kodGSC);
        $kodGSC=$row["kod_gsc"];
    
        try{
            $kodGA=$connection->query("SELECT kod_GA from ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1");
            } catch(Exception $e){
                echo $e->getCode().', komunikat:'.$e->getMessage();
            }
            $row = mysqli_fetch_assoc($kodGA);
            $kodGA=$row["kod_GA"];
            try{
                $kodGTM_head=$connection->query("SELECT kod_GTM_head from ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1");
                } catch(Exception $e){
                    echo $e->getCode().', komunikat:'.$e->getMessage();
                }
                $row = mysqli_fetch_assoc($kodGTM_head);
                $kodGTM_head=$row["kod_GTM_head"];
                try{
                    $kodGTM_body=$connection->query("SELECT kod_GTM_body from ustawieniaseo ORDER BY id_ustawienia DESC LIMIT 1");
                    } catch(Exception $e){
                        echo $e->getCode().', komunikat:'.$e->getMessage();
                    }
                    $row = mysqli_fetch_assoc($kodGTM_body);
                    $kodGTM_body=$row["kod_GTM_body"];
}
try{
    $zUstawienOgolnych=$connection->query("SELECT logo,lokalizacja,numer_telefonu,mail from ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1");
    } catch(Exception $e){
        echo $e->getCode().', komunikat:'.$e->getMessage();
    }
    $row = mysqli_fetch_assoc($zUstawienOgolnych);
    $logo=$row["logo"];
    $lokalizacja=$row["lokalizacja"];
    $numerTelefonu=$row["numer_telefonu"];
    $mail=$row["mail"];
