var testPoly;
	var autocomplete;
	var map; 
	var pickup;
	var dropoff;
	var pickup_feature;

	//construct test polygon
	var testCoords = [
	{lat: 44.070372, lng: -123.117517},
	{lat: 44.029245, lng: -123.116636},
	{lat: 44.029841, lng: -123.050326},
	{lat: 44.076671, lng: -123.042297},
	];

	var testPoly = new google.maps.Polygon({
		paths: testCoords,
		strokeColor: "#666796",
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: "#666796",
		fillOpacity: 0.35
	});

	//creates a platform for geoprocessing - map is not visible in final product
	function initialize() {
		var map = {
			center: new google.maps.LatLng(44.047833, -123.089757),
			zoom: 13,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("map"),map);

		testPoly.setMap(map); // kml will be loaded here

		autocomplete = new google.maps.places.Autocomplete(
      		/** @type {!HTMLInputElement} */(document.getElementById('pickup')),
      		{types: ['geocode']}
      	);

      	autocomplete = new google.maps.places.Autocomplete(
      		/** @type {HTML.InputElement}) */(document.getElementById('dropoff')),
			{types: ['geocode']}
		);

		var pickup = document.getElementById("pickup").value; // query string
		var dropoff = document.getElementById("dropoff").value; // query string

		if (pickup != ''){
			search_pickup(map, pickup);
		}
		if (dropoff != ''){
			search_dropoff(map, dropoff);
		}

	}

	//load geoprocessing platform on pageload
	google.maps.event.addDomListener(window, "load", initialize);

	//search functions to process query string - retrieves place objects from API
	function search_pickup(map, place_reference) {
		var eugene = new google.maps.LatLng(44.047833, -123.089757);

		var request = {
			location: eugene,
			radius: "4047",
			query: place_reference
		}

		var service = new google.maps.places.PlacesService(map);
		service.textSearch(request, callback_pickup);

	}

	function search_dropoff(map, place_reference) {
		var eugene = new google.maps.LatLng(44.047833, -123.089757);

		var request = {
			location: eugene,
			radius: "4047",
			query: place_reference
		}

		var service = new google.maps.places.PlacesService(map);
		service.textSearch(request, callback_dropoff);

	}


//**** Inspired by Google Developer's 8, April 2016, Address Form Example
	function geolocate() {
		console.log('geolocation working');
		if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(function(position) {
			    var geolocation = {
			        lat: position.coords.latitude,
			        lng: position.coords.longitude
			    };
			    var circle = new google.maps.Circle({
			        center: geolocation,
			        radius: 4047
		        });
		        autocomplete.setBounds(circle.getBounds());
		    });
		}
	}
//****

	//call back functions geocode place & check if it's in bounds via point in polygon operation
	function callback_pickup(resultLocations, status) {
		if (status == google.maps.places.PlacesServiceStatus.OK){
			if (resultLocations.length > 1) {
				document.alert("please choose a more specific location")
			} else {
				console.log(resultLocations[0]);
				var place = resultLocations[0];
				var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
				initialize();
				if (google.maps.geometry.poly.containsLocation(point, testPoly)) {
					console.log("locaiton in bounds") // turn text box green
					document.getElementById("pickup").style.backgroundColor = "#f0fbf0"
				} else {
					console.log("Error: Location out of Bounds") // turn text box red
					document.getElementById("pickup").style.backgroundColor = "#f4d2d2"
				}
			}
		}
	}

	function callback_dropoff(resultLocations, status) {
		if (status == google.maps.places.PlacesServiceStatus.OK){
			if (resultLocations.length > 1) {
				alert("please choose a more specific location")
			} else {
				console.log(resultLocations[0]);
				var place = resultLocations[0];
				var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
				initialize();
				if (google.maps.geometry.poly.containsLocation(point, testPoly)) {
					console.log("locaiton in bounds") // turn text box green
					document.getElementById("dropoff").style.backgroundColor = "#f0fbf0"
				} else {
					console.log("Error: Location out of Bounds") // turn text box red
					document.getElementById("dropoff").style.backgroundColor = "#f4d2d2"
				}
			}
		}
	}

// allow user to verify their location to be in bounds
$("#verify").click(function() {
	initialize();
});






