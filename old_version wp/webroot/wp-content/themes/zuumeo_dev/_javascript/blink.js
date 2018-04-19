var blink_intervall = 80;

function blink(obj) {
	jQuery(obj).fadeOut(blink_intervall, function(){
		jQuery(obj).fadeIn(blink_intervall, function(){
			jQuery(obj).fadeOut(blink_intervall, function(){
				jQuery(obj).fadeIn(blink_intervall, function(){
					jQuery(obj).fadeOut(blink_intervall, function(){
						jQuery(obj).fadeIn(blink_intervall, function(){
							jQuery(obj).fadeIn(blink_intervall, function(){
								jQuery(obj).fadeIn(blink_intervall, function(){
	
								});
							});
						});
					});
				});
			});
		});
	});
}
