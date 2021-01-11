/* For multiple Map */
 var locations = JSON.parse(locations_arry); 
   var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(23.0225, 72.5714),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
   var infowindow = new google.maps.InfoWindow();
   


    var marker, i;
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
        icon: {url:mark_url,scaledSize: new google.maps.Size(50, 50)},
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent('Name: '+locations[i]['name'] +',<br> Location: '+locations[i]['location']);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
