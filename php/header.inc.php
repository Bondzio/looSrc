<!DOCTYPE html>
<?php header('content-type: text/html; charset=utf-8');?>
<?php include '../php/config.inc.php';?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <title>Loooping</title>
        <base href="<?php FULLURL.'/' ?>" target="_blank">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800italic,800,700,700italic,600italic,400italic,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/initialize.css">
        <link rel="stylesheet" href="../css/loooping.css">
        <link rel="stylesheet" href="../css/icons.css">
        <script src="../bower_components/webcomponentsjs/webcomponents.min.js"></script>
        <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        <?php  $entries = scandir("../js/helpers");
                foreach($entries as $index=>$file){
                  if(stripos($file, ".js")>0) { echo "<script src='../js/helpers/$file'></script>";}
                }
              ?>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <!--script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script-->
    </head>
    <body>
        <!--[if lt IE 9]>
            <p style="{margin: 0.2em 0; background: #ccc; padding: 0.2em 0;}">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
