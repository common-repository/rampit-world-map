<?php

/*

 * Jsps Masters to manage All settings masters

 * @link      

 * @since      1.0.0

 * @package    Google World Map

 * @subpackage google_world_map/admin/includes

 * @author     RAMPiT

 */

 

// If this file is called directly, abort.

if ( ! defined( 'ABSPATH' ) ) exit;









/*

 * Map settings form

 * @since     1.0.0

 * @access    public

 * @param     -     -     -

 * @return    String HTML

 */   



function jsps_map_manage_settings() {

	  

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access(); 



	// Get all user input values

	$jsps_api_key = $_POST['setting_map_api'];

	if(isset($_POST['setting_map_api'])){

		if(strlen($jsps_api_key < 100)){

			$jsps_setting_map_api = trim($_POST['setting_map_api']);

		}else{

			$jsps_setting_map_api = '';

		}

	}
	
	$jsps_jsps_location_info_page = ''; 
	$jsps_location_info_page = trim($_POST['jsps_location_info_page']);
	if(isset($jsps_location_info_page)){
		if(intval($jsps_location_info_page)){
			if($jsps_location_info_page >= 0){ 
				$jsps_jsps_location_info_page =  $jsps_location_info_page;
			} 
		}
	}

	$sett_update = '';



	/* Check if value is not empty */

	// Required Fields          

	$all_required_field =  array($jsps_setting_map_api);         



	if(isset($jsps_setting_map_api)) {

	   if( check_val_notempty($all_required_field) ){

		  $sett_update = jsps_map_manage_settings_update( $_POST );

	   }

	}

	global $wpdb;

	$table_name = $wpdb->prefix . 'jsps_map_setting';

	$user_input_page_id ="";



	$results = $wpdb->get_results('SELECT * FROM '.$table_name. ' Limit 1');

	foreach ( $results as $result ){

		 $sett_location_info= $result->loc_info_page;

		 $sett_map_api = $result->map_api_key;

	}



	$args = array(

	'depth'                 => 0,

	'child_of'              => 0,

	'selected'              => 0,

	'echo'                  => 1,

	'name'                  => 'jsps_location_info_page',

	'id'                    => 'jsps_location_info_page', 

	'class'                 => null, 

	'show_option_none'      => '------select------', 

	'show_option_no_change' => null, 

	'option_none_value'     => null, 

	);



	?>

	<div class="jsps_map_wrap">

		<div class="jsps_map_titles"> 

			<h2><?php esc_html_e( 'Settings', 'rampit-world-map' ); ?></h2>

		</div>

		<div class="heading settings_title">

			 <h3><?php esc_html_e( 'Settings', 'rampit-world-map' ); ?></h3>

		 </div>

		<div class="jsps_map_settings">

			<form method="post" action="">

				<?php  if($sett_update) { ?> <div class="jsps_map_success"><h2><?php echo esc_html($sett_update); ?></h2></div> <?php } ?>

				<div class="jsps_map_row">

					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Location Info Form Display Page', 'rampit-world-map' ); ?></h3></div>

					<div><?php wp_dropdown_pages( $args ); ?></div>

				<script>

						jQuery("#jsps_location_info_page").val("<?php echo esc_html($sett_location_info) ?>");

				</script>

				</div>

				<div class="jsps_map_row">

					<div class="jsps_map_subtitles"><h3><?php esc_html_e( 'Map Api Key', 'rampit-world-map' ); ?></h3></div>

					<div><input type="password" name="setting_map_api" id="setting_map_api" value="<?php echo $sett_map_api; ?>" /></div>

				</div>

				<div class="notification_info" style="font-size: 18px;padding-bottom: 14px;padding-top: 14px;color: #F70303;font-weight: bold;">

					<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Click Here</a> to Create API Key from Google account.

				</div>

				<div class="jsps_set_submit"> 

					   <input type="submit" name="submit"  id="submit" class="button button-primary" value="Save" />

				</div>

				 <?php wp_nonce_field( 'jsps_map_settings_nonce_action', 'jsps_map_settings_nonce_field' ); ?>

			</form>

		</div>

	</div>	

<?php	

}



 

/*

 * Map settings Update process

 * @since     1.0.0

 * @access    public

 * @param     -     -     -

 * @return    String HTML

 */

function jsps_map_manage_settings_update( $post_values ) {



	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();

		  

	global $wpdb;

	$table_name = $wpdb->prefix . 'jsps_map_setting';



	$wpdb->query("delete from ".$table_name);





	$setting_insert = $wpdb->insert($table_name,

							 array( 

							   'map_setting_id'=>'',

							   'loc_info_page'=>$post_values['jsps_location_info_page'],

							   'map_api_key'=>$post_values['setting_map_api']

							  )

						);

	if($setting_insert == 1 || wp_verify_nonce( $_POST['jsps_map_settings_nonce_field'], 'jsps_map_settings_nonce_action' )){

				return 'Settings has been successfully updated';

	}

	else{

		return 'Setting update failed';

	}

}





