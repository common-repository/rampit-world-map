<?php

/*

Plugin Name: Rampit World Map

Plugin URI: http://www.rampit.in/rampit-world-map/world-map-demo-page/

Description:  Rampit Map Plugin. Eazy to customize Map view, Manage locations with all inforamtion under different categories.

Version: 0.1.2

Author: RAMPiT

Author URI: http://www.rampit.in/

Text Domain: rampit-world-map

Domain Path: /languages

*/



// If this file is called directly, abort.  

if ( ! defined( 'ABSPATH' ) ) exit; 

  

  

/*

 *  Admin hooks init, active, default template values and uninstall

 */ 

 require_once plugin_dir_path(__FILE__).'admin/jsps_file_initialisation.php';

 require_once plugin_dir_path(__FILE__).'include/jsps_custom_validation.php'; // all custom validation functions

 

 register_activation_hook(__FILE__,'jsps_create_tables');                              

 register_activation_hook(__FILE__,'jsps_create_tables_template_values'); 

 

/*

 *  Admin all masters

 */

  if( is_admin() ) {

     //we are in admin mode

     require_once plugin_dir_path(__FILE__ ).'admin/jsps_masters.php';

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_markers_masters.php'; // All masters to manage Markers

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_category_masters.php'; // All masters to manage Categories

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_location_masters.php'; // All masters to manage Locations

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_map_masters.php'; // All masters to manage Maps  

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_template_masters.php'; // All masters to manage Templates/Map Style

     require_once plugin_dir_path(__FILE__ ).'admin/includes/jsps_settings_masters.php'; // All masters to manage Templates/Map Style

  }

 

 

/*

 *  public shotcode creation for map display dynamically

 */ 

 require_once plugin_dir_path(__FILE__).'public/jsps_short_code_user_end.php';





/*

 *  Plugin deactivation hook

 */ 

register_uninstall_hook(__FILE__, 'jsps_map_uninstall_clean_DB');

