<style>
   	body { font-size: 10px; }
    p { font-size: 12px; }
    input.text { width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    table { border-spacing:0;float:left;margin-right:30px; }
    tr { height:50px;}
    td { padding:0; width:230px;}
    .fwd-error { color:#FF0000; }
</style>

<script>
	var settingsAr = <?php echo json_encode($this->_data->settings_ar); ?>;
	
	var sid = <?php echo $set_id; ?>;
	var cur_order_id = <?php echo $set_order_id; ?>;
	var tab_init_id = <?php echo $tab_init_id; ?>;
</script>

<fieldset class="ui-widget">
	<label for="skins">Select your preset:</label>
	
    <select id="skins" class="ui-widget ui-corner-all" style="max-width:200px;"></select>
    <label id="preset_id" for="skins"></label>
    
    <p id="tips" style="width:600px;">All form fields are required.</p>
</fieldset>

<form action="" method="post" style="margin-top:20px;margin-right:20px;">
	<div id="tabs" style="height:600px;overflow:auto;">
	  	<ul>
			<?php $iconsPath = plugin_dir_url(dirname(__FILE__)) . "load/icons/" ?>
		    <li><a href="#tab1"><img src=<?php echo $iconsPath . "tab1-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Main settings</span></a></li>
		    <li><a href="#tab2"><img src=<?php echo $iconsPath . "tab2-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Thumbnails settings</span></a></li>
		    <li><a href="#tab3"><img src=<?php echo $iconsPath . "tab3-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Controls settings</span></a></li>
		    <li><a href="#tab4"><img src=<?php echo $iconsPath . "tab4-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Combobox settings</span></a></li>
		    <li><a href="#tab5"><img src=<?php echo $iconsPath . "tab5-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Lightbox settings</span></a></li>
			<li><a href="#tab6"><img src=<?php echo $iconsPath . "tab6-icon.png" ?> style="vertical-align:middle;"><span style="vertical-align:middle;margin-left:4px;">Navigation bullets settings</span></a></li>
	  	</ul>
	 
	  	<div id="tab1">
			<table>
    			<tr>
		    		<td>
		    			<label for="name">Preset name:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="name" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="display_type">Display type:</label>
		    		</td>
		    		<td>
		    			<select id="display_type" class="ui-corner-all">
							<option value="fluidwidth">fluid-width</option>
							<option value="responsive">responsive</option>
							<option value="fixed">fixed</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
						title="If 'fluid-width' the carousel will always fill the browser width and its height will be the below value.
							If 'responsive' the carousel will fill its container width and its height will be the below value.
							If 'fixed' the carousel width and height will be the below values.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="autoscale">Autoscale:</label>
		    		</td>
		    		<td>
		    			<select id="autoscale" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="If 'yes' and the layout width is less than the specified carousel width, then it will keep a correct scale ratio.
								If 'no' the carousel size and scale ratio will not be modified.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_width">Carousel width:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="cov_width" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_height">Carousel height:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="cov_height" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="skin_path">Skin path:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="skin_path" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_bg_color">Background color:</label>
		    		</td>
		    		<td>
		    			<input id="cov_bg_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_bg_image_url">Background image path:</label>
		    		</td>
		    		<td>
		    			<div id="cov_bg_image_div">
				    		<table>
				    			<tr>
						    		<td>
						    			<input id="cov_bg_image_url" type="text" style="width:200px;" class="text ui-widget-content ui-corner-all">
						    		 	<button id="cov_bg_image_btn" style="cursor:pointer;">Add Image</button>
						    		</td>
						    		<td>
						    			<img src="" id="cov_bg_upload_img" style="width:50px;height:50px;margin-left:20px;">
						    		</td>
						    	</tr>
						    </table>
						</div>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumbs_bg_image_url">Thumbnails background image path:</label>
		    		</td>
		    		<td>
		    			<div id="thumbs_bg_image_div">
				    		<table>
				    			<tr>
						    		<td>
						    			<input id="thumbs_bg_image_url" type="text" style="width:200px;" class="text ui-widget-content ui-corner-all">
						    		 	<button id="thumbs_bg_image_btn" style="cursor:pointer;">Add Image</button>
						    		</td>
						    		<td>
						    			<img src="" id="thumbs_bg_upload_img" style="width:50px;height:50px;margin-left:20px;">
						    		</td>
						    	</tr>
						    </table>
						</div>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="scrollbar_bg_image_url">Scrollbar background image path:</label>
		    		</td>
		    		<td>
		    			<div id="scrollbar_bg_image_div">
				    		<table>
				    			<tr>
						    		<td>
						    			<input id="scrollbar_bg_image_url" type="text" style="width:200px;" class="text ui-widget-content ui-corner-all">
						    		 	<button id="scrollbar_bg_image_btn" style="cursor:pointer;">Add Image</button>
						    		</td>
						    		<td>
						    			<img src="" id="scrollbar_bg_upload_img" style="width:50px;height:50px;margin-left:20px;">
						    		</td>
						    	</tr>
						    </table>
						</div>
		    		</td>
		    	</tr>
		    </table>
		    
		    <table>
    			<tr>
		    		<td>
		    			<label for="bg_repeat">Background repeat:</label>
		    		</td>
		    		<td>
		    			<select id="bg_repeat" class="ui-corner-all">
							<option value="repeat">repeat</option>
							<option value="repeat-x">repeat-x</option>
							<option value="repeat-y">repeat-y</option>
							<option value="no-repeat">no-repeat</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the CSS background-repeat property for all the 3 background images. It has the standard CSS values.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="car_topology">Carousel topology:</label>
		    		</td>
		    		<td>
		    			<select id="car_topology" class="ui-corner-all">
							<option value="normal">normal</option>
							<option value="ring">ring</option>
							<option value="star">star</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the geometry topology of the carousel. It has 3 options and it changes the rotation of each thumbnail.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="car_x_radius">Carousel X radius:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="car_x_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the value of the radius for the X axis of the carousel.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="car_y_radius">Carousel Y radius:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="car_y_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the value of the radius for the Y axis of the carousel.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="car_x_rot">Carousel X rotation:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="car_x_rot" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the value of the rotation of the whole carousel on the X axis.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="car_y_offset">Carousel Y offset:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="car_y_offset" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is an offset used for the Y axis of the whole carousel, you can move it up and down.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_center_image">Show center image:</label>
		    		</td>
		    		<td>
		    			<select id="show_center_image" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide the center image of the carousel.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="center_image_url">Center image path:</label>
		    		</td>
		    		<td>
		    			<div id="center_image_div">
				    		<table>
				    			<tr>
						    		<td>
						    			<input id="center_image_url" type="text" style="width:200px;" class="text ui-widget-content ui-corner-all">
						    		 	<button id="center_image_btn" style="cursor:pointer;">Add Image</button>
						    		</td>
						    		<td>
						    			<img src="" id="center_upload_img" style="width:50px;height:50px;margin-left:20px;">
						    		</td>
						    	</tr>
						    </table>
						</div>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="center_image_y_offset">Center image Y offset:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="center_image_y_offset" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is an offset used for the Y axis of the center image, you can move it up and down.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_2d_display">Always show 2D display:</label>
		    		</td>
		    		<td>
		    			<select id="show_2d_display" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This sets the carousel to be always displayed in the 2D layout even on browsers that support 3D, not just for fallback.">
		    		</td>
		    	</tr>
		    </table>
		    
		    <table>
				<tr>
		    		<td>
		    			<label for="cov_start_pos">Carousel start position:</label>
		    		</td>
		    		<td>
		    			<select id="cov_start_pos" class="ui-corner-all">
		    				<option value="left">left</option>
							<option value="center">center</option>
							<option value="right">right</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the start position of the thumbnails of the carousel, the one that will be selected in front.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_autoplay">Carousel autoplay:</label>
		    		</td>
		    		<td>
		    			<select id="cov_autoplay" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_slideshow_delay">Carousel slideshow delay (milliseconds):</label>
		    		</td>
		    		<td>
		    			<input type="text" id="cov_slideshow_delay" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="right_click_context_menu">Right-click context menu:</label>
		    		</td>
		    		<td>
		    			<select id="right_click_context_menu" class="ui-corner-all">
							<option value="developer">developer</option>
							<option value="disabled">disabled</option>
							<option value="default">default</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="If 'developer' the context menu will be the developer link 'made by FWD'.
							If 'disabled' the context menu will be disabled completely.
							If 'default' the context menu will be the browser default.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="cov_keyboard_support">Add keyboard navigation support:</label>
		    		</td>
		    		<td>
		    			<select id="cov_keyboard_support" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="fluid_width_z_index">Fluid-width z-index:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="fluid_width_z_index" style="width:200px;" class="text ui-widget-content ui-corner-all">
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is a z-index used for the 'fluid-width' version of the carousel so that you can remove conflicts with overlapping menus etc.">
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="show_large_next_and_prev_buttons">Show large next and prev buttons:</label>
		    		</td>
		    		<td>
		    			<select id="show_large_next_and_prev_buttons" class="ui-corner-all">
		    				<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
				
				<tr>
		    		<td>
		    			<label for="large_next_and_prev_buttons_offest">Large next and prev buttons offset:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="large_next_and_prev_buttons_offest" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="Horizontal offset in px for the large next and prev buttons.">
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="use_drag_and_swipe">Use mouse drag and swipe:</label>
		    		</td>
		    		<td>
		    			<select id="use_drag_and_swipe" class="ui-corner-all">
		    				<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
				
		    </table>
		</div>
	  
		<div id="tab2">
		  	<table>
    			<tr>
		    		<td>
		    			<label for="thumb_width">Thumbnail width:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="thumb_width" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_height">Thumbnail height:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="thumb_height" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_border_size">Thumbnail border size:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="thumb_border_size" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_min_alpha">Thumbnail minimum alpha:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="thumb_min_alpha" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the opacity of the back thumbnails of the carousel (the ones that are the furthest). It must be a float value between 0 and 1.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_bg_color">Thumbnail background color:</label>
		    		</td>
		    		<td>
		    			<input id="thumb_bg_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_border_color1">Thumbnail border color 1:</label>
		    		</td>
		    		<td>
		    			<input id="thumb_border_color1" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the upper color of the thumbnails border. If these two border color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="thumb_border_color2">Thumbnail border color 2:</label>
		    		</td>
		    		<td>
		    			<input id="thumb_border_color2" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the lower color of the thumbnails border. If these two border color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="transparent_images">Use transparent images:</label>
		    		</td>
		    		<td>
		    			<select id="transparent_images" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="If 'yes' then the background and border of the thumbnails won't be displayed and you can use png images with transparent backgrounds.
								If 'no' then the background and border will be displayed.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="max_thumbs_mobile">Maximum number of thumbnails <br> on mobile:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="max_thumbs_mobile" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the maximum number of thumbnails to be displayed only on the mobile devices for performance reasons.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_thumbs_gradient">Show thumbnail gradient:</label>
		    		</td>
		    		<td>
		    			<select id="show_thumbs_gradient" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide the side thumbnails gradient (used for the shadow effect).">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_thumbs_text">Show thumbnail text:</label>
		    		</td>
		    		<td>
		    			<select id="show_thumbs_text" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide the thumbnails hover text.">
		    		</td>
		    	</tr>
			</table>
		    <table>
		    	<tr>
		    		<td>
		    			<label for="text_bg_color">Text background color:</label>
		    		</td>
		    		<td>
		    			<input id="text_bg_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="text_bg_opacity">Text background opacity:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="text_bg_opacity" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the opacity of the thumbnails text background. It must be a float value between 0 and 1.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_text_bg_image">Show text background image:</label>
		    		</td>
		    		<td>
		    			<select id="show_text_bg_image" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide the thumbnails text background image. If it is 'no' then the previous text background color setting will be used.">
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="show_full_text_without_hover">Show full text without hover:</label>
		    		</td>
		    		<td>
		    			<select id="show_full_text_without_hover" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to enable the thumbnails text to be shown all the time without the otherwise necessary hover.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_thumb_box_shadow">Show thumbnail box shadow:</label>
		    		</td>
		    		<td>
		    			<select id="show_thumb_box_shadow" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show a box shadow on the thumbnail if desired.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="box_shadow_css">Thumbnail box shadow CSS:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="box_shadow_css" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the CSS box-shadow property for the thumbnail. It will be displayed only if the previous 'Show thumbnail box shadow' setting is set to 'yes'.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_reflection">Show image reflection:</label>
		    		</td>
		    		<td>
		    			<select id="show_reflection" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="reflection_height">Thumbnail reflection height:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="reflection_height" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="reflection_distance">Thumbnail reflection distance:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="reflection_distance" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="reflection_opacity">Thumbnail reflection opacity:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="reflection_opacity" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the opacity of the thumbnails reflection. It must be a float value between 0 and 1.">
		    		</td>
		    	</tr>
		    </table>
		</div>
		  
		<div id="tab3">
	    	<table>
	    		<tr>
		    		<td>
		    			<label for="controls_max_width">Controls maximum width:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="controls_max_width" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the maximum width of the controls bar and is used to scale the scrollbar at resize.">
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="controls_height">Controls height:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="controls_height" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the height of the controls bar.">
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="controls_position">Controls position:</label>
		    		</td>
		    		<td>
		    			<select id="controls_position" class="ui-corner-all">
							<option value="top">top</option>
							<option value="bottom">bottom</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_prev_btn">Show previous button:</label>
		    		</td>
		    		<td>
		    			<select id="show_prev_btn" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_next_btn">Show next button:</label>
		    		</td>
		    		<td>
		    			<select id="show_next_btn" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="disable_btns_mobile">Disable next and previous buttons <br> on mobile:</label>
		    		</td>
		    		<td>
		    			<select id="disable_btns_mobile" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_slideshow_btn">Show slideshow button:</label>
		    		</td>
		    		<td>
		    			<select id="show_slideshow_btn" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="timer_color">Slideshow timer color:</label>
		    		</td>
		    		<td>
		    			<input id="timer_color" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the color of the slideshow timer button display numbers.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_scrollbar">Show scrollbar:</label>
		    		</td>
		    		<td>
		    			<select id="show_scrollbar" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="scrollbar_handler_width">Scrollbar handler width:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="scrollbar_handler_width" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="scrollbar_text_normal_color">Scrollbar text normal color:</label>
		    		</td>
		    		<td>
		    			<input id="scrollbar_text_normal_color" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the normal color of the text from the scrollbar handler.">
		    		</td>
		    	</tr>
			</table>
		    <table>
		    	<tr>
		    		<td>
		    			<label for="scrollbar_text_selected_color">Scrollbar text selected color:</label>
		    		</td>
		    		<td>
		    			<input id="scrollbar_text_selected_color" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the selected color of the text from the scrollbar handler.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="disable_scrollbar_mobile">Disable scrollbar on mobile:</label>
		    		</td>
		    		<td>
		    			<select id="disable_scrollbar_mobile" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="enable_mouse_wheel">Enable mouse wheel scroll:</label>
		    		</td>
		    		<td>
		    			<select id="enable_mouse_wheel" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    </table>
		</div>
	
		<div id="tab4">
			<table>
		    	<tr>
		    		<td>
		    			<label for="show_combobox">Show combobox:</label>
		    		</td>
		    		<td>
		    			<select id="show_combobox" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide the carousel combobox. This combobox is used as a select menu for the carousel categories.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="start_category">Combobox start category:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="start_category" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is used to specify the selected start category of the combobox if there is more than one category. Please note that the counting starts from 1.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="select_label">Combobox select label:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="select_label" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the combobox title label for the selecting of the categories.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="all_cats_label">Combobox all categories label:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="all_cats_label" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the combobox label of the option that shows all the categories.
								If the 'Show all categories' setting below is enabled then it is considered the first category.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="show_all_cats">Show all categories:</label>
		    		</td>
		    		<td>
		    			<select id="show_all_cats" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is used to show or hide an extra combobox option button which will load all categories in a single category.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="combobox_pos">Combobox position:</label>
		    		</td>
		    		<td>
		    			<select id="combobox_pos" class="ui-corner-all">
							<option value="topleft">top-left</option>
							<option value="topright">top-right</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="selector_bg_normal_color1">Combobox selector background <br> normal color 1:</label>
		    		</td>
		    		<td>
		    			<input id="selector_bg_normal_color1" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox selector button background upper normal color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="selector_bg_normal_color2">Combobox selector background <br> normal color 2:</label>
		    		</td>
		    		<td>
		    			<input id="selector_bg_normal_color2" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox selector button background lower normal color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="selector_bg_selected_color1">Combobox selector background <br> selected color 1:</label>
		    		</td>
		    		<td>
		    			<input id="selector_bg_selected_color1" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox selector button background upper selected color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="selector_bg_selected_color2">Combobox selector background <br> selected color 2:</label>
		    		</td>
		    		<td>
		    			<input id="selector_bg_selected_color2" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox selector button background lower selected color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="selector_text_normal_color">Combobox selector text <br> normal color:</label>
		    		</td>
		    		<td>
		    			<input id="selector_text_normal_color" />
		    		</td>
		    	</tr>
		    </table>
		    <table>
		    	<tr>
		    		<td>
		    			<label for="selector_text_selected_color">Combobox selector text <br> selected color:</label>
		    		</td>
		    		<td>
		    			<input id="selector_text_selected_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_bg_normal_color1">Combobox button background <br> normal color 1:</label>
		    		</td>
		    		<td>
		    			<input id="button_bg_normal_color1" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox category button background upper normal color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_bg_normal_color2">Combobox button background <br> normal color 2:</label>
		    		</td>
		    		<td>
		    			<input id="button_bg_normal_color2" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox category button background lower normal color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_bg_selected_color1">Combobox button background <br> selected color 1:</label>
		    		</td>
		    		<td>
		    			<input id="button_bg_selected_color1" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox category button background upper selected color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_bg_selected_color2">Combobox button background <br> selected color 2:</label>
		    		</td>
		    		<td>
		    			<input id="button_bg_selected_color2" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the combobox category button background lower selected color. If these two color values are different then they create a gradient effect,
								if they are the same then there is a single color.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_text_normal_color">Combobox button text normal color:</label>
		    		</td>
		    		<td>
		    			<input id="button_text_normal_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="button_text_selected_color">Combobox button text selected color:</label>
		    		</td>
		    		<td>
		    			<input id="button_text_selected_color" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="combobox_shadow_color">Combobox box shadow color:</label>
		    		</td>
		    		<td>
		    			<input id="combobox_shadow_color" />
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;"
							title="This is the color of the box shadow surrounding the combobox.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="combobox_horizontal_margins">Combobox horizontal margin:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="combobox_horizontal_margins" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the horizontal margin offset of the combobox relative to the carousel container.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="combobox_vertical_margins">Combobox vertical margin:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="combobox_vertical_margins" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    			<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"
							title="This is the vertical margin offset of the combobox relative to the carousel container.">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="combobox_corner_radius">Combobox corner radius:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="combobox_corner_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    </table>
		</div>
			
		<div id="tab5">
			<table>


				<tr>


		    		<td>


		    			<label for="buttons_alignment">Buttons alignment:</label>


		    		</td>


		    		<td>


		    			<select id="buttons_alignment" class="ui-corner-all">


							<option value="in">in</option>


							<option value="out">out</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="item_box_shadow">Item box shadow:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="item_box_shadow" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="description_windowAnimation_type">Item description animation type:</label>


		    		</td>


		    		<td>


		    			<select id="description_windowAnimation_type" class="ui-corner-all">


							<option value="opacity">opacity</option>


							<option value="motion">motion</option>


						</select>


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="The type of animation of the item info/description when it appears.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="description_window_position">Item description position:</label>


		    		</td>


		    		<td>


		    			<select id="description_window_position" class="ui-corner-all">


							<option value="top">top</option>


							<option value="bottom">bottom</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>
		    		<td>
		    			<label for="description_window_animation_type">Item description position:</label>
		    		</td>

		    		<td>
		    			<select id="description_window_animation_type" class="ui-corner-all">
							<option value="opacity">opacity</option>
							<option value="motion">motion</option>
							


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="slide_show_auto_play">Slideshow autoplay:</label>


		    		</td>


		    		<td>


		    			<select id="slide_show_auto_play" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="add_keyboard_support">Add keyboard support:</label>


		    		</td>


		    		<td>


		    			<select id="add_keyboard_support" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_close_button">Show close button:</label>


		    		</td>


		    		<td>


		    			<select id="show_close_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_share_button">Show share button:</label>


		    		</td>


		    		<td>


		    			<select id="show_share_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_zoom_button">Show image maximize/zoom button:</label>


		    		</td>


		    		<td>


		    			<select id="show_zoom_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>
				
				<tr>


		    		<td>


		    			<label for="show_slide_show_button">Show slideshow button:</label>


		    		</td>


		    		<td>


		    			<select id="show_slide_show_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


			</table>

			<table>

				<tr>


		    		<td>


		    			<label for="show_slide_show_animation">Show slideshow circular animation:</label>


		    		</td>


		    		<td>


		    			<select id="show_slide_show_animation" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_next_and_prev_buttons">Show next and previous buttons:</label>


		    		</td>


		    		<td>


		    			<select id="show_next_and_prev_buttons" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_next_and_prev_buttons_on_mobile">Show next and previous buttons on mobile:</label>


		    		</td>


		    		<td>


		    			<select id="show_next_and_prev_buttons_on_mobile" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Disable next and previous  buttons on all devices, mobile or desktop.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_description_button">Show item description/info button:</label>


		    		</td>


		    		<td>


		    			<select id="show_description_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="show_description_by_default">Show description/info by default:</label>


		    		</td>


		    		<td>


		    			<select id="show_description_by_default" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="If a lightbox item has a description it will apear after the item is loaded without the need to click the show item description/info button.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="video_show_full_screen_button">Show video player fullscreen button:</label>


		    		</td>


		    		<td>


		    			<select id="video_show_full_screen_button" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="video_auto_play">Video player autoplay:</label>


		    		</td>


		    		<td>


		    			<select id="video_auto_play" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="next_video_or_audio_auto_play">Autoplay next audio or video item:</label>


		    		</td>


		    		<td>


		    			<select id="next_video_or_audio_auto_play" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="If enabled and a next item is a audio or video type it will start playing.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="video_loop">Video player loop:</label>


		    		</td>


		    		<td>


		    			<select id="video_loop" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>


				


				


				<tr>


		    		<td>


		    			<label for="audio_auto_play">Audio player autoplay:</label>


		    		</td>


		    		<td>


		    			<select id="audio_auto_play" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>

				


				<tr>


		    		<td>


		    			<label for="audio_loop">Audio player loop:</label>


		    		</td>


		    		<td>


		    			<select id="audio_loop" class="ui-corner-all">


							<option value="yes">yes</option>


							<option value="no">no</option>


						</select>


		    		</td>


		    	</tr>

			</table>
			
			<table>
			<tr>


		    		<td>


		    			<label for="background_opacity">Main background opacity:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="background_opacity" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="A float value from 0 to 1.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="description_window_background_opacity">Description window background opacity:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="description_window_background_opacity" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="A float value from 0 to 1.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="buttons_hide_delay">Buttons hide delay:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="buttons_hide_delay" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Delays in seconds until the buttons will hide after the last lightbox interaction.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="slide_show_delay">Slideshow delay:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="slide_show_delay" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Slideshow delay in seconds.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="default_item_width">Default item width:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="default_item_width" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="The default item width in px. If a lightbox item dosen't have a specified width, this is what it will be used as a default.">


		    		</td>


		    	</tr>

				<tr>


		    		<td>


		    			<label for="default_item_height">Default item height:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="default_item_height" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="The default item width in px. If a lightbox item dosen't have a specified height, this is what it will be used as a default.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="item_offset_height">Item offset height:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="item_offset_height" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Represents the px to remove from the top and bottom part of the lightbox item, think of this as margin top and margin bottom for the lightbox item.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="space_between_buttons">Space between buttons:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="space_between_buttons" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Space between buttons in px.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="buttons_offset_in">Buttons offset in:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="buttons_offset_in" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Space between the buttons in px and the lightbox item, think of this as margin left for the buttons from the right side of the lightbox item and margin right for the buttons from the left site of the lightbox item.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="buttons_offset_out">Buttons offset out:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="buttons_offset_out" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Space between the buttons in px and window left or right side, think of this as margin right for the buttons from the right side of the lightbox item and margin left for the buttons from the left site of the lightbox item.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="item_border_size">Item border size:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="item_border_size" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Item border size in px.">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="item_border_radius">Item border radius:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="item_border_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">


						<img src=<?php echo $this->_dir_url . "load/icons/help-icon.png" ?> style="vertical-align:middle;margin-top:-4px;"


							title="Item border radius in px.">


		    		</td>


		    	</tr>


			
				
				<tr>
		    		<td>
		    			<label for="item_background_color">Item background color:</label>
		    		</td>

		    		<td>
		    			<input type="text" id="item_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>

				<tr>
		    		<td>
		    			<label for="item_border_color1">Item gradient border color 1:</label>
		    		</td>

		    		<td>
		    			<input type="text" id="item_border_color1" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
				
				<tr>


		    		<td>


		    			<label for="item_border_color2">Item gradient border color2:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="item_border_color2" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="light_box_background_color">Lightbox main background color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="light_box_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="description_window_background_color">Description window background color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="description_window_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="video_poster_background_color">Video poster background color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="video_poster_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="video_controller_background_color">Video controller background color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="video_controller_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="audio_controller_background_color">Audio controller background color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="audio_controller_background_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>


				


				<tr>


		    		<td>


		    			<label for="time_color">Video/audio time color:</label>


		    		</td>


		    		<td>


		    			<input type="text" id="time_color" style="width:200px;" class="text ui-widget-content ui-corner-all">


		    		</td>


		    	</tr>
			</table>

		</div>
	
		
		<div id="tab6">
			<table>
		    	<tr>
		    		<td>
		    			<label for="show_bullets_navigation">Show bullets navigation:</label>
		    		</td>
		    		<td>
		    			<select id="show_bullets_navigation" class="ui-corner-all">
							<option value="yes">yes</option>
							<option value="no">no</option>
						</select>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_background_normal_color1">Bullets gradient normal state color 1:</label>
		    		</td>
		    		<td>
		    			<input id="bullets_background_normal_color1" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_background_normal_color2">Bullets gradient normal state color 2:</label>
		    		</td>
		    		<td>
		    			<input id="bullets_background_normal_color2" />
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="bullets_background_selected_color1">Bullets gradient selected state color 1:</label>
		    		</td>
		    		<td>
		    			<input id="bullets_background_selected_color1" />
		    		</td>
		    	</tr>
				<tr>
		    		<td>
		    			<label for="bullets_background_selected_color2">Bullets gradient selected state color 2:</label>
		    		</td>
		    		<td>
		    			<input id="bullets_background_selected_color2" />
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_shadow">Bullets CSS box shadow:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="bullets_shadow" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_normal_radius">Bullets normal radius in px:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="bullets_normal_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_selected_radius">Bullets selected radius in px:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="bullets_selected_radius" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="space_between_bullets">Space between bullets in px:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="space_between_bullets" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>
		    			<label for="bullets_offset">Bullets offset y in px:</label>
		    		</td>
		    		<td>
		    			<input type="text" id="bullets_offset" style="width:200px;" class="text ui-widget-content ui-corner-all">
		    		</td>
		    	</tr>
		    </table>
		</div>
	
	</div>
	
	<input type="hidden" id="settings_data" name="settings_data" value="">
	
	<input id="add_btn" type="submit" name="submit" style="cursor:pointer;margin-top:20px;" value="Add new preset" />
	<input id="update_btn" type="submit" name="submit" style="cursor:pointer;margin-top:20px;" value="Update preset settings" />
	<input id="del_btn" type="submit" name="submit" style="cursor:pointer;margin-top:20px;" value="Delete preset" />
	
	<?php wp_nonce_field("fwdu3dcar_general_settings_update", "fwdu3dcar_general_settings_nonce"); ?>
</form>

<?php echo $msg; ?>

