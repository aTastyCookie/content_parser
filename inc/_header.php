<?php
//ini_set('display_errors', 1);
//error_reporting (E_ALL);
$demo = false;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Content Parser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- begin connection styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-switch.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
     <!-- end connection styles -->
     <!-- begin favicon -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/qr-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/qr-96.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/qr-72.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/fsm-48.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.ico">
     <!-- end favicon -->
    <!--[if IE 7]>
    	<link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
    <![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

     <!-- begin javascripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.waitforimages.js"></script>
    <script type="text/javascript" src="assets/js/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
     <!-- end javascripts -->
  </head>
  <body>
   <!-- begin top navigation -->
   <?php require_once('inc/_menu.php');?>
   <!-- end top navigation -->
        <div class="container" style="padding-bottom:45px; margin-top:60px;">
            <div class="row">
				<div class="col-md-12">
                <div class="btn-group btn-group-justified">
                	<a href="?images" class="btn btn-primary btn-lg<?php if(isset($_GET['images'])){ echo ' active';}?>"><i class="fa fa-picture-o fa-3x"></i><hr>IMAGES</a>
                	<a href="?links" class="btn btn-primary btn-lg<?php if(isset($_GET['links'])){ echo ' active';}?>"><i class="fa fa-link fa-3x"></i><hr>LINKS</a>
                	<a href="?css" class="btn btn-primary btn-lg<?php if(isset($_GET['css'])){ echo ' active';}?>"><i class="fa fa-file-code-o fa-3x"></i><hr>CSS</a>
                	<a href="?js" class="btn btn-primary btn-lg<?php if(isset($_GET['js'])){ echo ' active';}?>"><i class="fa fa-file-code-o fa-3x"></i><hr>JS</a>
                	<a href="?emails" class="btn btn-primary btn-lg<?php if(isset($_GET['emails'])){ echo ' active';}?>"><i class="fa fa-envelope-o fa-3x"></i><hr>E-mails</a>
                	<a href="?wp" class="btn btn-primary btn-lg<?php if(isset($_GET['wp'])){ echo ' active';}?>"><i class="fa fa-wordpress fa-3x"></i><hr>WordPress Posts</a>
                    <a href="?phpbb" class="btn btn-primary btn-lg<?php if(isset($_GET['phpbb'])){ echo ' active';}?>"><img src="assets/images/phpbb.png"  height="54"><hr>phpBB</a>
                    <a href="?smf" class="btn btn-primary btn-lg<?php if(isset($_GET['smf'])){ echo ' active';}?>" style="font-size:12px"><img src="assets/images/logo-smf.png"  height="62"><hr>Simple Machine<br>Forum</a>
                </div>
                <hr>
