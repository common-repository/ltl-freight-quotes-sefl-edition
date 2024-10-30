<?php
/**
 * SEFL WooComerce Admin Settings | Test connection Settings
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_nopriv_sefl_action', 'sefl_test_submit');
add_action('wp_ajax_sefl_action', 'sefl_test_submit');
/**
 * sefl Test connection AJAX Request
 */
function sefl_test_submit()
{
    $sefl_accountno = (isset($_POST['sefl_accountno'])) ? sanitize_text_field($_POST['sefl_accountno']) : "";
    $third_party_acc = (isset($_POST['third_party_acc'])) ? sanitize_text_field($_POST['third_party_acc']) : "";

    $sefl_account_type = (isset($_POST['sefl_account_type'])) ? sanitize_text_field($_POST['sefl_account_type']) : "";

    $option = ($sefl_account_type == 'thirdParty') ? 'T' : 'S';
    $customerAccount = ($sefl_account_type == 'thirdParty') ? $third_party_acc : $sefl_accountno;

    $domain = sefl_quotes_get_domain();
    $data = array(
        'licence_key' => (isset($_POST['sefl_plugin_license'])) ? sanitize_text_field($_POST['sefl_plugin_license']) : "",
        'sever_name' => $domain,
        'carrierName' => 'southeastern',
        'plateform' => 'WordPress',
        'carrier_mode' => 'test',
        'username' => (isset($_POST['sefl_username'])) ? sanitize_text_field($_POST['sefl_username']) : "",
        'password' => (isset($_POST['sefl_password'])) ? sanitize_text_field($_POST['sefl_password']) : "",
        'customerAccount' => $customerAccount,
        'customerName' => (isset($_POST['sefl_customer_name'])) ? sanitize_text_field($_POST['sefl_customer_name']) : "",
        'customerStreet' => (isset($_POST['sefl_customer_street_address'])) ? sanitize_text_field($_POST['sefl_customer_street_address']) : "",
        'customerCity' => (isset($_POST['sefl_customer_city'])) ? sanitize_text_field($_POST['sefl_customer_city']) : "",
        'customerState' => (isset($_POST['sefl_customer_state'])) ? sanitize_text_field($_POST['sefl_customer_state']) : "",
        'customerZip' => (isset($_POST['sefl_customer_zip_code'])) ? sanitize_text_field($_POST['sefl_customer_zip_code']) : "",
        'Option' => $option,
    );

    $sefl_curl_obj = new SEFL_Curl_Request();
    $sResponseData = $sefl_curl_obj->sefl_get_curl_response(SEFL_FREIGHT_DOMAIN_HITTING_URL . '/index.php', $data);
    $sResponseData = json_decode($sResponseData);

    $error = isset($sResponseData->error) ? (array)$sResponseData->error : [];
    $errors = isset($sResponseData->q->error) ? (array)$sResponseData->q->error : [];

    if (isset($sResponseData->q->details->rate) && !empty($sResponseData->q->details->rate)) {
        $sResult = array('message' => "success");
    } elseif (empty($sResponseData->q->details->rate) && (!empty ($error) || !empty ($errors))) {
        if (!empty($sResponseData->error)) {
            $sResult = $sResponseData->error;
        } else {
            $sResult = (!empty ($sResponseData->q->error) && strpos($sResponseData->q->error, "zip") !== false) ? $sResponseData->q->error : "Customer Account Number is invalid.";
        }

        $sResult = array('message' => $sResult);
    } else {
        $sResult = array('message' => "failure");
    }

    echo json_encode($sResult);
    exit();
}
