<?php
/*
 * Jsps Masters to manage All template/map style management masters
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage google_world_map/admin/includes
 * @author     RAMPiT
 */
 
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Manage settings
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML)
 */  
function jsps_setings_form() {
	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	// Get all user input values	$jsps_edit_templateID = ''; 	$Edit_TemplateID = trim($_GET['Edit_TemplateID']);	if(isset($Edit_TemplateID)){		if(intval($Edit_TemplateID)){			if($Edit_TemplateID >= 0){ 				$jsps_edit_templateID =  $Edit_TemplateID;			} 		}	}	$jsps_copy_templateID = ''; 	$Copy_TemplateID = trim($_GET['Copy_TemplateID']);	if(isset($Copy_TemplateID)){		if(intval($Copy_TemplateID)){			if($Copy_TemplateID >= 0){ 				$jsps_copy_templateID =  $Copy_TemplateID;			} 		}	}
	$jsps_sett_title = isset($_POST['sett_title']) ? sanitize_text_field($_POST['sett_title']) : '';      
	$template_insert = '';
	$template_update = '';
	$template_copy = '';
	$temp_title = '';
	$temp_fixed_width = '';
	$temp_maptypeid = '';  		 
	$temp_det_map_width = ''; 
	$temp_det_map_height = '';      		 
	$temp_layout_type = '';  
	$temp_search_show = '';
	$temp_search_position  = '';  
	$temp_list_show = '';
	$temp_list_position = '';  
	$temp_filter_show = '';
	$temp_filter_position = ''; 
	$temp_width_rpx  = '';
	$temp_height_rpx = '';
	$temp_fixed_width_rpx = '';
	$temp_dmap_width_rpx = '';
	$temp_dmap_heig_rpx = ''; 
	$template_id = '';
						  
	$hidden_skin_count = 1;
	$skin_flag = 1;

	 /* Check if value is not empty */
	 // Required Fields          
	 $all_required_field =  array($jsps_sett_title);
			 
	if(isset($_POST['jsps_map_add_temp_submit'])){                        //Insert, Update and Copy template process
		if( check_val_notempty($all_required_field) ) {
			  $template_insert = jsps_insert_settings($_POST);
		}
	}
	if(isset($_POST['jsps_map_edit_temp_submit'])){
	   if( check_val_notempty($all_required_field) ) {
			  $template_update = jsps_update_settings($_POST, $jsps_edit_templateID);
	   }
	}
	if(isset($_POST['jsps_map_copy_temp_submit'])){
	   if( check_val_notempty($all_required_field) ) {
			  $template_copy = jsps_insert_settings($_POST, $jsps_copy_templateID);
	   }
	}

	$temp_map_zoom = 5;
	$temp_cen_latitude = 34.5199402;
	$temp_cen_longitude = -105.8700900;
	$temp_width = "";
	$temp_height = "";
	$temp_full_window = 2;
	$temp_as_background = 2;
	$temp_cont_zoom = 2;
	$temp_cont_map_type = 2;
	$temp_cont_scale = 2;
	$temp_cont_scroll = 2;

	 if($jsps_edit_templateID || $jsps_copy_templateID)
	 {
		if($jsps_edit_templateID){
			$template_id = $jsps_edit_templateID;
		}
		else{
			$template_id = $jsps_copy_templateID;
		}
		
	   global $wpdb;
	   $table_name = $wpdb->prefix . 'jsps_settings';
	   $table_template_skin = $wpdb->prefix . 'jsps_template_skin';
	   
	   //Get count of map skins for the template id from skin table 
	   $skin_flag = 2;
	   $table_template_skin_count = $wpdb->get_results( $wpdb->prepare('SELECT count(*) as skin_count FROM '.$table_template_skin.' WHERE template_id = %d', $template_id) );
	   foreach ( $table_template_skin_count as $count ){
		   if($count->skin_count == 0)
		   {
			   $hidden_skin_count = 1;
		   }
		   else{
			$hidden_skin_count = $count->skin_count;
		   }
	   }
	   $temp_result = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE Setting_id = %d', $template_id) );
	   foreach ( $temp_result as $result ){
		 
		 $temp_title = stripslashes($result->template_title);
		 $temp_map_zoom = $result->Zoom_level;
		 $temp_cen_latitude = $result ->Center_latitude;
		 $temp_cen_longitude = $result->Center_longitude;
		 $temp_width = $result->width;
		 $temp_height = $result->height;
		 $temp_full_window = $result->template_fullwindow;
		 $temp_fixed_width = $result->template_fixedheight;
		 $temp_as_background = $result->background;
		 $temp_maptypeid = $result->maptypeid;
		 $temp_cont_zoom = $result->Zoom_control;
		 $temp_cont_map_type = $result->Maptype_control;
		 $temp_cont_scale = $result->Scale_control;
		 $temp_cont_scroll = $result->scroll_wheel;
		 
		 $temp_det_map_width = $result->det_map_width;
		 $temp_det_map_height = $result->det_map_height;
		 
		 $temp_layout_type = 'L4'; // Assigned value as default to disable the other layout dropdown and select option
		 $temp_search_show = $result->search_form_show;
		 $temp_search_position = $result->search_form_position;
		 $temp_list_show = $result->list_form_show;
		 $temp_list_position = $result->list_form_position;
		 $temp_filter_show = $result->category_filter_show;
		 $temp_filter_position = $result->category_filter_position;             
	   }
	   
	   if($temp_width){ $temp_width_rpx = substr($temp_width,0,-2); } else{ $temp_width_rpx =""; }
	   if($temp_height){ $temp_height_rpx = substr($temp_height,0,-2); } else{ $temp_height_rpx =""; }
	   if($temp_fixed_width){ $temp_fixed_width_rpx = substr($temp_fixed_width,0,-2); } else{ $temp_fixed_width_rpx =""; }
	   
	   if($temp_det_map_width){ $temp_dmap_width_rpx = substr($temp_det_map_width,0,-2); } else{ $temp_dmap_width_rpx =""; }
	   if($temp_det_map_height){ $temp_dmap_heig_rpx = substr($temp_det_map_height,0,-2); } else{ $temp_dmap_heig_rpx =""; }
	   
	 }
	?>
	<div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<?php if($jsps_edit_templateID)
					{?>
					   <h2>Edit Template</h2>	   
			  <?php } elseif($jsps_copy_templateID){ ?>
					   <h2>Copy Template</h2>  
			  <?php  }else{ 
						// Delete URL array
						$jsps_manage_templateID =  array('page' => 'jsps_managetemplate' );                     
				 ?>
					   <h2><?php esc_html_e( 'Add Template', 'rampit-world-map' ); ?></h2>
					   NOTE: We could <a href="<?php echo add_query_arg( $jsps_manage_templateID , menu_page_url("managetemplate",false));?>">Copy the existing templates</a> and update it based on our need insteads instead of creating new one.
			  <?php  }?>
		</div>
	   <?php if($template_insert){
		?>	
			<div class="jsps_map_success"><h2><?php esc_html_e( 'Template Inserted Successfully', 'rampit-world-map' ); ?></h2></div>
		<?php	
		} ?>
		
		<?php if($template_update){
		?>	
			<div class="jsps_map_success"><h2><?php esc_html_e( 'Template Updated Successfully', 'rampit-world-map' ); ?></h2></div>
		<?php	
		} ?>
		
		<?php if($template_copy){
		?>	
			<div class="jsps_map_success"><h2><?php esc_html_e( 'Template Copied Successfully', 'rampit-world-map' ); ?></h2></div>
		<?php	
		} ?>
		<div class="heading add_temp_title"> 
			<?php if($jsps_edit_templateID)
					{?>
					   <h3><?php esc_html_e( 'Edit Template', 'rampit-world-map' ); ?></h3>		   
			  <?php } elseif($jsps_copy_templateID){ ?>
					   <h3><?php esc_html_e( 'Copy Template', 'rampit-world-map' ); ?></h3>  
			  <?php  }else{?>
					   <h3><?php esc_html_e( 'Add Template', 'rampit-world-map' ); ?></h3>
			  <?php  }?>
		</div>
		
		<div class="jsps_add_map_template"> 
			<form id="frm_template" method="post" action="">
				<div class="jsps_map_row">
					<div>
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Template title', 'rampit-world-map' ); ?></h3></div> 
					<div><input type="text" name="sett_title" id="sett_title" maxlength="100" value="<?php echo esc_html($temp_title); ?>" required /></div>
					</div>
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Zoom level', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_zoom" id="sett_zoom" pattern="\d*" maxlength="2" title="Invalid zoom level" value="<?php echo esc_html($temp_map_zoom); ?>" required /> </div>
					</div>
				</div> 
				<div class="jsps_map_row">
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Width', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_width" id="sett_width" pattern="\d*" maxlength="4" title="Invalid width" value="<?php echo esc_html($temp_width_rpx); ?>" required /> </div>
					</div>
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'height', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_height" id="sett_height" pattern="\d*" maxlength="4" title="Invalid height" value="<?php echo esc_html($temp_height_rpx); ?>" required /> </div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Full window', 'rampit-world-map' ); ?></h3></div>
						<div style="margin-top: 10px;"><input type="checkbox" name="sett_fullwindow" id="sett_fullwindow" <?php if($temp_full_window == 1) { ?> checked <?php } ?> /> Full window</div>
					</div>
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Fixed height', 'rampit-world-map' ); ?></h3></div>
						<div><input type="text" name="sett_fixed_height" id="sett_fixed_height" pattern="\d*" maxlength="4" title="Invalid fixed height" value="<?php echo esc_html($temp_fixed_width_rpx); ?>" /></div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div>
					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Map TypeID', 'rampit-world-map' ); ?></h3></div>
					<div>
						<select name="sett_maptypeid" id="sett_maptypeid">  
							<option value="">----select----</option>
							<option value="ROADMAP">ROADMAP</option>
							<option value="SATELLITE">SATELLITE</option>
							<option value="HYBRID">HYBRID</option>
							<option value="TERRAIN">TERRAIN</option>
						</select>
						<?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_maptypeid').val('<?php echo esc_html($temp_maptypeid); ?>') </script> <?php } ?>
					</div>
					</div>
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Map Controls', 'rampit-world-map' ); ?></h3></div>
						<div> 
							<input type="checkbox" name="sett_control[]" id="zoom"  value="zoom" <?php if($temp_cont_zoom == 0){?> checked  <?php } ?> > <?php esc_html_e( 'Turn Off Zoom control', 'rampit-world-map' ); ?><br>
							<input type="checkbox" name="sett_control[]" id="maptype" value="maptype" <?php if($temp_cont_map_type == 0){?> checked  <?php } ?>> <?php esc_html_e( 'Turn Off map Type control', 'rampit-world-map' ); ?><br>
							<input type="checkbox" name="sett_control[]" id="scale"  value="scale" <?php if($temp_cont_scale == 0){?> checked  <?php } ?>> <?php esc_html_e( 'Turn Off scale control', 'rampit-world-map' ); ?><br>
							<input type="checkbox" name="sett_control[]" id="scroll"  value="scroll" <?php if($temp_cont_scroll == 0){?> checked <?php } ?>> <?php esc_html_e( 'Turn Off scroll wheel', 'rampit-world-map' ); ?><br>
						</div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div> 
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Detail map width', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_det_map_width" id="sett_det_map_width" maxlength="4" pattern="\d*" title="Invalid detail map width" value="<?php echo esc_html($temp_dmap_width_rpx); ?>" /> </div>
					</div> 
					<div> 
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Detail map height', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_det_map_height" id="sett_det_map_height" maxlength="4" pattern="\d*" title="Invalid detail map height" value="<?php echo esc_html($temp_dmap_heig_rpx); ?>" /> </div>
					</div> 
				</div>
				<div class="jsps_map_row">
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Center point latitude', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_point_latitude" id="sett_point_latitude" maxlength="20" value="<?php echo esc_html($temp_cen_latitude); ?>" required /> </div>
					</div>
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Center point longitude', 'rampit-world-map' ); ?></h3></div>
						<div> <input type="text" name="sett_point_longitude" id="sett_point_longitude" maxlength="20" value="<?php echo esc_html($temp_cen_longitude); ?>" required /> </div>
					</div>
				</div>
				<div class="jsps_map_row">
					<div>
						<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Set map as background', 'rampit-world-map' ); ?></h3></div>
						<div style="margin-top: 10px;"><input type="checkbox" name="sett_as_background" id="sett_as_background" <?php if($temp_as_background == 0){ ?> checked <?php } ?> /> As background</div>
					</div>
					<div></div>
				</div>
				<div class="jsps_all_sub_title">
					<h2>Map Skins</h2>
					<span class="jsps_map_skin_note">NOTE: Please dont update below settings before know more about Google API. <a target='_blank' href='https://developers.google.com/maps/documentation/javascript/styling'>Read here.</a></span>  
				</div>
				<input type="hidden" name="hid_skin_count" id="hid_skin_count"  value="<?php echo esc_html($hidden_skin_count); ?>" /> 
			   <div class="template_skins_container">
				  <div id="skin_header_title">  
						<div class ="featuretype_title"><span data-tooltip="Styled Maps accept an array of map stylers which define the colors, visibility, and weight of featureTypes on the map">Featured Type <img src="<?php echo plugins_url( 'images/tooltip_icon.png', dirname(dirname(__FILE__) )); ?>" /></span></div> 
						<div class ="featuretype_title"><span data-tooltip="Selects the feature, or group of features, to which a styler should be applied">Element Type <img src="<?php echo plugins_url( 'images/tooltip_icon.png', dirname(dirname(__FILE__) )); ?>" /></span></div>    
						<div class ="element_title"><span data-tooltip="Sets the color of the feature. Valid values: An RGB hex string, i.e. '#ff0000'.">color <img src="<?php echo plugins_url( 'images/tooltip_icon.png', dirname(dirname(__FILE__) )); ?>" /></span></div> 
						<div class ="element_title"><span data-tooltip="Sets the visibility of the feature. Valid values: 'on', 'off' or 'simplified'.">Visibility <img src="<?php echo plugins_url( 'images/tooltip_icon.png', dirname(dirname(__FILE__) )); ?>" /></span></div> 
						<div class ="feature_title"><span data-tooltip="Shifts lightness of colors by a percentage of the original value if decreasing and a percentage of the remaining value if increasing. Valid values: [-100, 100].">Lightness <img src="<?php echo  plugins_url( 'images/tooltip_icon.png', dirname(dirname(__FILE__)));?>" /></span></div> 
						<!--div class ="feature_title"><span data-tooltip="Sets the hue of the feature to match the hue of the color supplied. Note that the saturation and lightness of the feature is conserved, which means that the feature will not match the color supplied exactly. Valid values: An RGB hex string, i.e. '#ff0000'.">Hue <img src="<?php echo plugins_url(); ?>/rampit-world-map/images/tooltip_icon.png" /></span></div> 
						<div class ="feature_title"><span data-tooltip="Shifts the saturation of colors by a percentage of the original value if decreasing and a percentage of the remaining value if increasing. Valid values: [-100, 100].">Saturation <img src="<?php echo plugins_url(); ?>/rampit-world-map/images/tooltip_icon.png" /></span></div--> 
				  </div>
				  <?php jsps_map_skin_list_template($hidden_skin_count,$skin_flag,$template_id); ?>     		  
			   </div>
			   <div class="jsps_all_sub_title jsps_map_layout">
					<h2><?php esc_html_e( 'Template Layout', 'rampit-world-map' ); ?></h2>
					<span class="jsps_map_skin_note"><?php esc_html_e( 'NOTE: Update below settings to Display/Hide and Change Position for Template Forms.', 'rampit-world-map' ); ?></a></span> 
			   </div>
			   <div class="jsps_map_row" style="height:0px;">
					<!--div class="jsps_map_subtitles"><span>Select Layout</span></div-->
						<!--input type="hidden" name="sett_map_layouts" value="L4"/-->
						<select name="sett_map_layouts" id="sett_map_layouts" style="color: #fff;border: #fff;"  disabled="true">
							<option value="L1">Layout 1</option>
							<option value="L2">Layout 2</option>
							<option value="L3">Layout 3</option>
							<option value="L4" selected="selected">Layout 4</option>				
						</select>
				</div>
			
				<?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_map_layouts').val('<?php echo esc_html($temp_layout_type); ?>') </script> <?php } ?>
					<div id="template_layouts" style="margin-top: -24px;">
					   <div class="jsps_map_row">
						   <div class="jsps_map_row_left">
								<div id="template_layout_search" style="clear: both;width: 100%;" >
									 <div class="template_inner">
									   <div class="cal_1 jsps_label"><?php esc_html_e( 'Display Search form?', 'rampit-world-map' ); ?></div> 
									   <div class="cal_2" style="margin-bottom:20px;"><select name="sett_search_visible" id="sett_search_visible" style="width:200px;">
											<option value="0">Select</option>
											<option value="1">Yes</option>
											<option value="2">No</option>			
										   </select>
									   </div>
									   <?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_search_visible').val('<?php echo esc_html($temp_search_show); ?>') </script> <?php } else { ?>  <script> jQuery('#sett_search_visible').val('<?php echo esc_html(1); ?>') </script> <?php } ?>
									   <div class="cal_3 jsps_label"><?php esc_html_e( 'Search Form Display  Position', 'rampit-world-map' ); ?></div> 
									   <div class="cal_4"><select name="sett_search_position" id="sett_search_position" style="width:200px;margin-bottom:20px;">
											<option value="0">Select</option>
											<option value="1">Top</option>
											<option value="2">Bottom</option>			
										   </select>
									   </div>
									   <?php if($jsps_edit_templateID || $jsps_copy_templateID) { ?> <script> jQuery('#sett_search_position').val('<?php echo esc_html($temp_search_position); ?>') </script> <?php } else { ?> <script> jQuery('#sett_search_position').val('<?php echo esc_html(1); ?>') </script> <?php } ?>
									 </div>
								</div>
								<br/>
								<div id="template_layout_list" style="clear: both;width: 100%;" >
									 <div class="template_inner">
										<div class="cal_1 jsps_label"><?php esc_html_e( 'Display All Location list?', 'rampit-world-map' ); ?></div> 
										<div class="cal_2" style=""><select name="sett_list_visible" id="sett_list_visible" style="width:200px;margin-bottom:20px;">
											<option value="0">Select</option>
											<option value="1">Yes</option>
											<option value="2">No</option>			
										   </select>
										</div>
										<?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_list_visible').val('<?php echo esc_html($temp_list_show); ?>') </script> <?php } else { ?> <script> jQuery('#sett_list_visible').val('<?php echo esc_html(1); ?>') </script> <?php } ?>
									   
									   <div class="cal_3 jsps_label"><?php esc_html_e( 'Location list display Position', 'rampit-world-map' ); ?></div> 
									   <div class="cal_4"><select name="sett_list_position" id="sett_list_position" style="width:200px;margin-bottom:20px;">
											<option value="0">Select</option>
											<option value="1">Top</option>
											<option value="2">Bottom</option>
											<option value="3">Left</option>
											<option value="4">Right</option> 				
										   </select>
									   </div>
									   <?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_list_position').val('<?php echo esc_html($temp_list_position); ?>') </script> <?php } else { ?> <script> jQuery('#sett_list_position').val('<?php echo esc_html(2); ?>') </script> <?php } ?> 
									 </div>
								</div>
							<br/>
							<div id="template_layout_category" style="clear: both;width: 100%;">
								 <div class="template_inner">
								   <div class="cal_1 jsps_label"><?php esc_html_e( 'Dsiaply Category Filter?', 'rampit-world-map' ); ?></div> 
								   <div class="cal_2" style=""><select name="sett_category_visible" id="sett_category_visible" style="width:200px;margin-bottom:20px;">
										<option value="0">Select</option>
										<option value="1">Yes</option>
										<option value="2">No</option>			
									   </select>
									</div>
								   <?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_category_visible').val('<?php echo esc_html($temp_filter_show); ?>') </script> <?php } else { ?> <script> jQuery('#sett_category_visible').val('<?php echo esc_html(1); ?>') </script> <?php } ?>
								   
								   
								   <div class="cal_3 jsps_label"><?php esc_html_e( 'Category Filter display Position.', 'rampit-world-map' ); ?></div> 
								   <div class="cal_4"><select name="sett_category_position" id="sett_category_position" style="width:200px;margin-bottom:20px;">
										<option value="0">Select</option>
										<option value="1">Left</option>
										<option value="2">Right</option> 				
									   </select>
								   </div>
								   <?php if($jsps_edit_templateID || $jsps_copy_templateID){ ?> <script> jQuery('#sett_category_position').val('<?php echo esc_html($temp_filter_position); ?>') </script> <?php } else { ?> <script> jQuery('#sett_category_position').val('<?php echo esc_html(1); ?>') </script> <?php } ?>
								 </div>
							</div>
						</div>        
						<div class="jsps_add_tem_sub" style="width: 60px;"> 
							<?php if($jsps_edit_templateID)
								{?>
								   <input type="submit" name="jsps_map_edit_temp_submit" id="submit" class="button button-primary" value="Save" />
							<?php } elseif($jsps_copy_templateID){ ?>
								   <input type="submit" name="jsps_map_copy_temp_submit" id="submit" class="button button-primary" value="Copy Template" />  
							<?php  }else{ ?>
								   <input type="submit" name="jsps_map_add_temp_submit" id="submit" class="button button-primary" value="Add Template" />
							<?php  }?>
						</div>
					 <?php wp_nonce_field( 'jsps_add_map_template_nonce_action', 'jsps_add_map_template_nonce_field' ); ?>
				</form>
					</div>
			  </div>
		</div>
		<div class="jsps_map_row_right">
			<ul>
				<li><?php esc_html_e( 'Below is the demo view based on this template settings.', 'rampit-world-map' ); ?></li>
				<li><?php esc_html_e( 'Drag and Drop to Marker to set the Center Point.', 'rampit-world-map' ); ?></li>
				<li><?php _e( 'Go to Demo Page <a href="http://www.rampit.in/rampit-world-map/" target="_blank">from Here</a> to view the existing template examples.', 'rampit-world-map' ); ?></li>      
			</ul>
			<span></span>
		   <?php 
		   //if($jsps_copy_templateID || $jsps_edit_templateID)
		   //{
			?>
			   <div class="jsps_example_demo_overlay">
				   <span class="jsps_demo_form"><!--Demo Search Form display View examples--></span>
				   <div id="demo_map_search_top"> 
						<img src="<?php echo  plugins_url( 'images/demo_search_content.png', dirname(dirname(__FILE__)));?>">                        
				   </div>
				   <div id="demo_map_list_top"><div><img style="" src="<?php echo  plugins_url( 'images/demo_list_content_top_bot.png', dirname(dirname(__FILE__)));?>"></div></div>
				   
				   <div id="demo_map_inner">
					   <div id="demo_map_list_left"><div><img src="<?php echo  plugins_url( 'images/demo_list_content.png', dirname(dirname(__FILE__)));?>"></div></div>
					   <div id="demo_map_filter_inner">
						  <div id="map_copy" style="float:left;width:100%;height:100%;"></div>
						  <div id="demo_map_filter" >
								<img src="<?php echo  plugins_url( 'images/demo_category_content.png', dirname(dirname(__FILE__)));?>">
								<span><!--Demo Category Filter--></span>
						  </div>
					   </div> 
					   <div id="demo_map_list_right"><div><img src="<?php echo  plugins_url( 'images/demo_list_content.png', dirname(dirname(__FILE__)));?>"></div></div>
				   </div>	   
				   
				   <div id="demo_map_search_bottom"> <img src="<?php echo  plugins_url( 'images/demo_search_content.png', dirname(dirname(__FILE__)));?>"> </div>
				   <div id="demo_map_list_bottom"><div><img style="" src="<?php echo  plugins_url( 'images/demo_list_content_top_bot.png', dirname(dirname(__FILE__)));?>"></div> </div>
			   </div>    
			   <script type='text/javascript'>
						
						var temp_copy_arr, demo_layout;
						copy_template_input_values();
						var skin_values = get_skin_values();  
						copy_template(temp_copy_arr,skin_values,demo_layout);
						
						jQuery(document).on('change', 'input,select', function() {
							
								copy_template_input_values();
								var skin_values = get_skin_values();  
								copy_template(temp_copy_arr,skin_values,demo_layout);	
						});		
						
						jQuery(document).on('click', '.delete_skin', function() {
							
								copy_template_input_values();
								var skin_values = get_skin_values();  
								copy_template(temp_copy_arr,skin_values,demo_layout);	
						});							
							
						function copy_template_input_values(){
							
							var zoom = parseInt(jQuery("#sett_zoom").val());
							var point_latitude = jQuery("#sett_point_latitude").val();
							var point_longitude = jQuery("#sett_point_longitude").val();
							
							var demo_width = jQuery("#sett_width").val();
							var demo_height = jQuery("#sett_height").val();
							
							var demo_fullwindow = 0;
							if(jQuery("#sett_fullwindow").is(':checked')){
								demo_fullwindow = 1;
							}
							
							var fixed_height = jQuery("#sett_fixed_height").val();
							var demo_fixedheight = '200';
							if(fixed_height){
							   demo_fixedheight = jQuery("#sett_fixed_height").val();
							}
							
							var demo_maptypeid = jQuery("#sett_maptypeid").val();
							
							var zoom_control = true;
							var zoom_ckeck = jQuery('#zoom').is(':checked'); 
							if(zoom_ckeck){ zoom_control = false; }
							
							var maptype = true;
							var type_ckeck = jQuery('#maptype').is(':checked'); 
							if(type_ckeck){ maptype = false; }
							
							var scale = true;
							var scale_ckeck = jQuery('#scale').is(':checked'); 
							if(scale_ckeck){ scale = false; }
							
							var scrollwheel = true;
							var scroll_ckeck = jQuery('#scroll').is(':checked'); 
							if(scroll_ckeck){ scrollwheel = false; }
							
							var demo_layout_type = jQuery("#sett_map_layouts").val();
							var demo_search_show = jQuery("#sett_search_visible").val();
							var demo_search_pos = jQuery("#sett_search_position").val();
							var demo_list_show = jQuery("#sett_list_visible").val();
							var demo_list_pos = jQuery("#sett_list_position").val();
							var demo_filter_show = jQuery("#sett_category_visible").val();
							var demo_filter_pos = jQuery("#sett_category_position").val();
							
							temp_copy_arr = { "zoom": zoom, "latt": point_latitude, "long": point_longitude, "width": demo_width, "height": demo_height, "full_window": demo_fullwindow, "fixed_height":demo_fixedheight, "map_typeid":demo_maptypeid, "zoomcontrol": zoom_control, "maptype": maptype, "scale": scale, "scroll": scrollwheel };
							
							demo_layout = {"type":demo_layout_type, "search_show":demo_search_show, "search_pos":demo_search_pos, "list_show":demo_list_show, "list_pos":demo_list_pos, "filter_show":demo_filter_show, "filter_pos":demo_filter_pos};
							
						}	

						function copy_template(val,skin_val,layout_val)
						{
							
							var skin_value_arr = skin_val;
							var demo_layout_arr = layout_val;
							
							var skin="[";
							var visibility =""
							for(var x = 0;x < skin_value_arr.length;x++)
							{
								if(skin_value_arr[x][3] == 1) { visibility='on'; } else if(skin_value_arr[x][3] == 2){ visibility='off'; } else{ visibility='simplified'; }
								skin+='{"featureType": "'+skin_value_arr[x][0]+'", "elementType": "'+skin_value_arr[x][1]+'", "stylers": [{ "color": "'+skin_value_arr[x][2]+'" }, {"visibility": "'+visibility+'" }, {"lightness": "'+skin_value_arr[x][4]+'" }, {"hue": "'+skin_value_arr[x][5]+'" }, {"saturation": "'+skin_value_arr[x][6]+'" }] }';
								
								if(x < skin_value_arr.length-1){
									skin+=',';
								}
							}
							skin+="]";    							
								
							var styles= JSON.parse(skin);
							
							var set_map_type_id ="";
							if(val["map_typeid"]){
								 set_map_type_id = val["map_typeid"];
							}
							else{
								 set_map_type_id ='ROADMAP';
							}
							
							var mapCenter = new google.maps.LatLng(val["latt"],val["long"]);
							
							var mapProp = {
								center:mapCenter,
								zoom:val["zoom"],
								mapTypeId:google.maps.MapTypeId.ROADMAP,
								zoomControl:val["zoomcontrol"],
								mapTypeControl:val["maptype"],
								scaleControl:val["scale"],
								scrollwheel:val["scroll"],
								styles:styles   
								};

								if(val["full_window"] == 0 && !val["width"] && !val["height"]){
									document.getElementById('demo_map_inner').style.width = '700px';
									document.getElementById('demo_map_inner').style.height = '500px';
								}
								
								if(val["full_window"] == 1){
									document.getElementById('demo_map_inner').style.width = '100%';
									document.getElementById('demo_map_inner').style.height = '100%';
								
								   //if(demo_layout_arr["list_show"] =='1'){
										if(demo_layout_arr["list_pos"] =='3' || demo_layout_arr["list_pos"] =='4'){
											document.getElementById('demo_map_filter_inner').style.width = '75%';
											document.getElementById('demo_map_filter_inner').style.height = val["fixed_height"]+'px';
											document.getElementById('demo_map_list_left').style.height = val["fixed_height"]+'px';
											document.getElementById('demo_map_list_right').style.height = val["fixed_height"]+'px';
										}
										else{
											document.getElementById('demo_map_filter_inner').style.width = '100%';
											document.getElementById('demo_map_filter_inner').style.height = val["fixed_height"]+'px';
											document.getElementById('demo_map_list_left').style.height = val["fixed_height"]+'px';
											document.getElementById('demo_map_list_right').style.height = val["fixed_height"]+'px';
										}
								   //} 
								}
								else
								{
									document.getElementById('demo_map_inner').style.width = val["width"]+'px';
									document.getElementById('demo_map_inner').style.height = val["height"]+'px';
									
									if(demo_layout_arr["list_show"] =='1'){
										if(demo_layout_arr["list_pos"] == 3 || demo_layout_arr["list_pos"] == 4){
											document.getElementById('demo_map_filter_inner').style.width = '75%';
										}
										else{
											document.getElementById('demo_map_filter_inner').style.width = '99%';
										}
									}
									else{
										 document.getElementById('demo_map_filter_inner').style.width = '99%';
									}
									
									document.getElementById('demo_map_filter_inner').style.height = val["height"]+'px';
									
									document.getElementById('demo_map_list_left').style.height = val["height"]+'px';
									document.getElementById('demo_map_list_right').style.height = val["height"]+'px';
									
									document.getElementById('demo_map_list_top').style.width = val["width"]+'px';
									document.getElementById('demo_map_list_bottom').style.width = val["width"]+'px';
									
								}

								if(demo_layout_arr["type"] =='L1'){
									jQuery('#demo_map_search_top, #demo_map_list_top, #demo_map_list_left, #demo_map_filter, #demo_map_list_right, #demo_map_search_bottom, #demo_map_list_bottom').hide();
								}
								
								if(demo_layout_arr["type"] =='L2'){
									if(demo_layout_arr["search_show"] =='1'){
										 if(demo_layout_arr["search_pos"] =='1'){
											 jQuery('#demo_map_search_top').show();
											 jQuery('#demo_map_search_bottom , #demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
										 else if(demo_layout_arr["search_pos"] =='2'){
											 jQuery('#demo_map_search_bottom').show();
											 jQuery('#demo_map_search_top, #demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
										 else{
											 jQuery('#demo_map_search_bottom').hide();
											 jQuery('#demo_map_search_top, #demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
											 
									}
									else {
											 jQuery('#demo_map_search_bottom').hide();
											 jQuery('#demo_map_search_top, #demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
									}
										 
								}
								
								if(demo_layout_arr["type"] =='L3'){
									if(demo_layout_arr["search_show"] =='1'){
										 if(demo_layout_arr["search_pos"] =='1'){
											 jQuery('#demo_map_search_top').show();
											 jQuery('#demo_map_search_bottom, #demo_map_filter').hide();
										 }
										 else if(demo_layout_arr["search_pos"] =='2'){
											 jQuery('#demo_map_search_bottom').show();
											 jQuery('#demo_map_search_top, #demo_map_filter').hide();
										 }
										 else{
											 jQuery('#demo_map_search_bottom, #demo_map_filter').hide();
											 jQuery('#demo_map_search_top, #demo_map_filter').hide();
										 }
										 
									}
									else {
											 jQuery('#demo_map_search_bottom, #demo_map_filter').hide();
											 jQuery('#demo_map_search_top, #demo_map_filter').hide();
									}
									
									if(demo_layout_arr["list_show"] =='1'){
										if(demo_layout_arr["list_pos"] =='1'){
											 jQuery('#demo_map_list_top').show();
											 jQuery('#demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='2'){
											 jQuery('#demo_map_list_bottom').show();
											 jQuery('#demo_map_list_top, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='3'){
											 jQuery('#demo_map_list_left').show();
											 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_right, #demo_map_filter').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='4'){
											 jQuery('#demo_map_list_right').show();
											 jQuery('#demo_map_list_top, #demo_map_list_left, #demo_map_list_bottom, #demo_map_filter').hide();
										 }
										 else {
											 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
										 }
									}
									else{
										 jQuery('#demo_map_list_top, #demo_map_list_left, #demo_map_list_left, #demo_map_list_right, #demo_map_filter').hide();
									}
									
								}

								if(demo_layout_arr["type"] =='L4'){
									
									if(demo_layout_arr["search_show"] =='1'){
										 if(demo_layout_arr["search_pos"] =='1'){
											 jQuery('#demo_map_search_top').show();
											 jQuery('#demo_map_search_bottom').hide();
										 }
										 else if(demo_layout_arr["search_pos"] =='2'){
											 jQuery('#demo_map_search_bottom').show();
											 jQuery('#demo_map_search_top').hide();
										 }
										 else{
											 jQuery('#demo_map_search_bottom').hide();
											 jQuery('#demo_map_search_top').hide();
										 }
										 
									}
									else {
											 jQuery('#demo_map_search_bottom').hide();
											 jQuery('#demo_map_search_top').hide();
									}
									
									if(demo_layout_arr["list_show"] =='1'){
										if(demo_layout_arr["list_pos"] =='1'){
											 jQuery('#demo_map_list_top').show();
											 jQuery('#demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='2'){
											 jQuery('#demo_map_list_bottom').show();
											 jQuery('#demo_map_list_top, #demo_map_list_left, #demo_map_list_right').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='3'){
											 jQuery('#demo_map_list_left').show();
											 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_right').hide();
										 }
										 else if(demo_layout_arr["list_pos"] =='4'){
											 jQuery('#demo_map_list_right').show();
											 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left').hide();
										 }
										 else {
											 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right').hide();
										 }
									}
									else{
										 jQuery('#demo_map_list_top, #demo_map_list_bottom, #demo_map_list_left, #demo_map_list_right').hide();
									}

									if(demo_layout_arr["filter_show"] =='1'){
										if(demo_layout_arr["filter_pos"] =='1'){
											 jQuery('#demo_map_filter').show();
											 jQuery('#demo_map_filter').addClass("demo_map_filter_set_left");
											 jQuery('#demo_map_filter').removeClass("demo_map_filter_set_right");
											 
										 }
										 else if(demo_layout_arr["filter_pos"] =='2'){
											 jQuery('#demo_map_filter').show();
											 jQuery('#demo_map_filter').addClass("demo_map_filter_set_right");
											 jQuery('#demo_map_filter').removeClass("demo_map_filter_set_left");
										 }
										 else {
											 jQuery('#demo_map_filter').removeClass("demo_map_filter_set_left");
											 jQuery('#demo_map_filter').removeClass("demo_map_filter_set_right");
											 jQuery('#demo_map_filter').hide();
										 }
									}
									else {
											jQuery('#demo_map_filter').removeClass("demo_map_filter_set_left");
											jQuery('#demo_map_filter').removeClass("demo_map_filter_set_right");
											jQuery('#demo_map_filter').hide();
										 }
									
								}

							var map_copy = new google.maps.Map(document.getElementById("map_copy"),mapProp);
							   var marker = new google.maps.Marker({
							  map: map_copy,
							draggable:true
							});
							marker.setPosition(mapCenter);
							marker.setVisible(true);
							
							google.maps.event.addListener(marker, 'dragend', function() {
								
								jQuery('#sett_point_latitude').val(marker.getPosition().lat());
								jQuery('#sett_point_longitude').val(marker.getPosition().lng()); 
								
							});
							map_copy.setMapTypeId(google.maps.MapTypeId[set_map_type_id]);
						}
						
						function get_skin_values(){
							var copy_map_skin_FT = document.getElementsByName('sett_map_skin_FT[]');
							var copy_map_skin_PR = document.getElementsByName('sett_map_skin_PR[]');
							var copy_map_skin_color = document.getElementsByName('sett_map_skin_PR_color[]');
							var copy_map_skin_visible = document.getElementsByName('sett_map_skin_PR_visibility[]');
							var copy_map_skin_lightness = document.getElementsByName('sett_map_skin_PR_lightness[]');
							var copy_map_skin_hue = document.getElementsByName('sett_map_skin_PR_hue[]');
							var copy_map_skin_saturation = document.getElementsByName('sett_map_skin_PR_saturation[]');
							
							var skin_array = [];
							for (var i = 0; i <copy_map_skin_FT.length; i++) {
								var FT = copy_map_skin_FT[i]; 
								var PR = copy_map_skin_PR[i];  
								var color = copy_map_skin_color[i]; 
								var visible = copy_map_skin_visible[i]; 
								var lightness = copy_map_skin_lightness[i];  
								var hue = copy_map_skin_hue[i]; 
								var saturation_cpy = copy_map_skin_saturation[i];
								
								skin_array[i] = Array(FT.value,PR.value,color.value,visible.value,lightness.value,hue.value,saturation_cpy.value);	
							}
							
							return skin_array;
						}
				</script>
			   <?php //}?>	
		</div>      
<?php
}

/*
 * Manage Template
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string  (HTML)
 */ 

function  jsps_template_manage_form() {
	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access(); 

	// Get all user input values	$jsps_del_templateID = ''; 	$Del_TemplateID = trim($_GET['Del_TemplateID']);	if(isset($Del_TemplateID)){		if(intval($Del_TemplateID)){			if($Del_TemplateID >= 0){ 				$jsps_del_templateID =  $Del_TemplateID;			} 		}	}

	$jsps_delete_temp = '';

	if($jsps_del_templateID) {
	   $jsps_delete_temp = jsps_delete_template($jsps_del_templateID);
	}

	 global $wpdb;
	 $i = 1;
	 $table_name = $wpdb->prefix.'jsps_settings';
	 $template_results = $wpdb->get_results('SELECT * FROM '.$table_name);
	 ?>

	 <div class="jsps_map_wrap">
		<div class="jsps_map_titles"> 
			<h2><?php esc_html_e( 'Add Template', 'rampit-world-map' ); ?></h2>
		</div>
		<?php if($jsps_delete_temp == 1){ ?>	
			  <div class="jsps_map_fail"><h2><?php esc_html_e( 'Template has been deleted Successfully', 'rampit-world-map' ); ?></h2></div>
		<?php            
			  }
			 /* Create URL with query string */
			 // Edit URL array
			 $jsps_add_template =  array(
									'page' => 'jsps_setting'
									);                  
		?>	
		<div class="heading add_template">
			<h3> <?php esc_html_e( 'Add Template', 'rampit-world-map' ); ?></h3>
		</div>
		<div class="jsps_add_template">
			 <div class="managepage_addmaster">
				<ul>
				  <li><a href="<?php echo add_query_arg( $jsps_add_template , menu_page_url("setting",false));?>"><?php esc_html_e( 'Add Template', 'rampit-world-map' ); ?></a></li>
				</ul>
				<div><b>NOTE: System not allow to Edit/Delete the default templates. You could COPY the default templates and EDIT the changes.</b></div><br />
			 </div>
			 <table cellspacing="0">
			 <tr>
				<th> <?php esc_html_e( 'S.No', 'rampit-world-map' ); ?></a> </th>
				<th> <?php esc_html_e( 'Template title', 'rampit-world-map' ); ?></a> </th>
				<th> <?php esc_html_e( 'Template Map', 'rampit-world-map' ); ?></a> </th>
				<th> <?php esc_html_e( 'Zoom Level', 'rampit-world-map' ); ?></a> </th>
				<th> <?php esc_html_e( 'Latitude', 'rampit-world-map' ); ?></a> </th>
				<th> <?php esc_html_e( 'Longitude', 'rampit-world-map' ); ?></a></th>
				<th> <?php esc_html_e( 'Width', 'rampit-world-map' ); ?></a></th>
				<th> <?php esc_html_e( 'Height', 'rampit-world-map' ); ?></a></th>
				<th colspan="3" align="center"> <?php esc_html_e( 'Action', 'rampit-world-map' ); ?></a></th>
			 </tr>
			 <?php
			 if(count($template_results) > 0){
				 foreach($template_results as $templates){
					 $disable_link_url = 'no'; 
					 if($templates->Setting_id <= 15 )
					 { $disable_link_option ="pointer-events: none; opacity: .4;";
					   $disable_link_url = 'yes'; 
					 } else{ $disable_link_option=""; 
						$disable_link_url = 'no';
					 }
											  
					 /* Create URL with query string */
					 // Edit URL array
					 $jsps_edit_templateID =  array('Edit_TemplateID' => $templates->Setting_id,
											'page' => 'jsps_setting'
											);
					 // Delete URL array
					 $jsps_del_templateID =  array('Del_TemplateID' => $templates->Setting_id,
											'page' => 'jsps_managetemplate'
											);    

					 // Copy URL array
					 $jsps_copy_templateID =  array('Copy_TemplateID' => $templates->Setting_id,
											'page' => 'jsps_setting'
											);       
                    $default_icon = plugins_url( 'images/map_templates/Template'.$i.'.jpg', dirname(dirname(__FILE__)));												
				 ?>		 
					<tr>
					 <td align="center"><?php echo esc_html($i); ?></td>
					 <td align="center"><?php echo esc_html($templates->template_title); ?></td>
					  <?php if($i < 16) { ?>
						<td align="center"><img src="<?php echo esc_url($default_icon);?>" width="50" height="50"></td>
					  <?php }else { ?>
						<td align="center"></td>
					 <?php } ?>
					 <td align="center"><?php echo esc_html($templates->Zoom_level); ?></td>
					 <td align="center"><?php echo esc_html($templates->Center_latitude); ?></td>
					 <td align="center"><?php echo esc_html($templates->Center_longitude); ?></td>
					 <td align="center"><?php echo esc_html($templates->width); ?></td>
					 <td align="center"><?php echo esc_html($templates->height); ?></td>
					 <td align="center"><a style="<?php echo esc_html($disable_link_option); ?>" href="<?php echo ($disable_link_url == 'no') ? add_query_arg( $jsps_edit_templateID , menu_page_url("setting",false)) : '#';?>"><?php esc_html_e( 'Edit', 'rampit-world-map' ); ?></a> </td>
					 <td align="center"><a style="<?php echo esc_html($disable_link_option); ?>" href="<?php echo ($disable_link_url == 'no') ? add_query_arg( $jsps_del_templateID , menu_page_url("managetemplate",false)) : '#';?>"  onclick="return confirm('Are you sure want to delete row?')"><?php esc_html_e( 'Delete', 'rampit-world-map' ); ?></a> </td>
					 <td align="center"><a href="<?php echo add_query_arg( $jsps_copy_templateID , menu_page_url("setting",false));?>"><?php esc_html_e( 'Copy', 'rampit-world-map' ); ?></a> </td>
					</tr>		
				 <?php	 
				  $i = $i + 1;
				 }
			 }
			 else{
			 ?>
				  <tr>
					 <td colspan="8" align="center"><?php esc_html_e( 'No Template added yet', 'rampit-world-map' ); ?></td>
				  </tr>
			 <?php }  ?>
			 </table>
		</div>
	</div>
<?php   
}


/*
 * Insert settings
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string
 */  

function jsps_insert_settings( $jsps_template_post_arr ) {

	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
			 
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_settings';
	$table_template_skin = $wpdb->prefix . 'jsps_template_skin';

	$mapcontrolscheck = array("zoom", "maptype", "scale", "scroll");
	$inputcontrols = $jsps_template_post_arr['sett_control'];
	$zoom = 1;
	$maytype = 1;
	$scale = 1;
	$scroll = 1;

	//Retrive checkbox value from array
	if(isset($jsps_template_post_arr['sett_control'][0])){
	  foreach ($inputcontrols as $control){
		  if (in_array($control, $inputcontrols)) {
			  if($control == 'zoom')
			  {
				  $zoom = 0;
			  }
			  if($control == 'maptype')
			  {
				  $maytype = 0;
			  }
			  if($control == 'scale')
			  {
				  $scale = 0;
			  }
			  if($control == 'scroll')
			  {
				  $scroll = 0;
			  }
		  }
	  }
	}

	$width_px ="";
	if(!empty($jsps_template_post_arr['sett_width'])){
		$width_px = $jsps_template_post_arr['sett_width'].'px';
	}

	$height_px ="";
	if(!empty($jsps_template_post_arr['sett_height'])){
		$height_px = $jsps_template_post_arr['sett_height'].'px';
	}

	$full_window = 0;
	if(isset($jsps_template_post_arr['sett_fullwindow'])){
		$full_window = 1;
	}

	$fixedheight_px ="";
	if(!empty($jsps_template_post_arr['sett_fixed_height'])){
		$fixedheight_px = $jsps_template_post_arr['sett_fixed_height'].'px';
	}

	$as_background ="";
	if(isset($jsps_template_post_arr['sett_as_background'])){
		$as_background = 0;
	}
	else{
		$as_background = 99999;
	}

	$det_width="";
	 if(!empty($jsps_template_post_arr['sett_det_map_width'])){
		 $det_width=$jsps_template_post_arr['sett_det_map_width'].'px';
	 }
	 
	 $det_height="";
	 if(!empty($jsps_template_post_arr['sett_det_map_height'])){
		 $det_height=$jsps_template_post_arr['sett_det_map_height'].'px';
	 }

	$sett_template_layout="";
	if(isset($jsps_template_post_arr['sett_map_layouts'])){ $sett_template_layout = $jsps_template_post_arr['sett_map_layouts']; }

	$sett_template_search_visible = 0;
	if(isset($jsps_template_post_arr['sett_search_visible'])){ $sett_template_search_visible = $jsps_template_post_arr['sett_search_visible']; }

	$sett_template_search_position = 0;
	if(isset($jsps_template_post_arr['sett_search_position'])){ $sett_template_search_position = $jsps_template_post_arr['sett_search_position']; }

	$sett_template_list_show = 0;
	if(isset($jsps_template_post_arr['sett_list_visible'])){ $sett_template_list_show = $jsps_template_post_arr['sett_list_visible']; }

	$sett_template_list_position = 0;
	if(isset($jsps_template_post_arr['sett_list_position'])){ $sett_template_list_position = $jsps_template_post_arr['sett_list_position']; }

	$sett_template_category_show = 0;
	if(isset($jsps_template_post_arr['sett_category_visible'])){ $sett_template_category_show = $jsps_template_post_arr['sett_category_visible']; }

	$sett_template_category_position = 0;
	if(isset($jsps_template_post_arr['sett_category_position'])){ $sett_template_category_position = $jsps_template_post_arr['sett_category_position']; }

	$insert_template_title = stripslashes_deep(htmlentities($jsps_template_post_arr['sett_title'], ENT_QUOTES));

	$template_insert = $wpdb->insert($table_name,
							 array( 
							   'Setting_id' =>'',
							   'template_title'=>sanitize_text_field($insert_template_title),
							   'Zoom_level' =>sanitize_text_field($jsps_template_post_arr['sett_zoom']),
							   'Center_latitude' =>sanitize_text_field($jsps_template_post_arr['sett_point_latitude']),
							   'Center_longitude'=>sanitize_text_field($jsps_template_post_arr['sett_point_longitude']),
							   'width'=>sanitize_text_field($width_px),
							   'height'=>sanitize_text_field($height_px),
							   'template_fullwindow'=>sanitize_text_field($full_window),
							   'template_fixedheight'=>sanitize_text_field($fixedheight_px),
							   'background'=>sanitize_text_field($as_background),
							   'maptypeid'=>sanitize_text_field($jsps_template_post_arr['sett_maptypeid']),
							   'Zoom_control'=>sanitize_text_field($zoom),
							   'Maptype_control'=>sanitize_text_field($maytype),
							   'Scale_control'=>sanitize_text_field($scale),
							   'scroll_wheel'=>sanitize_text_field($scroll),
							   'det_map_width'=>sanitize_text_field($det_width),
							   'det_map_height'=>sanitize_text_field($det_height),
							   'temp_layout'=>sanitize_text_field($sett_template_layout),
							   'search_form_show'=>sanitize_text_field($sett_template_search_visible),
							   'search_form_position'=>sanitize_text_field($sett_template_search_position),
							   'list_form_show'=>sanitize_text_field($sett_template_list_show),
							   'list_form_position'=>sanitize_text_field($sett_template_list_position),
							   'category_filter_show'=>sanitize_text_field($sett_template_category_show),
							   'category_filter_position'=>sanitize_text_field($sett_template_category_position),
							   'last_updated'=> date("Y-m-d H:i:s",time())
							   )
						  );
						  
						  
			$template_last_id = $wpdb->insert_id;     // insert seperate template skin details 
			if($template_last_id || ! wp_verify_nonce( $_POST['jsps_add_map_template_nonce_field'], 'jsps_add_map_template_nonce_action' )){
				for($i = 0; $i < $jsps_template_post_arr['hid_skin_count']; $i++)
				{ 
				  if(!empty($jsps_template_post_arr['sett_map_skin_FT'][$i]) || !empty($jsps_template_post_arr['sett_map_skin_PR_lightness'][$i]) || !empty($jsps_template_post_arr['sett_map_skin_PR_hue'][$i]) || !empty($jsps_template_post_arr['sett_map_skin_PR_saturation'][$i]) )
				  {
						$PR_visibility = 2;
						if($jsps_template_post_arr['sett_map_skin_PR_visibility'][$i] == 'on'){
							$PR_visibility = 1;
						}
						
						$wpdb->insert($table_template_skin,
							 array( 
							   'template_skin_id'=>'',
							   'template_id'=>$template_last_id,
							   'feature_type'=>$jsps_template_post_arr['sett_map_skin_FT'][$i],
							   'feature_type_property'=>$jsps_template_post_arr['sett_map_skin_PR'][$i],
							   'color'=>$jsps_template_post_arr['sett_map_skin_PR_color'][$i],
							   'visibility'=>$jsps_template_post_arr['sett_map_skin_PR_visibility'][$i],
							   'lightness'=>$jsps_template_post_arr['sett_map_skin_PR_lightness'][$i],
							   'hue'=>$jsps_template_post_arr['sett_map_skin_PR_hue'][$i],
							   'saturation'=>$jsps_template_post_arr['sett_map_skin_PR_saturation'][$i]
							   )
						);
				  }
				}
		   }			  	  
	return $template_insert;
}
 

/*
 * Update settings
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    string 
 */   

function jsps_update_settings() {
    	 
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
			  
	global $wpdb;
	$table_sett_update = $wpdb->prefix.'jsps_settings';
	$table_template_skin_update = $wpdb->prefix . 'jsps_template_skin';

	$mapcontrolscheck = array("zoom", "maptype", "scale");
	if(count($_POST['sett_control']) >= 0){
		$inputcontrols = $_POST['sett_control'];
			 foreach ($inputcontrols as $key => $val) {
				$inputcontrols[$key] = sanitize_text_field($val);
			 }
	}else{
		$inputcontrols = array();
	}
	$zoom = 1;
	$maytype = 1;
	$scale = 1;
	$scroll = 1;

	//Retrive checkbox value from array
	if(isset($_POST['sett_control'][0])){
	  foreach ($inputcontrols as $control){
		  if (in_array($control, $inputcontrols)) {
			  if($control == 'zoom')
			  {
				  $zoom = 0;
			  }
			  if($control == 'maptype')
			  {
				  $maytype = 0;
			  }
			  if($control == 'scale')
			  {
				  $scale = 0;
			  }
			  if($control == 'scroll')
			  {
				  $scroll = 0;
			  }
		  }
	  }
	}

	$width_px ="";
	if(!empty($_POST['sett_width'])){
		$width_px = sanitize_text_field($_POST['sett_width']).'px';
	}

	$height_px ="";
	if(!empty($_POST['sett_height'])){
		$height_px = sanitize_text_field($_POST['sett_height']).'px';
	}

	$full_window = 0;
	if(isset($_POST['sett_fullwindow']) || $_POST['sett_fullwindow']){
		$full_window = 1;
	}

	$fixedheight_px ="";
	if(!empty($_POST['sett_fixed_height'])){
		$fixedheight_px = sanitize_text_field($_POST['sett_fixed_height']).'px';
	}

	$as_background ="";
	if(isset($_POST['sett_as_background'])){
		$as_background = 0;
	}
	else{
		$as_background = 99999;
	}

	$det_width="";
	 if(!empty($_POST['sett_det_map_width'])){
		 $det_width=sanitize_text_field($_POST['sett_det_map_width']).'px';
	 }
	 
	 $det_height="";
	 if(!empty($_POST['sett_det_map_height'])){
		 $det_height=sanitize_text_field($_POST['sett_det_map_height']).'px';
	 }

	$sett_template_layout="";
	if(isset($_POST['sett_map_layouts'])){ $sett_template_layout = sanitize_text_field($_POST['sett_map_layouts']); }

	/*
	if($sett_template_layout == 'L1')
	{
		$sett_template_search_visible = 0;
		$sett_template_search_position = 0;
		$sett_template_list_show = 0;
		$sett_template_list_position = 0;
		$sett_template_category_show = 0;
		$sett_template_category_position = 0;
	}

	if($sett_template_layout == 'L2')
	{
		$sett_template_search_visible = $_POST['sett_search_visible'];
		$sett_template_search_position = $_POST['sett_search_position'];
		$sett_template_list_show = 0;
		$sett_template_list_position = 0;
		$sett_template_category_show = 0;
		$sett_template_category_position = 0;
	}

	if($sett_template_layout == 'L3')
	{
		$sett_template_search_visible = $_POST['sett_search_visible'];
		$sett_template_search_position = $_POST['sett_search_position'];
		$sett_template_list_show = $_POST['sett_list_visible'];
		$sett_template_list_position = $_POST['sett_list_position'];
		$sett_template_category_show = 0;
		$sett_template_category_position = 0;
	}

	if($sett_template_layout == 'L4')
	{
		$sett_template_search_visible = $_POST['sett_search_visible'];
		$sett_template_search_position = $_POST['sett_search_position'];
		$sett_template_list_show = $_POST['sett_list_visible'];
		$sett_template_list_position = $_POST['sett_list_position'];
		$sett_template_category_show = $_POST['sett_category_visible'];
		$sett_template_category_position = $_POST['sett_category_position'];
	}
	*/

	$sett_template_search_visible = $_POST['sett_search_visible'];		$jsps_del_locationID = ''; 	$Del_LocationID = trim($_GET['Del_LocationID']);	if(isset($Del_LocationID)){		if(intval($Del_LocationID)){			if($Del_LocationID >= 0){ 				$jsps_del_locationID =  $Del_LocationID;			} 		}	}
	$sett_template_search_position = ''; 	$sett_search_position = trim($_POST['sett_search_position']);	if(isset($sett_search_position)){		if(intval($sett_search_position)){			if($sett_search_position >= 0){ 				$sett_template_search_position =  $sett_search_position;			} 		}	}	 	$sett_template_list_show = ''; 	$sett_list_visible = trim($_POST['sett_list_visible']);	if(isset($sett_list_visible)){		if(intval($sett_list_visible)){			if($sett_list_visible >= 0){ 				$sett_template_list_show =  $sett_list_visible;			} 		}	}	   	$sett_template_list_position = ''; 	$sett_list_position = trim($_POST['sett_list_position']);	if(isset($sett_list_position)){		if(intval($sett_list_position)){			if($sett_list_position >= 0){ 				$sett_template_list_position =  $sett_list_position;			} 		}	}	$sett_template_category_show = ''; 	$sett_category_visible = trim($_POST['sett_category_visible']);	if(isset($sett_category_visible)){		if(intval($sett_category_visible)){			if($sett_category_visible >= 0){ 				$sett_template_category_show =  $sett_category_visible;			} 		}	}		$sett_template_category_position = ''; 	$sett_category_position = trim($_POST['sett_category_position']);	if(isset($sett_category_position)){		if(intval($sett_category_position)){			if($sett_category_position >= 0){ 				$sett_template_category_position =  $sett_category_position;			} 		}	}
	$update_template_title = stripslashes_deep(htmlentities($_POST['sett_title'], ENT_QUOTES));
	$template_update = $wpdb->update($table_sett_update,
							 array(
							   'template_title'=>sanitize_text_field($update_template_title),
							   'Zoom_level' =>sanitize_text_field($_POST['sett_zoom']),
							   'Center_latitude' =>sanitize_text_field($_POST['sett_point_latitude']),
							   'Center_longitude'=>sanitize_text_field($_POST['sett_point_longitude']),
							   'width'=>sanitize_text_field($width_px),
							   'height'=>sanitize_text_field($height_px),
							   'template_fullwindow'=>sanitize_text_field($full_window),
							   'template_fixedheight'=>sanitize_text_field($fixedheight_px),
							   'background'=>sanitize_text_field($as_background),
							   'maptypeid'=>sanitize_text_field($_POST['sett_maptypeid']),
							   'Zoom_control'=>sanitize_text_field($zoom),
							   'Maptype_control'=>sanitize_text_field($maytype),
							   'Scale_control'=>sanitize_text_field($scale),
							   'scroll_wheel'=>sanitize_text_field($scroll),
							   'det_map_width'=>sanitize_text_field($det_width),
							   'det_map_height'=>sanitize_text_field($det_height),
							   'temp_layout'=>sanitize_text_field($sett_template_layout),
							   'search_form_show'=>sanitize_text_field($sett_template_search_visible),
							   'search_form_position'=>sanitize_text_field($sett_template_search_position),
							   'list_form_show'=>sanitize_text_field($sett_template_list_show),
							   'list_form_position'=>sanitize_text_field($sett_template_list_position),
							   'category_filter_show'=>sanitize_text_field($sett_template_category_show),
							   'category_filter_position'=>sanitize_text_field($sett_template_category_position),
							   'last_updated'=> date("Y-m-d H:i:s",time())						   
							   ),
							   array('Setting_id'=> sanitize_text_field($_REQUEST['Edit_TemplateID']))
						   );							   
	if($template_update || ! wp_verify_nonce( $_POST['jsps_add_map_template_nonce_field'], 'jsps_add_map_template_nonce_action' ))
	{
		$delete_skins = $wpdb->get_results('delete FROM '.$table_template_skin_update.' where template_id ='. sanitize_text_field($_REQUEST['Edit_TemplateID']) );
		$PR_visibility ="";
		for($i = 0; $i < $_POST['hid_skin_count']; $i++)
		{
			if(!empty($_POST['sett_map_skin_FT'][$i]) || !empty($_POST['sett_map_skin_PR_lightness'][$i]) || !empty($_POST['sett_map_skin_PR_hue'][$i]) || !empty($_POST['sett_map_skin_PR_saturation'][$i]) )
			{
				$PR_visibility = 2;
				if($_POST['sett_map_skin_PR_visibility'][$i] == 'on'){
					$PR_visibility = 1;
				}
				$wpdb->insert($table_template_skin_update,
				array( 
					'template_skin_id'=>'',
					'template_id'=>sanitize_text_field($_REQUEST['Edit_TemplateID']),
					'feature_type'=>sanitize_text_field($_POST['sett_map_skin_FT'][$i]),
					'feature_type_property'=>sanitize_text_field($_POST['sett_map_skin_PR'][$i]),
					'color'=>sanitize_text_field($_POST['sett_map_skin_PR_color'][$i]),
					'visibility'=>sanitize_text_field($_POST['sett_map_skin_PR_visibility'][$i]),
					'lightness'=>sanitize_text_field($_POST['sett_map_skin_PR_lightness'][$i]),
					'hue'=>sanitize_text_field($_POST['sett_map_skin_PR_hue'][$i]),
					'saturation'=>sanitize_text_field($_POST['sett_map_skin_PR_saturation'][$i])
					)
				);
		  }
		}
	}				   
	return $template_update; 
}
    
 
/*
 * delete template
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    ''
 */ 

function jsps_delete_template($jsps_del_templateID) {	
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
		  
	global $wpdb;
	$table_name = $wpdb->prefix.'jsps_settings';
	$delete_template = $wpdb->delete( $table_name, array( 'Setting_id' =>$jsps_del_templateID) );	 
	return  $delete_template;
}
 
/*
 * template skins load on add and edit
 * @since     1.0.0
 * @access    public
 * @param     -     -     -
 * @return    ''
 */  
function jsps_map_skin_list_template($skin_count,$skin_flag,$skin_template_id) {
	  
	/*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
			 
	if($skin_flag == 2){
	  global $wpdb;
	  $table_name = $wpdb->prefix . 'jsps_settings';
	  $table_template_skin = $wpdb->prefix . 'jsps_template_skin';

	  $table_template_skin_count_update = $wpdb->get_results('SELECT * FROM '.$table_template_skin.' WHERE template_id ='.$skin_template_id);
	  
	  $skin_count_update = 1;
	  if( count($table_template_skin_count_update) > 0)
		   $skin_count_update = count($table_template_skin_count_update);
	  }
	  
	?>

	<?php if($skin_flag == 2){?> 
		<?php for($i = 0; $i<$skin_count_update; $i++){ ?>
		 <div class="template_skins" id="">
				<div class="template_skins_inner">
				  <div><select name="sett_map_skin_FT[]" id="sett_map_skin_FT<?php echo "_".$i ?>" class="sett_map_skin">
							 <option value="" selected>-select-</option>
							 <option value="administrative">administrative</option>
							 <option value="administrative.country">administrative.country</option>
							 <option value="administrative.land_parcel">administrative.land_parcel</option>
							 <option value="administrative.locality">administrative.locality</option>
							 <option value="administrative.neighborhood">administrative.neighborhood</option>
							 <option value="administrative.province">administrative.province</option>
							 <option value="all">all</option>
							 <option value="landscape">Landscape</option>
							 <option value="landscape.man_made">landscape.man_made</option>
							 <option value="landscape.natural">landscape.natural</option>
							 <option value="landscape.natural.landcover">landscape.natural.landcover</option>
							 <option value="landscape.natural.terrain">landscape.natural.terrain</option>
							 <option value="poi">poi</option>
							 <option value="poi.attraction">poi.attraction</option>
							 <option value="poi.business">poi.business</option>
							 <option value="poi.government">poi.government</option>
							 <option value="poi.medical">poi.medical</option>
							 <option value="poi.park">poi.park</option>
							 <option value="poi.place_of_worship">poi.place_of_worship</option>
							 <option value="poi.school">poi.school</option>
							 <option value="poi.sports_complex">poi.sports_complex</option>
							 <option value="road">road</option>
							 <option value="road.arterial">road.arterial</option>
							 <option value="road.highway">road.highway</option>
							 <option value="road.highway.controlled_access">road.highway.controlled_access</option>
							 <option value="road.local">road.local</option>
							 <option value="transit">transit</option>
							 <option value="transit.line">transit.line</option>
							 <option value="transit.station">transit.station</option>
							 <option value="transit.station.airport">transit.station.airport</option>
							 <option value="transit.station.bus">transit.station.bus</option>
							 <option value="transit.station.rail">transit.station.rail</option>
							 <option value="water">water</option></select>
				  </div>
				</div> 
				<script>
						jQuery('#sett_map_skin_FT<?php echo "_".$i ?>').val("<?php echo isset($table_template_skin_count_update[$i]->feature_type)? $table_template_skin_count_update[$i]->feature_type : ''; ?>")
				</script>
				<div class="template_skins_inner">
				  <div><select name="sett_map_skin_PR[]" id="sett_map_skin_PR<?php echo "_".$i ?>"  class="sett_map_skin">
						 <option value="" selected>-select-</option>
						 <option value="all">all</option>
						 <option value="geometry">geometry</option>
						 <option value="geometry.fill">geometry.fill</option>
						 <option value="geometry.stroke">geometry.stroke</option>
						 <option value="labels">labels</option>
						 <option value="labels.icon">labels.icon</option>
						 <option value="labels.text">labels.text</option>
						 <option value="labels.text.fill">labels.text.fill</option>
						 <option value="labels.text.stroke">labels.text.stroke</option></select>
				  </div>
				</div>
				<script>
						jQuery('#sett_map_skin_PR<?php echo "_".$i ?>').val("<?php echo isset($table_template_skin_count_update[$i]->feature_type_property) ? $table_template_skin_count_update[$i]->feature_type_property : ''; ?>")
				</script>
	   
				<div class="template_skins_inner">
				  <div><input type="text" name="sett_map_skin_PR_color[]" value="<?php  echo isset($table_template_skin_count_update[$i]->color) ? $table_template_skin_count_update[$i]->color : ''; ?>" pattern="[#][0-9A-Za-z]*" title="Invalid format color" class="sett_map_skin_att"/></div>
				</div>
	   
				<div class="template_skins_inner">
				 <div><select name="sett_map_skin_PR_visibility[]" id="sett_map_skin_PR_visibility<?php echo "_".esc_html($i) ?>" class="sett_map_skin_att">
							 <option value="" selected>-select-</option>
							 <option value="1">On</option>
							 <option value="2">Off</option>
							 <option value="3">simplified</option>
					   </select>
				 </div>
				</div>
				
				<script>
						jQuery('#sett_map_skin_PR_visibility<?php echo "_".$i ?>').val("<?php echo isset($table_template_skin_count_update[$i]->visibility) ? $table_template_skin_count_update[$i]->visibility : ''; ?>")
				</script>
				
				<div class="template_skins_inner">
				  <div><input type="text" class="sett_mapskin" name="sett_map_skin_PR_lightness[]"  pattern="[0-9-]*" title="Invalid format lightness" value="<?php  echo isset($table_template_skin_count_update[$i]->lightness) ? $table_template_skin_count_update[$i]->lightness : ''; ?>" /></div>
				</div>
				
				<div class="template_skins_inner">
				  <div><input type="hidden" class="sett_mapskin" name="sett_map_skin_PR_hue[]" pattern="[#][0-9A-Za-z]*" title="Invalid format hue" value="<?php  echo isset($table_template_skin_count_update[$i]->hue) ? $table_template_skin_count_update[$i]->hue : ''; ?>" /></div>
				</div>
				
				<div class="template_skins_inner">
				  <div><input type="hidden" class="sett_mapskin" name="sett_map_skin_PR_saturation[]" pattern="[0-9-]*" title="Invalid format saturation" value="<?php  echo isset($table_template_skin_count_update[$i]->saturation) ? $table_template_skin_count_update[$i]->saturation : ''; ?>" /></div>
				</div>
				
				<?php
				if( $i != 0 ) {
				?>
				<div style="float:left;">
				  <div><a class="delete_skin" >X</a></div>
				</div>
			   <?php } else { ?> 
			   <span class="skin_options">
				  <span><a id="add_new_skin"><img src="<?php echo  plugins_url( 'images/add_new_skin.png', dirname(dirname(__FILE__)));?>" alt="add new"></a></span>
			   </span>                                   
			   <?php } ?>
		 </div>
		<?php }?>

	   <?php } else { ?>
		  <?php for($i = 0; $i<$skin_count; $i++){ ?>
			<div class="template_skins" id="">
				<div class="template_skins_inner">
				  <div><select name="sett_map_skin_FT[]" class="sett_map_skin" style="width: 130px;">
							 <option value="" selected>-select-</option>
							 <option value="administrative">administrative</option>
							 <option value="administrative.country">administrative.country</option>
							 <option value="administrative.land_parcel">administrative.land_parcel</option>
							 <option value="administrative.locality">administrative.locality</option>
							 <option value="administrative.neighborhood">administrative.neighborhood</option>
							 <option value="administrative.province">administrative.province</option>
							 <option value="all">all</option>
							 <option value="landscape">Landscape</option>
							 <option value="landscape.man_made">landscape.man_made</option>
							 <option value="landscape.natural">landscape.natural</option>
							 <option value="landscape.natural.landcover">landscape.natural.landcover</option>
							 <option value="landscape.natural.terrain">landscape.natural.terrain</option>
							 <option value="poi">poi</option>
							 <option value="poi.attraction">poi.attraction</option>
							 <option value="poi.business">poi.business</option>
							 <option value="poi.government">poi.government</option>
							 <option value="poi.medical">poi.medical</option>
							 <option value="poi.park">poi.park</option>
							 <option value="poi.place_of_worship">poi.place_of_worship</option>
							 <option value="poi.school">poi.school</option>
							 <option value="poi.sports_complex">poi.sports_complex</option>
							 <option value="road">road</option>
							 <option value="road.arterial">road.arterial</option>
							 <option value="road.highway">road.highway</option>
							 <option value="road.highway.controlled_access">road.highway.controlled_access</option>
							 <option value="road.local">road.local</option>
							 <option value="transit">transit</option>
							 <option value="transit.line">transit.line</option>
							 <option value="transit.station">transit.station</option>
							 <option value="transit.station.airport">transit.station.airport</option>
							 <option value="transit.station.bus">transit.station.bus</option>
							 <option value="transit.station.rail">transit.station.rail</option>
							 <option value="water">water</option></select>
				  </div>
				</div> 
	   
				<div class="template_skins_inner">
				  <div><select name="sett_map_skin_PR[]"  class="sett_map_skin">
						<option value="" selected>-select-</option>
						<option value="all">all</option>
						<option value="geometry">geometry</option>
						<option value="geometry.fill">geometry.fill</option>
						<option value="geometry.stroke">geometry.stroke</option>
						<option value="labels">labels</option>
						<option value="labels.icon">labels.icon</option>
						<option value="labels.text">labels.text</option>
						<option value="labels.text.fill">labels.text.fill</option>
						<option value="labels.text.stroke">labels.text.stroke</option></select>
				  </div>
				</div>
	   
				<div class="template_skins_inner">
				  <div><input type="text" name="sett_map_skin_PR_color[]" pattern="[#][0-9A-Za-z]*" title="Invalid format color" class="sett_map_skin_att"/></div>
				</div>
				 
				<div class="template_skins_inner">
				 <div> <select name="sett_map_skin_PR_visibility[]"  class="sett_map_skin_att">
							 <option value="" selected>-select-</option>
							 <option value="1">On</option>
							 <option value="2">Off</option>
							 <option value="3">simplified</option>
					   </select>
				 </div>
				</div>
				
				<div class="template_skins_inner">
				  <div><input  type="text" class="sett_mapskin" name="sett_map_skin_PR_lightness[]" pattern="[0-9-]*" title="Invalid format lightness" /></div>
				</div>
				
				<div class="template_skins_inner">
				  <div><input type="hidden" class="sett_mapskin"   name="sett_map_skin_PR_hue[]" pattern="[#][0-9A-Za-z]*" title="Invalid format hue" /></div>
				</div>
				
				<div class="template_skins_inner">
				  <div><input type="hidden" class="sett_mapskin" name="sett_map_skin_PR_saturation[]" pattern="[0-9-]*" title="Invalid format saturation" /></div>
				</div>
			   <span class="skin_options">
				  <span><a id="add_new_skin"><img src="<?php echo  plugins_url( 'images/add_new_skin.png', dirname(dirname(__FILE__)));?>" alt="add new"></a></span>
			   </span>                                  

			</div>
		  <?php }?> 
	  <?php } ?>   
<?php	
}
