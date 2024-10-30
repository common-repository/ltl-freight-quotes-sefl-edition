<?php
/**
 * SEFL WooComerce | SEFL Test connection HTML Form
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SEFL WooComerce | SEFL Test connection HTML Form
 */
class SEFL_Connection_Settings
{
    /**
     * SEFL Test connection
     * @return array
     */
    public function sefl_con_setting()
    {
        echo '<div class="connection_section_class_sefl">';
        $settings = array(
            'section_title_sefl' => array(
                'name' => __('', 'woocommerce_sefl_quote'),
                'type' => 'title',
                'desc' => '<br> ',
                'id' => 'wc_settings_sefl_title_section_connection',
            ),

            'accountno_sefl' => array(
                'name' => __('Customer Account Number ', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'wc_settings_sefl_accountno',
                'class' => 'sefl_ltl_freight_class',
            ),

            'billing_accountno_sefl' => array(
                'name' => __('3rd Party Billing Account Number  ', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'wc_settings_sefl_billing_accountno',
                'class' => 'sefl_ltl_freight_class',
            ),

            'userid_sefl' => array(
                'name' => __('Username ', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'wc_settings_sefl_username',
                'class' => 'sefl_ltl_freight_class',
            ),

            'password_sefl' => array(
                'name' => __('Password ', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'wc_settings_sefl_password',
                'class' => 'sefl_ltl_freight_class',
            ),

            'customer_name_sefl' => array(
                'class' => 'sefl_ltl_freight_class',
                'name' => __('Customer Name', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'customer_name_sefl'
            ),

            'customer_street_address_sefl' => array(
                'class' => 'sefl_ltl_freight_class',
                'name' => __('Customer Address', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'customer_street_address_sefl'
            ),

            'customer_city_sefl' => array(
                'class' => 'sefl_ltl_freight_class',
                'name' => __('Customer City', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'customer_city_sefl'
            ),

            'customer_state_sefl' => array(
                'class' => 'sefl_ltl_freight_class',
                'name' => __('Customer State', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'customer_state_sefl'
            ),

            'customer_zip_code_sefl' => array(
                'class' => 'sefl_ltl_freight_class',
                'name' => __('Customer Zip Code', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('', 'woocommerce_sefl_quote'),
                'id' => 'customer_zip_code_sefl'
            ),

            'plugin_licence_key_sefl' => array(
                'name' => __('Eniture API Key ', 'woocommerce_sefl_quote'),
                'type' => 'text',
                'desc' => __('Obtain a Eniture API Key from <a href="https://eniture.com/woocommerce-sefl-ltl-freight/" target="_blank" >eniture.com </a>', 'woocommerce_sefl_quote'),
                'id' => 'wc_settings_sefl_plugin_licence_key',
                'class' => 'sefl_ltl_freight_class',
            ),

            'sefl_account_select' => array(
                'name' => __('', 'sefl_freight_wc_settings'),
                'id' => 'sefl_account_select_setting',
                'class' => 'sefl_account_select_setting',
                'type' => 'radio',
                'default' => 'shipper',
                'options' => array(
                    'shipper' => __('Test With Shipper', 'woocommerce'),
                    'thirdParty' => __('Test With Third Party', 'woocommerce')
                )
            ),

            'section_end_sefl' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_sefl_plugin_licence_key'
            ),
        );
        return $settings;
    }
}