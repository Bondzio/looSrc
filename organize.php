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
        <base href="<?= FULLURL.'/' ?>">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800italic,800,700,700italic,600italic,400italic,300italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="css/initialize.css">
        <link rel="stylesheet" href="css/loooping.css">
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
        <div class="main-container">
            <div class="main wrapper clearfix">

                <div>
                    <header>
                      <h2>Organizer</h2>
                    </header>
                  
                  <table class="fileTable">
                    <!--tr><th>Datei</th><th>Ordner</th><th>Vorschau</th></tr-->

                  </table>

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
        
        <script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        <?php  $entries = scandir("js/helpers");
                foreach($entries as $index=>$file){
                  if(stripos($file, ".js")>0) { echo "<script src='js/helpers/$file'></script>";}
                }
              ?>
        <script>
          var looD = {};
          $.when($.getJSON("php/getAssets.php"), $.getJSON("cms/cms.json" ))
            .done(function(filesPhp, cmsJson) {
              looD.files = filesPhp[0];
              looD.cms = cmsJson[0];
              checkFiles();
            });
          
          function createFileTable() {
            _.templateSettings = {interpolate: /\{\{(.+?)\}\}/g}; // {{test}}
            var rowTemplate = _.template("<tr data-file='{{f.file}}' data-folder='{{f.folder}}'><td><input type='checkbox'></td><td>{{f.folder}}</td><td>{{f.file}}</td><td><iframe width=200 height=100 src='{{f.folder}}/{{f.file}}'></iframe></td><td>{{notInInfos}}</td><td class='tags'><select></select></td></tr>");
            var $fileTable = $(".fileTable").empty();
            for(var i in looD.files) {
              $fileTable.append(rowTemplate({f: looD.files[i], notInInfos: (_.contains(looD.notInInfos, looD.files[i].file)?"<button class='updateCms'>in Infos eintragen</button>":"ok")}))
            }
            $fileTable.off("click.updateCms").on("click.updateCms", ".updateCms", updateCms);
          }
          
          function updateCms(e) {
            var content = {
              file: $(this).closest("tr").data("file"),
              folder: $(this).closest("tr").data("folder")
            }
            $.post("php/saveSafeCentral.php", {code: localStorage.looopCode, path: "cms/cms.json", task: "JSONinsert", content: content}, responseAnalyzer);
          }
          
          $.subscribe("response.cms", checkFiles);
          
          function checkFiles() {
            looD.filelist = _.map(looD.files, function(obj){return obj.file;});
            looD.infolist = _.map(looD.cms, function(obj){return obj.file;});
            looD.merge = looD.files.map(function(f){return _.extend(f, _.findWhere(looD.cms, {file: f.file}) || {notininfos: true});});
            log(looD.merge);
            looD.notInInfos = _.difference(looD.filelist, looD.infolist);
            looD.notInFiles = _.difference(looD.infolist, looD.filelist);
            if(looD.notInInfos.length!==0) {log("not all Files are in sync");}
            createFileTable();
          }
          
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
