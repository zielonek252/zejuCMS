<?php
include 'connect.php';
if (!$connection) {
    header("Location: instalacja-1.php");
}
$bladWalidacjiHasla = "";
$bladWalidacjiMaila = "";
$bladWalidacjiNazwyAdmina = "";
$prawidlowaNazwa = 0;
$prawidloweHaslo = 0;
$prawidlowyMail = 0;
$data = date("Y-m-d");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwaAdmina = $_POST['nazwaUzytkownika'];
    $haslo = $_POST['hasloUzytkownika'];
    $email = $_POST["eMail"];
    if (strlen($nazwaAdmina) < 3) {
        $bladWalidacjiNazwyAdmina = "Nazwa użytkownika musi mieć co najmniej 3 znaki";
    } else {
        $prawidlowaNazwa += 1;
    }
    if (strlen($haslo) < 6) {
        $bladWalidacjiHasla = "Hasło musi mieć co najmniej 6 znaków";
    } else {
        $prawidloweHaslo += 1;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $bladWalidacjiMaila = "Zły format maila!";
    } else {
        $prawidlowyMail += 1;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/instalator.css">
    <meta name="robots" content="noindex" />
    <title>zejuCMS - instalacja część 2</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>

    <div class="row">
        <div class="mx-auto w-75 p-3" id="sekcjaFormularza">
            <div class="col-md-8 offset-md-2 ">
                <h1 class="text-center">zejuCMS</h1>
            </div>
            <hr class="my-4">
            <p class="text-center">Gratulacje! Autoryzacja bazy danych udała się, wprowadź dane konta, które chcesz utworzyć i pamiętaj, aby je zapisać!</p>
            <form class="w-50 p-3 mx-auto" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Użytkownik</label>
                    <input type="text" class="form-control" name="nazwaUzytkownika" placeholder="Wpisz nazwę administratora">
                    <span style="color:red;" for="formGroupExampleInput4"><?php echo $bladWalidacjiNazwyAdmina; ?></span>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput3">Hasło</label>
                    <input type="password" class="form-control" name="hasloUzytkownika" placeholder="Wpisz hasło administratora">
                    <label style="color:red;" for="formGroupExampleInput4"><?php echo $bladWalidacjiHasla; ?></label>

                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput4">E-mail</label>
                    <input type="text" class="form-control" name="eMail" placeholder="Wpisz adres e-mail administratora">
                    <label style="color:red;" for="formGroupExampleInput4"><?php echo $bladWalidacjiMaila; ?></label>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="form-control" value="Utwórz bazę">
                </div>
            </form>
        </div>
    </div>


    <?php
    if (isset($_POST['submit'])) {
        if ($prawidlowaNazwa == 1 && $prawidloweHaslo == 1 && $prawidlowyMail == 1) {
            instalujBaze();
        }
    }

    function instalujBaze()
    {
        global $connection, $data;
        $nazwaAdmina = $_POST['nazwaUzytkownika'];
        $email = $_POST["eMail"];
        $haslo = password_hash($_POST['hasloUzytkownika'], PASSWORD_BCRYPT, array('cost' => 12));
        $tabelaUzytkownikow = "CREATE TABLE IF NOT EXISTS Uzytkownicy(
        id_uzytkownika INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nazwa_uzytkownika VARCHAR(255) NOT NULL,
        mail_uzytkownika VARCHAR(255) NOT NULL,
        haslo_uzytkownika VARCHAR(255) NOT NULL)";

        $tabelaStron = "CREATE TABLE IF NOT EXISTS Strony(
        id_strony INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_nadrzednej_strony INT(6),
        czy_wyswietlic_w_menu INT NOT NULL,
        kolejnosc_w_menu INT,
        url_strony VARCHAR(255) NOT NULL,
        tytul_strony VARCHAR(255) NOT NULL,
        tytul_seo_strony VARCHAR(255),
        opis_seo_strony VARCHAR(255),
        indeksowalnosc_seo_strony INT NOT NULL,
        data_publikacji DATE NOT NULL,
        zawartosc_strony TEXT,
        naglowek_h1 TEXT)";

        $ustawieniaSEO = "CREATE TABLE IF NOT EXISTS ustawieniaSEO(
        id_ustawienia INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        czy_https INT,
        czy_www INT,
        kod_gsc TEXT,
        kod_GTM_head TEXT,
        kod_GTM_body TEXT,
        kod_GA TEXT)";

        $ustawieniaOgolne = "CREATE TABLE IF NOT EXISTS ustawieniaOgolne(
        id_ustawienia INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        logo TEXT,
        czy_blog INT,
        zdjecie_tlo TEXT,
        lokalizacja TEXT,
        numer_telefonu TEXT,
        mail TEXT)";

        $przekierowania = "CREATE TABLE IF NOT EXISTS przekierowania(
        id_przekierowania INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        stary_url TEXT,
        nowy_url TEXT)";

        $blog = "CREATE TABLE IF NOT EXISTS blog(
                id_wpisu INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                url_wpisu VARCHAR(255) NOT NULL,
                tytul_wpisu VARCHAR(255) NOT NULL,
                tytul_seo_wpisu VARCHAR(255),
                opis_seo_wpisu VARCHAR(255),
                indeksowalnosc_seo_wpisu INT NOT NULL,
                data_publikacji_wpisu DATE NOT NULL,
                obrazek_wyrozniajacy_wpisu TEXT,
                zawartosc_wpisu TEXT)";

        $dodajUsera = "INSERT INTO Uzytkownicy (nazwa_uzytkownika,mail_uzytkownika,haslo_uzytkownika) VALUES ('$nazwaAdmina','$email','$haslo')";
        $dodajStroneGlownaDoBazy = "INSERT INTO Strony (id_nadrzednej_strony,czy_wyswietlic_w_menu,kolejnosc_w_menu,url_strony,tytul_strony,tytul_seo_strony,opis_seo_strony,indeksowalnosc_seo_strony,data_publikacji,zawartosc_strony,naglowek_h1) VALUES('0','1','0','/','Strona główna','Strona główna | zejuCMS','','1','date(Y-m-d)','Treść strony głównej możesz zmienić w panelu administracyjnym!','Strona główna')";
        $dodajLogowanieDoBazy = "INSERT INTO Strony (id_nadrzednej_strony,czy_wyswietlic_w_menu,url_strony,tytul_strony,kolejnosc_w_menu,tytul_seo_strony,opis_seo_strony,indeksowalnosc_seo_strony,data_publikacji,zawartosc_strony,naglowek_h1) VALUES('0','0','/logowanie','Logowanie','0','Logowanie','','0','date(Y-m-d)','','Logowanie')";
        $dodajBlog = "INSERT INTO Strony (id_nadrzednej_strony,czy_wyswietlic_w_menu,url_strony,tytul_strony,kolejnosc_w_menu,tytul_seo_strony,opis_seo_strony,indeksowalnosc_seo_strony,data_publikacji,zawartosc_strony,naglowek_h1) VALUES('0','0','/blog','Blog','0','Blog','','0','date(Y-m-d)','','Blog')";
        $dodajWpis = "INSERT INTO blog (url_wpisu,tytul_wpisu,tytul_seo_wpisu,indeksowalnosc_seo_wpisu,data_publikacji_wpisu,obrazek_wyrozniajacy_wpisu,zawartosc_wpisu)VALUES('/blog/pierwszy-wpis','Twój pierwszy wpis','Pierwszy wpis','0','$data','/img/placeholder.jpg','Zmień zawartośc wpisu w panelu!')";
        $ustawLogo = "INSERT INTO ustawieniaOgolne (logo,zdjecie_tlo,lokalizacja,numer_telefonu,mail) VALUES ('/img/logo.png','/img/hero.jpg','Zmień dane w panelu administratora','Zmień dane w panelu administratora','Zmień dane w panelu administratora')";
        $dodajUstawieniaSEO = "INSERT INTO ustawieniaseo (czy_https,czy_www,kod_gsc,kod_GTM_head,kod_GTM_body,kod_GA) VALUES(NULL,NULL,'','','','')";

        try {
            if ($connection->query($tabelaUzytkownikow) === TRUE && $connection->query($tabelaStron) === TRUE && $connection->query($ustawieniaSEO) === TRUE && $connection->query($przekierowania) === TRUE && $connection->query($blog) === TRUE && $connection->query($dodajUsera) === TRUE && $connection->query($dodajStroneGlownaDoBazy) === TRUE && $connection->query($ustawieniaOgolne) === TRUE && $connection->query($ustawLogo) === TRUE && $connection->query($dodajLogowanieDoBazy) === TRUE && $connection->query($dodajBlog) === TRUE && $connection->query($dodajWpis) === TRUE && $connection->query($dodajUstawieniaSEO) === TRUE) {
                echo "Udało się!";
                header("Location: /");
            } else {
                echo "Nie udało się utworzyć tabeli: " . $connection->error;
            }
        } catch (Exception $e) {
            echo $e->getCode() . ', komunikat:' . $e->getMessage();
        }
    }

    ?>


</body>

</html>