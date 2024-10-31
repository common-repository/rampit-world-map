<?php
/*
 * Jsps Masters to manage Locations
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage google_world_map/admin/includes
 * @author     RAMPiT
 */
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;

   
/*
 * Function - creates a location  form for getting location values. mapped in admin menu 
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    String (Add/Edit location form HTML) 
 */

function  jsps_location_form() {
	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
 
	// Get all post and get values	$jsps_edit_locationID = ''; 	$Edit_LocationID = trim($_GET['Edit_LocationID']);	if(isset($Edit_LocationID)){		if(intval($Edit_LocationID)){			if($Edit_LocationID >= 0){ 				$jsps_edit_locationID =  $Edit_LocationID;			} 		}	}
	$jsps_loc_title = isset($_POST['loc_title']) ? trim(sanitize_text_field($_POST['loc_title'])) : '';
	$jsps_loc_address = isset($_POST['loc_address']) ? trim(sanitize_text_field($_POST['loc_address'])) : '';
	$jsps_loc_latitude = isset($_POST['loc_latitude']) ? trim(sanitize_text_field($_POST['loc_latitude'])) : '';
	$jsps_loc_longitude = isset($_POST['loc_longitude']) ? trim(sanitize_text_field($_POST['loc_longitude'])) : '';
	$Update_location_title ='';
	$Update_location_address ='';
	$Update_latitude ="34.5199402"; 
	$Update_longitude ="-105.8700900";
	$update_description ='';
	$Update_Category ="";
	$update_clink = "";
	$update_phone ="";
	$update_email ="";
	$update_image ="";
	$update_default_popup ='';
	$Update_default_Marker ='';
	$Update_Marker ='';
	$location_insert ="";
	$location_update ="";
	$update_enable_location = 'Y';
	 /* Check if value is not empty */
	 // Required Fields 
	 $all_required_field =  array($jsps_loc_title, $jsps_loc_address, $jsps_loc_latitude, $jsps_loc_longitude);   

	if(isset($jsps_loc_title) && $jsps_edit_locationID) {
		if( check_val_notempty($all_required_field) ) {
			  $location_update = jsps_update_location($_POST, $_FILES, $jsps_edit_locationID);
		}
	} else if(!empty($jsps_loc_title)) {
		if( check_val_notempty($all_required_field) ) {
			  $location_insert = jsps_insert_location($_POST, $_FILES);
		}            
	}
	if($jsps_edit_locationID) {
	  global $wpdb;
	  $table_name = $wpdb->prefix . 'jsps_locations';
	  $table_category = $wpdb->prefix.'jsps_category';
	  $category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';
	  
	  $results = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE location_id = %d', $jsps_edit_locationID) );
	  foreach ( $results as $results ){
		 $Update_location_title = stripslashes($results->Location_title);
		 $Update_location_address = stripslashes($results->Location_address);
		 $Update_latitude = stripslashes($results->Latitude);
		 $Update_longitude = stripslashes($results->Longitude);
		 $update_description = stripslashes($results->Location_description);
		 $update_clink = stripslashes($results->Location_clink);
		 $update_phone = stripslashes($results->Location_phone);
		 $update_email = stripslashes($results->Location_email);
		 $update_image = stripslashes($results->Location_image);
		 $update_default_popup = stripslashes($results->Location_popup_default);
		 $Update_default_Marker = stripslashes($results->Location_default_marker);
		 $Update_Marker = stripslashes($results->Location_marker);
		 $update_enable_location = stripslashes($results->Location_enable);
	  }
	  
	  //category value get process from category detail table
	  $category_location_check = $wpdb->get_results('SELECT detail_category_id FROM '.$category_detail_location.' where detail_location_id ='.$jsps_edit_locationID );
	  $detail_category_arr= json_decode(json_encode($category_location_check), true);
	  $detail_category_arr_combine = array();
	  
	  foreach($detail_category_arr as $arr){
		 $detail_category_arr_combine[] = $arr['detail_category_id'];
	  }
	  $update_category_id = jsps_common_implode($detail_category_arr_combine);
	}	  
	?>
	<form method="post" action="" enctype="multipart/form-data">

	<div class="location_container">
	   <?php
		  global $wpdb;        // marker drop down list in add location
		  $marker_table_name = $wpdb->prefix . 'jsps_marker';
		  $markerresults = $wpdb->get_results('SELECT * FROM '.$marker_table_name);
		?>
		<div class="jsps_map_wrap">

			<div class="jsps_map_titles"> 
				<?php if($jsps_edit_locationID) { ?>
						  <h2> <?php esc_html_e( 'Edit Location', 'rampit-world-map' ); ?></h2>
				<?php }else{ ?>
						  <h2> <?php esc_html_e( 'Add Location', 'rampit-world-map' ); ?></h2>
				<?php  } ?>
			</div>
					
			<?php if($location_insert == 1){ ?>	<div class="jsps_map_success"><h2><?php esc_html_e( 'Location Inserted Successfully', 'rampit-world-map' ); ?></h2></div> <?php } elseif($location_insert == 'file_type_error') { ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Image file format is not valid', 'rampit-world-map' ); ?></h2></div> <?php } ?> 
			<?php if($location_update == 1){ ?>	<div class="jsps_map_success"><h2><?php esc_html_e( 'Location Updated Successfully', 'rampit-world-map' ); ?></h2></div>  <?php } ?>

			<div class="heading add_location">
				<?php if($jsps_edit_locationID) { ?>
						  <h3> <?php esc_html_e( 'Edit Location', 'rampit-world-map' ); ?> </h3>
				<?php }else{ ?>
						  <h3> <?php esc_html_e( 'Add Location', 'rampit-world-map' ); ?> </h3>
				<?php  } ?>
			</div>
			<div class="jsps_add_location">
				<div class="jsps_map_row">
					<div class="jsps_map_row_add_left">
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Location Title', 'rampit-world-map' ); ?></h3></div>
					   <div><input type="text" name="loc_title" id="loc_title" maxlength="100" value="<?php echo esc_html($Update_location_title); ?>"  required /> </div>
					</div>
					<div class="jsps_map_row_add_right">
					   <div class="jsps_map_subtitles" ><h3><?php esc_html_e( 'Address', 'rampit-world-map' ); ?></h3></div>
					   <div><input type="text" name="loc_address" id="loc_address" maxlength="200" value="<?php echo esc_html($Update_location_address); ?>"  required /> </div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_row_add_left">
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Latitude', 'rampit-world-map' ); ?></h3></div>
					   <div> <input type="text" name="loc_latitude" id="loc_latitude" maxlength="30" value="<?php echo esc_html($Update_latitude); ?>" required /> </div>
					 </div>
					<div class="jsps_map_row_add_right">  
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Longitude', 'rampit-world-map' ); ?></h3></div>
					   <div> <input type="text" name="loc_longitude" id="loc_longitude" maxlength="30" value="<?php echo esc_html($Update_longitude); ?>" required /> </div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_row_add_left">
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Location Map', 'rampit-world-map' ); ?></h3></div>
					   <span>Drag and Drop to set the Location.</span>
					   <div id="location_map" style="width:250px; height:200px;">
							<script>
							   Location_map();
							   function Location_map() {
				   
								   var Loc_map = new google.maps.Map(document.getElementById('location_map'), {
									center: {lat: 34.8375, lng: -106.2370},
									zoom: 4
									});
								   var location_input = (document.getElementById('loc_address'));
								   
								   var autocomplete = new google.maps.places.Autocomplete(location_input);
								   autocomplete.bindTo('bounds', Loc_map);
								   
								   var loc_marker = new google.maps.Marker({
									map: Loc_map,
									draggable: true,
									anchorPoint: new google.maps.Point(0, -29)
								   });
								   <?php if($jsps_edit_locationID){ ?>
									   var latlng = new google.maps.LatLng(jQuery('#loc_latitude').val(), jQuery('#loc_longitude').val());
									   loc_marker.setPosition(latlng);
									   Loc_map.setCenter(latlng);
									   Loc_map.setZoom(6);
								   <?php } else{ ?>
									   var latlng = new google.maps.LatLng( 34.5199402, -105.87009009999997 );
									   loc_marker.setPosition(latlng);
									   Loc_map.setCenter(latlng);
									   Loc_map.setZoom(4);
								  <?php } ?> 
								 autocomplete.addListener('place_changed', function() {
									   loc_marker.setVisible(false);
									   var place = autocomplete.getPlace();
									   if (place.geometry.viewport) {
										   
											Loc_map.fitBounds(place.geometry.viewport);
									   } 
									   else {
										   Loc_map.setCenter(place.geometry.location);
										   Loc_map.setZoom(17);  
									   }
									 loc_marker.setPosition(place.geometry.location);
									 loc_marker.setVisible(true);
									 jQuery('#loc_latitude').val(place.geometry.location.lat());
									 jQuery('#loc_longitude').val(place.geometry.location.lng());		 

								  });
								  google.maps.event.addListener(loc_marker, 'dragend', function() {
										jQuery('#loc_latitude').val(loc_marker.getPosition().lat());
										jQuery('#loc_longitude').val(loc_marker.getPosition().lng()); 	
								  });
							   }
							</script>
					   </div>
					</div>
					<div class="jsps_map_row_add_right">  
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Description', 'rampit-world-map' ); ?></h3></div>
						<div> <textarea name="loc_description" id="loc_description" cols="30" rows="5" ><?php echo esc_textarea($update_description); ?></textarea></div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_row_add_left">
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Custom Link', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="loc_clink" id="loc_clink" maxlength="250" value="<?php echo esc_url($update_clink); ?>" /> </div>
					</div>
					<div class="jsps_map_row_add_right">
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Phone', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="loc_phone" id="loc_phone" maxlength="15" value="<?php echo esc_html($update_phone); ?>" /> </div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_row_add_left">
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Email', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="loc_email" id="loc_email"  maxlength="50" value="<?php echo esc_html($update_email); ?>" /> </div>
					</div>
					<div class="jsps_map_row_add_right">
					   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Image', 'rampit-world-map' ); ?></h3></div>
					   <div><input type="file" name="loc_image" id="loc_image">
					   <?php  if($jsps_edit_locationID){   ?>
					   <input type="hidden" name="hidden_loc_image_update" id="hidden_loc_image_update" value="<?php echo esc_url($update_image);  ?>" >
					   <?php } ?>
					   <span class="open_popup_check"><input type="checkbox" name="loc_popup_default" id="loc_popup_default" <?php if($update_default_popup == 2){ ?> checked <?php } ?> ><?php esc_html_e( 'Open this location popup as default', 'rampit-world-map' ); ?></div></span>
					</div>
				</div>
				 <?php  if($jsps_edit_locationID){   ?>
					<div class="jsps_map_row">
						<div class="jsps_map_subtitles" style="opacity:0;" >.</div>
						<div> <img src="<?php echo esc_url($update_image); ?>" style="width:350px; height:250px;"  alt="No image"></div>
					</div>
				 <?php } ?>
				 <div class="jsps_map_row">
				   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Category', 'rampit-world-map' ); ?></h3></div>
				   <div><div><?php jsps_map_location_catogery_list(); ?></div></div>
				   
				   <?php
					 if($jsps_edit_locationID)                              // select location in edit mode
					 {?>	 
					 <script>
						  var  Category_location_id = "<?php echo esc_html($update_category_id)?>";
						  var locationtemp = new Array();
						  locationtemp = Category_location_id.split(",");
						  for(var i=0;i<locationtemp.length;i++) {
							  jQuery('.' + locationtemp[i]).prop('checked', true)
						  }
					   </script>
					   <input type="hidden" name="hidden_category_val" id="hidden_category_val" value="<?php echo esc_html($update_category_id); ?>" >
					 <?php } ?>
				 </div>
				 
				<div class="jsps_map_row">
				   <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Marker', 'rampit-world-map' ); ?></h3></div>
				   <div><select name="category_marker" id="category_marker" > 
						<option value="">------select------</option>
				   <?php
					foreach($markerresults as $marker){
					?>
					   <option value="<?php echo esc_html($marker->marker_id); ?>"><?php echo esc_html($marker->Marker_title); ?></option>
						<?php 
						  }
						?>
					  </select>
					</div>
					<script>
						jQuery("#category_marker").val("<?php echo esc_html($Update_Marker); ?>");
					</script>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_row_or"><?php esc_html_e( 'OR', 'rampit-world-map' ); ?></div>
				</div>
				<div class="jsps_map_row">	
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Default marker', 'rampit-world-map' ); ?></h3></div>
					<div><?php jsps_default_marker(); ?></div>
					<script>
						jQuery("#default_marker").val("<?php echo esc_html($Update_default_Marker); ?>");
					</script>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Enable', 'rampit-world-map' ); ?></h3></div>
					<div style="margin-top: 10px;"> <input type="checkbox" name="loc_enable" id="loc_enable" <?php if($update_enable_location == 'Y'){ ?> checked <?php } ?>/></div>
				</div>	
				<div class="jsps_loc_submit"> 
					<?php if($jsps_edit_locationID)
						   {?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Update" />
					 <?php }else{ ?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Add Location" />
					 <?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php wp_nonce_field( 'jsps_add_location_nonce_action', 'jsps_add_location_nonce_field' ); ?>
	</form>
<?php	
}
   

/*
 * Location category list function 
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    String (Display checkbox for all category ) 
 */ 

function jsps_map_location_catogery_list() {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();        

	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_category';
	$Categoryresults = $wpdb->get_results('SELECT * FROM '.$table_name);
	?>

	<table border="1" cellspacing="0" style="min-width:250px;">
		<tr>
			<th style="width:50px;"><?php esc_html_e( 'Select', 'rampit-world-map' ); ?></th>
			<th> <?php esc_html_e( 'Category', 'rampit-world-map' ); ?></th>
		</tr>
		<?php
		if(count($Categoryresults) > 0)
		{
		 foreach($Categoryresults as $Category){ 
		 ?>		 
			<tr>
			 <td style="width:50px;" align="center" ><input type="checkbox" name="map_location_category_id[]" id="map_location_category_id" class="<?php echo esc_html($Category->Category_id); ?>" value="<?php echo esc_html($Category->Category_id); ?>" /> </td>
			 <td align="center"><?php echo esc_html(stripslashes($Category->Category_title)); ?> </td>
			</tr>
		   <?php	 
		}		 
		} else{
		?>		
		   <tr>
			 <td colspan="3" align="center" ><h4><?php esc_html_e( 'No Category is available', 'rampit-world-map' ); ?></h4></td>
		   </tr>
		<?php } ?>	   
	</table>
<?php   
}


/*
 * Function - insert location value  on submit
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string    
 */
function jsps_insert_location( $jsps_POST_arr, $jsps_FILE_arr ) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
				
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_locations';
	$table_category = $wpdb->prefix.'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	$location_image = jsps_common_upload_image($jsps_FILE_arr['loc_image']);   // call common upload image function
	$marker = ''; 	$category_marker = trim($jsps_POST_arr['category_marker']);	if(isset($category_marker)){		if(intval($category_marker)){			if($category_marker >= 0){ 				$marker =  $category_marker;			} 		}	}	 	
	$image_url_loc = "";
	if($location_image)
	{
		$image_url_loc = $location_image;
	}

	$popup_default = 1;
	if(isset($jsps_POST_arr['loc_popup_default'])){ $popup_default= 2; }

	$location_enable = 'N';
	if(isset($jsps_POST_arr['loc_enable'])){ $location_enable= 'Y'; }
	if($image_url_loc == 'file_type_error' || ! wp_verify_nonce( $_POST['jsps_add_location_nonce_field'], 'jsps_add_location_nonce_action' ))
	{
		return 'file_type_error';
	}
	else{
		$insert_location_title = stripslashes_deep($jsps_POST_arr['loc_title']);
		$insert_loc_clink = filter_var($jsps_POST_arr['loc_clink'], FILTER_SANITIZE_URL);
		$location_insert =  $wpdb->insert($table_name,
						array( 
							'location_id'=>' ',
							'Location_title'=>sanitize_text_field($insert_location_title),
							'Location_address'=>sanitize_text_field($jsps_POST_arr['loc_address']),
							'Latitude'=>sanitize_text_field($jsps_POST_arr['loc_latitude']), 
							'Longitude'=>sanitize_text_field($jsps_POST_arr['loc_longitude']),
							'Location_description'=>sanitize_text_field($jsps_POST_arr['loc_description']),
							'Location_clink'=>$insert_loc_clink,
							'Location_phone'=>sanitize_text_field($jsps_POST_arr['loc_phone']),
							'Location_email'=>sanitize_email($jsps_POST_arr['loc_email']),
							'Location_image'=>sanitize_text_field($image_url_loc),
							'Location_popup_default'=>sanitize_text_field($popup_default),
							'Location_default_marker'=>sanitize_text_field($jsps_POST_arr['default_marker']),
							'Location_marker'=>sanitize_text_field($marker),
							'Location_enable'=>sanitize_text_field($location_enable),
							'location_last_updated'=>date("Y-m-d H:i:s",time())
							)
						);
						
		if($location_insert == 1){
			$location_inserted_id = $wpdb->insert_id;
			if(isset($jsps_POST_arr['map_location_category_id'])){              // insert seperate location id , category id for  displaying category marker for locations 
				 $location_category_id = $jsps_POST_arr['map_location_category_id'];				 				$map_location_category_id = $jsps_POST_arr['map_location_category_id'];				if(is_array($map_location_category_id)){ 					if(count($map_location_category_id) >= 0){						$location_category_id =  $map_location_category_id;					}				}				
				 foreach($location_category_id as $val){
					 $category_location_check = $wpdb->get_results('SELECT Category_locationid,Category_marker FROM '.$table_category.' where Category_id ='.$val );
					 foreach ( $category_location_check as $cat_loc_val ){
						 $category_location_ids = $cat_loc_val->Category_locationid;
						 $category_marker_id = $cat_loc_val->Category_marker;
					 }
					 if(empty($category_marker_id)){
						 $category_marker_id = 0;
					 }
					 if(!empty($category_location_ids)){
						 $cat_loc_val_arr = explode(',',$category_location_ids);
					 }
					 else{
						 $cat_loc_val_arr = array();
					 }
					 if (!in_array($location_inserted_id, $cat_loc_val_arr)){
						 array_push($cat_loc_val_arr,$location_inserted_id);
					 }	 
					 $cat_loc_val_string = jsps_common_implode($cat_loc_val_arr);
					 $wpdb->query('update '.$table_category.' set Category_locationid ="'.$cat_loc_val_string.'" where Category_id ='.$val );
					 $wpdb->insert($category_detail_location,
							 array(
							   'category_detail_id'=>'',
							   'detail_location_id'=>sanitize_text_field($location_inserted_id),
							   'detail_category_id'=>sanitize_text_field($val),
							   'detail_marker_id'=>sanitize_text_field($category_marker_id)
							   )
					  );
				 }
			 }
		}
	  
		$location_errors = $wpdb->last_error;                        //error check location insert
				  
		if($location_errors || ! wp_verify_nonce( $_POST['jsps_add_location_nonce_field'], 'jsps_add_location_nonce_action' )){                                                   
				return $location_errors;
		}
		else{
			  return $location_insert;
		}
	}
}
        
 
/*
 * Update location
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string    
 */
function jsps_update_location( $jsps_POST_arr, $jsps_FILE_arr, $jsps_edit_locationID ) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
			
	global $wpdb;
	$table_loc_update = $wpdb->prefix.'jsps_locations';
	$table_category = $wpdb->prefix.'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';
	$edit_location_id = $jsps_edit_locationID;
	if($jsps_FILE_arr['loc_image']['size']){
		if(is_array($jsps_FILE_arr)){ 			if(count($jsps_FILE_arr) >= 0){				$location_image = jsps_common_upload_image($jsps_FILE_arr['loc_image']);   // call common upload image function			}		}
	}
	else
	{   		if(is_array($jsps_FILE_arr)){ 			if(count($jsps_FILE_arr) >= 0){				$location_image = $jsps_POST_arr['hidden_loc_image_update'];   			}		}
	}
	//marker
	$marker = ''; 	$category_marker = trim($jsps_POST_arr['category_marker']);	if(isset($category_marker)){		if(intval($category_marker)){			if($category_marker >= 0){ 				$marker =  $category_marker;			} 		}	}
	$popup_default = 1;
	if(isset($jsps_POST_arr['loc_popup_default'])){ $popup_default= 2; }

	$location_enable = 'N';
	if(isset($jsps_POST_arr['loc_enable'])){ $location_enable= 'Y'; }

	if($location_image == 'file_type_error')
	{
		return 'Image file format is not valid';
	}
	else{
		$update_location_title = stripslashes_deep($jsps_POST_arr['loc_title']);
		$update_loc_clink = filter_var($jsps_POST_arr['loc_clink'], FILTER_SANITIZE_URL);
		$location_update = $wpdb->update($table_loc_update,
						   array(
							 'Location_title'=>sanitize_text_field($update_location_title),
							 'Location_address'=>sanitize_text_field($jsps_POST_arr['loc_address']),					 
							 'Latitude' =>sanitize_text_field($jsps_POST_arr['loc_latitude']),
							 'Longitude' =>sanitize_text_field($jsps_POST_arr['loc_longitude']),
							 'Location_description' =>sanitize_text_field($jsps_POST_arr['loc_description']),
							 'Location_clink'=>$update_loc_clink,
							 'Location_phone'=>sanitize_text_field($jsps_POST_arr['loc_phone']),
							 'Location_email'=>sanitize_email($jsps_POST_arr['loc_email']),
							 'Location_image' =>sanitize_text_field($location_image),
							 'Location_popup_default'=>sanitize_text_field($popup_default),
							 'Location_default_marker'=>sanitize_text_field($jsps_POST_arr['default_marker']),
							 'Location_marker'=>sanitize_text_field($marker),
							 'Location_enable'=>sanitize_text_field($location_enable),
							 'location_last_updated'=>date("Y-m-d H:i:s",time())
							),
						   array('location_id'=>$jsps_edit_locationID)
		);

		if(!empty($jsps_POST_arr['hidden_category_val'])){
			if($location_update == 1){
				 $edit_cat_loc_arr = explode(',',$jsps_POST_arr['hidden_category_val']);
				 foreach($edit_cat_loc_arr as $edit_cat_loc_id){						if(intval($edit_cat_loc_id)){							if($edit_cat_loc_id >= 0){ 								$edit_cat_loc_id =  $edit_cat_loc_id;							} 						}
					 $edit_category_location = $wpdb->get_results('SELECT Category_locationid FROM '.$table_category.' where Category_id ='.$edit_cat_loc_id );
					 foreach ( $edit_category_location as $edit_cat_loc_val ){
							$edit_category_location_ids = $edit_cat_loc_val->Category_locationid;
					 }
					 $edit_cat_loc_val_arr = explode(',',$edit_category_location_ids);
					 if (in_array($edit_location_id, $edit_cat_loc_val_arr)){
						$dele_cat_loc_id = array_diff($edit_cat_loc_val_arr, [$edit_location_id]);
						$wpdb->query('delete from ' .$category_detail_location. ' where detail_location_id ='.$edit_location_id);
						$edit_cat_loc_val_string = jsps_common_implode($dele_cat_loc_id);
						$wpdb->query('update '.$table_category.' set Category_locationid ="'.$edit_cat_loc_val_string.'" where Category_id ='.$edit_cat_loc_id );
					 }	  
				 }
			}
		}
		if(isset($jsps_POST_arr['map_location_category_id'])){              // insert seperate location id , category id for  displaying category marker for locations
			 $location_inserted_id = $edit_location_id;				$map_location_category_id = $jsps_POST_arr['map_location_category_id'];				if(is_array($map_location_category_id)){ 					if(count($map_location_category_id) >= 0){						$location_category_id =  $map_location_category_id;					}				}
			 foreach($location_category_id as $val){
				 $category_location_check = $wpdb->get_results('SELECT Category_locationid,Category_marker FROM '.$table_category.' where Category_id ='.$val );
				 foreach ( $category_location_check as $cat_loc_val ){
					$category_location_ids = $cat_loc_val->Category_locationid;
					$edit_category_marker_id = $cat_loc_val->Category_marker;
				 }
				 if(empty($edit_category_marker_id)){
					 $edit_category_marker_id = 0;
				 }
				 if(!empty($category_location_ids)){
					 $cat_loc_val_arr = explode(',',$category_location_ids);
				 }
				 else{
					 $cat_loc_val_arr = array();
				 }
				 if (!in_array($location_inserted_id, $cat_loc_val_arr)){
					 array_push($cat_loc_val_arr,$location_inserted_id);
				 }
				 $cat_loc_val_string = jsps_common_implode($cat_loc_val_arr);
				 $wpdb->query('update '.$table_category.' set Category_locationid ="'.$cat_loc_val_string.'" where Category_id ='.$val );
				 
				 
				 $wpdb->insert($category_detail_location,
						 array(
						   'category_detail_id'=>'',
						   'detail_location_id'=>sanitize_text_field($location_inserted_id),
						   'detail_category_id'=>sanitize_text_field($val),
						   'detail_marker_id'=>sanitize_text_field($edit_category_marker_id)
						   )
				  );
			 }
		}

		$location_errors = $wpdb->last_error;                                  //error check location update  
		if($location_errors || ! wp_verify_nonce( $_POST['jsps_add_location_nonce_field'], 'jsps_add_location_nonce_action' )){                                                   
			return $location_errors;
		}
		else{
			return $location_update;
		}
	}
}

 
/*
 * Delete location
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string    
 */ 
function jsps_delete_location( $jsps_del_locationID ) {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
			
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_locations';
	$location_delete = $wpdb->delete( $table_name, array( 'location_id' =>$jsps_del_locationID) );

	return $location_delete;    	 
}
  
 
/*
 * Manage location
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML to List all Location details)  
 */
function  jsps_location_manage_form() {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	// get all Post and get values
	$jsps_location_import_submit = isset($_POST['location_import_submit']) ? trim(sanitize_text_field($_POST['location_import_submit'])) : '';	$jsps_del_locationID = ''; 	$Del_LocationID = trim($_GET['Del_LocationID']);	if(isset($Del_LocationID)){		if(intval($Del_LocationID)){			if($Del_LocationID >= 0){ 				$jsps_del_locationID =  $Del_LocationID;			} 		}	}	 
	$jsps_location_import = isset($_FILES['location_import']['name']) ? $_FILES['location_import'] : '';
	$location_delete = '';        
	$import_notification = '';
	 // Image Fields check 
	$all_image_files =  array($jsps_location_import);	 
	if(isset($jsps_location_import)) {
		if(check_val_isfile($all_image_files)) {
		   $import_notification = jsps_import_location($jsps_location_import);
		}
	}
	if($jsps_del_locationID) {
		   $location_delete = jsps_delete_location($jsps_del_locationID);
	}
	 global $wpdb;
	 $i = 1;
	 $table_name = $wpdb->prefix.'jsps_locations';
	 $Locationresults = $wpdb->get_results('SELECT * FROM '.$table_name);
	 ?>
	 
	 <div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<h2> <?php esc_html_e( 'Manage Location', 'rampit-world-map' ); ?></h2>
		</div>
		
		<?php if($location_delete == 1) { ?> <div class="jsps_map_fail"><h2>Location has been deleted</h2></div> <?php } ?>
		
		<div class="heading manage_loc_heading">
			<h3><?php esc_html_e( 'Manage Location', 'rampit-world-map' );
					/* Create URL with query string */
					// Add URL array
					$jsps_add_locationID =  array( 'page' => 'jsps_addlocation' );
			 ?></h3>
		</div>
		<div class="jsps_manage_locate">
		<form method="post" action="" enctype="multipart/form-data">
			 <div class="managepage_addmaster">
				<ul>
				  <li><a href="<?php echo add_query_arg( $jsps_add_locationID , menu_page_url("addlocation",false));?>"><?php esc_html_e( 'Add Location', 'rampit-world-map' ); ?></a></li>
				</ul>
			 </div>
			 
			 <?php if($import_notification) {?> <div><h2><?php echo $import_notification; ?></div> <?php } ?>
			 
			 <!--div id="location_import_container">
				 <div><h3>Location Import</h3></div>
				 <div><input type="file" name="location_import" id="location_import"/></div>
				 <div><input type="submit" name="location_import_submit" id="location_import_submit" value="Import" /></div>
			 </div-->    			 
			 <table  cellspacing="0">
			 <tr>
				<th> <?php esc_html_e( 'S.No', 'rampit-world-map' ); ?> </th>
				<th> <?php esc_html_e( 'Location Title', 'rampit-world-map' ); ?> </th>
				<th> <?php esc_html_e( 'Address', 'rampit-world-map' ); ?> </th>
				<th> <?php esc_html_e( 'Latitude', 'rampit-world-map' ); ?> </th>
				<th> <?php esc_html_e( 'Longitude', 'rampit-world-map' ); ?></th>
				<th> <?php esc_html_e( 'Description', 'rampit-world-map' ); ?></th>
				<th colspan="3" align="center"> <?php esc_html_e( 'Action', 'rampit-world-map' ); ?></th>
			 </tr>
			 <?php
			 if(count($Locationresults) > 0){
				 foreach($Locationresults as $locations){

					 /* Create URL with query string */
					 // Edit URL array
					 $jsps_edit_locationID =  array('Edit_LocationID' => $locations->location_id,
											'page' => 'jsps_addlocation'
											);
					 // Delete URL array
					 $jsps_del_locationID =  array('Del_LocationID' => $locations->location_id,
											'page' => 'jsps_managelocation'
											);      					 
				 ?>		 
					<tr>
					 <td align="center"><?php echo esc_html($i); ?></td>
					 <td align="center"><?php echo esc_html(stripslashes($locations->Location_title)); ?></td>
					 <td align="center"><?php echo esc_html(stripslashes($locations->Location_address)); ?></td>
					 <td align="center"><?php echo esc_html($locations->Latitude); ?></td>
					 <td align="center"><?php echo esc_html($locations->Longitude); ?></td>
					 <td align="center"><?php 
							$position=30;
							$description = esc_html(stripslashes($locations->Location_description)); 
							$short_desec = substr($description, 0, $position); 
							echo esc_html($short_desec);
							if($short_desec){
								echo "..."; 
							}
					 ?> </td>
					 <td align="center"><a href="<?php echo add_query_arg( $jsps_edit_locationID , menu_page_url("addlocation",false));?>"><?php esc_html_e( 'Edit', 'rampit-world-map' ); ?></a> </td>
					 <td align="center"><a href="<?php echo add_query_arg( $jsps_del_locationID , menu_page_url("managelocation",false));?>"  onclick="return confirm('Are you sure want to delete row?')"><?php esc_html_e( 'Delete', 'rampit-world-map' ); ?></a> </td>
					</tr>		
				 <?php	 
				  $i = $i + 1;
				 }
			  }
			  else{
			 ?>
				 <tr>
					 <td  colspan="10" align="center"><?php esc_html_e( 'No Location added yet', 'rampit-world-map' ); ?></td>
				 </tr>
			  <?php } ?>
			 </table>
			</form>
		</div>
	</div>
<?php   
}