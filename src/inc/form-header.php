<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link href="css/primetimept.css" rel="stylesheet" type="text/css">
    <title><?= $title ?? 'Home' ?></title>
	<script src="js/signature_pad.js"></script>
	<script type="text/javascript"></script>
	<script src="../js/primetimept.js"></script>
	<script src="../js/jquery-3.4.1.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap-4.4.1.js"></script>
</head>
<body style="padding-top: 70px"> 
<?php view('navbar')?>
<main class="container-fluid">
<?php flash() ?>





