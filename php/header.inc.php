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
        <link rel="stylesheet" href="../bower_components/jquery.tablesorter/css/theme.dropbox.css">
        <link rel="stylesheet" href="../bower_components/jquery.tablesorter/css/filter.formatter.css">
        <script src="../bower_components/webcomponentsjs/webcomponents.min.js"></script>
        <link rel="import" href="../elements/loo-tree.html">
        <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        <script type="text/javascript" src="../bower_components/jquery.tablesorter/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="../bower_components/jquery.tablesorter/js/jquery.tablesorter.widgets.min.js"></script>
