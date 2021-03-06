<?php 
function pf_contactmap_func( $atts ) {
  extract( shortcode_atts( array(
    'setup5_mapsettings_height' => 550,
	'setup5_mapsettings_lat' => '37.77493',
	'setup5_mapsettings_lng' => '-122.41942',
	'setup5_mapsettings_zoom' => 12,
	'setup5_mapsettings_zoom_mobile' => 10,
	'setup5_mapsettings_type' => 'ROADMAP',
	'setup5_mapsettings_business'=> 0,
	'setup5_mapsettings_streetViewControl' => 0,
	'contact_title' => '',
	'contact_desc' => '',
	'pfcustompoint' => '',
	'colorp' => '',
  ), $atts ) );
  	ob_start();

  	parse_str(html_entity_decode($pfcustompoint),$pfcustompoints);
  	
  	$wpf_rndnum = rand(10,1000);
  	if($setup5_mapsettings_streetViewControl != 0){$setup5_mapsettings_streetViewControl = 'true';}else{$setup5_mapsettings_streetViewControl = 'false';};
	?>

    <div id="wpf-map-container<?php echo $wpf_rndnum;?>" class="wpf-map-container">
    	<div class="pfmaploading pfloadingimg">loding image...</div>

        <?php 
		$pfbopt1 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','1','0');
		$pfbopt2 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','2','0');
		
		if($pfbopt1 != 1){$pfbopt1_text = 'style="display:none"';}else{$pfbopt1_text = '';}
		if($pfbopt2 != 1){$pfbopt2_text = 'style="display:none"';}else{$pfbopt2_text = '';}
		?>
        <div id="pfcontrol" class="clearfix">
          <div class="pfcontrol-header">
          	<ul class="pfcontrolmenulist">
            	<li class="pfcontrol-plus" <?php echo $pfbopt1_text;?>><i class="pfadmicon-glyph-722"></i></li>
                <li class="pfcontrol-minus" <?php echo $pfbopt2_text;?>><i class="pfadmicon-glyph-723"></i></li>
            </ul>
          </div>
        </div>
        
		
    	<div id="wpf-map<?php echo $wpf_rndnum;?>" class="gmap3 wpf-map clearfix" style="height:<?php echo $setup5_mapsettings_height;?>px"></div>
    	
    </div>  
    <div class="pfsearchresults-container"></div>  
	<script type="text/javascript">
	(function($) {
		"use strict";


		// LOAD MAP STARTED --------------------------------------------------------------------------------------------
		<?php 
		// Main Function Started?>	
		$(function(){
			//Define static vars
			$.pfgmap3static = {};
			$.pfgmap3static.center = [<?php echo $setup5_mapsettings_lat;?>,<?php echo $setup5_mapsettings_lng;?>];
			$.pfgmap3static.zoom = <?php echo $setup5_mapsettings_zoom; ?>;
			$.pfgmap3static.zoom_mobile = <?php echo $setup5_mapsettings_zoom_mobile; ?>;
			
			if($.pf_mobile_check()){
				$.pfgmap3static.streetview = <?php echo $setup5_mapsettings_streetViewControl; ?>;
			}else{
				$.pfgmap3static.streetview = false;
			}

			$('#wpf-map<?php echo $wpf_rndnum;?>').gmap3({
			  defaults:{ 
	            classes:{
	              Marker:RichMarker
	            }
	          },
			  map:{
				  options:{
					center:[<?php echo $setup5_mapsettings_lat;?>,<?php echo $setup5_mapsettings_lng;?>],
					zoom: (!$.pf_mobile_check())? $.pfgmap3static.zoom_mobile:$.pfgmap3static.zoom, 
					mapTypeId: google.maps.MapTypeId.<?php echo $setup5_mapsettings_type; ?>,
					mapTypeControl: true,
					zoomControl: false,
					panControl: false,
					scaleControl: false,
					navigationControl: false,
					draggable:true,
					scrollwheel: false,
					streetViewControl: $.pfgmap3static.streetview,
					streetViewControlOptions: {
						position: google.maps.ControlPosition.LEFT_BOTTOM,
					},
					<?php
					//Map styles & Business Points
					echo 'styles: [';
					if($setup5_mapsettings_business == 0){
						echo "{featureType: 'poi',elementType: 'labels',stylers: [{ visibility: 'off' }]},";
					}
					echo ']';
					?>
				  },
				  events:{
					projection_changed: function(map){
						
						var pfmdefault = "<div class='pfcatdefault-mapicon pf-map-pin-1 pf-map-pin-1-middle pfcustom-mapicon-<?php echo $wpf_rndnum;?>' style='background-color:<?php echo $colorp;?>;opacity:1;' ><i class='pfadmicon-glyph-869' style='color:<?php echo $colorp;?>;margin:-7px 0px 0 -9px;' ></i></div><style>.pfcustom-mapicon-<?php echo $wpf_rndnum;?>:after{background-color:#ffffff}</style>";

						var wpflistdata2 = [<?php 
						for ($i=0; $i < $pfcustompoints['rownum'];) {
						 ?>{latLng:[<?php 
						 	echo $pfcustompoints['cmap_lat'][$i];
						 	?>,<?php 
						 	echo $pfcustompoints['cmap_lng'][$i];
						 	?>],data:{title:"<?php echo urlencode($pfcustompoints['cmap_title'][$i]);?>",desc:"<?php echo urlencode($pfcustompoints['cmap_desc'][$i]);?>"},options:{content:pfmdefault}}<?php 
						 	$i++;
						 	if ($i != $pfcustompoints['rownum']) { 
						 		echo ',';
						 	};
						 	
						 }?>];

						$('#wpf-map<?php echo $wpf_rndnum;?>').gmap3({
							marker: {
								values: wpflistdata2, 
								events:{
									click: function(marker, event, context){

										$.pfloadinfowindowcmap(marker, event, context.data.title,context.data.desc);
									},
								}
							}
						  
						});

				   }
				  },
				  callback:function(map){
				  	$.pfgmap3static.pfmapobj = $(this).gmap3('get');
				  }
			  }
			});
			<?php // Map Function Finished?>
		});
		<?php // Main Function Finished?>
		// LOAD MAP FINISHED --------------------------------------------------------------------------------------------


		$.pfloadinfowindowcmap = function(marker,event,datatitle,datadesc){
	        var map = $.pfgmap3static.pfmapobj;
	        var pos = marker.getPosition();
	        if($.pf_mobile_check()){
				var off_x = -175;
				var off_y = -168;
			}else{
				var off_x = -85;
				var off_y = -168;
			}


			function urldecode(str) {
			  return decodeURIComponent((str + '')
			    .replace(/%(?![\da-f]{2})/gi, function() {
			      return '%25';
			    })
			    .replace(/\+/g, '%20'));
			}

			$.pfmap_recenter(map,marker.getPosition(),0,0);

	        $('#wpf-map<?php echo $wpf_rndnum;?>').gmap3(
	            {overlay:{
					id:'contactoverlay',
	                latLng: pos,
	                options:{
	                    content: "<div class='wpfinfowindow2'><span class='wpftitle'><a>"+urldecode(datatitle)+"</a></span><span class='wpfaddress'>"+urldecode(datadesc)+"</span><div class='wpf-closeicon'><i class='pfadmicon-glyph-65'></i></div></div><div class='wpfarrow2'></div><script>jQuery(\'.wpf-closeicon\').click(function(){jQuery(\'#wpf-map<?php echo $wpf_rndnum;?>\').gmap3({clear:{id: \'contactoverlay\'}});})",
						offset: {x:off_x,y:off_y}
	                }
	            }
	            
	        });
    	};
	})(jQuery);
	</script>
<?php
$output_value = ob_get_contents();
ob_end_clean();
return $output_value;
}
add_shortcode( 'pf_contact_map', 'pf_contactmap_func' ); 

?>
