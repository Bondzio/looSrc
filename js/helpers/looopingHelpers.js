console.log("helpers are loaded!");

//Enhance input[range] element
$(document).ready(function() {
  $("input[type=range]").each(updateRange);
})
$(document).on("change", "input[type=range]", updateRange);


function updateRange() {
  var patharray = $(this).data("for").split(".");
  var path = window;
  for(var i =0; i<patharray.length-1; i++) {
    path = path[patharray[i]];
  }
  $(this).parents("label").find("span").text($(this).val()*$(this).data("scale"));
  path[patharray[patharray.length-1]] = $(this).val() * $(this).data("scale");
  $(this).val()
}