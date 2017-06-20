<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       htto://www.neweb.info
 * @since      1.0.0
 *
 * @package    Rexbuilder
 * @subpackage Rexbuilder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rexbuilder
 * @subpackage Rexbuilder/admin
 * @author     Neweb <info@neweb.info>
 */
class Rexbuilder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $plugin_options    The options of the plugin.
	 */
	private $plugin_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Rexbuilder       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->plugin_options = get_option( $this->plugin_name . '_options' );

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			// Call the construction of the metabox
			require_once plugin_dir_path( __FILE__ ) . '/class-rexbuilder-meta-box.php';

			foreach( $post_to_activate as $key => $value ) :

				if( 1 == $value ) :

					$page_builder = new Rexbuilder_Meta_Box( 
						$this->plugin_name,
						'rexbuilder', 
						'Rexpansive Builder', 
						$key, 
						'normal', 
						'high',
						'rexpansive-builder rexbuilder-materialize-wrap'
					);

					$page_builder->add_fields( array(
						array(
							'id' => '_rexbuilder_active',
							'type' => 'hidden_field',
							'default' => 'true',
						),
						/*array(
							'id'	=>	'_rexbuilder_photoswipe',
							'type'	=>	'hidden_field',
							'default'	=>	'0',
						),*/
						array(
							'label' => 'Rexbuilder Header',
							'desc'	=>	'',
							'id'	=>	'_rexbuilder_custom_css',
							'type'	=>	'rexbuilder_header'
						),
						array(
							'label' => 'Rexbuilder',
							'desc' => 'Expand your mind',
							'id' => '_rexbuilder',
							'type'	=>	'rexpansive_plugin',
						),
					) );

				endif;

			endforeach;

		endif;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rexbuilder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rexbuilder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_style( 'material-design-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );
					wp_enqueue_style( 'materialize', plugin_dir_url( __FILE__ ) . 'css/materialize.min.css', array(), $this->version, 'all' );
					
					wp_enqueue_style( 'spectrum-style', plugin_dir_url( __FILE__ ) . 'spectrum/spectrum.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'font-awesome-4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rex-custom-fonts', plugin_dir_url( __FILE__ ) . 'rexpansive-font/font.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'gridster-style', plugin_dir_url( __FILE__ ) . 'css/jquery.gridster.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'custom-editor-buttons-style', plugin_dir_url( __FILE__ ) . 'css/rex-custom-editor-buttons.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rexbuilder-style', plugin_dir_url( __FILE__ ) . 'css/builder.css', array(), $this->version, 'all' );
				endif;
			endif;
		endif;
	}

	/**
	 * Register the stylesheets for the admin area for production version
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_production( $hook ) {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :
			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_style( 'material-design-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $this->version, 'all' );

					wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'font-awesome-4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
					wp_enqueue_style( 'rex-custom-fonts', plugin_dir_url( __FILE__ ) . 'rexpansive-font/font.css', array(), $this->version, 'all' );

					wp_enqueue_style( 'admin-style', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
				endif;
			endif;
		endif;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rexbuilder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rexbuilder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Retrieve the page information
		// Get current screen works only from 3.1, but allows me to retrieve more specific information
		// compared to the $hook.
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_media();
					wp_enqueue_script('jquery');

					wp_enqueue_script( 'materialize-scripts', plugin_dir_url( __FILE__ ) . 'materialize/js/materialize.js', array('jquery'), $this->version, true );
					wp_enqueue_script( 'gridster', plugin_dir_url( __FILE__ ) . 'js/jquery.gridster.js', array('jquery'),  $this->version, true );
					
					wp_enqueue_script( 'spectrum-scripts', plugin_dir_url( __FILE__ ) . 'spectrum/spectrum.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'ace-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/ace.js', array('jquery'),  $this->version, true );
					wp_enqueue_script( 'ace-mode-css-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/mode-css.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'rexbuilder', plugin_dir_url( __FILE__ ) . 'js/rexbuilder.js', array('jquery'),  $this->version, true );
					wp_localize_script( 'rexbuilder', '_plugin_backend_settings', array(
						'activate_builder'	=>	'true',
					) );
					wp_enqueue_script( 'rexbuilder-admin', plugin_dir_url( __FILE__ ) . 'js/rexbuilder-admin.js', array( 'jquery' ), $this->version, true );
				endif;
			endif;
		endif;
	}

	/**
	 * Register the JavaScript for the admin area for production version
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts_production( $hook ) {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
					wp_enqueue_media();
					wp_enqueue_script('jquery');

					wp_enqueue_script( 'ace-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/ace.js', array('jquery'),  $this->version, true );
					wp_enqueue_script( 'ace-mode-css-scripts', plugin_dir_url( __FILE__ ) . 'ace/src-min-noconflict/mode-css.js', array('jquery'),  $this->version, true );

					wp_enqueue_script( 'admin-plugins', plugin_dir_url( __FILE__ ) . 'js/plugins.js', array('jquery'),  $this->version, true );
					wp_localize_script( 'admin-plugins', '_plugin_backend_settings', array(
						'activate_builder'	=>	'true',
					) );
					wp_enqueue_script( 'rexbuilder-admin', plugin_dir_url( __FILE__ ) . 'js/rexbuilder-admin.js', array( 'jquery' ), $this->version, true );
				endif;
			endif;
		endif;
	}

	/**
	 *	Register the administration menu for the plugin.
	 *
	 * 	@since    1.0.0
	 */
	public function add_plugin_options_menu() {
		add_menu_page( 'Rexpansive Builder', 'Rexpansive Builder', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_options_page' ), plugin_dir_url( __FILE__ ) . 'img/favicon.ico', '80.5' );
	}

	/**
	 *	Add settings action link to the plugin page.
	 *
	 * 	@since    1.0.0
	 */
	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
		);
		return array_merge( $settings_link, $links );
	}

	/**
	 *	Register the admin top bar menu for the plugin
	 *
	 *	@since	1.0.0
	 */
	public function add_top_bar_plugin_options_menu() {
		global $wp_admin_bar;
		
		$wp_admin_bar->add_menu( array(
				'id'	=>	'rexpansive-builder-top',
				'title'	=>	__( '<img src="'. plugin_dir_url( __FILE__ ) . 'img/favicon.ico" style="vertical-align:middle;margin-right:5px" alt="Rexpansive Builder" title="Rexpansive Builder" />Rexpansive Builder' ),
				'href'	=>	admin_url( 'options-general.php?page=' . $this->plugin_name )
			)
		);
	}

	/**
	 *	Render the settings page for the plugin
	 *
	 * 	@since    1.0.0
	 */
	public function display_plugin_options_page() {
		include_once( 'partials/rexbuilder-admin-display.php' );
	}

	/**
	 *	Validate the plugin settings
	 *
	 * 	@since    1.0.0
	 */
	public function plugin_options_validate( $input ) {
		$valid = array();

		foreach( $input['post_types'] as $key => $value ) :
			$valid['post_types'][$key] = ( isset( $value ) && !empty( $value ) ) ? 1 : 0;
		endforeach;

		//$valid['post_types'] = $input['post_types'];
		$valid['animation'] = ( isset( $input['animation'] ) && !empty( $input['animation'] ) ) ? 1 : 0;

		return $valid;
	}

	/**
	 *	Update the plugin settings
	 *
	 * 	@since    1.0.0
	 */
	public function plugin_options_update() {
		//register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'plugin_options_validate' ) );
		register_setting( $this->plugin_name . '_options', $this->plugin_name . '_options', array( $this, 'plugin_options_validate' ) );
	}

	/**
	 *	Add notifier update page
	 *
	 *	@since	1.0.3
	 */
	public function update_notifier_menu() {  
		$xml = $this->get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
		
		$theme_data = get_plugin_data( WP_PLUGIN_DIR . '/rexpansive-builder/rexpansive-builder.php' ); // Get theme data from style.css (current version is what we want)
		
		if(version_compare($theme_data['Version'], $xml->latest) == -1) {
			add_dashboard_page( $theme_data['Name'] . 'Plugin Updates', $theme_data['Name'] . '<span class="update-plugins count-1"><span class="update-count">Updates</span></span>', 'administrator', strtolower($theme_data['Name']) . '-updates', array( $this, 'update_notifier' ) );
		}
	}

	/**
	 *	Render the page
	 */
	public function update_notifier() { 
		$xml = $this->get_latest_theme_version(21600); // This tells the function to cache the remote call for 21600 seconds (6 hours)
		$theme_data = get_plugin_data( WP_PLUGIN_DIR . '/rexpansive-builder/rexpansive-builder.php' ) // Get theme data from style.css (current version is what we want) ?>

		<div class="wrap">
		
			<div id="icon-tools" class="icon32"></div>
			<h2><?php echo $theme_data['Name']; ?> Plugin Updates</h2>
		    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $theme_data['Name']; ?> plugin available.</strong> You have version <?php echo $theme_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>

		    <h2>Check your email to get the automatic update download link</h2>
	        
	        <!-- <a href="http://rexpansive.neweb.info/download/1450/" class="update-notify-link" title="Update" style="background-image:url(<?php echo WP_PLUGIN_DIR . '/rexpansive-builder/screenshot.png'; ?>);">
	        	<h2>Version <?php echo $xml->latest; ?></h2>
	        	Download this update
	    		<?php 
	    			// echo do_shortcode( '[rexArrow type="download" target="_self" color="#ffffff" link="http://rexpansive.neweb.info/download/1450/" isinsidelink="true"]Download this update[/rexArrow]' ); 
	    		?>
	        </a> -->
	        <!-- <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo WP_PLUGIN_DIR . '/rexpansive-builder/screenshot.png'; ?>" /> -->

	        <div id="instructions" style="max-width: 800px;">
	            <h3>Update Download and Instructions</h3>
	            <p><strong>Please note:</strong> make a <strong>backup</strong> of the Plugin inside your WordPress installation folder <strong>/wp-content/plugins/<?php echo strtolower($theme_data['Name']); ?>/</strong></p>
	            <p>To update the Plugin, login to your account, head over to your <strong>downloads</strong> section and re-download the plugin like you did when you bought it.</p>
	            <p>Extract the zip's contents, look for the extracted plugin folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/plugins/<?php echo strtolower($theme_data['Name']); ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the plugin files).</p>
	            <p>If you didn't make any changes to the plugin files, you are free to overwrite them with the new ones without the risk of losing plugin settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
	        </div>
	        
	            <div class="clear"></div>
		    
		    <h3 class="title">Changelog</h3>
		    <?php echo $xml->changelog; ?>

		</div>
	    
	<?php }

	// This function retrieves a remote xml file on my server to see if there's a new update 
	// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
	public function get_latest_theme_version($interval) {
		// remote xml file location
		$notifier_file_url = 'http://rexpansive.neweb.info/notifier-builder-premium.xml';
		
		$db_cache_field = 'rexpansive-builder-premium-notifier-cache';
		$db_cache_field_last_updated = 'rexpansive-builder-premium-notifier-last-updated';
		$last = get_option( $db_cache_field_last_updated );
		$now = time();
		// check the cache
		if ( !$last || (( $now - $last ) > $interval) ) {
			// cache doesn't exist, or is old, so refresh it
			if( function_exists('curl_init') ) { // if cURL is available, use it...
				$ch = curl_init($notifier_file_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$cache = curl_exec($ch);
				curl_close($ch);
			} else {
				$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
			}
			
			if ($cache) {			
				// we got good results
				update_option( $db_cache_field, $cache );
				update_option( $db_cache_field_last_updated, time() );			
			}
			// read from the cache file
			$notifier_data = get_option( $db_cache_field );
		}
		else {
			// cache file is fresh enough, so read from it
			$notifier_data = get_option( $db_cache_field );
		}
		
		$xml = simplexml_load_string($notifier_data); 
		
		return $xml;
	}

	/**
	 *	Add a swtich button under the post title/permalink to activate/deactivate the builder
	 *
	 * 	@since    1.0.0
	 */
	public function add_switch_under_post_title() {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
	?>
		<div class="builder-heading rexpansive-builder rexbuilder-materialize-wrap">
			<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/rexpansive-builder.png" alt="logo" width="260" />
			<div class="builder-switch-wrap">
				<div class="switch">
					<label>
						<input type="checkbox" id="builder-switch" checked />
						<span class="lever"></span>
					</label>
				</div>
			</div>
		</div>
	<?php
				endif;
			endif;
		endif;
	}

	/**
	 * Create the variuos modal editors of the builder.
	 *
	 * @since    1.0.0
	 */
	public function create_builder_modals() {
		$page_info = get_current_screen();

		if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') ) { 
			return; 
		}
		if( !isset( $this->plugin_options['post_types'] ) ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true') { 
			$post_to_activate = $this->plugin_options['post_types'];
			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
		?>
			<div id="rex-css-editor" class="modal rexbuilder-materialize-wrap rex-modal" style="display:none;">
				<div class="modal-content">
					<div id="rex-css-ace-editor" class="rex-ace-editor"></div>
				</div>
				<div class="rex-modal-footer">
					<button id="css-editor-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="">
						<i class="rex-icon">n</i>
					</button>
					<button id="css-editor-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- CSS Editor -->

			<div id="rex-video-block" style="display:none;" class="modal rex-modal rexbuilder-materialize-wrap">
				<div class="modal-content">
					<div id="section-set-video-wrap" class="row valign-wrapper">
						<div class="rex-check rex-check-icon col">
							<input type="radio" class="rex-choose-video with-gap" name="rex-choose-video" value="youtube" id="rex-choose-youtube">
							<label for="rex-choose-youtube">
								<i class="material-icons rex-icon">C</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
						<div class="input-field col">
							<input id="rex-mp4-id" type="hidden">
							<input id="rex-youtube-url" type="text">
							<label id="rex-youtube-url-label" for="rex-youtube-url">https://youtu.be/...</label>
						</div>
						<div class="rex-check rex-check-icon col">
							<input type="radio" class="rex-choose-video with-gap" name="rex-choose-video" value="mp4" id="rex-choose-mp4">
							<label id="rex-upload-mp4" for="rex-choose-mp4">
								<i class="material-icons rex-icon">A</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="rex-modal-footer">
					<button id="rex-video-block-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="">
						<i class="rex-icon">n</i>
					</button>
					<button id="rex-video-block-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- Block Video Editor -->

			<div id="rexeditor-modal" class="modal rexbuilder-materialize-wrap outside-content-modal" style="display:none;">
				<div class="modal-editor-header">
					<button id="content-position-open-modal" class="btn-floating waves-effect waves-light tooltipped" value="image" data-position="bottom" data-tooltip="<?php _e( 'Text Position', 'rexspansive' ); ?>">
						<i class="material-icons rex-icon">E</i>
					</button>
					<button id="content-padding-open-modal" class="btn-floating waves-effect waves-light tooltipped" value="image" data-position="bottom" data-tooltip="<?php _e( 'Padding', 'rexspansive' ); ?>">
						<i class="material-icons rex-icon">D</i>
					</button>
				</div>
				<div class="modal-content-wrap">
					<div class="modal-content">
						<div class="modal-editor-editorarea">
						<?php wp_editor( '', 'rexbuilder_editor', array( 'textarea_rows' => 20, 'wpautop' => false, 'editor_height' => 250 ) ); ?>
						</div>
					</div>
					<div class="rexeditor_bottom rex-modal-footer clearfix">
						<button id="editor-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="">
							<i class="rex-icon">n</i>
						</button>
						<button id="editor-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="">
							<i class="rex-icon">m</i>
						</button>
					</div>
				</div>
			</div><!-- Text Editor -->

			<div id="block-modal-content-padding" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="modal-content">
					<div class="row valign-wrapper">
						<div class="col">
							<div class="clearfix">
								<div class="block-padding-wrap">
									<input type="text" id="block-padding-top" class="block-padding-values" name="block-padding-top" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Top">d</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="block-padding-left" class="block-padding-values" name="block-padding-left" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Left">a</i>
								</div>
								<div id="block-padding-future-content"></div>
								<div class="block-padding-wrap">
									<input type="text" id="block-padding-right" class="block-padding-values" name="block-padding-right" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Right">c</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="block-padding-bottom" class="block-padding-values" name="block-padding-bottom" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Bottom">b</i>
								</div>
							</div>
						</div>

						<div class="rex-vertical-check-wrap col">
							<div class="rex-check-text">
								<input id="block-pad-percentage" type="radio" class="block-padding-type with-gap" name="block-padding-type" value="percentage" checked />
								<label for="block-pad-percentage">
									%
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="rex-check-text">
								<input id="block-pad-pixel" type="radio" class="block-padding-type with-gap" name="block-padding-type" value="pixel" />
								<label for="block-pad-pixel">
									PX
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="rex-modal-footer">
					<button id="block-set-content-padding-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="">
						<i class="rex-icon">n</i>
					</button>
					<button id="block-set-content-padding-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="" data-block_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- Block Content Padding Modal -->

			<div id="block-modal-content-position" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="modal-content">
					<div class="row valign-wrapper">
						<div class="col">
							<div>
								<input id="rex-content-top-left" type="radio" class="content-position with-gap" name="content-position" value="top-left" />
								<label for="rex-content-top-left" class="tooltipped" data-position="bottom" data-tooltip="Align Top Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-top-center" type="radio" class="content-position with-gap" name="content-position" value="top-center" />
								<label for="rex-content-top-center" class="tooltipped" data-position="bottom" data-tooltip="Align Top Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-top-right" type="radio" class="content-position with-gap" name="content-position" value="top-right"/>
								<label for="rex-content-top-right" class="tooltipped" data-position="bottom" data-tooltip="Align Top Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-content-middle-left" type="radio" class="content-position with-gap" name="content-position" value="middle-left" />
								<label for="rex-content-middle-left" class="tooltipped" data-position="bottom" data-tooltip="Align Middle Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-middle-center" type="radio" class="content-position with-gap" name="content-position" value="middle-center" />
								<label for="rex-content-middle-center" class="tooltipped" data-position="bottom" data-tooltip="Align Middle Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-middle-right" type="radio" class="content-position with-gap" name="content-position" value="middle-right" />
								<label for="rex-content-middle-right" class="tooltipped" data-position="bottom" data-tooltip="Align Middle Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-content-bottom-left" type="radio" class="content-position with-gap" name="content-position" value="bottom-left" />
								<label for="rex-content-bottom-left" class="tooltipped" data-position="bottom" data-tooltip="Align Bottom Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-bottom-center" type="radio" class="content-position with-gap" name="content-position" value="bottom-center" />
								<label for="rex-content-bottom-center" class="tooltipped" data-position="bottom" data-tooltip="Align Bottom Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-content-bottom-right" type="radio" class="content-position with-gap" name="content-position" value="bottom-right" />
								<label for="rex-content-bottom-right" class="tooltipped" data-position="bottom" data-tooltip="Align Bottom Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="rex-modal-footer">
					<button id="block-set-content-position-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="">
						<i class="rex-icon">n</i>
					</button>
					<button id="block-set-content-position-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="" data-block_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- Block Content Position Modal -->

			<div id="background_block_set" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="background-options-area modal-content">
					<div class="background_set_image row valign-wrapper">
						<div class="col">
							<div class="valign-wrapper">
								<div class="rex-check">
									<input type="radio" id="background-value-image" class="background_type with-gap" name="background_type" value="image" />
									<label for="background-value-image" title="Image">
										<span class="rex-ripple"></span>
									</label>
								</div>
								<div id="bg-set-img-wrap" class="rex-button-with-plus">
									<div id="bg-img-preview">
										<i class="material-icons rex-icon">p</i>
									</div>
									<button id="background_up_img" class="rex-plus-button btn-floating light-blue darken-1" value="" title="Select Image">
										<i class="material-icons">&#xE145;</i>
									</button>
									<input name="" class="file-path" type="hidden" id="background_url" />
								</div>
							</div>
						</div>
						<div id="set-image-size">
							<input type="hidden" id="set-image-size-value" name="set-image-size-value" value="">
						</div>
						<div id="bg-set-img-type" class="col clearfix">
							<div>
								<input id="bg-img-type-full" class="background_image_type with-gap" type="radio" name="background_image_type" value="full" checked>
								<label for="bg-img-type-full" class="tooltipped" data-position="bottom" data-tooltip="Full">
									<i class="material-icons rex-icon">j</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="bg-img-type-natural" class="background_image_type with-gap" type="radio" name="background_image_type" value="natural">
								<label for="bg-img-type-natural" class="tooltipped" data-position="bottom" data-tooltip="Natural">
									<i class="material-icons rex-icon">k</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
						<div id="bg-set-photoswipe" class="col rex-check-icon">
							<input type="checkbox" id="background_photoswipe" name="background_photoswipe" title="Photo Zoom">
							<label for="background_photoswipe" class="tooltipped" data-position="bottom" data-tooltip="Photo Zoom">
								<i class="rex-icon">g</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
					</div><!-- /BACKGROUND IMAGE -->

					<div id="background-set-color" class="background_set_color row valign-wrapper">
						<div class="col">
							<div class="valign-wrapper">
								<div class="">
									<input type="radio" id="background-value-color" class="background_type with-gap" name="background_type" value="color" />
									<label for="background-value-color">
										<span class="rex-ripple"></span>
									</label>
								</div>
								<div class="rex-relative-col">
									<input type="hidden" id="background-block-color-runtime" name="background-block-color-runtime" value="">
									<input id="background-block-color" type="text" name="background-block-color" value="" size="10">
									<div id="background-preview-icon" class="preview-color-icon"></div>
								</div>
							</div>
						</div>
						<div class="col">
							<div id="bg-color-palette" class="clearfix">
								<div id="palette-blue" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(33,150,243,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-green" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(139,195,74,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-black" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(0,0,0,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-red" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(244,67,54,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-orange" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,152,0,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-purple" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(156,39,176,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-transparent" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,255,255,0)" />
									<span class="bg-palette-button">
										<i class="material-icons rex-icon">o</i>
									</span>
								</div>
							</div>
						</div>				
					</div><!-- /COLOR BACKGROUND -->

					<div id="block-set-video-wrap" class="row valign-wrapper">
						<div class="col rex-check-icon">
							<input type="radio" class="rex-block-choose-video with-gap" name="rex-block-choose-video" value="youtube" id="rex-block-choose-youtube">
							<label for="rex-block-choose-youtube">
								<i class="material-icons rex-icon">C</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
						<div id="block-set-youtube-video-wrap" class="col input-field">
							<input id="rex-block-mp4-id" type="hidden">
							<input id="rex-block-youtube-url" type="text">
							<label id="rex-block-youtube-url-label" for="rex-block-youtube-url">https://youtu.be/...</label>
							<span class="rex-material-bar"></span>
						</div>
						<div id="block-set-mp4-video-wrap" class="rex-check-icon col">
							<input type="radio" class="rex-block-choose-video with-gap" name="rex-block-choose-video" value="mp4" id="rex-block-choose-mp4">
							<label id="rex-block-upload-mp4" for="rex-block-choose-mp4">
								<i class="material-icons rex-icon">A</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
						<div id="block-set-video-has-audio" class="col">
							<input type="checkbox" id="rex-block-video-has-audio" name="rex-block-video-has-audio" title="Audio ON/OFF">
							<label for="rex-block-video-has-audio" class="tooltipped" data-position="bottom" data-tooltip="Audio ON/OFF">
								<i class="rex-icon">
									<span class="rex-icon-audio">L</span><span class="rex-icon-mute">M</span>
								</i>
								<span class="rex-ripple"></span>
							</label>
						</div>
					</div><!-- /VIDEO -->

					<div id="block-set-class-wrap" class="row valign-wrapper">
						<div class="col">
							<div>
								<input id="rex-bm-content-top-left" type="radio" class="content-position with-gap" name="content-position" value="top-left" />
								<label for="rex-bm-content-top-left" class="tooltipped" data-position="bottom" data-tooltip="Top-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-top-center" type="radio" class="content-position with-gap" name="content-position" value="top-center" />
								<label for="rex-bm-content-top-center" class="tooltipped" data-position="bottom" data-tooltip="Top-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-top-right" type="radio" class="content-position with-gap" name="content-position" value="top-right"/>
								<label for="rex-bm-content-top-right" class="tooltipped" data-position="bottom" data-tooltip="Top-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-bm-content-middle-left" type="radio" class="content-position with-gap" name="content-position" value="middle-left" />
								<label for="rex-bm-content-middle-left" class="tooltipped" data-position="bottom" data-tooltip="Middle-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-middle-center" type="radio" class="content-position with-gap" name="content-position" value="middle-center" />
								<label for="rex-bm-content-middle-center" class="tooltipped" data-position="bottom" data-tooltip="Middle-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-middle-right" type="radio" class="content-position with-gap" name="content-position" value="middle-right" />
								<label for="rex-bm-content-middle-right" class="tooltipped" data-position="bottom" data-tooltip="Middle-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-bm-content-bottom-left" type="radio" class="content-position with-gap" name="content-position" value="bottom-left" />
								<label for="rex-bm-content-bottom-left" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-bottom-center" type="radio" class="content-position with-gap" name="content-position" value="bottom-center" />
								<label for="rex-bm-content-bottom-center" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-bottom-right" type="radio" class="content-position with-gap" name="content-position" value="bottom-right" />
								<label for="rex-bm-content-bottom-right" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>

						<div class="col">
							<div class="clearfix">
								<div class="block-padding-wrap">
									<input type="text" id="bm-block-padding-top" class="block-padding-values" name="block-padding-top" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Top">d</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="bm-block-padding-left" class="block-padding-values" name="block-padding-left" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Left">a</i>
								</div>
								<div id="block-padding-future-content"></div>
								<div class="block-padding-wrap">
									<input type="text" id="bm-block-padding-right" class="block-padding-values" name="block-padding-right" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Right">c</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="bm-block-padding-bottom" class="block-padding-values" name="block-padding-bottom" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Bottom">b</i>
								</div>
							</div>
						</div>

						<div class="rex-vertical-check-wrap col">
							<div class="rex-check-text">
								<input id="bm-block-pad-percentage" type="radio" class="bm-block-padding-type with-gap" name="block-padding-type" value="percentage" checked />
								<label for="bm-block-pad-percentage">
									%
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="rex-check-text">
								<input id="bm-block-pad-pixel" type="radio" class="bm-block-padding-type with-gap" name="block-padding-type" value="pixel" />
								<label for="bm-block-pad-pixel">
									PX
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
					</div><!-- /POSITION & PADDING -->

					<div id="block-overlay-wrap" class="row valign-wrapper">
						<div class="col">
							<div id="bg-set-block-overlay" class="col rex-check-icon">
								<input type="checkbox" id="block-has-overlay-small" class="block-has-overlay" name="block-has-overlay-small" value="small">
								<label for="block-has-overlay-small" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Mobile', 'rexpansive' ); ?>">
									<i class="rex-icon">r</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="col rex-check-icon">
								<input type="checkbox" id="block-has-overlay-medium" class="block-has-overlay" name="block-has-overlay-medium" value="medium">
								<label for="block-has-overlay-medium" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Tablet', 'rexpansive' ); ?>">
									<i class="rex-icon">y</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="col rex-check-icon">
								<input type="checkbox" id="block-has-overlay-large" class="block-has-overlay" name="block-has-overlay-large" value="large">
								<label for="block-has-overlay-large" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Desktop', 'rexpansive' ); ?>">
									<i class="rex-icon">x</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
						<div class="col row">
							<div id="bg-overlay-block-color-col" class="col">
								<div>
									<input id="overlay-color-block-value" type="text" name="overlay-color-block-value" value="rgba(255,255,255,0.5)" size="10">
									<div id="overlay-block-preview-icon" class="preview-color-icon"></div>
								</div>
							</div>
							<div id="bg-overlay-block-color-palette" class="col">
								<div id="overlay-block-palette-blue" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(33,150,243,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-block-palette-green" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(139,195,74,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-block-palette-black" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(0,0,0,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-block-palette-red" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(244,67,54,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-block-palette-orange" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,152,0,0.6)" />
									<span class="bg-palette-button"></span>
								</div>	
								<div id="overlay-block-palette-transparent" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,255,255,0)" />
									<span class="bg-palette-button">
										<i class="material-icons rex-icon">o</i>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div id="bg-set-link-wrap" class="row">
						<div class="col">
							<div class="input-field rex-input-prefixed">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="Link">l</i>
								<input type="text" id="block_link_value" name="block_link_value" value="" size="30">
								<label for="block_link_value">http://www...</label>
								<span class="rex-material-bar"></span>
							</div>
						</div>
						<div class="col">
							<div class="input-field rex-col2 rex-input-prefixed">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="Custom Class">e</i>
								<input type="text" id="block_custom_class" name="block_custom_class" value="">
								<label for="block_custom_class">
									Classes
								</label>
								<span class="rex-material-bar"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="background_set_bottom rex-modal-footer">
					<button id="background_set_cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="image">
						<i class="rex-icon">n</i>
					</button>
					<button id="background_set_save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="" data-block_id="" data-block_parent="" data-section_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- Block settings and section background settings -->

			<!--<div id="modal-sectionid-set" style="display:none;">
				<div class="modal_wrap">
					<h2><?php _e('Section ID', 'rexpansive'); ?></h2>
					<div class="sectionid-set">
						<input type="text" value="" id="sectionid-container" name="sectionid-container">
					</div>
					<div class="sectionid-set-bottom">
						<button id="sectionid-set-cancel" class="button button-large"><?php _e('Cancel', 'rexpansive'); ?></button>
						<button id="sectionid-set-save" class="button button-primary button-large" data-section_id=""><?php _e('Save', 'rexpansive'); ?></button>
					</div>
				</div>
			</div>-->

			<div id="modal-background-responsive-set" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="modal-content">

					<div id="section-config-first-row" class="row valign-wrapper">

						<div class="col valign-wrapper">
							<div class="rex-edit-layout-wrap">
								<div>
									<input type="radio" id="section-fixed" name="section-layout" class="builder-edit-row-layout with-gap" value="fixed" checked title="Grid Layout" />
									<label for="section-fixed"  class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Grid Layout', 'rexspansive' ); ?>">
										<i class="material-icons">&#xE8F1;</i>
										<span class="rex-ripple"></span>
									</label>
								</div>
								<div>
									<input type="radio" id="section-masonry" name="section-layout" class="builder-edit-row-layout with-gap" value="masonry" title="Masonry Layout" />
									<label for="section-masonry"  class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Masonry Layout', 'rexspansive' ); ?>">
										<i class="material-icons">&#xE871;</i>
										<span class="rex-ripple"></span>
									</label>
								</div>
							</div>
						</div>

						<div></div>

						<!-- <div class="col row valign-wrapper">
							<div class="input-field rex-input-prefixed col">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Block Distance', 'rexpansive' ); ?>">q</i>
								<input type="text" id="" class="section-set-block-gutter" name="section-set-block-gutter" value="00" placeholder="" size="15">
								<span class="rex-material-bar"></span>
							</div>
							<div class="rex-col-text col">
								<span>PX</span>
							</div>
						</div> -->

						<div class="col row valign-wrapper layout-wrap">
							<div>
								<input type="radio" id="section-full-modal" name="section-dimension-modal" class="builder-edit-row-dimension-modal with-gap" value="full" title="Full" />
								<label for="section-full-modal" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full', $this->plugin_name ); ?>">
									<i class="material-icons rex-icon">v</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="section-boxed-modal" type="radio" name="section-dimension-modal" class="builder-edit-row-dimension-modal with-gap" value="boxed" title="Boxed" />
								<label for="section-boxed-modal" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Boxed', $this->plugin_name ); ?>">
									<i class="material-icons rex-icon">t</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>

						<div class="col row valign-wrapper">
							<div id="section-set-dimension" class="input-field rex-input-prefixed col">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Boxed Width', 'rexpansive' ); ?>">t</i>
								<input type="text" id="" class="section-set-boxed-width" name="section-set-boxed-width" value="0000" placeholder="" size="23">
								<span class="rex-material-bar"></span>
							</div>
							<div class="section-set-boxed-width-wrap col">
								<div class="rex-check-text">
									<input id="block-width-percentage" type="radio" class="section-width-type with-gap" name="section-width-type" value="percentage" checked />
									<label for="block-width-percentage">
										<?php _e( '%', 'rexpansive' ); ?>
										<span class="rex-ripple"></span>
									</label>
								</div>
								<div class="rex-check-text">
									<input id="block-width-pixel" type="radio" class="section-width-type with-gap" name="section-width-type" value="pixel" />
									<label for="block-width-pixel">
										<?php _e( 'PX', 'rexpansive' ); ?>
										<span class="rex-ripple"></span>
									</label>
								</div>
							</div>
						</div>

					</div><!-- /full-heigth, boxed dimension, block distance -->

					<div id="section-config-third-row" class="row valign-wrapper">
						<div class="col">
							<div class="cross-style-wrap">
								<div class="clearfix">
									<div class="block-padding-wrap">
										<input type="text" id="row-separator-top" class="block-padding-values" name="row-separator-top" value="" placeholder="" />
										<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Row Margin Top">P</i>
										<span class="block-padding-label">PX</span>
									</div>
								</div>
								<div class="clearfix horizontal-cross-wrap">
									<div class="block-padding-wrap">				
										<input type="text" id="row-separator-left" class="block-padding-values" name="row-separator-left" value="" placeholder="" />
										<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Row Margin Left">Q</i>
										<span class="block-padding-label">PX</span>
									</div>
									<!-- <div class="col row valign-wrapper gutter-wrap">
										<div class="input-field rex-input-prefixed col">
											<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Block Distance', 'rexpansive' ); ?>">S</i>
											<input type="text" id="" class="section-set-block-gutter" name="section-set-block-gutter" value="00" placeholder="" size="15">
											<span class="rex-material-bar"></span>
										</div>
										<div class="rex-col-text col">
											<span>PX</span>
										</div>
									</div> -->
									<div class="col row valign-wrapper gutter-wrap">
										<div class="block-padding-wrap">
											<input type="text" id="" class="section-set-block-gutter block-padding-values" name="section-set-block-gutter" value="" placeholder="" size="15">
											<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Block Distance', 'rexpansive' ); ?>">S</i>
											<span class="block-padding-label">PX</span>
											<span class="rex-material-bar"></span>
										</div>
									</div>
									<div class="block-padding-wrap">
										<input type="text" id="row-separator-right" class="block-padding-values" name="row-separator-right" value="" placeholder="" />
										<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Row Margin Right">O</i>
										<span class="block-padding-label">PX</span>
									</div>
								</div>
								<div class="clearfix">
									<div class="block-padding-wrap">				
										<input type="text" id="row-separator-bottom" class="block-padding-values" name="row-separator-bottom" value="" placeholder="" />
										<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Row Margin Bottom">N</i>
										<span class="block-padding-label">PX</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col row" style="margin-left:96px;">
							<div class="clearfix">
								<div id="bg-set-full-section" class="rex-check-icon col">
									<input type="checkbox" id="section-is-full" name="section-is-full" value="full-height">
									<label for="section-is-full" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full Height', 'rexpansive' ); ?>">
										<i class="rex-icon">s</i>
										<span class="rex-ripple"></span>
									</label>
								</div>
								<div id="bg-set-full-text" class="rex-col-text col">
									<span>100%</span>
								</div>
							</div>

							<div id="rx-set-hold-grid" class="clearfix">
								<div id="rx-hold-grid__wrap" class="rex-check-icon col">
									<input type="checkbox" id="rx-hold-grid" name="rx-hold-grid" value="full-height">
									<label for="rx-hold-grid" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Grid On Mobile', 'rexpansive' ); ?>">
										<!--<i class="rex-icon rx-hold-grid__uncheck">T</i>
										<i class="rex-icon rx-hold-grid__check">U</i>-->
										<i class="rex-icon">V</i>
										<span class="rex-ripple"></span>
									</label>
								</div>
							</div>

							<div id="bg-set-photoswipe" class="col rex-check-icon">
								<input type="checkbox" id="section-active-photoswipe" name="section-active-photoswipe" title="<?php _e( 'All Images Zoom', 'rexpansive' ); ?>">
								<label for="section-active-photoswipe" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'All Images Zoom', 'rexpansive' ); ?>">
									<i class="rex-icon">R</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
						
					</div><!-- custom classes -->

					<div class="row valign-wrapper id-class-row-wrap">
						<!-- <div class="col row valign-wrapper">
							<div id="bg-set-full-section" class="rex-check-icon col">
								<input type="checkbox" id="section-is-full" name="section-is-full" value="full-height">
								<label for="section-is-full" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full Height', 'rexpansive' ); ?>">
									<i class="rex-icon">s</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div id="bg-set-full-text" class="rex-col-text col">
								<span>100%</span>
							</div>
						</div> -->
						<div id="rex-config-id" class="input-field col rex-input-prefixed">
							<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Section Name', 'rexpansive' ); ?>">B</i>
							<input type="text" id="sectionid-container" name="sectionid-container">
							<span class="rex-material-bar"></span>
						</div>
						<div id="section-set-class-wrap" class="input-field col rex-input-prefixed">
							<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Custom Class', 'rexpansive' ); ?>">e</i>
							<input type="text" id="section-set-custom-class" name="section-set-custom-class" value="" size="10">
							<label for="section-set-custom-class">
								<?php _e( 'Classes', 'rexpansive'); ?>
							</label>
							<span class="rex-material-bar"></span>
						</div>
					</div><!-- custom classes -->

					<!--<div id="section-config-second-row" class="row valign-wrapper">
						<div class="col">
							<div id="bg-set-responsive-overlay" class="col rex-check-icon">
								<input type="checkbox" id="section-has-overlay-small" name="section-has-overlay">
								<label for="section-has-overlay-small" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Mobile', 'rexpansive' ); ?>">
									<i class="rex-icon">r</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="col rex-check-icon">
								<input type="checkbox" id="section-has-overlay-medium" name="section-has-overlay-medium">
								<label for="section-has-overlay-medium" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Tablet', 'rexpansive' ); ?>">
									<i class="rex-icon">y</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="col rex-check-icon">
								<input type="checkbox" id="section-has-overlay-large" name="section-has-overlay-large">
								<label for="section-has-overlay-large" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Overlay Desktop', 'rexpansive' ); ?>">
									<i class="rex-icon">x</i>
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
						<div class="col row">
							<div id="bg-overlay-color-col" class="col">
								<div>
									<input class="backresponsive-color-section" type="text" name="backresponsive-color-section" value="rgba(255,255,255,0.5)" size="10">
									<div id="overlay-preview-icon" class="preview-color-icon"></div>
								</div>
							</div>
							<div id="bg-overlay-color-palette" class="col">
								<div id="overlay-palette-blue" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(33,150,243,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-palette-green" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(139,195,74,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-palette-black" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(0,0,0,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-palette-red" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(244,67,54,0.6)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="overlay-palette-transparent" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,255,255,0)" />
									<span class="bg-palette-button">
										<i class="material-icons rex-icon">o</i>
									</span>
								</div>
							</div>
						</div>
					</div>--><!-- /responsive overlay,  -->
				</div>
				<div class="backresponsive-set-bottom rex-modal-footer">
					<button id="backresponsive-set-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button">
						<i class="rex-icon">n</i>
					</button>
					<button id="backresponsive-set-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" data-section_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div><!-- Section settings -->

			<div id="modal-text-fill" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="modal-content">

					<div class="row">
						<div class="col">
							<div class="valign-wrapper">
								<div id="" class="rex-button-with-plus">
									<div id="bg-img-preview">
										<i class="material-icons rex-icon">p</i>
									</div>
									<button id="textfill-background-upload-button" class="rex-plus-button btn-floating light-blue darken-1" value="" title="Select Image">
										<i class="material-icons">&#xE145;</i>
									</button>
									<input id="textfill-background-image-url" type="hidden" name="textfill-background-image-url" value="">
									<input id="textfill-background-image-id" type="hidden" name="textfill-background-image-id" value="">
								</div>
							</div>
						</div>
						<div class="rex-space rex-space-12"></div>
						<div class="col">
							<div class="input-field rex-col2 rex-input-prefixed">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="Custom Class">e</i>
								<input type="text" id="textfill-text" name="textfill-text" value="">
								<label for="textfill-text">
									Text
								</label>
								<span class="rex-material-bar"></span>
							</div>
						</div>
						<div class="col valign-wrapper">
							<div class="input-field rex-input-prefixed col">
								<input type="text" id="textfill-font-size" class="" name="textfill-font-size" value="00" placeholder="" size="15">
								<span class="rex-material-bar"></span>
							</div>
							<div class="rex-col-text col">
								<span>PX</span>
							</div>
						</div>
					</div>

					<div id="background-set-color" class="background_set_color row valign-wrapper">
						<div class="col">
							<div class="valign-wrapper">
								<div class="rex-relative-col">
									<input type="hidden" id="textfill-background-color-runtime" name="textfill-background-color-runtime" value="">
									<input id="textfill-background-color" type="text" name="textfill-background-color" value="" size="10">
									<div id="background-preview-icon" class="preview-color-icon"></div>
								</div>
							</div>
						</div>
						<div class="col">
							<div id="bg-color-palette" class="clearfix">
								<div id="palette-blue" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(33,150,243,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-green" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(139,195,74,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-black" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(0,0,0,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-red" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(244,67,54,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-orange" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,152,0,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-purple" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(156,39,176,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-transparent" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,255,255,0)" />
									<span class="bg-palette-button">
										<i class="material-icons rex-icon">o</i>
									</span>
								</div>
							</div>
						</div>				
					</div>
	
					<div id="textfill-set-align-wrap" class="row valign-wrapper">
						<div class="col">
							<div>
								<div>
									<input id="textfill-text-align-left" type="radio" class="content-position with-gap" name="textfill-text-align" value="left" />
									<label for="textfill-text-align-left" class="tooltipped" data-position="bottom" data-tooltip="Left">
										<span class="rex-ripple"></span>
										<i class="material-icons">&#xE236;</i>
									</label>
								</div>
								<input id="textfill-text-align-center" type="radio" class="content-position with-gap" name="textfill-text-align" value="center" />
								<label for="textfill-text-align-center" class="tooltipped" data-position="bottom" data-tooltip="Center">
									<span class="rex-ripple"></span>
									<i class="material-icons">&#xE234;</i>
								</label>
								<input id="textfill-text-align-right" type="radio" class="content-position with-gap" name="textfill-text-align" value="right" />
								<label for="textfill-text-align-right" class="tooltipped" data-position="bottom" data-tooltip="Right">
									<span class="rex-ripple"></span>
									<i class="material-icons">&#xE237;</i>
								</label>
							</div>
						</div>

						<div class="col">
							<div class="clearfix">
								<div class="block-padding-wrap">
									<input type="text" id="textfill-padding-top" class="block-padding-values" name="textfill-padding-top" value="0" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Top">d</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="textfill-padding-left" class="block-padding-values" name="textfill-padding-left" value="0" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Left">a</i>
								</div>
								<div id="block-padding-future-content"></div>
								<div class="block-padding-wrap">
									<input type="text" id="bm-textfill-padding-right" class="block-padding-values" name="textfill-padding-right" value="0" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Right">c</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="textfill-padding-bottom" class="block-padding-values" name="textfill-padding-bottom" value="0" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Bottom">b</i>
								</div>
							</div>
						</div>

						<div class="rex-vertical-check-wrap col">
							<div class="rex-check-text">
								<input id="texftill-pad-percentage" type="radio" class="bm-block-padding-type with-gap" name="textfill-padding-type" value="percentage" checked />
								<label for="texftill-pad-percentage">
									%
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="rex-check-text">
								<input id="texftill-pad-pixel" type="radio" class="bm-block-padding-type with-gap" name="textfill-padding-type" value="pixel" />
								<label for="texftill-pad-pixel">
									PX
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
					

					<!-- 
					<div>
						<label for="textfill-text">
							<?php _e( 'Your text', 'rexpansive' ); ?>
						</label>
						<input type="text" id="textfill-text" name="textfill-text" value="">
					</div>
					<div>
						<label for="textfill-text-align">
							<?php _e( 'Text align', 'rexpansive' ); ?>
						</label>
						<select id="textfill-text-align" name="textfill-text-align">
							<option value="center"><?php _e( 'Center', 'rexpansive' ); ?></option>
							<option value="left"><?php _e( 'Left', 'rexpansive' ); ?></option>
							<option value="right"><?php _e( 'Right', 'rexpansive' ); ?></option>
						</select>
					</div>
					<div>
						<label for="textfill-background-image-url">
							<?php _e( 'Background Url', 'rexpansive' ); ?>
						</label>
						<input id="textfill-background-image-url" type="text" name="textfill-background-image-url" value="">
						<input id="textfill-background-image-id" type="hidden" name="textfill-background-image-id" value="">
					</div>
					<div>
						<button id="textfill-background-upload-button" type=""><?php _e( 'Upload Image', 'rexpansive' ); ?></button>
					</div>
					<div>
						<label for="textfill-background-color">
							<?php _e( 'Background color', 'rexpansive' ); ?>
						</label>
						<input type="text" id="textfill-background-color" name="textfill-background-color" value="">
					</div>
					<div>
						<label for="textfill-font-size">
							<?php _e( 'Max Font Size', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-font-size" name="textfill-font-size" value="" min="0">
					</div>
					<div>
						<label for="textfill-padding-top">
							<?php _e( 'Padding Top', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-padding-top" name="textfill-padding-top" value="" min="0">
					</div>
					<div>
						<label for="textfill-padding-right">
							<?php _e( 'Padding Right', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-padding-right" name="textfill-padding-right" value="" min="0">
					</div>
					<div>
						<label for="textfill-padding-bottom">
							<?php _e( 'Padding Bottom', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-padding-bottom" name="textfill-padding-bottom" value="" min="0">
					</div>
					<div>
						<label for="textfill-padding-left">
							<?php _e( 'Padding Left', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-padding-left" name="textfill-padding-left" value="" min="0">
					</div>
					<div>
						<label for="textfill-margin-top">
							<?php _e( 'Margin Top', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-margin-top" name="textfill-margin-top" value="" min="0">
					</div>
					<div>
						<label for="textfill-margin-right">
							<?php _e( 'Margin Right', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-margin-right" name="textfill-margin-right" value="" min="0">
					</div>
					<div>
						<label for="textfill-margin-bottom">
							<?php _e( 'Margin Bottom', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-margin-bottom" name="textfill-margin-bottom" value="" min="0">
					</div>
					<div>
						<label for="textfill-margin-left">
							<?php _e( 'Margin Left', 'rexpansive' ); ?>
						</label>
						<input type="number" id="textfill-margin-left" name="textfill-margin-left" value="" min="0">
					</div>
				</div> -->

				<div class="rex-modal-footer">
					<button id="textfill-set-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button">
						<i class="rex-icon">n</i>
					</button>
					<button id="textfill-set-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" data-section_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div> <!-- TextFill Settings -->

			<!-- <div id="modal-text-fill" class="modal rex-modal rexbuilder-materialize-wrap" style="display:none;">
				<div class="background-options-area modal-content">
					<div class="background_set_image row valign-wrapper">
						<div class="col">
							<div class="valign-wrapper">
								<div id="bg-set-img-wrap" class="rex-button-with-plus">
									<div id="bg-img-preview">
										<i class="material-icons rex-icon">p</i>
									</div>
									<button id="background_up_img" class="rex-plus-button btn-floating light-blue darken-1" value="" title="Select Image">
										<i class="material-icons">&#xE145;</i>
									</button>
									<input name="" class="file-path" type="hidden" id="background_url" />
								</div>
							</div>
						</div>
					</div>

					<div id="background-set-color" class="background_set_color row valign-wrapper">
						<div class="col">
							<div class="valign-wrapper">
								<div class="rex-relative-col">
									<input type="hidden" id="background-block-color-runtime" name="background-block-color-runtime" value="">
									<input id="background-block-color" type="text" name="background-block-color" value="" size="10">
									<div id="background-preview-icon" class="preview-color-icon"></div>
								</div>
							</div>
						</div>
						<div class="col">
							<div id="bg-color-palette" class="clearfix">
								<div id="palette-blue" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(33,150,243,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-green" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(139,195,74,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-black" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(0,0,0,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-red" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(244,67,54,1)" />
									<span class="bg-palette-button"></span>
								</div>
								<div id="palette-orange" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,152,0,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-purple" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(156,39,176,1)" />
									<span class="bg-palette-button"></span>
								</div>						
								<div id="palette-transparent" class="bg-palette-selector">
									<input class="bg-palette-value" type="hidden" value="rgba(255,255,255,0)" />
									<span class="bg-palette-button">
										<i class="material-icons rex-icon">o</i>
									</span>
								</div>
							</div>
						</div>				
					</div>

					<div id="block-set-class-wrap" class="row valign-wrapper">
						<div class="col">
							<div>
								<input id="rex-bm-content-top-left" type="radio" class="content-position with-gap" name="content-position" value="top-left" />
								<label for="rex-bm-content-top-left" class="tooltipped" data-position="bottom" data-tooltip="Top-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-top-center" type="radio" class="content-position with-gap" name="content-position" value="top-center" />
								<label for="rex-bm-content-top-center" class="tooltipped" data-position="bottom" data-tooltip="Top-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-top-right" type="radio" class="content-position with-gap" name="content-position" value="top-right"/>
								<label for="rex-bm-content-top-right" class="tooltipped" data-position="bottom" data-tooltip="Top-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-bm-content-middle-left" type="radio" class="content-position with-gap" name="content-position" value="middle-left" />
								<label for="rex-bm-content-middle-left" class="tooltipped" data-position="bottom" data-tooltip="Middle-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-middle-center" type="radio" class="content-position with-gap" name="content-position" value="middle-center" />
								<label for="rex-bm-content-middle-center" class="tooltipped" data-position="bottom" data-tooltip="Middle-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-middle-right" type="radio" class="content-position with-gap" name="content-position" value="middle-right" />
								<label for="rex-bm-content-middle-right" class="tooltipped" data-position="bottom" data-tooltip="Middle-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div>
								<input id="rex-bm-content-bottom-left" type="radio" class="content-position with-gap" name="content-position" value="bottom-left" />
								<label for="rex-bm-content-bottom-left" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Left">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-bottom-center" type="radio" class="content-position with-gap" name="content-position" value="bottom-center" />
								<label for="rex-bm-content-bottom-center" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Center">
									<span class="rex-ripple"></span>
								</label>
								<input id="rex-bm-content-bottom-right" type="radio" class="content-position with-gap" name="content-position" value="bottom-right" />
								<label for="rex-bm-content-bottom-right" class="tooltipped" data-position="bottom" data-tooltip="Bottom-Right">
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>

						<div class="col">
							<div class="clearfix">
								<div class="block-padding-wrap">
									<input type="text" id="bm-block-padding-top" class="block-padding-values" name="block-padding-top" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Top">d</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="bm-block-padding-left" class="block-padding-values" name="block-padding-left" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Left">a</i>
								</div>
								<div id="block-padding-future-content"></div>
								<div class="block-padding-wrap">
									<input type="text" id="bm-block-padding-right" class="block-padding-values" name="block-padding-right" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Right">c</i>
								</div>
							</div>
							<div class="clearfix">
								<div class="block-padding-wrap">				
									<input type="text" id="bm-block-padding-bottom" class="block-padding-values" name="block-padding-bottom" value="5" />
									<i class="rex-icon tooltipped" data-position="bottom" data-tooltip="Padding Bottom">b</i>
								</div>
							</div>
						</div>

						<div class="rex-vertical-check-wrap col">
							<div class="rex-check-text">
								<input id="bm-block-pad-percentage" type="radio" class="bm-block-padding-type with-gap" name="block-padding-type" value="percentage" checked />
								<label for="bm-block-pad-percentage">
									%
									<span class="rex-ripple"></span>
								</label>
							</div>
							<div class="rex-check-text">
								<input id="bm-block-pad-pixel" type="radio" class="bm-block-padding-type with-gap" name="block-padding-type" value="pixel" />
								<label for="bm-block-pad-pixel">
									PX
									<span class="rex-ripple"></span>
								</label>
							</div>
						</div>
					</div>

					<div id="bg-set-link-wrap" class="row">
						<div class="col">
							<div class="input-field rex-col2 rex-input-prefixed">
								<i class="material-icons rex-icon prefix tooltipped" data-position="bottom" data-tooltip="Custom Class">e</i>
								<input type="text" id="block_custom_class" name="block_custom_class" value="">
								<label for="block_custom_class">
									Classes
								</label>
								<span class="rex-material-bar"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="background_set_bottom rex-modal-footer">
					<button id="textfill-set-cancel" class="waves-effect waves-light btn-flat grey rex-cancel-button" value="image">
						<i class="rex-icon">n</i>
					</button>
					<button id="textfill-set-save" class="waves-effect waves-light btn-flat blue darken-1 rex-save-button" value="" data-block_id="" data-block_parent="" data-section_id="">
						<i class="rex-icon">m</i>
					</button>
				</div>
			</div> -->

			<div class="lean-overlay" style="display:none;"></div><!-- Opaque overlay -->
		<?php
				endif;
			endif;
		}
	}

	/**
	 * Create the templates for the builder used by the scripts.
	 *
	 * @since    1.0.0
	 */
	public function create_builder_templates() {
		$page_info = get_current_screen();

		if( isset( $this->plugin_options['post_types'] ) ) :

			$post_to_activate = $this->plugin_options['post_types'];

			if( isset( $post_to_activate[$page_info->id] ) ) : 
				if( ( $post_to_activate[$page_info->id] == 1 ) && 
					( $post_to_activate[$page_info->post_type] == 1 ) ) :
		?>
<script id="rexbuilder-tmpl-element-actions" type="text/html">
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
			<i class="material-icons rex-icon">u</i></div>
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
</script><!-- element actions template -->

<script id="rexbuilder-tmpl-text-element" type="text/html">
<li id="data.imageid" class="text item with-border z-depth-1 hoverable svg-ripple-effect" data-block_type="text" data-block-custom-classes="" data-content-padding="" data-bg_settings="">
	data.elementactionsplaceholder
	<div class="element-data">
		<textarea class="data-text-content" display="none"></textarea>
	</div>
	<div class="element-preview-wrap">
		<div class="element-preview"></div>
	</div>
	<div class="element-visual-info">
		<div class="vert-wrap">
			<div class="vert-elem">
				<i class="material-icons rex-icon rex-notice rex-video-notice">G</i>
			</div>
		</div>
	</div>
	<div class="el-visual-size"><span></span></div>
</li>
</script><!-- text element template -->

<script id="rexbuilder-tmpl-image-element" type="text/html">
<li id="data.textid" class="image item z-depth-1 hoverable svg-ripple-effect data.isnaturalimage" data-block_type="text" data-block-custom-classes="" data-content-padding="" data-bg_settings='data.bgblocksetts'>
	data.elementactionsplaceholder
	<div class="element-data">
		<textarea class="data-text-content" display="none"></textarea>
	</div>
	<div class="element-preview-wrap" style="background-image:url(data.imgprevsrc);">
		<div class="element-preview">
			<div class="backend-image-preview" data-image_id="data.attachmentid"></div>
		</div>
	</div>
	<div class="element-visual-info">
		<div class="vert-wrap">
			<div class="vert-elem">
				<i class="material-icons rex-icon rex-notice rex-video-notice">G</i>
			</div>
		</div>
	</div>
	<div class="el-visual-size"><span></span></div>
</li>
</script><!-- image element template -->

<script id="rexbuilder-tmpl-empty-element" type="text/html">
<li id="data.emptyid" class="empty with-border item z-depth-1 hoverable svg-ripple-effect" data-block_type="empty" data-bg_settings="" data-block-custom-classes="" data-content-padding="">
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
	<div class="element-data">
		<textarea class="data-text-content" display="none"></textarea>
	</div>
	<div class="element-preview-wrap">
		<div class="element-preview"></div>	
	</div>
	<div class="element-visual-info">
		<div class="vert-wrap">
			<div class="vert-elem">
				<i class="material-icons rex-icon rex-notice rex-video-notice">G</i>
			</div>
		</div>
	</div>
	<div class="el-visual-size"><span></span></div>
</li>
</script><!-- empty element template -->
<script id="rexbuilder-tmpl-notice-video" type="text/html">
<div class="element-visual-info rex-active-video-notice">
	<div class="vert-wrap">
		<div class="vert-elem">
			<i class="material-icons rex-icon rex-notice rex-video-notice">G</i>
		</div>
	</div>
</div>
<div class="el-visual-size"><span></span></div>
</script><!-- rexbuilder-tmpl-notice-video -->
		<?php
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
			$defaultsectionconfigs = json_encode( array(
				'gutter' => '20',
				'isFull' => '',
				'custom_classes' => '',
				'section_width'	=>	'',
			) );
		?>
<script id="rexbuilder-tmpl-section" type="text/html">
<div class="builder-row clearfix z-depth-1" data-count="" data-gridcontent='' data-gridproperties='<?php echo htmlspecialchars( $defaultsectionproperties ); ?>' data-griddimension='full' data-layout='fixed' data-sectionid='' data-section-overlay-color='' data-backresponsive='<?php echo htmlspecialchars( $defaultsectionconfigs ); ?>' data-row-separator-top="" data-row-separator-bottom="" data-row-separator-right="" data-row-separator-left="" data-section-active-photoswipe="">
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
						id="section-full-data.index"
						name="section-dimension-data.index" 
						class="builder-edit-row-dimension with-gap" 
						value="full" checked title="Full" />
					<label for="section-full-data.index" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Full', 'rexspansive' ); ?>">
						<i class="material-icons rex-icon">v<span class="rex-ripple"></span></i>
					</label>
				</div>
				<div>
					<input type="radio"
						id="section-boxed-data.index" 
						name="section-dimension-data.index" 
						class="builder-edit-row-dimension with-gap" 
						value="boxed" title="Boxed" />
					<label for="section-boxed-data.index" class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Boxed', 'rexspansive' ); ?>">
						<i class="material-icons rex-icon">t<span class="rex-ripple"></span></i>
					</label>
				</div>
				<div class="rex-edit-layout-wrap" style="display:none;">
					<input type="radio"
						id="section-fixed-data.index" 
						name="section-layout-data.index" 
						class="builder-edit-row-layout with-gap" 
						value="fixed" checked title="Fixed" />
					<label for="section-fixed-data.index"  class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Grid Layout', 'rexspansive' ); ?>">
						<i class="material-icons">&#xE8F1;<span class="rex-ripple"></span></i>
					</label>
					<input type="radio" 
						id="section-masonry-data.index" 
						name="section-layout-data.index" 
						class="builder-edit-row-layout with-gap" 
						value="masonry" title="Masonry" />
					<label for="section-masonry-data.index"  class="tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Masonry Layout', 'rexspansive' ); ?>">
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
							<button class="btn-floating builder-add waves-effect waves-light tooltipped" value="text-fill" data-position="bottom" data-tooltip="<?php _e( 'TextFill', 'rexspansive' ); ?>">
								<span style="color:white;">T</span>
							</button>
						</li> -->
					</ul>
				</div>
			</div>
			
			<div class="col s4 right-align builder-setting-buttons">
				<div class="background_section_preview btn-floating tooltipped" data-position="bottom" data-tooltip="<?php _e( 'Row background', 'rexspansive' ); ?>"></div>
				<button class="btn-floating builder-section-config tooltipped" data-position="bottom" data-tooltip="<?php _e('Row settings', 'rexspansive'); ?>">
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
					<ul>
					</ul>
					<div class="section-visual-info"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
		<?php
				endif;
			endif;
		endif;
	}

	/**
	 * Function that adds the scripts for the handle of the custom buttons.
	 *
	 * @since    1.0.0
	 */
	public function rexbuilder_add_tinymce_plugin( $plugin_array ) {
		$plugin_array['rexbuilder_textfill_button'] = plugin_dir_url( __FILE__ ) . 'js/textfill-button.js';
		//$plugin_array['rexbuilder_animation_button'] = plugin_dir_url( __FILE__ ) . 'js/animation-button.js';
		$plugin_array['rexbuilder_embed_video_button'] = plugin_dir_url( __FILE__ ) . 'js/embed-video.js';
		return $plugin_array;
	}

	/**
	 * Function that registers the new custom buttons.
	 *
	 * @since    1.0.0
	 */
	public function rexbuilder_register_custom_buttons( $buttons ) {
		array_push( $buttons, 'rexbuilder_textfill_button' );
		//array_push( $buttons, 'rexbuilder_animation_button' );
		array_push( $buttons, 'rexbuilder_embed_video_button' );
		return $buttons;
	}


	function rexbuilder_add_custom_buttons() {
		global $typenow;
		if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') ) { 
			return; 
		}
		if( ! array_key_exists( 'post_types', $this->plugin_options) ) {
			return;
		}
		if( ! array_key_exists( $typenow, $this->plugin_options['post_types'] ) ) {
			return;
		}
		if ( get_user_option('rich_editing') == 'true') { 
			add_filter('mce_external_plugins', array( $this, 'rexbuilder_add_tinymce_plugin' ) ); 
			add_filter('mce_buttons', array( $this, 'rexbuilder_register_custom_buttons' ) ); 
		}
	}
}
