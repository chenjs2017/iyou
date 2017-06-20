jQuery(document).ready(function($) {
	// Sortable lists
	$('.sortable-list').sortable({
		placeholder: 'list-item-placeholder',
		forcePlaceholderSize: true,
		handle: '.list-item-handle'
	});

	$(document).on('keyup', '.title-input', function(event) {
		var text = $(this).val();
		if (text === '') text = 'undefined';

		$(this).closest('.list-item').find('.menu-item-title').text(text);
	});

	$(document).on('click', '.menu-item-toggle', function(event) {
		event.preventDefault();
		$(this).closest('.list-item').children('.list-item-settings').slideToggle(200);
		$(this).toggleClass('opened');
	});

	// Export Indentation
	$('#mapplic-export-indented').change(function() {
		var ischecked = $(this).is(':checked'),
			object = JSON.parse($('#mapplic-export').val());
		if (ischecked) $('#mapplic-export').val(JSON.stringify(object, null, 4));
		else $('#mapplic-export').val(JSON.stringify(object));
	});

	// Import select
	$("#mapplic-new-type").change(function() {
		if ($(this).val() == 'import') $('#mapplic-import').show();
		else $('#mapplic-import').hide();
	});

	// WordPress colorpicker
	$('.mapplic-color-picker').wpColorPicker();

	// Media buttons
	$(document).on('click', '.media-button', function(event) {
		var button = this;

		var media_popup = wp.media({
			title: 'Select or Upload File',
			button: { text: 'Select' },
			multiple: false
		});

		media_popup.on('select', function() {
			var attachment = media_popup.state().get('selection').first().toJSON();
			$(button).closest('div').find('.input-text').val(attachment.url);
		}).open();
	});

	// Item actions
	$(document).on('click', '.item-cancel', function(event) {
		event.preventDefault();
		$(this).closest('.list-item-settings').slideToggle(200);
	});

	$(document).on('click', '.item-delete', function(event) {
		event.preventDefault();
		if (confirm('Are you sure you want to delete the selected item?')) {
			$(this).closest('.list-item').remove();
		}
	});

	// Categories
	$('#new-category').click(function() {
		$('#category-list .new-item').clone().removeClass('new-item').appendTo('#category-list');
	});

	// Floors
	$('#new-floor').click(function() {
		$('#floor-list .new-item').clone().removeClass('new-item').appendTo('#floor-list');
	});

	// Pin switcher
	$('#pins-input > li').click(function() {
		$('#pins-input .selected').removeClass('selected');
		$(this).addClass('selected');

		// Show label field only when it's available
		if ($('.mapplic-pin', this).hasClass('pin-label')) $('#landmark-settings .label-input').show();
		else $('#landmark-settings .label-input').hide();

		var selected = $('.selected-pin');
		if (selected.length) {

			var data = selected.data('landmarkData'),
				pin = $('.mapplic-pin', this).data('pin');

			selected.attr('class', 'mapplic-pin selected-pin ' + pin);
			data.pin = pin;
		}
	});

	// New landmark
	$('#new-landmark').click(function() {
		// Remove selection if any
		$('.selected-pin').removeClass('selected-pin');
		// Show the cleared landmark fields
		$('#landmark-settings').show();
		$('#landmark-settings input[type="text"]').val('');
		tinyMCE.activeEditor.setContent('');
		$('#landmark-settings .category-select').val('false');
		$('#landmark-settings .action-select').val('default');
		// Change button text
		$('#save-landmark').val('Add');
	});

	$('#save-landmark').click(function() {
		var data = null,
			selected = $('.selected-pin');
		
		if (selected.length) {
			data = selected.data('landmarkData');
			saveLandmarkData(data);
		}
		else {
			// Add new landmark
			data = {};
			saveLandmarkData(data);

			data.x = 0.5;
			data.y = 0.5;
			$(this).val('Save');

			$.each(mapData.levels, function(index, level) {
				if (level.id == shownLevel) {
					level.locations.push(data);
				}
			});

			// Add new pin to the map
			var pin = $('<a></a>').attr({'href': '#' + data.id, 'title': data.title}).addClass('mapplic-pin selected-pin').addClass(data.pin).css({'top': '50%', 'left': '50%'}).click(function(e) {
				e.preventDefault();
			}).appendTo($('.mapplic-layer:visible'));
			pin.data('landmarkData', data);
		}
	});

	$('#delete-landmark').click(function() {
		var data = $('.selected-pin').data('landmarkData');

		// Remove the location and pin
		if (data) {
			data.id = null;
			$('.selected-pin').remove();
		}

		// Hide the settings
		$('#landmark-settings').hide();
	});

	var saveLandmarkData = function(data) {
		data.id 			= $('#landmark-settings .id-input').val();
		data.title 			= $('#landmark-settings .title-input').val();
		data.description 	= $('#wp-descriptioninput-wrap').hasClass('html-active') ? $('#descriptioninput').val() : tinyMCE.activeEditor.getContent();
		data.lat 			= $('#landmark-settings .landmark-lat').val();
		data.lng 			= $('#landmark-settings .landmark-lng').val();
		data.pin 			= $('#pins-input .selected .mapplic-pin').data('pin');
		data.label 			= $('#landmark-settings .label-input').val();
		data.fill 			= $('#landmark-settings .fill-input').val();
		data.link 			= $('#landmark-settings .link-input').val();
		data.category 		= $('#landmark-settings .category-select').val();
		data.thumbnail 		= $('#landmark-settings .thumbnail-input').val();
		data.action 		= $('#landmark-settings .action-select').val();
		data.about 			= $('#landmark-settings .about-input').val();
		data.zoom 			= $('#landmark-settings .zoom-input').val();
	}

	var getParameter = function(param) {
		var pageURL = window.location.search.substring(1);
		var variables = pageURL.split('&');
		for (var i = 0; i < variables.length; i++) {
			var paramName = variables[i].split('=');
			if (paramName[0] == param) {
				return paramName[1];
			}
		}
	}

	// Load the map
	$('#admin-map').mapplic({
		id: getParameter('map'),
		height: 420,
		locations: true,
		sidebar: false,
		search: true,
		minimap: true,
		slide: 0
	});

	var invalid;
	var errormsg;

	// Form submit
	$('.form-submit').click(function(event) {
		invalid = false;

		var newData = {};

		if (typeof mapData === 'undefined') mapData = {};
		else newData = mapData;

		// Map File Dimensions
		newData['mapwidth'] 	= $('#setting-mapwidth').val();
		newData['mapheight'] 	= $('#setting-mapheight').val();

		// Components and Features
		newData['minimap'] 		= $('#setting-minimap').is(':checked');
		newData['clearbutton'] 	= $('#setting-clearbutton').is(':checked');
		newData['zoombuttons'] 	= $('#setting-zoombuttons').is(':checked');
		newData['sidebar'] 		= $('#setting-sidebar').is(':checked');
		newData['search'] 		= $('#setting-search').is(':checked');
		newData['hovertip'] 	= $('#setting-hovertip').is(':checked');
		newData['mousewheel'] 	= $('#setting-mousewheel').is(':checked');
		newData['fullscreen'] 	= $('#setting-fullscreen').is(':checked');
		newData['deeplinking'] 	= $('#setting-deeplinking').is(':checked');

		// General Settings
		newData['mapfill'] 		= $('#setting-mapfill').is(':checked');
		newData['zoom'] 		= $('#setting-zoom').is(':checked');
		newData['alphabetic'] 	= $('#setting-alphabetic').is(':checked');
		var zoomlimit = $('#setting-zoomlimit').val();
		newData['zoomlimit'] 	= (isNaN(zoomlimit) || zoomlimit == '') ? 4 : zoomlimit;
		newData['fillcolor'] 	= $('#setting-fillcolor').val();
		newData['action'] 		= $('#setting-action').val();

		// Geolocation
		if ($('#geopos > #topLat').val()) newData['topLat'] = $('#geopos > #topLat').val();
		if ($('#geopos > #leftLng').val()) newData['leftLng'] = $('#geopos > #leftLng').val();
		if ($('#geopos > #bottomLat').val()) newData['bottomLat'] = $('#geopos > #bottomLat').val();
		if ($('#geopos > #rightLng').val()) newData['rightLng'] = $('#geopos > #rightLng').val();

		// Fetching data
		newData['categories'] 	= getCategories();
		newData['levels'] 		= getLevels();

		$('#input-data').val(JSON.stringify(newData));
	});

	$('#mapplic-form').submit(function(e) {
		if (invalid) {
			alert(errormsg);
			e.preventDefault();
		}
	});

	var getCategories = function() {
		var categories = [];
		$('#category-list .list-item:not(.new-item)').each(function() {
			var category = {};
			
			category['id']       = $('.id-input', this).val();
			category['title']    = $('.title-input', this).val();
			category['color']    = $('.color-input', this).val();
			if (!$('.expand-input', this).is(':checked')) {
				category['show'] = 'false';
			}

			// Validation
			if (category['id'] == '') {
				if (!invalid) errormsg = 'The category titled "' + category['title'] + '" has no ID.';
				invalid = true;
			}

			categories.push(category);
		});

		return categories;
	}

	var getLevels = function() {
		var levels = [];
		$('#floor-list .list-item:not(.new-item)').each(function() {
			var level = {};

			level['id']        = $('.id-input', this).val();
			level['title']     = $('.title-input', this).val();
			level['map']       = $('.map-input', this).val();
			level['minimap']   = $('.minimap-input', this).val();
			if ($('.show-input', this).is(':checked')) {
				level['show']  = 'true';
			}
			level['locations'] = getLocations(level['id']);

			// Validation
			if (level['id'] == '') {
				if (!invalid) errormsg = 'The floor titled "' + level['title'] + '" has no ID.';
				invalid = true;
			}

			levels.push(level);
		});

		levels.reverse();

		return levels;
	}

	var getLocations = function(targetLevel) {
		var locations = [];
		
		if (typeof mapData.levels !== 'undefined') {
			$.each(mapData.levels, function(index, level) {
				if (level.id == targetLevel) {
					$.each(level.locations, function(index, location) {
						if (location.id !== null) {
							delete location.el;

							for (var key in location) {
								if (location[key] == '') delete location[key];
							}
							locations.push(location);
						}
					});
				}
			});
		}
		
		return locations;
	}
});