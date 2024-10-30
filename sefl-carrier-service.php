<?php
/**
 * SEFL WooComerce | Get SEFL LTL Quotes Rate Class
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SEFL WooComerce | Get SEFL LTL Quotes Rate Class
 */
class SEFL_Get_Shipping_Quotes extends Sefl_Quotes_Liftgate_As_Option
{
    public $en_wd_origin_array;
    public $InstorPickupLocalDelivery;
    public $quote_settings;

    /**
     * Create Shipping Package
     * @param $packages
     * @return shipping package
     */
    function sefl_shipping_array($packages, $package_plugin = '')
    {
        $EnSeflFdo = new EnSeflFdo();
        $en_fdo_meta_data = array();

        $product_name = $lineItem = array();
        // Cuttoff Time
        $shipment_week_days = "";
        $order_cut_off_time = "";
        $shipment_off_set_days = "";
        $modify_shipment_date_time = "";
        $store_date_time = "";
        $sefl_delivery_estimates = get_option('sefl_delivery_estimates');
        $shipment_week_days = $this->sefl_shipment_week_days();
        if ($sefl_delivery_estimates == 'delivery_days' || $sefl_delivery_estimates == 'delivery_date') {
            $order_cut_off_time = $this->quote_settings['orderCutoffTime'];
            $shipment_off_set_days = $this->quote_settings['shipmentOffsetDays'];
            $modify_shipment_date_time = ($order_cut_off_time != '' || $shipment_off_set_days != '' || (is_array($shipment_week_days) && count($shipment_week_days) > 0)) ? 1 : 0;
            $store_date_time = $today = date('Y-m-d H:i:s', current_time('timestamp'));
        }
        // check plan for nested material
        $nested_plan = apply_filters('sefl_quotes_quotes_plans_suscription_and_features', 'nested_material');
        $nestingPercentage = $nestedDimension = $nestedItems = $stakingProperty = [];
        $doNesting = false;
        $product_markup_shipment = 0;

        foreach ($packages['items'] as $item) {
            $iProductClass = "";
            if (isset($item['productClass']) && !empty($item['productClass'])) {
                switch ($item['productClass']) {
                    case "92.5":
                        $iProductClass = 92;
                        break;

                    case "77.5":
                        $iProductClass = 77;
                        break;

                    default :
                        $iProductClass = $item['productClass'];
                        break;
                }
            }

            // Standard Packaging
            $ship_as_own_pallet = isset($item['ship_as_own_pallet']) && $item['ship_as_own_pallet'] == 'yes' ? 1 : 0;
            $vertical_rotation_for_pallet = isset($item['vertical_rotation_for_pallet']) && $item['vertical_rotation_for_pallet'] == 'yes' ? 1 : 0;
            $sefl_counter = (isset($item['variantId']) && $item['variantId'] > 0) ? $item['variantId'] : $item['productId'];

            $lineItem[$sefl_counter] = array(
                'lineItemHeight' => $item['productHeight'],
                'lineItemLength' => $item['productLength'],
                'lineItemWidth' => $item['productWidth'],
                'lineItemClass' => $iProductClass,
                'lineItemWeight' => $item['productWeight'],
                'piecesOfLineItem' => $item['productQty'],
                'cubicFt' => '',
                // Nested indexes
                'nestingPercentage' => $item['nestedPercentage'],
                'nestingDimension' => $item['nestedDimension'],
                'nestedLimit' => $item['nestedItems'],
                'nestedStackProperty' => $item['stakingProperty'],

                // Shippable handling units
                'lineItemPalletFlag' => $item['lineItemPalletFlag'],
                'lineItemPackageType' => $item['lineItemPackageType'],
                // Standard Packaging
                'shipPalletAlone' => $ship_as_own_pallet,
                'vertical_rotation' => $vertical_rotation_for_pallet
            );

            $lineItem[$sefl_counter] = apply_filters('en_fdo_carrier_service', $lineItem[$sefl_counter], $item);
            isset($item['nestedMaterial']) && !empty($item['nestedMaterial']) &&
            $item['nestedMaterial'] == 'yes' && !is_array($nested_plan) ? $doNesting = 1 : "";

            $product_name[] = $item['product_name'];

            if(!empty($item['markup']) && is_numeric($item['markup'])){
                $product_markup_shipment += $item['markup'];
            }
        }

        $destinationAddressSefl = $this->destinationAddressSefl();
        $aPluginVersions = $this->sefl_wc_version_number();
        $domain = sefl_quotes_get_domain();
        $billing_accountno = get_option('wc_settings_sefl_billing_accountno');
        $accountno = get_option('wc_settings_sefl_accountno');
        $customer_zip = get_option('customer_zip_code_sefl');
        $residential_detecion_flag = get_option("en_woo_addons_auto_residential_detecion_flag");

        $this->en_wd_origin_array = (isset($packages['origin'])) ? $packages['origin'] : array();

        if ($packages['origin']['zip'] == $customer_zip) {
            $customerAccount = $accountno;
            $option = "S";

        } elseif (strlen($billing_accountno) > 0) {
            $customerAccount = $billing_accountno;
            $option = "T";

        } else {
            
            $customerAccount = $accountno;
            $option = "S";
        }

        $en_fdo_meta_data = $EnSeflFdo->en_cart_package($packages);

        $post_data = array(
            'plateform' => 'WordPress',
            'plugin_version' => $aPluginVersions["sefl_plugin_version"],
            'wordpress_version' => get_bloginfo('version'),
            'woocommerce_version' => $aPluginVersions["woocommerce_plugin_version"],
            'licence_key' => get_option('wc_settings_sefl_plugin_licence_key'),
            'sever_name' => $this->sefl_parse_url($domain),
            'carrierName' => 'southeastern',
            'carrier_mode' => 'pro',
            'username' => get_option('wc_settings_sefl_username'),
            'password' => get_option('wc_settings_sefl_password'),
            'customerAccount' => $customerAccount,
            'customerName' => get_option('customer_name_sefl'),
            'customerStreet' => get_option('customer_street_address_sefl'),
            'customerCity' => get_option('customer_city_sefl'),
            'customerState' => get_option('customer_state_sefl'),
            'customerZip' => get_option('customer_zip_code_sefl'),

            'suspend_residential' => get_option('suspend_automatic_detection_of_residential_addresses'),
            'residential_detecion_flag' => $residential_detecion_flag,

            'senderCity' => $packages['origin']['city'],
            'senderState' => $packages['origin']['state'],
            'senderZip' => $packages['origin']['zip'],
            'senderCountryCode' => $this->sefl_get_country_code($packages['origin']['country']),
            'receiverCity' => $destinationAddressSefl['city'],
            'receiverState' => $destinationAddressSefl['state'],
            'receiverZip' => str_replace(' ', '', $destinationAddressSefl['zip']),
            'receiverCountryCode' => $this->sefl_get_country_code($destinationAddressSefl['country']),
            'Option' => $option,
            'lookupTransit' => 'Y',
            'pickupDateMM' => date('m'),
            'pickupDateDD' => date('d'),
            'pickupDateYYYY' => date('Y'),
            'terms' => 'P',
            'emailAddress' => '',
            'accessorial' => array(
                (get_option('sefl_liftgate') == 'yes') ? 'chkLGD' : '',
                (get_option('sefl_residential') == 'yes') ? 'chkPR' : '',

            ),
            'commdityDetails' => $lineItem,
            'en_fdo_meta_data' => $en_fdo_meta_data,
            'sender_origin' => $packages['origin']['location'] . ": " . $packages['origin']['city'] . ", " . $packages['origin']['state'] . " " . $packages['origin']['zip'],
            'product_name' => $product_name,
            'sender_location' => $packages['origin']['location'],
            'doNesting' => $doNesting,
            // Cuttoff Time
            'modifyShipmentDateTime' => $modify_shipment_date_time,
            'OrderCutoffTime' => $order_cut_off_time,
            'shipmentOffsetDays' => $shipment_off_set_days,
            'storeDateTime' => $store_date_time,
            'shipmentWeekDays' => $shipment_week_days,
            'origin_markup' => (isset($packages['origin']['origin_markup'])) ? $packages['origin']['origin_markup'] : 0,
            'product_level_markup' => $product_markup_shipment,
            'handlingUnitWeight' => get_option('handling_weight_sefl'),
            'maxWeightPerHandlingUnit' => get_option('maximum_handling_weight_sefl'),
        );

        $post_data = $this->sefl_quotes_update_carrier_service($post_data);
        $post_data = apply_filters("en_woo_addons_carrier_service_quotes_request", $post_data, en_woo_plugin_sefl_quotes);

        if (get_option('sefl_quotes_store_type') == "1") {
//          Hazardous Material
            $hazardous_material = apply_filters('sefl_quotes_quotes_plans_suscription_and_features', 'hazardous_material');

            if (!is_array($hazardous_material)) {

                $post_data['accessorial'][] = ($packages['hazardousMaterial'] == 'yes') ? 'chkHM' : '';
                ($packages['hazardousMaterial'] == 'yes') ? $post_data['hazardous'][] = 'H' : '';
                $post_data['en_fdo_meta_data'] = array_merge($post_data['en_fdo_meta_data'], $EnSeflFdo->en_package_hazardous($packages, $en_fdo_meta_data));
            }
        } else {
            $post_data['accessorial'][] = ($packages['hazardousMaterial'] == 'yes') ? 'chkHM' : '';
            ($packages['hazardousMaterial'] == 'yes') ? $post_data['hazardous'][] = 'H' : '';
            $post_data['en_fdo_meta_data'] = array_merge($post_data['en_fdo_meta_data'], $EnSeflFdo->en_package_hazardous($packages, $en_fdo_meta_data));
        }

//      In-store pickup and local delivery
        $instore_pickup_local_devlivery_action = apply_filters('sefl_quotes_quotes_plans_suscription_and_features', 'instore_pickup_local_devlivery');

        if (!is_array($instore_pickup_local_devlivery_action)) {
            $post_data = apply_filters('en_wd_standard_plans', $post_data, $post_data['receiverZip'], $this->en_wd_origin_array, $package_plugin);
        }

        // Standard Packaging
        // Configure standard plugin with pallet packaging addon
        $post_data = apply_filters('en_pallet_identify', $post_data);

//      Eniture debug mood
        do_action("eniture_debug_mood", "Quotes Request (SEFL)", $post_data);
        do_action("eniture_debug_mood", "Build Query (SEFL)", http_build_query($post_data));
        do_action("eniture_debug_mood", "Plugin Feature (Sefl)", get_option('eniture_plugin_12'));
        return $post_data;
    }

    /**
     * @return shipment days of a week  - Cuttoff time
     */
    public function sefl_shipment_week_days()
    {
        $shipment_days_of_week = array();

        if (get_option('all_shipment_days_sefl') == 'yes') {
            return $shipment_days_of_week;
        }
        if (get_option('monday_shipment_day_sefl') == 'yes') {
            $shipment_days_of_week[] = 1;
        }
        if (get_option('tuesday_shipment_day_sefl') == 'yes') {
            $shipment_days_of_week[] = 2;
        }
        if (get_option('wednesday_shipment_day_sefl') == 'yes') {
            $shipment_days_of_week[] = 3;
        }
        if (get_option('thursday_shipment_day_sefl') == 'yes') {
            $shipment_days_of_week[] = 4;
        }
        if (get_option('friday_shipment_day_sefl') == 'yes') {
            $shipment_days_of_week[] = 5;
        }

        return $shipment_days_of_week;
    }

    /**
     * SEFL Line Items
     * @param $packages
     * @return string
     */
    function sefl_get_line_items($packages)
    {
        $lineItem = array();
        foreach ($packages['items'] as $item) {
            $iProductClass = "";
            if (isset($item['productClass']) && !empty($item['productClass'])) {
                switch ($item['productClass']) {
                    case "92.5":
                        $iProductClass = 92;
                        break;

                    case "77.5":
                        $iProductClass = 77;
                        break;

                    default :
                        $iProductClass = $item['productClass'];
                        break;
                }
            }
            $lineItem[] = array(
                'lineItemHeight' => $item['productHeight'],
                'lineItemLength' => $item['productLength'],
                'lineItemWidth' => $item['productWidth'],
                'lineItemClass' => $iProductClass,
                'lineItemWeight' => $item['productWeight'],
                'piecesOfLineItem' => $item['productQty'],
                'cubicFt' => ''
            );
        }
        return $lineItem;
    }

    /**
     * Get SEFL Country Code
     * @param $sCountryName
     * @return string
     */
    function sefl_get_country_code($sCountryName)
    {
        switch (trim($sCountryName)) {
            case 'CN':
                $sCountryName = "CA";
                break;
            case 'CA':
                $sCountryName = "CA";
                break;
            case 'CAN':
                $sCountryName = "CA";
                break;
            case 'US':
                $sCountryName = "US";
                break;
            case 'USA':
                $sCountryName = "US";
                break;
        }
        return $sCountryName;
    }

    function destinationAddressSefl()
    {
        $en_order_accessories = apply_filters('en_order_accessories', []);
        if (isset($en_order_accessories) && !empty($en_order_accessories)) {
            return $en_order_accessories;
        }

        $sefl_woo_obj = new SEFL_Woo_Update_Changes();
        $freight_zipcode = (strlen(WC()->customer->get_shipping_postcode()) > 0) ? WC()->customer->get_shipping_postcode() : $sefl_woo_obj->sefl_postcode();
        $freight_state = (strlen(WC()->customer->get_shipping_state()) > 0) ? WC()->customer->get_shipping_state() : $sefl_woo_obj->sefl_getState();
        $freight_country = (strlen(WC()->customer->get_shipping_country()) > 0) ? WC()->customer->get_shipping_country() : $sefl_woo_obj->sefl_getCountry();
        $freight_city = (strlen(WC()->customer->get_shipping_city()) > 0) ? WC()->customer->get_shipping_city() : $sefl_woo_obj->sefl_getCity();
        return array(
            'city' => $freight_city,
            'state' => $freight_state,
            'zip' => $freight_zipcode,
            'country' => $freight_country
        );
    }

    /**
     * Get Nearest Address If Multiple Warehouses
     * @param $warehous_list
     * @param $receiverZipCode
     * @return  Warehouse Address
     */
    function sefl_multi_warehouse($warehous_list, $receiverZipCode)
    {
        if (count($warehous_list) == 1) {
            $warehous_list = reset($warehous_list);
            return $this->sefl_origin_array($warehous_list);
        }

        $sefl_distance_request = new Get_sefl_quotes_distance();
        $accessLevel = "MultiDistance";
        $response_json = $sefl_distance_request->sefl_quotes_get_distance($warehous_list, $accessLevel, $this->destinationAddressSefl());
        $response_obj = json_decode($response_json);
        return $this->sefl_origin_array($response_obj->origin_with_min_dist);

    }

    /**
     * Create Origin Array
     * @param $origin
     * @return Warehouse Address Array
     */
    function sefl_origin_array($origin)
    {
//      In-store pickup and local delivery
        if (has_filter("en_wd_origin_array_set")) {
            return apply_filters("en_wd_origin_array_set", $origin);
        }
        return array('locationId' => $origin->id, 'zip' => $origin->zip, 'city' => $origin->city, 'state' => $origin->state, 'location' => $origin->location, 'country' => $origin->country);
    }

    /**
     * Refine URL
     * @param $domain
     * @return Domain URL
     */
    function sefl_parse_url($domain)
    {
        $domain = trim($domain);
        $parsed = parse_url($domain);

        if (empty($parsed['scheme'])) {
            $domain = 'http://' . ltrim($domain, '/');
        }

        $parse = parse_url($domain);
        $refinded_domain_name = $parse['host'];
        $domain_array = explode('.', $refinded_domain_name);

        if (in_array('www', $domain_array)) {
            $key = array_search('www', $domain_array);
            unset($domain_array[$key]);
            if(phpversion() < 8) {
                $refinded_domain_name = implode($domain_array, '.'); 
            }else {
                $refinded_domain_name = implode('.', $domain_array);
            }
        }
        return $refinded_domain_name;
    }

    /**
     * Curl Request To Get Quotes
     * @param $request_data
     * @return json/array
     */
    function sefl_get_web_quotes($request_data)
    {
//      check response from session 
        $currentData = md5(json_encode($request_data));
        $requestFromSession = WC()->session->get('previousRequestData');
        $requestFromSession = ((is_array($requestFromSession)) && (!empty($requestFromSession))) ? $requestFromSession : array();

        if (isset($requestFromSession[$currentData]) && (!empty($requestFromSession[$currentData]))) {
            $this->InstorPickupLocalDelivery = (isset(json_decode($requestFromSession[$currentData])->InstorPickupLocalDelivery) ? json_decode($requestFromSession[$currentData])->InstorPickupLocalDelivery : NULL);
//          Eniture debug mood
            do_action("eniture_debug_mood", "Quotes Response Session (SEFL)", json_decode($requestFromSession[$currentData]));

            return $this->parse_sefl_output($requestFromSession[$currentData], $request_data);
        }

        if (is_array($request_data) && count($request_data) > 0) {
            $sefl_curl_obj = new SEFL_Curl_Request();
            $output = $sefl_curl_obj->sefl_get_curl_response(SEFL_FREIGHT_DOMAIN_HITTING_URL . '/index.php', $request_data);

//      set response in session 
            $response = json_decode($output);

            $rateQuote = (isset($response->q->rateQuote) ? (array)$response->q->rateQuote : "");

            if (isset($rateQuote) &&
                (!empty($rateQuote))) {
                if (isset($response->autoResidentialSubscriptionExpired) &&
                    ($response->autoResidentialSubscriptionExpired == 1)) {
                    $flag_api_response = "no";
                    $request_data['residential_detecion_flag'] = $flag_api_response;
                    $currentData = md5(json_encode($request_data));
                }

                $requestFromSession[$currentData] = $output;
                WC()->session->set('previousRequestData', $requestFromSession);
            }


            $response = json_decode($output);

            $this->InstorPickupLocalDelivery = (isset($response->InstorPickupLocalDelivery) ? $response->InstorPickupLocalDelivery : NULL);

//          Eniture debug mood
            do_action("eniture_debug_mood", "Quotes Response (SEFL)", json_decode($output));

            return $this->parse_sefl_output($output, $request_data);
        }
    }

    /**
     * Get Shipping Array For Single Shipment
     * @param $output
     * @return Single Quote Array
     */
    function parse_sefl_output($output, $request_data)
    {
        $result = json_decode($output);
        // FDO
        $en_fdo_meta_data = (isset($request_data['en_fdo_meta_data'])) ? $request_data['en_fdo_meta_data'] : '';
        if (isset($result->debug)) {
            $en_fdo_meta_data['handling_unit_details'] = $result->debug;
        }

        // Standard Packaging
        $standard_packaging = isset($result->standardPackagingData) ? $result->standardPackagingData : [];
        // Cuttoff Time
        $delivery_estimates = (isset($result->q->totalTransitTimeInDays)) ? $result->q->totalTransitTimeInDays : '';
        $delivery_time_stamp = (isset($result->q->deliveryDate)) ? $result->q->deliveryDate : '';

        $accessorials = [];
        ($this->quote_settings['liftgate_delivery'] == "yes") ? $accessorials[] = "L" : "";
        ($this->quote_settings['residential_delivery'] == "yes") ? $accessorials[] = "R" : "";
        (isset($request_data['hazardous']) && is_array($request_data['hazardous']) && in_array('H', $request_data['hazardous'])) ? $accessorials[] = "H" : "";

        $label_sufex_arr = $this->filter_label_sufex_array_sefl_quotes($result);
        $rateQuote = (isset($result->q->rateQuote) ? (array)$result->q->rateQuote : "");

        if (isset($rateQuote) && !empty($rateQuote)) {

            $simple_quotes = array();
            $surcharges = (isset($result->q->details)) ? $result->q->details : '';
            $meta_data['accessorials'] = json_encode($accessorials);
            $meta_data['sender_origin'] = $request_data['sender_origin'];
            $meta_data['product_name'] = json_encode($request_data['product_name']);
            // Standard Packaging
            $meta_data['standard_packaging'] = wp_json_encode($standard_packaging);
            $cost = (isset($result->q->rateQuote)) ? $result->q->rateQuote : 0;
            $self_freight_class = new SEFL_Freight_Shipping_Class();

            // Product level markup
            if ( !empty($request_data['product_level_markup'])) {
                $cost = $self_freight_class->add_handling_fee($cost, $request_data['product_level_markup']);
            }        
            
            // Origin level markup
            if ( !empty($request_data['origin_markup'])) {
                $cost = $self_freight_class->add_handling_fee($cost, $request_data['origin_markup']);
            }

            $quotes = array(
                'id' => 'en_sefl',
                'cost' => $cost,
                // Cuttoff Time
                'delivery_estimates' => $delivery_estimates,
                'delivery_time_stamp' => $delivery_time_stamp,
                'label_sfx_arr' => $label_sufex_arr,
                'surcharges' => (isset($surcharges)) ? $this->update_parse_sefl_quotes_output($surcharges) : 0,
                'meta_data' => $meta_data,
                'plugin_name' => 'sefl',
                'plugin_type' => 'ltl',
                'owned_by' => 'eniture'
            );

            in_array('R', $label_sufex_arr) ? $quotes['meta_data']['en_fdo_meta_data']['accessorials']['residential'] = true : '';
            $en_fdo_meta_data['rate'] = $quotes;
            if (isset($en_fdo_meta_data['rate']['meta_data'])) {
                unset($en_fdo_meta_data['rate']['meta_data']);
            }
            $en_fdo_meta_data['quote_settings'] = $this->quote_settings;
            $quotes['meta_data']['en_fdo_meta_data'] = $en_fdo_meta_data;
            $quotes = apply_filters("en_woo_addons_web_quotes", $quotes, en_woo_plugin_sefl_quotes);

            $label_sufex = (isset($quotes['label_sufex'])) ? $quotes['label_sufex'] : array();

            $label_sufex = $this->label_R_sefl_ltl($label_sufex);

            $quotes['label_sufex'] = $label_sufex;
            in_array('R', $label_sufex_arr) ? $quotes['meta_data']['en_fdo_meta_data']['accessorials']['residential'] = true : '';

            ($this->quote_settings['liftgate_resid_delivery'] == "yes") && (in_array("R", $label_sufex)) && in_array('L', $label_sufex_arr) ? $quotes['meta_data']['en_fdo_meta_data']['accessorials']['liftgate'] = true : '';

            if (($this->quote_settings['liftgate_delivery_option'] == "yes") &&
                (($this->quote_settings['liftgate_resid_delivery'] == "yes") && (!in_array("R", $label_sufex)) ||
                    ($this->quote_settings['liftgate_resid_delivery'] != "yes"))) {
                $service = $quotes;
                $quotes['id'] .= "WL";

                (isset($quotes['label_sufex']) &&
                    (!empty($quotes['label_sufex']))) ?
                    array_push($quotes['label_sufex'], "L") : // IF
                    $quotes['label_sufex'] = array("L");       // ELSE

                $quotes['meta_data']['en_fdo_meta_data']['accessorials']['liftgate'] = true;
                $quotes['append_label'] = " with lift gate delivery ";
                $liftgate_charge = (isset($service['surcharges']['LIFTGATE DELIVERY'])) ? $service['surcharges']['LIFTGATE DELIVERY'] : 0;
                $service['cost'] = (isset($service['cost'])) ? $service['cost'] - $liftgate_charge : 0;
                (!empty($service)) && (in_array("R", $service['label_sufex'])) ? $service['label_sufex'] = array("R") : $service['label_sufex'] = array();
                $simple_quotes = $service;
                // FDO
                if (isset($simple_quotes['meta_data']['en_fdo_meta_data']['rate']['cost'])) {
                    $simple_quotes['meta_data']['en_fdo_meta_data']['rate']['cost'] = $service['cost'];
                }
            }

        } else {
            return [];
            $simple_quotes = array();
            $meta_data['accessorials'] = json_encode($accessorials);
            $meta_data['sender_origin'] = $request_data['sender_origin'];
            $meta_data['product_name'] = json_encode($request_data['product_name']);
            // Standard packaging
            $meta_data['standard_packaging'] = wp_json_encode($standard_packaging);

            $quotes = array(
                'id' => 'no_quotes',
                'label' => '',
                'cost' => 0,
                'label_sfx_arr' => [],
                'surcharges' => [],
                'meta_data' => $meta_data,
                'plugin_name' => 'sefl',
                'plugin_type' => 'ltl',
                'owned_by' => 'eniture'
            );

            $en_fdo_meta_data['rate'] = $quotes;
            if (isset($en_fdo_meta_data['rate']['meta_data'])) {
                unset($en_fdo_meta_data['rate']['meta_data']);
            }
            $en_fdo_meta_data['quote_settings'] = $this->quote_settings;
            $quotes['meta_data']['en_fdo_meta_data'] = $en_fdo_meta_data;

            // FDO
            $label_sufex = (isset($quotes['label_sufex'])) ? $quotes['label_sufex'] : array();

            $label_sufex = $this->label_R_sefl_ltl($label_sufex);
            $quotes['label_sufex'] = $label_sufex;

            in_array('R', $label_sufex_arr) ? $quotes['meta_data']['en_fdo_meta_data']['accessorials']['residential'] = true : '';
            ($this->quote_settings['liftgate_resid_delivery'] == "yes") && (in_array("R", $label_sufex)) && in_array('L', $label_sufex_arr) ? $quotes['meta_data']['en_fdo_meta_data']['accessorials']['liftgate'] = true : '';

            if (($this->quote_settings['liftgate_delivery_option'] == "yes") &&
                (($this->quote_settings['liftgate_resid_delivery'] == "yes") && (!in_array("R", $label_sufex)) ||
                    ($this->quote_settings['liftgate_resid_delivery'] != "yes"))) {
                $service = $quotes;
                $quotes['id'] .= "WL";

                (isset($quotes['label_sufex']) &&
                    (!empty($quotes['label_sufex']))) ?
                    array_push($quotes['label_sufex'], "L") : // IF
                    $quotes['label_sufex'] = array("L");       // ELSE

                // FDO
                $quotes['meta_data']['en_fdo_meta_data']['accessorials']['liftgate'] = true;
                $quotes['append_label'] = " with lift gate delivery ";

                $simple_quotes = $service;

                // FDO
                if (isset($simple_quotes['meta_data']['en_fdo_meta_data']['rate']['cost'])) {
                    $simple_quotes['meta_data']['en_fdo_meta_data']['rate']['cost'] = $service['cost'];
                }
            }
        }

        (!empty($simple_quotes)) ? $quotes['simple_quotes'] = $simple_quotes : "";

        return $quotes;
    }

    /**
     * check "R" in array
     * @param array type $label_sufex
     * @return array type
     */
    public function label_R_sefl_ltl($label_sufex)
    {
        if (get_option('sefl_residential') == 'yes' && (in_array("R", $label_sufex))) {
            $label_sufex = array_flip($label_sufex);
            unset($label_sufex['R']);
            $label_sufex = array_keys($label_sufex);
        }

        return $label_sufex;
    }

    /**
     * Return WooCommerce version
     * @return version
     */
    function sefl_wc_version_number()
    {
        if (!function_exists('get_plugins'))
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');

        $plugin_folder = get_plugins('/' . 'woocommerce');
        $plugin_file = 'woocommerce.php';
        $sefl_plugin_folders = get_plugins('/' . 'ltl-freight-quotes-sefl-edition');
        $sefl_plugin_files = 'ltl-freight-quotes-sefl-edition.php';
        $wc_plugin = (isset($plugin_folder[$plugin_file]['Version'])) ? $plugin_folder[$plugin_file]['Version'] : "";
        $ups_small_plugin = (isset($sefl_plugin_folders[$sefl_plugin_files]['Version'])) ? $sefl_plugin_folders[$sefl_plugin_files]['Version'] : "";

        $pluginVersions = array(
            "woocommerce_plugin_version" => $wc_plugin,
            "sefl_plugin_version" => $ups_small_plugin
        );

        return $pluginVersions;
    }

    /**
     * Return SEFL LTL In-store Pickup Array
     */
    function sefl_ltl_return_local_delivery_store_pickup()
    {
        return $this->InstorPickupLocalDelivery;
    }
}
