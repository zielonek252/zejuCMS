<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
?>

<div class="mx-auto w-75 p-3" id="main">
    <table class="mt-4 table table-striped">
        <thead>
            <tr>
                <th scope="col">Id wpisu</th>
                <th scope="col">Nazwa wpisu</th>
                <th scope="col">Adres url wpisu</th>
                <th scope="col">Data ostatniej modyfikacji</th>
                <th scope="col">Edytuj</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $wpisy = array();
            $elementy = $connection->query("SELECT * FROM blog ORDER BY data_publikacji_wpisu,id_wpisu DESC");
            while ($wpis = mysqli_fetch_assoc($elementy)) {
                $wpisy[] = $wpis;
            }
            foreach ($wpisy as $wpis) {
            ?>
                <tr>
                    <th scope="row"><?php echo $wpis['id_wpisu'] ?></th>
                    <td><?php echo $wpis['tytul_wpisu'] ?></td>
                    <td><?php echo $wpis['url_wpisu'] ?></td>
                    <td><?php echo $wpis['data_publikacji_wpisu'] ?></td>
                    <td>
                        <form method="post" action="/panel/edytuj-wpis.php?pid=<?php echo $wpis['id_wpisu'] ?>">
                            <input class="btn btn-warning" type="submit" value="Edytuj" />
                        </form>
                    </td>
                    <td>
                        <form method="post" action="?delete-pid=<?php echo $wpis['id_wpisu'] ?>">
                            <input class="btn btn-danger" type="submit" value="Usuń" />
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <form action="/panel/dodaj-wpis.php">
        <input style="width:100%" class="btn btn-success mt-4" type="submit" value="Dodaj wpis" />
    </form>
</div>
</body>
<?php
    if(isset($_GET['delete-pid'])){
    $idStronyGet=$_GET['delete-pid'];
    $zapytanie="DELETE from blog where id_wpisu='$idStronyGet'";
if (isset($_GET['delete-pid'])) {
    $idStronyGet = $_GET['delete-pid'];
    echo $idStronyGet;
        try {
            $connection->query($zapytanie);
        } catch (Exception $e) {
            echo $e->getCode() . ', komunikat:' . $e->getMessage();
        }
?>
        <script type="text/javascript">
            alert('Usunięto wpis!');
        </script>
    <?php
        odswiez();
}
}
function odswiez()
{
    echo "<meta http-equiv='refresh' content='0;url=/panel/blog.php'>";
}
?>