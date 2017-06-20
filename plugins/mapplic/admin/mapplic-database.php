<?php
/**
 * Mapplic - Database management
 *
 */

global $custommap_db_version;
$custommap_db_version = '1.2';

// Creating database
function custommap_install() {
	global $wpdb;
	global $custommap_db_version;

	$table = $wpdb->prefix . 'custommaps';

	$sql = "CREATE TABLE $table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		title text COLLATE utf8_unicode_ci NOT NULL,
		data mediumtext COLLATE utf8_unicode_ci NOT NULL,
		width smallint DEFAULT '0',
		height smallint DEFAULT '0',
		status tinyint DEFAULT '1' NOT NULL,
		UNIQUE KEY id (id)
	);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	update_option('custommap_db_version', $custommap_db_version);

	if (get_option('custommap_activatted') == false) {
		custommap_install_data();
	}

	update_option('custommap_activatted', time());
}

// Adding initial data
function custommap_install_data() {
	global $wpdb;
	$table = $wpdb->prefix . 'custommaps';

	$exampledir = plugins_url() . '/mapplic/images/examples';
	$mapdir = plugins_url() . '/mapplic/maps';

	// US Example 
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] US States',
			'data' => '{"mapwidth":"959","mapheight":"593","minimap":true,"sidebar":false,"search":false,"hovertip":true,"zoomlimit":"4","categories":[],"levels":[{"id":"states","title":"States","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"ca","title":"California","description":"<p>California state.</p>","link":"http://en.wikipedia.org/wiki/California","pin":"hidden no-fill","x":"0.0718","y":"0.4546","category":"false","action":"tooltip"},{"id":"wa","title":"Washington","description":"<p>The Evergreen State</p>","link":"http://en.wikipedia.org/wiki/Washington_(state)","pin":"hidden","x":"0.1331","y":"0.0971"},{"id":"nv","title":"Nevada","description":"Nevada is officially known as the \"Silver State\" due to the importance of silver to its history and economy","link":"http://en.wikipedia.org/wiki/Nevada","pin":"hidden","x":"0.1484","y":"0.3973"},{"id":"il","title":"Illinois","description":"<p>Three U.S. presidents have been elected while living in Illinois</p>","link":"http://en.wikipedia.org/wiki/Illinois","pin":"hidden","x":"0.6209","y":"0.4316","category":null},{"id":"ny","title":"New York","description":"New York is a state in the Northeastern and Mid-Atlantic regions of the United States.","link":"http://en.wikipedia.org/wiki/NewYork","pin":"hidden","x":"0.8472","y":"0.2680"},{"id":"ma","title":"Massachusetts","description":"Officially the Commonwealth of Massachusetts, is a state in the New England region of the northeastern United States.","link":"http://en.wikipedia.org/wiki/Massachusetts","pin":"hidden","x":"0.9049","y":"0.2625"},{"id":"ga","title":"Georgia","description":"Georgia is known as the Peach State and the Empire State of the South.","link":"http://en.wikipedia.org/wiki/Georgia_(U.S._state)","pin":"hidden","x":"0.7517","y":"0.6885"},{"id":"fl","title":"Florida","description":"The state capital is Tallahassee, the largest city is Jacksonville, and the largest metropolitan area is the Miami metropolitan area.","link":"http://en.wikipedia.org/wiki/Florida","pin":"hidden","x":"0.8001","y":"0.8486"},{"id":"tx","title":"Texas","description":"<p>The Lone Star State <a href=\"http://www.codecanyon.net\">Canyon</a></p>","link":"http://en.wikipedia.org/wiki/Texas","pin":"hidden","x":"0.4512","y":"0.7694","zoom":"2","category":null},{"id":"losangeles","title":"Los Angeles","description":"<p>The city of Angels</p>","x":"0.0892","y":"0.5742","zoom":"2","category":"false","action":"tooltip","pin":"circular pin-md pin-label","label":"LA"},{"id":"houston","title":"Houston","description":"<p>Space City</p>","x":"0.4962","y":"0.8127","zoom":"2","pin":"circular","category":"false","action":"tooltip"},{"id":"chicago","title":"Chicago","description":"<p>The windy city</p>","x":"0.6418","y":"0.3489","zoom":"2","pin":"circular","category":"false","action":"tooltip"},{"id":"newyork","title":"New York","description":"<p>The big apple</p>","x":"0.8827","y":"0.3322","zoom":"2","pin":"circular pin-md pin-label","label":"NY","category":"false","action":"tooltip"}]}],"maxscale":4,"zoombuttons":true,"fullscreen":false,"mapfill":false,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}'
		)
	);

	// Mall Example
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] Mall',
			'data' => '{"mapwidth":"1000","mapheight":"600","categories":[{"id":"food","title":"Fast-foods & Restaurants","color":"#b7a6bd","show":"false"},{"id":"dep","title":"Department Stores","color":"#b7a6bd"},{"id":"clothing","title":"Clothing & Accessories","color":"#b7a6bd"},{"id":"health","title":"Health & Cosmetics","color":"#b7a6bd"},{"id":"misc","title":"Miscellaneous","color":"#b7a6bd"}],"levels":[{"id":"basement","title":"Basement","map":"' . $exampledir . '/mall/mall-underground.svg","minimap":"' . $exampledir . '/mall/mall-underground-mini.jpg","locations":[{"id":"gap","title":"GAP","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3750","y":"0.4343","pin":"hidden","action":"tooltip"},{"id":"petco","title":"Petco","description":"<p>Lorem ipsum</p>","category":"misc","x":"0.5194","y":"0.3091","pin":"hidden","action":"tooltip"}]},{"id":"ground","title":"Ground Floor","map":"' . $exampledir . '/mall/mall-ground.svg","minimap":"' . $exampledir . '/mall/mall-ground-mini.jpg","show":"true","locations":[{"id":"sears","title":"Sears","description":"<p>Sears depártment store</p>","category":"dep","x":"0.7929","y":"0.2727","zoom":"3","pin":"hidden","action":"tooltip"},{"id":"macys","title":"Macy\'s","description":"<p>Macy\'s <i>department</i> store</p>","category":"dep","x":"0.2022","y":"0.5843","zoom":"3","pin":"hidden","actionx":"open-link-new-tab","action":"tooltip"},{"id":"jcpenney","title":"JCPenney","description":"<p>JCPenney department store</p>","category":"dep","x":"0.6713","y":"0.6553","zoom":"3","pin":"hidden","action":"default"},{"id":"walgreens","title":"Walgreens","description":"<p>At the corner of Happy & Healthy</p>","category":"health","x":"0.4600","y":"0.5396","pin":"hidden","action":"none"},{"id":"sephora","title":"Sephora","description":"<p>Makeup, fragrance, skincare</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7506","y":"0.5203","pin":"hidden","action":"default"},{"id":"belk","title":"Belk","description":"<p>Lorem ipsumy</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.3956","y":"0.5556","pin":"hidden","action":"tooltip"},{"id":"hnm","title":"H&M","description":"<p>Lorem ipsum xy</p>","category":"clothing","x":"0.5407","y":"0.5135","link":"http://codecanyon.net/user/sekler?ref=sekler","action":"default","pin":"hidden"},{"id":"oldnavy","title":"Old Navy","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3668","y":"0.3948","pin":"hidden","action":"default"},{"id":"sportchek","title":"Sport Chek","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.6239","y":"0.3049","pin":"hidden","action":"tooltip"},{"id":"starbucks","title":"Starbucks","description":"<p>The coffee company</p>","category":"food","x":"0.6445","y":"0.4477","pin":"hidden","link":"http://codecanyon.net/user/sekler?ref=sekler","action":"open-link-new-tab"},{"id":"zara","title":"Zara","description":"<p>Lorem ipsum</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.4779","y":"0.3112","pin":"hidden","action":"tooltip"}]},{"id":"first","title":"First Floor","map":"' . $exampledir . '/mall/mall-level1.svg","minimap":"' . $exampledir . '/mall/mall-level1-mini.jpg","locations":[{"id":"applebees","title":"Applebee\'s","description":"<p>See you tomorrow</p>","category":"food","x":"0.7539","y":"0.2767","pin":"hidden","action":"tooltip"},{"id":"kfc","title":"KFC","description":"<p>Kentucky Fried Chicken</p>","category":"food","x":"0.7491","y":"0.4996","pin":"hidden","action":"tooltip"},{"id":"mcdonalds","title":"McDonald\'s","description":"<p>Additional information</p>","category":"food","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7386","y":"0.3991","pin":"hidden","action":"tooltip"},{"id":"pizzahut","title":"Pizza Hut","description":"<p>Make it great</p>","category":"food","x":"0.6265","y":"0.3150","pin":"hidden","action":"tooltip"},{"id":"subway","title":"Subway","description":"<p>Eat fresh.</p>","category":"food","x":"0.7110","y":"0.5294","pin":"hidden","action":"tooltip"},{"id":"cvs","title":"CVS Pharmacy","description":"<p>Lorem ipsum <a href=\"http://www.codecanyon.net\">dolor sit</a> amet, consectetur.</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.5188","y":"0.2731","pin":"hidden","action":"tooltip"},{"id":"pullnbear","title":"Pull & Bear","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.4854","y":"0.3293","pin":"hidden","action":"tooltip"},{"id":"amc","title":"AMC Theatres","description":"<p>Additional information</p>","category":"misc","x":"0.6630","y":"0.6452","pin":"hidden","action":"tooltip"},{"id":"atnt","title":"AT&T","description":"<p>Additional information</p>","category":"misc","actionx":"open-link-new-tab","x":"0.3749","y":"0.5386","pin":"hidden","action":"tooltip"}]}],"maxscale":4,"minimap":true,"zoombuttons":true,"sidebar":true,"search":true,"hovertip":true,"fullscreen":true,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":true,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"","action":"tooltip"}'
		)
	);

	// Apartment Example
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] Apartment',
			'data' => '{"mapwidth":"2000","mapheight":"2000","minimap":true,"sidebar":true,"search":true,"hovertip":true,"zoomlimit":"1","categories":[{"id":"furniture","title":"Furniture","color":"#4cd3b8","show":"false"},{"id":"rooms","title":"Rooms","color":"#63aa9c"}],"levels":[{"id":"lower","title":"Lower","map":"' . $exampledir . '/apartment/lower.jpg","minimap":"' . $exampledir . '/apartment/lower-small.jpg","locations":[{"id":"coffeetable","title":"Coffee Table","description":"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>","category":"furniture","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.2067","y":"0.4660","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"stairstop","title":"Stairs","description":"<p>Let\'s go upstairs!</p>","category":"furniture","x":"0.5057","y":"0.6173","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"diningtable","title":"Dining Table","description":"<p>An eight-person dining table with an image.</p>","category":"rooms","x":"0.4746","y":"0.2883","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"coffeemachine","title":"Coffee Machine","description":"<p>Coffee Machine</p>","category":"furniture","x":"0.6792","y":"0.3459","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"workingtable","title":"Working Table","description":"It\'s the perfect home workspace you\'ve always dreamed about.","category":"furniture","x":"0.6285","y":"0.1480","zoom":"3"},{"id":"kitchen","title":"Kitchen","description":"<p>Welcome to the kitchen.</p>","category":"rooms","link":"http://codecanyon.net/user/sekler?ref=sekler","pin":"hidden","x":"0.6650","y":"0.4600","zoom":"3","action":"tooltip"},{"id":"dining","title":"Dining room","description":"<p>The main living room</p><!--<iframe width=\"320\" height=\"180\" src=\"//www.youtube.com/embed/HGy9i8vvCxk\" frameborder=\"0\" allowfullscreen></iframe>-->","category":"rooms","pin":"hidden","x":"0.2966","y":"0.3795","zoom":"3","action":"tooltip"}]},{"id":"upper","title":"Upper","map":"' . $exampledir . '/apartment/upper.jpg","minimap":"' . $exampledir . '/apartment/upper-small.jpg","locations":[{"id":"livingup","title":"Living room","description":"<p>I could spend the whole day here!</p>","category":"rooms","x":"0.4900","y":"0.3600","zoom":"2","pin":"no-fill","action":"tooltip"},{"id":"kingbed","title":"King bed","description":"<p>A king size bed situated in the main bedroom on the first floor.</p>","category":"furniture","x":"0.6564","y":"0.2782","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"bathroom","title":"Bathroom","description":"<p>Take a bath!</p>","category":"rooms","pin":"hidden","x":"0.7843","y":"0.4035","mapfill":"true","zoom":"3","action":"tooltip"}]}],"maxscale":1,"zoombuttons":true,"fullscreen":false,"mapfill":true,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":false,"fillcolor":"","action":"tooltip"}'
		)
	);
}
register_activation_hook(__FILE__, 'custommap_install');

function custommap_update_db_check() {
	global $custommap_db_version;
	if (get_option('custommap_db_version') != $custommap_db_version) {
		custommap_install();
	}
}
add_action('plugins_loaded', 'custommap_update_db_check');