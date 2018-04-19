(function ($) {
    $.fn.downThePan = function (options) {
 
        // default settings
        var defaults = {
 
            // Use the current width of the container
            containerWidth: $(this).width(),
 
            // Use the current height of the container
            containerHeight: $(this).height(),
 
            // Pan up, down or both
            direction: 'both',
 
            // Allow easing (requires jQuery easing)
            easing: false
        };
 
        // Set options to be used as variables
        var options = $.extend({}, defaults, options);
 
        return this.each(function () {
 
            // Set the container as the element the plugin is applied to
            var container = $(this),
 
                // Find the image within the container
                img = $(this).find('img'),
 
                // Get the image width
                w = img.width(),
 
                // Get the image height
                h = img.height(),
 
                // Calculate the difference between the image and the container
                cx = (w - options.containerWidth) / options.containerWidth,
                cy = (h - options.containerHeight) / options.containerHeight;
 
            // Set the container CSS
            container.css({
                // Set the width
                width: options.containerWidth,
 
                // Set the height
                height: options.containerHeight,
 
                // So the image can be moved with position:absolute;
                position: 'relative',
 
                // Hide the overflowing part of the image
		'overflow': 'hidden'
            });
 
            // When the mouse moves over the container
            container.mousemove(function (e) {
 
                // mouse x coordinate relative to the container
                var x = e.pageX - container.offset().left;
 
                // mouse y coordinate relative to the container
                var y = e.pageY - container.offset().top;
 
                // If easing is turned off
                if (options.easing === false) {
 
                    // Set the position of the image based on mouse position
                    img.css({
 
                        // Calculate the negative left
                        left: -cx * x,
 
                        // Calculate the negative top
                        top: -cy * y,
 
                        // Allows control of left & top
                        position: 'absolute'
                    });
 
                }
 
            });
 
        });
 
    }
 
})(jQuery);