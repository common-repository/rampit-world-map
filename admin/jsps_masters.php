<?php

/*

 * Jsps Master Pages

 * @link      

 * @since      1.0.0

 * @package    RAMPiT World Map

 * @subpackage RAMPiT World Map/admin

 * @author     RAMPiT

 */

 

// If this file is called directly, abort.

if ( ! defined( 'ABSPATH' ) ) exit;

  

/**

 * Map Plugin Dashboard

 * @since 1.0.0

 * @param '' 

 * @return String(HTML) 

 */  



function jsps_map_dashboard() {



	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();            

?>

	<div class="dashboard">

		<header>

			<div id="plugin_header" class="plugin_bg">        	

				<div class="jsps_dashboard_title">				

					<span class="plugin_heading">RAMPiT World Map</span>                            

					<span class="plugin_subheading">Troubleshooting and Pro Support</span>

				</div>

			</div>

		</header>

		<div class="jsps_map_wrap ">        				

			<!-- Pulgin Form START -->                       

				<ul>

					<li><h2>Troubleshooting<br />----------------------------</h2></li>

					<li>1. Activate Default Theme and check it.</li>

					<li>2. If some click and hover option not working, please include the jQuery. Because, you theme not used Jquery.</li>

					<li>3. Deactivate all other plugins and test it.</li>

					<li>4. <strong>Ask your developer to check it.</strong></li>

					<li>5. Delete and re-install the plugin and test it. <span style="color: red;">(You will lost all admin changes from this plugin)</span></li>                                

				</ul>                             

					<span class="jsps_devider"> (OR)</span> 

				<ul class="pro_support">

					<li><h2>Pro Support<br />----------------------------</h2></li>

					<li>Please contact Pro support team for any needs. We are always available to support you. And also, ready to do any features based on your needs.</li>                               

				</ul>

				<a target="_blank" class="support_button" href="http://www.rampit.in/rampit-world-map/documents/documents.php#!/section_9">Contact Pro Support Team</a>	

				<div id="mail_info"><div></div></div>

		<!-- Pulgin Form END -->

		</div>

		<footer>

			<div id="plugin_footer" class="plugin_bg">

				<span class="footer_heading">By Support Team</span>

			</div>

		</footer>

	</div>

<?php

}

 

/*

 * List all default markders

 * @since     1.0.0

 * @access    public

 * @param     -     -     -

 * @return    String HTML

 */

function jsps_default_marker() {

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();

	$default_icon = plugins_url( 'images/marker_default_icons', dirname(__FILE__) );

	?>

	<div>

	   <select name="default_marker" id="default_marker" >

			<option value="" selected>------select------</option>

			<option value="<?php echo $default_icon ?>/bus.png">Bus</option>

			<option value="<?php echo $default_icon ?>/cabs.png">Cabs</option>

			<option value="<?php echo $default_icon ?>/camera.png">Camera</option>

			<option value="<?php echo $default_icon ?>/gas.png">Gas</option>

			<option value="<?php echo $default_icon ?>/helicopter.png">Helicopter</option>

			<option value="<?php echo $default_icon ?>/hospitals.png">Hospitals</option>   

			<option value="<?php echo $default_icon ?>/man.png">Man</option>

			<option value="<?php echo $default_icon ?>/motorcycling.png">Motorcycling</option>

			<option value="<?php echo $default_icon ?>/movies.png">Movies</option>   

			<option value="<?php echo $default_icon ?>/plane.png">Plane</option>

			<option value="<?php echo $default_icon ?>/police.png">Police</option>

			<option value="<?php echo $default_icon ?>/rail.png">Rail</option>

			<option value="<?php echo $default_icon ?>/recycle.png">Recycle</option>

			<option value="<?php echo $default_icon ?>/restaurant.png">Restaurant</option>

			<option value="<?php echo $default_icon ?>/subway.png">Subway</option>  

			<option value="<?php echo $default_icon ?>/swimming.png">Swimming</option>

			<option value="<?php echo $default_icon ?>/toilets.png">Toilets</option>

			<option value="<?php echo $default_icon ?>/truck.png">Truck</option>

			<option value="<?php echo $default_icon ?>/water.png">Water</option>

			<option value="<?php echo $default_icon ?>/woman.png">Woman</option>

		</select>

	</div>

<?php	  

}



/*

 * Check the file access

 * @since     1.0.0

 * @access    public

 * @param     -     -     -

 * @return    String HTML

 */



function jsps_map_user_rights_access(){        

	if(!current_user_can('administrator')) {

		wp_die( __('<div class="jsps_map_access_msg"><span class="jsps_map_warning_img"></span><span class="jsps_map_warning_msg">Only administrator can access this part of the plugin</span></div>') );

	}

}



  

/*

 * upload change directory

 * @since     1.0.0

 * @access    public

 * @param     $dirs String folder path

 * @return    String String folder path

 */

 

function jsps_upload_dir( $dirs ) {

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();

		   

	$dirs['subdir'] = '/plugin_upload';

	$dirs['path'] = $dirs['basedir'] . '/plugin_upload';

	$dirs['url'] = $dirs['baseurl'] . '/plugin_upload';



	return $dirs;

}



/*

 * Common upload image function

 * @since     1.0.0

 * @access    public

 * @param     $filename String File name

 * @return    String

 */



function jsps_common_upload_image($filename) {  

		

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();



	// wp_handle_upload support  file	

	if(!function_exists( 'wp_handle_upload' ) ) {

		require_once( ABSPATH . 'wp-admin/includes/file.php' );

	}

	if(!function_exists('wp_get_current_user')) {

		include(ABSPATH . "wp-includes/pluggable.php"); 

	}



	$uploadedfile = $filename;

	if($uploadedfile['size']){

		$support_type = array('png','jpg','jpeg');	

		$type = pathinfo($uploadedfile['name'], PATHINFO_EXTENSION);



		if(in_array($type,$support_type))

		{      

			  $upload_overrides = array( 'test_form' => false );

			  add_filter( 'upload_dir', 'jsps_upload_dir' ); // change upload directory

			  $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

			  remove_filter( 'upload_dir', 'jsps_upload_dir' ); // change upload directory

			 

			 return $movefile['url'];

		}

		else{

		   return 'file_type_error';  

		}

	}  

}



/*

 * Common implode function

 * @since     1.0.0

 * @access    public

 * @param     $args array to implode

 * @return    String

 */



function jsps_common_implode($args) {

	

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();        



	$implode_arr = $args;

	$imploded = "";



	if(is_array($implode_arr)){

		foreach($implode_arr as $val)

		{

			$imploded.= $val.',';

		}

	}



	$imploded_value = rtrim($imploded,',');

	return $imploded_value;

}



 

 /*

 * Location import function

 * @since     1.0.0

 * @access    public

 * @param     $filename Import file name

 * @return    String

 */

function jsps_import_location($filename) {

	/*Check logged in user access privilege */ 

	jsps_map_user_rights_access();        



	$import_location = $filename;

	$file_type = pathinfo($import_location['name'], PATHINFO_EXTENSION);

	$support_type = array('csv');



	global $wpdb;

	$jsps_locations = $wpdb->prefix . 'jsps_locations';



	if($import_location['size']){

	 if(in_array($file_type,$support_type))

	   {

		   $file_name = $import_location['tmp_name'];

		   if (($getfile = fopen($file_name, "r")) !== FALSE) {

			   //$count = 0;

			   while (($data = fgetcsv($getfile)) !== FALSE) {

				   $count++;

				   if($count>1){

					   $im_location_title = sanitize_text_field($data[0]);

					   $im_location_addr = sanitize_text_field($data[1]);

					   $im_location_lat = sanitize_text_field($data[2]);

					   $im_location_long = sanitize_text_field($data[3]);

					   $im_location_desc = sanitize_text_field($data[4]);

					   $im_location_phone =sanitize_text_field($data[5]);

					   $im_location_email = sanitize_email($data[6]);

					   $import_result =  $wpdb->query("INSERT INTO  ".$jsps_locations." (location_id, Location_title, Location_address, Latitude, Longitude, Location_description, Location_phone, Location_email, Location_image, Location_popup_default, Location_marker, Location_enable) VALUES

														('','".$im_location_title."','".$im_location_addr."','".$im_location_lat."','".$im_location_long."','".$im_location_desc."','".$im_location_phone."','".$im_location_email."','',1,'','Y') ");

				   }

			   }

			   if($import_result > 0){

				   return "Locations have been added";

			   }

			   else{

				   return $wpdb->last_error;

			   }

		   }  

	   }

	   else{

		   return  "Invalid file format only CSV file formate is valid";

	   }

	}	

}



