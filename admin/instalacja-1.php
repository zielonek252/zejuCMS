<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/instalator.css">
    <meta name="robots" content="noindex" />
    <title>zejuCMS - instalacja</title>
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
            <p class="text-center">Poniższe dane są wymagane, aby poprawnie zaimplementować bazę danych. Po poprawnej autoryzacji, zostaniesz przeniesiony do drugiego kroku. </p>
            <form class="w-50 p-3 mx-auto" method="post">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Użytkownik</label>
                    <input type="text" class="form-control" name="nazwaUzytkownikaBazyDanych" placeholder="Wpisz nazwę użytkownika bazy danych">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput3">Hasło</label>
                    <input type="text" class="form-control" name="hasloUzytkownikaBazyDanych" placeholder="Wpisz hasło użytkownika bazy danych">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput4">Serwer bazy danych</label>
                    <input type="text" class="form-control" name="serwerBazyDanych" placeholder="Wpisz adres serwera bazy danych">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput5">Prefiks bazy danych</label>
                    <input type="text" class="form-control" name="prefiksBazyDanych" placeholder="Wpisz prefiks bazy danych">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="form-control" value="Sprawdź poprawność">
                </div>
            </form>
        </div>
    </div>


    <?php
    $connection="";
    include 'connect.php';
    if (!$connection) {
      } else{
        header("Location: instalacja-2.php");

      }
if(isset($_POST['submit'])){
    sprawdzPoprawnosc();
}
function sprawdzPoprawnosc(){
$servername = $_POST['serwerBazyDanych'];
$username = $_POST['nazwaUzytkownikaBazyDanych'];
$password = $_POST['hasloUzytkownikaBazyDanych'];
$prefiks = $_POST['prefiksBazyDanych'];
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else{
$sql = "CREATE DATABASE IF NOT EXISTS ".$prefiks."_zejuCMS";
try{
if ($conn->query($sql) === TRUE) {
    $zapis=fopen("connect.php","w");
$con='<?php'."\n".'$connection=new mysqli("'.$servername.'", "'.$username.'", "'.$password.'","'.$prefiks.'_zejucms");'."\n".'?>';
fputs($zapis, $con);
    echo "Database created successfully";
    header("Location: instalacja-2.php");
  } else {
    echo "Nie udało się utworzyć bazy danych: " . $conn->error;
  }
}
catch(Exception $e){
    {
        echo $e->getCode().', komunikat:'.$e->getMessage();
    }
}
}
}


?>


</body>

</html>