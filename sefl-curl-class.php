<?php
/**
 * SEFL WooComerce | Curl Response Class
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}
        
/**
 * SEFL WooComerce | Curl Response Class
 */ 
    class SEFL_Curl_Request 
    {
       
        /**
         * Get Curl Response 
         * @param $url
         * @param $postData
         * @return Json/array
         */
        function sefl_get_curl_response($url, $postData) 
        {
            if ( !empty( $url ) && !empty( $postData ) )
            {
                $field_string = http_build_query($postData);
                
                $response = wp_remote_post($url,
                    array(
                        'method' => 'POST',
                        'timeout' => 60,
                        'redirection' => 5,
                        'blocking' => true,
                        'body' => $field_string,
                    )
                );

                $output = wp_remote_retrieve_body($response);
                return $output;
            }    
        }
    }