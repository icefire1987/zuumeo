$("#resizeImageWrapper").mousemove(function(e){
   var parentOffset = $(this).offset(); 
   //or $(this).offset(); if you really just want the current element's offset
   var relX = e.pageX - parentOffset.left -45;
   var relY = e.pageY - parentOffset.top;
   $("#imageResize").width(relX);
   //$("#spanMove").css({"display" : "none"});
   $("#spanMove").css({"left":relX});
});



$('#wrapper').scrollspy({ target: '#bs-example-navbar-collapse-1' });

$('#leistungen .asLink').click(function(){
	$('#leistungen_more').show();
	$('#leistungen_more .row').hide();
	
	$($(this).data("target")).show('slide', {direction: 'up'}, 500);
	
	$('html, body').animate({
        scrollTop: ($("#leistungen_more").offset().top - $(window).height() + $("#leistungen_more").height() +100)
    }, 1000, "easeOutQuad" );

	$("#spanMove").effect( "bounce", {distance: 80, times:2}, 1800 );
});
$('.page-scroll a').click(function(){
	$('html, body').animate({
        scrollTop: $($(this).data("target")).offset().top
    }, 1000, "easeOutQuad" );
});

function setVideoSrc(id,src){
	var player = document.getElementById(id);
		player.parentNode.parentNode.style.display = "block";
		player.scrollIntoView(false);
		player.src = "inc/vid/" + src;
		player.play();
		player.onended = function(){ player.parentNode.parentNode.style.display = "none";};
}
function closeVideo(id){
	var player = document.getElementById(id);
		player.pause();
		player.parentNode.parentNode.style.display="none";
}
$('#closeLayer').click(function(){
	$('#layerContact').hide();
});
$('.showLayer').click(function(){
	$('#layerContact').show();
	$('#layerContact').css({top: ($(this).offset().top-40)});
});

$("#formContact").submit(function(e){
	var button=document.getElementById("submit");
	button.value = "wird gesendet";
	button.className = "inputSubmit disabled";
	button.disabled=true;
    var formObj = $(this);
    var formURL = formObj.attr("action");
    if(typeof FormData == "undefined"){
    	var formData = formObj.serialize();
    	var ct = "application/x-www-form-urlencoded";
    }else{
    	var formData = new FormData(this);
    	var ct = false;
    }
    $.ajax({		    	
        url: "inc/req/sendMail.php",
	    type: 'POST',
	    data: formData,
	    mimeType:"multipart/form-data",
	    contentType: ct,
        cache: false,
        processData:false,
	    success: function(response, textStatus, jqXHR){
	    	if(response==1){
	    		button.value = "absenden";
				button.className = "inputSubmit";
				button.removeAttribute("disabled");
				document.getElementById("outputMailSuccess").style.display = "block";
				document.getElementById("outputMailSuccess").className = "textSuccess";
				document.getElementById("outputMailSuccess").innerHTML = "Vielen Dank für Ihre Anfrage. Die eMail wurde erfolgreich versandt."
	    	}else{
	    		button.value = "absenden";
				button.className = "inputSubmit";
				button.removeAttribute("disabled");
	    		var res=JSON.parse(response);
	    		document.getElementById("outputMailSuccess").style.display = "block";
	    		document.getElementById("outputMailSuccess").className = "textError";
	    		document.getElementById("outputMailSuccess").innerHTML = res.err;
	    	}
	    },
     	error: function(jqXHR, textStatus, errorThrown){
	    	 alert("err - console for details");
	    	 console.log(JSON.stringify(jqXHR));

	    	 console.log("Details: " + textStatus + "\n Error:" + errorThrown + "\n Formdata:" + formData);
	    }         
    });
    e.preventDefault();
    return false;
}); 

// SLIDER
function cycleItems(id,currentIndex,items) {
	var item = $('#'+id+' .slide').eq(currentIndex);
	items.removeClass("slideShow");		
	item.addClass("slideShow");
}

function autoSlide(id){
	var items = $('#'+id+' .slide');
	var itemAmt = items.length;
	var currentIndex = 0;
	autoSlide_addBubbles(id,itemAmt);
	cycleItems(id,currentIndex,items);
	setInterval(function() {
		currentIndex += 1;
		if (currentIndex > itemAmt - 1) {
			currentIndex = 0;
		}
		cycleItems(id,currentIndex,items);
	}, 6000);
}
function autoSlide_addBubbles(id,bubbleCount){
	var bubbleWrapper = document.createElement("div");
		bubbleWrapper.id="bubbleWrapper_"+id;
		bubbleWrapper.className="bubbleWrapper";
		
	
	for(var x=0;x<bubbleCount;x++){
		var bubble=document.createElement("span");
		bubble.innerHTML = "&#931"+(x+2)+";";
		bubble.className="margindSide5";
		bubbleWrapper.appendChild(bubble);
	}
	document.getElementById(id).appendChild(bubbleWrapper);
}