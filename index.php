<!DOCTYPE html>
  
<html>
    <head>
        <meta charset="utf-8" />
        <title>Google Maps Example</title>
        <style type="text/css">
            body { font: normal 14px Verdana; }
            h1 { font-size: 24px; }
            h2 { font-size: 18px; }
            #sidebar { float: right; width: 30%; }
            #main { padding-right: 15px; }
            .infoWindow { width: 220px; }
        </style>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvRq382OX0VKC3EmUOh-USqzoJYfsVBFs&callback=initMap"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
        <script type="text/javascript">

        function makeRequest(url, callback) {
        var request;
        if (window.XMLHttpRequest) {
        request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
        request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }
        request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            callback(request);
        }
        }
        request.open("GET", url, true);
        request.send();
        }

        var map;
        var center = new google.maps.LatLng(40.14556, 26.40639);
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();
        var citymap = {
        canakkale: {
          center: {lat: 40.14556, lng: 26.40639},
          //population: 2714856
        }
        };
        function init() {
              
            var mapOptions = {
                zoom: 13,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

              
            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
              
            /*var marker = new google.maps.Marker({
                map: map, 
                position: center,
            });*/
            makeRequest('getLocation.php', function(data) {
              
            var data = JSON.parse(data.responseText);
          
            for (var i = 0; i < data.length; i++) {
            displayLocation(data[i]);
            }
             });

            var Coordinates = [
          {lat: 40.100709, lng: 26.407732},
          {lat: 40.098586, lng: 26.414813},
          {lat: 40.130665, lng: 26.413472},
          {lat: 40.146911, lng: 26.404787}
        ];
        var flightPath = new google.maps.Polyline({
          path: Coordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);

         var path = [
         {lat: 40.100709, lng: 26.407732},
          {lat: 40.098586, lng: 26.414813},
          {lat: 40.130665, lng: 26.413472},
         ];
         
         var bermudaTriangle = new google.maps.Polygon({
         paths: path,
        strokeColor: '#8D38C9',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#9E7BFF',
        fillOpacity: 0.35
         });
        bermudaTriangle.setMap(map);
        }
        function displayLocation(location) {
          
        var content =   '<div class="infoWindow"><strong>'  + location.ad + '</strong>'
                    + '<br/>'     + location.adres+ '</div>';
      
        if (parseInt(location.lat) == 0) {
        geocoder.geocode( { 'adres': location.adres }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                  
                var marker = new google.maps.Marker({
                    map: map, 
                    position: results[0].geometry.location,
                    title: location.ad
                });
                  
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                });
            }
        });
        } else {
        var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lng));
        var marker = new google.maps.Marker({
            map: map, 
            position: position,
            title: location.name
        });
          
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        });
    }
}
    


        </script>
    </head>
    <body onload="init();">
          
        <center><h1 style="font-family:  'Quicksand', sans-serif;">Çanakkale Eczaneler</h1></center>
          
        <section id="sidebar">
            <div id="directions_panel"></div>
        </section>
          
        <section id="main">
            <div id="map_canvas" style="width: 2000px; height: 500px; border: 1px solid black;"></div>
        </section>

          
    </body>
</html>