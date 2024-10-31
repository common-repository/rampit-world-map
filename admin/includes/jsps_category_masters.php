<?php
/*
 * Jsps Masters to manage All categories
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage google_world_map/admin/includes
 * @author     RAMPiT
 */
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;
  
/*
 * Create Category form
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML Create Category form)  
 */  
function jsps_create_category() {
	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	//Get all Post / Get values         
	$jsps_category_title = isset($_POST['category_title']) ? trim(sanitize_text_field($_POST['category_title'])) : '';	$jsps_edit_category = ''; 	$Edit_Category = trim($_GET['Edit_Category']);
	if(isset($Edit_Category)){
		if(intval($Edit_Category)){			if($Edit_Category >= 0){ 
				$jsps_edit_category =  $Edit_Category;
			} 		}
	}
    if(isset($_POST['marker_locationID'])){
		if(count($_POST['marker_locationID']) >= 0){
			$jsps_locatioID_arr = $_POST['marker_locationID'];
				 foreach ($jsps_locatioID_arr as $key => $val) {
					 if($val >= 0 && intval($val)){
						$jsps_locatioID_arr[$key] = $val;
				    }
				}
		}else{
			$jsps_locatioID_arr = array();
		}
	}	$jsps_category_marker = ''; 	$category_marker = trim($_POST['category_marker']);	if(isset($category_marker)){		if(intval($category_marker)){			if($category_marker >= 0){ 				$jsps_category_marker =  $category_marker;			} 		}	}
	$jsps_default_marker = isset($_POST['default_marker']) ? trim(sanitize_text_field($_POST['default_marker'])) : '';  
	$category_insert = '';
	$category_update = '';         
	$Update_default_Marker = '';


	/* Check if value is not empty */
	// Required Fields 
	$all_required_field =  array($jsps_category_title);   

	if(isset($jsps_category_title) && $jsps_edit_category){
	if( check_val_notempty($all_required_field) ) { 
		$category_update = jsps_update_category( $jsps_category_title, $jsps_locatioID_arr, $jsps_category_marker, $jsps_default_marker, $jsps_edit_category );
	}
	} elseif(!empty($jsps_category_title)){
	 if( check_val_notempty($all_required_field) ) {
		  $category_insert = jsps_insert_category( $jsps_category_title, $jsps_locatioID_arr, $jsps_category_marker, $jsps_default_marker );
	 }
	}

	$Update_category_title = " ";
	$Update_category_location = " ";
	$Update_Category_marker = " ";

	if($jsps_edit_category)
	{
	global $wpdb;
	$Edit_category_table = $wpdb->prefix . 'jsps_category';
	$results = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$Edit_category_table.' WHERE Category_id = %d', $jsps_edit_category) );
	foreach ( $results as $results ){
	 $Update_category_title = $results ->Category_title;
	 $Update_category_location = $results->Category_locationid;
	 $Update_Category_marker = $results->Category_marker;
	 $Update_default_Marker = $results->Category_default_marker;
	}
	}	  

	?>
	<div class="jsps_map_wrap">
	<div class="jsps_map_titles">    		    
		<?php if($jsps_edit_category) { ?>
				  <h2> <?php esc_html_e( 'Edit Category', 'rampit-world-map' ); ?> </h2>
		<?php } else { ?>
				 <h2> <?php esc_html_e( 'Add Category', 'rampit-world-map' ); ?></h2>
		<?php } ?>    			
	</div>

	<?php if($category_insert == 1){ ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Category Inserted Successfully', 'rampit-world-map' ); ?></h2></div> <?php } elseif($category_insert != 0) { ?> <div class="jsps_map_success"><h2><?php printf(esc_html__( '%d', 'rampit-world-map' ), $category_insert); ?> </h2></div>  <?php } ?>
	<?php if($category_update == 1){ ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Category Updated Successfully', 'rampit-world-map' ); ?></h2></div> <?php	} elseif($category_update != 0) { ?> <div class="jsps_map_success"><h2><?php printf(esc_html__( '%d', 'rampit-world-map' ), $category_update); ?></h2></div> <?php } ?>

	<div class="heading add_cat_title">
		<?php if($jsps_edit_category) { ?>
				  <h3><?php esc_html_e( 'Edit Category', 'rampit-world-map' ); ?></h3>
		<?php } else { ?>
				  <h3><?php esc_html_e( 'Add Category', 'rampit-world-map' ); ?></h3>
		<?php } ?>
	</div>
	<div class="jsps_add_map_cat">
		
		<form method="post" action="">
			<div class="jsps_map_row">
			  <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Category Title', 'rampit-world-map' ); ?></h3></div>
			  <div><input type="text" name="category_title" id="category_title" maxlength="100" value="<?php echo esc_html($Update_category_title); ?>" required /></div>
			</div>
			<div class="jsps_map_row">
				<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Location', 'rampit-world-map' ); ?></h3></div>
				<div> <?php jsps_catogery_location_list(); ?> </div> 
			</div>
			<div class="jsps_map_row">
				<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Marker', 'rampit-world-map' ); ?></h3></div>
				 <?php
				 global $wpdb;
				 $marker_table_name = $wpdb->prefix . 'jsps_marker';
				 $markerresults = $wpdb->get_results('SELECT * FROM '.$marker_table_name);
				 ?>
				 <div>
					<select name="category_marker" id="category_marker" >
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
							
			 <?php
			 if($jsps_edit_category)                              // select location in edit mode
			 {?>	 
			 <script>
				  var  Category_location_id = "<?php echo esc_html($Update_category_location)?>";
				  var locationtemp = new Array();
				  locationtemp = Category_location_id.split(",");
				  for(var i=0;i<locationtemp.length;i++) {
					  jQuery('.' + locationtemp[i]).prop('checked', true)
				  }
				  jQuery("#category_marker").val("<?php echo esc_html($Update_Category_marker)?>");
			   </script>
			 <?php } ?>
			 
			 <div class="jsps_add_map_submit"> 
				<?php if($jsps_edit_category)
					   {?>
						   <input type="submit" name="submit" id="submit" class="button button-primary" value="Save" />
				<?php }else{ ?>
						   <input type="submit" name="submit" id="submit" class="button button-primary" value="Add Category" />
				 <?php  } ?>
			 </div>
			<?php wp_nonce_field( 'jsps_add_map_cat_nonce_action', 'jsps_add_map_cat_nonce_field' ); ?>
		</form>
	</div>
	</div>
<?php
}

 
/*
 * Location list function
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML List all location details)  
 * @return    --- Need to confirm from where its using!
 */  

function jsps_catogery_location_list() {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_locations';
	$Locationresults = $wpdb->get_results('SELECT * FROM '.$table_name);
	?>

	<table width="900px"  border="1" cellspacing="0">
		<tr>
			<th><?php esc_html_e( 'Select', 'rampit-world-map' ); ?></th>
			<th><?php esc_html_e( 'Location Name', 'rampit-world-map' ); ?></th>
			<th><?php esc_html_e( 'Latitude', 'rampit-world-map' ); ?></th>
			<th><?php esc_html_e( 'Longitude', 'rampit-world-map' ); ?></th>
		</tr>
		<?php
		if(count($Locationresults) > 0)
		{
		 foreach($Locationresults as $locations){	 
		 ?>		 
			<tr>
			 <td align="center"><input type="checkbox" name="marker_locationID[]" id="marker_locationID" class="<?php echo $locations->location_id; ?>" value="<?php echo $locations->location_id; ?>" /> </td>
			 <td align="center"><?php echo esc_html($locations->Location_title); ?></td>
			 <td align="center"><?php echo esc_html($locations->Latitude); ?></td>
			 <td align="center"><?php echo esc_html($locations->Longitude); ?></td>
			</tr>
		   <?php	 
			 }
		} else{
			?>
			 <tr>
				<td colspan="5" align="center" ><h4><?php esc_html_e( 'No Location is available', 'rampit-world-map' ); ?></h4></td>
			 </tr>
		<?php } ?>			
	</table>
<?php   
}

 
 
/*
 * Category manage form
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML List all Category details)  
 */

 function jsps_catogery_manage() {
 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	// Get post value	$jsps_del_category = ''; 	$Del_Category = trim($_GET['Del_Category']);	if(isset($Del_Category)){		if(intval($Del_Category)){			if($Del_Category >= 0){ 				$jsps_del_category =  $Del_Category;			} 		}	}	
	$delete_category = '';  

	 if($jsps_del_category)
	 {
		 $delete_category = jsps_delete_category($jsps_del_category);
	 }
	 
	 global $wpdb;
	 $i = 1;
	 $category_table_manage = $wpdb->prefix . 'jsps_category';
	 $categoryresults = $wpdb->get_results('SELECT * FROM '.$category_table_manage);
	 ?>
	<div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<h2><?php esc_html_e( 'Manage Category', 'rampit-world-map' ); ?></h2> 
		</div>

	 <?php if($delete_category == 1) { ?> <div class="jsps_map_fail"><h2><?php esc_html_e( 'Category has been deleted', 'rampit-world-map' ); ?></h2></div> <?php } ?>
		<div class="heading jsps_manage_title">
			<h3><?php esc_html_e( 'Manage Category', 'rampit-world-map' ); 
			$jsps_add_categoryID =  array( 'page' => 'jsps_addcategory' );
			?></h3>
		</div>

		<div class="jsps_manage_cat">
			 <div class="managepage_addmaster">
				<ul>
				  <li><a href="<?php echo add_query_arg( $jsps_add_categoryID , menu_page_url("addcategory",false));?>"><?php esc_html_e( 'Add Category', 'rampit-world-map' ); ?></a></li>
				</ul>
			 </div>
			 <table width="900px"  border="1" cellspacing="0">
				 <tr>
					<th><?php esc_html_e( ' S.No', 'rampit-world-map' ); ?> </th>
					<th><?php esc_html_e( 'Category', 'rampit-world-map' ); ?> </th>
					<th colspan="3" align="center"><?php esc_html_e( 'Action', 'rampit-world-map' ); ?> </th>
				 </tr>
				 <?php
				 if(count($categoryresults) > 0){
					 foreach($categoryresults as $category){

						 /* Create URL with query string */
						 // Edit URL array
						 $jsps_edit_cat =  array('Edit_Category' => $category->Category_id,
												'page' => 'jsps_addcategory'
												);
						 // Delete URL array
						 $jsps_del_cat =  array('Del_Category' => $category->Category_id,
												'page' => 'jsps_managecategory'
												);     					 
					 ?>		 
						<tr>
						 <td align="center"><?php echo esc_html($i); ?></td>
						 <td align="center"><?php echo esc_html($category->Category_title); ?></td>
						 <td align="center"><a href="<?php echo add_query_arg( $jsps_edit_cat , menu_page_url("addcategory",false));?>"><?php esc_html_e( 'Edit', 'rampit-world-map' ); ?></a> </td>
						 <td align="center"><a href="<?php echo add_query_arg( $jsps_del_cat , menu_page_url("managecategory",false));?>"  onclick="return confirm('Are you sure want to delete row?')"><?php esc_html_e( 'Delete', 'rampit-world-map' ); ?></a> </td>
						</tr>		
					 <?php	 
					  $i = $i + 1;
					 }
				 }
				 else{
				 ?>
					<tr>
						 <td colspan="4" align="center"><?php esc_html_e( 'No Category added Yet', 'rampit-world-map' ); ?></td>
					</tr>
				 <?php } ?>
			 </table>
		</div>
	 </div>
<?php   
}

 
/*
 * Insert Category function
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string   
 */

function jsps_insert_category( $jsps_category_title, $jsps_locatioID_arr, $jsps_category_marker, $jsps_default_marker ) {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$category_table_name = $wpdb->prefix.'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	$Marker_locationID_implode_add = jsps_common_implode($jsps_locatioID_arr);

	$insert_category_title = stripslashes_deep(htmlentities($jsps_category_title, ENT_QUOTES));
	$category_insert = $wpdb->insert($category_table_name,
					  array(
						'Category_id' =>'',
						'Category_title' =>sanitize_text_field($insert_category_title),
						'Category_locationid' =>sanitize_text_field($Marker_locationID_implode_add),
						'Category_marker' =>sanitize_text_field($jsps_category_marker),
						'Category_default_marker' =>sanitize_text_field($jsps_default_marker),
						'category_last_updated'=>date("Y-m-d H:i:s",time())
					   )
					   
					 );
	$Category_last_id = $wpdb->insert_id;
	if(is_array($jsps_locatioID_arr)) {        
		 if(isset($jsps_locatioID_arr)) {              // insert seperate location id , category id for  displaying category marker for locations
			 $Location_ID = $jsps_locatioID_arr;
			 foreach($Location_ID as $val){
				$wpdb->insert($category_detail_location,
						 array( 
						   'category_detail_id'=>'',
						   'detail_location_id'=>sanitize_text_field($val),
						   'detail_category_id'=>sanitize_text_field($Category_last_id),
						   'detail_marker_id'=>sanitize_text_field($jsps_category_marker)
						   )
				  );
			 }
		 }
	}
	$category_errors = $wpdb->last_error;                                  //error check  category insert
	if($category_errors || ! wp_verify_nonce( $_POST['jsps_add_map_cat_nonce_field'], 'jsps_add_map_cat_nonce_action' )){                                            
		return $category_errors;
	}
	else{
		return $category_insert;
	}
}

/*
 * Update Category function
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  
 */ 

function jsps_update_category( $jsps_category_title, $jsps_locatioID_arr, $jsps_category_marker, $jsps_default_marker, $jsps_edit_category ) {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$category_table_update = $wpdb->prefix . 'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	$Marker_locationID_implode_update = jsps_common_implode($jsps_locatioID_arr);

	$update_category_title = stripslashes_deep(htmlentities($jsps_category_title, ENT_QUOTES));
	$update_result = $wpdb->update($category_table_update,
				 array(
				   'Category_title' =>sanitize_text_field($update_category_title),
				   'Category_locationid' =>sanitize_text_field($Marker_locationID_implode_update),
				   'Category_marker'=>sanitize_text_field($jsps_category_marker),
				   'Category_default_marker' =>sanitize_text_field($jsps_default_marker),
				   'category_last_updated'=>date("Y-m-d H:i:s",time())
				   ),
				   array('Category_id'=>$jsps_edit_category)
			  );
	if($update_result > 0 || ! wp_verify_nonce( $_POST['jsps_add_map_cat_nonce_field'], 'jsps_add_map_cat_nonce_action' ))
	{
		 $results = $wpdb->get_results('delete FROM '.$category_detail_location.' where detail_category_id ='. $jsps_edit_category );
		 
		 $Location_ID = $jsps_locatioID_arr;
		 if(isset($jsps_locatioID_arr)){ 
			foreach($Location_ID as $val){
			 $wpdb->insert($category_detail_location,
					 array( 
					   'category_detail_id'=>'',
					   'detail_location_id'=>sanitize_text_field($val),
					   'detail_category_id'=>sanitize_text_field($jsps_edit_category),
					   'detail_marker_id'=>sanitize_text_field($jsps_category_marker)
					   )
			  );
		   }
		 }
	}			
	$category_errors = $wpdb->last_error;                                  //error check category update

	if($category_errors || ! wp_verify_nonce( $_POST['jsps_add_map_cat_nonce_field'], 'jsps_add_map_cat_nonce_action' )){                                                  
		return $category_errors;
	}
	else {
		return $update_result;
	}			 
}

 /*
 * Delete category function
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  
 */ 

function jsps_delete_category($jsps_del_category) {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_category';
	$category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	$delete_category = $wpdb->delete( $table_name, array( 'Category_id' => sanitize_text_field($jsps_del_category)) );

	$delete_category_detail = $wpdb->get_results('delete FROM '.$category_detail_location.' where detail_category_id ='. $jsps_del_category );

	return $delete_category;
}

