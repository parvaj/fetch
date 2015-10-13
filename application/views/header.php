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
    <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-12">

                </div>

            </div>

            <div class="row">
                <div class="col-sm-6">
                    <button type="button"  class="navbar-toggle" data-toggle="collapse" data-target=".collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="header-logo">
                       <a style="border-right: 0px;" href="<?php echo base_url();?>"> <img src="<?php echo base_url();?>img/fetchlogo.gif" width="100" height="36"></a>
                    </div>

                </div>
                <div class="col-sm-6">


                </div>
            </div>

			<div class="row">

                <div class="col-sm-7" >

                <div class="navbar-header">
                    <?php echo $this->session->flashdata('message'); ?>

                    <ul class="nav navbar-nav fetch-menu">
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/3">
                                DOG
                            </a>  
                        </li>
						<li>
                            <a class="page-scroll" href="<?php echo base_url();?>product/products/2">
                                CAT
                            </a>
                        </li>
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/1">
                                BIRD
                            </a>
                        </li>
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/4">
                                FISH
                            </a>

                        </li>
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/8">
                                SMALL ANIMAL
                            </a>
                        </li>

                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/7">
                                REPTILE
                            </a>
                        </li>
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/9">
                                WILD BIRD
                            </a>
                        </li>
                        <li>
                            <a class=" page-scroll" href="<?php echo base_url();?>product/products/5">
                                OTHER
                            </a>
                        </li>
                        <li>
                            <a class="page-scroll last" href="<?php echo base_url();?>product/products/11">
                                SALE
                            </a>
                        </li>
                    </ul>
				</div>
				<div class="row">
					<div class="col-sm-12" >
                        <div class="sub-menu">
                            <?php
                        /*    if(is_array($classes)){
                               echo "right";
                            }else{
                                "not right";
                            }
                        */
                            //echo $urlSegment['deptSection'];
                            //echo count($classes);
                           //echo "<pre>";
                           //print_r($classes);
                            //echo end($classes);
                            $segments = $this->uri->segment(3);
                            //echo   $segments= $this->uri->segment(2);
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
                                        echo "<a class='$linkClass' href='" . base_url() . "product/products/" . $urlSegment['deptSection'] . "/" . $class['class_id'] . "'>" . $class['class_name'] . "</a> ";
                                        $i++;
                                    }
                                }
                            }
                            ?>
                        </div>

					</div>
				</div>
				
			</div>
               <?php //echo $this->session->userdata('username'); ?>
                <?php //echo $segment.'tytr'; ?>
                <?php //echo $this->session->userdata('customerId'); ?>

                <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="col-sm-5">
                        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                            <div class="navbar-header">

								<ul class="nav navbar-nav right-nav">
									 <!--li><a class="last" href="<?php //echo base_url();?>checkout/cartItems"> cart<?php //echo isset($cartCount)? "(".$cartCount.")":"";?></a></li-->
									<li>
                                     <?php if ($this->session->userdata('logged_in') == TRUE) { ?> Hello,<br>
                                            <?php echo $this->session->userdata('firstName'); ?>
                                   <?php  }else {
                                     ?>
										<button name="singupButton" class="orange-button">SIGNUP</button>

                                     <?php } ?>
									</li>
									<li>
                                        <?php if ($this->session->userdata('logged_in') == TRUE) { ?>
                                            <button name="logoutButton" class="orange-button" onclick="location.href='<?php echo base_url();?>login/logout'">LOGOUT</button>
                                        <?php } else {  ?>
                                            <button name="loginButton" class="orange-button" id="loginButton">LOGIN</button>
                                        <?php } ?>
									</li>
									<li>
										<input type="text" value=""><img src="<?php echo base_url();?>img/search_icon_white.png">
									</li>
								</ul>

                               
                            </div>
                        </div>

                       <div class="row fetch-login">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <?php echo form_open(base_url().'login/process_login');
                                //echo $this->session->userdata('username');
                               // echo "<pre>";
                               // print_r(test_method(''));
                                ?>
                                <?php //echo site_url('Welcome')?>
                                   <?php echo form_input($username,'','class="test" placeholder="EMAIL ADDRESS"'); ?>
                                <!--input type="password" name="password" value="" placeholder="PASSWORD"-->
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