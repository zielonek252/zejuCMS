<?php
include 'funkcje.php';
include 'nawigacja.php';
global $connection;
?>
<div class="mx-auto w-75 p-3" id="main">
    <h1 class="mt-2 text-center h3">Użytkownicy</h1>
    <hr>
    <table class="mt-4 table table-striped">
        <thead>
            <tr>
            <th scope="col">Id użytkownika</th>    
            <th scope="col">Użytkownik</th>
                <th scope="col">E-mail</th>
                <th scope="col">Edytuj</th>
                <th scope="col">Usuń</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $uzytkownicy = array();
            try{
            $elementy = $connection->query("SELECT * FROM uzytkownicy");
            while ($uzytkownik = mysqli_fetch_assoc($elementy)) {
                $uzytkownicy[] = $uzytkownik;
            }
        }catch (Exception $e) {
            echo $e->getCode() . ', komunikat:' . $e->getMessage();
        }
            foreach ($uzytkownicy as $uzytkownik) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $uzytkownik['id_uzytkownika']?></th>
                        <td><?php echo $uzytkownik['nazwa_uzytkownika'] ?></td>
                        <td><?php echo $uzytkownik['mail_uzytkownika'] ?></td>
                        <?php
                        if($idUsera==1||$uzytkownik['id_uzytkownika']==$idUsera){
                            ?>
                        <td>
                            <form method="post" action="/panel/edycja-uzytkownika.php?uid=<?php echo $uzytkownik['id_uzytkownika'] ?>">
                                <input class="btn btn-warning" type="submit" value="Edytuj" />
                            </form>
                        </td>
                        <td>
                            <form method="post" action="?delete-uid=<?php echo $uzytkownik['id_uzytkownika'] ?>">
                                <input class="btn btn-danger" type="submit" value="Usuń" />
                            </form>
                        </td>
                        <?php
                    }else{
                        ?>
                        <td>
                            <form method="post">
                                <input class="btn btn-warning disabled" type="submit" value="Edytuj" />
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input class="btn btn-danger disabled" type="submit" value="Usuń" />
                            </form>
                        </td>
                        <?php
                    }
                    ?>
                    </tr>
            <?php

            }
            ?>
        </tbody>
    </table>
    <form action="/panel/dodaj-uzytkownika.php">
        <input style="width:100%" class="btn btn-success mt-4" type="submit" value="Dodaj użytkownika" />
    </form>
</div>
</body>


<?php
if (isset($_GET['delete-uid'])) {
    $idUz = $_GET['delete-uid'];
    if ($idUz != 1 && $idUz==$idUsera||$idUsera==1) {
        if($idUz!=1){
        $zapytanie = "DELETE from uzytkownicy where id_uzytkownika='$idUz'";
        try {
            $connection->query($zapytanie);
        } catch (Exception $e) {
            echo $e->getCode() . ', komunikat:' . $e->getMessage();
        }
?>
        <script type="text/javascript">
            alert('Usunięto użytkownika!');
        </script>
    <?php
        odswiez();
    } else {
    ?>
        <script type="text/javascript">
            alert('Nie możesz tego zrobić!');
        </script>
<?php
        odswiez();
    }
}
}
function odswiez()
{
    echo "<meta http-equiv='refresh' content='0;url=/panel/uzytkownicy.php'>";
}
?>