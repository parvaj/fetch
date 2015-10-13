<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frequency/sexy-combo.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frequency/frequency.css">
    <!-- Custom CSS -->

    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>css/social.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script-->
    <![endif]-->

</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container header-container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".test">
                   <i class="fa fa-bars"></i> <span style="color:coral;"> MENU </span>
                </button>
                <div class="header-logo">
                    <a style="border-right: 0px;" href="<?php echo base_url();?>"> <img src="<?php echo base_url();?>img/fetchlogo.gif" width="100" height="36"></a>
                </div>
                <!--button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".fetch-menu">
                    <i class="fa fa-bars"></i>MENU
                </button-->

            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 test">
                <div style="display:none;">
                    <button name="singupButton" class="orange-button">SIGNUP</button>
                    <button name="singupButton" class="orange-button">LOGIN</button>
                </div>
                    <?php echo $this->session->flashdata('message'); ?>
                     <ul class="nav navbar-nav fetch-menu">
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/3">
                                DOG
                            </a>
                        </li>
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/2">
                                CAT
                            </a>
                        </li>
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/1">
                                BIRD
                            </a>
                        </li>
                         <li>
                             <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/8">
                                 SMALL ANIMAL
                             </a>
                         </li>
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/4">
                                FISH
                            </a>

                        </li>


                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/7">
                                REPTILE
                            </a>
                        </li>
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/9">
                                WILD BIRD
                            </a>
                        </li>
                        <li>
                           <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/6">
                               HORSE
                           </a>
                        </li>
                        <li>
                            <a class="left-nav page-scroll" href="<?php echo base_url();?>product/products/5">
                                OTHER
                            </a>
                        </li>
                        <li>
                            <a class="left-nav page-scroll last" href="<?php echo base_url();?>product/products/11">
                                SALE
                            </a>
                        </li>

                        </ul>
                    <ul class="nav navbar-nav fetch-menu-right pull-right">
                        <!--li>
                            <!--a class="last" style="margin:0 38px;" href="<?php //echo base_url();?>checkout/cartItems"> cart<?php //echo isset($cartCount)? "(".$cartCount.")":"";?></a-->
                        <!--/li-->
                        <li class="">
                            <?php if ($this->session->userdata('logged_in') == TRUE) { ?> <div class="custom-font">Hello,</div>
                               <div class="name-style"> <?php echo $this->session->userdata('firstName'); ?></div>
                            <?php  }else {
                                ?>
                                <button name="singupButton" class="orange-button">SIGNUP</button>

                            <?php } ?>
                        </li>
                        <li class="">
                            <?php if( $this->session->userdata('logged_in') == TRUE ) { ?>
                                <button name="logoutButton" class="left-nav orange-button" onclick="location.href='<?php echo base_url();?>login/logout'">LOGOUT</button>
                            <?php } else {  ?>
                                <button name="loginButton" class="orange-button" id="loginButton">LOGIN</button>
                            <?php } ?>
                        </li>

                        <li class="search-bar">
                            <input type="text" value=""><img src="<?php echo base_url();?>img/search_icon_white.png">
                        </li>
                    </ul>

           </div>
        </div>
        <div class="row">
            <div class="col-md-7" >
                <div class="sub-menu">
                    <?php
                    $segments = $this->uri->segment(3);
                    if( !empty($segments) && isset($classes) ){
                        end($classes);
                        $keys = key($classes);
                        if (count($classes) > 0) {
                            $i = 0;
                            foreach ($classes as $class) {
                                if ($i == $keys) {
                                    $linkClass = 'last';
                                } else {
                                    $linkClass = 'fetch-classes';
                                }
                                echo "<a class='$linkClass' href='" . base_url() . "product/products/" . $urlSegment['deptSection'] . "/" . $class['class_id'] ."/2". "'>" . $class['class_name'] . "</a> ";
                                $i++;
                            }
                        }
                    }
                    ?>
                </div>
            </div>


            <div class="col-md-5" >
                <div class="row fetch-login">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <?php echo form_open(base_url().'login/process_login');?>
                        <?php echo form_input($username,'','class="test" placeholder="EMAIL ADDRESS"'); ?>
                        <?php echo form_password($password,'','placeholder="PASSWORD"'); ?>
                        <?php echo form_submit('login', 'Login' ,'class="formbutton"'); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- /.body -->
<header class="intro intro-size">
    <div class="intro-body">

                    <?php echo $body; ?>


    </div>
</header>
<!---
<header class="intro" style="border:1px solid green;margin-top:auto;">
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php //echo $body; ?>
                </div>
            </div>
        </div>
    </div>
</header>

->
<!-- /.end of body -->
<!-- Footer -->
<footer>
    <div class="container-fluid header-container">
        <div class="row">

            <div class="col-md-5">
                <div class="navbar-custom">
                    <ul class="nav navbar-nav ">
                        <!-- Hidden li included to remove active class from about link when scrolled up past about section -->

                        <li>
                            <a class="page-scroll" href="#about">About us</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#download">My Account</a>
                        </li>
                        <li>
                            <a class="last" href="<?php echo base_url();?>checkout/cartItems"> cart<?php echo isset($cartCount)? "(".$cartCount.")":"";?></a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <a class="page-scroll last" href="#contact"> <div class="follow-fetch">Follow Fetch!</div> </a>

            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-4">

                <div id="social">
                    <a class="facebookBtn smGlobalBtn" href="#" ></a>
                    <a class="twitterBtn smGlobalBtn" href="#" ></a>
                    <a class="rssBtn smGlobalBtn" href="#" ></a>
                    <a class="facebookBtn smGlobalBtn" href="#" ></a>
                </div>
            </div>
        </div>
    </div>

    <!-- /.navbar-collapse -->

</footer>
<!-- jQuery -->

    <script type='text/javascript' src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>js/jquery.easing.min.js"></script>
    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>
    <!--script type='text/javascript' src="<?php //echo base_url(); ?>js/jquery.sexy-combo-min.js"></script-->
    <script type='text/javascript' src="<?php echo base_url(); ?>js/grayscale.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>js/jquery-1.3.2.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>js/jquery.sexy-combo.js"></script>
</body>
</html>