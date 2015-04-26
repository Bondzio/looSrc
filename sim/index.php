<?php include '../php/header.inc.php';?>
<title>Simulations</title>
<style>
  body {background-color: #eee;}
  .itemlist {padding:0;}
  .item {margin-bottom: 0.4em; background-color: #bbb;}
  .item:hover {background-color: #aaa;}
  .item__link {display: block; height:8em;}
  .item__img {width: 8em; margin-right: 1em;}
  .item__name {font-size: 1.5em;}
  </style>
<?php include '../php/postheader.inc.php';?>
<div class="header-container ">
  <header class="wrapper menu clearfix">
    <span class="title"><img src="../img/looopingBright.svg" style="width:2em;"></span>
  </header>  
</div>
    <div class="main-container">
      <div class="main wrapper clearfix">
        <h1>Simulations</h1>
        <ul class="itemlist">
        <?php
          $files = scandir("./");
          foreach($files as $index=>$file){
            if((stripos($file, ".html")>0 || stripos($file, ".php")>0) && stripos($file, "index") === false) {
              $name = substr($file, 0, stripos($file, "."));
              echo "<li class='item'><a class='item__link' href='$file'><img class='item__img' src='../img/$name.jpg'><span class='item__name'>" . $name . "</span></a></li>";
            }
            else {
              //echo "<li><a href='$file/index.php'>$file</a></li>";
            }
          }
        ?>
          <li class='item'><a class='item__link' href='../flug'><img class='item__img' src='../img/Flug.jpg'><span class='item__name'>Flight Sim (Google Earth)</span></a></li>
        </ul>
      </div>
    </div>
  </body>
</html>
