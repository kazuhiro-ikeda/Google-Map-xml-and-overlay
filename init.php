<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/maps/util.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<script type="text/javascript"> 
  var infowindow;
  var map;
 
  function initialize() {

    var myLatlng = new google.maps.LatLng(35.720808,139.855611);

    var myOptions = {
	    zoom: 10,
	    center: myLatlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    gbarOptions={
     // we're going with the defaults
    };

    	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		downloadUrl("http://owlsweb.xsrv.jp/wp-content/themes/v-m-e-network/maps/post_map.xml", function(data) {
		var markers = data.documentElement.getElementsByTagName("marker");

	    for (var i = 0; i < markers.length; i++) {
	        var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),
	                                    parseFloat(markers[i].getAttribute("lng")));
	        var marker = createMarker(markers[i].getAttribute("name"), latlng, 
				markers[i].getAttribute("iconcolor"), markers[i].getAttribute("icongraph"), 
				markers[i].getAttribute("poststr1"), markers[i].getAttribute("poststr2"), 
				markers[i].getAttribute("poststr3"), markers[i].getAttribute("telstr"), markers[i].getAttribute("corpstr"));
    		}
    	});
  	}
 
    function createMarker(name, latlng, iconcolor, icongraph, poststr1, poststr2, poststr3, telstr, corpstr) {

    var marker = new google.maps.Marker({
		position: latlng, 
		map: map, 
		draggable: false,
		title: name,
		icon: icongraph
	});

    // Add a Circle overlay to the map.
    var circle = new google.maps.Circle({
        map: map,
        radius: 16000, // 16 km
	    center: latlng,
	    fillColor: iconcolor,
	    fillOpacity: 0.2,
	    strokeColor: iconcolor,
	    strokeOpacity: 0,
	    strokeWeight: 1
    });

    var contentString =  '<p style="color:orange;">' + name + '</p>'+
        '<p style="margin-bottom:0;width:240px;">' + poststr1 + '<br>'+ poststr2 + '</br>' + poststr3 + '</p>'
        + '<p style="margin-bottom:0;">TEL：' + telstr + '</p>'
        + '<p style="text-align:right;"><a style="text-decoration:underline;color:orange;" href="' + corpstr + '">詳細→</a></p>'; 

    google.maps.event.addListener(marker, "click", function() {
		if (infowindow) infowindow.close();
		infowindow = new google.maps.InfoWindow({content: contentString});
		infowindow.open(map, marker);
    });
	    return marker;
    }
	window.onload = initialize;		
</script>