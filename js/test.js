/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function(){
//
//	// the minimum version of jQuery we want
//	var v = "1.3.2";
//
//	// check prior inclusion and version
//	if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
//		var done = false;
//		var script = document.createElement("script");
//		script.src = "http://ajax.googleapis.com/ajax/libs/jquery/" + v + "/jquery.min.js";
//		script.onload = script.onreadystatechange = function(){
//			if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
//				done = true;
//				initMyBookmarklet();
//			}
//		};
//		document.getElementsByTagName("head")[0].appendChild(script);
//	} else {
//		initMyBookmarklet();
//	}
	
//	function initMyBookmarklet() {
		(window.myBookmarklet = function() {
      $("body").append("<iframe draggable='true' style='position:absolute; width: 400px; height: 50%; top: 0px; z-index=2147483647' src='//loooping.ch/extensions/looX.php'>")
		})();
//	}
})();


function getSelText() {
	var SelText = '';
	if (window.getSelection) {
		SelText = window.getSelection();
	} else if (document.getSelection) {
		SelText = document.getSelection();
	} else if (document.selection) {
		SelText = document.selection.createRange().text;
	}
	return SelText;
}


