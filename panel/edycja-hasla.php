<?php
include 'funkcje.php';
include 'nawigacja.php';
$idUseraGet = $_GET['pass-uid'];
if ($idUsera == 1) {
    try {
        $aktualnyUser = $connection->query("SELECT * FROM uzytkownicy WHERE id_uzytkownika='$idUseraGet'");
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $uzytkownik = mysqli_fetch_assoc($aktualnyUser);
} else if ($idUseraGet != 1 &&$idUseraGet==$idUsera) {
    try {
        $aktualnyUser = $connection->query("SELECT * FROM uzytkownicy WHERE id_uzytkownika='$idUseraGet'");
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
    $uzytkownik = mysqli_fetch_assoc($aktualnyUser);
}else{
    header("Location: /panel/uzytkownicy.php");
}
if (mysqli_num_rows($aktualnyUser) == 0) {
    header("Location: /panel/uzytkownicy.php");
}
$hasloStare = $uzytkownik['haslo_uzytkownika'];
?>
<div class="mx-auto w-75 p-3" id="main">
    <form action="/panel/uzytkownicy.php">
        <input style="width:100%" class="btn btn-secondary mb-4 mt-2" type="submit" value="Powróć" />
    </form>
    <form method="post">
        <?php
if($idUseraGet==$idUsera){
        ?>
        <div class="form-group">
            <label for="nazwa_strony_input">Aktualne hasło</label>
            <input name="aktualne-haslo" type="password" class="form-control" id="nazwa_strony_input" placeholder="Wpisz aktualne hasło">
        </div>
        <?php
        }else if($idUseraGet==1&&$idUseraGet!=$idUsera){

        }
        ?>
        <div class="form-group">
            <label for="nazwa_strony_input">Nowe hasło</label>
            <input name="nowe_haslo" type="password" class="form-control" id="nazwa_strony_input" placeholder="Wpisz nowe hasło">
        </div>
        <div class="form-group">
            <label for="nazwa_strony_input">Powtórz nowe hasło</label>
            <input name="powtorz_nowe_haslo" type="password" class="form-control" id="nazwa_strony_input" placeholder="Powtórz nowe hasło">
        </div>
        <div class="form-group">
            <input style="width:100%" type="submit" name="submit" class="btn btn-success" value="Zmień hasło">
        </div>
    </form>
</div>
<?php
if (isset($_POST['submit'])) {
$noweHaslo=$_POST['nowe_haslo'];
$powtorzoneNoweHaslo=$_POST['powtorz_nowe_haslo'];
$aktualneHaslo=$_POST['aktualne-haslo'];
$haslo = password_hash($noweHaslo, PASSWORD_BCRYPT, array('cost' => 12));
if($idUseraGet==1&&$idUsera!=1){
    if(strlen($noweHaslo)<6){
        $czyDlugie=0;
        ?>
        <script type="text/javascript">
          alert('Wprowadzone hasło jest za krótkie. Użyj co najmniej 6 znaków.');
        </script>
        <?php
    }else{
    $czyDlugie=1;
    }
    if($noweHaslo==$powtorzoneNoweHaslo&&$czyDlugie==1){
        walidacja();
    }
}else{
if(password_verify($aktualneHaslo, $hasloStare)){
$czyHaslaZgadzajaSie=1;
}else{
    $czyHaslaZgadzajaSie=0;
}
if(strlen($noweHaslo)<=6&&$czyHaslaZgadzajaSie==1){
    $czyDlugie=0;
    ?>
    <script type="text/javascript">
      alert('Wprowadzone hasło jest za krótkie. Użyj co najmniej 6 znaków.');
    </script>
    <?php
}else{
$czyDlugie=1;
}
if($noweHaslo==$powtorzoneNoweHaslo&&$czyHaslaZgadzajaSie==1&&$czyDlugie==1){
    walidacja();
}else if($noweHaslo!=$powtorzoneNoweHaslo){
    ?>
    <script type="text/javascript">
      alert('Wprowadzone hasła różnią się od siebie');
    </script>
    <?php
}
}
}
function walidacja(){
    global $haslo,$idUseraGet,$connection,$noweHaslo;
    try {
        $zapytanie = "UPDATE uzytkownicy
SET haslo_uzytkownika = '$haslo'
WHERE id_uzytkownika = '$idUseraGet'";
        $connection->query($zapytanie);
    } catch (Exception $e) {
        echo $e->getCode() . ', komunikat:' . $e->getMessage();
    }
?>
    <script type="text/javascript">
      alert('Hasło zostało zmienione!');
    </script>
    <meta http-equiv='refresh' content='0'>
<?php
    session_destroy();
    header("Location: /logowanie");
}
?>