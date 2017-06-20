<?php

// Metaboxes
$screen = get_current_screen();

add_action('admin_footer-' . $screen->id, 'mapplic_footer_scripts');

function mapplic_footer_scripts() {
	?>
	<script>
		postboxes.add_postbox_toggles(pagenow);
	</script>
	<?php
}

// Floors metabox callback
function mapplic_floors_metabox($post, $param) {
	$floors = array_reverse($param['args']['levels']);
	?>

	<ul id="floor-list" class="sortable-list">
		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New floor', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">
				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="New floor"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>

				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input buttoned" value="">
						<input type="button" class="button media-button" value="<?php _e('Add', 'mapplic'); ?>">
					</label>
				</div>

				<div>
					<label><?php _e('Minimap', 'mapplic'); ?><br>
						<input type="text" class="input-text minimap-input buttoned" value="">
						<input type="button" class="button media-button" value="<?php _e('Add', 'mapplic'); ?>">
					</label>
				</div>

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>
	
	<?php foreach ($floors as &$floor) : ?>

		<li class="list-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php echo $floor['title']; ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">
				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php echo $floor['title']; ?>"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value="<?php echo $floor['id']; ?>" disabled></label>

				<?php $shown = ($floor['show'] == 'true') ? 'checked' : ''; ?>
				<label>
					<input type="radio" name="shown-floor" class="show-input" <?php echo $shown; ?> value="<?php echo $floor['id']; ?>"> <?php _e('Show by default', 'mapplic'); ?>
				</label>

				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input buttoned" value="<?php echo $floor['map']; ?>">
						<input type="button" class="button media-button" value="<?php _e('Add', 'mapplic'); ?>">
					</label>
				</div>

				<div>
					<label>Minimap<br>
						<input type="text" class="input-text minimap-input buttoned" value="<?php echo $floor['minimap']; ?>">
						<input type="button" class="button media-button" value="<?php _e('Add', 'mapplic'); ?>">
					</label>
				</div>

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>

	<?php endforeach; ?>
	</ul>
	<input type="button" id="new-floor" class="button" value="<?php _e('New Floor', 'mapplic'); ?>">
	<input type="submit" name="submit" class="button button-primary form-submit right" value="<?php _e('Save', 'mapplic'); ?>">
	<div class="clear"></div>
	<?php
	unset($floor);
}

// Categories metabox callback
function mapplic_categories_metabox($post, $param) {
	$categories = $param['args']['categories'];
	?>
	<ul id="category-list" class="sortable-list">

		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New category', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="New category"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>
				<label><input type="checkbox" class="expand-input" checked> <?php _e('Expand by default', 'mapplic'); ?></label>
				<input type="text" value="#666666" class="mapplic-color-picker color-input" data-default-color="#666666">

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>

	<?php foreach ($categories as &$category) : ?>
		<li class="list-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php echo $category['title']; ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php echo $category['title']; ?>"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value="<?php echo $category['id']; ?>"></label>
				<?php $shown = ($category['show'] == 'false') ? '' : 'checked'; ?>
				<label><input type="checkbox" class="expand-input" <?php echo $shown; ?>> <?php _e('Expand by default', 'mapplic'); ?></label>
				<input type="text" value="<?php echo $category['color']; ?>" class="mapplic-color-picker color-input" data-default-color="#666666">

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
	<input type="button" id="new-category" class="button" value="<?php _e('New Category', 'mapplic'); ?>">
	<input type="submit" name="submit" class="button button-primary form-submit right" value="<?php _e('Save', 'mapplic'); ?>">
	<div class="clear"></div>	
	<?php
	unset($category);
}

// Geoposition metabox
function mapplic_geoposition_metabox($post, $param) {
?>
	<div id="geopos">
		<div class="geopos-corner tl"></div>
		<input type="text" class="geopos-field" id="topLat" placeholder="Top Latitude" value="<?php echo $param['args']['topLat']; ?>">
		<div class="geopos-corner tr"></div><br>
		<input type="text" class="geopos-field" id="leftLng" placeholder="Left Longitude" value="<?php echo $param['args']['leftLng']; ?>">
		<input type="text" class="geopos-field" id="rightLng" placeholder="Right Longitude" value="<?php echo $param['args']['rightLng']; ?>">
		<br><div class="geopos-corner bl"></div>
		<input type="text" class="geopos-field" id="bottomLat" placeholder="Bottom Latitude" value="<?php echo $param['args']['bottomLat']; ?>">
		<div class="geopos-corner br"></div>
	</div>
<?php
}

// Settings metabox callback
function mapplic_settings_metabox($post, $param) {
?>
	<h4><?php _e('Map file Dimensions (REQUIRED)', 'mapplic'); ?></h4>
	<label>
		<?php _e('Map Width', 'mapplic'); ?><br>
		<input type="text" id="setting-mapwidth" value="<?php echo $param['args']['mapwidth']; ?>" placeholder="REQUIRED"><span> px</span>
	</label>
	<label>
		<?php _e('Map Height', 'mapplic'); ?><br>
		<input type="text" id="setting-mapheight" value="<?php echo $param['args']['mapheight']; ?>" placeholder="REQUIRED"><span> px</span>
	</label>

	<!-- Components -->
	<h4><?php _e('Components and Features', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-minimap"<?php echo ($param['args']['minimap'] == 'true') ? ' checked' : ''; ?>> <?php _e('Minimap', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-clearbutton"<?php echo ($param['args']['clearbutton'] == 'true') ? ' checked' : ''; ?>> <?php _e('Clear Button', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-zoombuttons"<?php echo ($param['args']['zoombuttons'] == 'true') ? ' checked' : ''; ?>> <?php _e('Zoom Buttons', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-sidebar"<?php echo ($param['args']['sidebar'] == 'true') ? ' checked' : ''; ?>> <?php _e('Sidebar', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-search"<?php echo ($param['args']['search'] == 'true') ? ' checked' : ''; ?>> <?php _e('Search', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-hovertip"<?php echo ($param['args']['hovertip'] == 'true') ? ' checked' : ''; ?>> <?php _e('Hover Tooltip', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-mousewheel"<?php echo ($param['args']['mousewheel'] == 'true') ? ' checked' : ''; ?>> <?php _e('Mouse wheel', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-fullscreen"<?php echo ($param['args']['fullscreen'] == 'true') ? ' checked' : ''; ?>> <?php _e('Fullscreen', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-deeplinking"<?php echo ($param['args']['deeplinking'] == 'true') ? ' checked' : ''; ?>> <?php _e('Deeplinking', 'mapplic'); ?>
	</label>

	<!-- General -->
	<h4><?php _e('General Settings', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-zoom"<?php echo ($param['args']['zoom'] == false) ? '' : ' checked'; ?>> <?php _e('Enable zoom', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-mapfill"<?php echo ($param['args']['mapfill'] == 'true') ? ' checked' : ''; ?>> <?php _e('Map fills the container', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-alphabetic"<?php echo ($param['args']['alphabetic'] == 'true') ? ' checked' : ''; ?>> <?php _e('Alphabetically ordered', 'mapplic'); ?>
	</label>
	<label>
		<?php _e('Zoom Limit', 'mapplic'); ?><br>
		<input type="text" id="setting-zoomlimit" value="<?php echo $param['args']['zoomlimit']; ?>">
	</label>
	<?php
		$actions = array(
			'tooltip' => 'Tooltip',
			'open-link' => 'Open link',
			'open-link-new-tab' => 'Open link in new tab',
			'lightbox' => 'Lightbox',
			'none' => 'None'
		);
	?>
	<label><?php _e('Default Action', 'mapplic'); ?><br>
		<select id="setting-action"><?php foreach ($actions as $value => $action) : ?>
			<option value="<?php echo $value; ?>"<?php if ($param['args']['action'] == $value) echo ' selected'; ?>><?php echo $action; ?></option>
		<?php endforeach; ?></select>
	</label>
	<label>
		<?php _e('Default Fill Color', 'mapplic'); ?><br>
		<input type="text" id="setting-fillcolor" class="mapplic-color-picker" data-default-color="#343f4b" value="<?php echo $param['args']['fillcolor']; ?>">
	</label>
<?php
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') {
	include('mapplic-edit.php');
}
else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'new') {
	include('mapplic-new.php');
}
else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'export') {
	include('mapplic-export.php');
}
else {

// Load WP_List_Table class
if (!class_exists('WP_List_Table')) {
	require_once('class-wp-list-table.php');
}

class Map_List_Table extends WP_List_Table {

	function __construct() {
		parent::__construct(array(
			'singular'=> 'map',
			'plural' => 'maps',
			'ajax'	=> false
		));
	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'title':
			case 'id':
				return $item[$column_name];
			case 'shortcode':
				$height = ($item['height'] != 0 ? sprintf(' h="%s"', $item['height']) : '');

				return '[mapplic id="' . $item['id'] . '"' . $height . ']';
			default:
				return print_r($item, true);
		}
	}

	function column_title($item){
		
		$actions = array(
			'edit'      => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'edit', $item['id'], __('Edit')),
			'duplicate' => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'duplicate', $item['id'], __('Duplicate')),
			'delete'    => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'delete', $item['id'], __('Delete')),
			'export'    => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'export', $item['id'], __('Export'))
		);
		
		//Return the title contents
		return sprintf('<a href="?page=%1$s&action=edit&map=%2$s" class="row-title">%3$s</a> %4$s',
			/*$1%s*/ $_REQUEST['page'],
			/*$2%s*/ $item['id'],
			/*$3%s*/ $item['title'],
			/*$4%s*/ $this->row_actions($actions)
		);
	}

	function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s">',
			/*$1%s*/ $this->_args['singular'],
			/*$2%s*/ $item['id']
		);
	}

	function get_columns() {
		$columns = array(
			'cb'        => '<input type="checkbox">',
			'title'     => __('Title'),
			'id'        => __('Id'),
			'shortcode' => __('Shortcode')
		);
		return $columns;
	}

	// Bulk actions
	function process_bulk_action() {
		if (isset($_REQUEST['map'])) $target = $_REQUEST['map'];

		if ($this->current_action() === 'delete') {
			global $wpdb;

			//if (is_array($target)) { }

			$table = $wpdb->prefix . 'custommaps';
			$wpdb->query("UPDATE $table 
				SET status = 0
				WHERE id = $target"
			);


			$count = sprintf(_n('1 map', '%s maps', count($target)), count($target));
			echo sprintf('<div class="updated notice is-dismissible"><p>%1$s deleted! <a href="?page=%2$s&action=%3$s&map=%4$s">%5$s</a></p><button type="button" class="notice-dismiss"></button></div>',
				/*$1%s*/ $count,
				/*$2%s*/ $_REQUEST['page'],
				/*$3%s*/ 'undo',
				/*$4%s*/ $target,
				/*$5%s*/ __('Undo')
			);
		}
		else if ($this->current_action() === 'duplicate') {
			global $wpdb;
			/* debug */

			$table = $wpdb->prefix . 'custommaps';

			$original = $wpdb->get_row("SELECT * FROM $table WHERE id = $target", 'ARRAY_A');

			$wpdb->insert(
				$table,
				array(
					'title' => '[Duplicate] ' . $original['title'],
					'data' => $original['data']
				)
			);
		}
		else if ($this->current_action() === 'export') {
		}
		else if ($this->current_action() === 'undo') {
			global $wpdb;

			$table = $wpdb->prefix . 'custommaps';
			$wpdb->query("UPDATE $table 
				SET status = 1
				WHERE ID = $target"
			);

			$count = sprintf(_n('1 map', '%s maps', count($target)), count($target));
			echo sprintf('<div class="updated notice is-dismissible"><p>%1$s restored.</p><button type="button" class="notice-dismiss"></button></div>', $count);
		}
	}

	function prepare_items() {
		global $wpdb;

		$per_page = 16;
		
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		$this->process_bulk_action();
		
		// Database Query
		$table_name = $wpdb->prefix . 'custommaps';

		$query = "SELECT * FROM $table_name WHERE status > 0";

		//Parameters that are going to be used to order the result
		$orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
		$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
		if (!empty($orderby) & !empty($order)) { $query .= ' ORDER BY ' . $orderby . ' ' . $order; }

		// Number of elements
		$total_items = $wpdb->query($query);

		// Page number
		$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';

		//Page Number
		if (empty($paged) || !is_numeric($paged) || $paged <= 0) { $paged = 1; }

		//adjust the query to take pagination into account
		if (!empty($paged) && !empty($per_page)) {
			$offset = ($paged - 1) * $per_page;
			$query .= ' LIMIT ' . (int)$offset . ', ' . (int)$per_page;
		}
		
		// Register pagination
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items/$per_page)
		));

		// Add items
		$this->items = $wpdb->get_results($query, 'ARRAY_A');
	}
}

$map_list_table = new Map_List_Table();
$map_list_table->prepare_items();

?>
<div class="wrap">

	<h2><?php _e('Custom Interactive Maps', 'mapplic'); ?> <a href="?page=<?php echo $_REQUEST['page']; ?>&amp;action=new" class="add-new-h2"><?php _e('Add New'); ?></a></h2>
	
	<form id="maps-filter" method="get">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
	
		<?php $map_list_table->display() ?>
	
	</form>
	
</div>

<?php 
}
?>