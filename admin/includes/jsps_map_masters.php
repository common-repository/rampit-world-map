<?php
/*
 * Jsps Masters to manage Map with shortcode
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage google_world_map/admin/includes
 * @author     RAMPiT
 */
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;


/*
 * Create Map form to add map process
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query error/success)  
 */  

function jsps_addmap() {
 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	global $wpdb;         

	// Get all user input values
	$jsps_map_title = isset($_POST['Map_title']) ? trim(sanitize_text_field($_POST['Map_title'])) : '';
	if(isset($_POST['map_categoryID'])){
		if(count($_POST['map_categoryID']) >= 0){
			$jsps_map_categoryID = $_POST['map_categoryID'];
				 foreach ($jsps_map_categoryID as $key => $val) {
					 if($val >= 0 && intval($val)){
						$jsps_map_categoryID[$key] = $val;
				    }
				 }
		}else{
			$jsps_map_categoryID = array();
		}
	}	$jsps_map_template_id = ''; 	$map_template_id = trim($_POST['map_template_id']);	if(isset($map_template_id)){		if(intval($map_template_id)){			if($map_template_id >= 0){ 				$jsps_map_template_id =  $map_template_id;			} 		}	}	$jsps_edit_mapID = ''; 	$Edit_MapID = trim($_GET['Edit_MapID']);	if(isset($Edit_MapID)){		if(intval($Edit_MapID)){			if($Edit_MapID >= 0){ 				$jsps_edit_mapID =  $Edit_MapID;			} 		}	}		
	$map_insert = '';
	$map_update = '';    
	$Update_Mapcategory = '';     
	 
		  
	/* Check if value is not empty */
	// Required Fields          
	$all_required_field =  array($jsps_map_title);

				   
	if(isset($jsps_map_title ) && $jsps_edit_mapID ) {

	if( check_val_notempty($all_required_field) ){
		  $map_update = jsps_update_map( $jsps_map_title, $jsps_map_categoryID, $jsps_map_template_id, $jsps_edit_mapID );
	}            
	} elseif (!empty($jsps_map_title)){

	if( check_val_notempty($all_required_field) ){
	  $map_insert = jsps_insert_map( $jsps_map_title, $jsps_map_categoryID, $jsps_map_template_id );
	}
	}

	$Update_Maptitle = "";
	if($jsps_edit_mapID)
	{
	$table_name = $wpdb->prefix . 'jsps_map';
	$results = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE map_id = %d', $jsps_edit_mapID) );
	foreach ( $results as $results ):
	 $Update_Maptitle = stripslashes($results ->Map_title);
	 $Update_Mapcategory = $results->Category;
	 $Update_Template_id = $results->template_id;
	endforeach;

	}

	  // template drop down list in map
	  $template_table_name = $wpdb->prefix . 'jsps_settings';
	  $template_list = $wpdb->get_results('SELECT Setting_id,template_title FROM '.$template_table_name);
		 
	?>
	<div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<?php if($jsps_edit_mapID)
				   {?>
					  <h2> <?php esc_html_e( 'Edit Map', 'rampit-world-map' ); ?></h2>
			 <?php }else{ ?>
					  <h2> <?php esc_html_e( 'Add Map', 'rampit-world-map' ); ?></h2>
			  <?php  } ?>
		</div>
		<?php if($map_insert == 1){ ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Map Inserted Successfully.', 'rampit-world-map' ); ?></h2></div> <?php }?>
		<?php if($map_update == 1){ ?> <div class="jsps_map_updated"><h2><?php esc_html_e( 'Map Updated Successfully.', 'rampit-world-map' ); ?></h2></div> <?php } ?>
		<div class="heading jsps_addmap_form_heading">
		 <?php if($jsps_edit_mapID)
			   {?>
				  <h3> <?php esc_html_e( 'Edit Map', 'rampit-world-map' ); ?></h3>
		 <?php }else{ ?>
				  <h3> <?php esc_html_e( 'Add Map', 'rampit-world-map' ); ?></h3>
		 <?php  } ?>
		</div>
		<div class="jsps_addmap_form">
			<form method="post" action="">
				<div class="jsps_map_row">
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Map Title', 'rampit-world-map' ); ?></h3></div>
					<div> <input type="text" name="Map_title" id="Map_title" maxlength="100"  value="<?php echo esc_html($Update_Maptitle); ?>" required/> </div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Category', 'rampit-world-map' ); ?></h3></div>
					<div><?php jsps_map_catogery_list( $Update_Mapcategory ); ?></div>
				</div>
				<div class="jsps_map_row">
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Template', 'rampit-world-map' ); ?></h3></div>
					<div><select name="map_template_id" id="map_template_id" style="" > 
						 <option value="">-------select--------</option>
				   <?php
					foreach($template_list as $template_val){ 
					   $jsps_selected_option = ($Update_Template_id == $template_val->Setting_id) ? 'selected' : '';
					?>
					   <option value="<?php echo esc_html($template_val->Setting_id) ?>" <?php echo esc_html($jsps_selected_option); ?>><?php echo esc_html($template_val->template_title); ?></option>
						<?php 
						  }
						?>
					  </select>
					</div>
				</div>   				
			   <br>
			   <div class="jsps_addmap_submit"> <?php if($jsps_edit_mapID)
						   {?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Save" />
					 <?php }else{ ?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Add Map" />
					  <?php  } ?>
				</div>
				 <?php wp_nonce_field( 'jsps_addmap_nonce_action', 'jsps_addmap_nonce_field' ); ?>
			</form>
		</div>
	</div>
<?php
}

 
/*
 * Category list function
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML list all category)  
 */ 

function jsps_map_catogery_list( $Update_Mapcategory ) {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		   
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_category';
	$Categoryresults = $wpdb->get_results('SELECT * FROM '.$table_name);

	// Seleted category IDs in EDIT process
	$Update_Mapcategory_arr = explode( ',', $Update_Mapcategory );         
	?>

	<table border="1" cellspacing="0">
		<tr>
			<th><?php esc_html_e( 'Select', 'rampit-world-map' ); ?></th>
			<th><?php esc_html_e( 'Category', 'rampit-world-map' ); ?></th>
		</tr>
		<?php
		if(count($Categoryresults) > 0)
		{
		 foreach($Categoryresults as $Category){
			$selected_value_str = in_array($Category->Category_id, $Update_Mapcategory_arr ) ? 'checked' : '';
		 ?>		 
			<tr>
			 <td align="center"><input type="checkbox" name="map_categoryID[]" id="map_categoryID" class="<?php echo esc_html($Category->Category_id); ?>" value="<?php echo esc_html($Category->Category_id); ?>" <?php echo esc_html($selected_value_str); ?> /> </td>
			 <td align="center"><?php echo esc_html($Category->Category_title); ?> </td>
			</tr>
		   <?php	 
		}		 
		} else{
		?>		
		   <tr>
			 <td colspan="3" align="center" ><h4>No Category is available</h4></td>
		   </tr>
		<?php } ?>	   
	</table>
<?php   
}

 
/*
 * insert map 
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query Erro/success)  
 */ 

function jsps_insert_map( $jsps_map_title, $jspsmap_categoryID, $jsps_map_template_id ) {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();         
	 
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_map';
	$map_category_values = jsps_common_implode($jspsmap_categoryID);

	$insert_map_title = stripslashes_deep(htmlentities($jsps_map_title, ENT_QUOTES));
	$map_insert = $wpdb->insert($table_name,
					 array(
					   'map_id' =>'',
					   'Map_title' =>sanitize_text_field($insert_map_title),
					   'category'=>sanitize_text_field($map_category_values),
					   'template_id'=>sanitize_text_field($jsps_map_template_id),
					   'map_last_updated'=>date("Y-m-d H:i:s",time())
					   )
				  );	  
	$map_errors = $wpdb->last_error;                                  //error check map insert
	if($map_errors || ! wp_verify_nonce( $_POST['jsps_addmap_nonce_field'], 'jsps_addmap_nonce_action' )){                                                   
		return $map_errors;
	}
	else{
		return $map_insert;
	}
}

/*
 * update map
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query Erro/success)  
 */  

function jsps_update_map( $jsps_map_title, $jspsmap_categoryID, $jsps_map_template_id, $jsps_edit_mapID ) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();         

	global $wpdb;
	$table_map_update = $wpdb->prefix.'jsps_map'; 
	$map_category_values = jsps_common_implode($jspsmap_categoryID);         

	$update_map_title = stripslashes_deep(htmlentities($jsps_map_title, ENT_QUOTES));
	$map_update = $wpdb->update($table_map_update,
				   array( 
					 'Map_title' =>sanitize_text_field($update_map_title),
					 'category'=>sanitize_text_field($map_category_values),
					 'template_id'=>sanitize_text_field($jsps_map_template_id),
					 'map_last_updated'=>date("Y-m-d H:i:s",time())
					 ),
				   array('map_id'=>$jsps_edit_mapID)
				);	
	$map_errors = $wpdb->last_error;                                  //error check map update	  
	if($map_errors || ! wp_verify_nonce( $_POST['jsps_addmap_nonce_field'], 'jsps_addmap_nonce_action' )){                                                   
		return $map_errors;
	}
	else {
		return $map_update;
	}				
}

/*
 * Delete map
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query Erro/success)  
 */

function jsps_delete_map( $jsps_del_mapID ) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_map';
	$delete_map = $wpdb->delete( $table_name, array( 'map_id' =>$jsps_del_mapID) );

	return  $delete_map;
}

/*
 * Manage Map
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML list of all Map details)  
 */ 

function  jsps_map_manage_form(){
	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	//Get map ID	$jsps_del_mapID = ''; 	$Del_MapID = trim($_GET['Del_MapID']);	if(isset($Del_MapID)){		if(intval($Del_MapID)){			if($Del_MapID >= 0){ 				$jsps_del_mapID =  $Del_MapID;			} 		}	}
	$delete_map = '';
	 
	if($jsps_del_mapID) {
	   $delete_map = jsps_delete_map($jsps_del_mapID);
	}
	 global $wpdb;
	 $i = 1;
	 $table_name = $wpdb->prefix . 'jsps_map';
	 $Mapresults = $wpdb->get_results('SELECT * FROM '.$table_name);
	 ?>
	 <div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<h2> <?php esc_html_e( 'Manage Map', 'rampit-world-map' ); ?></h2>
		</div>
		<?php if($delete_map == 1) { ?> <div class="jsps_map_fail"><h2>Map has been deleted</h2></div> <?php }
				/* Create URL with query string */
				// Add URL array
				$jsps_add_map_arr =  array( 'page' => 'jsps_addmap' );            
		?>
	 
		 <div class="heading">
			<h3><?php esc_html_e( 'Manage Map', 'rampit-world-map' ); ?></h3>
		</div>
		<div class="manage_map_table">
			<div class="managepage_addmaster">
				<ul>
				  <li><a href="<?php echo add_query_arg( $jsps_add_map_arr, menu_page_url("addmap",false));?>"><?php esc_html_e( 'Add Map', 'rampit-world-map' ); ?></a></li>
				</ul>
			</div>
			 <table cellspacing="0">
			 <tr>
				<th> <?php esc_html_e( 'S.No', 'rampit-world-map' ); ?></th>
				<th> <?php esc_html_e( 'Map Title', 'rampit-world-map' ); ?> </th>
				<th> <?php esc_html_e( 'shortcode', 'rampit-world-map' ); ?></th>
				<th colspan="3" align="center"> <?php esc_html_e( 'Action', 'rampit-world-map' ); ?></th>
			 </tr>
			 <?php
			if(count($Mapresults) > 0){
				 foreach($Mapresults as $map){
					 
					 /* Create URL with query string */
					 // Edit URL array
					 $jsps_edit_mapID =  array('Edit_MapID' => $map->map_id,
											'page' => 'jsps_addmap'
											);
					 // Delete URL array
					 $jsps_del_mapID =  array('Del_MapID' => $map->map_id,
											'page' => 'jsps_managemap'
											);  
											
																	 
					 $shortcode_template_id ="";
					 if($map->template_id){ $shortcode_template_id = 'template ="'. esc_html($map->template_id).'"'; };
				 ?>		 
					<tr>
					 <td align="center" style="width: 60px;"><?php echo esc_html($i); ?></td>
					 <td align="center" style="width: 320px;"><?php echo esc_html($map->Map_title); ?></td>
					 <td align="center"><input style="width: 300px;border: 0px;" onClick="this.setSelectionRange(0, this.value.length)" value='<?php echo '[jsps_world_map id="'.esc_html($map->map_id).'" ' .esc_html($shortcode_template_id).']'; ?>' /></td>
					 <td align="center"><a href="<?php echo add_query_arg( $jsps_edit_mapID, menu_page_url("addmap",false));?>">Edit</a> </td>
					 <td align="center"><a href="<?php echo add_query_arg( $jsps_del_mapID, menu_page_url("managemap",false));?>"  onclick="return confirm('Are you sure want to delete row?')">Delete</a> </td>
					</tr>		
				 <?php	 
				  $i = $i + 1;
				 }
			}
			else{
			 ?>
			   <tr>
					 <td colspan="5" align="center"><?php esc_html_e( 'No Map added yet.', 'rampit-world-map' ); ?></td>
			   </tr>
			<?php } ?>
			
			 </table>
		 </div>
	 </div>
<?php   
}  

 
