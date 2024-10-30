jQuery(document).ready(function () {

    // Weight threshold for LTL freight
    en_weight_threshold_limit();
    //          JS for edit product nested fields
    jQuery("._nestedMaterials").closest('p').addClass("_nestedMaterials_tr");
    jQuery("._nestedPercentage").closest('p').addClass("_nestedPercentage_tr");
    jQuery("._maxNestedItems").closest('p').addClass("_maxNestedItems_tr");
    jQuery("._nestedDimension").closest('p').addClass("_nestedDimension_tr");
    jQuery("._nestedStakingProperty").closest('p').addClass("_nestedStakingProperty_tr");
// Cuttoff Time
    jQuery("#sefl_freight_shipment_offset_days").closest('tr').addClass("sefl_freight_shipment_offset_days_tr");
    jQuery("#sefl_freight_shipment_offset_days").attr('maxlength', 8);
    jQuery("#all_shipment_days_sefl").closest('tr').addClass("all_shipment_days_sefl_tr");
    jQuery(".sefl_shipment_day").closest('tr').addClass("sefl_shipment_day_tr");
    jQuery("#sefl_freight_order_cut_off_time").closest('tr').addClass("sefl_freight_cutt_off_time_ship_date_offset");
    var sefl_current_time = en_sefl_admin_script.sefl_freight_order_cutoff_time;
    if (sefl_current_time == '') {

        jQuery('#sefl_freight_order_cut_off_time').wickedpicker({
            now: '',
            title: 'Cut Off Time',
        });
    } else {
        jQuery('#sefl_freight_order_cut_off_time').wickedpicker({

            now: sefl_current_time,
            title: 'Cut Off Time'
        });
    }

    var delivery_estimate_val = jQuery('input[name=sefl_delivery_estimates]:checked').val();
    if (delivery_estimate_val == 'dont_show_estimates') {
        jQuery("#sefl_freight_order_cut_off_time").prop('disabled', true);
        jQuery("#sefl_freight_shipment_offset_days").prop('disabled', true);
        jQuery("#sefl_freight_shipment_offset_days").css("cursor", "not-allowed");
        jQuery("#sefl_freight_order_cut_off_time").css("cursor", "not-allowed");
        jQuery('.sefl_shipment_day, .all_shipment_days_sefl ').prop('disabled', true);
        jQuery('.sefl_shipment_day, .all_shipment_days_sefl').css("cursor", "not-allowed");
    } else {
        jQuery("#sefl_freight_order_cut_off_time").prop('disabled', false);
        jQuery("#sefl_freight_shipment_offset_days").prop('disabled', false);
        // jQuery("#sefl_freight_order_cut_off_time").css("cursor", "auto");
        jQuery("#sefl_freight_order_cut_off_time").css("cursor", "");
        jQuery('.sefl_shipment_day, .all_shipment_days_sefl ').prop('disabled', false);
        jQuery('.sefl_shipment_day, .all_shipment_days_sefl').css("cursor", "");
    }

    jQuery("input[name=sefl_delivery_estimates]").change(function () {
        var delivery_estimate_val = jQuery('input[name=sefl_delivery_estimates]:checked').val();
        if (delivery_estimate_val == 'dont_show_estimates') {
            jQuery("#sefl_freight_order_cut_off_time").prop('disabled', true);
            jQuery("#sefl_freight_shipment_offset_days").prop('disabled', true);
            jQuery("#sefl_freight_order_cut_off_time").css("cursor", "not-allowed");
            jQuery("#sefl_freight_shipment_offset_days").css("cursor", "not-allowed");
            jQuery('.sefl_shipment_day, .all_shipment_days_sefl ').prop('disabled', true);
            jQuery('.sefl_shipment_day, .all_shipment_days_sefl').css("cursor", "not-allowed");
        } else {
            jQuery("#sefl_freight_order_cut_off_time").prop('disabled', false);
            jQuery("#sefl_freight_shipment_offset_days").prop('disabled', false);
            jQuery("#sefl_freight_order_cut_off_time").css("cursor", "auto");
            jQuery("#sefl_freight_shipment_offset_days").css("cursor", "auto");
            jQuery('.sefl_shipment_day, .all_shipment_days_sefl').prop('disabled', false);
            jQuery('.sefl_shipment_day, .all_shipment_days_sefl').css("cursor", "auto");
        }
    });

    /*
     * Uncheck Week days Select All Checkbox
     */
    jQuery(".sefl_shipment_day").on('change load', function () {

        var checkboxes = jQuery('.sefl_shipment_day:checked').length;
        var un_checkboxes = jQuery('.sefl_shipment_day').length;
        if (checkboxes === un_checkboxes) {
            jQuery('.all_shipment_days_sefl').prop('checked', true);
        } else {
            jQuery('.all_shipment_days_sefl').prop('checked', false);
        }
    });

    /*
     * Select All Shipment Week days
     */

    var all_int_checkboxes = jQuery('.all_shipment_days_sefl');
    if (all_int_checkboxes.length === all_int_checkboxes.filter(":checked").length) {
        jQuery('.all_shipment_days_sefl').prop('checked', true);
    }

    jQuery(".all_shipment_days_sefl").change(function () {
        if (this.checked) {
            jQuery(".sefl_shipment_day").each(function () {
                this.checked = true;
            });
        } else {
            jQuery(".sefl_shipment_day").each(function () {
                this.checked = false;
            });
        }
    });


    //** End: Order Cut Off Time
    if (!jQuery('._nestedMaterials').is(":checked")) {
        jQuery('._nestedPercentage_tr').hide();
        jQuery('._nestedDimension_tr').hide();
        jQuery('._maxNestedItems_tr').hide();
        jQuery('._nestedDimension_tr').hide();
        jQuery('._nestedStakingProperty_tr').hide();
    } else {
        jQuery('._nestedPercentage_tr').show();
        jQuery('._nestedDimension_tr').show();
        jQuery('._maxNestedItems_tr').show();
        jQuery('._nestedDimension_tr').show();
        jQuery('._nestedStakingProperty_tr').show();
    }

    jQuery("._nestedPercentage").attr('min', '0');
    jQuery("._maxNestedItems").attr('min', '0');
    jQuery("._nestedPercentage").attr('max', '100');
    jQuery("._maxNestedItems").attr('max', '100');
    jQuery("._nestedPercentage").attr('maxlength', '3');
    jQuery("._maxNestedItems").attr('maxlength', '3');

    if (jQuery("._nestedPercentage").val() == '') {
        jQuery("._nestedPercentage").val(0);
    }

    jQuery("._nestedPercentage").keydown(function (eve) {
        sefl_lfq_stop_special_characters(eve);
        var nestedPercentage = jQuery('._nestedPercentage').val();
        if (nestedPercentage.length == 2) {
            var newValue = nestedPercentage + '' + eve.key;
            if (newValue > 100) {
                return false;
            }
        }
    });

    jQuery("._nestedDimension").keydown(function (eve) {
        sefl_lfq_stop_special_characters(eve);
        var nestedDimension = jQuery('._nestedDimension').val();
        if (nestedDimension.length == 2) {
            var newValue1 = nestedDimension + '' + eve.key;
            if (newValue1 > 100) {
                return false;
            }
        }
    });

    jQuery("._maxNestedItems").keydown(function (eve) {
        sefl_lfq_stop_special_characters(eve);
    });

    jQuery("._nestedMaterials").change(function (e) {
        if (!jQuery('._nestedMaterials').is(":checked")) {
            jQuery('._nestedPercentage_tr').hide();
            jQuery('._nestedDimension_tr').hide();
            jQuery('._maxNestedItems_tr').hide();
            jQuery('._nestedDimension_tr').hide();
            jQuery('._nestedStakingProperty_tr').hide();
        } else {
            jQuery('._nestedPercentage_tr').show();
            jQuery('._nestedDimension_tr').show();
            jQuery('._maxNestedItems_tr').show();
            jQuery('._nestedDimension_tr').show();
            jQuery('._nestedStakingProperty_tr').show();
        }
    });

    jQuery("#order_shipping_line_items .shipping .display_meta").css('display', 'none');

    jQuery("#sefl_residential").closest('tr').addClass("sefl_residential");
    jQuery("#avaibility_auto_residential").closest('tr').addClass("avaibility_auto_residential");
    jQuery("#avaibility_lift_gate").closest('tr').addClass("avaibility_lift_gate");
    jQuery("#sefl_liftgate").closest('tr').addClass("sefl_liftgate");
    jQuery("#sefl_quotes_liftgate_delivery_as_option").closest('tr').addClass("sefl_quotes_liftgate_delivery_as_option");

    /**
     * Offer lift gate delivery as an option and Always include residential delivery fee
     * @returns {undefined}
     */

    jQuery(".checkbox_fr_add").on("click", function () {
        var id = jQuery(this).attr("id");
        if (id == "sefl_liftgate") {
            jQuery("#sefl_quotes_liftgate_delivery_as_option").prop({checked: false});
            jQuery("#en_woo_addons_liftgate_with_auto_residential").prop({checked: false});

        } else if (id == "sefl_quotes_liftgate_delivery_as_option" ||
            id == "en_woo_addons_liftgate_with_auto_residential") {
            jQuery("#sefl_liftgate").prop({checked: false});
        }
    });

    var url = get_url_vars_sefl_freight()["tab"];
    if (url === 'sefl_quotes') {
        jQuery('#footer-left').attr('id', 'wc-footer-left');
    }


    /*
    * Add err class on connection settings page
    */
    jQuery('.connection_section_class_sefl input[type="text"]').each(function () {
        if (jQuery(this).parent().find('.err').length < 1) {
            jQuery(this).after('<span class="err"></span>');
        }
    });

    /*
     * Show Note Message on Connection Settings Page
     */

    jQuery('.connection_section_class_sefl .form-table').before("<div class='warning-msg'><p>Note! You must have an Southeastern LTL Freight account to use this application. if you don't have one, contact Southeastern LTL Freight.</p></div>");

    /*
    * Add maxlength Attribute on Handling Fee Quote Setting Page
    */

    jQuery("#sefl_handling_fee").attr('maxlength', '8');


    /*
    * Add maxlength Attribute on Connection Setting Page
    */

    jQuery("#customer_state_sefl").attr('maxlength', '2');
    jQuery("#customer_zip_code_sefl").attr('maxlength', '8');


    /*
     * Add Title To Connection Setting Fields
     */
    jQuery('#wc_settings_sefl_username').attr('title', 'Username');
    jQuery('#wc_settings_sefl_password').attr('title', 'Password');
    jQuery('#wc_settings_sefl_accountno').attr('title', 'Customer Account Number');

    jQuery('#wc_settings_sefl_billing_accountno').attr('title', '3rd Party Billing Account Number');
    jQuery('#wc_settings_sefl_billing_accountno').attr('data-optional', '1');

    jQuery('#wc_settings_sefl_plugin_licence_key').attr('title', 'Eniture API Key ');
    jQuery('#customer_name_sefl').attr('title', 'Customer Name');
    jQuery('#customer_street_address_sefl').attr('title', 'Customer Street Address');
    jQuery('#customer_city_sefl').attr('title', 'Customer City');
    jQuery('#customer_state_sefl').attr('title', 'Customer State');
    jQuery('#customer_zip_code_sefl').attr('title', 'Customer Zip Code');

    /*
     * Add Title To Qoutes Setting Fields
     */

    jQuery('#sefl_label_as').attr('title', 'Label As');
    jQuery('#sefl_label_as').attr('maxlength', '50');
    jQuery('#sefl_handling_fee').attr('title', 'Handling Fee / Markup');

    jQuery(".connection_section_class_sefl .button-primary, .connection_section_class_sefl .is-primary").click(function () {
        var input = validateInput('.connection_section_class_sefl');
        if (input === false) {
            return false;
        }
    });

    jQuery(".connection_section_class_sefl .woocommerce-save-button").before('<a href="javascript:void(0)" class="button-primary sefl_test_connection">Test connection</a>');

    /*
     * SEFL Test connection Form Valdating ajax Request
     */

    jQuery('.sefl_test_connection').click(function (e) {
        var input = validateInput('.connection_section_class_sefl');

        if (input === false) {
            return false;
        }

        var postForm = {
            'action': 'sefl_action',
            'sefl_username': jQuery('#wc_settings_sefl_username').val(),
            'sefl_password': jQuery('#wc_settings_sefl_password').val(),
            'sefl_accountno': jQuery('#wc_settings_sefl_accountno').val(),
            'third_party_acc': jQuery('#wc_settings_sefl_billing_accountno').val(),
            'sefl_plugin_license': jQuery('#wc_settings_sefl_plugin_licence_key').val(),
            'sefl_customer_name': jQuery('#customer_name_sefl').val(),
            'sefl_customer_street_address': jQuery('#customer_street_address_sefl').val(),
            'sefl_customer_city': jQuery('#customer_city_sefl').val(),
            'sefl_customer_state': jQuery('#customer_state_sefl').val(),
            'sefl_customer_zip_code': jQuery('#customer_zip_code_sefl').val(),
            'sefl_account_type': jQuery('input[name=sefl_account_select_setting]:checked').val()

        };

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: postForm,
            dataType: 'json',

            beforeSend: function () {
                jQuery(".connection_save_button").remove();
                jQuery('#wc_settings_sefl_username, #wc_settings_sefl_password, #wc_settings_sefl_accountno, #wc_settings_sefl_billing_accountno, #wc_settings_sefl_plugin_licence_key, #customer_name_sefl, #customer_street_address_sefl, #customer_city_sefl, #customer_state_sefl, #customer_zip_code_sefl').addClass('sefl_freight_test_conn_prosessing');
            },
            success: function (data) {
                jQuery('#wc_settings_sefl_username, #wc_settings_sefl_password, #wc_settings_sefl_accountno, #wc_settings_sefl_billing_accountno, #wc_settings_sefl_plugin_licence_key, #customer_name_sefl, #customer_street_address_sefl, #customer_city_sefl, #customer_state_sefl, #customer_zip_code_sefl').removeClass('sefl_freight_test_conn_prosessing');
                jQuery(".sefl_success_message, .sefl_error_message, #message").remove();

                if (data.message === "success") {
                    jQuery('.warning-msg').before('<div class="notice notice-success sefl_success_message"><p><strong>Success! The test resulted in a successful connection.</strong></p></div>');
                } else if (data.message !== "failure" && data.message !== "success") {
                    jQuery('.warning-msg').before('<div class="notice notice-error sefl_error_message"><p>Error!  ' + data.message + ' </p></div>');
                } else {
                    jQuery('.warning-msg').before('<div class="notice notice-error sefl_error_message"><p>Error! Please verify credentials and try again.</p></div>');
                }

                jQuery('html,body').animate({scrollTop: 0}, 'slow');
            }
        });
        e.preventDefault();
    });
    // fdo va
    jQuery('#fd_online_id_sefl').click(function (e) {
        var postForm = {
            'action': 'sefl_fd',
            'company_id': jQuery('#freightdesk_online_id').val(),
            'disconnect': jQuery('#fd_online_id_sefl').attr("data")
        }
        var id_lenght = jQuery('#freightdesk_online_id').val();
        var disc_data = jQuery('#fd_online_id_sefl').attr("data");
        if(typeof (id_lenght) != "undefined" && id_lenght.length < 1) {
            jQuery(".sefl_error_message").remove();
            jQuery('.user_guide_fdo').before('<div class="notice notice-error sefl_error_message"><p><strong>Error!</strong> FreightDesk Online ID is Required.</p></div>');
            return;
        }
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: postForm,
            beforeSend: function () {
                jQuery('#freightdesk_online_id').addClass('sefl_freight_test_conn_prosessing');
            },
            success: function (data_response) {
                if(typeof (data_response) == "undefined"){
                    return;
                }
                var fd_data = JSON.parse(data_response);
                jQuery('#freightdesk_online_id').css('background', '#fff');
                jQuery(".sefl_error_message").remove();
                if((typeof (fd_data.is_valid) != 'undefined' && fd_data.is_valid == false) || (typeof (fd_data.status) != 'undefined' && fd_data.is_valid == 'ERROR')) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error sefl_error_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'SUCCESS') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-success sefl_success_message"><p><strong>Success! ' + fd_data.message + '</strong></p></div>');
                    window.location.reload(true);
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'ERROR') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error sefl_error_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if (fd_data.is_valid == 'true') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error sefl_error_message"><p><strong>Error!</strong> FreightDesk Online ID is not valid.</p></div>');
                } else if (fd_data.is_valid == 'true' && fd_data.is_connected) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error sefl_error_message"><p><strong>Error!</strong> Your store is already connected with FreightDesk Online.</p></div>');

                } else if (fd_data.is_valid == true && fd_data.is_connected == false && fd_data.redirect_url != null) {
                    window.location = fd_data.redirect_url;
                } else if (fd_data.is_connected == true) {
                    jQuery('#con_dis').empty();
                    jQuery('#con_dis').append('<a href="#" id="fd_online_id_sefl" data="disconnect" class="button-primary">Disconnect</a>')
                }
            }
        });
        e.preventDefault();
    });

    /*
     * SEFL Qoute Settings Tabs Validation
     */

    // Handling unit
    jQuery('#handling_weight_sefl').attr('maxlength', '7');
    jQuery('#maximum_handling_weight_sefl').attr('maxlength','7');
    jQuery('#handling_weight_sefl').closest('tr').addClass('sefl_residential');
    jQuery('#handling_weight_sefl').closest('td').addClass('sefl_residential');
    jQuery('#maximum_handling_weight_sefl').closest('tr').addClass('sefl_residential');
    jQuery('#maximum_handling_weight_sefl').closest('td').addClass('sefl_residential');

    jQuery("#handling_weight_sefl, #maximum_handling_weight_sefl").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)|| e.keyCode == 109) {
            // let it happen, don't do anything
            return;
        }
        
        // Ensure that it is a number and stop the keypress
        if ((e.keyCode === 190 || e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    
        if ((jQuery(this).val().indexOf('.') != -1) && (jQuery(this).val().substring(jQuery(this).val().indexOf('.'), jQuery(this).val().indexOf('.').length).length > 2)) {
            if (event.keyCode !== 8 && event.keyCode !== 46) { //exception
                event.preventDefault();
            }
        }
    });
    
    jQuery("#handling_weight_sefl, #maximum_handling_weight_sefl").keyup(function (e) {    
        var val = jQuery(this).val();
        if (val.split('.').length - 1 > 1) {
            var newval = val.substring(0, val.length - 1);
            var countDots = newval.substring(newval.indexOf('.') + 1).length;
            newval = newval.substring(0, val.length - countDots - 1);
            jQuery(this).val(newval);
        }
    });

    jQuery('.quote_section_class_sefl .woocommerce-save-button').on('click', function () {
        jQuery(".updated").hide();
        jQuery('.error').remove();
        var handling_fee = jQuery('#sefl_handling_fee').val();

        // Handling unit validations
        if (!sefl_handling_unit_validation('handling_weight_sefl')) {
            return false;
        }
        if (!sefl_handling_unit_validation('maximum_handling_weight_sefl')) {
            return false;
        }

        if (handling_fee.slice(handling_fee.length - 1) == '%') {
            handling_fee = handling_fee.slice(0, handling_fee.length - 1);
        }

        if (handling_fee === "")
            return true;
        else {
            if (isValidNumber(handling_fee) === false) {
                jQuery("#mainform .quote_section_class_sefl").prepend('<div id="message" class="error inline sefl_handlng_fee_error"><p><strong>Handling fee format should be 100.2000 or 10%.</strong></p></div>');
                jQuery('html, body').animate({
                    'scrollTop': jQuery('.sefl_handlng_fee_error').position().top
                });
                return false;
            } else if (isValidNumber(handling_fee) === 'decimal_point_err') {
                jQuery("#mainform .quote_section_class_sefl").prepend('<div id="message" class="error inline sefl_handlng_fee_error"><p><strong>Handling fee format should be 100.2000 or 10% and only 4 digits are allowed after decimal point.</strong></p></div>');
                jQuery('html, body').animate({
                    'scrollTop': jQuery('.sefl_handlng_fee_error').position().top
                });
                return false;
            } else {
                return true;
            }
        }
    });

    // Origin and product level markup fields validations
    jQuery("#en_wd_origin_markup, #en_wd_dropship_markup, ._en_product_markup").bind("cut copy paste",function(e) {
        e.preventDefault();
    });

    jQuery("#en_wd_origin_markup, #en_wd_dropship_markup, ._en_product_markup").keypress(function (e) {
        if (!String.fromCharCode(e.keyCode).match(/^[-0-9\d\.%\s]+$/i)) return false;
    });

    jQuery("#en_wd_origin_markup, #en_wd_dropship_markup, ._en_product_markup").keydown(function (e) {
        const val = jQuery(this).val();

        if ((e.keyCode === 109 || e.keyCode === 189) && (val.length > 0)) return false;
        if (e.keyCode === 53) if (e.shiftKey) if (val.length == 0) return false; 
        
        if ((val.indexOf('.') != -1) && (val.substring(val.indexOf('.'), val.indexOf('.').length).length > 2)) {
            if (e.keyCode !== 8 && e.keyCode !== 46) { //exception
                e.preventDefault();
            }
        }

        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 53, 189]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }

        // Ensure that it is a number and stop the keypress
        if (val.length > 7 || (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    jQuery("#en_wd_origin_markup, #en_wd_dropship_markup, ._en_product_markup").keyup(function (e) {

        var val = jQuery(this).val();

        if (val.length && val.includes('%')) {
            jQuery(this).val(val.substring(0, val.indexOf('%') + 1));
        }

        if (val.split('.').length - 1 > 1) {
            var newval = val.substring(0, val.length - 1);
            var countDots = newval.substring(newval.indexOf('.') + 1).length;
            newval = newval.substring(0, val.length - countDots - 1);
            jQuery(this).val(newval);
        }

        if (val.split('%').length - 1 > 1) {
            var newval = val.substring(0, val.length - 1);
            var countPercentages = newval.substring(newval.indexOf('%') + 1).length;
            newval = newval.substring(0, val.length - countPercentages - 1);
            jQuery(this).val(newval);
        }

        if (val.split('-').length - 1 > 1) {
            var newval = val.substring(0, val.length - 1);
            var countPercentages = newval.substring(newval.indexOf('-') + 1).length;
            newval = newval.substring(0, val.length - countPercentages - 1);
            jQuery(this).val(newval);
        }
    });
    
    // Product variants settings
    jQuery(document).on("click", '._nestedMaterials', function(e) {
        const checkbox_class = jQuery(e.target).attr("class");
        const name = jQuery(e.target).attr("name");
        const checked = jQuery(e.target).prop('checked');

        if (checkbox_class?.includes('_nestedMaterials')) {
            const id = name?.split('_nestedMaterials')[1];
            setNestMatDisplay(id, checked);
        }
    });

    // Callback function to execute when mutations are observed
    const handleMutations = (mutationList) => {
        let childs = [];
        for (const mutation of mutationList) {
            childs = mutation?.target?.children;
            if (childs?.length) setNestedMaterialsUI();
          }
    };
    const observer = new MutationObserver(handleMutations),
        targetNode = document.querySelector('.woocommerce_variations.wc-metaboxes'),
        config = { attributes: true, childList: true, subtree: true };
    if (targetNode) observer.observe(targetNode, config);

});

// Weight threshold for LTL freight
if (typeof en_weight_threshold_limit != 'function') {
    function en_weight_threshold_limit() {
        // Weight threshold for LTL freight
        jQuery("#en_weight_threshold_lfq").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g) || !jQuery("#en_weight_threshold_lfq").val().match(/^\d{0,3}$/)) return false;
        });

        jQuery('#en_plugins_return_LTL_quotes').on('change', function () {
            if (jQuery('#en_plugins_return_LTL_quotes').prop("checked")) {
                jQuery('tr.en_weight_threshold_lfq').css('display', 'contents');
            } else {
                jQuery('tr.en_weight_threshold_lfq').css('display', 'none');
            }
        });

        jQuery("#en_plugins_return_LTL_quotes").closest('tr').addClass("en_plugins_return_LTL_quotes_tr");
        // Weight threshold for LTL freight
        var weight_threshold_class = jQuery("#en_weight_threshold_lfq").attr("class");
        jQuery("#en_weight_threshold_lfq").closest('tr').addClass("en_weight_threshold_lfq " + weight_threshold_class);

        // Weight threshold for LTL freight is empty
        if (jQuery('#en_weight_threshold_lfq').length && !jQuery('#en_weight_threshold_lfq').val().length > 0) {
            jQuery('#en_weight_threshold_lfq').val(150);
        }
    }
}

// Update plan
if (typeof en_update_plan != 'function') {
    function en_update_plan(input) {
        let action = jQuery(input).attr('data-action');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: action},
            success: function (data_response) {
                window.location.reload(true);
            }
        });
    }
}

/*
         * SEFL Form Validating Inputs
         */
function validateInput(form_id) {
    var has_err = true;
    jQuery(form_id + " input[type='text']").each(function () {
        var input = jQuery(this).val();
        var response = validateString(input);
        var errorText = jQuery(this).attr('title');
        var optional = jQuery(this).data('optional');

        var errorElement = jQuery(this).parent().find('.err');
        jQuery(errorElement).html('');

        optional = (optional === undefined) ? 0 : 1;
        errorText = (errorText != undefined) ? errorText : '';

        if ((optional == 0) && (response == false || response == 'empty')) {
            errorText = (response == 'empty') ? errorText + ' is required.' : 'Invalid input.';
            jQuery(errorElement).html(errorText);
        }
        has_err = (response != true && optional == 0) ? false : has_err;
    });
    return has_err;
}

/*
 * SEFL Validating Numbers
 */
function isValidNumber(value, noNegative) {
    if (typeof (noNegative) === 'undefined') noNegative = false;
    var isValidNumber = false;
    var validNumber = (noNegative == true) ? parseFloat(value) >= 0 : true;
    if ((value == parseInt(value) || value == parseFloat(value)) && (validNumber)) {
        if (value.indexOf(".") >= 0) {
            var n = value.split(".");
            if (n[n.length - 1].length <= 4) {
                isValidNumber = true;
            } else {
                isValidNumber = 'decimal_point_err';
            }
        } else {
            isValidNumber = true;
        }
    }
    return isValidNumber;
}

/*
 * SEFL Validating String
 */
function validateString(string) {
    if (string == '')
        return 'empty';
    else
        return true;

}

/**
 * Read a page's GET URL variables and return them as an associative array.
 */
function get_url_vars_sefl_freight() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

// Nesting
function sefl_lfq_stop_special_characters(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if (jQuery.inArray(e.keyCode, [46, 9, 27, 13, 110, 190, 189]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        e.preventDefault();
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 90)) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 186 && e.keyCode != 8) {
        e.preventDefault();
    }
    if (e.keyCode == 186 || e.keyCode == 190 || e.keyCode == 189 || (e.keyCode > 64 && e.keyCode < 91)) {
        e.preventDefault();
        return;
    }
}

function sefl_handling_unit_validation(field) {
    var handling_unit = jQuery('#' + field).val();
    var handling_unit_regex = /^([0-9]{1,4})*(\.[0-9]{0,2})?$/;
    const title = field == 'handling_weight_sefl' ? 'Weight of Handling Unit' : 'Maximum Weight per Handling Unit';
    
    if (handling_unit != '' && !handling_unit_regex.test(handling_unit)) {
        jQuery("#mainform .quote_section_class_sefl").prepend('<div id="message" class="error inline sefl_handlng_fee_error"><p><strong>Error! </strong>' + title + ' format should be 100.20 or 10 and only 2 digits are allowed after decimal.</p></div>');
        jQuery('html, body').animate({
            'scrollTop': jQuery('.sefl_handlng_fee_error').position().top
        });

        return false;
    } else {
        return true;
    }
}

if (typeof setNestedMaterialsUI != 'function') {
    function setNestedMaterialsUI() {
        const nestedMaterials = jQuery('._nestedMaterials');
        const productMarkups = jQuery('._en_product_markup');
        
        if (productMarkups?.length) {
            for (const markup of productMarkups) {
                jQuery(markup).attr('maxlength', '7');

                jQuery(markup).keypress(function (e) {
                    if (!String.fromCharCode(e.keyCode).match(/^[0-9.%-]+$/))
                        return false;
                });
            }
        }

        if (nestedMaterials?.length) {
            for (let elem of nestedMaterials) {
                const className = elem.className;

                if (className?.includes('_nestedMaterials')) {
                    const checked = jQuery(elem).prop('checked'),
                        name = jQuery(elem).attr('name'),
                        id = name?.split('_nestedMaterials')[1];
                    setNestMatDisplay(id, checked);
                }
            }
        }
    }
}

if (typeof setNestMatDisplay != 'function') {
    function setNestMatDisplay (id, checked) {
        
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('min', '0');
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('max', '100');
        jQuery(`input[name="_nestedPercentage${id}"]`).attr('maxlength', '3');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('min', '0');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('max', '100');
        jQuery(`input[name="_maxNestedItems${id}"]`).attr('maxlength', '3');

        jQuery(`input[name="_nestedPercentage${id}"], input[name="_maxNestedItems${id}"]`).keypress(function (e) {
            if (!String.fromCharCode(e.keyCode).match(/^[0-9]+$/))
                return false;
        });

        jQuery(`input[name="_nestedPercentage${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`select[name="_nestedDimension${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`input[name="_maxNestedItems${id}"]`).closest('p').css('display', checked ? '' : 'none');
        jQuery(`select[name="_nestedStakingProperty${id}"]`).closest('p').css('display', checked ? '' : 'none');
    }
}