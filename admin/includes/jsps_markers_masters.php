<?php
/*
 * Jsps Masters to manage markers
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage google_world_map/admin/includes
 * @author     RAMPiT
 */
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;
  
/*
 * Create Marker
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML Add Marker form)  
 */  

function jsps_add_marker() {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	// Get all user input values
	$jsps_marker_title = isset($_POST['Marker_title']) ? trim(sanitize_text_field($_POST['Marker_title'])) : '';
	$jsps_marker_image = isset($_FILES['Marker_image']['name']) ? $_FILES['Marker_image'] : '';
	$jsps_hidden_marker_edit = isset($_POST['hidden_marker_edit']) ? trim(sanitize_text_field($_POST['hidden_marker_edit'])) : '';    	$jsps_edit_marker = ''; 	$Edit_marker = trim($_REQUEST['Edit_marker']);	if(isset($Edit_marker)){		if(intval($Edit_marker)){			if($Edit_marker >= 0){ 				$jsps_edit_marker =  $Edit_marker;			} 		}	}		$jsps_del_marker = ''; 	$Del_marker = trim($_REQUEST['Del_marker']);	if(isset($Del_marker)){		if(intval($Del_marker)){			if($Del_marker >= 0){ 				$jsps_del_marker =  $Del_marker;			} 		}	}

	$marker_insert = '';
	$marker_update = '';
	$delete_marker = '';

	/* Check if value is not empty */
	// Required Fields 
	$all_required_field =  array($jsps_marker_title);

	// Image Fields check 
	$all_image_files =  array($jsps_marker_image);
		  
	if(isset($jsps_marker_title ) && $jsps_edit_marker ) {    	       
		if( check_val_notempty($all_required_field) ){  
			if(check_val_isfile($all_image_files)){
			
			  $jsps_image_files = $jsps_marker_image;   // call common upload image function
			} else {
			  $jsps_image_files = $jsps_hidden_marker_edit;   
			}                   
			$marker_update = jsps_update_marker( $jsps_marker_title, $jsps_image_files );   
		}    
	} elseif(!empty($jsps_marker_title)) {
	   if( check_val_notempty($all_required_field) && check_val_isfile($all_image_files)) {  
		  $marker_insert = jsps_insert_marker( $jsps_marker_title, $jsps_marker_image );
	   } 
	}

	if($jsps_del_marker) {
	   $delete_marker = jsps_delete_marker( $jsps_del_marker );
	}

	$Update_marker_title="";
	$Update_marker_image="";

	if($jsps_edit_marker)
	{
		global $wpdb;
		$edit_table_name = $wpdb->prefix . 'jsps_marker';
		$edit_results = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$edit_table_name.' WHERE marker_id = %d', $jsps_edit_marker) );
		foreach ($edit_results as $result){
		 $Update_marker_title = stripslashes_deep(htmlentities($result->Marker_title, ENT_QUOTES));
		 $Update_marker_image = $result->Marker_image;
		}
	}
	?>     
	<div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<h2> <?php esc_html_e( 'Add Marker', 'rampit-world-map' ); ?></h2>
		</div>
		 <?php if($marker_insert == 1){ ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Marker Inserted Successfully', 'rampit-world-map' ); ?></h2></div> <?php  } elseif($marker_insert == 'file_type_error') { ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Marker image type is invalid, valid formats are(PDF, JPG, JPEG)', 'rampit-world-map' ); ?></h2></div> <?php } ?>
		 <?php if($marker_update == 1){ ?> <div class="jsps_map_success"><h2><?php esc_html_e( 'Marker Updated Successfully', 'rampit-world-map' ); ?></h2></div> <?php  }  elseif($marker_update == 'file_type_error') {?>  <div class="jsps_map_success"><h2><?php esc_html_e( 'Marker image type is invalid, valid formats are(PDF, JPG, JPEG)', 'rampit-world-map' ); ?> </h2></div> <?php } ?>
		 <?php if($delete_marker == 1){ ?> <div class="jsps_map_fail"><h2><?php esc_html_e( 'Marker has been deleted', 'rampit-world-map' ); ?></h2></div> <?php } ?>
		<div class="heading add_marker">
			<h3> <?php esc_html_e( 'Add Marker', 'rampit-world-map' ); ?></h3>
		</div>
		<div class="jsps_add_marker">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="jsps_map_row">
				  <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Marker Title', 'rampit-world-map' ); ?></h3></div>
				  <div> <input type="text" name="Marker_title" id="Marker_title" maxlength="100" value="<?php echo esc_html($Update_marker_title); ?>" required /> </div>
				</div> 
				
				<div class="jsps_map_row">
				  <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Marker', 'rampit-world-map' ); ?></h3> </div>
				  <div> <input type="file" name="Marker_image" id="Marker_image" /> </div>
				</div>  
				  <?php if($jsps_edit_marker) { ?>
						<div class="jsps_map_row">
							<input type="hidden" name="hidden_marker_edit" id="hidden_marker_edit" value="<?php echo esc_url($Update_marker_image); ?>" />
							<div class="jsps_map_subtitles"style="width:160px;opacity:0;" >.</div>
							<div class="jsps_marker_admin" > <img src="<?php echo esc_url($Update_marker_image); ?>" /></div>
						</div>
				  <?php  } ?>
				<div class="jsps_add_marker_sub"> <?php if($jsps_edit_marker)
						   { ?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Save" />
					 <?php } else{ ?>
							   <input type="submit" name="submit" id="submit" class="button button-primary" value="Add Marker" />
					  <?php  } ?>
				</div>
			  
				<div class="jsps_map_row">
				  <div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Marker List', 'rampit-world-map' ); ?></h3></div>
				  <div><?php jsps_marker_grid(); ?></div>
				</div>
				<?php wp_nonce_field( 'jsps_add_marker_nonce_action', 'jsps_add_marker_nonce_field' ); ?>
			</form>
		</div>
	</div>
<?php	 
}

/*
 * List all markers as list in admin
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML list markders under "Add marker form")  
 */  

function jsps_marker_grid() {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();         

	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_marker';
	$markerlist = $wpdb->get_results('SELECT * FROM '.$table_name);
	?>

	<table width="600px"  border="1" cellspacing="0">
		<tr>
			<th> <?php esc_html_e( 'S.No', 'rampit-world-map' ); ?></th>
			<th> <?php esc_html_e( 'Marker Title', 'rampit-world-map' ); ?></th>
			<th> <?php esc_html_e( 'Marker', 'rampit-world-map' ); ?></th>
			<th colspan="3" align="center"> <?php esc_html_e( 'Action', 'rampit-world-map' ); ?></th>
		</tr>
		<?php
		$i = 1;
		if(count($markerlist) > 0)
		{
		 foreach($markerlist as $marker){
			 /* Create URL with query string */
			 // Edit URL array
			 $edit_marker =  array('Edit_marker' => $marker->marker_id,
									'page' => 'jsps_addmarker'
									);
			 // Delete URL array
			 $del_marker =  array('Del_marker' => $marker->marker_id,
									'page' => 'jsps_addmarker'
									);                 
		 ?>		 
			<tr>
			 <td align="center"><?php echo esc_html($i); ?></td>
			 <td align="center"><?php echo esc_html($marker->Marker_title); ?></td>
			 <td align="center"><img  style="max-width:30px; max-height:45px;" src="<?php echo esc_url($marker->Marker_image); ?>" alt="no image" ></td>
			 <td align="center"><a href="<?php echo add_query_arg( $edit_marker , menu_page_url("addmarker",false));?>"><?php esc_html_e( 'Edit', 'rampit-world-map' ); ?></a> </td>
			 <td align="center"><a href="<?php echo add_query_arg( $del_marker , menu_page_url("addmarker",false));?>"  onclick="return confirm('Are you sure want to delete Marker?')"><?php esc_html_e( 'Delete', 'rampit-world-map' ); ?></a> </td>
			
			 </tr>		
		 <?php $i = $i + 1; 
		  }
		} else{ ?>
		   <tr>
			 <td colspan="4" align="center"><h4><?php esc_html_e( 'No Marker is available', 'rampit-world-map' ); ?></h4></td>
			</tr>
		<?php } ?>
	</table>
<?php       
} 


/*
 * List all markers as list in admin- Duplicate from jsps_marker_grid to list all marker
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML list markders)  
 */    
function jsps_manage_marker() {                                 //manage marker

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();       

	// Get post value         	$jsps_del_marker = ''; 	$Del_marker = trim($_REQUEST['Del_marker']);	if(isset($Del_marker)){		if(intval($Del_marker)){			if($Del_marker >= 0){ 				$jsps_del_marker =  $Del_marker;			} 		}	}
				   
	if($jsps_del_marker)
	{
		$delete_marker = jsps_delete_marker( $jsps_del_marker );
	}
	global $wpdb;
	$table_name = $wpdb->prefix . 'jsps_marker';
	$markerlist = $wpdb->get_results('SELECT * FROM '.$table_name);
	?>
	<br>
	<br>
	<?php if($delete_marker == 1) { ?> <div class="jsps_map_fail"><h2><?php esc_html_e( 'Marker has been deleted.', 'rampit-world-map' ); ?></h2></div> <?php } ?>
	<br>
	<div class="managepage_addmaster">
		<ul>
		  <li><a href="<?php menu_page_url("addmarker",true); ?>"><?php esc_html_e( 'Add Marker', 'rampit-world-map' ); ?></a></li>
		</ul>
	</div>
	<br>
	<table cellspacing="0">
		<tr>
			<th> <?php esc_html_e( 'S.No', 'rampit-world-map' ); ?></th>
			<th> <?php esc_html_e( 'Marker Title', 'rampit-world-map' ); ?></th>
			<th> <?php esc_html_e( 'Marker', 'rampit-world-map' ); ?></th>
			<th colspan="3" align="center"> <?php esc_html_e( 'Action', 'rampit-world-map' ); ?></th>
		</tr>
		<?php
		$i = 1;
		if(count($markerlist) > 0)
		{
		 foreach($markerlist as $marker){ 
		 ?>		 
			<tr>
				 <td align="center"><?php echo esc_html($i); ?></td>
				 <td align="center"><?php echo esc_html($marker->Marker_title); ?></td>
				 <td align="center"><img src="<?php echo esc_url($marker->Marker_image); ?>" alt="no image" ></td>
				 <td align="center"><a href="<?php echo add_query_arg( 'Edit_marker', $marker->marker_id , menu_page_url("addmarker",false));?>"><?php esc_html_e( 'Edit', 'rampit-world-map' ); ?></a> </td>
				 <td align="center"><a href="<?php echo add_query_arg( 'Del_marker', $marker->marker_id , menu_page_url("managemarker",false));?>"  onclick="return confirm('Are you sure want to delete row?')"><?php esc_html_e( 'Delete', 'rampit-world-map' ); ?></a> </td>
			 </tr>		
		 <?php $i = $i + 1; 
		  }
		} else{ ?>  
		<tr>
			<td colspan="5" align="center"><h4><?php esc_html_e( 'No Marker is available', 'rampit-world-map' ); ?></h4></td>
		</tr>
		<?php } ?>
	</table>
<?php     
}

   
/*
 * Marker insert
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query error/success)  
 */  

function jsps_insert_marker( $jsps_marker_title, $jsps_marker_image ) {
	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();        
				   
	global $wpdb;
	$marker_table_name = $wpdb->prefix.'jsps_marker';

	$marker_image = jsps_common_upload_image($jsps_marker_image);   // call common upload image function

	$image_url_marker = "";
	if($marker_image) {
	   $image_url_marker = $marker_image;
	}

	if($image_url_marker == 'file_type_error' || ! wp_verify_nonce( $_POST['jsps_add_marker_nonce_field'], 'jsps_add_marker_nonce_action' )) {
		return 'file_type_error';
	} else {
		$insert_marker_title = stripslashes_deep(htmlentities($jsps_marker_title, ENT_QUOTES));
		$marker_insert = $wpdb->insert($marker_table_name,
									 array( 
									   'marker_id' =>' ',
									   'Marker_title' =>sanitize_text_field($insert_marker_title),
									   'Marker_image' =>sanitize_text_field($image_url_marker),
									   'marker_last_updated'=> date("Y-m-d H:i:s",time())	
									   )
									);
		$marker_error = $wpdb->last_error;                                  //error check marker insert
		  
		if($marker_error || ! wp_verify_nonce( $_POST['jsps_add_marker_nonce_field'], 'jsps_add_marker_nonce_action' )){                                                   
			return $marker_error;
		}
		else{
			return  $marker_insert;
		}
	}                
}


/*
 * Marker update
 * @since     1.0.0
 * @access    public
 * @param     $jsps_marker_image = String / array = If its a array, it will be a image. Else, it will be edit file id  
 * @return    string  (Query error/success)  
 */ 

function jsps_update_marker( $jsps_marker_title, $jsps_marker_image = NULL) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();         

	global $wpdb;
	$marker_table_name = $wpdb->prefix.'jsps_marker';
    $jsps_marker_image_size = isset($jsps_marker_image['size']) ? $jsps_marker_image['size'] : 0;      
	if($jsps_marker_image_size > 0 ){

	  $marker_image = jsps_common_upload_image($jsps_marker_image);   // call common upload image function
	} else {
	  $marker_image = $jsps_marker_image;   
	}

	if($marker_image == 'file_type_error') {
		return 'file_type_error';
	} else{
	  $update_marker_title = stripslashes_deep(htmlentities($_POST['Marker_title'], ENT_QUOTES));
	  $marker_update = $wpdb->update($marker_table_name,
				   array(
					 'Marker_title' =>sanitize_text_field($update_marker_title),
					 'Marker_image'=>sanitize_text_field($marker_image),
					 'marker_last_updated'=> date("Y-m-d H:i:s",time())
					 ),
				   array('marker_id'=>sanitize_text_field($_REQUEST['Edit_marker']))
				);
				
		$marker_error = $wpdb->last_error;                                  //error check marker update
		  
		if($marker_error || ! wp_verify_nonce( $_POST['jsps_add_marker_nonce_field'], 'jsps_add_marker_nonce_action' )){                                                   
			return $marker_error;
		}
		else{
			return $marker_update;
		}		
	}	
}

/*
 * Marker Delete
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (Query error/success)  
 */ 

function jsps_delete_marker( $jsps_marker_id ) {
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	if ( ! intval($jsps_marker_id) ) {
	  $jsps_marker_id = '';
	}
	$table_name = $wpdb->prefix.'jsps_marker';
	$delete_marker = $wpdb->delete( $table_name, array( 'marker_id' =>$jsps_marker_id) );
	return $delete_marker;
}
