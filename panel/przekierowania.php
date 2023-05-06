<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
?>

<div class="mx-auto w-75 p-3" id="main">
    <?php
    ?>
<form method="post">
  <div class="form-row mt-4">
    <div class="col">
      <input type="text" name="stary_url"class="form-control" placeholder="Stary slug (uprosczony adres url)">
    </div>
    <div class="col">
      <input type="text" name="nowy_url" class="form-control" placeholder="Nowy adres URL">
    </div>
  </div>
  <input style="width:100%" name="submit"class="btn btn-success mt-2  mb-3" type="submit" value="Dodaj przekierowanie" />
</form>
    <table class="mt-4 table table-striped">
        <thead>
            <tr>
                <th scope="col">Id przekierowania</th>
                <th scope="col">Stary adres</th>
                <th scope="col">Nowy adres</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $przekierowania = array();
            $elementy = $connection->query("SELECT * from przekierowania order by id_przekierowania DESC");
            while($przekierowanie = mysqli_fetch_assoc($elementy)){
$przekierowania[]=$przekierowanie;
            }
            if(mysqli_num_rows($elementy)>0){
foreach($przekierowania as $przekierowanie){
?>
                <tr>
                    <th scope="row"><?php echo $przekierowanie['id_przekierowania']?></th>
                    <td><?php echo $przekierowanie['stary_url'];?></td>
                    <td><?php echo $przekierowanie['nowy_url'] ?></td>
                    <td>
                    <form method="post" action="?delete-pid=<?php echo $przekierowanie['id_przekierowania'] ?>">    
                    <input class="btn btn-danger" type="submit" value="Usuń" />
                    </form>
                </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</body>


<?php
}
    if(isset($_GET['delete-pid'])){
$idStronyGet = $_GET['delete-pid'];
    $zapytanie="DELETE from przekierowania where id_przekierowania='$idStronyGet'";
    try{
        $connection->query($zapytanie);
    }catch(Exception $e){
        echo $e->getCode().', komunikat:'.$e->getMessage();
      }
odswiez();
    }
function odswiez(){
    echo "<meta http-equiv='refresh' content='0;url=/panel/przekierowania.php'>";

}
if(isset($_POST['submit'])){
    global $connection;
$staryURL=$_POST['stary_url'];
$nowyURL=$_POST['nowy_url'];
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$staryURL=str_replace($actual_link,'',$staryURL);
$zapytanie="INSERT INTO przekierowania (stary_url,nowy_url) VALUES('$staryURL','$nowyURL')";
try{
    $connection->query($zapytanie);
}catch(Exception $e){
  echo $e->getCode().', komunikat:'.$e->getMessage();
}
odswiez();
}
?>