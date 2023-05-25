<!DOCTYPE html>
<?php 
ob_start();
session_start();
 $uri = "http://".  $_SERVER['SERVER_NAME'] ."/portfolio/admin/";
 if(!isset($_SESSION['isLoggedIn'])){
    header("Location: index.php");
    exit();
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $uri ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://designreset.com/cork/ltr/demo4/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="https://designreset.com/cork/ltr/demo4/plugins/table/datatable/dt-global_style.css">

    <!-- custom Stylesheet -->
    <link href="<?php echo $uri ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- sidebar -->
        <?php include 'sidebar.php' ?>

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0" style="height: 10%;">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
               
            </nav>
            <!-- Navbar End -->