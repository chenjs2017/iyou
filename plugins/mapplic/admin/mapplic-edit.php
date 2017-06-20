<?php
/**
 * Mapplic - Edit Page
 *
 */

$id = $_REQUEST['map'];

global $wpdb;
$table = $wpdb->prefix . 'custommaps';

// SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$title = $_REQUEST['map-title'];
	$data = $_REQUEST['data'];
	$height = $_REQUEST['map-height'];

	if (empty($data)) {
		echo '<div class="error notice is-dismissible"><p>' . __('Something went wrong saving the map, no changes were made.', 'mapplic') . '</p></div>';
	}
	else {
		$wpdb->query("UPDATE $table
			SET title = '$title',
				data = '$data',
				height = $height /*ftl*/
			WHERE id = $id"
		);
	}
}

$map = $wpdb->get_row("SELECT * FROM $table WHERE id = $id", 'ARRAY_A');
$data = json_decode($map['data'], true);

if (count($data['levels']) > 0) {
	add_meta_box('landmark', __('Landmark', 'mapplic'), 'mapplic_landmark_metabox','toplevel_page_mapplic_menu', 'side', 'core', $data);
}
add_meta_box('floors', __('Floors', 'mapplic'), 'mapplic_floors_metabox', 'toplevel_page_mapplic_menu', 'side', 'core', $data);
add_meta_box('categories', __('Categories', 'mapplic'), 'mapplic_categories_metabox', 'toplevel_page_mapplic_menu', 'side', 'core', $data);
add_meta_box('geoposition', __('Geoposition', 'mapplic'), 'mapplic_geoposition_metabox', 'toplevel_page_mapplic_menu', 'side', 'core', $data);
add_meta_box('settings', __('Settings', 'mapplic'), 'mapplic_settings_metabox', 'toplevel_page_mapplic_menu', 'normal', 'core', $data);

// Landmark metabox callback
function mapplic_landmark_metabox($post, $param) {
	$categories = $param['args']['categories'];
	$pins = array('yellow no-fill', 'orange no-fill', 'green no-fill', 'blue no-fill', 'purple no-fill', 'circular', 'circular pin-md pin-label', 'transparent pin-md pin-label', 'circular pin-md pin-pulse pin-label');
	
	// Filter for custom pins
	$pins = apply_filters('mapplic_pins', $pins);
?>

	<input type="button" id="new-landmark" class="button" value="<?php _e('Add New', 'mapplic'); ?>">

	<div id="landmark-settings">
		<hr>

		<label><strong><?php _e('Title', 'mapplic'); ?>:</strong><input type="text" class="title-input input-text"></label>
		<label><strong><?php _e('ID (unique)', 'mapplic'); ?>:</strong><input type="text" class="id-input input-text"></label>
		<?php wp_editor('', 'descriptioninput', array('drag_drop_upload' => true)); ?>

		<div class="landmark-geolocation">
			<p><strong><?php _e('Geolocation', 'mapplic'); ?></strong></p>
			<input type="text" class="landmark-lat input-text geopos-field" placeholder="Latitude">
			<input type="text" class="landmark-lng input-text geopos-field" placeholder="Longitude">
		</div>

		<p><strong><?php _e('Color and Pin Type', 'mapplic'); ?></strong></p>
		<div>
			<ul id="pins-input">
				<li><div class="mapplic-pin hidden" data-pin="hidden">pin</div></li>
				<li><div class="mapplic-pin default selected" data-pin="no-fill">pin</div></li>
			<?php foreach ($pins as &$pin) : ?>
				<li><div class="mapplic-pin <?php echo $pin; ?>" data-pin="<?php echo $pin; ?>">pin</div></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<input type="text" class="label-input input-text" placeholder="Label">
		<input type="text" class="mapplic-color-picker fill-input" data-default-color="#343f4b">

		<p><strong><?php _e('Attributes', 'mapplic'); ?></strong></p>
		<label><?php _e('Link', 'mapplic'); ?>:<input type="text" class="link-input input-text"></label>

		<label><?php _e('Category', 'mapplic'); ?>
			<select class="category-select input-select">
				<option value="false" selected>None</option>
			<?php foreach ($categories as &$category) : ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
			<?php endforeach; ?>
			</select>
		</label>

		<div>
			<label><?php _e('Thumbnail', 'mapplic'); ?><br>
				<input type="text" class="input-text thumbnail-input buttoned" value="">
				<input type="button" class="button media-button" value="<?php _e('Add', 'mapplic'); ?>">
			</label>
		</div>

		<label><?php _e('Action', 'mapplic'); ?>
			<select class="action-select input-select">
				<option value="default" selected>Default</option>
				<option value="tooltip">Tooltip</option>
				<option value="open-link">Open link</option>
				<option value="open-link-new-tab">Open link in new tab</option>
				<option value="lightbox">Lightbox</option>
				<option value="none">None</option>
			</select>
		</label>

		<label><?php _e('About', 'mapplic'); ?>:<input type="text" class="about-input input-text" placeholder="Visible in sidebar"></label>

		<label><?php _e('Zoom Level', 'mapplic'); ?><input type="text" class="zoom-input input-text" placeholder="Auto"></label>

		<div>
			<input type="button" id="delete-landmark" class="button" value="<?php _e('Delete', 'mapplic'); ?>">
			<input type="button" id="save-landmark" class="button button-primary right" value="<?php _e('Save', 'mapplic'); ?>">
		</div>
	</div>
	
	<?php
	unset($pins);
	unset($category);
}
?>

<div class="wrap">

	<h2><?php _e('Edit Custom Map', 'mapplic'); ?> <a href="?page=<?php echo $_REQUEST['page']; ?>&amp;action=new" class="add-new-h2"><?php _e('Add New'); ?></a></h2>
	
	<form id="mapplic-form" method="post">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
		<input type="hidden" name="action" value="edit">
		<input type="hidden" name="map" value="<?php echo $id; ?>">

		<input type="hidden" name="data" id="input-data">

		<?php
			wp_nonce_field($_REQUEST['page'] . '-nonce');
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
		?>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<input type="text" value="<?php echo $map['title']; ?>" name="map-title" id="title" placeholder="Enter map title here">
					</div>

					<?php if (count($data['levels']) > 0) : ?>
						<div id="admin-map"></div>
					<?php endif; ?>

					<input type="submit" name="submit" id="mapplic-submit" class="button button-primary form-submit" value="<?php _e('Save Changes', 'mapplic') ?>">

					<h4><?php _e('Container height', 'mapplic'); ?></h4>

					<label class="in-line">
						<?php _e('Height (Requires shortcode update!)', 'mapplic'); ?><br>
						<input type="text" name="map-height" value="<?php echo $map['height']; ?>">
					</label>
				</div>
				
				<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes('', 'side', null); ?>
				</div>
				
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes('', 'normal', null); ?>
				</div>
			</div>
		</div>
	</form>
</div>