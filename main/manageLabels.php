<?php include '../php/header.inc.php';?>
<?php include '../php/postheader.inc.php';?>
   <loo-tree src="../cms/labels.json" type="manageTree"></loo-tree>
<?php include '../php/prefooterscripts.inc.php';?>
  <script>
    var undoManager = new UndoManager();
    $.subscribe("undo", undoManager.undo);

//    var labeltree = new Tree("../cms/labels.json", $(".labeltree"), "manageTree");

  </script>
<?php include '../php/footer.inc.php';?>
