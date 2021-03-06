<?php

/**
 * The class that prepares the meta box for the builder.
 *
 * @link       htto://www.neweb.info
 * @since      1.0.0
 *
 * @package    Rexbuilder
 * @subpackage Rexbuilder/admin
 */

/**
 * Defines the characteristics of the MetaBox
 *
 * @package    Rexbuilder
 * @subpackage Rexbuilder/admin
 * @author     Neweb <info@neweb.info>
 *
 */
class Rexbuilder_Meta_Box {

	private $id;
	private $title;
	private $post_type;
	private $context;
	private $priority;
	private $custom_classes;

	private $fields = array();

	private $plugin_name;

	public function __construct( $pname, $i, $t, $p = 'page', $c = 'normal', $pr = 'default', $cc = '' ) {
		$this->plugin_name = $pname;

		$this->id = $i;
		$this->title = $t;
		$this->post_type = $p;
		$this->context = $c;
		$this->priority = $pr;
		$this->custom_classes = $cc;

		add_action( 'add_meta_boxes', array( $this, 'define_builder_metabox' ) );
		add_action( 'save_post', array( $this, 'save_builder_meta' ) );

		add_filter( 'postbox_classes_' . $this->post_type . '_' . $this->id, array( $this, 'add_metabox_class' ) );
	}

	public function add_fields( $args ) {
		foreach( $args as $arg ) {
			array_push( $this->fields, $arg );
		}
	}

	public function define_builder_metabox() {
		add_meta_box(
			$this->id,
			$this->title,
			array( $this, 'display_builder_meta_box' ),
			$this->post_type,
			$this->context,
			$this->priority
		);
	}

	/**
	 *	Method that adds a custom class to the meta box
	 */
	public function add_metabox_class() {
		$classes[] = $this->custom_classes;
		return $classes;
	}

	public function display_builder_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'rexbuilder_meta_nonce' );

		ob_start();
		?>
		<table class='form-table context-<?php echo $this->context; ?>'>
		<?php

		foreach($this->fields as $field) :
			$meta = get_post_meta( $post->ID, $field['id'], true );

			$pattern = get_shortcode_regex();

			switch( $field['type']) {
				case 'rexbuilder_header':
		?>
		<tr id="rexbuilder-header">
				<td class="row valign-wrapper">
					<div class="col s4">
						<button id="rex-open-ace-css-editor" class="btn-floating tooltipped" data-position="bottom" data-tooltip="<?php _e('CSS Editor', $this->plugin_name); ?>">
							<i class="material-icons">&#xE314;</i><span>CSS</span><i class="material-icons">&#xE315;</i>
						</button>
						<textarea style="display:none;" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>"><?php if('' !== ($meta)) { echo htmlspecialchars($meta); } ?></textarea>
					</div>
					<div class="col s4 center-align">
						<a href="http://rexpansive.neweb.info/" title="Rexpansive" target="_blank">
							<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/ico-rexpansive.png" alt="Rexpansive" width="40">
						</a>
					</div>
					<div class="col s4"></div>
				</td>
			</tr>
		<?php
					break;
				case 'rexpansive_plugin':
		?>
			<tr>
				<input type="hidden" 
					name="<?php echo $field['id']; ?>" 
					id="<?php echo $field['id']; ?>"
					value='<?php if( '' !== ( $meta ) ) { echo htmlspecialchars( $meta ); } ?>'>
				<td id="builder-area">
				<?php
					//Retrieve the post content
					$checkbox_index = 0;
					$contents = get_post( $post->ID )->post_content;
					preg_match_all( "/$pattern/", $contents, $result_rows);

					if( !empty( $result_rows[2] ) ) :		// If there isn't content that suits for the builder, go on
						
						foreach( $result_rows[2] as $i => $section ) :
							if( $section == 'RexpansiveSection') :

								$section_content = $result_rows[5][$i];
								$section_attr = shortcode_parse_atts( trim( $result_rows[3][$i] ) );
								
								$section_bg_setts = array(
									'color' 	=> '',
									'image' 	=> '',
									'url' 		=> '',
									'video'		=>	'',
									'youtube'	=>	'',
								);

								$section_bg_style = '';
								$section_bg_button_preview_style = '';

								if( '' != $section_attr['color_bg_section'] ) {
									$section_bg_style = ' style="';
									$section_bg_style .= 'background-color:' . $section_attr['color_bg_section'];
									$section_bg_setts['color'] = $section_attr['color_bg_section'];
									$section_bg_style .= ';"';
									$section_bg_button_preview_style .= ' style="background-color:' . $section_attr['color_bg_section'] . ';background-image:none;" ';
								} else if( '' != $section_attr['image_bg_section'] ) {
									$section_bg_style = ' style="';
									$section_bg_style .= 'background-image:url(' . wp_get_attachment_url( $section_attr['id_image_bg_section'] ) . ')';
									$section_bg_setts['image'] = $section_attr['id_image_bg_section'];
									$section_bg_setts['url'] = $section_attr['image_bg_section'];
									$section_bg_style .= ';"';
									$section_bg_button_preview_style .= ' style="background-image:url(' . wp_get_attachment_url( $section_attr['id_image_bg_section'] ) . ');" ';
								}

								if(array_key_exists('video_bg_id_section', $section_attr) && $section_attr['video_bg_id_section'] != 'undefined') :
									$section_bg_setts['video'] = $section_attr['video_bg_id_section'];
								endif;

								if(array_key_exists('video_bg_url_section', $section_attr) && $section_attr['video_bg_url_section'] != 'undefined') :
									$section_bg_setts['youtube'] = $section_attr['video_bg_url_section'];
								endif;

								$section_bg_setts = json_encode( $section_bg_setts );

								$section_dimension = '';
								if( '' != $section_attr['dimension'] ) {
									$section_dimension = $section_attr['dimension'];
								}

								$background_responsive = array(
									//'r' => '255',
									//'g' => '255',
									//'b' => '255',
									//'a' => '0',
									'gutter' => '20',
									'isFull' => '',
									'custom_classes' => '',
									'section_width'	=>	'',
								);

								$section_has_overlay = false;
								$section_overlay_style = '';

								$section_overlay_color = '';

								if( array_key_exists( 'responsive_background', $section_attr ) && '' != $section_attr['responsive_background'] ) {
									//$background_responsive['section_overlay_color'] = $section_attr['responsive_background'];
									$section_overlay_color = $section_attr['responsive_background'];

									/*$x = ltrim( $section_attr['responsive_background'], 'rgba(');
									$x = rtrim( $x, ')');
									$x = explode(',', $x);
									$background_responsive['r'] = $x[0];
									$background_responsive['g'] = $x[1];
									$background_responsive['b'] = $x[2];
									$background_responsive['a'] = $x[3];*/
								}
									//var_dump(json_encode($background_responsive));
								if( array_key_exists( 'block_distance', $section_attr ) && '' != $section_attr['block_distance'] ) {
									$background_responsive['gutter'] = $section_attr['block_distance'];
								}
								if( array_key_exists( 'full_height', $section_attr ) && '' != $section_attr['full_height'] ) {
										$background_responsive['isFull'] = $section_attr['full_height'];
									}
								if( array_key_exists( 'custom_classes', $section_attr ) && '' != $section_attr['custom_classes'] ) {
									$background_responsive['custom_classes'] = $section_attr['custom_classes'];
									$section_overlay_classes = preg_match_all("/active-(small|medium|large)-overlay/", $section_attr['custom_classes'], $foo);
									if($section_overlay_classes > 0) :
										$section_has_overlay = true;
										/*$section_overlay_style = ' style="background-color:rgba('
											. $background_responsive['r'] . ','
											. $background_responsive['g'] . ','
											. $background_responsive['b'] . ','
											. $background_responsive['a']
											. ')"';*/
										$section_overlay_style = ' style="background-color:' . $section_overlay_color . ';"';
									endif;
								}
								if( array_key_exists( 'section_width', $section_attr ) && '' != $section_attr['section_width'] ) {
									$background_responsive['section_width'] = $section_attr['section_width'];
								}

								/*$navigation_settings = array(
									'section_id' => '',
									'icon_id' => '',
									'icon_url' => '',
									'image_id' => '',
									'image_url' => '',
								);

								if( isset( $navigation_global_settings[$i] ) ) {
									$temp = json_decode( $navigation_global_settings[$i] );
									$navigation_settings['section_id'] = $temp->section_id;
									$navigation_settings['icon_id'] = $temp->icon_id;
									$navigation_settings['icon_url'] = $temp->icon_url;
									$navigation_settings['image_id'] = $temp->image_id;
									$navigation_settings['image_url'] = $temp->image_url;
								}*/

								$custom_section_name = '';
								if(array_key_exists('section_name', $section_attr) && $section_attr['section_name'] != 'undefined') :
									$custom_section_name = $section_attr['section_name'];
								endif;

								?>
								<div class="builder-row clearfix z-depth-1" data-count="" data-gridcontent='' data-gridproperties='<?php echo $section_bg_setts; ?>' data-griddimension='<?php echo $section_dimension; ?>' data-layout='<?php echo $section_attr['layout']; ?>' data-section-overlay-color="<?php echo $section_overlay_color; ?>" data-sectionid='<?php echo $custom_section_name; ?>' data-backresponsive='<?php echo htmlspecialchars(json_encode($background_responsive)); ?>' data-row-separator-top="<?php echo ( isset( $section_attr['row_separator_top'] ) ? $section_attr['row_separator_top'] : '' ); ?>" data-row-separator-bottom="<?php echo ( isset( $section_attr['row_separator_bottom'] ) ? $section_attr['row_separator_bottom'] : '' ); ?>" data-row-separator-right="<?php echo ( isset( $section_attr['row_separator_right'] ) ? $section_attr['row_separator_right'] : '' ); ?>" data-row-separator-left="<?php echo ( isset( $section_attr['row_separator_left'] ) ? $section_attr['row_separator_left'] : '' ); ?>" data-section-active-photoswipe="<?php echo ( isset( $section_attr['row_active_photoswipe'] ) ? $section_attr['row_active_photoswipe'] : '' ); ?>">
									<div class="builder-row-contents">
										<div class="builder-edit-row-header">
											<button class="btn-floating builder-delete-row waves-effect waves-light grey darken-2 tooltipped" data-position="bottom" data-tooltip="<?php _e('Delete row', 'rexspansive'); ?>">
												<i class="material-icons white-text">&#xE5CD;</i>
											</button>
										</div>
										<div class="builder-edit-row-wrap clearfix row valign-wrapper">
											<div class="col s4 rex-edit-dimension-wrap valign-wrapper">
												<div>
													<input type="radio" 
														id="section-full-<?php echo $checkbox_index; ?>" 
														name="section-dimension-<?php echo $checkbox_index; ?>" 
														class="builder-edit-row-dimension with-gap" 
														value="full" title="Full"
													<?php
													checked( $section_attr['dimension'], 'full', 1 );
													?> />
													<label for="section-full-<?php echo $checkbox_index; ?>" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full', $this->plugin_name ); ?>">
														<!--<i class="material-icons">&#xE30B;</i>-->
														<i class="material-icons rex-icon">v<span class="rex-ripple"></span></i>
													</label>
												</div>
												<div>
													<input id="section-boxed-<?php echo $checkbox_index; ?>" type="radio" 
														name="section-dimension-<?php echo $checkbox_index; ?>" 
														class="builder-edit-row-dimension with-gap" value="boxed" title="Boxed"
													<?php
													checked( $section_attr['dimension'], 'boxed', 1 );
													?> />
													<label for="section-boxed-<?php echo $checkbox_index; ?>" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Boxed', $this->plugin_name ); ?>">
														<!--<i class="material-icons">&#xE30C;</i>-->
														<i class="material-icons rex-icon">t<span class="rex-ripple"></span></i>
													</label>
												</div>
												<div class="rex-edit-layout-wrap" style="display:none;">
													<input id="section-fixed-<?php echo $checkbox_index; ?>" type="radio" 
														name="section-layout-<?php echo $checkbox_index; ?>" 
														class="builder-edit-row-layout with-gap" value="fixed" title="Fixed"
													<?php
													checked( $section_attr['layout'], 'fixed', 1 );
													?> />
													<label for="section-fixed-<?php echo $checkbox_index; ?>" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Grid Layout', $this->plugin_name ); ?>">
														<i class="material-icons">&#xE8F1;<span class="rex-ripple"></span></i>
													</label>
													<input id="section-masonry-<?php echo $checkbox_index; ?>" type="radio" 
														name="section-layout-<?php echo $checkbox_index; ?>" 
														class="builder-edit-row-layout with-gap" value="masonry" title="Masonry"
													<?php
													checked( $section_attr['layout'], 'masonry', 1 );
													?> />
													<label for="section-masonry-<?php echo $checkbox_index; ?>" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Masonry Layout', $this->plugin_name ); ?>">
														<i class="material-icons">&#xE871;<span class="rex-ripple"></span></i>
													</label>
												</div>

											</div>

											<div class="builder-buttons col s4 center-align">
												<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="image" data-position="bottom" data-tooltip="<?php _e( 'Image', 'rexspansive' ); ?>">
													<i class="material-icons rex-icon">p</i>
												</button>
												<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="text" data-position="bottom" data-tooltip="<?php _e( 'Text', 'rexspansive' ); ?>">
													<i class="material-icons rex-icon">u</i>
												</button>
												<div class="builder-fab-row-widgets fixed-action-btn horizontal">
													<button class="builder-add btn-floating builder-show-widgets waves-effect waves-light light-blue darken-3">
														<i class="material-icons">add</i>
													</button>
													<ul>
														<li>
															<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="video" data-position="bottom" data-tooltip="<?php _e( 'Video', 'rexpansive' ); ?>">
																<i class="material-icons">play_arrow</i>
															</button>
														</li>
														<li>
															<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="empty" data-position="bottom" data-tooltip="<?php _e( 'Block space', 'rexspansive' ); ?>">
																<i class="material-icons rex-icon">H</i>
															</button>
														</li>
														<!-- <li>
															<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="textfill" data-position="bottom" data-tooltip="<?php _e( 'TextFill', 'rexspansive' ); ?>">
																<span style="color:white;">T</span>
															</button>
														</li> -->
													</ul>
												</div>
											</div>
											
											<!-- Icon button -->
											<div class="col s4 right-align builder-setting-buttons">
												<div class="background_section_preview btn-floating tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Row background', 'rexspansive' ); ?>"<?php echo $section_bg_button_preview_style; ?>></div>
												<button class="btn-floating builder-section-config tooltipped waves-effect waves-light" data-position="bottom" data-tooltip="<?php _e('Row settings', 'rexspansive'); ?>">
													<i class="material-icons">&#xE8B8;</i>
												</button>
												<div class="btn-flat builder-copy-row tooltipped" data-position="bottom" data-tooltip="<?php _e('Copy row', 'rexspansive'); ?>">
													<i class="material-icons grey-text text-darken-2">&#xE14D;</i>
												</div>
												<div class="btn-flat builder-move-row tooltipped" data-position="bottom" data-tooltip="<?php _e('Move row', 'rexspansive'); ?>">
													<i class="material-icons grey-text text-darken-2">&#xE8D5;</i>
												</div>
											</div>
										</div>
										<div class="builder-row-edit">
											
											<div class="builder-elements">
												<div class="gridster">
													<ul <?php echo $section_bg_style; ?>>
														<?php
															if( !empty( $section_content ) ) :
																preg_match_all( "/$pattern/", $section_content, $result_block);
																foreach( $result_block[3] as $i => $attrs ) :
																	$block_attr = shortcode_parse_atts( trim( $attrs ) );

																	// Prepare the background block settings

																	$background_block_setts = array(
																		'color' => '',
																		'image' => '',
																		'url' => '',
																		'bg_img_type' => '',
																		'image_size'	=>	'',
																		'photoswipe' => '',
																		'linkurl' => '',
																		'video'		=>	'',
																		'youtube'	=>	'',
																		'block_custom_class' => '',
																		'overlay_block_color' => '',
																	);
																	$style = ' style="';
																	$classEmpty = '';

																	if( isset( $block_attr['image_size'] ) && 'undefined' != $block_attr['image_size'] ) :
																		$background_block_setts['image_size'] = $block_attr['image_size'];
																		$img_attrs = wp_get_attachment_image_src( $block_attr['id_image_bg_block'], $block_attr['image_size'] );
																		$preview_image_url = $img_attrs[0];
																	else :
																		$background_block_setts['image_size'] = 'full';
																		$preview_image_url = $block_attr['image_bg_block'];
																	endif;

																	if( array_key_exists('image_bg_block', $block_attr) && array_key_exists('type_bg_block', $block_attr) && $block_attr['image_bg_block'] != '' && $block_attr['type_bg_block'] == 'full' ) {
																		$style .= 'background-image:url(' . $preview_image_url . ');';
																		$background_block_setts['image'] = $block_attr['id_image_bg_block'];
																		$background_block_setts['url'] = $block_attr['image_bg_block'];
																		$background_block_setts['bg_img_type'] = $block_attr['type_bg_block'];

																		$classEmpty = 'hidden';
																	} else if( array_key_exists('color_bg_block', $block_attr) && array_key_exists('type_bg_block', $block_attr) && $block_attr['color_bg_block'] != '' && $block_attr['type_bg_block'] != 'full' ) {
																		$style .= 'background-color:' . $block_attr['color_bg_block'] . ';';

																		if( array_key_exists('type_bg_block', $block_attr) && $block_attr['type_bg_block'] == 'natural' ) {
																			$style .= 'background-image:url(' . $preview_image_url . ');';
																		}

																		$background_block_setts['color'] = $block_attr['color_bg_block'];
																		$background_block_setts['image'] = $block_attr['id_image_bg_block'];
																		$background_block_setts['url'] = $block_attr['image_bg_block'];
																		$background_block_setts['bg_img_type'] = $block_attr['type_bg_block'];
																		$classEmpty = 'hidden';
																	} else if( array_key_exists('type_bg_block', $block_attr) && $block_attr['type_bg_block'] == 'natural' ) {
																			if( array_key_exists('color_bg_block', $block_attr) && array_key_exists('type_bg_block', $block_attr) && $block_attr['color_bg_block'] != '' && $block_attr['type_bg_block'] != 'full' ) {
																				$style .= 'background-color:' . $block_attr['color_bg_block'] . ';';
																			}
																		$style .= 'background-image:url(' . $preview_image_url . ');';
																		$background_block_setts['image'] = $block_attr['id_image_bg_block'];
																		$background_block_setts['url'] = $block_attr['image_bg_block'];
																		$background_block_setts['bg_img_type'] = $block_attr['type_bg_block'];

																		$classEmpty = 'hidden';
																	}

																	if(array_key_exists('video_bg_id', $block_attr) && $block_attr['video_bg_id'] != 'undefined') :
																		$background_block_setts['video'] = $block_attr['video_bg_id'];
																	else :
																		$background_block_setts['video'] = '';
																	endif;

																	if(array_key_exists('video_bg_url', $block_attr) && $block_attr['video_bg_url'] != 'undefined') :
																		$background_block_setts['youtube'] = $block_attr['video_bg_url'];
																	else :
																		$background_block_setts['youtube'] = '';
																	endif;

																	$video_has_audio = '0';
																	if(array_key_exists('video_has_audio', $block_attr) && $block_attr['video_has_audio'] != 'undefined') :
																		$video_has_audio =  $block_attr['video_has_audio'];
																	endif;

																	if(array_key_exists('photoswipe', $block_attr) && $block_attr['photoswipe'] != 'undefined') :
																		$background_block_setts['photoswipe'] = $block_attr['photoswipe'];
																	else :
																		$background_block_setts['photoswipe'] = '';
																	endif;

																	if(array_key_exists('linkurl', $block_attr) && $block_attr['linkurl'] != 'undefined') :
																		$background_block_setts['linkurl'] = $block_attr['linkurl'];
																	else :
																		$background_block_setts['linkurl'] = '';
																	endif;

																	$element_preview_position_classes = '';

																	if(array_key_exists('block_custom_class', $block_attr) && $block_attr['block_custom_class'] != 'undefined') :
																		$background_block_setts['block_custom_class'] = $block_attr['block_custom_class'];
																		$block_custom_classes = $block_attr['block_custom_class'];
																		$matches = preg_match_all("/rex-flex-(top|middle|bottom|left|center|right)/", $block_custom_classes, $content_position);
																		if($matches != 0) :
																			$element_preview_position_classes = ' element-content-positioned';
																			foreach ($content_position[0] as $key => $class) :
																				switch ($class) :
																					case 'rex-flex-top':
																						$element_preview_position_classes .= ' element-content-positioned-top';
																						break;
																					case 'rex-flex-middle':
																						$element_preview_position_classes .= ' element-content-positioned-middle';
																						break;
																					case 'rex-flex-bottom':
																						$element_preview_position_classes .= ' element-content-positioned-bottom';
																						break;
																					case 'rex-flex-left':
																						$element_preview_position_classes .= ' element-content-positioned-left';
																						break;
																					case 'rex-flex-center':
																						$element_preview_position_classes .= ' element-content-positioned-center';
																						break;
																					case 'rex-flex-right':
																						$element_preview_position_classes .= ' element-content-positioned-right';
																						break;
																					default:
																						break;
																				endswitch;
																			endforeach;
																		endif;
																	else :
																		$background_block_setts['block_custom_class'] = '';
																		$block_custom_classes = '';
																	endif;

																	if(array_key_exists('block_padding', $block_attr) && $block_attr['block_padding'] != 'undefined') :
																		$content_padding_settings = $block_attr['block_padding'];
																	else :
																		$content_padding_settings = '';
																	endif;

																	if(array_key_exists('overlay_block_color', $block_attr) && $block_attr['overlay_block_color'] != 'undefined') :
																		$background_block_setts['overlay_block_color'] = $block_attr['overlay_block_color'];
																	endif;

																	/*if( $block_attr['image_bg_block'] != '' ) {
																		$style .= 'background-image:url(' . $block_attr['image_bg_block'] . ');"';

																		$background_block_setts['image'] = $block_attr['id_image_bg_block'];
																		$background_block_setts['url'] = $block_attr['image_bg_block'];
																		$classEmpty = 'hidden';

																	} else if( $block_attr['color_bg_block'] != '' ) {
																		$style .= 'background-color:' . $block_attr['color_bg_block'];

																		$background_block_setts['color'] = $block_attr['color_bg_block'];
																		$classEmpty = 'hidden';

																	} else {
																	}*/
																	$style .= ';"';

																	$define_borders = ' with-border';
																	if( $background_block_setts['color'] != '' || ( $background_block_setts['image'] != '' && $background_block_setts['bg_img_type'] != 'natural' ) ) :
																		if( $background_block_setts['color'] != 'rgba(255,255,255,0)' ) :
																			$define_borders = ' no-border';
																		endif;
																	endif;

																	$temp_block_setts = $background_block_setts;

																	$background_block_setts = json_encode( $background_block_setts );

																	// Preapre the zak effect settings
																	$zak_effect_setts = array(
																		'side' => '',
																		'background_url' => '',
																		'background_id' => '',
																		'title' => '',
																		'icon_url' => '',
																		'icon_id' => '',
																		'content' => '',
																		'foreground_url' => '',
																		'foreground_id' => ''
																	);
																	if(array_key_exists('zak_side', $block_attr) && $block_attr['zak_side'] != 'undefined') {
																		$zak_effect_setts['side'] = $block_attr['zak_side'];
																	}

																	if(array_key_exists('zak_background', $block_attr) && $block_attr['zak_background'] != 'undefined') {
																		$zak_effect_setts['background_url'] = wp_get_attachment_url( $block_attr['zak_background'] );
																		$zak_effect_setts['background_id'] = $block_attr['zak_background'];
																	}

																	if(array_key_exists('zak_title', $block_attr) && $block_attr['zak_title'] != 'undefined') {
																		$zak_effect_setts['title'] = $block_attr['zak_title'];
																	}

																	if(array_key_exists('zak_icon', $block_attr) && $block_attr['zak_icon'] != 'undefined') {
																		$zak_effect_setts['icon_url'] = ( $block_attr['zak_icon'] ) ? wp_get_attachment_url( $block_attr['zak_icon'] ) : '';
																		$zak_effect_setts['icon_id'] = $block_attr['zak_icon'];
																	}
																	$zak_effect_setts['content'] = ($result_block[5][$i]);

																	if(array_key_exists('zak_foreground', $block_attr) && $block_attr['zak_foreground'] != 'undefined') :
																		//var_dump( $block_attr['zak_foreground'] );
																		//print_r( $block_attr['zak_foreground'] );
																		if( '' != $block_attr['zak_foreground'] ) :
																			$zak_effect_setts['foreground_url'] = wp_get_attachment_url( $block_attr['zak_foreground'] );
																			$zak_effect_setts['foreground_id'] = $block_attr['zak_foreground'];
																		endif;
																	endif;

																	//var_dump(mysql_real_escape_string($result_block[5][$i]));

																	$zak_effect_setts = json_encode( $zak_effect_setts );

																	$block_content = $result_block[5][$i];																				

																	$block_content = preg_replace('/^<\/p>/', '', $block_content);
																	$block_content = preg_replace('/<p>+$/', '', $block_content);
																	//$block_content = trim( $block_content );

																	// $block_has_textfill = preg_match_all('/\[(\[?)(TextFill)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $block_content);

																	// if( 'text' == $block_attr['type'] && 0 != $block_has_textfill ) {
																	// 	$block_attr['type'] = 'textfill';
																	// }
																	
																	?>
																		<li id="<?php echo $block_attr['id']; ?>" class="<?php echo $block_attr['type']; echo $define_borders; ?> item z-depth-1 hoverable svg-ripple-effect<?php if( $block_attr['type_bg_block'] == 'natural') : echo ' block-is-natural'; endif; ?>" data-block_type="<?php echo $block_attr['type']; ?>" data-col="<?php echo $block_attr['col']; ?>" data-row="<?php echo $block_attr['row']; ?>" data-sizex="<?php echo $block_attr['size_x']; ?>" data-sizey="<?php echo $block_attr['size_y']; ?>" data-bg_settings='<?php echo $background_block_setts; ?>' data-block-custom-classes="<?php echo $block_custom_classes; ?>" data-content-padding="<?php echo $content_padding_settings; ?>" data-video-has-audio="<?php echo $video_has_audio; ?>">
																			<div class="element-actions">
																				<div class="builder-fab-row-widgets actions-center-icons fixed-action-btn horizontal">
																					<button class="btn-floating builder-show-widgets waves-effect waves-light light-blue darken-3">
																						<i class="material-icons">add</i>
																					</button>
																					<ul>
																						<li class="edit_handler btn-floating waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="<?php _e('Text', 'rexpansive'); ?>">
																							<i class="material-icons rex-icon">u</i>
																						</li>
																						<li class="background_handler btn-floating waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="<?php _e('Block settings', 'rexpansive'); ?>">
																							<i class="material-icons">&#xE8B8;</i>
																						</li>
																						<li class="copy-handler btn-floating grey darken-2 tooltipped" data-position="bottom" data-tooltip="<?php _e('Copy block', 'rexpansive'); ?>">
																							<i class="material-icons white-text">&#xE14D;</i>
																						</li>
																					</ul>
																				</div>
																				<div class="actions-center-icons">
																					<div class="edit_handler btn-floating waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="<?php _e('Text', 'rexpansive'); ?>">
																						<i class="material-icons rex-icon">u</i>
																					</div>
																					<div class="background_handler btn-floating waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="<?php _e('Block settings', 'rexpansive'); ?>">
																						<i class="material-icons">&#xE8B8;</i>
																					</div>
																					<br>
																					<div class="copy-handler btn-floating grey darken-2 tooltipped" data-position="bottom" data-tooltip="<?php _e('Copy block', 'rexpansive'); ?>">
																						<i class="material-icons white-text">&#xE14D;</i>
																					</div>
																				</div>
																				<div class="delete_handler btn-floating waves-effect waves-light grey darken-2 tooltipped" data-position="bottom" data-tooltip="<?php _e('Delete block', 'rexpansive'); ?>">
																					<i class="material-icons white-text">&#xE5CD;</i>
																				</div>
																			</div>
																			<?php
																				switch( $block_attr['type'] ) {
																					case 'image':
																			?>
																						<div class="element-data">
																							<textarea class="data-text-content" display="none"><?php echo $block_content; ?></textarea>
																						</div>
																						<div class="element-preview-wrap<?php echo $element_preview_position_classes; ?>"<?php echo $style; ?>>
																							<div class="element-preview">
																								<?php 
																									if( $block_attr['type_bg_block'] == '' && $block_attr['color_bg_block'] == '' ) { 
																										$control = true;
																									} else {
																										$control = false;
																									}
																								?>
																								<div class="backend-image-preview" data-image_id="<?php $block_attr['id_image_bg_block']; ?>" <?php if($control) { echo 'style="display:none;"'; } ?>>
																									<?php echo $block_content; ?>
																								</div>
																							</div>
																						</div>
																			<?php
																						break;
																					case 'text':
																					case 'textfill':
																			?>
																						<div class="element-data">
																							<textarea class="data-text-content" display="none"><?php echo $block_content; ?></textarea>
																						</div>
																						<div class="element-preview-wrap<?php echo $element_preview_position_classes; ?>"<?php echo $style; ?>>
																							<div class="element-preview"><?php echo $block_content; ?></div>
																						</div>
																			<?php
																						break;
																					case 'empty':
																			?>
																						<div class="element-data">
																							<textarea class="data-text-content" display="none"><?php echo $block_content; ?></textarea>
																						</div>
																						<div class="element-preview-wrap<?php echo $element_preview_position_classes; ?>"<?php if($style) { echo $style; } ?>>
																							<div class="element-preview">
																								<div class="element-preview"><?php echo $block_content; ?></div>
																							</div>
																						</div>
																			<?php
																						break;
																					case 'video':
																			?>
																						<div class="element-data">
																							<textarea class="data-text-content" display="none"><?php echo $block_content; ?></textarea>	
																						</div>
																						<div class="element-preview-wrap<?php echo $element_preview_position_classes; ?>"<?php echo $style; ?>>
																							<div class="element-preview"><?php echo $block_content; ?></div>	
																						</div>
																			<?php
																						break;	
																					case 'expand':
																			?>
																						<div class="element-data">
																							<input class="data-zak-content" type="hidden" <?php echo 'data-zak-content=\'' . $zak_effect_setts . '\'' ?>>
																						</div>
																						<div class="element-preview"<?php echo $style; ?>>
																							<?php
																								if( 'left' == $block_attr['zak_side'] ) :
																							?>
																								<div class="zak-block zak-image-side">
																									<img src="<?php echo wp_get_attachment_url( $block_attr['zak_background'] ); ?>">
																								</div>
																								<div class="zak-block zak-text-side">
																									<h2><?php echo $block_attr['zak_title']; ?></h2>
																									<?php if( $block_attr['zak_icon'] ) : ?>
																										<img src="<?php echo wp_get_attachment_url( $block_attr['zak_icon'] ); ?>" alt="">
																									<?php endif; ?>
																									<div class="text-preview"><?php echo $block_content; ?></div>
																								</div>
																							<?php
																								else :
																							?>
																								<div class="zak-block zak-text-side">
																									<h2><?php echo $block_attr['zak_title']; ?></h2>
																									<?php if( $block_attr['zak_icon'] ) : ?>
																										<img src="<?php echo wp_get_attachment_url( $block_attr['zak_icon'] ); ?>" alt="">
																									<?php endif; ?>
																									<div class="text-preview"><?php echo $block_content; ?></div>
																								</div>
																								<div class="zak-block zak-image-side">
																									<img src="<?php echo wp_get_attachment_url( $block_attr['zak_background'] ); ?>">
																								</div>
																							<?php
																								endif;
																							?>
																						</div>
																			<?php
																						break;
																					case 'default':
																						break;
																				}
																	?>
<div class="element-visual-info<?php
	if('' != $temp_block_setts['youtube'] || '' != $temp_block_setts['video']) :
		echo ' ' . 'rex-active-video-notice';
	endif;
?>"<?php 
	if( '' != $temp_block_setts['overlay_block_color'] ) :
		echo ' style="background-color:' . $temp_block_setts['overlay_block_color'] . '"';
	endif;
?>>
	<div class="vert-wrap">
		<div class="vert-elem">
			<i class="material-icons rex-icon rex-notice rex-video-notice">G</i>
		</div>
	</div>
</div>
<div class="el-visual-size"><span><?php echo $block_attr['size_x'] . 'x' . $block_attr['size_y']; ?></span></div>
																		</li>
																	<?php
																endforeach;
															endif; ?>
													</ul>
													<div class="section-visual-info<?php if($section_has_overlay) echo ' active-section-visual-info'; ?>"<?php if($section_has_overlay) echo $section_overlay_style; ?>></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								$checkbox_index++;
							endif;
						endforeach;
					else :
						$defaultsectionproperties = json_encode( array(
							"color"			=>	"",
							"image"			=>	"",
							"url"			=>	"",
							"bg_img_type"	=>	"",
							"video"			=>	"",
							"youtube"		=>	"",
						) );
						$defaultidproperties = json_encode( array(
							"section_id"	=>	"",
							"icon_id"		=>	"",
							"icon_url"		=>	"",
							"image_id"		=>	"",
							"image_url"		=>	"",
						) );
						$defaultsectionconfigs = json_encode(array(
							'gutter' => '20',
							'custom_classes' => '',
							'section_width'	=>	'',
						));
					?>
<div class="builder-row builder-new-row clearfix z-depth-1" data-count="0" data-gridcontent="" data-gridproperties="<?php echo htmlspecialchars( $defaultsectionproperties ); ?>" data-griddimension="full" data-layout="fixed" data-sectionid="" data-section-overlay-color="" data-backresponsive="<?php echo htmlspecialchars( $defaultsectionconfigs ); ?>" data-row-separator-top="" data-row-separator-bottom="" data-row-separator-right="" data-row-separator-left="" data-section-active-photoswipe="">
	<div class="builder-row-contents">
		<div class="builder-edit-row-header">
			<button class="btn-floating builder-delete-row waves-effect waves-light grey darken-2 tooltipped" data-position="bottom" data-tooltip="<?php _e('Delete row', 'rexspansive'); ?>">
				<i class="material-icons white-text">&#xE5CD;</i>
			</button>
		</div>
		<div class="builder-edit-row-wrap clearfix row valign-wrapper">
			<div class="col s4">
				<div class="rex-edit-dimension-wrap">
					<input id="section-full-0" type="radio" 
						name="section-dimension-0" 
						class="builder-edit-row-dimension with-gap" value="full" checked title="Full" />
					<label for="section-full-0" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full', $this->plugin_name ); ?>">
						<!--<i class="material-icons">&#xE30B;</i>-->
						<i class="material-icons rex-icon">v<span class="rex-ripple"></i>
					</label>
					<input id="section-boxed-0" type="radio" 
						name="section-dimension-0" 
						class="builder-edit-row-dimension with-gap" value="boxed" title="Boxed" />
					<label for="section-boxed-0" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Boxed', $this->plugin_name ); ?>">
						<!--<i class="material-icons">&#xE30C;</i>-->
						<i class="material-icons rex-icon">t<span class="rex-ripple"></i>
					</label>
				</div>
				<div class="rex-edit-layout-wrap" style="display:none;">
					<input id="section-fixed-0" type="radio" 
						name="section-layout-0" 
						class="builder-edit-row-layout with-gap" value="fixed" checked title="Grid Layout" />
					<label for="section-fixed-0" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Grid Layout', $this->plugin_name ); ?>">
						<i class="material-icons">&#xE8F1;<span class="rex-ripple"></span></i>
					</label>
					<input id="section-masonry-0" type="radio" 
						name="section-layout-0" 
						class="builder-edit-row-layout with-gap" value="masonry" title="Masonry Layout" />
					<label for="section-masonry-0"  class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Masonry Layout', $this->plugin_name ); ?>">
						<i class="material-icons">&#xE871;<span class="rex-ripple"></span></i>
					</label>
				</div>
			</div>
			
			<div class="builder-buttons col s4 center-align">
				<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="image" data-position="bottom" data-tooltip="<?php _e( 'Image', $this->plugin_name ); ?>">
					<i class="material-icons rex-icon">p</i>
				</button>
				<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="text" data-position="bottom" data-tooltip="<?php _e( 'Text', $this->plugin_name ); ?>">
					<i class="material-icons rex-icon">u</i>
				</button>
				<div class="builder-fab-row-widgets fixed-action-btn horizontal">
					<button class="builder-add btn-floating builder-show-widgets waves-effect waves-light light-blue darken-3">
						<i class="material-icons">add</i>
					</button>
					<ul>
						<li>
							<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="video" data-position="bottom" data-tooltip="<?php _e( 'Video', $this->plugin_name ); ?>">
								<i class="material-icons">play_arrow</i>
							</button>
						</li>
						<li>
							<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="empty" data-position="bottom" data-tooltip="<?php _e( 'Block space', $this->plugin_name ); ?>">
								<i class="material-icons rex-icon">H</i>
							</button>
						</li>
						<!-- <li>
							<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="textfill" data-position="bottom" data-tooltip="<?php _e( 'TextFill', $this->plugin_name ); ?>">
								<span style="color:white;">T</span>
							</button>
						</li> -->
					</ul>
				</div>
			</div>
			
			<div class="col s4 right-align builder-setting-buttons">
				<div class="background_section_preview btn-floating tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Row background', $this->plugin_name ); ?>"></div>
				<button class="btn-floating builder-section-config tooltipped" data-position="bottom" data-tooltip="<?php _e('Row settings', $this->plugin_name); ?>">
					<i class="material-icons white-text">&#xE8B8;</i>
				</button>
				<div class="btn-flat builder-copy-row tooltipped" data-position="bottom" data-tooltip="<?php _e('Copy row', $this->plugin_name); ?>">
					<i class="material-icons grey-text text-darken-2">&#xE14D;</i>
				</div>
				<div class="btn-flat builder-move-row tooltipped" data-position="bottom" data-tooltip="<?php _e('Move row', $this->plugin_name); ?>">
					<i class="material-icons grey-text text-darken-2">&#xE8D5;</i>
				</div>
			</div>
		</div>
		<div class="builder-row-edit">
			<div class="builder-buttons-new-row col s3">
				<div>
					<button class="btn light-blue darken-1 builder-add waves-effect waves-light tooltipped" value="image" data-position="bottom" data-tooltip="<?php _e('Image', $this->plugin_name); ?>">
						<i class="material-icons rex-icon white-text">p</i>
					</button>
					<button class="btn light-blue darken-1 builder-add waves-effect waves-light tooltipped" value="text" data-position="bottom" data-tooltip="<?php _e('Text', $this->plugin_name); ?>">
						<i class="material-icons rex-icon white-text">u</i>
					</button>
					<br>
					<div class="builder-fab-row-widgets fixed-action-btn horizontal">
						<button class="builder-add btn-floating builder-show-widgets waves-effect waves-light light-blue darken-3">
							<i class="material-icons">add</i>
						</button>
						<ul>
							<li>
								<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="video" data-position="bottom" data-tooltip="<?php _e( 'Video', $this->plugin_name ); ?>">
									<i class="material-icons">play_arrow</i>
								</button>
							</li>
							<li>
								<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="empty" data-position="bottom" data-tooltip="<?php _e( 'Block space', $this->plugin_name ); ?>">
									<i class="material-icons rex-icon">H</i>
								</button>
							</li>
							<!-- <li>
								<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="textfill" data-position="bottom" data-tooltip="<?php _e( 'TextFill', $this->plugin_name ); ?>">
									<span style="color:white;">T</span>
								</button>
							</li> -->
						</ul>
					</div>
				</div>
			</div>
			<div class="builder-elements">
				<div class="gridster">
					<ul>
					</ul>
					<div class="section-visual-info"></div>
				</div>
			</div>
		</div>
	</div>
</div>
					
					<?php
						endif;
					?>
				</td>
			</tr>
			<tr>
				<td colspan="" rowspan="" headers="">
					<div class="builder-add-row-wrap">
						<button id="builder-add-row" class="builder-button btn-floating btn light-blue darken-1 waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Add row', $this->plugin_name ) ?>">
							<i class="material-icons text-white">&#xE145;</i>
						</button>
					</div>
				</td>
			</tr>

		<?php
				break;
			case 'hidden_field':
			?>
			<tr class="<?php echo $field['id']; ?>-wrap" style="display:none;">
				<td>
					<input type="hidden" 
						name="<?php echo $field['id']; ?>" 
						id="<?php echo $field['id']; ?>" 
						value="<?php echo ( $meta ? $meta : $field['default'] ); ?>">
				</td>
			</tr>
			<?php
				break;
			default:
				break;
		}
		endforeach;
		?>
		</table>
		<?php
		echo ob_get_clean();
	}

	public function save_builder_meta( $post_id ) {
		if( !isset( $_POST[ 'rexbuilder_meta_nonce' ] ) || 
			!wp_verify_nonce( $_POST[ 'rexbuilder_meta_nonce' ], basename( __FILE__ ) ) ) {
			return $post_id;
		}
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		$plugin_options = get_option( $this->plugin_name . '_options' );
		if( in_array( $_POST[ 'post_type' ], $plugin_options['post_types'] ) ) {
			if( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		foreach ( $this->fields as $field ) :

			$old = get_post_meta( $post_id, $field[ 'id' ], true );

			$new = $_POST[ $field[ 'id' ] ];

			if( $new && $new != $old ) {		
				update_post_meta( $post_id, $field[ 'id' ], $new );
			} elseif ( '' == $new && $old ) {
				delete_post_meta( $post_id, $field[ 'id' ], $old );
			}

		endforeach;
	}

	/**
	 *	Function usefull for save associative values on metaboxes
	 */
	public function array_push_assoc($array, $key, $value) {
		$array[$key] = $value;
		return $array;
	}
}