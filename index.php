<!DOCTYPE html>
<?php include 'php/config.inc.php';?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
        <title>Loooping</title>
        <base href="<?php FULLURL.'/' ?>" target="_blank">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800italic,800,700,700italic,600italic,400italic,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="css/initialize.css">
        <link rel="stylesheet" href="css/loooping.css">
        <script src="bower_components/webcomponentsjs/webcomponents.min.js"></script>
        <link rel="import" href="bower_components/sortable-table/sortable-table.html">
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 9]>
            <p style="{margin: 0.2em 0; background: #ccc; padding: 0.2em 0;}">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container ">
          <header class="wrapper menu clearfix">
            <span class="title"><img src="img/looopingBright.svg" style="width:2em;"></span>
            <div class="right">&nbsp;&nbsp;</div>
            <div class="right">&nbsp;&nbsp;</div>
            <div class="right">&nbsp;&nbsp;</div>
            <div class="right">&nbsp;&nbsp;</div>
          </header>  
        </div>
<!--                -->
                <!--nav>
                    <ul>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                    </ul>
                </nav-->
           

        <div class="main-container">
            <div class="main wrapper clearfix">

                <div>
                    <header>
                      <img src="img/looopingLarge.svg" style="margin:2em 0; width:15rem; max-width:90%;"><br>
                      <h2>Physikalische Simulationen</h2>
                    </header>
                    <section>
                        <img class="grid-4th" src='http://www.csmonitor.com/var/ezflow_site/storage/images/media/images/1122-mars-curiosity-rover/11076284-1-eng-US/1122-mars-curiosity-rover_full_600.jpg'>
                        <img class="grid-4th" src='http://www.samuelheller.ch/wp-content/uploads/2011/05/schwarm-baikalenten.jpg'>
                        <img class="grid-4th" src='http://blog.mercedes-benz-passion.com/wp-content/uploads/749436_1363515_4800_3207_09C1143_105-Kopie.jpg'>
                        <img class="grid-4th" src='http://images.derstandard.at/t/12/2011/03/15/1297908095051.jpg'>
                    </section>
                    <section>
                      <div class="test grid-15 gridM-24-last"></div><div class="test grid-9-last gridM-24-last"></div>
                    </section>
                    <section>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                      <div class="test grid-8th"></div>
                    </section>
                    <section>
                      <div class="test grid-6th"></div>
                      <div class="test grid-6th"></div>
                      <div class="test grid-6th"></div>
                      <div class="test grid-6th"></div>
                      <div class="test grid-6th"></div>
                      <div class="test grid-6th"></div>
                    </section>
                                      <section>
                      <div class="test grid-4th"></div>
                      <div class="test grid-4th"></div>
                      <div class="test grid-4th"></div>
                      <div class="test grid-4th"></div>
                    </section>
                                      <section>
                      <div class="test grid-3th"></div>
                      <div class="test grid-3th"></div>
                      <div class="test grid-3th"></div>
                    </section>
                                                        <section>
                      <div class="test grid-2th"></div>
                      <div class="test grid-2th"></div>
                    </section>
                    <!--section>
                        <h2>article section h2</h2>
                        <p>eu porta velit mollis nec. Curabitur posuere enim eget turpis feugiat tempor. Etiam ullamcorper lorem dapibus velit suscipit ultrices. Proin in est sed erat facilisis pharetra.</p>
                    </section-->
                    <!--footer>
                        <h3>article footer h3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </footer-->
                </div>

                <!--aside>
                    <h3>aside</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales urna non odio egestas tempor. Nunc vel vehicula ante. Etiam bibendum iaculis libero, eget molestie nisl pharetra in. In semper consequat est, eu porta velit mollis nec. Curabitur posuere enim eget turpis feugiat tempor. Etiam ullamcorper lorem dapibus velit suscipit ultrices.</p>
                </aside-->

            </div> <!-- #main -->
        </div> <!-- #main-container -->

<!--        <div class="footer-container">
            <footer class="wrapper">
                <h3>loooping.ch</h3>
            </footer>
        </div>-->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        <?php  $entries = scandir("js/helpers");
                foreach($entries as $index=>$file){
                  if(stripos($file, ".js")>0) { echo "<script src='js/helpers/$file'></script>";}
                }
              ?>
        <script>
          
        </script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
            
            //$(document).on("mousemove", function(e) {if(e.clientY < 100) {$(".header-container").show();} else {$(".header-container").hide();} })
        </script>
    </body>
</html>
