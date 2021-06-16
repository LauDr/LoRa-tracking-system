<!DOCTYPE html>
<html>
	<head>
		<title>Javascript GPS</title>
		<script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
		<link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
		<style>
			#map {
				width: 100%;
				height: 400px;				
			}
			.slidecontainer {
				width: 100%; /* Width of the outside container */
			}
			.slider {
			  width: 100%; 
			  height: 25px; 
			}
		</style>
		<script>
		function loadMap(longitude, latitude)
		{		
			mapboxgl.accessToken = 'pk.eyJ1IjoibGF1ZHIiLCJhIjoiY2twbWU4enUxMmVmeTJwcmkxaTdwNHpvciJ9.CiOHa5JtM2m_88dkXGWhvQ';
			var map = new mapboxgl.Map({
			container: 'map',
			style: 'mapbox://styles/mapbox/streets-v11',
			center: [longitude, latitude],
			zoom: 16
			});	
		
			map.on('load', function () {
				// Load an image from an external URL.
				map.loadImage(
					'antenna.png',
					function (error, image) {
						if (error) throw error;
						 
						// Add the image to the map style.
						map.addImage('antenne', image);
						 
						// Add a data source containing one point feature.
						map.addSource('antenne', {
							'type': 'geojson',
							'data': {
								'type': 'FeatureCollection',
								'features': [{
								'type': 'Feature',
									'geometry': {
									'type': 'Point',
									'coordinates': [4.256995, 51.624043]
									}
								}]
							}
						});
						 
						// Add a layer to use the image to represent the data.
						map.addLayer({
						'id': 'antenne',
						'type': 'symbol',
						'source': 'antenne', // reference the data source
						'layout': {
						'icon-image': 'antenne', // reference the image
						'icon-size': 0.06
						}
						});
					}
				);
				
				map.loadImage(
					'rozeboom.png',
					function (error, image) {
						if (error) throw error;
						 
						// Add the image to the map style.
						map.addImage('rozeboom', image);
						 
						// Add a data source containing one point feature.
						map.addSource('rozeboom', {
							'type': 'geojson',
							'data': {
								'type': 'FeatureCollection',
								'features': [
								{
									'type': 'Feature',
									'geometry': {
										'type': 'Point',
										'coordinates': [4.323077, 51.582364]
									}
								}
								]
							}
						});
						 
						// Add a layer to use the image to represent the data.
						map.addLayer({
							'id': 'rozeboom',
							'type': 'symbol',
							'source': 'rozeboom', // reference the data source
							'layout': {
								'icon-image': 'rozeboom', // reference the image
								'icon-size': 0.05
							}
						});
					}
				);
				
				
				map.loadImage(
				'boot.png',
				function (error, image) {
					if (error) throw error;
						 
					// Add the image to the map style.
					map.addImage('boot', image);
					 
					// Add a data source containing one point feature.
					map.addSource('boot', {
						'type': 'geojson',
						'data': {
							'type': 'FeatureCollection',
							'features': [{
								'type': 'Feature',
								'geometry': {
									'type': 'Point',
									'coordinates': [longitude,latitude ]									
								}
							}]
						}
					});
					 
					// Add a layer to use the image to represent the data.
					map.addLayer({
						'id': 'boot',
						'type': 'symbol',
						'source': 'boot', // reference the data source
						'layout': {
							'icon-image': 'boot', // reference the image
							'icon-size': 0.1
						}
					});
				}
				);
			});

		}
		
		function showPoint(value) {
			const xmlhttp = new XMLHttpRequest();
			xmlhttp.onload = function() {
			  const myObj = JSON.parse(this.responseText);
			  timestamp = new Date(1000*myObj.timestamp);
			  console.log(timestamp);
			  document.getElementById("timestamp").innerHTML = timestamp;
			  console.log(parseFloat(myObj.latitude));
			  console.log(parseFloat(myObj.longitude));
			  loadMap(myObj.longitude,myObj.latitude);
			}
		xmlhttp.open("GET", "server.php?q="+(20-value));
		xmlhttp.send();
		}
		</script>
	</head>
	<body>	
		<div class="slidecontainer">
			<input type="range" min="1" max="20" value="20" class="slider" id="myRange" onchange="showPoint(this.value)">
		</div>
		<div id="timestamp"><b>Timestamp...</b></div>
		<div id = "map"><div>
		<script>
			showPoint(20);	
		</script>
	</body>

</html>