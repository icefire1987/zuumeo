jQuery(function($) {

	$('#sortable-table tbody').sortable({
		axis: 'y',
		handle: '.drag',
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		update: function(event, ui) {
			var theOrder = $(this).sortable('toArray');
			
			//alert(theOrder);
			
			var data = {
				action: 'sneek_update_post_order',
				postType: $(this).attr('data-post-type'),
				order: theOrder
			};

			$.post(ajaxurl, data);
		}
	}).disableSelection();

});

//jQuery(document).ready( function() {
//	if(jQuery("#tr_lang_de")) {
//		jQuery("#tr_lang_de").attr('readonly', true);
//	}
//	
//	if(jQuery("#tr_lang_en")) {
//		jQuery("#tr_lang_en").attr('readonly', true);
//	}
//	
//	if(jQuery("#tr_lang_ru")) {
//		jQuery("#tr_lang_ru").attr('readonly', true);
//	}
//});
//
//
//(function(){
//    // creates the plugin
//    tinymce.create('tinymce.plugins.mygallery', {
//        alert(1);
//        // creates control instances based on the control's id.
//        // our button's id is &quot;mygallery_button&quot;
//        createControl : function(id, controlManager) {
//            if (id == 'mygallery_button') {
//                // creates the button
//                var button = controlManager.createButton('mygallery_button', {
//                    title : 'MyGallery Shortcode', // title of the button
//                    image : '../wp-includes/images/smilies/icon_mrgreen.gif',  // path to the button's image
//                    onclick : function() {
//                        // do something when the button is clicked <img src="http://www.garyc40.com/wordpress/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> 
//                    }
//                });
//                return button;
//            }
//            return null;
//        }
//    });
// 
//    // registers the plugin. DON'T MISS THIS STEP!!!
//    tinymce.PluginManager.add('mygallery', tinymce.plugins.mygallery);
//})();