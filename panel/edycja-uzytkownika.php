<?php
include 'funkcje.php';
include 'nawigacja.php';
$idUseraGet = $_GET['uid'];
$uzytkownicy = array();
$prawidlowyMail=0;
$prawidlowaNazwa=0;
if ($idUsera == 1) {
    try {
        $aktualnyUser = $connection->query("SELECT * FROM uzytkownicy WHERE id_uzytkownika='$idUseraGet'");
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $uzytkownik = mysqli_fetch_assoc($aktualnyUser);
} else if ($idUseraGet != 1 && $idUseraGet == $idUsera) {
    try {
        $aktualnyUser = $connection->query("SELECT * FROM uzytkownicy WHERE id_uzytkownika='$idUseraGet'");
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $uzytkownik = mysqli_fetch_assoc($aktualnyUser);
} else {
    header("Location: /panel/uzytkownicy.php");
}

if (mysqli_num_rows($aktualnyUser) == 0) {
    header("Location: /panel/uzytkownicy.php");
}
$emailOld = $uzytkownik['mail_uzytkownika'];
$nameOld = $uzytkownik['nazwa_uzytkownika'];


try {
    $wszyscy = $connection->query("SELECT * FROM uzytkownicy");
} catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
while ($uzytkownik2 = mysqli_fetch_assoc($wszyscy)) {
    $uzytkownicy[] = $uzytkownik2;
}
?>
<div class="mx-auto w-75 p-3" id="main">
    <div class="row">
        <div class="col-sm">
            <form action="/panel/uzytkownicy.php">
                <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
            </form>
        </div>
        <div class="col-sm">
            <form method="post" action="/panel/edycja-hasla.php?pass-uid=<?php echo $idUseraGet ?>">
                <input style="width:100%" class="btn btn-warning mb-4 mt-2" type="submit" value="Edytuj hasło" />
            </form>
        </div>
    </div>
    <form method="post">
        <div class="form-group">
            <label for="nazwa_strony_input">Nazwa użytkownika</label>
            <input name="nazwa_uzytkownika" type="text" value="<?php echo $uzytkownik['nazwa_uzytkownika']; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nazwę użytkownika">
        </div>
        <div class="form-group">
            <label for="nazwa_strony_input">Adres e-mail</label>
            <input name="e-mail_uzytkownika" type="text" value="<?php echo $uzytkownik['mail_uzytkownika']; ?>" class="form-control" id="nazwa_strony_input" placeholder="Wpisz e-mail">
        </div>
        <div class="form-group">
            <input style="width:100%" type="submit" name="submit" class="btn btn-success" value="Zapisz">
        </div>
    </form>
</div>
<?php
if (isset($_POST['submit'])) {
    $nazwaUzytkownika = $_POST['nazwa_uzytkownika'];
    $eMail = $_POST['e-mail_uzytkownika'];
    if (!filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
?>
        <script type="text/javascript">
            alert('Wprowadziłeś błędny adres e-mail!');
        </script>
        <?php
        }else if ($eMail == $emailOld) {
            $prawidlowyMail = 0;
        } else {
            foreach ($uzytkownicy as $uzytkownik2) {
                if ($uzytkownik2['mail_uzytkownika'] != $eMail) {
                    $prawidlowyMail += 0;
                } else {
                    $prawidlowyMail = 1;
        ?>
                    <script type="text/javascript">
                        alert('Taki mail już istnieje!');
                    </script>
        <?php
                }
            }
        }

    if (strlen($nazwaUzytkownika) < 3) {
        ?>
        <script type="text/javascript">
            alert('Nazwa użytkownika musi mieć co najmniej 3 znaki.');
        </script>
        <?php
    } else {
        if ($nazwaUzytkownika == $nameOld) {
            $prawidlowaNazwa = 0;
        } else {
            foreach ($uzytkownicy as $uzytkownik2) {
                if ($uzytkownik2['nazwa_uzytkownika'] != $nazwaUzytkownika) {
                    $prawidlowaNazwa += 0;
                } else {
                    $prawidlowaNazwa = 1;
        ?>
                    <script type="text/javascript">
                        alert('Taki użytkownik już istnieje!');
                    </script>
            <?php
                }
            }
        }
    }
    if ($prawidlowaNazwa == 0 && $prawidlowyMail == 0) {
        if ($emailOld != $eMail || $nameOld != $nazwaUzytkownika) {
            try {
                $zapytanie = "UPDATE uzytkownicy
  SET nazwa_uzytkownika = '$nazwaUzytkownika',
  mail_uzytkownika = '$eMail'
  WHERE id_uzytkownika = $idUseraGet";
                $connection->query($zapytanie);
            } catch (Exception $e) {
                echo $e->getCode() . ', komunikat:' . $e->getMessage();
            }
            ?>
            <script type="text/javascript">
                alert('Zaktualizowano!');
            </script>
            <meta http-equiv='refresh' content='0'>
        <?php
        } else if ($nazwaUzytkownika == $nameOld && $eMail == $emailOld) {
        ?>
            <script type="text/javascript">
                alert('Nie wprowadziłeś żadnych zmian!');
            </script>
<?php
        }
    }
}
?>