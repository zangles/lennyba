<div class="col-md-{$megaboxs_group_width} {$megaboxs_group_custom_class}">
	{if $megaboxs_group_display_title == '1'}<h4>{$megaboxs_group_name}</h4>{/if}
	<div id="footer-top-small-map"></div>
   <div class="quick-contact">
   		<div id="alert-{$megaboxs_group_id}" class="alert " style="display: none"></div>  
		<select id="id_contact-{$megaboxs_group_id}" class="selectbox" name="id_contact">
	        <option value="0">{l s='-- Choose --'}</option>
	        {foreach from=$contacts item=contact}
	            <option value="{$contact.id_contact|intval}" {if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact}selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
	        {/foreach}
	    </select> 		
		<div class="xs-margin half"></div>
		<div class="form-group">
			<input type="email" id="email-{$megaboxs_group_id}" class="is_required validate form-control input-lg" required placeholder="{l s='ENTER YOUR E-MAIL *' mod='megaboxs'}">
		</div>
		<div class="form-group clear-margin">
			<textarea id="message-{$megaboxs_group_id}" class="form-control input-lg min-height-sm clear-margin is_required validate" cols="30" rows="4" placeholder="{l s='ENTER YOUR MESSAGE *' mod='megaboxs'}"></textarea>
		</div>
		<div class="xs-margin half"></div>
		<div class="form-group"><input type="button" class="btn btn-custom-9 min-width-md submitQuickContact" data-id="{$megaboxs_group_id}" value="{l s='Send Message' mod='megaboxs'}"></div>
		<div class="xs-margin visible-md visible-lg"></div>
	</div>		
</div>
{literal}
<script language="JavaScript" type="text/javascript">
	
	$(function() {
	    "use strict";
	    
	}), function() {
	    "use strict";
	    function e() {
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
	        }, a = new google.maps.Map(document.getElementById("footer-top-small-map"), t), i = megaboxsImageUrl+"pin2.png";
	        new google.maps.Marker({
	            position:e,
	            map:a,
	            icon:i,
	            animation:google.maps.Animation.DROP,
	            title:"Granada"
	        });
	        var s = new google.maps.LatLng(defaultLat, defaultLong), n = new MapLabel({
	            text:"Granada",
	            position:s,
	            map:a,
	            fontSize:18,
	            align:"center"
	        });
	        n.set("position", s), n.set("fontColor", "#868176"), n.set("fontSize", 12), n.set("strokeWeight", 0);
	    }
	    document.getElementById("footer-top-small-map") && google.maps.event.addDomListener(window, "load", e);
	}();
</script>
{/literal}