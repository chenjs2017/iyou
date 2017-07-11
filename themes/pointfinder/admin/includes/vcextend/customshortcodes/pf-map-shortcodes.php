<?php 
function pf_directorymap_func( $atts,$content="" ) {
  extract( shortcode_atts( array(
    'setup5_mapsettings_height' => 550,
	'setup5_mapsettings_lat' => '0',
	'setup5_mapsettings_lng' => '0',
	'setup5_mapsettings_zoom' => 12,
	'setup5_mapsettings_zoom_mobile' => 10,
	'setup8_pointsettings_limit' => '',
	'setup8_pointsettings_orderby' => '',
	'setup8_pointsettings_order' => '',
	'setup8_pointsettings_ajax' => 0,
	'setup8_pointsettings_ajax_drag' => 0,
	'setup8_pointsettings_ajax_zoom'=> 0,
	'setup5_mapsettings_autofit' => 0,
	'setup5_mapsettings_autofitsearch' => 0,
	'setup5_mapsettings_type' => 'ROADMAP',
	'setup5_mapsettings_business'=> 0,
	'setup5_mapsettings_streetviewcontrol' => 0,
	'setup5_mapsettings_style' => '',
	'mapsearch_status' => '',
	'mapnot_status' => '',
	'listingtype' => '',
	'itemtype' => '',
	'conditions' => '',
	'features' => '',
	'locationtype' => '',
	'backgroundmode' => 0,
	'horizontalmode' => 0,
	'content_bg' => '',
	'box_topmargin' => 100,
	'box_leftmargin' => 350,
	'ne' => '',
	'ne2' => '',
	'sw' => '',
	'sw2' => '',
	'neaddress' => ''
  ), $atts) );

	$arr = pf_get_location();
	$setup5_mapsettings_lat = $arr['lat'];
	$setup5_mapsettings_lng = $arr['lon'];

  		if ($horizontalmode != 0) {
  			$horizontalmode_style = ' pfsearch-draggable-full pf-container';
  			$horizontalmode_style2 = ' pf-row';
  			$horizontalmode_style3 = ' class="col-lg-12 col-md-12 col-sm-12"';
  			$hormode = 1;
  		}else{$horizontalmode_style = $horizontalmode_style2 = $horizontalmode_style3 = '';$hormode = 0;};

  		$dragiconstatus = PFSAIssetControl('dragiconstatus','','1');
  		if ($dragiconstatus == 1) {
  			$drag_icon = "pfadmicon-glyph-151";
  			$drag_status = "false";
  		}else{
  			$drag_icon = "pfadmicon-glyph-152";
  			$drag_status = "true";
  		}

  		ob_start();
  		echo do_shortcode($content);
  		$output_content = ob_get_contents();
  		ob_end_clean();

  		ob_start();

  		if (empty($setup8_pointsettings_limit)) {
  			$setup8_pointsettings_limit = -1;
  		}


  		$tooltipstatus = PFSAIssetControl('setup12_searchwindow_tooltips','','1');
		if($tooltipstatus == 1){
			$pftooltip0 = PFSAIssetControl('setup12_searchwindow_tooltips_text','si0','Drag this window');
			$pftooltip1 = PFSAIssetControl('setup12_searchwindow_tooltips_text','si1','Search window.');
			$pftooltip2 = PFSAIssetControl('setup12_searchwindow_tooltips_text','si2','Display map info.');
			$pftooltip3 = PFSAIssetControl('setup12_searchwindow_tooltips_text','si3','Display map options.');
		}else{
			$pftooltip0 = $pftooltip1 = $pftooltip2 = $pftooltip3 = $pftooltip4 = '';
		}
		

		for ($i=1; $i <= 3; $i++) { 
			switch ($i) {
				case 1:
					if(PFSAIssetControl('setup12_searchwindow_buttonconfig'.$i,'','1') == 0){
						$dragstatus = 'style="display:none"'; $searchstyle = 'style="margin-left:0;"';
					}else{
						$dragstatus = ''; $searchstyle = '';
					}
					break;

				case 2:
					if(PFSAIssetControl('setup12_searchwindow_buttonconfig'.$i,'','1') == 0){
						$mapinfostatus = 'style="display:none"';
					}else{
						$mapinfostatus = '';
					}
					break;
				case 3:
					if(PFSAIssetControl('setup12_searchwindow_buttonconfig'.$i,'','1') == 0){
						$mapoptionsstatus = 'style="display:none"';
					}else{
						$mapoptionsstatus = '';
					}
					break;
			}
		}

		

		$setup12_searchwindow_startpositions = PFSAIssetControl('setup12_searchwindow_startpositions','','1');

		if($setup12_searchwindow_startpositions == 1){
			$pfdraggablestyle = 'left:15px';
		}else{
			$pfdraggablestyle = 'right:15px';
		}
		if ($horizontalmode == 1) {
			$pfdraggablestyle = 'left:0!important;right:0!important';
			$box_leftmargin=0;
		}

		if($mapsearch_status == 1){
		?>
        <div class="pf-container psearchdraggable"><div class="pf-row"><div class="col-lg-12">

        <?php if ($backgroundmode != 0) {?>
		<div class="pf-ex-search-text" style="position:absolute;top:<?php echo $box_topmargin;?>px;left:<?php echo $box_leftmargin;?>px;z-index:1"><?php echo $output_content;?></div>
        <?php }?>
        <div id="pfsearch-draggable" class="pfsearch-draggable-window<?php echo $horizontalmode_style;?> ui-widget-content" style="<?php echo $pfdraggablestyle;?>">
          <?php if ($horizontalmode == 0) {?>
          <div class="pfsearch-header">
          	<ul class="pftogglemenulist clearfix">
            	<li class="pftoggle-move" title="<?php echo $pftooltip0?>" <?php echo $dragstatus?>><i class="pfadmicon-glyph-692"></i></li>
                <li class="pftoggle-search" data-pf-icon1="pfadmicon-glyph-640" data-pf-icon2="pfadmicon-glyph-639" data-pf-content="search" title="<?php echo $pftooltip1?>" <?php echo $searchstyle?>><i class="pfadmicon-glyph-640"></i></li>
                <li class="pftoggle-itemlist" data-pf-icon1="pfadmicon-glyph-482" data-pf-icon2="pfadmicon-glyph-96" data-pf-content="itemlist" title="<?php echo $pftooltip2?>" <?php echo $mapinfostatus?>><i class="pfadmicon-glyph-482"></i></li>
                <li class="pftoggle-mapopt" data-pf-icon1="pfadmicon-glyph-750" data-pf-icon2="pfadmicon-glyph-96" data-pf-content="mapopt" title="<?php echo $pftooltip3?>" <?php echo $mapoptionsstatus?>><i class="pfadmicon-glyph-750"></i></li>
            </ul>
          </div>
          <?php }?>
          <?php
          /**
          *Start: Search Form
          **/
          ?>
	          <form id="pointfinder-search-form">
	          <div class="pfsearch-content golden-forms pfdragcontent<?php echo $horizontalmode_style2;?>" style="max-height:<?php echo $setup5_mapsettings_height - 90;?>px">
	          <div class="pfsearchformerrors">
	          	<ul>
	            </ul>
	            <a class="button pfsearch-err-button"><?php echo esc_html__('CLOSE','pointfindert2d')?></a>
	          </div>
	          <?php 
				$setup1s_slides = PFSAIssetControl('setup1s_slides','','');
				
				if(is_array($setup1s_slides)){
					
					$PFListSF = new PF_SF_Val();
					foreach ($setup1s_slides as &$value) {
					
						$PFListSF->GetValue($value['title'],$value['url'],$value['select'],0,array(),$hormode);
						
					}

					/*Get Listing Type Item Slug*/
                    $fltf = pointfinder_find_requestedfields('pointfinderltypes');
                    $features_field = pointfinder_find_requestedfields('pointfinderfeatures');
                    $itemtypes_field = pointfinder_find_requestedfields('pointfinderitypes');
                    $conditions_field = pointfinder_find_requestedfields('pointfinderconditions');

                    $stp_syncs_it = PFSAIssetControl('stp_syncs_it','',1);
					$stp_syncs_co = PFSAIssetControl('stp_syncs_co','',1);
					$setup4_sbf_c1 = PFSAIssetControl('setup4_sbf_c1','',1);

					$second_request_process = false;
					$second_request_text = "{features:'',itemtypes:'',conditions:''}";
					$multiple_itemtypes = $multiple_features = $multiple_conditions =  '';

					if (!empty($features_field) || !empty($itemtypes_field) || !empty($conditions_field)) {
						$second_request_process = true;
						$second_request_text = '{';
						if (!empty($features_field) && $setup4_sbf_c1 == 0) {
							$second_request_text .= "features:'$features_field'";
							$multiple_features = PFSFIssetControl('setupsearchfields_'.$features_field.'_multiple','','0');
						}
						if (!empty($itemtypes_field) && $stp_syncs_it == 0) {
							$second_request_text .= ",itemtypes:'$itemtypes_field'";
							$multiple_itemtypes = PFSFIssetControl('setupsearchfields_'.$itemtypes_field.'_multiple','','0');
						}
						if (!empty($conditions_field) && $stp_syncs_co == 0) {
							$second_request_text .= ",conditions:'$conditions_field'";
							$multiple_conditions = PFSFIssetControl('setupsearchfields_'.$conditions_field.'_multiple','','0');
						}

						if (!empty($multiple_itemtypes)) {
							$second_request_text .= ",mit:'1'";
						}

						if (!empty($multiple_features)) {
							$second_request_text .= ",mfe:'1'";
						}

						if (!empty($multiple_conditions)) {
							$second_request_text .= ",mco:'1'";
						}


						$second_request_text .= '}';
					}


					echo $PFListSF->FieldOutput;
					echo '<div id="pfsearchsubvalues" '.$horizontalmode_style3.'></div>';
					if ($horizontalmode == 1) {
						echo '<div class="colhorsearch">';
					}
					echo '<a class="button pfsearch" id="pf-search-button">'.esc_html__('SEARCH MAP', 'pointfindert2d').'</a>';
					if ($horizontalmode == 1) {
						echo '</div>';
					}
					echo '<script type="text/javascript">
					(function($) {
						"use strict";
						$.pffieldsids = '.$second_request_text.'
						$.pfsliderdefaults = {};$.pfsliderdefaults.fields = Array();
						$(function(){
						'.$PFListSF->ScriptOutput;
						echo 'var pfsearchformerrors = $(".pfsearchformerrors");
							$("#pointfinder-search-form").validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{'.$PFListSF->VSORules.'},messages:{'.$PFListSF->VSOMessages.'},
								  ignore: ".select2-input, .select2-focusser, .pfignorevalidation",
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100)
										$(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100)
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300)
									}
								  }
							});';

							if ($horizontalmode == 1 && PFASSIssetControl('as_hormode_close','','0') == 1) {
								echo '
									$( ".pfsearch-draggable-full" ).toggle( "slide",{direction:"up",mode:"hide"},function(){
										$(".pfsopenclose").fadeToggle("fast");
										$(".pfsopenclose2").fadeToggle("fast");
									});
								';
							}
							
							if ($backgroundmode != 0) {
                        		echo 'if($.pf_mobile_check()){';
                        			echo '$("#wpf-map-container").css("min-height","'.$setup5_mapsettings_height.'px");';
	                        		echo '$("#wpf-map").css("z-index",-1).css("margin-top",-1).css("position","absolute").css("height","'.($setup5_mapsettings_height+1).'px").hide();';
	                        		echo '$("#pfcontrol").hide();';
	                        		echo '$("#pfcontrol").css("z-index",-1);';
	                        		echo '$(".pfnotificationwindow").css("z-index",-1);';
	                        		echo '$(".pf-err-button").css("z-index",-1);';
	                        		echo '$(".pfnotificationwindow").hide();';
	                        		echo 'setTimeout(function(){$(".pfnotificationwindow").hide();$(".pf-err-button").hide();},100);';
	                        		echo 'setTimeout(function(){$(".pfnotificationwindow").hide();$(".pf-err-button").hide();},2000);';
	                        		echo 'setTimeout(function(){$(".pfnotificationwindow").hide();$(".pf-err-button").hide();},4000);';
                        		echo '}else{
                        			$(".pf-ex-search-text").remove();/*text bg remove*/
                        			$("#wpf-map-container").closest(".pf-fullwidth").prev(".upb_video-wrapper").remove();/*Video bg remove*/
									$("#wpf-map-container").closest(".pf-fullwidth").prev(".upb_row_bg").remove();/*Image bg remove*/
                        		}';
                        	}

                        if ($fltf != 'none') {
                        	$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

							if ($as_mobile_dropdowns == 1) {
								echo '
								$(function(){
		                            $("#'.$fltf.'").change(function(e) {
		                            	
		                              $.PFGetSubItems($("#'.$fltf.'").val(),"",0,'.$hormode.');
		                              ';
		                              if ($second_request_process) {
		                              	echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
		                              }
		                              echo '
		                            });
		                            $(document).one("ready",function(){
		                                if ($("#'.$fltf.'" ).val() !== 0) {
		                                   $.PFGetSubItems($("#'.$fltf.'" ).val(),"",0,'.$hormode.');
		                                   ';
			                               if ($second_request_process) {
			                              	 echo '$.PFRenewFeatures($("#'.$fltf.'").val(),"'.$second_request_text.'");';
			                               }
			                               echo '
		                                };
		                                setTimeout(function(){
		                                	$(".select2-container" ).attr("title","");
		                                	$("#'.$fltf.'" ).attr("title","")
		                                },300);
		                            });
	                            });
	                            ';
							}else{
								echo '
	                            $("#'.$fltf.'" ).change(function(e) {
	                            
	                              $.PFGetSubItems($("#'.$fltf.'" ).val(),"",0,'.$hormode.');
	                              ';
	                              if ($second_request_process) {
	                              	echo '$.PFRenewFeatures($("#'.$fltf.'" ).val(),"'.$second_request_text.'");';
	                              }
	                              echo '
	                            });
	                            $(document).one("ready",function(){
	                            
	                                if ($("#'.$fltf.'" ).val() !== 0) {
	                                   $.PFGetSubItems($("#'.$fltf.'" ).val(),"",0,'.$hormode.');
	                                   ';
		                              if ($second_request_process) {
		                              	echo '$.PFRenewFeatures($("#'.$fltf.'" ).val(),"'.$second_request_text.'");';
		                              }
		                              echo '
	                                };
	                                setTimeout(function(){
	                                	$(".select2-container" ).attr("title","");
	                                	$("#'.$fltf.'" ).attr("title","")
	                                },300);
	                            });
	                            
	                            ';
							}
                            
                        }
                        echo '
						});'.$PFListSF->ScriptOutputDocReady;
					}
					echo '	
					
					})(jQuery);
					</script>';
				//}
					unset($PFListSF);
			  ?>
	          </div>
	          </form>
          <?php
          /**
          *End: Search Form
          **/
          ?>
          <div class="pfitemlist-content pfdragcontent" <?php echo $mapinfostatus?>>
          <?php 
          global $pointfindertheme_option;
		  $setup12_searchwindow_mapinfotext = ($pointfindertheme_option['setup12_searchwindow_mapinfotext'])?wp_kses_post($pointfindertheme_option['setup12_searchwindow_mapinfotext']):'';
		  echo $setup12_searchwindow_mapinfotext
		  ?>
          	
          </div>
          <div class="pfmapopt-content golden-forms pfdragcontent clearfix" <?php echo $mapoptionsstatus?>>
          	<div class="pfmaptype-control">
            	<div class="pfmaptype-control-ul">
                	<div class="pfmaptype-control-hybrid pfmaptype-control-li" data-mapopt-status="passive" data-mapopt-type="hybrid"><?php echo esc_html__('Hybrid','pointfindert2d')?></div>
                    <div class="pfmaptype-control-roadmap pfmaptype-control-li" data-mapopt-status="passive" data-mapopt-type="roadmap"><?php echo esc_html__('Roadmap','pointfindert2d')?></div>
                    <div class="pfmaptype-control-satellite pfmaptype-control-li" data-mapopt-status="passive" data-mapopt-type="satellite"><?php echo esc_html__('Satellite','pointfindert2d')?></div>
                    <div class="pfmaptype-control-terrain pfmaptype-control-li clearfix" data-mapopt-status="passive" data-mapopt-type="terrain"><?php echo esc_html__('Terrain','pointfindert2d')?></div>
                </div>
                
                <div class="pfmaptype-control-layers-ul">
                	<div class="pfmaptype-control-traffic pfmaptype-control-layers-li" data-mapopt-status="passive" data-mapopt-type="traffic"><?php echo esc_html__('Traffic','pointfindert2d')?></div>
                    <div class="pfmaptype-control-bicycle pfmaptype-control-layers-li clearfix" data-mapopt-status="passive" data-mapopt-type="bicycle"><?php echo esc_html__('Bicycle','pointfindert2d')?></div>
                </div>
            </div>
			
          </div>   
         <?php if ($horizontalmode == 1) {?>
         <a class="pfsopenclose hidden-xs"><i class="pfadmicon-glyph-737"></i></a>
		 <?php }?>               
        </div>
        </div></div></div>
       <?php if ($horizontalmode == 1) {?>
        <a class="pfsopenclose2 hidden-xs"><i class="pfadmicon-glyph-155"></i> <?php echo esc_html__('SEARCH','pointfindert2d');?></a>
        
		<?php }?>       
    <!--  / Search Container -->
	<?php }?>


	<div id="wpf-map-container">
    
    	<div class="pfmaploading pfloadingimg"></div>
        
        
        <?php 
		$pfbopt1 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','1','0');
		$pfbopt2 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','2','0');
		$pfbopt3 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','3','0');
		$pfbopt4 = PFSAIssetControl('setup13_mapcontrols_buttonconfig','4','0');
		
		if($pfbopt1 != 1){$pfbopt1_text = 'style="display:none"';}else{$pfbopt1_text = '';}
		if($pfbopt2 != 1){$pfbopt2_text = 'style="display:none"';}else{$pfbopt2_text = '';}
		if($pfbopt3 != 1){$pfbopt3_text = 'style="display:none"';}else{$pfbopt3_text = '';}
		if($pfbopt4 != 1){$pfbopt4_text = 'style="display:none"';}else{$pfbopt4_text = '';}

		$exclstext = '';
		if (PFSAIssetControl('setup13_mapcontrols_position','','1') == 0) {
			$exclstext = ' pfexclsright';
		} 
		
		?>
        <div id="pfcontrol" class="clearfix">
          <div class="pfcontrol-header golden-forms">
          	<ul class="pfcontrolmenulist">
          		<li class="pfcontrol-lock info-tip3<?php echo $exclstext;?>" <?php echo $pfbopt4_text;?> aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Drag Option','pointfindert2d');?></span><i class="<?php echo $drag_icon;?>"></i></li>
          		<li class="pfcontrol-home info-tip3<?php echo $exclstext;?>" <?php echo $pfbopt4_text;?> aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Home','pointfindert2d');?></span><i class="pfadmicon-glyph-645"></i></li>
          		<li class="pfcontrol-locate info-tip3<?php echo $exclstext;?>" <?php echo $pfbopt3_text;?> aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('My Location','pointfindert2d');?></span><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16px" height="16px"></li>
            	<li class="pfcontrol-plus info-tip3<?php echo $exclstext;?>" <?php echo $pfbopt1_text;?> aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Zoom In','pointfindert2d');?></span><i class="pfadmicon-glyph-722"></i></li>
                <li class="pfcontrol-minus info-tip3<?php echo $exclstext;?>" <?php echo $pfbopt2_text;?> aria-describedby="helptooltip"><span class="pftooltipx" role="tooltip"><?php echo esc_html__('Zoom Out','pointfindert2d');?></span><i class="pfadmicon-glyph-723"></i></li>
            </ul>
          </div>
        </div>
        

    	<?php echo '<div id="wpf-map" class="gmap3 clearfix jchen" style="height:'.$setup5_mapsettings_height.'px"></div>';?>
    	<?php if ($mapnot_status == 1) {?>
        <div class="pfnotificationwindow">
            <span class="pfnottext"></span>
            
        </div>
        <a class="pf-err-button pfnot-err-button" id="pfnot-err-button">
           	<i class="pfadmicon-glyph-96"></i>
        </a>
        <a class="pf-err-button pfnot-err-button pfnot-err-button-menu" id="pfnot-err-button-menu">
        	<i class="pfadmicon-glyph-725"></i>
        </a>
        <?php }?>
    </div>  
    <div class="pfsearchresults-container"></div>  
    <?php	
	/*Map Settings*/
	if($setup5_mapsettings_streetviewcontrol == 1){$setup5_mapsettings_streetviewcontrol = 'true';}else{$setup5_mapsettings_streetviewcontrol = 'false';};
	$setup5_mapsettings_notfound = PFSAIssetControl('setup5_mapsettings_notfound','','Not Found');
	
	/*Cluster Feature*/
	$setup6_clustersettings_status = PFSAIssetControl('setup6_clustersettings_status','','1');
	$setup6_clustersettings_minsize = PFSAIssetControl('setup6_clustersettings_minsize','','10');
	$setup6_clustersettings_size2 = PFSAIssetControl('setup6_clustersettings_size2','','20');
	$setup6_clustersettings_size3 = PFSAIssetControl('setup6_clustersettings_size3','','50');
	$setup6_clustersettings_size4 = PFSAIssetControl('setup6_clustersettings_size4','','75');
	$setup6_clustersettings_size5 = PFSAIssetControl('setup6_clustersettings_size5','','100');
	
	/*Geolocation Feature*/
	$setup7_geolocation_status = PFSAIssetControl('setup7_geolocation_status','','0');
	$setup7_geolocation_move = PFSAIssetControl('setup7_geolocation_move','','0');
	$setup7_geolocation_distance = PFSAIssetControl('setup7_geolocation_distance','','10');
	$setup7_geolocation_distance_unit = PFSAIssetControl('setup7_geolocation_distance_unit','','km');
	//1E3Change to this : 6.21371E-4 for miles or Change to this: 3.28084 for ft
	if($setup7_geolocation_distance_unit == 'km'){$setup7_geolocation_distance_output = $setup7_geolocation_distance*1000;}
	if($setup7_geolocation_distance_unit == 'm'){$setup7_geolocation_distance_output = (($setup7_geolocation_distance*1000)*1.609344);}
	$setup7_geolocation_fillcolor = PFSAIssetControl('setup7_geolocation_fillcolor','','#008BB2');
	$setup7_geolocation_strokecolor = PFSAIssetControl('setup7_geolocation_strokecolor','','#005BB7');
	$setup7_geolocation_fillopacity = PFSAIssetControl('setup7_geolocation_fillopacity','','0.3');
	$setup7_geolocation_strokeopacity = PFSAIssetControl('setup7_geolocation_strokeopacity','','0.6');
	if($setup7_geolocation_fillcolor == 'transparent'){$setup7_geolocation_fillcolor = '#008BB2';};
	if($setup7_geolocation_strokecolor == 'transparent'){$setup7_geolocation_strokecolor = '#005BB7';};
	$setup7_geolocation_hideinfo = PFSAIssetControl('setup7_geolocation_hideinfo','','0');
	if($setup7_geolocation_hideinfo == 1){ $setup7_geolocation_hideinfo_val = 'false';}else{ $setup7_geolocation_hideinfo_val = 'true';}
	$setup7_geolocation_point_icon = PFSAIssetControl('setup7_geolocation_point_icon','url',get_template_directory_uri() . '/images/geo.png');
	$setup7_geolocation_resize_icon = PFSAIssetControl('setup7_geolocation_resize_icon','url',get_template_directory_uri() . '/images/geo2.png');
	$setup7_geolocation_autofit = PFSAIssetControl('setup7_geolocation_autofit','','0');
	
	/*Point settings*/
	$setup10_infowindow_height = PFSAIssetControl('setup10_infowindow_height','','136');
	$setup10_infowindow_width = PFSAIssetControl('setup10_infowindow_width','','350');
	
	if($setup10_infowindow_height != 136){ $heightbetweenitems = $setup10_infowindow_height - 136;}else{$heightbetweenitems = 0;}
	if($setup10_infowindow_width != 350){ 
		$widthbetweenitems = (($setup10_infowindow_width - 350)/2);
	}else{
		$widthbetweenitems = 0;
	}

	$s10_iw_w_m = PFSAIssetControl('s10_iw_w_m','','184');
	$s10_iw_h_m = PFSAIssetControl('s10_iw_h_m','','136');
	if($s10_iw_h_m != 136){ $heightbetweenitems2 = $s10_iw_h_m - 136;}else{$heightbetweenitems2 = 0;}
	if($s10_iw_w_m != 184){ $widthbetweenitems2 = (($s10_iw_w_m - 184)/2);}else{$widthbetweenitems2 = -6;}
	
	/*Map Notifications*/
	$setup15_mapnotifications_dontshow_i = PFSAIssetControl('setup15_mapnotifications_dontshow_i','','1');
	$setup15_mapnotifications_autoplay_e = PFSAIssetControl('setup15_mapnotifications_autoplay_e','','1');
	if($setup15_mapnotifications_autoplay_e == 1){
	$setup15_mapnotifications_autoclosetime_e = PFSAIssetControl('setup15_mapnotifications_autoclosetime_e','','5000');
	}else{$setup15_mapnotifications_autoclosetime_e = '120000';}
	$setup15_mapnotifications_autoplay_i = PFSAIssetControl('setup15_mapnotifications_autoplay_i','','0');
	if($setup15_mapnotifications_autoplay_i == 1){
	$setup15_mapnotifications_autoclosetime_i = PFSAIssetControl('setup15_mapnotifications_autoclosetime_i','','5000');
	}else{$setup15_mapnotifications_autoclosetime_i = '120000';}
	$setup15_mapnotifications_foundtext = PFSAIssetControl('setup15_mapnotifications_foundtext','','Items found.');
	$setup8_pointsettings_pointopacity = PFSAIssetControl('setup8_pointsettings_pointopacity','','0.7');

	/*Multiple Point Settings */
	$setup14_multiplepointsettings_slidespeed = PFSAIssetControl('setup14_multiplepointsettings_slidespeed','','400');
	$setup14_multiplepointsettings_navigation = PFSAIssetControl('setup14_multiplepointsettings_navigation','','1');
	$setup14_multiplepointsettings_autoplay = PFSAIssetControl('setup14_multiplepointsettings_autoplay','','1');
	if($setup14_multiplepointsettings_autoplay == 1){$setup14_multiplepointsettings_autoplay = 'true';}else{$setup14_multiplepointsettings_autoplay = 'false';}
	?>
	<script type="text/javascript">

	(function($) {
		"use strict";

		$(function(){
			var containerparent = $("#wpf-map-container").parent().parent().parent().parent().parent();
			if (containerparent.hasClass("vc_row-o-full-height")) {

				var calc_height = containerparent.height();
				
				
				if (!$(".wpf-container").hasClass("pftransparenthead") && $.pf_tablet_check()) {
					calc_height = (calc_height - $("#pfheadernav").height());
				}

				if (!$.pf_tablet_check()) {
					calc_height = (calc_height - $("#pfheadernav").height());
				}
				
				setTimeout(function(){
				  $("#wpf-map")
				    .height(calc_height) 
				    .gmap3({trigger:"resize"});
				}, 100);
			}

			if ($(".wpf-container").hasClass("pftransparenthead")) {
				if($.pf_tablet_check()){
					$(".pfsearch-draggable-window").css("margin-top",($("#pfheadernav").height()+20));
					$(".pfnotificationwindow").css("top",($("#pfheadernav").height()+29));
					$(".pf-err-button").css("top",($("#pfheadernav").height()+30));
				};
			}
		});

		$(function(){if ($('#pfsearch-draggable').parents('.pf-fullwidth').length == 0) {if ($.pf_mobile_check()) {$('#pfsearch-draggable').css('margin-right','50px').css('margin-left','50px');};};});
		
		/* CORE FUNCTIONS ADDON STARTED --------------------------------------------------------------------------------------------*/
		$.pfmultipleowlsetdefaults = function(owl){owl.owlCarousel({navigation : false,singleItem : true,autoPlay:<?php echo $setup14_multiplepointsettings_autoplay;?>,slideSpeed:<?php echo $setup14_multiplepointsettings_slidespeed;?>,mouseDrag:false,touchDrag:true,transitionStyle : "fade",autoHeight : false,});};
		$.pfloadmarkers = function(ne,sw,ne2,sw2,saction,sdata){
			$.typeofsdata = typeof sdata;
			var kxdata = [{name:'pointfinderltypes',value:'<?php echo PFEX_extract_type_ig($listingtype);?>'},{name:'pointfinderlocations',value:'<?php echo PFEX_extract_type_ig($locationtype);?>'},{name:'pointfinderconditions',value:'<?php echo PFEX_extract_type_ig($conditions);?>'},{name:'pointfinderitypes',value:'<?php echo PFEX_extract_type_ig($itemtype);?>'},{name:'pointfinderfeatures',value:'<?php echo PFEX_extract_type_ig($features);?>'}];
			$.ajax({
				  beforeSend: function(){$(".pfmaploading").fadeIn("slow");},
				  type: 'POST',
				  dataType: 'script',
				  url: theme_map_functionspf.ajaxurl,
				  cache:false,
				  data: {
				  	'action': 'pfget_markers',
				  	<?php if(isset($_GET['serialized'])){ ?>
				  		'act': 'search',
				  	<?php }else{ ?>
				  		'act': saction,
				  	<?php }?>
				  	'spl': $.pfgmap3static.spl,
				  	'splo': $.pfgmap3static.splo,
				  	'splob': $.pfgmap3static.splob,
				  	<?php if(isset($_GET['serialized'])){ ?>
				  		<?php if(!empty($ne)){?>
				  			'ne': <?php echo $ne;?>,
				  			'sw': <?php echo $sw;?>,
				  			'ne2': <?php echo $ne2;?>,
				  			'sw2': <?php echo $sw2;?>,
				  		<?php }?>
				  		'dt': '<?php echo base64_encode(maybe_serialize($_GET));?>',
				  	<?php }else{ ?>
				  		'ne': ne,
				  		'sw': sw,
				  		'ne2': ne2,
				  		'sw2': sw2,
				  		'dt': sdata,
				  	<?php }?>
				  	'dtx':kxdata,
				  	'cl':$.pfgmap3static.currentlang,
				  	'security': theme_map_functionspf.pfget_markers
				  },
				  success:function(data){
			
					$.pfgmap3static.callbackdata = data;
					
					$.pftogglewnotificationclearex = function(){
						if($('.pf-err-button').is(':visible')){
							$('.pf-err-button').hide('fast');
						}else{
							$('.pf-err-button').show({ effect: "fade",direction: "up" },0);
						}
					};

					<?php if($setup15_mapnotifications_dontshow_i == 1){
						$s_fix_word = '$.typeofsdata != "undefined"';
						echo '$.pftogglewnotificationclearex();';
					}else{
						$s_fix_word = '1==1';
					}
					?>

					if(wpflistdata.length == 0){

						$.pftogglewnotificationclearex();

						$.pftogglewnotification('<?php echo esc_attr($setup5_mapsettings_notfound);?>',<?php echo $setup15_mapnotifications_autoclosetime_e;?>,'pfnotfoundimage');
						
						<?php 
						if(!empty($neaddress)){
						?>
							var myLatlngxxx = new google.maps.LatLng(<?php echo $neaddress?>);
							$.pfmap_recenter($.pfgmap3static.pfmapobj,myLatlngxxx,0,0);
						<?php 
						}else{
						/* We couldn't found points at user's location */
							if (PFSAIssetControl('stp7_geo_newx','',0) == 0 && ($setup7_geolocation_status == 1 && $setup5_mapsettings_autofit != 1)) {
						?>
							$(function(){
								var myLatlngxxx = new google.maps.LatLng(<?php echo $setup5_mapsettings_lat;?>,<?php echo $setup5_mapsettings_lng;?>);
								if($.pfGeolocationDefaults.automove == true){
									$.pfloadmarkers();
								}
								$.pfmap_recenter($.pfgmap3static.pfmapobj,myLatlngxxx,0,0);
							})
						<?php
							}
						}
						?>


						
					}else if(wpflistdata.length != 0 && <?php echo $s_fix_word;?>){
						$.pftogglewnotification('<i class="pfadmicon-glyph-686"></i><a id="pfshowsearchresults" class="pfpointercursor pfshowsearchresults">'+wpflistdata.length+' <?php echo esc_attr($setup15_mapnotifications_foundtext);?></a>',<?php echo $setup15_mapnotifications_autoclosetime_i;?>,'pfnotfoundimagei');
					}
					$.pfclearallmarkers();
					if($.pf_tablet_check()){
						$.mdefaultopacity = <?php echo $setup8_pointsettings_pointopacity;?>;
					}else{
						$.mdefaultopacity = 1;
					}
					$('#wpf-map').gmap3({
					  <?php // Marker Started?>
					  marker: {
						values: wpflistdata, 
						options:{opacity: $.mdefaultopacity},
						<?php 
						// Cluster feature
						if($setup6_clustersettings_status == 1){
						?>
						cluster: {
						  radius:100,
						  <?php echo $setup6_clustersettings_minsize;?>: {content: '<div class="cluster cluster-1">CLUSTER_COUNT</div>',width: 53,height: 53,},
						  <?php echo $setup6_clustersettings_size2;?>: {content: '<div class="cluster cluster-2">CLUSTER_COUNT</div>',width: 56,height: 56,},
						  <?php echo $setup6_clustersettings_size3;?>: {content: '<div class="cluster cluster-3">CLUSTER_COUNT</div>',width: 66,height: 66,},
						  <?php echo $setup6_clustersettings_size4;?>: {content: '<div class="cluster cluster-4">CLUSTER_COUNT</div>',width: 78,height: 78,},
						  <?php echo $setup6_clustersettings_size5;?>: {content: '<div class="cluster cluster-5">CLUSTER_COUNT</div>',width: 90,height: 90,},
						  events: {
							click: function(cluster, event, context) {
								
							 
							  var map = $.pfgmap3static.pfmapobj;
							  map.panTo(cluster.main.getPosition());
							  map.setZoom(map.getZoom() + 1);
							  /*
								var latlngbounds = new google.maps.LatLngBounds();

								for (var i = 0; i < context.data.markers.length; i++) {
									latlngbounds.extend(new google.maps.LatLng(context.data.markers[i].latLng[0], context.data.markers[i].latLng[1]));
								}
								map.fitBounds(latlngbounds);
								
							*/
								
							},
							mouseover: function(cluster){
								$(cluster.main.getDOMElement()).css("opacity", "1.0");
							},
							mouseout: function(cluster){
								$(cluster.main.getDOMElement()).css("opacity", "1.0");
							}
						  }
						},
						<?php
						}
						//Cluster feature finished
						?>
						
						<?php // Event (marker) started?>
						events:{
						  click: function(marker, event, context){
						  		
								$.pfloadinfowindow(marker, event, context.data.id);
								if($.pf_tablet_check()){
									if ($.isEmptyObject($.zindexclicker)) { $.zindexclicker = {}; $.zindexclicker.click = 0};
						  			$.zindexclicker.click++
									marker.setZIndex(google.maps.Marker.MAX_ZINDEX + $.zindexclicker.click);
								}
						  },
						}
						<?php // Event (marker) finished?>
					  },
					  <?php if($setup5_mapsettings_autofit != 0){ echo 'autofit:{}';}?>
					  <?php // Marker finished?>
					});
					var saction;
					var sdata;
					if(!$.isEmptyObject($.pfsearchformvars)){saction = $.pfsearchformvars.action;}else{saction = '';}
					if(!$.isEmptyObject($.pfsearchformvars)){sdata = $.pfsearchformvars.vars;}else{sdata = '';}
					<?php 
					if (PFSAIssetControl('setup5_mapsettings_mapautoopen','','0') == 1) {
					?>
						if (sdata != '') {
							$.fn.pfgetpagelistdata({saction : saction,sdata : sdata,dtx :kxdata,ne : ne,sw : sw,ne2 : ne2,sw2 : sw2,});
							$.pftogglewnotificationclear();
							$.smoothScroll({scrollTarget: '.pfsearchresults-container',offset: -110});
						};
					<?php
					}
					?>
					$('#pfshowsearchresults').click(function(){
						$.fn.pfgetpagelistdata({saction : saction,sdata : sdata,dtx :kxdata,ne : ne,sw : sw,ne2 : ne2,sw2 : sw2,});
						$.pftogglewnotificationclear();
						$.smoothScroll({scrollTarget: '.pfsearchresults-container',offset: -110});
					});
				  },
				  error: function(jqXHR,textStatus,errorThrown){
				  	console.log(errorThrown);
				  },
				  complete: function(){
				  	console.log('Map loaded.')
					$(".pfmaploading").fadeOut("slow");
					<?php if($setup5_mapsettings_autofitsearch == 1 && $setup5_mapsettings_autofit == 0 ){ ?>if(!$.isEmptyObject($.pfsearchformvars)){$.pfaftersearch();}<?php }?>
					<?php if(isset($_GET['serialized']) && $setup5_mapsettings_autofitsearch == 1 && $setup5_mapsettings_autofit == 0 ){ ?>$.pfaftersearch();<?php }?>
				  },
				});
			
		};
		/* LOAD MARKERS FINISHED --------------------------------------------------------------------------------------------*/
		
		/* GEOLOCATION FUNCTION STARTED -------------------------------------------------------------------------------------*/
		$.pfgeolocation = function(){

			$('#wpf-map').gmap3({
				getgeoloc:{
					<?php // Callback started ?>
					callback : function(latLng){
					  <?php // If Started (If result: lanlng is ok.)?>
					  if (latLng){
						<?php // Gmap3 Started?>
						$(this).gmap3({
						  <?php // Circle Started?>
						  circle:{
							values:[{id:'geoloccircle'}],
							options:{
							  center: latLng,
							  editable: false,
							  draggable:false,
							  clickable:true,
							  radius : <?php echo $setup7_geolocation_distance_output; ?>,
							  fillColor : "<?php echo $setup7_geolocation_fillcolor; ?>",
							  fillOpacity: "<?php echo $setup7_geolocation_fillopacity; ?>",
							  strokeColor : "<?php echo $setup7_geolocation_strokecolor; ?>",
							  strokeOpacity: "<?php echo $setup7_geolocation_strokeopacity; ?>",
							},
							<?php // Callback (circle) started?>
							callback: function(){
								$.pfgmap3static.geocircle = $(this).gmap3({get: {id: 'geoloccircle'}});
								$.pfgmap3static.geocircleBounds = $.pfgmap3static.geocircle.getBounds();
								$(".pfmaploading").fadeOut("slow");
								$.pfgmap3static.pfmapobj.setCenter(latLng);
						
								$.pfGeolocationDefaults = {};
								$.pfGeolocationDefaults.icon1 = '<?php echo $setup7_geolocation_point_icon;?>';
								$.pfGeolocationDefaults.icon2 =	'<?php echo $setup7_geolocation_resize_icon;?>';
								$.pfGeolocationDefaults.latLng = latLng;
								$.pfGeolocationDefaults.distance = <?php echo $setup7_geolocation_distance; ?>;
								$.pfGeolocationDefaults.hideinfo = <?php echo $setup7_geolocation_hideinfo_val; ?>;
								<?php 
								if($setup7_geolocation_distance_unit == 'm'){echo '$.pfGeolocationDefaults.unit = "mi";';}else{echo '$.pfGeolocationDefaults.unit = "km";';}
								if($setup7_geolocation_move == 0 && empty($neaddress)){ echo '$.pfGeolocationDefaults.automove = false;';}else{ echo '$.pfGeolocationDefaults.automove = true;';}?>
								var distanceWidget = new $.pfDistanceWidget($(this).gmap3('get'));
							},
							<?php // Callback (circle) finished?>
						  },<?php if($setup7_geolocation_autofit == 1){ echo 'autofit:{},';}?>
						  <?php // Circle Finished?>
						  
						});
						<?php // Gmap3 finished?>
					  }
					  <?php // If  finished?>
					}
					<?php // Callback finished?>
				  },
			});
		};
		
		/* GEOLOCATION FUNCTION FINISHED ------------------------------------------------------------------------------------*/

		


		/* GEOLOCATION FUNCTION FINDPOSITION STARTED -------------------------------------------------------------------------------------*/
		$.pfgeolocation_findme = function(fieldval){
			$('#wpf-map').gmap3({
				getgeoloc:{
					callback : function(latLng){
					  if (latLng){
						var geocoder = new google.maps.Geocoder();
						geocoder.geocode({'latLng': latLng}, function(results, status) {
						    if (status == google.maps.GeocoderStatus.OK) {
						      if (results[0]) {
						        $('#'+fieldval+'').val(results[0].formatted_address);
						        $('#pointfinder_google_search_coord').val(latLng.lat()+','+latLng.lng());
						      } 
						    }
						});

					  }
					  $('.pf-search-locatemebut').show('fast'); $('.pf-search-locatemebutloading').hide('fast');
					}
				  },
			});
		};
		
		/* GEOLOCATION FUNCTION FINDPOSITION FINISHED ------------------------------------------------------------------------------------*/


		
		/* LOAD MAP STARTED --------------------------------------------------------------------------------------------*/
		<?php // Main Function Started?>	
		$(function(){
			//Define static vars
			$.pfgmap3static = {};
			<?php if(!empty($neaddress)){?>
				$.pfgmap3static.center = [<?php echo $neaddress?>];
			<?php }else{?>
				$.pfgmap3static.center = [<?php echo $setup5_mapsettings_lat;?>,<?php echo $setup5_mapsettings_lng;?>];
			<?php }?>
			$.pfgmap3static.zoom = <?php echo $setup5_mapsettings_zoom; ?>;
			$.pfgmap3static.zoom_mobile = <?php echo $setup5_mapsettings_zoom_mobile; ?>;
			$.pfgmap3static.geocircle = null;
			$.pfgmap3static.geocircleBounds = null;
			$.pfgmap3static.allmarkers = null;
			$.pfgmap3static.pfmapsingle = 0;
			$.pfgmap3static.pfmapobj = null;
			$.pfgmap3static.callbackdata = null;
			$.pfgmap3static.currentlang = "<?php echo PF_current_language();?>";
			$.pfgmap3static.spl = <?php echo $setup8_pointsettings_limit;?>;
			$.pfgmap3static.splo = "<?php echo $setup8_pointsettings_order;?>";
			$.pfgmap3static.splob = "<?php echo $setup8_pointsettings_orderby;?>";
			$.pfgmap3static.movemaplatlng = new Array();
			$.pfgmap3static.heightbetweenitems = (!$.pf_mobile_check())? <?php echo $heightbetweenitems2;?> :<?php echo $heightbetweenitems;?>;
			$.pfgmap3static.widthbetweenitems = (!$.pf_mobile_check())? <?php echo $widthbetweenitems2;?> :<?php echo $widthbetweenitems;?>;
			<?php if($setup14_multiplepointsettings_navigation == 0){?>
			$.pfgmap3static.hidemultiplenav = true;
			<?php }else{?>
			$.pfgmap3static.hidemultiplenav = null;
			<?php }?>
			<?php // Map Function Started?>
			if($.pf_mobile_check()){
				$.pfgmap3static.streetview = <?php echo $setup5_mapsettings_streetviewcontrol; ?>;
			}else{
				$.pfgmap3static.streetview = false;
			}
			$('#wpf-map').gmap3({
			  defaults:{ 
	            classes:{
	              Marker:RichMarker
	            }
	          },
			  map:{
				  options:{
				  	<?php if(!empty($neaddress)){?>
						center:[<?php echo $neaddress?>],
					<?php }else{?>
						center:[<?php echo $setup5_mapsettings_lat;?>,<?php echo $setup5_mapsettings_lng;?>],
					<?php }?>
					
					zoom: (!$.pf_mobile_check())? $.pfgmap3static.zoom_mobile:$.pfgmap3static.zoom,
					maxZoom:<?php echo PFSAIssetControl('setup5_mzoom','',20);?>,
					mapTypeId: google.maps.MapTypeId.<?php echo $setup5_mapsettings_type; ?>,
					mapTypeControl: false,
					zoomControl: false,
					panControl: false,
					scaleControl: false,
					navigationControl: false,
					draggable:<?php echo $drag_status;?>,
					scrollwheel: false,
					streetViewControl: $.pfgmap3static.streetview,
					streetViewControlOptions: {
						position: google.maps.ControlPosition.RIGHT_BOTTOM,
					},
					<?php
					//Map styles & Business Points
					echo 'styles: [';
					if($setup5_mapsettings_business == 0){
						echo "{featureType: 'poi',elementType: 'labels',stylers: [{ visibility: 'off' }]},";
					}
					
					if($setup5_mapsettings_style != ''){
						$style_output = preg_replace('/\s+/', '', rawurldecode( base64_decode( strip_tags( $setup5_mapsettings_style ))));
						if (mb_substr($style_output, 0, 1,'UTF-8') == '[' && mb_substr($style_output, -1, 1,'UTF-8') == ']') {
							$style_output = mb_substr($style_output, 1, -1,'UTF-8');
						}
						
						print_r($style_output);
					}
					echo ']';
					?>
				  },
				  events:{
					<?php if($setup8_pointsettings_ajax != 0 && $setup8_pointsettings_ajax_zoom != 0){?>
					zoom_changed:function(marker, event, context){
						$.pfclearoverlay();
						var zoom = $.pfgmap3static.pfmapobj.getZoom();
						if($.pfgmap3static.geocircleBounds != null){var bounds = $.pfgmap3static.geocircleBounds;}else{var bounds = $.pfgmap3static.pfmapobj.getBounds();}
					  
						var ne = bounds.getNorthEast();
						var sw = bounds.getSouthWest();
										
					  if(zoom < <?php echo $setup5_mapsettings_zoom; ?>){
						 if(!$.isEmptyObject($.pfsearchformvars)){
							$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);
						 }else{
							$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng());
						 }
					  }
					},
					<?php }?>
					projection_changed: function(map){
						<?php // Geolocation function
						if($setup7_geolocation_status == 1 && $setup5_mapsettings_autofit != 1 ){
							echo '$.pfgeolocation();';
						}else{
						?>
							var bounds = map.getBounds();
							var ne = bounds.getNorthEast();
							var sw = bounds.getSouthWest();
							<?php 
							if($setup8_pointsettings_ajax != 0){
							echo '$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng());';
							}else{
							echo '$.pfloadmarkers();';
							}
						}
						?>
				   },
				   <?php if($setup8_pointsettings_ajax != 0 && $setup8_pointsettings_ajax_drag != 0){?>
				   dragend: function(map){
						if($.pfgmap3static.geocircleBounds != null){var bounds = $.pfgmap3static.geocircleBounds;}else{var bounds = $.pfgmap3static.pfmapobj.getBounds();}
						var ne = bounds.getNorthEast();
						var sw = bounds.getSouthWest();
						if(!$.isEmptyObject($.pfsearchformvars)){$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng(),$.pfsearchformvars.action,$.pfsearchformvars.vars);}else{$.pfloadmarkers(ne.lat(),sw.lat(),ne.lng(),sw.lng());}
				   },
				   <?php }?>
				   
				  },
				  callback: function(){
					$.pfgmap3static.pfmapobj = $(this).gmap3('get');
				  }
			  }
			});
			<?php // Map Function Finished?>
		});
		<?php // Main Function Finished?>
		/* LOAD MAP FINISHED --------------------------------------------------------------------------------------------*/
	})(jQuery);
	</script>
<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'pf_directory_map', 'pf_directorymap_func' ); 

?>
