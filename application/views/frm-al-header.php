<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fetch Delivers | Pet Supplies Delivered Right To Your Door</title>

    <!-- Bootstrap Core CSS -->


    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/grayscale.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min">

    <!-- Custom CSS -->

    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <div class="header-logo">
                <img src="<?php echo base_url();?>img/fetchlogo.gif" width="100" height="36">
            </div>
            <ul class="nav navbar-nav">
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/3">
                        dog
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/2">
                        CAT
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/1">
                        BIRD
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/4">
                        SMALL ANIMAL
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/8">
                        FISH
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/7">
                        REPTILE
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/9">
                        WILD BIRD
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll" href="<?php echo base_url();?>product/products/6">
                        OTHER
                    </a>
                </li>
                <li>
                    <a class="navbar-brand page-scroll last" href="<?php echo base_url();?>product/products/2">
                        SALE
                    </a>
                </li>
            </ul>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <div class="login-control">
                <ul class="nav navbar-nav ">
                    <li>
                        <button name="singupButton" class="orange-button">SIGNUP</button>
                    </li>
                    <li>
                        <button name="loginButton" class="orange-button">LOGIN</button>
                    </li>
                    <li>
                        <input type="text" value=""><img src="<?php echo base_url();?>img/search.png">
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>