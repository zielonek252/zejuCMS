<?php
include 'connect.php';
global $connection;

    $glowneMenu = array();
$dropdownMenu = array();
$czyDropdown=array();
$tablicaIdDropdown=array();
$j=1;
$elementy = $connection->query("SELECT id_strony, kolejnosc_w_menu,tytul_strony, url_strony, id_nadrzednej_strony, czy_wyswietlic_w_menu FROM strony ORDER BY kolejnosc_w_menu,id_nadrzednej_strony, id_strony ASC");
while ($idStrony = mysqli_fetch_assoc($elementy)){
    if($idStrony['czy_wyswietlic_w_menu']==0){
        $czyDropdown[$j]=0;
        $glowneMenu[] = $idStrony;
        $tablicaIdDropdown[$j]=$idStrony['id_nadrzednej_strony'];
    } else{
    if($idStrony['id_nadrzednej_strony']==0){
    $glowneMenu[] = $idStrony;
    $czyDropdown[$j]=0;
    $tablicaIdDropdown[$j]=0;
} else{
    $dropdownMenu[]=$idStrony;
    $tablicaIdDropdown[$j]=$idStrony['id_nadrzednej_strony'];
    $czyDropdown[$idStrony['id_nadrzednej_strony']]=1;
    if($j==$idStrony['id_nadrzednej_strony']){
        $czyDropdown[$j]=1;
    }
}
}
$j++;
}
$i=0;
$aktualneId="";
$g=1;
foreach($glowneMenu as $idStrony){
    if($idStrony['czy_wyswietlic_w_menu']==0){
        $g++;
    } else{
    $aktualneId=$idStrony['id_strony'];
    for($a=1;$a<=count($tablicaIdDropdown);$a++){
        if($tablicaIdDropdown[$a]==$aktualneId){
            $czyDropdown[$g]=1;
        }
    }
    if($czyDropdown[$g]==0){
?>
<li class="nav-item"><a class="nav-link" href="<?php echo $idStrony['url_strony'];?>"><?php echo $idStrony['tytul_strony'];?></a></li>
<?php
} else if($czyDropdown[$g]==1){
    ?>
    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="<?php echo $idStrony['url_strony'];?>"id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $idStrony['tytul_strony'];?></a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

<?php
foreach($dropdownMenu as $idStrony){
    if($idStrony['id_nadrzednej_strony']==$aktualneId){
?>
<a class="dropdown-item" href="<?php echo $idStrony['url_strony'];?>"><?php echo $idStrony['tytul_strony'];?></a>
<?php
$i++;
    }
}
if($i>0){
    ?>
    </div>
    </li>
    <?php
}
$g++;
}
    }
}
?>


<?php
?>