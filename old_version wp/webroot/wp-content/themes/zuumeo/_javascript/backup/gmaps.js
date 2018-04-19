function map(args) {
	var coordinates = args['coordinates'].split("###");
	
	if(args['zoom_only'] && args['lat'] && args['lng']) {
		var lat = parseFloat(args['lat']);
		var lng = parseFloat(args['lng']);
		
	} else {
		var coordinates_data = coordinates[0].split(",");
		
		var lat = parseFloat(coordinates_data[0]);
		var lng = parseFloat(coordinates_data[1]);
	}
	
	if(lat && lng) {
		var myOptions = {
			zoom: args['zoom'],
 			center: new google.maps.LatLng(lat,lng),
 			panControl: false,
 			streetViewControl: false,
 			
 			mapTypeControl: true,
		 	mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.TOP_RIGHT
		 	},
		 	
		 	zoomControl: true,
		 	zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.RIGHT_TOP
		 	},
			
			MapTypeId: google.maps.MapTypeId.TERRAIN
		};
		
		var map = new google.maps.Map(document.getElementById(args['object']), myOptions);
		
		var bounds = new google.maps.LatLngBounds();
			
		var image = new google.maps.MarkerImage(args['icon'],
			new google.maps.Size(args['icon_w'], args['icon_h']),
			new google.maps.Point(0, 0),
			new google.maps.Point(args['icon_left'], args['icon_top'])
		);
			
		var i_marker = 1;  
		for (var i = 0; i < coordinates.length; i++) {
			var coordinates_data = coordinates[i].split(",");
			
			var lat = parseFloat(coordinates_data[0]);
			var lng = parseFloat(coordinates_data[1]);
			
			var myLatLng = new google.maps.LatLng(lat,lng);
			
			++i_marker;
			
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				/* shadow: shadow, */
				icon: image,
				/* shape: shape, */
				zIndex: i_marker
			});
			
			if(coordinates.length > 1) {
				bounds.extend(myLatLng);
			}
			
			++i_marker;
		}
		
		if(coordinates.length > 1 && !args['zoom_only']) {
			map.fitBounds(bounds);
			map.panToBounds(bounds);
		
		} else {
			//map.panBy(0, 0);
		}
	
	} else {
		jQuery("#map_fallback").show();
	}
}