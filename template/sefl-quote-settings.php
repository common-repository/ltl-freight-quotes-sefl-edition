<?php
/**
 * SEFL WooComerce | Quote Settings Page
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

/**
 * SEFL WooComerce | Quote Settings Class
 */
class SEFL_Quote_Settings 
{
    /**
     * Quote Settings
     * @return array
     */
    function sefl_quote_settings_tab() 
    {
        // Cuttoff Time
        $sefl_disable_cutt_off_time_ship_date_offset = "";
        $sefl_cutt_off_time_package_required = "";

        //  Check the cutt of time & offset days plans for disable input fields
        $sefl_action_cutOffTime_shipDateOffset = apply_filters('sefl_quotes_quotes_plans_suscription_and_features', 'sefl_cutt_off_time');
        if (is_array($sefl_action_cutOffTime_shipDateOffset)) {
            $sefl_disable_cutt_off_time_ship_date_offset = "disabled_me";
            $sefl_cutt_off_time_package_required = apply_filters('sefl_quotes_plans_notification_link', $sefl_action_cutOffTime_shipDateOffset);
        }
        
        $ltl_enable = get_option('en_plugins_return_LTL_quotes');
        $weight_threshold_class = $ltl_enable == 'yes' ? 'show_en_weight_threshold_lfq' : 'hide_en_weight_threshold_lfq';
        $weight_threshold = get_option('en_weight_threshold_lfq');
        $weight_threshold = isset($weight_threshold) && $weight_threshold > 0 ? $weight_threshold : 150;


        echo '<div class="quote_section_class_sefl">';
        $settings = array(
            'section_title_quote' => array(
                'title'         => __('Quote Settings ', 'woocommerce_sefl_quote'),
                'type'          => 'title',
                'desc'          => '',
                'id'            => 'sefl_section_title_quote'
            ),

            'label_as_sefl' => array(
                'name'          => __('Label As ', 'woocommerce_sefl_quote'),
                'type'          => 'text',
                'desc'          => '<span class="desc_text_style"> What the user sees during checkout, e.g. "Freight". Leave blank to display the "Freight".</span>',
                'id'            => 'sefl_label_as' 
            ),

            'price_sort_sefl' => array(
                'name' => __("Don't sort shipping methods by price  ", 'woocommerce-settings-abf_quotes'),
                'type' => 'checkbox',
                'desc' => 'By default, the plugin will sort all shipping methods by price in ascending order.',
                'id' => 'shipping_methods_do_not_sort_by_price'
            ),
            //** Start Delivery Estimate Options - Cuttoff Time
            'service_sefl_estimates_title' => array(
                'name' => __('Delivery Estimate Options ', 'woocommerce-settings-en_woo_addons_packages_quotes'),
                'type' => 'text',
                'desc' => '',
                'id' => 'service_sefl_estimates_title'
            ),
            'sefl_show_delivery_estimates_options_radio' => array(
                'name' => __("", 'woocommerce-settings-sefl'),
                'type' => 'radio',
                'default' => 'dont_show_estimates',
                'options' => array(
                    'dont_show_estimates' => __("Don't display delivery estimates.", 'woocommerce'),
                    'delivery_days' => __("Display estimated number of days until delivery.", 'woocommerce'),
                    'delivery_date' => __("Display estimated delivery date.", 'woocommerce'),
                ),
                'id' => 'sefl_delivery_estimates',
                'class' => 'sefl_dont_show_estimate_option',
            ),
            //** End Delivery Estimate Options
            //**Start: Cut Off Time & Ship Date Offset
            'cutOffTime_shipDateOffset_sefl_freight' => array(
                'name' => __('Cut Off Time & Ship Date Offset ', 'woocommerce-settings-en_woo_addons_packages_quotes'),
                'type' => 'text',
                'class' => 'hidden',
                'desc' => $sefl_cutt_off_time_package_required,
                'id' => 'sefl_freight_cutt_off_time_ship_date_offset'
            ),
            'orderCutoffTime_sefl_freight' => array(
                'name' => __('Order Cut Off Time ', 'woocommerce-settings-sefl_freight_freight_orderCutoffTime'),
                'type' => 'text',
                'placeholder' => '-- : -- --',
                'desc' => 'Enter the cut off time (e.g. 2.00) for the orders. Orders placed after this time will be quoted as shipping the next business day.',
                'id' => 'sefl_freight_order_cut_off_time',
                'class' => $sefl_disable_cutt_off_time_ship_date_offset,
            ),
            'shipmentOffsetDays_sefl_freight' => array(
                'name' => __('Fullfillment Offset Days ', 'woocommerce-settings-sefl_freight_shipment_offset_days'),
                'type' => 'text',
                'desc' => 'The number of days the ship date needs to be moved to allow the processing of the order.',
                'placeholder' => 'Fullfillment Offset Days, e.g. 2',
                'id' => 'sefl_freight_shipment_offset_days',
                'class' => $sefl_disable_cutt_off_time_ship_date_offset,
            ),
            'all_shipment_days_sefl' => array(
                'name' => __("What days do you ship orders?", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Select All',
                'class' => "all_shipment_days_sefl $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'all_shipment_days_sefl'
            ),
            'monday_shipment_day_sefl' => array(
                'name' => __("", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Monday',
                'class' => "sefl_shipment_day $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'monday_shipment_day_sefl'
            ),
            'tuesday_shipment_day_sefl' => array(
                'name' => __("", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Tuesday',
                'class' => "sefl_shipment_day $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'tuesday_shipment_day_sefl'
            ),
            'wednesday_shipment_day_sefl' => array(
                'name' => __("", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Wednesday',
                'class' => "sefl_shipment_day $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'wednesday_shipment_day_sefl'
            ),
            'thursday_shipment_day_sefl' => array(
                'name' => __("", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Thursday',
                'class' => "sefl_shipment_day $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'thursday_shipment_day_sefl'
            ),
            'friday_shipment_day_sefl' => array(
                'name' => __("", 'woocommerce-settings-sefl_quotes'),
                'type' => 'checkbox',
                'desc' => 'Friday',
                'class' => "sefl_shipment_day $sefl_disable_cutt_off_time_ship_date_offset",
                'id' => 'friday_shipment_day_sefl'
            ),
            'sefl_show_delivery_estimate' => array(
                'title' => __('', 'woocommerce'),
                'name' => __('', 'woocommerce-settings-sefl_quotes'),
                'desc' => '',
                'id' => 'sefl_show_delivery_estimates',
                'css' => '',
                'default' => '',
                'type' => 'title',
            ),
            //**End: Cut Off Time & Ship Date Offset

            'accessorial_quoted_sefl' => array(
                'title'         => __('', 'woocommerce'),
                'name'          => __('', 'woocommerce_sefl_quote'),
                'desc'          => '',
                'id'            => 'woocommerce_accessorial_quoted_sefl',
                'css'           => '',
                'default'       => '',
                'type'          => 'title',
            ),

            'accessorial_quoted_sefl' => array(
                'title'         => __('', 'woocommerce'),
                'name'          => __('', 'woocommerce_sefl_quote'),
                'desc'          => '',
                'id'            => 'woocommerce_sefl_accessorial_quoted',
                'css'           => '',
                'default'       => '',
                'type'          => 'title',
            ),
            
            'residential_delivery_options_label' => array(
                'name' => __('Residential Delivery', 'woocommerce-settings-wwe_small_packages_quotes'),
                'type' => 'text',
                'class' => 'hidden',
                'id' => 'residential_delivery_options_label'
            ),
            
            'accessorial_residential_delivery_sefl' => array(
                'name'          => __('Always quote as residential delivery ', 'woocommerce_sefl_quote'),
                'type'          => 'checkbox',
                'desc'          => __('', 'woocommerce_sefl_quote'),
                'id'            => 'sefl_residential',
                'class'         => 'accessorial_service seflCheckboxClass',
            ),
            
//          Auto-detect residential addresses notification
            'avaibility_auto_residential' => array(
                'name' => __('Auto-detect residential addresses', 'woocommerce-settings-wwe_small_packages_quotes'),
                'type' => 'text',
                'class' => 'hidden',
                'desc' => "Click <a target='_blank' href='https://eniture.com/woocommerce-residential-address-detection/'>here</a> to add the Residential Address Detection module. (<a target='_blank' href='https://eniture.com/woocommerce-residential-address-detection/#documentation'>Learn more</a>)",
                'id' => 'avaibility_auto_residential'
            ),

            'liftgate_delivery_options_label' => array(
                'name' => __('Lift Gate Delivery ', 'woocommerce-settings-en_woo_addons_packages_quotes'),
                'type' => 'text',
                'class' => 'hidden',
                'id' => 'liftgate_delivery_options_label'
            ),

            'accessorial_liftgate_delivery_sefl' => array(
                'name'          => __('Always quote lift gate delivery ', 'woocommerce_sefl_quote'),
                'type'          => 'checkbox',
                'desc'          => __('', 'woocommerce_sefl_quote'),
                'id'            => 'sefl_liftgate',
                'class'         => 'accessorial_service seflCheckboxClass checkbox_fr_add',
            ),
            
            'sefl_quotes_liftgate_delivery_as_option' => array(
                'name'          => __('Offer lift gate delivery as an option ', 'woocommerce-settings-xpo_quotes'),
                'type'          => 'checkbox',
                'desc'          => __('', 'woocommerce-settings-fedex_freight'),
                'id'            => 'sefl_quotes_liftgate_delivery_as_option',
                'class'         => 'accessorial_service checkbox_fr_add seflCheckboxClass',
            ),

//          Use my liftgate notification
            'avaibility_lift_gate' => array(
                'name' => __('Always include lift gate delivery when a residential address is detected', 'woocommerce-settings-wwe_small_packages_quotes'),
                'type' => 'text',
                'class' => 'hidden',
                'desc' => "Click <a target='_blank' href='https://eniture.com/woocommerce-residential-address-detection/'>here</a> to add the Residential Address Detection module. (<a target='_blank' href='https://eniture.com/woocommerce-residential-address-detection/#documentation'>Learn more</a>)",
                'id' => 'avaibility_lift_gate'
            ),
            // Handling Weight
            'handling_unit_sefl' => array(
                'name' => __('Handling Unit ', 'estes_freight_wc_settings'),
                'type' => 'text',
                'class' => 'hidden',
                'id' => 'handling_unit_sefl'
            ),
            'handling_weight_sefl' => array(
                'name' => __('Weight of Handling Unit  ', 'estes_freight_wc_settings'),
                'type' => 'text',
                'desc' => 'Enter in pounds the weight of your pallet, skid, crate or other type of handling unit.',
                'id' => 'handling_weight_sefl'
            ),
            // max Handling Weight
            'maximum_handling_weight_sefl' => array(
                'name' => __('Maximum Weight per Handling Unit  ', 'estes_freight_wc_settings'),
                'type' => 'text',
                'desc' => 'Enter in pounds the maximum weight that can be placed on the handling unit.',
                'id' => 'maximum_handling_weight_sefl'
            ),
            'handing_fee_markup_sefl' => array(
                'name'          => __('Handling Fee / Markup ', 'woocommerce_sefl_quote'),
                'type'          => 'text',
                'desc'          => '<span class="desc_text_style">Amount excluding tax. Enter an amount, e.g 3.75, or a percentage, e.g, 5%. Leave blank to disable.</span>',
                'id'            => 'sefl_handling_fee'
            ),

            // Enale Logs
            'enale_logs_sefl' => array(
                'name' => __("Enable Logs  ", 'woocommerce_odfl_quote'),
                'type' => 'checkbox',
                'desc' => 'When checked, the Logs page will contain up to 25 of the most recent transactions.',
                'id' => 'enale_logs_sefl'
            ),
            'allow_other_plugins_sefl' => array(
                'name'          => __('Show WooCommerce Shipping Options ', 'woocommerce_sefl_quote'),
                'type'          => 'select',
                'default'       => '3',
                'desc'          => __('<span class="desc_text_style">Enabled options on WooCommerce Shipping page are included in quote results.</span>', 'woocommerce_sefl_quote'),
                'id'            => 'sefl_allow_other_plugins',
                'options'       => array(
                    'yes'         => __('YES', 'YES'),
                    'no'          => __('NO', 'NO')
                    
                )
            ),
            'return_SEFL_quotes' => array(
                'name'          => __("Return LTL quotes when an order parcel shipment weight exceeds the weight threshold ", 'woocommerce-settings-sefl_quetes'),
                'type'          => 'checkbox',
                'desc'          => '<span class="desc_text_style">When checked, the LTL Freight Quote will return quotes when an order’s total weight exceeds the weight threshold (the maximum permitted by WWE and UPS), even if none of the products have settings to indicate that it will ship LTL Freight. To increase the accuracy of the returned quote(s), all products should have accurate weights and dimensions. </span>',
                'id'            => 'en_plugins_return_LTL_quotes',
               'class'          => 'seflCheckboxClass'
            ),
            // Weight threshold for LTL freight
            'en_weight_threshold_lfq' => [
                'name' => __('Weight threshold for LTL Freight Quotes  ', 'woocommerce-settings-sefl_quetes'),
                'type' => 'text',
                'default' => $weight_threshold,
                'class' => $weight_threshold_class,
                'id' => 'en_weight_threshold_lfq'
            ],
            'en_suppress_parcel_rates' => array(
                'name' => __("", 'woocommerce-settings-sefl_quetes'),
                'type' => 'radio',
                'default' => 'display_parcel_rates',
                'options' => array(
                    'display_parcel_rates' => __("Continue to display parcel rates when the weight threshold is met.", 'woocommerce-settings-sefl_quetes'),
                    'suppress_parcel_rates' => __("Suppress parcel rates when the weight threshold is met.", 'woocommerce-settings-sefl_quetes'),
                ),
                'class' => 'en_suppress_parcel_rates',
                'id' => 'en_suppress_parcel_rates',
            ),
            'section_end_quote' => array(
                'type'          => 'sectionend',
                'id'            => 'sefl_quote_section_end'
            )
        );
        return $settings;
    }
}