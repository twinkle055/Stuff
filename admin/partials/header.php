<?php ob_start(); ?>
<?php session_start(); ?>
<?php require '../config/db.php' ?>
<?php include './functions.php' ?>
<?php 
    if ( (!isset($_SESSION['role'])) && ($_SESSION['role'] !== "admin") ) {
        header("Location: ../index.php");
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>STUFF</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="css/paper-dashboard.css" rel="stylesheet"/>

    <!-- Extra classes -->
    <link rel="stylesheet" href="css/class.css">

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link href="css/themify-icons.css" rel="stylesheet">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Tiny MCE -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

    <script src="js/scripts.js"></script>

</head>
<body>
    <div class="wrapper">
            <?php include 'includes/partials/sidebar.php' ?>
            <?php include 'includes/partials/navigation.php' ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">