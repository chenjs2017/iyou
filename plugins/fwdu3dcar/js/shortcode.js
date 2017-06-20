jQuery(document).ready(function($)
{
	$.each(fwdu3dcarPresetsObj, function(i, el)
	{
		$("#fwdu3dcar_presets_list").append("<option value='" + el.id + "'>" + el.name + "</option>");
		sid = $("#fwdu3dcar_presets_list").val();
		setShortodeIntext();
	});

	$("#fwdu3dcar_presets_list").change(function()
	{
		sid = $("#fwdu3dcar_presets_list").val();
		setShortodeIntext();
	});
	
	function setShortodeIntext(){
		if(fwdu3dcarPlaylistsObj.length > 0){
			$("#fwdu3dcar_shortocde").val('[fwdu3dcar preset_id="' + sid + '" product_id="' + pid + '"]');
			$("#fwdu3dcar_shortocde").show();
		}else{
			$("#fwdu3dcar_shortocde").hide();
		}
	}
	
	$("#fwdu3dcar_div").hide();
		
	if (fwdu3dcarPlaylistsObj.length > 0)
	{
		$.each(fwdu3dcarPlaylistsObj, function(i, el)
		{
			$("#fwdu3dcar_playlists_list").append("<option value='" + el.id + "'>" + el.name + "</option>");
		});

		$("#fwdu3dcar_playlists_list").change(function()
		{
			pid = $("#fwdu3dcar_playlists_list").val();
			setShortodeIntext();
		});
		
		var sid = $("#fwdu3dcar_presets_list").val();
		var pid = $("#fwdu3dcar_playlists_list").val();
		
		$("#fwdu3dcar_shortcode_btn").click(function()
		{		
			if (typeof tinymce != "undefined")
			{
			    var editor = tinymce.get("content");
			    
			    if (editor && editor instanceof tinymce.Editor)
			    {
			        editor.selection.setContent('[fwdu3dcar preset_id="' + sid + '" playlist_id="' + pid + '"]');
			        editor.save({no_events: true});
			    }
			    else
			    {
			        $("textarea#content").append('[fwdu3dcar preset_id="' + sid + '" playlist_id="' + pid + '"]');
			    }
			    
			    $("#fwdu3dcar_div").hide();
			    $("#fwdu3dcar_div").fadeIn(600);
			    $("#fwdu3dcar_msg").html("The shortcode has been added!");
			}
			
			return false;
		});
	}
	else
	{
		var td = $("#fwdu3dcar_playlists_list").parent();
		
		$("#fwdu3dcar_playlists_list").remove();
		td.append("<em style='margin-left:8px;'>No playlists are available.</em>");
		
		$("#fwdu3dcar_shortcode_btn").prop("disabled", true);
		$("#fwdu3dcar_shortcode_btn").css("cursor", "default");
	}
	
	setShortodeIntext();
});