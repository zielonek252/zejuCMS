<?php
include 'header.php';
include 'menu.php';
session_start();
if(isset($_SESSION['nazwaUsera'])) {
    header("Location: /panel/index.php");
    }?>
<?php
?>

	<div class="container mt-3">
		<div class="row justify-content-center align-items-center">


								<form class="w-50 p-3 mx-auto"id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<input name="nazwa" type="text" class="form-control" placeholder="Wprowadź nazwę administratora">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<input name="haslo" type="password" class="form-control" placeholder="Wprowadź hasło">
										</div>
									</div>

									<div class="form-group">

										<input name="zaloguj" class="btn btn-lg btn-primary btn-block" value="Zaloguj" type="submit">
									</div>
								</form>
							</div>
						</div>

	<hr>
</div> 
<?php
if(isset($_POST['zaloguj'])){
    tworzenieSesji();
}
function tworzenieSesji(){
$nazwaAdmina = $_POST['nazwa'];
$haslo = $_POST['haslo'];
include 'admin/connect.php';
global $connection;
try{
$pobierzHaslo=$connection->query("SELECT id_uzytkownika, haslo_uzytkownika from uzytkownicy where nazwa_uzytkownika='$nazwaAdmina'");
}catch(Exception $e){
    echo $e->getCode().', komunikat:'.$e->getMessage();
}
$row = mysqli_fetch_assoc($pobierzHaslo);
if($row!=""){
$hasloBazaDanych=$row["haslo_uzytkownika"];
$idUzytkownika=$row['id_uzytkownika'];
if(password_verify($haslo, $hasloBazaDanych)){
    $_SESSION['nazwaUsera']=$nazwaAdmina;
	$_SESSION['idUsera']=$idUzytkownika;
    header("Location: /panel/index.php");
    echo $_SESSION['nazwaUsera'];
} else{
    ?>
    <p class="text-center"><?php
    echo "Podałeś błędne hasło";
    ?>
    </p>
    <?php
}
}else{
    ?>
    <p class="text-center"><?php
    echo "Taki użytkownik nie istnieje";
    ?>
    </p>
    <?php
}
}
?>
