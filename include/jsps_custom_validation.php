<?php 
/*
 * All custom validation functions
 * @link      
 * @since      1.0.0
 * @package    Google World Map
 * @subpackage Goolge World Map/admin
 * @author     RAMPiT
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check the array variable value is empry or not.
 * @since 1.0.0
 * @param @array - all required fields array 
 * @return string(True / false)
 */
function check_val_notempty($all_required_fields) {
    
    /*Check logged in user access privilege */ 
	jsps_map_user_rights_access();
    
    //echo "<pre>";
    //print_r($all_required_fields);
    
    foreach($all_required_fields  as $field_name => $field_value) {
        $field_value = trim($field_value);
        if( !isset($field_value) ){
            return false;
        } else if( empty($field_value) ){
            return false;
        }
    }
    
    return true; // If all fields exist, this function will return true        
}
    

/**
 * Check the array variable all are have valied images 
 * @since 1.0.0
 * @param @array - all array fields with uploaded files
 * @return string(True / false)
 */ 
function check_val_isfile($all_image_files) {
    
    /*Check logged in user access privilege */ 
	jsps_map_user_rights_access();                

    foreach($all_image_files  as $field_name => $field_value) {
            if( isset($field_value['size']) ) {
                if( $field_value['size'] <= 0 ) {
                    return false;   
                }
            } else if( !isset($field_value['tmp_name']) ) {                    
                return false;
            }
    }
    
    return true; // If all fields have valid image, this function will return true        
}
