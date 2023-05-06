<?php
include 'funkcje.php';
include 'nawigacja.php';
    try {
        $zapytanie = $connection->query("SELECT * FROM uzytkownicy");
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $uzytkownicy=array();
    while($uzytkownik = mysqli_fetch_assoc($zapytanie)){
$uzytkownicy[]=$uzytkownik;
    }
    $bladWalidacjiHasla = "";
    $bladWalidacjiMaila = "";
    $bladWalidacjiNazwyAdmina = "";
    $prawidlowaNazwa = 0;
    $prawidloweHaslo = 0;
    $prawidlowyMail = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nazwaAdmina = $_POST['nazwaUzytkownika'];
        $haslo = $_POST['hasloUzytkownika'];
        $email = $_POST["eMail"];
        if (strlen($nazwaAdmina) < 3) {
            $bladWalidacjiNazwyAdmina = "Nazwa użytkownika musi mieć co najmniej 3 znaki";
        } else {
            foreach($uzytkownicy as $uzytkownik){
                if($uzytkownik['nazwa_uzytkownika']!=$nazwaAdmina){
                    $prawidlowaNazwa = 1;
                }else{
                    $prawidlowaNazwa=0;
                    $bladWalidacjiNazwyAdmina = "Taki użytkownik już istnieje.";
                }
            }
        }
        if (strlen($haslo) < 6) {
            $bladWalidacjiHasla = "Hasło musi mieć co najmniej 6 znaków";
        } else {
            $prawidloweHaslo = 1;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $bladWalidacjiMaila = "Zły format maila!";
        } else {
            foreach($uzytkownicy as $uzytkownik){
                if($uzytkownik['mail_uzytkownika']!=$email){
                    $prawidlowyMail = 1;
                }else{
                    $prawidlowyMail=0;
                    $bladWalidacjiMaila = "Taki mail już istnieje.";
                }
            }
        }
    }
?>
<div class="mx-auto w-75 p-3" id="main">
    <form action="/panel/uzytkownicy.php">
        <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
    </form>
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
                    <input type="submit" name="submit" class="form-control" value="Dodaj użytkownika">
                </div>
            </form>
</div>
<?php
if (isset($_POST['submit'])) {
    if ($prawidlowaNazwa == 1 && $prawidloweHaslo == 1 && $prawidlowyMail == 1) {
        dodajUsera();
    }
}
function dodajUsera(){
    global $connection;
    $nazwaAdmina = $_POST['nazwaUzytkownika'];
    $email = $_POST["eMail"];
    $haslo = password_hash($_POST['hasloUzytkownika'], PASSWORD_BCRYPT, array('cost' => 12));
    $dodajUsera = "INSERT INTO Uzytkownicy (nazwa_uzytkownika,mail_uzytkownika,haslo_uzytkownika) VALUES ('$nazwaAdmina','$email','$haslo')";
try{
    $connection->query($dodajUsera);
    ?>
        <script type="text/javascript">
            alert('Dodano nowego użytkownika!');
        </script>
    <?php
}catch (Exception $e) {
    echo $e->getCode() . ', komunikat:' . $e->getMessage();
}
}
?>