// nov 12, 2012
// spencersoft
jQuery(document).ready(function(){

(function(window,undefined){
	$('.gallery').carousel();
	$('#hello p').css('display','none');
	$('#hello p').delay(1200).fadeIn(800);
	
	// Establish Variables
	var History = window.History,
		State = History.getState();
		// Log Initial State
		History.log('initial:', State.data, State.title, State.url);
		// Bind to State Change
		History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
			// Log the State
			var State = History.getState(); // Note: We are using History.getState() instead of event.state
			History.log('statechange:', State.data, State.title, State.url);
		}); 	
	
	var canvas = document.getElementById('index-sketch');
	
	// if canvas exists, launch dynamic background
	if (canvas && canvas.getContext){
		var ctx 	= canvas.getContext("2d"),
			canvasH	= $("#story-index").height() + 200,
			mouse 	= [{age:599,x:0,y:0,color:'rgba(0,0,0'}],
			red 	= 25,
			green 	= 254,
			blue 	= 255,
			timer	= 0;
		
		// update on every mousemove	 
		$(document).mousemove(function(e) {
			if(e.pageY < canvas.height){	
				// update model
				timer += 1; // equals 1/10 second
				if(Math.ceil((timer / 200)) % 2 === 0){
					red -= 1;
				} else {
					red += 1;
				}
				if((timer / 250 % 4) <= 1){
					green -= 1;
				} else if((timer / 250 % 4) >= 3){
					green += 1;
				}			
				mouse.push({age:599,x:e.pageX,y:e.pageY,color:'rgba('+red+','+green+','+blue});
				
				// draw screen
				ctx.clearRect(0,0,canvas.width,canvas.height);
				for(var i = 0 ;i < mouse.length;i++){
					var age = mouse[i].age - 1;
					if(age > 10){
						if(age < 100){
							age = "0"+age; 
						} 
						mouse[i].age = age;
						ctx.beginPath();
						ctx.lineWidth = 2;
						ctx.lineCap = "butt";
						// combine color and age for rgba opacity
						ctx.strokeStyle=mouse[i].color + ',0.' + age + ')';
						ctx.moveTo(mouse[i].x+1,mouse[i].y-2);
						ctx.lineTo(mouse[i].x-4,mouse[i].y+14);
						ctx.stroke();
					} else {
						mouse.splice(i, 1);
					}
				}	
			}
		});
		
		(function(){
			//setInterval(update, 50);
			ctx.canvas.width  = window.innerWidth;
  			ctx.canvas.height = window.innerHeight ;
			canvasH	= ctx.canvas.height;
		}());
			
	} //end if(canvas)
	
	// stories object structure = [{id:"sample",top:100,bottom:400]
	var stories = []
	  ,	storyState = 'opened'
	  ,	$window = $(window)
	  ,	windowHeight = $window.height()
	  ,	scrollHeight = $(document).height()
	  , scrollTop = $window.scrollTop();
		
	$('.story').each(function(index) {
		var newStory = {};
		
		newStory.top = Math.ceil($(this).offset().top);
		newStory.bottom = Math.ceil($(this).innerHeight()) + newStory.top;
		newStory.id = $(this).attr('id');
		newStory.url = newStory.id.substr(6);
		newStory.title = $(this).find(".story-title").text();
		stories.push(newStory);
		console.log(stories[index].id);
	});
		
	$(window).scroll(function(){
		var	scrollTop = $(window).scrollTop();
		  
		for (var i = 0; i < stories.length; i++) {
			if(storyState !== stories[i].id && scrollTop > stories[i].top && scrollTop < stories[i].bottom - windowHeight ) {		
				$("#"+stories[i].id+" .fixed-bg").css('position', 'fixed');
				$("#"+storyState+" .fixed-bg").css('position', 'absolute');
				storyState = stories[i].id;
				History.replaceState(stories[i] , stories[i].title, "/"+stories[i].url);
				console.log("active story change to "+storyState);
				return;
			} else if (storyState === stories[i].id && scrollTop > stories[i].bottom - windowHeight ){
				$("#"+stories[i].id+" .fixed-bg").css('position', 'absolute');						
				$("#"+stories[i].id+" .fixed-bg img").attr('style', 'bottom:0px');						
				storyState = 'transition';
				console.log("active story change to "+storyState);
				return;
			}  else if (storyState === stories[i].id && scrollTop < stories[i].top ){
				$("#"+stories[i].id+" .fixed-bg").css('position', 'absolute');						
				$("#"+stories[i].id+" .fixed-bg img").attr('style', 'top:0px');							
				storyState = 'transition';
				console.log("active story change to "+storyState);
				return;
			}
		}	
		
	});
	

	
	

}(window));// end annoymous function

}); // end jquery