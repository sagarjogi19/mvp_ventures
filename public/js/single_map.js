/* For Single Map */
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 8,
		center: new google.maps.LatLng(23.0225, 72.5714),
		mapTypeId: google.maps.MapTypeId.ROADMAP
});
var infowindow = new google.maps.InfoWindow();
var marker, i;
marker = new google.maps.Marker({
position: new google.maps.LatLng(lat,lng),
		icon: {url:mark_url, scaledSize: new google.maps.Size(50, 50)},
		map: map
});
google.maps.event.addListener(marker, 'click', (function(marker, i) {
return function() {
infowindow.setContent('Name: ' + car_name + ',<br> Location: ' + loc);
		infowindow.open(map, marker);
}
})(marker, i));
