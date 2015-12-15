$(document).ready(function(){
	map = new google.maps.Map(document.getElementById('map'), {
		center: new google.maps.LatLng(defaultLat, defaultLong),
		zoom: 10,
		mapTypeId: 'roadmap',
		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
	});
	infoWindow = new google.maps.InfoWindow();
	initMarkers();
});
function initMarkers()
{
	searchUrl += '?ajax=1&all=1';
	downloadUrl(searchUrl, function(data) {
		var xml = parseXml(data);
		var markerNodes = xml.documentElement.getElementsByTagName('marker');
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markerNodes.length; i++)
		{
			var name = markerNodes[i].getAttribute('name');
			var address = markerNodes[i].getAttribute('address');
			var addressNoHtml = markerNodes[i].getAttribute('addressNoHtml');
			var other = markerNodes[i].getAttribute('other');
			var id_store = markerNodes[i].getAttribute('id_store');
			var has_store_picture = markerNodes[i].getAttribute('has_store_picture');
			var latlng = new google.maps.LatLng(
			parseFloat(markerNodes[i].getAttribute('lat')),
			parseFloat(markerNodes[i].getAttribute('lng')));
			createMarker(latlng, name, address, other, id_store, has_store_picture);
			bounds.extend(latlng);
		}
		map.fitBounds(bounds);
		var zoomOverride = map.getZoom();
        if(zoomOverride > 10)
        	zoomOverride = 10;
		map.setZoom(zoomOverride);
	});
}
function createMarker(latlng, name, address, other, id_store, has_store_picture)
{
	var html = '<b>'+name+'</b><br/>'+address+(has_store_picture === 1 ? '<br /><br /><img src="'+img_store_dir+parseInt(id_store)+'.jpg" alt="" />' : '')+other+'<br /><a href="http://maps.google.com/maps?saddr=&daddr='+latlng+'" target="_blank">'+translation_5+'<\/a>';
	var image = new google.maps.MarkerImage(tpl_uri+"images/pin.png");
	var marker = '';

	if (hasStoreIcon)
		marker = new google.maps.Marker({ map: map, icon: image, position: latlng });
	else
		marker = new google.maps.Marker({ map: map, position: latlng });
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	});
	markers.push(marker);
}

function downloadUrl(url, callback)
{
	var request = window.ActiveXObject ?
	new ActiveXObject('Microsoft.XMLHTTP') :
	new XMLHttpRequest();

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			request.onreadystatechange = doNothing;
			callback(request.responseText, request.status);
		}
	};

	request.open('GET', url, true);
	request.send(null);
}

function parseXml(str)
{
	if (window.ActiveXObject)
	{
		var doc = new ActiveXObject('Microsoft.XMLDOM');
		doc.loadXML(str);
		return doc;
	}
	else if (window.DOMParser)
		return (new DOMParser()).parseFromString(str, 'text/xml');
}
function doNothing()
{
}