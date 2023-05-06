<?php
include 'admin/connect.php';
include 'admin/operacje-header.php';
global $titleSeo;
global $aktualny_link;
global $descSeo;
global $indeksowalna;
global $wyroznionyObrazek;
global $kodGSC;
global $kodGA;
global $kodGTM_head;
global $kodGTM_body;
if (!$connection) {
    header("Location: instalacja-1.php");
} 
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="/js/script.js"></script>
    <link rel="stylesheet" href="/css/main.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titleSeo; ?></title>
    <link rel="canonical" href="<?php echo $aktualny_link; ?>" />
    <meta name="description" content="<?php echo $descSeo; ?>">
    <meta name="robots" content="<?php  echo $indeksowalna; ?>" />
    <?php 
    if($kodGSC!=""){
        echo $kodGSC;
        echo PHP_EOL;
    }
    if($kodGA!=""){
        echo $kodGA;
        echo PHP_EOL;

    }
    if($kodGTM_head!=""){
        echo $kodGTM_head;
        echo PHP_EOL;
    }
    ?>
    
</head>
<body>
    <?php
    if($kodGTM_head!=""){
        echo $kodGTM_body;
        echo PHP_EOL;
    }
    ?>