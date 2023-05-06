<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
?>

<div class="mx-auto w-75 p-3" id="main">
    <table class="mt-4 table table-striped">
        <thead>
            <tr>
                <th scope="col">Id strony</th>
                <th scope="col">Nazwa strony</th>
                <th scope="col">Adres url</th>
                <th scope="col">Strona nadrzędna</th>
                <th scope="col">Czy wyświetla się w menu</th>
                <th scope="col">Kolejność w menu</th>
                <th scope="col">Data ostatniej modyfikacji</th>
                <th scope="col">Edytuj</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $strony = array();
            $nazwaStrony=array();
            $pomocnicze=array();
            $elementy = $connection->query("SELECT id_strony, url_strony,kolejnosc_w_menu,tytul_strony, id_nadrzednej_strony, czy_wyswietlic_w_menu, data_publikacji, CASE WHEN id_nadrzednej_strony!=0 THEN id_nadrzednej_strony ELSE id_strony END AS kolejnosc FROM strony ORDER BY kolejnosc,id_nadrzednej_strony ASC");
            while ($strona = mysqli_fetch_assoc($elementy)) {
                $strony[] = $strona;
$nazwaStrony[]=$strona['tytul_strony'];
$pomocnicze[]=$strona['id_strony'];
            }
            $zapytanie="SELECT czy_blog FROM ustawieniaogolne ORDER BY id_ustawienia DESC LIMIT 1";
try{
    $wykonaneZapytanie=$connection->query($zapytanie);
} catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
  }
  $czyBlog = mysqli_fetch_assoc($wykonaneZapytanie);

            $i=1;
            foreach ($strony as $strona) {
                if($czyBlog['czy_blog']==0&&$strona['id_strony']==3){

                }else{
            ?>
                <tr>
                    <th scope="row"><?php if($strona['id_nadrzednej_strony']!=0){
                        echo "— ".$strona['id_strony'];
                    }else{
                        echo $strona['id_strony']; }?></th>
                    <td><?php echo $strona['tytul_strony'];
                    $nazwaStrony[$i]=$strona['tytul_strony']; ?></td>
                    <td><?php echo $strona['url_strony'] ?></td>
                    <td><?php $idNadrzednejStrony = $strona['id_nadrzednej_strony'];
                        if ($idNadrzednejStrony == 0) {
                            echo "Główne menu";
                        } else {
                            for($j=0;$j<count($nazwaStrony);$j++){
                                if($idNadrzednejStrony==$pomocnicze[$j]){
                                    echo $nazwaStrony[$j+1];
                                }
                            }
                        } ?></td>
                    <td><?php if ($strona['czy_wyswietlic_w_menu'] == 0) {
                            echo "Nie";
                        } else {
                            echo "Tak";
                        } ?></td>
                         <td><?php if ($strona['czy_wyswietlic_w_menu'] == 0) {
                            echo "Nie dotyczy";
                        } else {
                            echo $strona['kolejnosc_w_menu'];
                        } ?></td>
                    <td><?php echo $strona['data_publikacji'] ?></td>
                    <td>
                    <form method="post" action="/panel/edycja-strony.php?pid=<?php echo $strona['id_strony'] ?>">    
                    <input class="btn btn-warning" type="submit" value="Edytuj" />
                    </form>
                </td>
                    <td>
                    <form method="post" action="?delete-pid=<?php echo $strona['id_strony'] ?>">    
                    <input class="btn btn-danger" type="submit" value="Usuń" />
                    </form>
                </td>
                </tr>
            <?php
            $i++;
            }
        }
            ?>
        </tbody>
    </table>
    <form action="/panel/dodaj-strone.php">
<input style="width:100%" class="btn btn-success mt-4" type="submit" value="Dodaj stronę" />
</form>
</div>
</body>


<?php
    if(isset($_GET['delete-pid'])){
$idStronyGet = $_GET['delete-pid'];
echo $idStronyGet;
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
    odswiez();
}else{
    ?>
          <script type="text/javascript">
      alert('Nie możesz usunąc tej strony!');
    </script>
    <?php
        odswiez();

}
}
function odswiez(){
    echo "<meta http-equiv='refresh' content='0;url=/panel/strony.php'>";

}
?>