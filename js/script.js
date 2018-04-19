$("#resizeImageWrapper").mousemove(function(e){
	
	var wrapper_width = $(this).width();
   var parentOffset = $(this).offset(); 
   //or $(this).offset(); if you really just want the current element's offset
   var relX = e.pageX - parentOffset.left -15;
   var relY = e.pageY - parentOffset.top;
  

   $("#imageResize").width(relX);
   //$("#spanMove").css({"display" : "none"});
   $(".moveIndicator").css({"left":relX+10});
});

$('#wrapper').scrollspy({ target: '#navbar-collapse' });

$('#leistungen .asLink').click(function(){
	$("#leistungen_foto").hide();
	$("#leistungen_texte").hide();
	$("#leistungen_consulting").hide();
	$("#leistungen_post").hide();
	$("#leistungen_video").hide();
	$("#anc_leistungen_foto_detail .container").hide();
	
	
	//$(".leistungen_item").css({"box-shadow":"none"});
	
	//$(this).parent().css({"box-shadow":" 2px 0px 2px -3px dodgerblue, -2px 0px 2px -3px dodgerblue"});
	$(".leistungen_title").attr("class","leistungen_title");
	$(this).find(".leistungen_title").attr("class","leistungen_title border_petrol");
	
	$($(this).data("target")).show('slide', {direction: 'up'}, 500);
	
	$('html, body').animate({
        scrollTop: ( $(this).offset().top -70 )
    }, 1000, "easeOutQuad" );
	resizeBackgroundPost();
	if($(this).data("target")=="#leistungen_post"){
		
		widthArr=[50,80,100,120,150,170,200,220,250,270,250,220,200,180,160,140,150,180,200];
		var x=0;
		setInterval(function() {
			$("#imageResize").width(widthArr[x]);
			x++;
		}, 80);
	}
	
});
function resizeBackgroundPost(){
	var imageOffset = $("#resizeImageWrapper").find(".layer_bottom").position().left;
	$("#imageResize").css("left",imageOffset+"px");
}
$('#leistungen_foto .asLink').click(function(){
	$("#anc_leistungen_foto_detail .container").hide();
	$("#leistungen_foto .leistungen_title").attr("class","leistungen_title");
	$(this).find(".leistungen_title").attr("class","leistungen_title border_petrol");
	$($(this).data("target")).show('slide', {direction: 'up'}, 500);
	$('html, body').animate({
        scrollTop: ( $($(this).data("target")).offset().top + parseInt($($(this).data("target")).outerHeight(true)) - parseInt($("#anc_leistungen_foto").outerHeight(true)) - 10 )
    }, 1000, "easeOutQuad" );
});
$('.page-scroll a').click(function(){
	$('html, body').animate({
        scrollTop: $($(this).data("target")).offset().top
    }, 1000, "easeOutQuad" );
});
$(window).resize(function(){
	resizeBackgroundPost();
})

function setSovido(wrapperid,data){
	var wrapper = $("#"+wrapperid);
		wrapper.show();
	var video = $("#"+data.code);
		video.show();
	var player = video.find('.video-js').first();
	var myPlayer = videojs(player.id);
	consloe.log(myPlayer)
}

function closeSovido(id){
	var player = document.getElementById(id);
		player.pause();
		player.parentNode.parentNode.style.display="none";
		
}

function setVideoSrc(id,src){
	
	var player = document.getElementById(id);
		player.parentNode.parentNode.style.display = "block";
		player.scrollIntoView(false);
		player.src = "inc/vid/" + src;
		var width = player.offsetWidth;
		$(".closeVideo").css("margin-left",(width-10))
		player.play();
		player.onended = function(){ 
			player.parentNode.parentNode.style.display = "none";
			$('html, body').animate({
		        scrollTop: $("#leistungen_video").offset().top-40
		    }, 500);
		};
		$('html, body').animate({
	        scrollTop: $(".videowrapper").offset().top-40
	    }, 500);
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
	document.getElementById("outputMailSuccess").innerHTML = "";
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
				document.getElementById("outputMailSuccess").className = "alert alert-success";
				document.getElementById("outputMailSuccess").innerHTML = "Vielen Dank für Ihre Anfrage. Die eMail wurde erfolgreich versandt."
	    	}else{
	    		button.value = "absenden";
				button.className = "inputSubmit";
				button.removeAttribute("disabled");
	    		var res=JSON.parse(response);
	    		document.getElementById("outputMailSuccess").style.display = "block";
	    		document.getElementById("outputMailSuccess").className = "alert alert-danger";
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

$("#video_aboutus").on("play", function(){
	$("#overlay").css("z-index",20);
	$("#overlay").animate({opacity: 1}, 'slow');
	
})
$("#video_aboutus").on("end", function(){
	$("#video_aboutus").get(0).load();
	$("#overlay").css("z-index","-2");
	$("#overlay").animate({opacity: 0}, 'slow');
})
$("#video_aboutus").on("pause", function(){
	$("#overlay").css("z-index","-2");
	$("#overlay").animate({opacity: 0}, 'slow');
})
$(document).click(function(event) { 
    if(!$(event.target).closest('#video_aboutus').length && !$(event.target).is('#video_aboutus')) {
    	$("#overlay").css("z-index","-2");
    	$("#video_aboutus").get(0).pause();
    	$("#overlay").animate({opacity: 0}, 'slow');
    }        
})
/*
// SLIDER
function cycleItems(id,currentIndex,items) {
	var item = $('#'+id+' .slide').eq(currentIndex);
	items.removeClass("slideShow");		
	item.addClass("slideShow");
	var bubbles = $('#'+id+' .bubbleBullet');
	bubbles.html("<span class='bullet_inactive'> &bull;</span>");	
	var bubbleActive = $('#bubble_'+id+"_"+currentIndex);
	bubbleActive.html("<span class='bullet_active'> &bull;</span>");
	
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
	}, 3000);
}
function autoSlide_addBubbles(id,bubbleCount){
	var bubbleWrapper = document.createElement("div");
		bubbleWrapper.id="bubbleWrapper_"+id;
		bubbleWrapper.className="bubbleWrapper";
		
	
	for(var x=0;x<bubbleCount;x++){
		var bubble=document.createElement("span");
		bubble.innerHTML = "&#9702;";
		bubble.id = "bubble_"+id+"_"+x;
		bubble.dataset.nr = x;
		bubble.className="bubbleBullet";
		bubbleWrapper.appendChild(bubble);
	}
	document.getElementById(id).appendChild(bubbleWrapper);
}*/