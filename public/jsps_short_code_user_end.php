<?php
/*
 * Jsps shortcode creation for displaying map with  values
 * @link      
 * @since      1.0.0
 * @package    RAMPiT World Map
 * @subpackage RAMPiT World Map/public
 * @author     RAMPiT
 */
 
 if ( ! defined( 'ABSPATH' ) ) exit;
 
/*
 *  Create map shortcode
 */
add_shortcode( 'pin', 'jsps_pin');
function jsps_pin($args, $content = null){                                                    
?>
      jsps_map_pin(<?php echo json_encode($args);?>,<?php echo '"'.$content.'"'; ?>);             
<?php
}
add_shortcode('jsps_world_map','jsps_world_map');

function jsps_world_map($args, $content, $tag) {
          
	// Set all variables
	 foreach ($args as $key => $val) {
		 if($val >= 0 && intval($val)){
			 $args[$key] = $val;
		 }else{
			$args[$key] = 1;
		 }
	}
	if(isset($args['temp'])){
		if($args['temp'] >= 0){
			$args['temp'] = $args['temp'];
		}
	}else{
		$args['temp'] = 0;
	}
	if(empty($args) || ( !isset($args['id']) && !isset($args['cat']) && !isset($args['temp']) ) ){
	  
	  /* Its  used for shortcode upcoming future */
	  
	 /* $Latitude ='34.8375';
	  $Longitude ='-106.2371';
	  $default_height = '350px';
	  if(isset($args['zoom'])){
		 $map_zoom = $args['zoom'];  
	  }else{
		 $map_zoom ='5';
	  } 
	  if(isset($args['width'])){
		  $mapwidth = $args['width'];
	  }else{
		  $mapwidth ='100%';
	  }
	  if(isset($args['height']) ){
		  $mapheight = $args['height']; 
		  $default_height = $args['height']; 
	  }else{
		  $mapheight ='350px';
	  }
	  if(isset($args['full_window'])){ 
	     if($args['full_window'] == 1){ 
			$mapheight ='100%';}
		 else{ 
			$mapheight = $default_height;
		 }
      }
	  if(isset($args['disable_zoom'])){ 
		  if($args['disable_zoom'] == 0){ 
			$scrollwheel ='false';
		  } else{ 
			$scrollwheel ='true';
		  } 
	  }else{ 
		  $scrollwheel ='true'; 
	  }
	  if(isset($args['map_type'])){
		  $maytypeid = $args['map_type'];
	  }else{
		  $maytypeid ='Road';
	  }
	  
	  $zoom ='true';
	  $maytype ='true';
	  $scale ='true';
	  $mapzindex =9999;*/
	}
	else{
	  
	if(isset($args['id'])){
		
		$Latitude ='34.8375';
		$Longitude ='-106.2371';  
		$map_zoom ='2';
		$maytypeid ='Road';
		$scrollwheel ='true';
		$mapwidth = '100%';
		$mapheight = '500px';
		$mapzindex = 1;
		
		$zoom ='false';
		$maytype ='false';
		$scale ='false';
		
		  if(isset($args['template'])){
			  
			$template_design = jsps_world_map_template_property_retrive($args['template']);     //template properties from template table
			$template_val = json_decode(json_encode($template_design), true);
			
			$template_skins = jsps_world_map_template_skins($args['template']);                 //template properties skins from template_skins table
			$template_skins_val = json_decode(json_encode($template_skins), true);
			if(isset($template_val[0]['Center_latitude'])){
				if($template_val[0]['Center_latitude'] && is_float($template_val[0]['Center_latitude'])){
					$Latitude = $template_val[0]['Center_latitude'];
				}
			}else{
				$Latitude ='34.8375';
			}
			if(isset($template_val[0]['Center_longitude'])){
				if($template_val[0]['Center_longitude'] && is_float($template_val[0]['Center_longitude'])){
					$Longitude = $template_val[0]['Center_longitude'];
				}
			}else{
				$Longitude ='-106.2371';
			}
			if(isset($template_val[0]['Zoom_level'])){
				if($template_val[0]['Zoom_level'] && intval($template_val[0]['Zoom_level'])){
					$map_zoom = $template_val[0]['Zoom_level'];
				}
			}else{
				$map_zoom ='2';
			}
			if(isset($template_val[0]['maptypeid'])){
				if($template_val[0]['maptypeid']){
					$maytypeid = sanitize_text_field($template_val[0]['maptypeid']);
				}
			}else{
				$maytypeid ='Road';
			}
			if(isset($template_val[0]['width'])){
				if($template_val[0]['width']){
					$mapwidth = sanitize_text_field($template_val[0]['width']);
				}
			}else{
				$mapwidth ='100%';
			}
			if(isset($template_val[0]['height'])){
				if($template_val[0]['height']){
					$mapheight = sanitize_text_field($template_val[0]['height']);
				}
			}else{
				$mapheight ='500px';
			}
			if(isset($template_val[0]['template_fullwindow'])){
				if($template_val[0]['template_fullwindow']){
					$map_fullwindow = sanitize_text_field($template_val[0]['template_fullwindow']); 
				}
			}
			if(isset($template_val[0]['template_fixedheight'])){
				if($template_val[0]['template_fixedheight']){
					$map_fixedheight = sanitize_text_field($template_val[0]['template_fixedheight']); 
				}
			}
			if(isset($template_val[0]['background'])){
				if($template_val[0]['background'] == 0 && intval($template_val[0]['background'])){
					$mapzindex = 0; 
				}
			}else{
				$mapzindex = 1;
			}
			if(isset($template_val[0]['Zoom_control'])){
				if($template_val[0]['Zoom_control'] == 1){
					 $zoom = 'true';
				}
			}else{
				$zoom ='false';
			}
			if(isset($template_val[0]['Maptype_control'])){
				if($template_val[0]['Maptype_control'] == 1){
					$maytype = 'true';
				}
			}else{
				$maytype ='false';
			}
			if(isset($template_val[0]['Scale_control'])){
				if($template_val[0]['Scale_control'] == 1 ){
					$scale ='true';
				}
			}else{
				$scale ='false';
			}
			if(isset($template_val[0]['scroll_wheel'])){
				if($template_val[0]['scroll_wheel'] == 1){
					$scrollwheel ='true';
				}
			}else{
				$scrollwheel ='false';
			}
			if(isset($template_val[0]['temp_layout'])){
				if($template_val[0]['temp_layout']){
					$layout_type =  sanitize_text_field($template_val[0]['temp_layout']);
				}
			}
			if(isset($template_val[0]['search_form_show'])){
				if($template_val[0]['search_form_show']){
					$search_show =  sanitize_text_field($template_val[0]['search_form_show']);
				}
			}
			if(isset($template_val[0]['search_form_position'])){
				if($template_val[0]['search_form_position']){
					$search_position =  sanitize_text_field($template_val[0]['search_form_position']);
				}
			}
			if(isset($template_val[0]['list_form_show'])){
				if($template_val[0]['list_form_show']){
					$list_show =  sanitize_text_field($template_val[0]['list_form_show']);
				}
			}
			if(isset($template_val[0]['list_form_position'])){
				if($template_val[0]['list_form_position']){
					$list_position =  sanitize_text_field($template_val[0]['list_form_position']);
				}
			}
			if(isset($template_val[0]['category_filter_show'])){
				if($template_val[0]['category_filter_show']){
					$filter_show =  sanitize_text_field($template_val[0]['category_filter_show']);
				}
			}
			if(isset($template_val[0]['category_filter_position'])){
				if($template_val[0]['category_filter_position']){
					$filter_position = sanitize_text_field($template_val[0]['category_filter_position']);
				}
			}
		  }
		}
	 }

	 $cur_location_dis_page_id = jsps_map_get_current_location_info_page_id();
	 ob_start();
		if(isset($args['id'])){
			$mapid = $args['id'];
		}
		else{
			$mapid = "P1";
		}			
	 if(isset($args['id'])){
		 //$list_location_width_whole ='';
		 $map_width_whole ='100%';
		 if($layout_type !== 'L1'){
						 if($list_show == 1){
							  if($list_position == 3 || $list_position == 4){
								$list_location_width_whole = '20%';
								$map_width_whole = '80%';					
							   }
						 }
		 }
		if($map_fullwindow == 1){
			 $mapwidth = '100%';
			 $list_location_width_whole = '20%';
			 
			 if($list_show == 1 && ($list_position == 3 || $list_position == 4)){  
				$map_width_whole = '80%';		
			 }
			 else{
				 $map_width_whole = '100%';	
			 }
			 
			 $mapheight = '350px';
			 if($map_fixedheight){
				 $mapheight = $map_fixedheight;
			 }
		}
	 }
	?>

	<div class="map_container" style="float:left; width:<?php echo esc_html($mapwidth); ?>;">

		<?php if(isset($args['id'])) { 
					if($layout_type !== 'L1'){
						 if($search_show == 1){
							  if($search_position == 1){
								  jsps_search_container($mapid);             
								  
						  } }  
						  
						  if($list_show == 1){
							  if($list_position == 1){
								  jsps_list_location_map_top_bottom($mapid,$mapwidth);
					
						  } } 
						  
						  
			   } } ?>

		<div class="map_container_inner">
		  <?php if(isset($args['id'])) { 
					 if($layout_type !== 'L1'){ 
						if($list_show == 1){
							if($list_position == 3){	
								jsps_list_location_map_left_right($mapid,$mapheight,$list_location_width_whole);
							} 
						} 
					 } 
				} 
			?>
			<?php if(isset($args['id'])) { ?> <div style="float:left; width:<?php echo esc_html($map_width_whole); ?>; position: relative;">  <?php } ?>
			 <?php 
				  $map_final_width = '100%'; 
				  //Template 10
				  /*if(isset($args['id'])){ if($args['template'] == '10'){ 
						$map_final_width = 'calc(100% - 300px)';
				  } }*/
			  ?>
			  <div id="rampit_map<?php echo esc_html($mapid); ?>" style="float:left; height:<?php echo esc_html($mapheight); ?>; width:<?php echo esc_html($map_final_width); ?>; z-index:<?php echo esc_html($mapzindex); ?>; margin-bottom: 1.6842em"></div> 
			  <!-- Template 10 -->
			  <?php if(isset($args['id'])){ if($args['template'] == '10'){
					 ?>
					  <div class="jsps_map_template_10"></div>
			  <?php  } }  ?>
			  
				<?php if(isset($args['id'])) { 
						 if($layout_type !== 'L1'){ 
							if($filter_show == 1){ ?>
							   <div style="position: absolute;z-index: 999;top:50px;<?php if($filter_position == 1){?> left:5px;<?php } else { ?> right:5px; <?php } ?>">
									<?php jsps_load_category_filter($mapid); ?>
							   </div>
				<?php } } } ?>
			<?php if(isset($args['id'])) { ?> </div>  <?php } ?>
			  <?php if(isset($args['id'])) { 
					 if($layout_type !== 'L1'){ 
						if($list_show == 1){
							if($list_position == 4){	
								jsps_list_location_map_left_right($mapid,$mapheight,$list_location_width_whole);
							} 
						}
					 } 
					} 
			 ?>  	   
		</div> 
		<?php if(isset($args['id'])) { 
					if($layout_type !== 'L1'){
						 if($search_show == 1){
							  if($search_position == 2){
								  jsps_search_container($mapid);             
							  } 
						} 
						if($list_show == 1){
							  if($list_position == 2){
								  jsps_list_location_map_top_bottom($mapid,$mapwidth);
							 } 
						} 
		 } } ?>
	</div>

	<style>
	.map_container_inner rampit_map<?php echo esc_html($mapid); ?>,map_list_item {display:inline-block;}
	</style>

	<?php if(isset($args['id'])){ if($args['template'] == '10'){ ?>
	<script>
	var res_mapwidth =<?php echo esc_html(substr($mapwidth,0,-2)); ?>;
	res_temp10_resize();

	jQuery(window).resize(function(){
		res_temp10_resize();
	});

	function res_temp10_resize(){
		 if(jQuery(window).width() < res_mapwidth){
			
			jQuery('.map_container').addClass('res_temp_10_map_width');
			jQuery('#rampit_map<?php echo esc_html($mapid); ?>').addClass('res_temp_10_rampit_map');
			jQuery('.jsps_map_template_10').addClass('res_temp_10_container');
			jQuery('.jsps_map_template_10_clink').addClass('res_temp_10_clink');
		 }
	}
	</script>

	<?php } } ?>

	<script type='text/javascript'>
	google.maps.event.addDomListener(window, 'load', init_jsps_map);

	var map<?php echo esc_html($mapid); ?>;
	var marker;
	var markers<?php echo esc_html($mapid); ?> = [];
	function init_jsps_map() {
	map<?php echo esc_html($mapid); ?> = new google.maps.Map(document.getElementById('rampit_map<?php echo esc_html($mapid); ?>'), {
	center: {lat:<?php echo esc_html($Latitude); ?>, lng:<?php echo esc_html($Longitude); ?>},
	mapTypeId: google.maps.MapTypeId.<?php echo esc_html($maytypeid); ?>,
	zoom: <?php echo esc_html($map_zoom); ?>,
	zoomControl:<?php echo esc_html($zoom); ?>,
	mapTypeControl:<?php echo esc_html($maytype); ?>,
	scaleControl:<?php echo esc_html($scale); ?>,
	scrollwheel:<?php echo esc_html($scrollwheel); ?>,

	<?php if(isset($args['id'])) {  
				if(isset($args['template'])) {		?>
		   styles: [
					<?php foreach($template_skins_val as $skin_val){ 
					    if(isset($skin_val['visibility'])){
							if($skin_val['visibility'] == 1 && intval($skin_val['visibility'])){
								$visibility = 'on';
							}elseif($skin_val['visibility'] == 2 && intval($skin_val['visibility'])){
								$visibility = 'off'; 
							} else{ 
								$visibility = 'simplified'; 
							}
						} 
						if(isset($skin_val['feature_type'])){
								$skin_val['feature_type'] = sanitize_text_field($skin_val['feature_type']);
						} 
						if(isset($skin_val['feature_type_property'])){
							$skin_val['feature_type_property'] = sanitize_text_field($skin_val['feature_type_property']);
						} 
						if(isset($skin_val['color'])){
							$skin_val['color'] = sanitize_text_field($skin_val['color']);
						} 
					?>
						{ "featureType": <?php echo '"'.esc_html($skin_val['feature_type']).'"'  ?>, "elementType": <?php echo '"'.esc_html($skin_val['feature_type_property']).'"'  ?>, "stylers": [ { "visibility": <?php echo '"'.esc_html($visibility).'"'  ?> },{ "color": <?php echo '"'.esc_html($skin_val['color']).'"'  ?> },{"lightness": <?php echo '"'.esc_html($skin_val['lightness']).'"'  ?>},{"hue":<?php echo '"'.esc_html($skin_val['hue']).'"'  ?> },{"saturation": <?php echo '"'.esc_html($skin_val['saturation']).'"'  ?>} ] },
					<?php }  ?>
		   ]
	<?php } } ?>
	});

	<?php  
	
		if (!empty($args))
		{   
			if($args['temp'] == 1){
				$locations = jsps_world_map_location_value();
			}
			   
			if(isset($args['cat'])){
				$locations = jsps_world_map_by_category_value($args['cat']);
			}
			   
			if(isset($args['id'])){
				$locations = jsps_world_map_by_mayID($args['id']);
			}
		}
         $locations_array_val = array();
		 foreach($locations as $key){ 
			if(isset($key->location_id)){
				 if(intval( $key->location_id)){
					$location_id =  $key->location_id;
				 }else{
					$location_id = ''; 
				 }
			}
			 $locations_array_val['location_id'] = $location_id;
			 $Location_title   = stripslashes_deep(htmlentities($key->Location_title, ENT_QUOTES));
			 $locations_array_val['Location_title'] = sanitize_text_field($Location_title);
			 $Location_address = sanitize_text_field($key->Location_address);
			 $locations_array_val['Location_address'] = $Location_address;
			 $Latitude = sanitize_text_field($key->Latitude);
			 $locations_array_val['Latitude'] = $Latitude;
			 $Longitude = sanitize_text_field($key->Longitude);
			 $locations_array_val['Longitude'] = $Longitude;
			 $Location_description = stripslashes_deep(htmlentities($key->Location_description, ENT_QUOTES));
			 $locations_array_val['Location_description'] = sanitize_text_field($Location_description);
			 $Location_clink = sanitize_text_field($key->Location_clink);
			 $locations_array_val['Location_clink'] = $Location_clink;
			 $Location_phone = sanitize_text_field($key->Location_phone);
			 $locations_array_val['Location_phone'] = $Location_phone;
			 $Location_email =  sanitize_email($key->Location_email);
			 $locations_array_val['Location_email'] = $Location_email;
			 $Location_image = sanitize_text_field($key->Location_image);
			 $locations_array_val['Location_image'] = $Location_image;
			 if(isset($key->Location_popup_default)){
				 if(intval( $key->Location_popup_default)){
					$Location_popup_default =  $key->Location_popup_default;
				 }else{
					$Location_popup_default = ''; 
				 }
			 }
		    $locations_array_val['Location_popup_default'] = $Location_popup_default;
			$Location_default_marker = sanitize_text_field($key->Location_default_marker);
			$locations_array_val['Location_default_marker'] = $Location_default_marker;
			 if(isset($key->Location_marker)){
				 if(intval( $key->Location_marker)){
					$Location_marker =  $key->Location_marker;
				 }else{
					$Location_marker = ''; 
				 }
			 }
			 $locations_array_val['Location_marker'] = $Location_marker;
			 $Location_enable =  sanitize_text_field($key->Location_enable);
			 $locations_array_val['Location_enable'] = $Location_enable;
			 $location_last_updated =  sanitize_text_field($key->location_last_updated);
			 $locations_array_val['location_last_updated'] = $location_last_updated;
			 if(isset($key->marker_id)){
				 if(intval( $key->marker_id)){
					$marker_id =  $key->marker_id;
				 }else{
					$marker_id = ''; 
				 }
			 }
			 $locations_array_val['marker_id'] = $marker_id;
			 $Marker_title =  sanitize_text_field($key->Marker_title);
			 $locations_array_val['Marker_title'] = $Marker_title;
			 $Marker_image =  sanitize_text_field($key->Marker_image);
			 $locations_array_val['Marker_image'] = $Marker_image;
			 $marker_last_updated =  sanitize_text_field($key->marker_last_updated);
			 $locations_array_val['marker_last_updated'] = $marker_last_updated;
			 $locations_array_new[$locations_i] = (object)$locations_array_val;
		 }

		$locations = $locations_array_new; 		
	?>
	var locations_array =<?php echo json_encode($locations);?>;
	var i;
	var template10_flag = 1;
	 
	if(locations_array) 
	{
	   var popup_marker<?php echo esc_html($mapid); ?> = [];
	   
	for(var key in locations_array)
	{
			 
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations_array[key]['Latitude'], locations_array[key]['Longitude']),
			animation: google.maps.Animation.DROP,
			map: map<?php echo esc_html($mapid); ?>,
			id: locations_array[key]['location_id'],
			icon:locations_array[key]['Marker_image']
			});
			markers<?php echo esc_html($mapid); ?>.push(marker);
			
			var map_infowindow = new google.maps.InfoWindow({
				   height: 355                       
			});
			
			<?php if(isset($args['id'])){ if($args['template'] == '10'){ ?>   
				   if(locations_array[key]['Location_popup_default'] == 2){              // Default marker info for template 10
					 if(template10_flag == 1){
						var temp10_clink_def = '';
						if(locations_array[key]['Location_clink']){
							temp10_clink_def = '<div class="jsps_map_template_10_clink"><ul><li><a href="'+locations_array[key]['Location_clink']+'" target=" ">VISIT SITE</a></li></ul></div>';
						}
						var template_10_info_default = '<div class="jsps_map_template_10_inner">' +
												   '<div class="jsps_map_template_10_title">'+ locations_array[key]['Location_title'] +'</div>' +
												   '<div class="jsps_map_template_10_addr">'+ locations_array[key]['Location_description'] +'</div>' +
												   '<div class="jsps_map_template_10_phone"><span class="phone_title">Tel:</span><span>'+ locations_array[key]['Location_phone'] + '</span></div>' +
												   '<div class="jsps_map_template_10_email"><span class="email_title">Email:</span><span>'+ locations_array[key]['Location_email'] + '</span></div>' +
													temp10_clink_def +
												'</div>';
						jQuery('#rampit_map<?php echo esc_html($mapid); ?>').parent().find('.jsps_map_template_10').append(template_10_info_default);
						
						template10_flag = 2;
						
					 }
				   }
			
				   google.maps.event.addListener(marker, 'click', (function(marker, key) {
						return function() {
							jQuery('#rampit_map<?php echo esc_html($mapid); ?>').parent().find('.jsps_map_template_10').empty();
							
							var temp10_clink = '';
							if(locations_array[key]['Location_clink']){
								temp10_clink = '<div class="jsps_map_template_10_clink"><ul><li><a href="'+locations_array[key]['Location_clink']+'" target=" ">VISIT SITE</a></li></ul></div>';
							}
							
							var template_10_info = '<div class="jsps_map_template_10_inner">' +
													   '<div class="jsps_map_template_10_title">'+ locations_array[key]['Location_title'] +'</div>' +
													   '<div class="jsps_map_template_10_addr">'+ locations_array[key]['Location_description'] +'</div>' +
													   '<div class="jsps_map_template_10_phone"><span class="phone_title">Tel:</span><span>'+ locations_array[key]['Location_phone'] + '</span></div>' +
													   '<div class="jsps_map_template_10_email"><span class="email_title">Email:</span><span>'+ locations_array[key]['Location_email'] + '</span></div>' +
														temp10_clink +
													'</div>';
							jQuery('#rampit_map<?php echo esc_html($mapid); ?>').parent().find('.jsps_map_template_10').append(template_10_info);
							
						}
				   })(marker, key));
			<?php } else{ ?>
			
			google.maps.event.addListener(marker, 'click', (function(marker, key) {
				return function() {
					
				var location_image ="";
				if(locations_array[key]['Location_image']){ 
					location_image = '<img style="width:200px; height:200px;" src='+ locations_array[key]['Location_image'] +' >';
				} 
							
				var contents = '<div  class="jsps_map_infowindow_container">'+                          //infowindow popup
									 '<div class="jsps_map_infowindow_inner_img">'+ location_image +'</div>'+
									 '<div class="jsps_map_infowindow_inner_detail">'+
										'<div class="detail_row">'+ locations_array[key]['Location_title'] +'</div>'+
										'<div class="detail_row" class="detail_row_inner"><div class="jsps_map_location_addr_dot">'+ locations_array[key]['Location_description'] +'</div><span class="jsps_map_pop_more"><a href="<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id='+locations_array[key]['location_id']+'&templateid=<?php echo esc_html($args['template']); ?>" target=" ">More</a></span></div>'+
										'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_addr.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_address'] + '</div></div>'+
										'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icon_call.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_phone'] + '</div></div>'+
										'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_email.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_email'] + '</div></div>'+
									 '</div>'+
								'</div>';
						 
				map_infowindow.setContent(contents);
				map_infowindow.open(map<?php echo esc_html($mapid); ?>, marker);
				}
			  })(marker, key));
			  
			  if(locations_array[key]['Location_popup_default'] == 2){   												//default infowindow popup
			  
				var popup_location_image ="";
				if(locations_array[key]['Location_image']){ 
					popup_location_image = '<img style="width:200px; height:200px;" src='+ locations_array[key]['Location_image'] +' >';
				} 
				var contents_popup = '<div  class="jsps_map_infowindow_container">'+                          //infowindow popup
										 '<div class="jsps_map_infowindow_inner_img">'+ popup_location_image +'</div>'+
										 '<div class="jsps_map_infowindow_inner_detail">'+
											'<div class="detail_row">'+ locations_array[key]['Location_title'] +'</div>'+
											'<div class="detail_row" class="detail_row_inner"><div class="jsps_map_location_addr_dot">'+ locations_array[key]['Location_description'] +'</div></div>'+
											'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_addr.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_address'] + '</div></div>'+
											'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icon_call.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_phone'] + '</div></div>'+
											'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_email.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_array[key]['Location_email'] + '</div></div>'+
										 '</div>'+
									  '</div>';
				
				map_infowindow.setContent(contents_popup);
				map_infowindow.open(map<?php echo esc_html($mapid); ?>, marker);
			  }
			<?php } } ?>
			  
			  marker.setMap(map<?php echo esc_html($mapid); ?>);
			  var map_list_content ="<div class='jsps_map_list_row'>"+                                                      //location list user end
									"<div class='jsps_map_list_row_title'><a id='location_list_popup' onClick=jsps_get_location_info<?php echo esc_html($mapid); ?>("+key+",1) >" + locations_array[key]['Location_title'] + "</a></div>"+
									"<div class='jsps_map_list_row_address'>" + locations_array[key]['Location_address'] + "</div>"+
									"<div style='margin-top:4px;'><a href='<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id="+locations_array[key]['location_id']+"&templateid=<?php echo esc_html($args['template']); ?>' target=' ' class='jsps_map_list_row_moreinfo' >more information</a></div>"+
								 "</div>";
		
			  jQuery('#map_list_item<?php echo esc_html($mapid); ?>').append(map_list_content);
		 
	}

	}      

	<?php if(empty($args) || ( !isset($args['id']) && !isset($args['cat']) && !isset($args['temp']) ) ){ // do shortcode print function call with pin and its argument form shortcode callback function
			do_shortcode($content);
	} ?>
	}  

	<?php if(empty($args) || ( !isset($args['id']) && !isset($args['cat']) && !isset($args['temp']) ) ){ ?>
	var geocoder;
	var directionsService;
	var directionsDisplay;


	function jsps_map_pin(pin_property,content){                      // pin place for shortcode
	  
	 if(pin_property['description']){ $tooltip = pin_property['description'];} else {$tooltip = " "; }
	  
	 geocoder = new google.maps.Geocoder();
	 var address = content;
	 
	 geocoder.geocode({'address': address}, function(results, status) {
	  if (status === google.maps.GeocoderStatus.OK) {
		map<?php echo esc_html($mapid); ?>.setCenter(results[0].geometry.location);
		var pin_marker = new google.maps.Marker({
		  map: map<?php echo esc_html($mapid); ?>,
		  position: results[0].geometry.location,
		  title:"tooltip"
		});
		
		var direction_inputs_assign = " ";
		var description_assign = " ";
		var pin_infowindow = new google.maps.InfoWindow();
		
		google.maps.event.addListener(pin_marker, 'click',function(){
			
			pin_infowindow.close();
			var direction_inputs = "<div>Your address: <input id='clientAddress' type='text'>"+
								   "<input id='direction_marker_lat' value='"+this.position.lat()+"' type='hidden'>"+
								   "<input id='direction_marker_lng' value='"+this.position.lng()+"' type='hidden'>"+
								   "<input type='button' onClick=getDir() value='Go'></div>";
			var description = pin_property['description'];
			
			if(pin_property['get_direction']){                          // direction condition check
				
			  if(pin_property['get_direction'] =='yes'){
				  
				   direction_inputs_assign = direction_inputs;
			  }
			  else{
				  direction_inputs_assign = " ";
			  }
			}
			else { direction_inputs_assign = direction_inputs;}
			
			if(pin_property['show_discription']){                      // show describtion condition check
				
			  if(pin_property['show_discription'] == 1){
				   if(pin_property['description']){description_assign = description;}
				   else{description_assign = " ";}
				}
			  else{
				  description = "";
			  }
			}
			
			 pin_infowindow.setContent(description_assign + direction_inputs_assign);			   
			 pin_infowindow.open(map<?php echo esc_html($mapid); ?>, pin_marker);
		});
	   
	  } 
	 });

		directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer({
				 suppressMarkers: false
		});	
		directionsDisplay.setMap(map<?php echo esc_html($mapid); ?>);	

	}

	function getDir() {                                                // get direction function call
	 
	var marker_position_lat = jQuery('#direction_marker_lat').val();
	var marker_position_lng = jQuery('#direction_marker_lng').val();

	geocoder.geocode({
	'address': document.getElementById('clientAddress').value
	},
	function (resultss, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		var origin = resultss[0].geometry.location;
		
		var map = new google.maps.LatLng(marker_position_lat,marker_position_lng);

		var request = {
			origin: origin,
			destination: map,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};

		directionsService.route(request, function (response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			}
		});

	   } else {
		document.getElementById('clientAddress').value =
			"Directions cannot be computed at this time.";
	  }
	});
	}
	<?php } ?>

	<?php if(isset($args['id'])){ ?>
	 
	jQuery("#address_search<?php echo esc_html($mapid); ?>").keyup(function(){
	   
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			
			var autocomplete_val = jQuery("#address_search<?php echo esc_html($mapid); ?>").val(); 
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: { action:'jsps_autocomplete', autocomplete_data:autocomplete_val
				},
				success:function(auto_data){
					
				  var  autocomplete_json = jQuery.parseJSON(auto_data);
				  
				  location_data ="[";
				  
				  
				  jQuery.each(autocomplete_json,function(i,obj)
				  {
					  
					  location_data+= '"' + obj.Location_address + ' - '+ obj.Location_title +' "';
					 
					  if(i < autocomplete_json.length-1){
						  location_data+=',';
					  }
					  
				  });
				  
				  location_data+="]";
				  
				  var address_data = JSON.parse(location_data);
				  
					jQuery("#address_search<?php echo esc_html($mapid); ?>").autocomplete({
						source: address_data
					});
				}
															
		   }); 


	});
	<?php } ?>
	var search_marker, search_markers<?php echo esc_html($mapid); ?> = [];
	function jsps_search_location_map<?php echo esc_html($mapid); ?>(){                      //search loacations pin place through ajax
	  
	 
	 for(var hide_marker = 0; hide_marker < markers<?php echo esc_html($mapid); ?>.length; hide_marker++){         // hide markers defalut loading 
		markers<?php echo esc_html($mapid); ?>[hide_marker].setMap(null);
	 }
	 
	 jsps_clear_marker<?php echo esc_html($mapid); ?>();                 //hide markers previous search
	 jsps_clear_marker_category_filter<?php echo esc_html($mapid); ?>();
	 
	 var serach_map_id = <?php echo esc_html($mapid); ?>;
	 
	 var search_value = jQuery('#address_search<?php echo $mapid; ?>').val();
	 
	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	 
	 jQuery.ajax({
		  type: "POST",
		  url: ajaxurl,
		  data: { action: 'jsps_search_location' , search_input: search_value, serach_map: serach_map_id }
	 }).done(function( search_result ) {
		
			
			var search_result_value = jQuery.parseJSON(search_result);
			
			jQuery('#map_list_item<?php echo esc_html($mapid); ?>').empty(); 
			search_markers<?php echo esc_html($mapid); ?>.length = 0; 
			
			for(var key in search_result_value)
			{
			 
					search_marker = new google.maps.Marker({
					position: new google.maps.LatLng(search_result_value[key]['Latitude'], search_result_value[key]['Longitude']),
					animation: google.maps.Animation.DROP,
					map: map<?php echo esc_html($mapid); ?>,
					icon:search_result_value[key]['Marker_image']
					});   
					search_markers<?php echo esc_html($mapid); ?>.push(search_marker);
					
					var search_infowindow = new google.maps.InfoWindow({
						   height: 355                       
					});
					google.maps.event.addListener(search_marker, 'click', (function(search_marker, key) {
					   return function() {
						  var search_location_image ="";
						  if(search_result_value[key]['Location_image']){ 
								   search_location_image = '<img style="width:200px; height:200px;" src='+ search_result_value[key]['Location_image'] +' >';
						  } 
							
						  var search_content = '<div  class="jsps_map_infowindow_container">'+                          //infowindow popup
												 '<div class="jsps_map_infowindow_inner_img">'+ search_location_image +'</div>'+
												 '<div class="jsps_map_infowindow_inner_detail">'+
													 '<div class="detail_row">'+ search_result_value[key]['Location_title'] +'</div>'+
													 '<div class="detail_row" class="detail_row_inner"><div class="jsps_map_location_addr_dot">'+ search_result_value[key]['Location_description'] +'</div><span class="jsps_map_pop_more"><a href="<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id='+search_result_value[key]['location_id']+'&templateid=<?php echo esc_html($args['template']); ?>" target=" ">More</a></span></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_addr.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ search_result_value[key]['Location_address'] + '</div></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icon_call.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ search_result_value[key]['Location_phone'] + '</div></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_email.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ search_result_value[key]['Location_email'] + '</div></div>'+
												  '</div>'+
												'</div>';
						  search_infowindow.setContent(search_content);
						  search_infowindow.open(map<?php echo esc_html($mapid); ?>, search_marker);
						}
					  })(search_marker, key));
		
					search_marker.setMap(map<?php echo esc_html($mapid); ?>);
				var map_list_content ="<div class='jsps_map_list_row'>"+
										 "<div class='jsps_map_list_row_title'> <a id='location_list_popup' onClick=jsps_get_location_info<?php echo esc_html($mapid); ?>("+key+",2) >" + search_result_value[key]['Location_title'] + "</a></div>"+
										 "<div class='jsps_map_list_row_address'>" + search_result_value[key]['Location_address'] + "</div>"+
										 "<div style='margin-top:4px;'><a href='<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id="+search_result_value[key]['location_id']+"&templateid=<?php echo esc_html($args['template']); ?>' target=' ' class='jsps_map_list_row_moreinfo'>more information</a></div>"+
									"</div>";
									
				jQuery('#map_list_item<?php echo esc_html($mapid); ?>').append(map_list_content);
		   }
		   
		   if(search_result_value.length < 1) 
		   {
			   jQuery('#map_list_item<?php echo esc_html($mapid); ?>').append('<div class="jsps_map_list_no_result">No result found</div>'); 
		   }	
	});
	 
	}
	function jsps_clear_marker<?php echo esc_html($mapid); ?>(){            //hide markers  previous search
	   for(var h = 0; h < search_markers<?php echo esc_html($mapid); ?>.length; h++){
			   search_markers<?php echo esc_html($mapid); ?>[h].setMap(null);
		}     
	}
	var cat_filter_marker, cat_filter_markers<?php echo esc_html($mapid); ?> = [];
	function jsps_category_filter_category_wise<?php echo esc_html($mapid); ?>(){
	  
	  var total_categories ="";	  
		  
	  jQuery('.category_filter_by_category<?php echo esc_html($mapid); ?>').each(function(){
	  
		  if(jQuery(this).is(':checked')){
			  
			  total_categories+= jQuery(this).val() + ",";
		  }
		  
	  });
	  
	  for(var hide_marker = 0; hide_marker < markers<?php echo esc_html($mapid); ?>.length; hide_marker++){         // hide markers defalut loading 
		markers<?php echo esc_html($mapid); ?>[hide_marker].setMap(null);
	  }
	  
	  jsps_clear_marker<?php echo esc_html($mapid); ?>();                  //hide markers previous search
	  jsps_clear_marker_category_filter<?php echo esc_html($mapid); ?>();  //hide markers previous category filter
	  
	  var categories = total_categories.substring(0, total_categories.length - 1); 
	  
	  var category_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	  
	  jQuery.ajax({
		  type: "POST",
		  url: category_ajaxurl,
		  data: { action: 'jsps_category_filter' , catgories_id: categories}
	   }).done(function( filter_result ) {
		  
			var category_filter_obj = jQuery.parseJSON(filter_result);
			
			
			jQuery('#map_list_item<?php echo esc_html($mapid); ?>').empty(); 
			cat_filter_markers<?php echo esc_html($mapid); ?>.length = 0; 
			
			for(var key in category_filter_obj)
			{
			 
					cat_filter_marker = new google.maps.Marker({
					position: new google.maps.LatLng(category_filter_obj[key]['Latitude'], category_filter_obj[key]['Longitude']),
					animation: google.maps.Animation.DROP,
					map: map<?php echo esc_html($mapid); ?>,
					icon: category_filter_obj[key]['Marker_image']
					});
  
					cat_filter_markers<?php echo esc_html($mapid); ?>.push(cat_filter_marker);
					
					var cat_filter_infowindow = new google.maps.InfoWindow({
						   height: 355                       
					});
					google.maps.event.addListener(cat_filter_marker, 'click', (function(cat_filter_marker, key) {
					   return function() {
						  
						  var filter_location_image ="";
						  if(category_filter_obj[key]['Location_image']){ 
								   filter_location_image = '<img style="width:200px; height:200px;" src='+ category_filter_obj[key]['Location_image'] +' >';
						  } 
							
						  var filter_content = '<div  class="jsps_map_infowindow_container">'+                          //infowindow popup
												 '<div class="jsps_map_infowindow_inner_img">'+ filter_location_image +'</div>'+
												 '<div class="jsps_map_infowindow_inner_detail">'+
													 '<div class="detail_row">'+ category_filter_obj[key]['Location_title'] +'</div>'+
													 '<div class="detail_row" class="detail_row_inner"><div class="jsps_map_location_addr_dot">'+ category_filter_obj[key]['Location_description'] +'</div><span class="jsps_map_pop_more"><a href="<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id='+category_filter_obj[key]['location_id']+'&templateid=<?php echo esc_html($args['template']); ?>" target=" ">More</a></span></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_addr.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ category_filter_obj[key]['Location_address'] + '</div></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icon_call.png', dirname(__FILE__)); ?>"/></div>  <div class="detail_row_inner_phone">'+ category_filter_obj[key]['Location_phone'] + '</div></div>'+
													 '<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_email.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ category_filter_obj[key]['Location_email'] + '</div></div>'+
												  '</div>'+
												'</div>';
						  cat_filter_infowindow.setContent(filter_content);
						  cat_filter_infowindow.open(map<?php echo esc_html($mapid); ?>, cat_filter_marker);
						}
					  })(cat_filter_marker, key));
		
					cat_filter_marker.setMap(map<?php echo esc_html($mapid); ?>);
				var map_list_content ="<div class='jsps_map_list_row'>"+
										"<div class='jsps_map_list_row_title'><a id='location_list_popup' onClick=jsps_get_location_info<?php echo esc_html($mapid); ?>("+key+",3) >" + category_filter_obj[key]['Location_title'] + "</a></div>"+
										"<div class='jsps_map_list_row_address'>" + category_filter_obj[key]['Location_address'] + "</div>"+
										"<div style='margin-top:4px;'><a href='<?php echo get_permalink($cur_location_dis_page_id); ?>?location_id="+category_filter_obj[key]['location_id']+"&templateid=<?php echo esc_html($args['template']); ?>' target=' ' class='jsps_map_list_row_moreinfo'>more information</a></div>"+
									"</div>";
				jQuery('#map_list_item<?php echo esc_html($mapid); ?>').append(map_list_content); 
		
		   }
		   
		   if(category_filter_obj.length < 1) 
		   {
			   jQuery('#map_list_item<?php echo esc_html($mapid); ?>').append('<div class="jsps_map_list_no_result">No result found</div>'); 
		   }
	  });

	}
	function jsps_clear_marker_category_filter<?php echo esc_html($mapid); ?>(){            //hide markers  previous category_filter
	   for(var cf = 0; cf < cat_filter_markers<?php echo esc_html($mapid); ?>.length; cf++){
			   cat_filter_markers<?php echo esc_html($mapid); ?>[cf].setMap(null);
		}    
	}
	function jsps_get_location_info<?php echo esc_html($mapid) ?>(popup_marker, flag){
	  if(flag == 1){
		google.maps.event.trigger(markers<?php echo esc_html($mapid); ?>[popup_marker], 'click');
	  }
	  if(flag == 2){
		google.maps.event.trigger(search_markers<?php echo esc_html($mapid); ?>[popup_marker], 'click');
	  }
	  if(flag == 3){
		google.maps.event.trigger(cat_filter_markers<?php echo esc_html($mapid); ?>[popup_marker], 'click');
	  }
	  
	}
	</script>	
	<?php
	$output = ob_get_clean();
	return $output;
}
  
  
  /*
   *   Shortcode for location information display in a seperate page
   */
   
  add_shortcode('jsps_location_info','jsps_location_information');
  function jsps_location_information(){
	   global $wpdb;
       $table_name = $wpdb->prefix . 'jsps_locations';
	   $table_map_temp = $wpdb->prefix . 'jsps_settings';
	   
	   if(isset($_REQUEST['location_id'])){
		 if(intval( $_REQUEST['location_id'] )){
			$locationid =  $_REQUEST['location_id'];
		 }else{
			$locationid = ''; 
		 }
	   }
	   $locationid = $_REQUEST['location_id'];
	   
	   $location_info = $wpdb->get_results("SELECT * FROM ".$table_name." where  location_id = ". $locationid );
	   
	   if(isset($_REQUEST['location_id'])){
		 if(intval( $_REQUEST['location_id'] )){
			$locationid =  $_REQUEST['location_id'];
		 }else{
			$locationid = ''; 
		 }
	   }
	   if(isset($_REQUEST['templateid'])){
		 if(intval( $_REQUEST['templateid'] )){
			$templateid =  $_REQUEST['templateid'];
		 }else{
			$templateid = ''; 
		 }
	   }

	   $sett_info = $wpdb->get_results("SELECT det_map_width, det_map_height FROM ".$table_map_temp. " where Setting_id =".$templateid);
	   
	   $info_location_individual = json_decode(json_encode($location_info), true);
	   
	   
	   if($sett_info){
		   foreach($sett_info as $sett_val){
		      $det_map_width = $sett_val->det_map_width;
	          $det_map_height = $sett_val->det_map_height;
	       }
	   }
	   
	   if($det_map_width) { $sett_det_map_width = $det_map_width; } else {  $sett_det_map_width ="500px"; }
	   if($det_map_height) { $sett_det_map_height = $det_map_height; } else {  $sett_det_map_height ="400px"; }
	   
	   
	   $template_skins = jsps_world_map_template_skins($templateid);                 //template properties skins from template_skins table
	   $template_skins_val = json_decode(json_encode($template_skins), true);
	   
	   ob_start();
	   ?>
	      <div class="map_info_container">
		    <div class="map_info_header"><?php echo esc_html($info_location_individual[0]['Location_title']); ?></div>
	        <div id="jsps_map_location_info" style="width:<?php echo esc_html($sett_det_map_width); ?>; height:<?php echo esc_html($sett_det_map_height); ?>; "></div> 
				<script>
				
					 var map_prop = {
							center:new google.maps.LatLng(51.508742,-0.120850),
							zoom:2,
							mapTypeId:google.maps.MapTypeId.ROADMAP,
							styles: [
										<?php foreach($template_skins_val as $skin_val){ 
												if($skin_val['visibility'] == 1){ $visibility = 'on'; } elseif($skin_val['visibility'] == 2){ $visibility = 'off'; } else{ $visibility = 'simplified'; }
												?>
												   { "featureType": <?php echo '"'.esc_html($skin_val['feature_type']).'"'  ?>, "elementType": <?php echo '"'.esc_html($skin_val['feature_type_property']).'"'  ?>, "stylers": [ { "visibility": <?php echo '"'.esc_html($visibility).'"'  ?> },{ "color": <?php echo '"'.esc_html($skin_val['color']).'"'  ?> },{"lightness": <?php echo '"'.esc_html($skin_val['lightness']).'"'  ?>},{"hue":<?php echo '"'.esc_html($skin_val['hue']).'"'  ?> },{"saturation": <?php echo '"'.esc_html($skin_val['saturation']).'"'  ?>} ] },
										<?php }  ?>
									]
							
						};
					 var Loc_info = new google.maps.Map(document.getElementById('jsps_map_location_info'),map_prop);
					 
					 var locations_info_object = <?php echo json_encode($location_info); ?>;
					 
					 var info_marker;
					 
					 if(locations_info_object.length > 0){
						 
						 for(var key in locations_info_object)
						 {
							
							info_marker = new google.maps.Marker({
								position: new google.maps.LatLng(locations_info_object[key]['Latitude'], locations_info_object[key]['Longitude']),
								animation: google.maps.Animation.DROP
							});
							
							 var info_location_image ="";
								  if(locations_info_object[key]['Location_image']){ 
										   info_location_image = '<img style="width:200px; height:200px;" src='+ locations_info_object[key]['Location_image'] +' >';
							 } 
							 
							 var info_contents = '<div  class="jsps_map_infowindow_container">'+                          //infowindow popup
												 '<div class="jsps_map_infowindow_inner_img">'+ info_location_image +'</div>'+
												 '<div class="jsps_map_infowindow_inner_detail">'+
													'<div class="detail_row">'+ locations_info_object[key]['Location_title'] +'</div>'+
													'<div class="detail_row" class="detail_row_inner"><div class="jsps_map_location_addr_dot">'+ locations_info_object[key]['Location_description'] +'</div></div>'+
													'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_addr.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_info_object[key]['Location_address'] + '</div></div>'+
													'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icon_call.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_info_object[key]['Location_phone'] + '</div></div>'+
													'<div class="detail_row" class="detail_row_inner"> <div style="float:left;clear:both;"><img  style="width:30px;height:30px;" src="<?php echo plugins_url( 'images/map_icons_email.png', dirname(__FILE__)); ?>" /></div>  <div class="detail_row_inner_phone">'+ locations_info_object[key]['Location_email'] + '</div></div>'+
												 '</div>'+
											'</div>';
							
							var loc_infowindow = new google.maps.InfoWindow({
								   content:info_contents
							});
							loc_infowindow.open(Loc_info,info_marker);
						 }
						 
						 info_marker.setMap(Loc_info);
					 }
				</script>
			    <div  class="map_info_inner">
			         <div class="map_info_row"> <div>Title <span>:</span></div> <div><?php echo esc_html($info_location_individual[0]['Location_title']); ?></div> </div>
					 <div class="map_info_row"> <div>Address <span>:</span></div> <div><?php echo esc_html($info_location_individual[0]['Location_address']); ?></div> </div>
					 <div class="map_info_row"> <div>Phone <span>:</span></div> <div><?php echo esc_html($info_location_individual[0]['Location_phone']); ?></div> </div>
					 <div class="map_info_row"> <div>Contact <span>:</span></div> <div><?php echo esc_html($info_location_individual[0]['Location_email']); ?></div> </div>
					 <div class="map_info_row"> <div>Description <span>:</span></div> <div><?php echo esc_html($info_location_individual[0]['Location_description']); ?></div> </div>
			    </div>
	       </div>
	   <?php
	   $output = ob_get_clean();
	   return $output;
  }
  
  function jsps_search_container($mapid){
  ?>
	  <div class="map_search_box"> <input type="text" name="address_search" class="map_search_box_input" id="address_search<?php echo esc_html($mapid); ?>">&nbsp;<input type="button" class="jsps_map_search_buton" onClick="jsps_search_location_map<?php echo esc_html($mapid); ?>();" value="SEARCH"></div>
	  
  <?php  
  }
  function jsps_list_location_map_left_right($mapid,$mapheight,$width_whole){
  ?>
	  <div class="map_list_item" style="width:<?php echo esc_html($width_whole); ?>; height:<?php echo esc_html($mapheight); ?>;" id="map_list_item<?php echo esc_html($mapid); ?>"></div>
	  
  <?php  
  }
  
  function jsps_list_location_map_top_bottom($mapid,$mapwidth){
  ?>
	  <div class="map_list_item" style="clear:both; float:none; width:<?php echo esc_html($mapwidth); ?>; height:180px;" id="map_list_item<?php echo esc_html($mapid); ?>"></div>
  <?php  
  }
  
function jsps_load_category_filter($mapid){
	global $wpdb;
	$layout_table_map = $wpdb->prefix .'jsps_map';
	$layout_table_category = $wpdb->prefix .'jsps_category';

	//get map category values
	$layout_map_query = 'Select Category from ' .$layout_table_map.' where map_id IN('.$mapid.')';  
	$layout_map_category_val = $wpdb->get_results($layout_map_query);
	$layout_categories_id ="";
	foreach($layout_map_category_val as $val){
		$layout_categories_id = $val->Category;
	}

	// get categories location values
	$layout_cat_query = 'Select Category_id, Category_title from ' .$layout_table_category.' where Category_id IN('.$layout_categories_id.')';   
	$layout_category_location_val = $wpdb->get_results($layout_cat_query);
	?>
	<script>
	jQuery(document).ready(function(){
	jQuery('#jsps_map_cf_head_toggle<?php echo esc_html($mapid); ?>').on('click', function() {
	   
			var category_up_down_arrow = jQuery(this).parent().next();
			if (category_up_down_arrow.is(":visible"))
			{
				category_up_down_arrow.slideUp();
				jQuery(this).html('+');
			}
			else
			{
				category_up_down_arrow.slideDown();
				jQuery(this).html('-');
			}
	   
	});
	});
	</script>
	<div class="category_filter_container">
		<div class="jsps_map_cf_header" >Category filter <span class="jsps_map_cf_head_tgg_ico" id="jsps_map_cf_head_toggle<?php echo esc_html($mapid); ?>">-</span></div>
		<div style="width:100%;"> 
			  <ul class="category_filter_inner">
				 <?php foreach($layout_category_location_val as $cat_val){ ?>
					 
					 <li><span><label><input type="checkbox" id="<?php echo esc_html($mapid.'_'.$cat_val->Category_id);?>" class="category_filter_by_category<?php echo esc_html($mapid); ?>" onchange="jsps_category_filter_category_wise<?php echo esc_html($mapid); ?>()" value="<?php echo esc_html($cat_val->Category_id); ?>"> <?php echo esc_html($cat_val->Category_title); ?></label></span> </li>
				 <?php } ?>
				 <script>
						var  layout_Category_id = "<?php echo esc_html($layout_categories_id)?>";
						var  layout_Category = new Array();
						layout_Category = layout_Category_id.split(",");
						for(var i=0;i<layout_Category.length;i++) {
							jQuery('#' + <?php echo esc_html($mapid); ?> +'_'+ layout_Category[i]).prop('checked', true)
						}
				</script>
			  </ul>
		</div>
	</div>  
<?php	
}
  
function jsps_world_map_setting_value(){            //common settings
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_settings';
	$mapsettingsvalue = $wpdb->get_results( 'SELECT * FROM '.$table_name );
	foreach ( $mapsettingsvalue as $value ):
	  $Sett_latitude = $value ->Center_latitude;
	  $Sett_longitude = $value->Center_longitude;
	  $Sett_width = $value->width;
	  $Sett_height = $value->height;
	  $Sett_background = $value->background;
	  $sett_map_color = $value ->map_color;
	  $sett_label_color = $value ->map_label_color;
	  $sett_label_visible = $value ->label_visibility;
	  
	  $sett_road_color = $value ->map_road_color;
	  $sett_road_visible = $value ->road_visibility;
	  
	  $sett_map_water_color = $value ->map_water_color;
	  
	  $Sett_Zoom_level = $value->Zoom_level;
	  $Sett_Zoom= $value->Zoom_control;
	  $Sett_Maptype= $value->Maptype_control;
	  $Sett_Scale= $value->Scale_control;
	endforeach;
	return array("Zoom"=>$Sett_Zoom_level,"Latitude"=>$Sett_latitude,"Longitude"=>$Sett_longitude,"width"=>$Sett_width,"height"=>$Sett_height, "asbackground"=>$Sett_background,"map_color"=>$sett_map_color,"label_color"=>$sett_label_color, "label_visible"=>$sett_label_visible, "road_color"=>$sett_road_color, "road_visible"=>$sett_road_visible, "water_color"=>$sett_map_water_color, "Zoom_control"=>$Sett_Zoom,"Map_type_control"=>$Sett_Maptype,"Scale_control"=>$Sett_Scale);
}
  
function jsps_world_map_template_property_retrive($template){  //template design value for map 
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_settings';
	$map_template_value = $wpdb->get_results( 'SELECT * FROM '.$table_name.' where Setting_id = '. $template );
	return $map_template_value;
}
  
function jsps_world_map_template_skins($template_skin_id){
	global $wpdb;
	$table_template_skin = $wpdb->prefix . 'jsps_template_skin';
	$map_template_skins = $wpdb->get_results( 'SELECT * FROM '.$table_template_skin.' where template_id = '. $template_skin_id);
	return $map_template_skins;
}
  
function jsps_map_get_current_location_info_page_id(){             // To get current location information display page id
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_map_setting';
	$location_display_id = $wpdb->get_results('SELECT * FROM '.$table_name);
	foreach ( $location_display_id as $result ){
		 $sett_location_info = $result->loc_info_page;
	}
	return $sett_location_info;
}
  
function jsps_map_pin_serach_by_address($serach_address){
	// exit();
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_locations';
	$map_search_address_value = $wpdb->get_results( "SELECT * FROM ".$table_name." where 	Location_address like '%".$serach_address."%' ");
	return $map_search_address_value;
}

function jsps_world_map_location_value(){
	global $wpdb;
	$table_name = $wpdb->prefix .'jsps_locations';
	$table_marker = $wpdb->prefix .'jsps_marker';
	$table_category = $wpdb->prefix .'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location'; 
	$query = 'SELECT a.*, b.*,(CASE  a.Location_marker WHEN " " THEN d.Marker_image else b.Marker_image END ) as Marker_image FROM '.$table_name .' as a 
				 left join '.$table_marker.' as b ON (a.Location_marker = b.marker_id)
				 left join '.$category_detail_location.' as c ON (a.location_id = c.detail_location_id)
				 left join '.$table_marker.' as d ON (c.detail_marker_id = d.marker_id)';		 		 
	 return $maplocationsvalue = $wpdb->get_results($query);  	   
}

function jsps_world_map_by_category_value($category_id){     // location values by category id 
	global $wpdb;
	$table_name = $wpdb->prefix .'jsps_locations';
	$table_marker = $wpdb->prefix .'jsps_marker';
	$table_category = $wpdb->prefix .'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';


	$category_query = 'Select Category_locationid from ' .$table_category.' where  Category_id IN('.$category_id.')';   // get category_location_id  based on category id in cateogy table
	$mapcategoryvalue111 = $wpdb->get_results($category_query);
	$cat_location_id = " ";
	foreach($mapcategoryvalue111 as $val)
	{
	   $cat_location_id.=$val->Category_locationid .',';
	}
	$location_ids = rtrim($cat_location_id, ",");
	$query = 'select a.*, b.*,(CASE  a.Location_marker WHEN " " THEN d.Marker_image else b.Marker_image END ) as Marker_image from '.$table_name .' as a  
			 left join '.$table_marker.' as b ON (a.Location_marker = b.marker_id)
			 left join '.$category_detail_location.' as c ON (a.location_id = c.detail_location_id)
			 left join '.$table_marker.' as d ON (c.detail_marker_id = d.marker_id)
			 where a.location_id IN('.$location_ids.')';			 
}
  
function jsps_world_map_by_mayID($map_id){
	  
	global $wpdb;
	$table_map = $wpdb->prefix .'jsps_map';
	$table_location = $wpdb->prefix .'jsps_locations';
	$table_category = $wpdb->prefix .'jsps_category';
	$table_marker = $wpdb->prefix .'jsps_marker';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';
	//get map category values
	$map_query = 'Select Category from ' .$table_map.' where map_id IN('.$map_id.')';  
	$map_category_val = $wpdb->get_results($map_query);
	$categories_id ="";
	foreach($map_category_val as $val){
		$categories_id = $val->Category;
	}
	// get categories location values
	$cat_query = 'Select Category_locationid from ' .$table_category.' where Category_id IN('.$categories_id.')';   
	$category_location_val = $wpdb->get_results($cat_query);
	$categories_loc_id ="";
	foreach($category_location_val as $loc_val){
	  $categories_loc_id .= $loc_val->Category_locationid.',';
	}
	$location_ids = rtrim($categories_loc_id, ",");

	$loc_query = 'select a.*, b.*,(CASE  WHEN  a.Location_default_marker ="" THEN case when a.location_marker ="" then d.Marker_image else b.Marker_image end else a.Location_default_marker  END ) as Marker_image from '.$table_location .' as a  
			 left join '.$table_marker.' as b ON (a.Location_marker = b.marker_id)
			 left join '.$category_detail_location.' as c ON (a.location_id = c.detail_location_id)
			 left join '.$table_marker.' as d ON (c.detail_marker_id = d.marker_id)
			 where a.location_id IN('.$location_ids.') and c.detail_category_id IN('.$categories_id.') and a.Location_enable = "Y" ';				 	
	return $mapcategoryvalue = $wpdb->get_results($loc_query);  
}

function jsps_ajax_search_map_location(){         
	  
	$search_input = sanitize_text_field($_REQUEST["search_input"]);
	$search_input_pos = stripos($search_input,"-");
	if(empty(trim($search_input_pos))){
	  $search_input_add = $search_input;
	  $search_input_tit = $search_input;
	}
	else{
	  $search_input_add = trim(substr($search_input,0,$search_input_pos)); 
	  $search_input_tit = trim(substr($search_input,$search_input_pos + 1));
	}
	$search_map = sanitize_text_field($_REQUEST["serach_map"]);
	global $wpdb;
	$table_map = $wpdb->prefix .'jsps_map';
	$table_location = $wpdb->prefix .'jsps_locations';
	$table_category = $wpdb->prefix .'jsps_category';
	$table_marker = $wpdb->prefix .'jsps_marker';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	//get map category values
	$map_query = 'Select Category from ' .$table_map.' where map_id IN('.$search_map.')';  
	$map_category_val = $wpdb->get_results($map_query);
	$categories_id ="";
	foreach($map_category_val as $val){
		$categories_id = $val->Category;
	}
	// get categories location values
	$cat_query = 'Select Category_locationid from ' .$table_category.' where Category_id IN('.$categories_id.')';   
	$category_location_val = $wpdb->get_results($cat_query);
	$categories_loc_id ="";
	foreach($category_location_val as $loc_val){
	  $categories_loc_id .= $loc_val->Category_locationid.',';
	}
	$location_ids = rtrim($categories_loc_id, ",");

	$loc_query = 'select a.*, b.*,(CASE  WHEN  a.Location_default_marker ="" THEN case when a.location_marker ="" then d.Marker_image else b.Marker_image end else a.Location_default_marker  END ) as Marker_image from '.$table_location .' as a  
			 left join '.$table_marker.' as b ON (a.Location_marker = b.marker_id)
			 left join '.$category_detail_location.' as c ON (a.location_id = c.detail_location_id)
			 left join '.$table_marker.' as d ON (c.detail_marker_id = d.marker_id)
			 where a.location_id IN('.$location_ids.') and c.detail_category_id IN('.$categories_id.') and a.Location_enable = "Y" and (a.Location_address like "%'.$search_input_add.'%" or Location_title like "%'.$search_input_tit.'%") ' ;
			 
	$mapcategoryvalue = $wpdb->get_results($loc_query);
	echo json_encode($mapcategoryvalue);
	exit();
}
 add_action('wp_ajax_jsps_search_location', 'jsps_ajax_search_map_location');
 add_action( 'wp_ajax_nopriv_jsps_search_location', 'jsps_ajax_search_map_location' );
 
function jsps_ajax_category_wise_filter(){ 
	if(isset($_REQUEST['catgories_id'])){
	 if(intval( $_REQUEST['catgories_id'] )){
		$catgories_id =  $_REQUEST['catgories_id'];
	 }else{
		$catgories_id = ''; 
	 }
	}
	$categories = $catgories_id;
	global $wpdb;
	$table_name = $wpdb->prefix .'jsps_locations';
	$table_marker = $wpdb->prefix .'jsps_marker';
	$table_category = $wpdb->prefix .'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';
	$category_query = 'Select Category_locationid from ' .$table_category.' where  Category_id IN('.$categories.')';   // get category_location_id  based on category id in cateogy table
	$category_filter_location_ids = $wpdb->get_results($category_query);
	$cat_location_id = " ";
	foreach($category_filter_location_ids as $val)
	{
	   $cat_location_id.=$val->Category_locationid .',';
	}
	$location_ids = rtrim($cat_location_id, ",");

	$query = 'select a.*, b.*,(CASE  WHEN  a.Location_default_marker ="" THEN case when a.location_marker ="" then d.Marker_image else b.Marker_image end else a.Location_default_marker  END ) as Marker_image from '.$table_name .' as a  
			 left join '.$table_marker.' as b ON (a.Location_marker = b.marker_id)
			 left join '.$category_detail_location.' as c ON (a.location_id = c.detail_location_id)
			 left join '.$table_marker.' as d ON (c.detail_marker_id = d.marker_id)
			 where a.location_id IN('.$location_ids.') and c.detail_category_id IN('.$categories.') and a.Location_enable = "Y" ';
			 
	$category_filter_values = $wpdb->get_results($query);
	echo json_encode($category_filter_values);
	exit();
}
add_action('wp_ajax_jsps_category_filter', 'jsps_ajax_category_wise_filter');
add_action('wp_ajax_nopriv_jsps_category_filter', 'jsps_ajax_category_wise_filter' );

function jsps_ajax_search_autocomplete(){  
	$autocomplete_val = sanitize_text_field($_REQUEST["autocomplete_data"]);
	global $wpdb;
	$table_name = $wpdb->prefix .'jsps_locations';
	$query = 'select Location_address, Location_title  from '.$table_name. ' where Location_address like "%'.$autocomplete_val.'%" or Location_title like "%'.$autocomplete_val.'%"  ';
	$autocomplete_values = $wpdb->get_results($query); 
	echo json_encode($autocomplete_values);
	exit();
}
 add_action('wp_ajax_jsps_autocomplete', 'jsps_ajax_search_autocomplete');
 add_action('wp_ajax_nopriv_jsps_autocomplete', 'jsps_ajax_search_autocomplete' );