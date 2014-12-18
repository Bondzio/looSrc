$(window).on("keydown", function(e) {
  if ((e.which == 90 || e.keyCode == 90) && e.ctrlKey) {$.publish("undo"); log("Ctrl+z");}
});