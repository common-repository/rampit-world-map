<?php 

/*

 * Jsps admin plugin activation, template default value and uninstall

 * @link      

 * @since      1.0.0

 * @package    RAMPiT World Map

 * @subpackage RAMPiT World Map/admin

 * @author     RAMPiT

 */



if ( ! defined( 'ABSPATH' ) ) exit;



/**

 * Create and display all Main and Sub Menu

 * @since 1.0.0

 * @param '' 

 * @return '' 

 */



function jsps_map_menu(){

	 /* Allow to access this plugin only for admin */

	if(current_user_can('administrator')) {        

		add_menu_page('World Map', 'World Map', 'manage_options', 'rampit_world_map', 'jsps_map_dashboard' );        

		add_submenu_page('rampit_world_map', 'Dashboard', 'Dashboard', 'manage_options', 'rampit_world_map','jsps_map_dashboard');

		add_submenu_page('rampit_world_map', 'Add marker', 'Add marker', 'manage_options', 'jsps_addmarker', 'jsps_add_marker' );        

		add_submenu_page('rampit_world_map', 'Add category', 'Add category', 'manage_options', 'jsps_addcategory', 'jsps_create_category' );

		add_submenu_page('rampit_world_map', 'Manage category', 'Manage category', 'manage_options', 'jsps_managecategory', 'jsps_catogery_manage' );

		add_submenu_page('rampit_world_map', 'Add Location', 'Add Location', 'manage_options', 'jsps_addlocation', 'jsps_location_form' );

		add_submenu_page('rampit_world_map', 'Manage Location', 'Manage Location', 'manage_options', 'jsps_managelocation', 'jsps_location_manage_form' );                

		add_submenu_page('rampit_world_map', 'Add Map', 'Add Map', 'manage_options', 'jsps_addmap', 'jsps_addmap' );

		add_submenu_page('rampit_world_map', 'Manage Map', 'Manage Map', 'manage_options', 'jsps_managemap', 'jsps_map_manage_form' );    	

		add_submenu_page('rampit_world_map', 'Add Template', 'Add Template', 'manage_options', 'jsps_setting', 'jsps_setings_form' );

		add_submenu_page('rampit_world_map', 'Manage template', 'Manage template', 'manage_options', 'jsps_managetemplate', 'jsps_template_manage_form' );

		add_submenu_page('rampit_world_map', 'Settings', 'Settings', 'manage_options', 'jsps_mapsetting', 'jsps_map_manage_settings' );

	}

}



 

 /*

  * Its plugin first step. Add menu in admin  

  */

  add_action('admin_menu', 'jsps_map_menu');

 

 



/**

 * Create table while activating Google World Map

 * @since 1.0.0

 * @param '' 

 * @return '' 

 */ 



function jsps_create_tables() {

	global $wpdb;

	$jsps_locations = $wpdb->prefix . 'jsps_locations';

	$jsps_category = $wpdb->prefix . 'jsps_category';

	$jsps_category_detail_location = $wpdb->prefix . 'jsps_category_detail_location';

	$jsps_settings = $wpdb->prefix . 'jsps_settings';

	$jsps_map = $wpdb->prefix . 'jsps_map';

	$jsps_marker = $wpdb->prefix . 'jsps_marker';

	$jsps_template_skin = $wpdb->prefix . 'jsps_template_skin';

	$jsps_map_setting = $wpdb->prefix . 'jsps_map_setting';

	 

	//Create table jsps_locations 

	if($wpdb->get_var("show tables like " .$jsps_locations) != $jsps_locations) 

	{

		$locations = "CREATE TABLE " . $jsps_locations ."( location_id INT(5) NOT NULL AUTO_INCREMENT, Location_title VARCHAR(100) NOT NULL, Location_address VARCHAR(200),  Latitude VARCHAR(30) NOT NULL, Longitude VARCHAR(30) NOT NULL, Location_description TEXT, Location_clink VARCHAR(250), Location_phone VARCHAR(15), Location_email VARCHAR(50), Location_image VARCHAR(300), Location_popup_default INT(1), Location_default_marker	VARCHAR(200), Location_marker VARCHAR(100), Location_enable VARCHAR(1), location_last_updated timestamp, UNIQUE KEY location_id (location_id));";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($locations);

	}



	//Create table jsps_category 

	 if($wpdb->get_var("show tables like " .$jsps_category) != $jsps_category) 

	{

		$category = "CREATE TABLE ". $jsps_category ."( Category_id INT(5) primary KEY AUTO_INCREMENT, Category_title VARCHAR(100) NOT NULL, Category_locationid VARCHAR(100), Category_marker INT(3), Category_default_marker TEXT, category_last_updated timestamp );";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($category);

	}





	//Create table jsps_category_detail_location

	if($wpdb->get_var("show tables like " .$jsps_category_detail_location) != $jsps_category_detail_location) 

	{

		$addmap = "CREATE TABLE ". $jsps_category_detail_location ."( category_detail_id INT(5) primary KEY AUTO_INCREMENT, detail_location_id INT(5), detail_category_id INT(5), detail_marker_id INT(3));";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($addmap);

	}



	//Create table jsps_settings 	

	if($wpdb->get_var("show tables like " .$jsps_settings) != $jsps_settings) 

	{

		$settings = "CREATE TABLE ". $jsps_settings ."( Setting_id INT(5) primary KEY AUTO_INCREMENT, template_title VARCHAR(100), Zoom_level INT(2) NOT NULL, Center_latitude VARCHAR(20) NOT NULL, Center_longitude VARCHAR(20) NOT NULL, width VARCHAR(20), height VARCHAR(20), template_fullwindow INT(2), template_fixedheight	VARCHAR(10), background VARCHAR(20), maptypeid VARCHAR(15), Zoom_control INT(1),Maptype_control INT(1),Scale_control INT(1), scroll_wheel INT(2), det_map_width VARCHAR(15), det_map_height VARCHAR(15), temp_layout VARCHAR(3), search_form_show INT(2), search_form_position	INT(2), list_form_show INT(2), list_form_position INT(2), category_filter_show	INT(2), category_filter_position INT(2), last_updated timestamp );";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($settings);

		

	}



	//Create table jsps_map 

	if($wpdb->get_var("show tables like " .$jsps_map) != $jsps_map) 

	{

		$addmap = "CREATE TABLE ". $jsps_map ."( map_id INT(5) primary KEY AUTO_INCREMENT, Map_title VARCHAR(100) NOT NULL, Category VARCHAR(500), template_id	INT(11), map_last_updated timestamp );";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($addmap);

	}



	//Create table jsps_marker

	if($wpdb->get_var("show tables like " .$jsps_marker) != $jsps_marker) 

	{

		$addmarker = "CREATE TABLE ". $jsps_marker ."( marker_id INT(11) primary KEY AUTO_INCREMENT, Marker_title VARCHAR(200), Marker_image VARCHAR(200), marker_last_updated timestamp );";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($addmarker);

	}



	//Create table jsps_template_skin

	if($wpdb->get_var("show tables like " .$jsps_template_skin) != $jsps_template_skin) 

	{

		$add_template_skin = "CREATE TABLE ". $jsps_template_skin ."( template_skin_id INT(10) primary KEY AUTO_INCREMENT, template_id INT(10) NOT NULL, feature_type VARCHAR(100), feature_type_property VARCHAR(100), color VARCHAR(20), visibility VARCHAR(20), 	lightness VARCHAR(15), hue varchar(15), saturation VARCHAR(15));";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($add_template_skin);

	}



	//Create table map settings

	if($wpdb->get_var("show tables like " .$jsps_map_setting) != $jsps_map_setting) 

	{   

		$add_map_sett = "CREATE TABLE ". $jsps_map_setting ."( map_setting_id INT(5) primary KEY AUTO_INCREMENT, loc_info_page INT(5), map_api_key VARCHAR(200));";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($add_map_sett);

	}

	//Create Jsps map location information  page on activating plugin

	$Location_info_title = 'Jsps map location information';

	$Location_info_content = '[jsps_location_info]  [/jsps_location_info]';



	$Location_info_page_check = get_page_by_title($Location_info_title);

	$customer_review_page = array(

			'post_title' => $Location_info_title,

			'post_content' => $Location_info_content,

			'post_type' => 'page',

			'post_status' => 'publish',

			'post_author' => 1,

			'post_date' => date('Y-m-d H:i:s'),

			'comment_status' => 'closed'

	);



	$new_location_info_page_id="";

	//$decoded_api_key = base64_encode('AIzaSyAzXoaC9OV09c-sTdIWWR1hWzUcJppx_g8');





	if(!isset($Location_info_page_check->ID)){

			

		//$wpdb->query("TRUNCATE TABLE " .$jsps_map_setting);

			

		$new_location_info_page_id = wp_insert_post($customer_review_page);

		update_option( 'jsps_map_location_info', $new_location_info_page_id );

		$wpdb->query("INSERT INTO ".$jsps_map_setting . " (loc_info_page,map_api_key) values (".$new_location_info_page_id.",'".$decoded_api_key."'); ");

	}

	else {

				

		//$wpdb->query("TRUNCATE TABLE " .$jsps_map_setting);

				  

		update_option( 'jsps_map_location_info', $Location_info_page_check->ID );

		$wpdb->query("INSERT INTO ".$jsps_map_setting . " (loc_info_page,map_api_key) values (".$Location_info_page_check->ID.",'".$decoded_api_key."'); ");

	}

}



function jsps_js_include() {

	$api_key_map_set = jsps_map_get_map_api_key();



	//if(!$api_key_map_set){

	//	$api_key_map_set ='AIzaSyAzXoaC9OV09c-sTdIWWR1hWzUcJppx_g8';

	//}

	//Rand string to remove the cache instead of plugin version 

	$jsps_rand_str = rand(9999999,100000000);



	wp_enqueue_style('jsps_map_styles', plugins_url( '../css/jsps_map_style.css?'.$jsps_rand_str, __FILE__ ));

	wp_enqueue_style('jsps_map_admin_style', plugins_url( 'css/jsps-google-world-admin.css?'.$jsps_rand_str, __FILE__ ));

	wp_enqueue_script('jsps_map_scripts', plugins_url( '../js/jsps_map_script.js', __FILE__ ),array(), '1.0', true);

    wp_enqueue_script('map_google', '//maps.googleapis.com/maps/api/js?key='.$api_key_map_set.'&libraries=places', array(), '1.0', null);

}

add_action('init','jsps_js_include',0);



/**

 * Get MAP API key details from database.

 * @since 1.0.0

 * @param '' 

 * @return string 

 */ 



function jsps_map_get_map_api_key(){            

	global $wpdb;

	$table_name = $wpdb->prefix . 'jsps_map_setting';



	$map_key = $wpdb->get_results('SELECT * FROM '.$table_name);

	foreach ( $map_key as $result ){

		 $sett_map_api_key = $result->map_api_key;

	}

	return $sett_map_api_key;

}





/**

 * Default template values insert

 * @since 1.0.0

 * @param '' 

 * @return ''

 */ 



function jsps_create_tables_template_values() {

	global $wpdb;

	$jsps_settings = $wpdb->prefix . 'jsps_settings';

	$jsps_template_skin = $wpdb->prefix . 'jsps_template_skin';



	$wpdb->query("INSERT INTO ".$jsps_settings." (Setting_id, template_title, Zoom_level, Center_latitude, Center_longitude, width, height, template_fullwindow, template_fixedheight, background, Zoom_control, Maptype_control, Scale_control, scroll_wheel, temp_layout, search_form_show, search_form_position, list_form_show, list_form_position, category_filter_show, category_filter_position) VALUES

	(1, 'Template 1', 5, '34.83751', '-106.2371', '800px', '650px', '', '', '99999', 1, 1, 1, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(2, 'Template 2', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 1, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(3, 'Template 3', 5, '34.83751', '-106.2371', '800px', '500px', '', '', '99999', 0, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(4, 'Template 4', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(5, 'Template 5', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 0, 0, 0, 'L4', 1, 1, 1, 3, 1, 2),





	(6, 'Template 6', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 0, 0, 0, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(7, 'Template 7', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 0, 0, 1, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(8, 'Template 8', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 0, 0, 0, 0, 'L4', 1, 1, 1, 3, 1, 2),

	(9, 'Template 9', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(10, 'Template 10', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(11, 'Template 11', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(12, 'Template 12', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(13, 'Template 13', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),

	(14, 'Template 14', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L4', 1, 1, 1, 3, 1, 2),        

	(15, 'Template 15', 5, '34.83751', '-106.2371', '800px', '600px', '', '', '99999', 1, 1, 0, 1, 'L1', 0, 0, 0, 0, 0, 0); ");



	$wpdb->query("INSERT INTO  ".$jsps_template_skin." (template_id, feature_type, feature_type_property, color, visibility, lightness, hue, saturation) VALUES

	( 7, 'all', '', '', '1', '', '', '-80'),

	( 7, 'road.arterial', 'geometry', '', '1', '', '#00ffee', '50'),

	( 7, 'poi.business', 'labels', '', '2', '', '', ''),

	( 9, 'water', 'geometry', '#46BCEC', '3', '', '', ''),

	( 9, 'landscape', 'geometry', '#e9e9e9', '1', '', '', ''),

	( 9, 'road.highway', 'geometry', '#C0C0C0', '1', '', '', ''),

	( 9, 'road.arterial', 'geometry', '#ffffff', '1', '', '', ''),

	( 9, 'road.local', 'geometry', '#ffffff', '1', '', '', ''),

	( 9, 'poi', 'all', '', '2', '', '', ''),

	( 10, 'water', 'geometry', '#46BCEC', '3', '-10', '', ''),

	( 10, 'landscape', 'geometry', '#e9e9e9', '1', '-10', '', ''),

	( 10, 'road.highway', 'geometry', '#C0C0C0', '1', '', '', ''),

	( 10, 'road.arterial', 'geometry', '#ffffff', '1', '', '', ''),

	( 10, 'road.local', 'geometry', '#ffffff', '1', '', '', ''),

	( 10, 'poi.park', 'all', '#E9E9E9', '2', '', '', ''),

	( 10, '', '', '', '', '-50', '', '-50'),

	( 11, 'water', 'geometry', '#46BCEC', '1', '', '', ''),

	( 11, 'landscape', 'geometry', '#e9e9e9', '1', '', '', ''),

	( 11, 'road.highway', 'geometry', '#C0C0C0', '1', '', '', ''),

	( 11, 'road.arterial', 'geometry', '#ffffff', '1', '', '', ''),

	( 11, 'road.local', 'geometry', '#ffffff', '1', '', '', ''),

	( 11, 'poi', 'all', '', '2', '', '', ''),

	( 11, '', '', '', '1', '-50', '', ''),

	( 11, 'administrative', 'labels.text.fill', '#ffffff', '1', '', '', ''),

	( 12, 'water', 'geometry', '#5E4B00', '1', '', '', ''),

	( 12, 'landscape', 'geometry', '#423E2F', '1', '', '', ''),

	( 12, 'administrative', 'labels.text.fill', '#ffffff', '1', '', '', ''),

	( 12, 'road.highway', 'geometry', '#EBC008', '1', '', '', ''),

	( 12, 'poi', 'all', '', '2', '', '', ''),

	( 12, 'road.local', 'geometry', '#1C1C1C', '1', '', '', ''),

	( 13, 'water', 'geometry', '#ffffff', '1', '', '', ''),

	( 13, 'landscape', 'geometry', '#4E4E4E', '1', '', '', ''),

	( 13, 'poi', 'all', '', '2', '', '', ''),

	( 8, 'road', 'geometry', '', '3', '100', '', ''),

	( 8, 'road', 'labels', '', '2', '', '', ''),

	( 8, '', '', '', '', '', '#00ffe6', '-20'),

	( 6, 'water', 'geometry', '#BBF8F2', '1', '', '', ''),

	( 6, 'landscape', 'geometry', '#DEE8E7', '1', '', '', ''),

	( 6, 'road.highway', 'geometry', '#ffffff', '1', '', '', ''),

	( 6, 'road.local', 'geometry', '#ffffff', '1', '', '', ''),

	( 6, 'administrative', 'labels.text.fill', '#306B63', '1', '', '', ''),

	( 6, 'poi', 'all', '#CBE2DF', '1', '', '', ''),

	( 14, 'water', 'geometry', '#46D4BD', '1', '', '', ''),

	( 14, 'landscape', 'geometry', '#F2F2F2', '1', '', '', ''),

	( 14, 'poi', 'all', '', '2', '', '', ''),

	( 14, 'road.highway', 'geometry', '#C0C0C0', '1', '', '', ''),

	( 14, 'road.local', 'geometry', '#C0C0C0', '1', '', '', ''),

	( 15, 'administrative', 'geometry.fill', '#ddd', '1', '', '', ''),

	( 15, 'water', 'geometry', '#A0CEE2', '1', '', '', ''),

	( 15, 'poi.park', 'geometry', '#E0EA8C', '1', '', '', ''),



			

	( 1, 'all', 'geometry', '#ebe3cd', '1', '', '', ''),

	( 1, 'all', 'labels.text.fill', '#523735', '1', '', '', ''),

	( 1, 'all', 'labels.text.stroke', '#f5f1e6', '1', '', '', ''),

	( 1, 'administrative', 'geometry.stroke', '#c9b2a6', '1', '', '', ''),

	( 1, 'administrative.land_parcel', 'geometry.stroke', '#dcd2be', '1', '', '', ''),

	( 1, 'administrative.land_parcel', 'labels.text.fill', '#ae9e90', '1', '', '', ''),

	( 1, 'landscape.natural', 'geometry', '#dfd2ae', '1', '', '', ''),

	( 1, 'poi', 'geometry', '#dfd2ae', '1', '', '', ''),

	( 1, 'poi', 'labels.text.fill', '#93817c', '1', '', '', ''),

	( 1, 'poi.park', 'geometry.fill', '#a5b076', '1', '', '', ''),

	( 1, 'poi.park', 'labels.text.fill', '#447530', '1', '', '', ''),

	( 1, 'road', 'geometry', '#f5f1e6c', '1', '', '', ''),

	( 1, 'road.arterial', 'geometry', '#fdfcf8', '1', '', '', ''),

	( 1, 'road.highway', 'geometry', '#f8c967', '1', '', '', ''),

	( 1, 'road.highway', 'geometry.stroke', '#e9bc62', '1', '', '', ''),

	( 1, 'road.highway.controlled_access', 'geometry', '#e98d58', '1', '', '', ''),

	( 1, 'road.highway.controlled_access', 'geometry.stroke', '#db8555', '1', '', '', ''),

	( 1, 'road.local', 'labels.text.fill', '#806b63', '1', '', '', ''),

	( 1, 'transit.line', 'geometry', '#dfd2ae', '1', '', '', ''),

	( 1, 'transit.line', 'labels.text.fill', '#8f7d77', '1', '', '', ''), 

	( 1, 'transit.line', 'labels.text.stroke', '#ebe3cd', '1', '', '', ''),

	( 1, 'transit.station', 'geometry', '#dfd2ae', '1', '', '', ''),

	( 1, 'water', 'geometry.fill', '#b9d3c2', '1', '', '', ''),

	( 1, 'water', 'labels.text.fill', '#92998d', '1', '', '', ''),





	( 2, 'all', 'geometry', '#f5f5f5', '1', '', '', ''),

	( 2, 'all', 'labels.icon', '', '0', '', '', ''),

	( 2, 'all', 'labels.text.fill', '#616161', '1', '', '', ''),

	( 2, 'all', 'labels.text.stroke', '#f5f5f5', '1', '', '', ''),

	( 2, 'administrative.land_parcel', 'labels.text.fill', '#bdbdbd', '1', '', '', ''),

	( 2, 'poi', 'geometry', '#eeeeee', '1', '', '', ''),

	( 2, 'poi', 'labels.text.fill', '#757575', '1', '', '', ''),

	( 2, 'poi.park', 'geometry', '#e5e5e5', '1', '', '', ''),

	( 2, 'poi.park', 'labels.text.fill', '#9e9e9e', '1', '', '', ''),

	( 2, 'road', 'geometry', '#ffffff', '1', '', '', ''),

	( 2, 'road.arterial', 'labels.text.fill', '#757575', '1', '', '', ''),

	( 2, 'road.highway', 'geometry', '#dadada', '1', '', '', ''),

	( 2, 'road.highway', 'labels.text.fill', '#616161', '1', '', '', ''),

	( 2, 'road.local', 'labels.text.fill', '#9e9e9e', '1', '', '', ''),

	( 2, 'transit.line', 'geometry', '#e5e5e5', '1', '', '', ''),

	( 2, 'transit.station', 'geometry', '#eeeeee', '1', '', '', ''),

	( 2, 'water', 'geometry', '#c9c9c9', '1', '', '', ''),

	( 2, 'water', 'labels.text.fill', '#9e9e9e', '1', '', '', ''),









	( 3, 'all', 'geometry', '#212121', '1', '', '', ''),

	( 3, 'all', 'labels.icon', '', '0', '', '', ''),

	( 3, 'all', 'labels.text.fill', '#757575', '1', '', '', ''),

	( 3, 'all', 'labels.text.stroke', '#212121', '1', '', '', ''),

	( 3, 'administrative', 'geometry', '#757575', '1', '', '', ''),

	( 3, 'administrative.country', 'labels.text.fill', '#9e9e9e', '1', '', '', ''),

	( 3, 'administrative.land_parcel', '', '', '0', '', '', ''),

	( 3, 'administrative.locality', 'labels.text.fill', '#bdbdbd', '1', '', '', ''),

	( 3, 'poi', 'labels.text.fill', '#757575', '1', '', '', ''),

	( 3, 'poi.park', 'geometry', '#181818', '1', '', '', ''),

	( 3, 'poi.park', 'labels.text.fill', '#616161', '1', '', '', ''),

	( 3, 'poi.park', 'labels.text.stroke', '#1b1b1b', '1', '', '', ''),

	( 3, 'road', 'geometry.fill', '#2c2c2c', '1', '', '', ''),

	( 3, 'road', 'labels.text.fill', '#8a8a8a', '1', '', '', ''),

	( 3, 'road.arterial', 'geometry', '#373737', '1', '', '', ''),

	( 3, 'road.highway', 'geometry', '#3c3c3c', '1', '', '', ''),

	( 3, 'road.highway.controlled_access', 'geometry', '#4e4e4e', '1', '', '', ''),

	( 3, 'road.local', 'labels.text.fill', '#616161', '1', '', '', ''),

	( 3, 'transit', 'labels.text.fill', '#757575', '1', '', '', ''),

	( 3, 'water', 'geometry', '#000000', '1', '', '', ''),

	( 3, 'water', 'labels.text.fill', '#3d3d3d', '1', '', '', ''),





	( 4, 'all', 'geometry', '#242f3e', '1', '', '', ''),

	( 4, 'all', 'labels.text.fill', '#746855', '1', '', '', ''),

	( 4, 'all', 'labels.text.stroke', '#242f3e', '1', '', '', ''),

	( 4, 'administrative.locality', 'labels.text.fill', '#d59563', '1', '', '', ''),

	( 4, 'poi', 'labels.text.fill', '#d59563', '1', '', '', ''),

	( 4, 'poi.park', 'geometry', '#263c3f', '1', '', '', ''),

	( 4, 'poi.park', 'labels.text.fill', '#6b9a76', '1', '', '', ''),

	( 4, 'road', 'geometry', '#38414e', '1', '', '', ''),

	( 4, 'road', 'geometry.stroke', '#212a37', '1', '', '', ''),

	( 4, 'road', 'labels.text.fill', '#9ca5b3', '1', '', '', ''),

	( 4, 'road.highway', 'geometry', '#746855', '1', '', '', ''),

	( 4, 'road.highway', 'geometry.stroke', '#1f2835', '1', '', '', ''),

	( 4, 'road.highway', 'labels.text.fill', '#f3d19c', '1', '', '', ''),

	( 4, 'transit', 'geometry', '#2f3948', '1', '', '', ''),

	( 4, 'transit.station', 'labels.text.fill', '#d59563', '1', '', '', ''),

	( 4, 'water', 'geometry', '#17263c', '1', '', '', ''),

	( 4, 'water', 'labels.text.fill', '#515c6d', '1', '', '', ''),

	( 4, 'water', 'labels.text.stroke', '#17263c', '1', '', '', ''),







	( 5, 'all', 'geometry', '#1d2c4d', '1', '', '', ''),

	( 5, 'all', 'labels.text.fill', '#8ec3b9', '1', '', '', ''),

	( 5, 'all', 'labels.text.stroke', '#1a3646', '1', '', '', ''),

	( 5, 'administrative.country', 'geometry.stroke', '#4b6878', '1', '', '', ''),

	( 5, 'administrative.land_parcel', 'labels.text.fill', '#64779e', '1', '', '', ''),

	( 5, 'administrative.province', 'geometry.stroke', '#4b6878', '1', '', '', ''),

	( 5, 'landscape.man_made', 'geometry.stroke', '#334e87', '1', '', '', ''),

	( 5, 'landscape.natural', 'geometry', '#023e58', '1', '', '', ''),

	( 5, 'poi', 'geometry', '#283d6a', '1', '', '', ''),

	( 5, 'poi', 'labels.text.fill', '#6f9ba5', '1', '', '', ''),

	( 5, 'poi', 'labels.text.stroke', '#1d2c4d', '1', '', '', ''),

	( 5, 'poi.park', 'geometry.fill', '#023e58', '1', '', '', ''),

	( 5, 'poi.park', 'labels.text.fill', '#3C7680', '1', '', '', ''),

	( 5, 'road', 'geometry', '#304a7d', '1', '', '', ''),

	( 5, 'road', 'labels.text.fill', '#98a5be', '1', '', '', ''),

	( 5, 'road', 'labels.text.stroke', '#1d2c4d', '1', '', '', ''),

	( 5, 'road.highway', 'geometry', '#2c6675', '1', '', '', ''),

	( 5, 'road.highway', 'geometry.stroke', '#255763', '1', '', '', ''),

	( 5, 'road.highway', 'labels.text.fill', '#b0d5ce', '1', '', '', ''),

	( 5, 'road.highway', 'labels.text.stroke', '#023e58', '1', '', '', ''),

	( 5, 'transit', 'labels.text.fill', '#98a5be', '1', '', '', ''),

	( 5, 'transit', 'labels.text.stroke', '#1d2c4d', '1', '', '', ''),

	( 5, 'transit.line', 'geometry.fill', '#283d6a', '1', '', '', ''),

	( 5, 'transit.station', 'geometry', '#3a4762', '1', '', '', ''),

	( 5, 'water', 'geometry', '#0e1626', '1', '', '', ''),

	( 5, 'water', 'labels.text.fill', '#4e6d70', '1', '', '', '');");

}





/**

 * uninstall database files in jsps map

 * @since 1.0.0

 * @param '' 

 * @return ''

 */ 



function jsps_map_uninstall_clean_DB() {

	global $wpdb;

	$jsps_table_array = array('jsps_locations','jsps_map','jsps_category','jsps_marker','jsps_settings','jsps_template_skin','jsps_category_detail_location','jsps_map_setting');

	foreach ($jsps_table_array as $table_delete){

		$table_name = $wpdb->prefix .$table_delete;

		$sql_table_delete = "DROP TABLE IF EXISTS ".$table_name;

		$wpdb->query($sql_table_delete);

	}



	$option_name = 'jsps_map_location_info';

	delete_option( $option_name );      

}

