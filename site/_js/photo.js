jQuery(document).ready(function(){


//------------------------------------------------------------
//--> 
var photoFunctions = (function(){
	
	
	$(document).keydown(function (e) {
	  var keyCode = e.keyCode || e.which;

		switch (keyCode) {
			case 39:
			case 75:
			case 102:
			case 54:
				window.location = $("#next").attr("href");
			break;
			case 37:
			case 74:
			case 100:
			case 52:
				window.location = $("#previous").attr("href");
			break;
		}
	});
	
	if ($('#photo_single')[0]){
		var cache 			= [],
			next 			= $('#next').attr("title")+".jpg",
			previous		= $('#previous').attr("title")+".jpg",
			folder			= $('#collection').text().replace(/\ /g, "-")+"/1180/",
			url				= "http://spencermccormick.com/_photos/";

		function preLoadImages(url) {
			var cacheImage = document.createElement('img');
			cacheImage.src = url;
			cache.push(cacheImage);
		}
		setTimeout(function() {
			console.log('preloading images');
			preLoadImages(url+folder+previous);
			preLoadImages(url+folder+next);
		}, 2000);
	}
	
	if ($('#photo_collection')[0]){
		
		
		// build columuns for seamless viewing
		var co1 = new Array(),
			co2 = new Array(),
			co3 = new Array(),
			co4 = new Array();
		
		$('li.photo').each(function(index) {
			switch (index % 4){
				case 0:
					co1.push(this);
					break;
				case 1:
					co2.push(this);
					break;
				case 2:
					co3.push(this);
					break;
				case 3:
					co4.push(this);
					break;
			}
		});	
		$(co1).wrapAll("<div class='col' />");
		$(co2).wrapAll("<div class='col' />");
		$(co3).wrapAll("<div class='col' />");
		$(co4).wrapAll("<div class='col' />");	
	}
	
	$('#comments').slideToggle(0);
	$('#btn_comments').click(function(){
		$('#comments').slideToggle();
	});
	
}()); // end photoFunctions
   
});