jQuery(document).ready(function(){
	
	 //jQuery('#template_layouts').css({"display":"none"});
	 var skins_input;                                                               //template skin addnew on click
	 var skin_count = jQuery('#hid_skin_count').val();
     
	 jQuery('#add_new_skin').click(function(){ 
	       
		   skin_count++;
		   
		   skins_template();
		   jQuery('.template_skins_container').append(skins_input);
		   jQuery('#hid_skin_count').val(skin_count);
		  
	  });
	  
	    
	  jQuery('.template_skins_container').on('click', '.delete_skin', function() {       //template skin remove 
		 if (!confirm('Are you sure want to delete?')) return false;
		 jQuery(this).parent().parent().parent().remove();
		 
		 var hid_skin_count_update = jQuery('.template_skins_container').find('.template_skins').length;     //template hidden skin count update after remove
		 jQuery('#hid_skin_count').val(hid_skin_count_update);
	  });
	
	function skins_template(){                                                      //template skin addnew on click
		
		skins_input = '<div class="template_skins">' +
							'<div class="template_skins_inner">' +
							  '<div><select name="sett_map_skin_FT[]"  style="width:280px;">' +
							             '<option value="" selected>---select---</option>' +
										 '<option value="administrative">administrative</option>' +
										 '<option value="administrative.country">administrative.country</option>' +
										 '<option value="administrative.land_parcel">administrative.land_parcel</option>' +
										 '<option value="administrative.locality">administrative.locality</option>' +
										 '<option value="administrative.neighborhood">administrative.neighborhood</option>' +
										 '<option value="administrative.province">administrative.province</option>' +
										 '<option value="all">all</option>' +
										 '<option value="landscape">Landscape</option>' +
										 '<option value="landscape.man_made">landscape.man_made</option>' +
										 '<option value="landscape.natural">landscape.natural</option>' +
										 '<option value="landscape.natural.landcover">landscape.natural.landcover</option>' +
										 '<option value="landscape.natural.terrain">landscape.natural.terrain</option>' +
										 '<option value="poi">poi</option>' +
										 '<option value="poi.attraction">poi.attraction</option>' +
										 '<option value="poi.business">poi.business</option>' +
										 '<option value="poi.government">poi.government</option>' +
										 '<option value="poi.medical">poi.medical</option>' +
										 '<option value="poi.park">poi.park</option>' +
										 '<option value="poi.place_of_worship">poi.place_of_worship</option>' +
										 '<option value="poi.school">poi.school</option>' +
										 '<option value="poi.sports_complex">poi.sports_complex</option>' +
										 '<option value="road">road</option>' +
										 '<option value="road.arterial">road.arterial</option>' +
										 '<option value="road.highway">road.highway</option>' +
										 '<option value="road.highway.controlled_access">road.highway.controlled_access</option>' +
										 '<option value="road.local">road.local</option>' +
										 '<option value="transit">transit</option>' +
										 '<option value="transit.line">transit.line</option>' +
										 '<option value="transit.station">transit.station</option>' +
										 '<option value="transit.station.airport">transit.station.airport</option>' +
										 '<option value="transit.station.bus">transit.station.bus</option>' +
										 '<option value="transit.station.rail">transit.station.rail</option>' +
										 '<option value="water">water</option></select>' +
										 
							  ' </div>' +
							'</div> ' +
				   
						    '<div class="template_skins_inner">' +
							  '<div><select name="sett_map_skin_PR[]"  style="width:250px;">' +
							        '<option value="" selected>---select---</option>' +
									'<option value="all">all</option>' +
									'<option value="geometry">geometry</option>' +
									'<option value="geometry.fill">geometry.fill</option>' +
									'<option value="geometry.stroke">geometry.stroke</option>' +
									'<option value="labels">labels</option>' +
									'<option value="labels.icon">labels.icon</option>' +
									'<option value="labels.text">labels.text</option>' +
									'<option value="labels.text.fill">labels.text.fill</option>' +
									'<option value="labels.text.stroke">labels.text.stroke</option></select>' +
							  '</div>' +
						    '</div>' +
				   
						    '<div class="template_skins_inner">' +
							  '<div><input type="text" name="sett_map_skin_PR_color[]" pattern="[#][0-9A-Za-z]*" title="Invalid format color" style="width:150px;" /></div>' +
						    '</div>' +
				   
						    '<div class="template_skins_inner">' +
							 '<div><select name="sett_map_skin_PR_visibility[]"  style="">' +
							             '<option value="" selected>---select---</option>' +
										 '<option value="1">On</option>' +
										 '<option value="2">Off</option>' +
										 '<option value="3">simplified</option>' +
								   '</select></div>' +
						    '</div>' +
							
							'<div class="template_skins_inner">' +
							  '<div><input type="text" style="width:90px;" name="sett_map_skin_PR_lightness[]" pattern="[0-9-]*" title="Invalid format lightness" /></div>' +
						    '</div>' +
							
							'<div class="template_skins_inner">' +
							  '<div><input type="hidden" style="width:90px;" name="sett_map_skin_PR_hue[]" pattern="[#][0-9A-Za-z]*" title="Invalid format hue" /></div>' +
						    '</div>' +
							
							'<div class="template_skins_inner">' +
							  '<div><input type="hidden" style="width:80px;" name="sett_map_skin_PR_saturation[]" pattern="[0-9-]*" title="Invalid format saturation" /></div>' +
						    '</div>' +
							
							'<div>' +
							  '<div><a class="delete_skin">X</a></div>' +
							'</div>' +
		   
	                   '</div>'; 
						
		
	}
	
	
	
	
	
	//template layout select
	 
	 jQuery('#sett_map_layouts').change(function(){
		 
		var layout_selected =  jQuery('#sett_map_layouts').val();
		
		if(layout_selected == "L1"){
			jQuery('#template_layouts').hide();
		}
		
		if(layout_selected == "L2"){
			
			jQuery('#template_layouts').show();
			jQuery('#template_layout_search').show();
			jQuery('#template_layout_list').hide();
			jQuery('#template_layout_category').hide();
		
		     
		}
		if(layout_selected == "L3"){
			
			jQuery('#template_layouts').show();
			jQuery('#template_layout_search').show();
			jQuery('#template_layout_list').show();
			jQuery('#template_layout_category').hide();
		}
		if(layout_selected == "L4"){
			
			
			jQuery('#template_layouts').show();
			jQuery('#template_layout_search').show();
			jQuery('#template_layout_list').show();
			jQuery('#template_layout_category').show();
		}
		
		
	 });
	 
	 
	
	 
	 
 });