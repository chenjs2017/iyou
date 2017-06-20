<?php
/**
 * Mapplic - New Map Page
 *
 */

// Built-in maps
$maps = array(
	'world' 		=> 'World',
	'continents' 	=> 'Continents',
	'europe' 		=> 'Europe',
	'usa' 			=> 'USA',
	'canada' 		=> 'Canada',
	'australia' 	=> 'Australia',
	'france' 		=> 'France',
	'germany' 		=> 'Germany',
	'uk' 			=> 'United Kingdom',
	'italy' 		=> 'Italy',
	'netherlands' 	=> 'Netherlands',
	'switzerland' 	=> 'Switzerland',
	'russia' 		=> 'Russia',
	'china' 		=> 'China',
	'brazil' 		=> 'Brazil'
);

// SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	global $wpdb;
	$table = $wpdb->prefix . 'custommaps';

	$type = $_REQUEST['map-type'];
	$data = '';
	$mapdir = plugins_url() . '/mapplic/maps';

	switch ($type) {
		case 'world':
			$data = '{"mapwidth":"1200","mapheight":"760","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"world","title":"World","map":"' . $mapdir . '/world.svg","minimap":"","locations":[{"id":"us","title":"USA","description":"<p>United States</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.2287","y":"0.5149"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'continents':
			$data = '{"mapwidth":"400","mapheight":"220","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":false,"alphabetic":false,"categories":[],"levels":[{"id":"continents","title":"Continents","map":"' . $mapdir . '/world-continents.svg","minimap":"","show":"true","locations":[{"id":"europe","title":"Europe","description":"<p>Example landmark.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5494","y":"0.2492"}]}],"maxscale":4,"clearbutton":true,"mousewheel":false,"deeplinking":false,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'europe':
			$data = '{"mapwidth":"1200","mapheight":"1200","minimap":true,"zoombuttons":true,"sidebar":true,"search":true,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":true,"zoom":true,"alphabetic":true,"categories":[],"levels":[{"id":"europe","title":"Europe","map":"' . $mapdir . '/europe.svg","minimap":"' . $mapdir . '/europe-mini.jpg","locations":[{"id":"ch","title":"Switzerland","description":"<p>Example country</p>","fill":"#343f4b","category":"false","action":"tooltip","pin":"hidden","x":"0.4085","y":"0.6328"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'usa':
			$data = '{"mapwidth":"960","mapheight":"600","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"usa","title":"USA","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"il","title":"Illinois","description":"<p>Example state.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.6226","y":"0.4248"},{"id":"los-angeles","title":"Los Angeles","description":"<p>Welcome to LA!</p>","pin":"circular pin-md pin-label","label":"LA","category":"false","action":"default","x":"0.0898","y":"0.5749","fill":"#937ed7"},{"id":"new-york","title":"New York","description":"<p>Welcome to NY!</p>","pin":"circular pin-md pin-label","label":"NY","category":"false","action":"default","x":"0.8810","y":"0.3339","fill":"#937ed7"},{"id":"ca","title":"California","description":"<p>California state.</p>","pin":"hidden","category":"false","action":"default","x":"0.0806","y":"0.4705"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'canada':
			$data = '{"mapwidth":"640","mapheight":"600","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":false,"alphabetic":false,"categories":[],"levels":[{"id":"canada","title":"Canada","map":"' . $mapdir . '/canada.svg","minimap":"","locations":[{"id":"ca-ab","title":"Alberta","description":"<p>Example province.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.2528","y":"0.6790"}]}],"maxscale":4,"clearbutton":true,"mousewheel":false,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'australia':
			$data = '{"mapwidth":"600","mapheight":"540","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"australia","title":"Australia","map":"' . $mapdir . '/australia.svg","minimap":"","locations":[{"id":"qld","title":"Queensland","description":"<p>Example territory.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7544","y":"0.3667"},{"id":"melbourne","title":"Melbourne","description":"<p>City of Melbourne.</p>","pin":"circular","category":"false","action":"default","x":"0.7586","y":"0.7752"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'france':
			$data = '{"mapwidth":"1000","mapheight":"1000","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"france","title":"France","map":"' . $mapdir . '/france.svg","minimap":"' . $mapdir . '/france-mini.jpg","locations":[{"id":"fr-d18","title":"Department 18","description":"<p>Example department.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5606","y":"0.4639"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'germany':
			$data = '{"mapwidth":"600","mapheight":"800","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"germany","title":"Germany","map":"' . $mapdir . '/germany.svg","minimap":"","locations":[{"id":"de-ni","title":"Niedersachsen","description":"<p>Example land.</p>","category":"false","action":"tooltip","x":"0.3980","y":"0.2674","pin":"hidden"},{"id":"de-by","title":"Bayern","pin":"hidden","category":"false","action":"tooltip","x":"0.6381","y":"0.7738","description":"<p>Bavaria.</p>"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'uk':
			$data = '{"mapwidth":"690","mapheight":"982","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":true,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"uk","title":"United Kingdom","map":"' . $mapdir . '/uk.svg","minimap":"","locations":[{"id":"north-west","title":"North West","description":"<p>Example region.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5437","y":"0.5530"},{"id":"london","title":"London","description":"<p>City of London.</p>","pin":"hidden","category":"false","action":"default","x":"0.7921","y":"0.8223"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'italy':
			$data = '{"mapwidth":"800","mapheight":"1000","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"italy","title":"Italy","map":"' . $mapdir . '/italy.svg","minimap":"","locations":[{"id":"tuscany","title":"Tuscany","description":"<p>Example.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.3897","y":"0.3401"},{"id":"milan","title":"Milan","pin":"circular","category":"false","action":"tooltip","x":"0.2379","y":"0.1703"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'switzerland':
			$data = '{"mapwidth":"640","mapheight":"420","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"switzerland","title":"Switzerland","map":"' . $mapdir . '/switzerland.svg","minimap":"' . $mapdir . '/switzerland-mini.jpg","locations":[{"id":"BE","title":"Bern","description":"<p>Canton of Bern.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.3680","y":"0.4808"},{"id":"zurich","title":"Zürich","description":"<p>City of Zürich.</p>","pin":"circular pin-md pin-label","category":"false","action":"default","x":"0.5562","y":"0.2341","label":"ZH"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'netherlands':
			$data = '{"mapwidth":"598","mapheight":"598","bottomLat":"50.67500192979909","leftLng":"2.8680356443589807","topLat":"53.62609096857893","rightLng":"7.679884929662812","categories":[],"levels":[{"id":"netherlands","title":"Netherlands","map":"' . $mapdir . '/netherlands.svg","minimap":"","locations":[{"id":"nl-ut","title":"Utrecht","about":"Province","description":"<p>Utrecht province description.</p>","pin":"hidden","x":"0.4819","y":"0.5238","category":"false","action":"default"},{"id":"amsterdam","title":"Amsterdam","about":"Capital city","description":"<p>Amsterdam, the capital city.</p>","pin":"transparent pin-md pin-label","link":"http://www.codecanyon.net/user/sekler","lng":"4.896911","lat":"52.373412","x":0.4216415010830731,"y":0.4326147922230017,"label":"AM","fill":"#8224e3","category":"false","action":"lightbox"}]}],"maxscale":3,"minimap":false,"zoombuttons":true,"sidebar":true,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'russia':
			$data = '{"mapwidth":"1100","mapheight":"640","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"russia","title":"Russia","map":"' . $mapdir . '/russia.svg","minimap":"' . $mapdir . '/russia-mini.jpg","locations":[{"id":"YAN","title":"Yamalia","description":"<p>Example</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.4019","y":"0.5905"},{"id":"MOW","title":"Moscow","description":"<p>The capital city.</p>","pin":"circular","category":"false","action":"default","x":"0.1267","y":"0.5924"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'china':
			$data = '{"mapwidth":"860","mapheight":"700","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"china","title":"China","map":"' . $mapdir . '/china.svg","minimap":"' . $mapdir . '/china-mini.jpg","locations":[{"id":"SD","title":"Shandong","description":"<p>Example.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7626","y":"0.4833"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'brazil':
			$data = '{"mapwidth":"800","mapheight":"800","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"brazil","title":"Brazil","map":"' . $mapdir . '/brazil.svg","minimap":"' . $mapdir . '/brazil-mini.jpg","locations":[{"id":"br-ba","title":"Bahia","description":"<p>Bahia state.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7964","y":"0.4429"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}';
			break;
		case 'import':
			$data = stripslashes($_REQUEST['mapplic-import']);
			break;
		default:
			$data = '{"minimap":false,"clearbutton":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"mousewheel":true,"fullscreen":false,"deeplinking":true,"mapfill":false,"zoom":true,"alphabetic":false,"zoomlimit":"3","fillcolor":"#343f4b","action":"tooltip","categories":[],"levels":[]}';
	}

	// Add new record to database
	$wpdb->insert(
		$table,
		array(
			'title' => $_REQUEST['map-title'],
			'data' => $data
		)
	);

	$id = $wpdb->insert_id;

	// Redirect to the edit page of the newly created map
	$editPage = remove_query_arg('noheader', add_query_arg(
		array(
			'action' => 'edit',
			'map' => $id
		)
	));

	wp_redirect($editPage);
	exit;
}
?>

<div class="wrap">

	<h2><?php _e('Add New Custom Map', 'mapplic'); ?></h2>
	
	<form id="mapplic-form" method="post" action="<?php echo add_query_arg('noheader', 'true'); ?>">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
		<input type="hidden" name="action" value="new">
		<input type="hidden" name="map" value="<?php echo $id; ?>">
		<input type="hidden" name="noheader" value="true">

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<input type="text" name="map-title" id="title" placeholder="<?php _e('Enter map title here'); ?>" autocomplete="off">
					</div>

					<p><?php _e('To create a new custom map, first add a floor, save it and you can start placing landmarks.', 'mapplic'); ?></p>

					<select id="mapplic-new-type" name="map-type">
						<option value="custom"><?php _e('Custom', 'mapplic'); ?></option>
						<option value="import"><?php _e('Import', 'mapplic'); ?></option>
					<?php foreach ($maps as $key => $map) : ?>
						<option value="<?php echo $key; ?>"><?php echo $map; ?></option>
					<?php endforeach; ?>
					</select>

					<textarea id="mapplic-import" name="mapplic-import" class="mapplic-mapdata-field" rows="16" placeholder="<?php _e('Enter map data here', 'mapplic'); ?>" spellcheck="false"></textarea>

					<input type="submit" name="submit" class="button button-primary form-submit" value="<?php _e('Create Map', 'mapplic'); ?>">
				</div>
			</div>
		</div>
	</form>
</div>