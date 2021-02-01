function initMap() {

	// The location
	var loc = {lat: latitude, lng: longitude};

	// The map, centered at location | draggable: false, scrollwheel: false,
	var map = new google.maps.Map(document.getElementById('map'), {zoom: 4, center: loc, disableDoubleClickZoom: true, zoomControl: true, scaleControl: false, mapTypeControl: false, streetViewControl: false, fullscreenControl: false});

	// The marker, positioned at location
	var marker = new google.maps.Marker({position: loc, map: map, draggable: true});

	var geocoder;

	geocoder = new google.maps.Geocoder();

	codeLatLng(loc.lat, loc.lng);

	google.maps.event.addListener(marker, 'dragend', function(evt) {

		codeLatLng(evt.latLng.lat().toFixed(3), evt.latLng.lng().toFixed(3));

		map.setCenter(marker.position);
		marker.setMap(map);
	});

	google.maps.event.addListener(map, 'dblclick', function(evt) {

		codeLatLng(evt.latLng.lat().toFixed(3), evt.latLng.lng().toFixed(3));

		marker.setPosition(evt.latLng);

		map.setCenter(marker.position);
		marker.setMap(map);
	});

	map.addListener("click", function (evt) {


	});

	function codeLatLng(lat, lng) {

		var latlng = new google.maps.LatLng(lat, lng);

		var itemPolitical = "";
		var itemCountry = "";
		var itemCity = "";

		geocoder.geocode({latLng: latlng}, function(results, status) {

			if (status == google.maps.GeocoderStatus.OK) {

				if (results[1]) {

					var arrAddress = results;
					console.log(results);

					$.each(arrAddress, function(i, address_component) {

						if (address_component.types[0] == "locality") {

							console.log("City: " + address_component.address_components[0].long_name);
							itemCity = address_component.address_components[0].long_name;
						}

						if (address_component.types[0] == "country") {

							console.log("Country: " + address_component.address_components[0].long_name);
							itemCountry = address_component.address_components[0].long_name;
						}

						if (address_component.types[1] == "political") {

							if (typeof address_component.address_components[1] !== 'undefined') {

								if (typeof address_component.address_components[1].long_name !== 'undefined') {

									console.log("Political: " + address_component.address_components[1].long_name);
									itemPolitical = address_component.address_components[1].long_name;

								} else {

									if (typeof address_component.address_components[1].short_name !== 'undefined') {

										console.log("Political: " + address_component.address_components[1].short_name);
										itemPolitical = address_component.address_components[1].short_name;
									}
								}
							}
						}

						setGeolocation(lat, lng, itemCountry, itemCity, itemPolitical);

					});

				} else {

					setGeolocation(lat, lng, itemCountry, itemCity, itemPolitical);
				}

			} else {

				setGeolocation(lat, lng, itemCountry, itemCity, itemPolitical);
			}
		});
	}

}

function setGeolocation(lat, lng, country, city, political) {

	var location = "";

	if (country.length == 0) {

		country = political;
	}

	if (country.length > 0) {

		location = country;
	}

	if (city.length > 0) {

		if (location.length > 0) {

			location = location + ", " + city;

		} else {

			location = location + city;
		}
	}

	$("input[name=lat]").val(lat);
	$("input[name=lng]").val(lng);
	$("input[name=country]").val(country);
	$("input[name=city]").val(city);

	if (location.length > 0) {

		$('i.ad-location').removeClass('icon-map-pin');
		$('i.ad-location').addClass('icon-check-circle');
		$('i.ad-location').addClass('text-green');

	} else {

		$('i.ad-location').removeClass('icon-check-circle');
		$('i.ad-location').removeClass('text-green');
		$('i.ad-location').addClass('icon-map-pin');

		location = strings.szLocationError;
	}

	$("p#location").text(location);
}