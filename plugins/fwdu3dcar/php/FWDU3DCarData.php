<?php

// main FWD Ultimate 3D Carousel Data class
class FWDU3DCarData
{
	// constants
	const DEFAULT_SKINS_NR = 3;

	// variables
	public $settings_ar;
    public $playlists_ar;
	
	private $_dir_url;
	
    // constructor
    public function FWDU3DCarData()
    {
		$this->_dir_url = plugin_dir_url(dirname(__FILE__));
	
		$cur_data = get_option("fwdu3dcar_data");
		
		//$this->reset_presets();
	       
	    if (!$cur_data)
	    {
	    	$this->init_settings();
	    	$this->set_data();
	    }
		
		//$this->set_updates();
    	
    	$this->get_data();
    }
	
	
	private function reset_presets()
	{
		$this->get_data();
		$this->init_settings();
	    $this->set_data();
	}
	
	
	private function set_updates()
	{
		$this->get_data();
		
   		foreach ($this->settings_ar as &$preset)
    	{
			
			if (!array_key_exists("controls_position", $preset))
	    	{
	    		$preset["controls_position"] = "bottom";
			}
			
			// update plugin dir url
			$pattern = "/\/[^\/]*\/load\/skin/";
			$parts = explode("/", trim($this->_dir_url, "/"));
			$preset["skin_path"] = preg_replace($pattern, "/" . $parts[count($parts)-1] . "/load/skin", $preset["skin_path"]);
    	}
		
		$this->set_data();
	}
    
    // functions
    private function init_settings()
    {
    	$this->settings_ar = array(
									array(
											// main settings
											"id" => 0,
											"name" => "skin_modern_silver",
											"display_type" => "fluidwidth",
											"autoscale" => "yes",
											"cov_width" => 940,
											"cov_height" => 538,
											"skin_path" => "skin_modern_silver",
											"cov_bg_color" => "#DDDDDD",
											"cov_bg_image_url" => "",
											"thumbs_bg_image_url" => $this->_dir_url . "load/skin_modern_silver/main_skin/thumbnailsBackground.jpg",
											"scrollbar_bg_image_url" => $this->_dir_url . "load/skin_modern_silver/main_skin/scrollbarBackground.jpg",
											"bg_repeat" => "repeat-x",
											"car_topology" => "ring",
											"car_x_radius" => 600,
											"car_y_radius" => 0,
											"car_x_rot" => 10,
											"car_y_offset" => 0,
											"show_center_image" => "no",
											"center_image_url" => "",
											"center_image_y_offset" => 0,
											"show_2d_display" => "no",
											"cov_start_pos" => "center",
											"cov_autoplay" => "no",
											"cov_slideshow_delay" => 5000,
											"right_click_context_menu" => "developer",
											"cov_keyboard_support" => "yes",
											"fluid_width_z_index" => 1000,
											"show_large_next_and_prev_buttons" => "no",
											"large_next_and_prev_buttons_offest" => 15,
											"use_drag_and_swipe" =>"yes",
					
											// thumbs settings
											"thumb_width" => 400,
											"thumb_height" => 266,
											"thumb_border_size" => 10,
											"thumb_min_alpha" => .3,
											"thumb_bg_color" => "#666666",
											"thumb_border_color1" => "#FCFDFD",
											"thumb_border_color2" => "#E4E4E4",
											"transparent_images" => "no",
											"max_thumbs_mobile" => 13,
											"show_thumbs_gradient" => "yes",
											"show_thumbs_text" => "yes",
											"text_bg_color" => "#333333",
											"text_bg_opacity" => .7,
											"show_text_bg_image" => "yes",
											"show_full_text_without_hover" => "no",
											"show_thumb_box_shadow" => "yes",
											"box_shadow_css" => "0px 2px 2px #555555",
											"show_reflection" => "yes",
											"reflection_height" => 60,
											"reflection_distance" => 0,
											"reflection_opacity" => .2,
											
											// controls settings
											"controls_max_width" => 940,
											"controls_height" => 31,
											"controls_position" => "bottom",
											"show_prev_btn" => "yes",
											"show_next_btn" => "yes",
											"disable_btns_mobile" => "no",
											"show_slideshow_btn" => "yes",
											"timer_color" => "#777777",
											"show_scrollbar" => "yes",
											"scrollbar_handler_width" => 300,
											"scrollbar_text_normal_color" => "#777777",
											"scrollbar_text_selected_color" => "#000000",
											"disable_scrollbar_mobile" => "yes",
											"enable_mouse_wheel" => "yes",
											
											//bullets navigation settings
											"show_bullets_navigation" => "no",
											"bullets_background_normal_color1" => "#fcfdfd",
											"bullets_background_normal_color2" => "#e4e4e4",
											"bullets_background_selected_color1" => "#000000",
											"bullets_background_selected_color2" => "#666666",
											"bullets_shadow" => "0px 0px 4px #888888",
											"bullets_normal_radius" => 7,
											"bullets_selected_radius" => 8,
											"space_between_bullets" => 16,
											"bullets_offset" => 14,
											
											// combobox settings
											"show_combobox" => "yes",
											"start_category" => 1,
											"select_label" => "SELECT CATEGORIES",
											"all_cats_label" => "All Categories",
											"show_all_cats" => "no",
											"combobox_pos" => "topright",
											"selector_bg_normal_color1" => "#FCFDFD",
											"selector_bg_normal_color2" => "#E4E4E4",
											"selector_bg_selected_color1" => "#A7A7A7",
											"selector_bg_selected_color2" => "#8E8E8E",
											"selector_text_normal_color" => "#8B8B8B",
											"selector_text_selected_color" => "#FFFFFF",
											"button_bg_normal_color1" => "#E7E7E7",
											"button_bg_normal_color2" => "#E7E7E7",
											"button_bg_selected_color1" => "#A7A7A7",
											"button_bg_selected_color2" => "#8E8E8E",
											"button_text_normal_color" => "#000000",
											"button_text_selected_color" => "#FFFFFF",
											"combobox_shadow_color" => "#000000",
											"combobox_horizontal_margins" => 12,
											"combobox_vertical_margins" => 12,
											"combobox_corner_radius" => 0,
											
											// lightbox settings
											"buttons_alignment" => "in",
											"item_box_shadow" => "none",
											"description_window_animation_type" => "opacity",
											"description_window_position" => "bottom",
											"slide_show_auto_play" => "no",
											"add_keyboard_support" => "yes",
											"show_close_button" => "yes",
											"show_share_button" => "yes",
											"show_zoom_button" => "yes",
											"show_slide_show_button" => "yes",
											"show_slide_show_animation" => "yes",
											"show_next_and_prev_buttons" => "yes",
											"show_next_and_prev_buttons_on_mobile" => "yes",
											"show_description_button" => "yes",
											"show_description_by_default" => "no",
											"video_show_full_screen_button" => "yes",
											"video_auto_play" => "yes",
											"next_video_or_audio_auto_play" => "yes",
											"video_loop" => "no",
											"audio_auto_play" =>"no",
											"audio_loop" => "no",
											"background_opacity" => 0.9,
											"description_window_background_opacity" => 0.95,
											"buttons_hide_delay" => 3,
											"slide_show_delay" => 4,
											"default_item_width" => 640,
											"default_item_height" => 480,
											"item_offset_height" => 50,
											"space_between_buttons" => 1,
											"buttons_offset_in" => 2,
											"buttons_offset_out" =>5,
											"item_border_size" => 5,
											"item_border_radius" => 0,
											"item_background_color" => "#333333",
											"item_border_color1" => "#fcfdfd",
											"item_border_color2" => "#e4e4e4",
											"light_box_background_color" => "#000000",
											"description_window_background_color" => "#FFFFFF",
											"video_poster_background_color" => "#0099FF",
											"video_controller_background_color" => "#FFFFFF",
											"audio_controller_background_color" => "#FFFFFF",
											"time_color" => "#000000"
										 ),
									array(
											// main settings
											"id" => 1,
											"name" => "skin_modern_warm",	
											"display_type" => "fluidwidth",
											"autoscale" => "yes",
											"cov_width" => 940,
											"cov_height" => 538,
											"skin_path" => "skin_modern_warm",
											"cov_bg_color" => "#DDDDDD",
											"cov_bg_image_url" => "",
											"thumbs_bg_image_url" => $this->_dir_url . "load/skin_modern_warm/main_skin/thumbnailsBackground.jpg",
											"scrollbar_bg_image_url" => $this->_dir_url . "load/skin_modern_warm/main_skin/scrollbarBackground.jpg",
											"bg_repeat" => "repeat-x",
											"car_topology" => "ring",
											"car_x_radius" => 600,
											"car_y_radius" => 0,
											"car_x_rot" => 10,
											"car_y_offset" => 0,
											"show_center_image" => "no",
											"center_image_url" => "",
											"center_image_y_offset" => 0,
											"show_2d_display" => "no",
											"cov_start_pos" => "center",
											"cov_autoplay" => "no",
											"cov_slideshow_delay" => 5000,
											"right_click_context_menu" => "developer",
											"cov_keyboard_support" => "yes",
											"fluid_width_z_index" => 1000,
											"show_large_next_and_prev_buttons" => "no",
											"large_next_and_prev_buttons_offest" => 15,
											"use_drag_and_swipe" =>"yes",
											
											// thumbs settings
											"thumb_width" => 400,
											"thumb_height" => 266,
											"thumb_border_size" => 10,
											"thumb_min_alpha" => .3,
											"thumb_bg_color" => "#999999",
											"thumb_border_color1" => "#FCFDFD",
											"thumb_border_color2" => "#E4E4E4",
											"transparent_images" => "no",
											"max_thumbs_mobile" => 13,
											"show_thumbs_gradient" => "yes",
											"show_thumbs_text" => "yes",
											"text_bg_color" => "#333333",
											"text_bg_opacity" => .7,
											"show_text_bg_image" => "yes",
											"show_full_text_without_hover" => "no",
											"show_thumb_box_shadow" => "yes",
											"box_shadow_css" => "0px 2px 2px #666666",
											"show_reflection" => "yes",
											"reflection_height" => 60,
											"reflection_distance" => 0,
											"reflection_opacity" => .2,
											
											// controls settings
											"controls_max_width" => 940,
											"controls_height" => 29,
											"controls_position" => "bottom",
											"show_prev_btn" => "yes",
											"show_next_btn" => "yes",
											"disable_btns_mobile" => "no",
											"show_slideshow_btn" => "yes",
											"timer_color" => "#777777",
											"show_scrollbar" => "yes",
											"scrollbar_handler_width" => 300,
											"scrollbar_text_normal_color" => "#777777",
											"scrollbar_text_selected_color" => "#000000",
											"disable_scrollbar_mobile" => "yes",
											"enable_mouse_wheel" => "yes",
											
											//bullets navigation settings
											"show_bullets_navigation" => "no",
											"bullets_background_normal_color1" => "#fcfdfd",
											"bullets_background_normal_color2" => "#e4e4e4",
											"bullets_background_selected_color1" => "#000000",
											"bullets_background_selected_color2" => "#666666",
											"bullets_shadow" => "0px 0px 4px #888888",
											"bullets_normal_radius" => 7,
											"bullets_selected_radius" => 8,
											"space_between_bullets" => 16,
											"bullets_offset" => 14,
											
											// combobox settings
											"show_combobox" => "yes",
											"start_category" => 1,
											"select_label" => "SELECT CATEGORIES",
											"all_cats_label" => "All Categories",
											"show_all_cats" => "no",
											"combobox_pos" => "topright",
											"selector_bg_normal_color1" => "#FFFFFF",
											"selector_bg_normal_color2" => "#FFFFFF",
											"selector_bg_selected_color1" => "#BAB8B4",
											"selector_bg_selected_color2" => "#A09E9A",
											"selector_text_normal_color" => "#8B8B8B",
											"selector_text_selected_color" => "#FFFFFF",
											"button_bg_normal_color1" => "#FFFFFF",
											"button_bg_normal_color2" => "#FFFFFF",
											"button_bg_selected_color1" => "#BAB8B4",
											"button_bg_selected_color2" => "#BAB8B4",
											"button_text_normal_color" => "#8B8B8B",
											"button_text_selected_color" => "#FFFFFF",
											"combobox_shadow_color" => "#999999",
											"combobox_horizontal_margins" => 12,
											"combobox_vertical_margins" => 12,
											"combobox_corner_radius" => 0,
											
											// lightbox settings
											"buttons_alignment" => "in",
											"item_box_shadow" => "none",
											"description_window_animation_type" => "opacity",
											"description_window_position" => "bottom",
											"slide_show_auto_play" => "no",
											"add_keyboard_support" => "yes",
											"show_close_button" => "yes",
											"show_share_button" => "yes",
											"show_zoom_button" => "yes",
											"show_slide_show_button" => "yes",
											"show_slide_show_animation" => "yes",
											"show_next_and_prev_buttons" => "yes",
											"show_next_and_prev_buttons_on_mobile" => "yes",
											"show_description_button" => "yes",
											"show_description_by_default" => "no",
											"video_show_full_screen_button" => "yes",
											"video_auto_play" => "yes",
											"next_video_or_audio_auto_play" => "yes",
											"video_loop" => "no",
											"audio_auto_play" =>"no",
											"audio_loop" => "no",
											"background_opacity" => 0.9,
											"description_window_background_opacity" => 0.95,
											"buttons_hide_delay" => 3,
											"slide_show_delay" => 4,
											"default_item_width" => 640,
											"default_item_height" => 480,
											"item_offset_height" => 50,
											"space_between_buttons" => 1,
											"buttons_offset_in" => 2,
											"buttons_offset_out" =>5,
											"item_border_size" => 5,
											"item_border_radius" => 0,
											"item_background_color" => "#333333",
											"item_border_color1" => "#FFFFFF",
											"item_border_color2" => "#dddddd",
											"light_box_background_color" => "#000000",
											"description_window_background_color" => "#FFFFFF",
											"video_poster_background_color" => "#0099FF",
											"video_controller_background_color" => "#FFFFFF",
											"audio_controller_background_color" => "#FFFFFF",
											"time_color" => "#000000"
										 ),
									array(
											// main settings
											"id" => 2,
											"name" => "minimal_classic_skin",	
											"display_type" => "fluidwidth",
											"autoscale" => "yes",
											"cov_width" => 940,
											"cov_height" => 538,
											"skin_path" => "minimal_classic_skin",
											"cov_bg_color" => "#333333",
											"cov_bg_image_url" => "",
											"thumbs_bg_image_url" => "",
											"scrollbar_bg_image_url" => $this->_dir_url . "load/minimal_classic_skin/main_skin/scrollbarBackground.jpg",
											"bg_repeat" => "repeat-x",
											"car_topology" => "ring",
											"car_x_radius" => 600,
											"car_y_radius" => 0,
											"car_x_rot" => 10,
											"car_y_offset" => 0,
											"show_center_image" => "no",
											"center_image_url" => "",
											"center_image_y_offset" => 0,
											"show_2d_display" => "no",
											"cov_start_pos" => "center",
											"cov_autoplay" => "no",
											"cov_slideshow_delay" => 5000,
											"right_click_context_menu" => "developer",
											"cov_keyboard_support" => "yes",
											"fluid_width_z_index" => 1000,
											"show_large_next_and_prev_buttons" => "no",
											"large_next_and_prev_buttons_offest" => 15,
											"use_drag_and_swipe" =>"yes",
											
											// thumbs settings
											"thumb_width" => 400,
											"thumb_height" => 266,
											"thumb_border_size" => 0,
											"thumb_min_alpha" => .3,
											"thumb_bg_color" => "#FFFFFF",
											"thumb_border_color1" => "#FFFFFF",
											"thumb_border_color2" => "#FFFFFF",
											"transparent_images" => "no",
											"max_thumbs_mobile" => 13,
											"show_thumbs_gradient" => "yes",
											"show_thumbs_text" => "yes",
											"text_bg_color" => "#FFFFFF",
											"text_bg_opacity" => .7,
											"show_text_bg_image" => "no",
											"show_full_text_without_hover" => "no",
											"show_thumb_box_shadow" => "yes",
											"box_shadow_css" => "0px 2px 2px #111111",
											"show_reflection" => "yes",
											"reflection_height" => 60,
											"reflection_distance" => 0,
											"reflection_opacity" => .2,
											
											//bullets navigation settings
											"show_bullets_navigation" => "no",
											"bullets_background_normal_color1" => "#333333",
											"bullets_background_normal_color2" => "#333333",
											"bullets_background_selected_color1" => "#FFFFFF",
											"bullets_background_selected_color2" => "#FFFFFF",
											"bullets_shadow" => "0px 0px 4px #888888",
											"bullets_normal_radius" => 7,
											"bullets_selected_radius" => 8,
											"space_between_bullets" => 16,
											"bullets_offset" => 14,
											
											// controls settings
											"controls_max_width" => 940,
											"controls_height" => 29,
											"controls_position" => "bottom",
											"show_prev_btn" => "yes",
											"show_next_btn" => "yes",
											"disable_btns_mobile" => "no",
											"show_slideshow_btn" => "yes",
											"timer_color" => "#777777",
											"show_scrollbar" => "yes",
											"scrollbar_handler_width" => 300,
											"scrollbar_text_normal_color" => "#000000",
											"scrollbar_text_selected_color" => "#FFFFFF",
											"disable_scrollbar_mobile" => "yes",
											"enable_mouse_wheel" => "yes",
											
											// combobox settings
											"show_combobox" => "yes",
											"start_category" => 1,
											"select_label" => "SELECT CATEGORIES",
											"all_cats_label" => "All Categories",
											"show_all_cats" => "no",
											"combobox_pos" => "topright",
											"selector_bg_normal_color1" => "#FFFFFF",
											"selector_bg_normal_color2" => "#FFFFFF",
											"selector_bg_selected_color1" => "#000000",
											"selector_bg_selected_color2" => "#000000",
											"selector_text_normal_color" => "#000000",
											"selector_text_selected_color" => "#FFFFFF",
											"button_bg_normal_color1" => "#FFFFFF",
											"button_bg_normal_color2" => "#FFFFFF",
											"button_bg_selected_color1" => "#000000",
											"button_bg_selected_color2" => "#000000",
											"button_text_normal_color" => "#000000",
											"button_text_selected_color" => "#FFFFFF",
											"combobox_shadow_color" => "#222222",
											"combobox_horizontal_margins" => 12,
											"combobox_vertical_margins" => 12,
											"combobox_corner_radius" => 0,
											
											// lightbox settings
											"buttons_alignment" => "in",
											"item_box_shadow" => "none",
											"description_window_animation_type" => "opacity",
											"description_window_position" => "bottom",
											"slide_show_auto_play" => "no",
											"add_keyboard_support" => "yes",
											"show_close_button" => "yes",
											"show_share_button" => "yes",
											"show_zoom_button" => "yes",
											"show_slide_show_button" => "yes",
											"show_slide_show_animation" => "yes",
											"show_next_and_prev_buttons" => "yes",
											"show_next_and_prev_buttons_on_mobile" => "yes",
											"show_description_button" => "yes",
											"show_description_by_default" => "no",
											"video_show_full_screen_button" => "yes",
											"video_auto_play" => "yes",
											"next_video_or_audio_auto_play" => "yes",
											"video_loop" => "no",
											"audio_auto_play" =>"no",
											"audio_loop" => "no",
											"background_opacity" => 0.9,
											"description_window_background_opacity" => 0.95,
											"buttons_hide_delay" => 3,
											"slide_show_delay" => 4,
											"default_item_width" => 640,
											"default_item_height" => 480,
											"item_offset_height" => 50,
											"space_between_buttons" => 1,
											"buttons_offset_in" => 2,
											"buttons_offset_out" =>5,
											"item_border_size" => 0,
											"item_border_radius" => 0,
											"item_background_color" => "#333333",
											"item_border_color1" => "#000000",
											"item_border_color2" => "#000000",
											"light_box_background_color" => "#000000",
											"description_window_background_color" => "#FFFFFF",
											"video_poster_background_color" => "#0099FF",
											"video_controller_background_color" => "#FFFFFF",
											"audio_controller_background_color" => "#FFFFFF",
											"time_color" => "#000000"
										 )
							      );
    }

    public function get_data(){
	    $cur_data = get_option("fwdu3dcar_data");
	       
	    $this->settings_ar = $cur_data->settings_ar;
	    $this->playlists_ar = $cur_data->playlists_ar;
    }
    
    public function set_data(){
    	update_option("fwdu3dcar_data", $this);
    }
}

?>