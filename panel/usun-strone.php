<?php
$idStronyGet = $_GET['pid'];
global $connection;
$czy=0;
if($idStronyGet!=1&&$idStronyGet!=2&&$idStronyGet!=3){
    $zapytanie="DELETE from strony where id_strony='$idStronyGet'";
    try{
        $connection->query($zapytanie);
    }catch(Exception $e){
        echo $e->getCode().', komunikat:'.$e->getMessage();
      }
      ?>
          <script type="text/javascript">
      alert('Usunięto stronę!');
    </script>
    <?php
    $czy=1;
}else{
    ?>
          <script type="text/javascript">
      alert('Nie możesz usunąc tej strony!');
    </script>
    <?php
$czy=1;
}
if($czy==1){
header("Location: /panel/strony.php");
}
?>