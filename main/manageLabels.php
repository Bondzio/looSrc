<?php include '../php/header.inc.php';?>
        <style>
          .tree ul {margin:0;}
          .tree i {display: none;}
          .tree span {background-color: #ddeeff;}
          .tree span:hover>i {display: inline-block;}
          .tree span {display: block;}
          .tree span:hover {background-color: #99aabb;}
          .tree .pasteBefore span {background-color: #fff; font-size:0.4em}
          .tree .pasteBefore.draghover {background-color: #99aabb;}
          .tree .pasteBefore input {display: none;}
          .tree .pasteBefore button {display: none;}
          .tree .pasteBefore.add {font-size: 2em;}
          .tree .pasteBefore.add input {display: inline-block;}
          .tree .pasteBefore.add button {display: inline-block;}
          
        </style>
      <div class="tree">
        <ul class="labeltree"></ul>
      </div>
        <script>
          var undoManager = new UndoManager();
          $.subscribe("undo", undoManager.undo);
          
          var labeltree = new Tree("../cms/labels.json", $(".labeltree"));

        </script>
    </body>
</html>
