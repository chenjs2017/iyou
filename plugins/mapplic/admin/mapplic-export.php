<?php
/**
 * Mapplic - Export Page
 *
 */

$id = $_REQUEST['map'];

global $wpdb;
$table = $wpdb->prefix . 'custommaps';

// SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = $_REQUEST['data'];

	$wpdb->query("UPDATE $table SET data = '$data' WHERE id = $id");
}

$map = $wpdb->get_row("SELECT * FROM $table WHERE id = $id", 'ARRAY_A');
$data = json_decode($map['data'], true);
?>

<div class="wrap">

	<h2><?php _e('Export Map', 'mapplic'); ?></h2>

	<form id="mapplic-form" method="post">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
		<input type="hidden" name="action" value="export">

		<h3><?php _e('Map data of', 'mapplic'); ?> <a href="<?php echo admin_url('admin.php?page=mapplic_menu&action=edit&map=' . $id); ?>"><?php echo $map['title']; ?></a>:</h3>

		<textarea id="mapplic-export" class="mapplic-mapdata-field" name="data" rows="16" spellcheck="false"><?php echo $map['data']; ?></textarea>

		<div class="right">
			<label><input type="checkbox" id="mapplic-export-indented"></input>Indented</label>
		</div>

		<input type="submit" id="mapplic-update-button" class="button" value="<?php _e('Update', 'mapplic'); ?>">

		<h3><?php _e('Map, minimap and other self-hosted image files must be migrated manually!', 'mapplic'); ?></h3>
		<p>The list of map and minimap files used:</p>
		<?php 
			$levels = array_reverse($data['levels']);
			foreach ($levels as &$level) {
				if ($level['map']) echo '<a href="' . $level['map'] . '" target="_blank">' . $level['map'] . '</a><br>';
				if ($level['minimap']) echo '<a href="' . $level['minimap'] . '" target="_blank">' . $level['minimap'] . '</a><br>';
			}
		?>
	</form>
</div>