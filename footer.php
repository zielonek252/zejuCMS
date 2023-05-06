<!--Section: Contact v.2-->
<?php
include 'admin/operacje-header.php';
global $lokalizacja;
global $numerTelefonu;
global $mail;
?>
<hr>
<section>

    <!--Section heading-->
    <h3 class="text-center mb-5">Skontaktuj się z nami</h3>
    <!--Section description-->

    <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" method="POST">

                <!--Grid row-->
                <div class="row mb-3">

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label for="imie" class="">Imię</label>
                            <input type="text" id="imie" name="imie" class="form-control">
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <label for="email" class="">Adres e-mail</label>
                            <input type="text" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <label for="temat" class="">W jakim celu chcesz się z nami skontaktować?</label>
                            <input type="text" id="temat" name="temat" class="form-control">
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="message">Wiadomość</label>

                            <textarea type="text" id="wiadomosc" name="wiadomosc" rows="2" class="form-control md-textarea"></textarea>
                        </div>

                    </div>
                </div>
                <!--Grid row-->
                <div class="text-center text-md-left mt-3">
                <input style="width:100%"type="submit" name="submit" class="btn btn-primary" value="Wyślij!">
            </div>
            </form>


            <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
                <li><i class="bi bi-geo-alt form-ico"></i>
                    <p><?php echo $lokalizacja;?></p>
                </li>

                <li><i class="bi bi-telephone form-ico"></i>
                    <p><?php echo $numerTelefonu;?></p>
                </li>

                <li><i class="bi bi-envelope form-ico"></i>
                    <p><?php echo $mail;?></p>
                </li>
            </ul>
        </div>
        <!--Grid column-->

    </div>

</section>
<div id="footer">
<p class="mb-0 text-center">
    <?php
    echo '©'.date("Y").' ';
$aktualnaStrona=$_SERVER['SERVER_NAME'];
echo $aktualnaStrona;
?>
</p>
</div>

<?php
if(isset($_POST['submit'])){
    $doMaila=$mail;
    $odMaila=$_POST['email'];
    $imie=$_POST['imie'];
    $temat=$_POST['temat'];
    $wiadomosc=$_POST['wiadomosc'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <'.$mail.'>' . "\r\n";
    if ( mail($doMaila, $temat, $wiadomosc, $headers)){
?>
<script>
alert('Pomyślnie wysłano wiadomość!')
</script>
<?php
}else{
?>
<script>
alert('Coś poszło nie tak!')
</script>
<?php
}
}
?>
<!--Section: Contact v.2-->