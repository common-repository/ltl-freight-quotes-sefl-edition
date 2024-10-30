<?php
/**
 * SEFL WooComerce Admin Settings | Settings Tabs Class
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SEFL WooComerce | Setting Tabs Class
 */
class SEFL_Freight_Settings extends WC_Settings_Page
{
    /**
     * Setting Tabs
     */
    public function __construct()
    {
        $this->id = 'sefl_quotes';
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);
        add_action('woocommerce_sections_' . $this->id, array($this, 'output_sections'));
        add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
        add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
    }

    /**
     * SEFL Setting Tab For WooCommerce
     * @param $settings_tabs
     * @return array
     */
    public function add_settings_tab($settings_tabs)
    {
        $settings_tabs[$this->id] = __('SEFL', 'woocommerce_sefl_quote');
        return $settings_tabs;
    }

    /**
     * sefl Setting Sections
     * @return get section
     */
    public function get_sections()
    {
        $sections = array(
            '' => __('Connection Settings', 'woocommerce_sefl_quote'),
            'section-1' => __('Quote Settings', 'woocommerce_sefl_quote'),
            'section-2' => __('Warehouses', 'woocommerce_sefl_quote'),
            // fdo va
            'section-4' => __('FreightDesk Online', 'woocommerce_sefl_quote'),
            'section-5' => __('Validate Addresses', 'woocommerce_sefl_quote'),
            'section-3' => __('User Guide', 'woocommerce_sefl_quote')
        );

        // Logs data
        $enable_logs = get_option('enale_logs_sefl');
        if ($enable_logs == 'yes') {
            $sections['en-logs'] = 'Logs';
        }

        $sections = apply_filters('en_woo_addons_sections', $sections, en_woo_plugin_sefl_quotes);
        // Standard Packaging
        $sections = apply_filters('en_woo_pallet_addons_sections', $sections, en_woo_plugin_sefl_quotes);
        return apply_filters('woocommerce_get_sections_' . $this->id, $sections);
    }

    /**
     * sefl Warehouse Tab
     */
    public function sefl_warehouse()
    {
        require_once 'warehouse-dropship/wild/warehouse/warehouse_template.php';
        require_once 'warehouse-dropship/wild/dropship/dropship_template.php';
    }

    /**
     * sefl User Guide Tab
     */
    public function sefl_user_guide()
    {
        include_once('template/sefl-guide.php');
    }

    /**
     * SEFL Settings
     * @param $section
     * @return settings pages
     */
    public function get_settings($section = null)
    {
        ob_start();
        switch ($section) {
            case 'section-0' :
                $settings = SEFL_Connection_Settings::sefl_con_setting();
                break;
            case 'section-1':
                $sefl_quote_Settings = new SEFL_Quote_Settings();
                $settings = $sefl_quote_Settings->sefl_quote_settings_tab();
                break;
            case 'section-2' :
                $this->sefl_warehouse();
                $settings = array();
                break;
            case 'section-3' :
                $this->sefl_user_guide();
                $settings = array();
                break;
            // fdo va
            case 'section-4' :
                $this->freightdesk_online_section();
                $settings = [];
                break;

            case 'section-5' :
                $this->validate_addresses_section();
                $settings = [];
                break;

            case 'en-logs' :
                $this->shipping_logs_section();
                $settings = [];
                break;

            default:
                $sefl_con_settings = new SEFL_Connection_Settings();
                $settings = $sefl_con_settings->sefl_con_setting();

                break;
        }

        $settings = apply_filters('en_woo_addons_settings', $settings, $section, en_woo_plugin_sefl_quotes);
        // Standard Packaging
        $settings = apply_filters('en_woo_pallet_addons_settings', $settings, $section, en_woo_plugin_sefl_quotes);
        $settings = $this->avaibility_addon($settings);
        return apply_filters('woocommerce_sefl_quote', $settings, $section);
    }

    /**
     * avaibility_addon
     * @param array type $settings
     * @return array type
     */
    function avaibility_addon($settings)
    {
        if (is_plugin_active('residential-address-detection/residential-address-detection.php')) {
            unset($settings['avaibility_lift_gate']);
            unset($settings['avaibility_auto_residential']);
        }

        return $settings;
    }

    /**
     * Settings Output
     * @global type $current_section
     */
    public function output()
    {
        global $current_section;
        $settings = $this->get_settings($current_section);
        WC_Admin_Settings::output_fields($settings);
    }

    /**
     * sefl Save Settings
     * @global $current_section
     */
    public function save()
    {
        global $current_section;
        $settings = $this->get_settings($current_section);
        // Cuttoff Time
        if (isset($_POST['sefl_freight_order_cut_off_time']) && $_POST['sefl_freight_order_cut_off_time'] != '') {
            $time_24_format = $this->sefl_get_time_in_24_hours($_POST['sefl_freight_order_cut_off_time']);
            $_POST['sefl_freight_order_cut_off_time'] = $time_24_format;
        }
        WC_Admin_Settings::save_fields($settings);
    }
    /**
     * Cuttoff Time
     * @param $timeStr
     * @return false|string
     */
    public function sefl_get_time_in_24_hours($timeStr)
    {
        $cutOffTime = explode(' ', $timeStr);
        $hours = $cutOffTime[0];
        $separator = $cutOffTime[1];
        $minutes = $cutOffTime[2];
        $meridiem = $cutOffTime[3];
        $cutOffTime = "{$hours}{$separator}{$minutes} $meridiem";
        return date("H:i", strtotime($cutOffTime));
    }
    // fdo va
    /**
     * FreightDesk Online section
     */
    public function freightdesk_online_section()
    {
        include_once plugin_dir_path(__FILE__) . 'fdo/freightdesk-online-section.php';
    }

    /**
     * Validate Addresses Section
     */
    public function validate_addresses_section()
    {
        include_once plugin_dir_path(__FILE__) . 'fdo/validate-addresses-section.php';
    }
    
    /**
     * Shipping Logs Section
    */
    public function shipping_logs_section()
    {
        include_once plugin_dir_path(__FILE__) . 'logs/en-logs.php';
    }
}

return new SEFL_Freight_Settings();