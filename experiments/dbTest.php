<?php include '../php/header.inc.php';?>
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>

<?php include '../php/prefooterscripts.inc.php';?>
<script>
  $(document).ready( function() {
      $.post("../php/dbCentral.php", {code: localStorage.looopCode, table: "test", task: "INSERT", values: [{title: $.now(), content: "äöl[¨7$$ü'°+\"*ç%&/()=?§1234567kjh", number: 10}, {title: $.now()+10, content: "äöljuioi8989kjh", number: 10}]}, responseAnalyzer);
      //$.post("../php/dbCentral.php", {code: localStorage.looopCode, table: "test", task: "UPDATE", values: [{key: "number", value: "10", newValues: {content: "234567890+", number: 11}}]}, responseAnalyzer);
      //$.post("../php/dbCentral.php", {code: localStorage.looopCode, table: "test", task: "DELETE", values: [{key: "number", value: 10}]}, responseAnalyzer);
  });
</script>
<?php include '../php/footer.inc.php';?>
