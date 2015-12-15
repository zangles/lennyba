function check_email(email){
	emailRegExp = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.([a-z]){2,4})$/;	
	if(emailRegExp.test(email)){
		return true;
	}else{
		return false;
	}
}
function loadMap(elId) {
	alert(defaultLat +'@@'+defaultLong);
    var e = new google.maps.LatLng(defaultLat, defaultLong), t = {
        center:e,
        zoom:17,
        scrollwheel:!1,
        mapTypeId:google.maps.MapTypeId.ROADMAP,
        styles:[ {
            featureType:"landscape",
            stylers:[ {
                saturation:-100
            }, {
                lightness:25
            }, {
                visibility:"on"
            } ]
        }, {
            featureType:"poi",
            stylers:[ {
                saturation:-100
            }, {
                lightness:51
            } ]
        }, {
            featureType:"road.highway",
            stylers:[ {
                saturation:-50
            } ]
        }, {
            featureType:"road.arterial",
            stylers:[ {
                saturation:-20
            }, {
                lightness:30
            } ]
        }, {
            featureType:"road.local",
            stylers:[ {
                saturation:-100
            }, {
                lightness:40
            }, {
                visibility:"on"
            } ]
        }, {
            featureType:"transit",
            stylers:[ {
                saturation:-100
            }, {
                visibility:"simplified"
            } ]
        }, {
            featureType:"water",
            elementType:"labels",
            stylers:[ {
                visibility:"on"
            }, {
                lightness:-25
            }, {
                saturation:-100
            } ]
        }, {
            featureType:"water",
            elementType:"geometry",
            stylers:[ {
                hue:"#ffff00"
            }, {
                lightness:-25
            }, {
                saturation:-97
            } ]
        } ]
    }, 
    a = new google.maps.Map(document.getElementById(elId), t), i = megaboxsImageUrl+"pin2.png";
    new google.maps.Marker({
        position:e,
        map:a,
        icon:i,
        animation:google.maps.Animation.DROP,
        title: shop_name
    });
    var s = new google.maps.LatLng(defaultLat, defaultLong), n = new MapLabel({
        text: shop_name,
        position:s,
        map:a,
        fontSize:18,
        align:"center"
    });
    n.set("position", s), n.set("fontColor", "#868176"), n.set("fontSize", 12), n.set("strokeWeight", 0);
}
$(document).ready(function(){
	//loadMap('footer-top-small-map');
	flickerFeed();
	twitterFeed();
	
});
$(window).bind('load', function(){
	
	/*
	if($("#footer-top-small-map").length > 0){		
		megaboxMap = new google.maps.Map(document.getElementById('footer-top-small-map'), {
			center: new google.maps.LatLng(defaultLat, defaultLong),
			zoom: 10,
			mapTypeId: 'roadmap',
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
		});
		infoWindow = new google.maps.InfoWindow();
		megaboxInitMarkers();
	}
	*/
	if($("#footer-top-map").length > 0){		
		megaboxMap = new google.maps.Map(document.getElementById('footer-top-map'), {
			center: new google.maps.LatLng(defaultLat, defaultLong),
			zoom: 10,
			mapTypeId: 'roadmap',
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
		});
		infoWindow = new google.maps.InfoWindow();
		megaboxInitMarkers();
	}	
});
jQuery(function($){    
	$(document).on('click', '.submitQuickContact', function(){
		$("#alert-"+formId).removeClass('alert-danger').html("").hide();
    	var formId = $(this).data('id');
    	var id_contact= $("#id_contact-"+formId+" :selected").val();
    	var email = $("#email-"+formId).val();
    	var message = $("#message-"+formId).val();
    	
    	if(email =="" || message==""){
    		$("#alert-"+formId).remove('alert-success').addClass('alert-danger').html("you enter the required content, please!").show();
    		return false;
    	}else{
    		var data={'action':'saveContact', 'id_contact':id_contact, 'email':email, 'message':message, 'secure_key':secure_key};
	        $.ajax({
	    		type:'POST',
	    		url: megaboxsUrlAjax,
	    		data: data,
	    		dataType:'json',
	    		cache:false,
	    		async: true,
	    		beforeSend: function(){},
	    		complete: function(){},
	    		success: function(response){
	                if(response){
	                	if(response.status == '0'){
	                		$("#alert-"+formId).removeClass('alert-success').addClass('alert-danger').html(response.msg).show();
	                	}else{
	                		$("#message-"+formId).val("");
	                		$("#alert-"+formId).removeClass('alert-danger').addClass('alert-success').html(response.msg+'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>').show();
	                	}
	                }                											
	    		}		
	    	}); 
    	}
    		
    });
	
});

function twitterFeed(){	
	if($(".twitter-top-widget").length >0){
		$(".twitter-top-widget").each(function(index) {
			var twitter_username = null;
			if($(this).data('username')) twitter_username = $(this).data('username');
			var twitter_query = null;
			if($(this).data('query')) twitter_query = $(this).data('query');
			var twitter_count = 2;
			if(parseInt($(this).data('count')) >0) twitter_count = parseInt($(this).data('count'));
			var twitter_favorites = false;
			if($(this).data('favorites') == '1') twitter_favorites = true;
			var twitter_avatar_size = null;
			if($(this).data('avatar_size')) twitter_avatar_size = $(this).data('avatar_size');
			var twitter_intro_text = null;
			if($(this).data('intro_text')) twitter_intro_text = $(this).data('intro_text');
			var twitter_outro_text = null;
			if($(this).data('outro_text')) twitter_outro_text = $(this).data('outro_text');
			var twitter_page = 1;
			if($(this).data('page')) twitter_page = $(this).data('page');			
			$(this).tweet({
	            modpath: megaboxsJsUrl+"twitter/",
	            avatar_size: twitter_avatar_size,
	            count: twitter_count,
	            username: twitter_username,
	            query:twitter_query,
	            page:twitter_page,
	            intro_text:twitter_intro_text,
	            outro_text:twitter_outro_text,
	            favorites:twitter_favorites,
	            loading_text: loading_text,
	            join_text: "",
	            retweets: !1,
	            template: '<div class="tweet_top clearfix">{avatar}<span>@{user}</span></div>{text}{time}'
	       });
		});
		
	}
	
}
function flickerFeed(){
	if($("ul.flickr-widget").length >0){
		$("ul.flickr-widget").each(function(index) {
			var flicker_userids = '';
			if($(this).data('userids')) flicker_userids = $(this).data('userids');
			var flicker_limit = 6;
			if($(this).data('limit')) flicker_limit = $(this).data('limit');
			var flicker_feedapi = 'photos_public.gne';
			if($(this).data('feedapi')) flicker_feedapi = $(this).data('feedapi');
			var ids = false;
			if($(this).data('ids') == '1') ids = true;
			if(ids == false){
				$(this).jflickrfeed({
					feedapi: flicker_feedapi,
	                limit: flicker_limit,
	                qstrings: {
	                    id: flicker_userids
	                },
	                itemTemplate: '<li><a href="{{image}}" title="{{title}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
	            });	
			}else{
				$(this).jflickrfeed({
	                limit: 6,
	                qstrings: {
	                    ids: flicker_userids
	                },
	                itemTemplate: '<li><a href="{{image}}" title="{{title}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
	           });
			}
		});
	}
}


function megaboxInitMarkers()
{
	searchUrl += '?ajax=1&all=1';
	megaboxDownloadUrl(searchUrl, function(data) {
		var xml = megaboxParseXml(data);
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
			megaboxCreateMarker(latlng, name, address, other, id_store, has_store_picture);
			bounds.extend(latlng);
		}
		megaboxMap.fitBounds(bounds);
		var zoomOverride = megaboxMap.getZoom();
        if(zoomOverride > 10)
        	zoomOverride = 10;
		megaboxMap.setZoom(zoomOverride);
	});
}
function megaboxCreateMarker(latlng, name, address, other, id_store, has_store_picture)
{
	var html = '<b>'+name+'</b><br/>'+address+(has_store_picture === 1 ? '<br /><br /><img src="'+img_store_dir+parseInt(id_store)+'.jpg" alt="" />' : '')+other+'<br /><a href="http://maps.google.com/maps?saddr=&daddr='+latlng+'" target="_blank">'+translation_5+'<\/a>';
	var image = new google.maps.MarkerImage(megaboxsImageUrl+"pin.png");
	var marker = '';

	if (hasStoreIcon)
		marker = new google.maps.Marker({ map: megaboxMap, icon: image, position: latlng });
	else
		marker = new google.maps.Marker({ map: megaboxMap, position: latlng, text:"asdsadas", fontSize:18, align:"center" });
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		infoWindow.open(megaboxMap, marker);
	});
	markers.push(marker);
}

function megaboxDownloadUrl(url, callback)
{
	var request = window.ActiveXObject ?
	new ActiveXObject('Microsoft.XMLHTTP') :
	new XMLHttpRequest();

	request.onreadystatechange = function() {
		if (request.readyState === 4) {
			request.onreadystatechange = megaboxDoNothing;
			callback(request.responseText, request.status);
		}
	};

	request.open('GET', url, true);
	request.send(null);
}

function megaboxParseXml(str)
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
function megaboxDoNothing()
{
}