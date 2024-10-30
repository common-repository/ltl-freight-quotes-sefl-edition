<?php
/**
 * SEFL WooComerce | Warehouse Page
 * @package     Woocommerce SEFL Edition
 * @author      <https://eniture.com/>
 * @copyright   Copyright (c) 2017, Eniture
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

global $wpdb;
$warehous_list = $wpdb->get_results(
    "SELECT * FROM ".$wpdb->prefix."warehouse WHERE location = 'warehouse'"
);
?>
<script type="text/javascript">
    jQuery( document ).ready(function() {
        window.location.href = jQuery('.close').attr('href');
        
        function setCity(e)
        {
            var city = jQuery(e).val();
            jQuery('#sefl_origin_city').val(city);
        }
    
        jQuery( '.hide_val' ).click( function () {
            
            jQuery( '#edit_form_id, #sefl_origin_zip, #sefl_origin_city, #sefl_origin_state, #sefl_origin_country' ).val( '' );
            jQuery( '.city_input' ).show();
            jQuery( '#sefl_origin_city' ).css( 'background', 'none' );
            jQuery( '.city_select, .sefl_zip_validation_err, .sefl_city_validation_err, .sefl_state_validation_err, .sefl_country_validation_err, .not_allowed, .already_exist, .sefl_warehouse_invalid_input_message, .wrng_credential' ).hide();
        });

        jQuery('.sefl_add_warehouse_btn').click(function(){
            setTimeout(function(){
                if(jQuery('.sefl_add_warehouse_popup').is(':visible'))
                {
                    jQuery('.sefl_add_warehouse_input > input').eq(0).focus();
                }
            },500);
        });

          jQuery( "#sefl_origin_zip" ).on('change', function() {
              
            if (jQuery( "#sefl_origin_zip" ).val() == ''){ 
                return false;
            }
            
            jQuery( '#sefl_origin_city, #sefl_origin_state, .city_select_css, #sefl_origin_country' ).css('background', 'rgba(255, 255, 255, 1) url("<?php echo plugins_url(); ?>/ltl-freight-quotes-sefl-edition/warehouse-dropship/wild/assets/images/processing.gif") no-repeat scroll 50% 50%');
            
            var postForm = {
                'action'      : 'sefl_get_address',
                'origin_zip'  : jQuery('#sefl_origin_zip').val()
            };

            jQuery.ajax({
                type      : 'POST', 
                url       : ajaxurl, 
                data      : postForm, 
                dataType  : 'json',
                
                beforeSend: function () 
                {
                    jQuery( '.sefl_zip_validation_err, .sefl_city_validation_err, .sefl_state_validation_err, .sefl_country_validation_err' ).hide();
                },
                success: function (data) 
                { 
                    if( data )
                    {
                        if( data.country === 'US' || data.country === 'CA' )
                        {
                            if (data.postcode_localities == 1) 
                            {
                                jQuery( '.city_select' ).show();
                                jQuery( '#actname' ).replaceWith( data.city_option );
                                jQuery( '.sefl_multi_state' ).replaceWith( data.city_option );
                                jQuery( '.city-multiselect' ).change( function(){
                                    setCity(this);
                                });
                                jQuery( '#sefl_origin_city' ).val( data.first_city );
                                jQuery( '#sefl_origin_state' ).val( data.state );
                                jQuery( '#sefl_origin_country' ).val( data.country );
                                jQuery( '#sefl_origin_state, .city_select_css, #sefl_origin_country' ).css('background', 'none');  
                                jQuery( '.city_input' ).hide();
                            }
                            else
                            {
                                jQuery( '.city_input' ).show();
                                jQuery( '#_city' ).removeAttr('value');
                                jQuery( '.city_select' ).hide();
                                jQuery( '#sefl_origin_city' ).val( data.city );
                                jQuery( '#sefl_origin_state' ).val( data.state );
                                jQuery( '#sefl_origin_country' ).val( data.country );
                                jQuery( '#sefl_origin_city, #sefl_origin_state, #sefl_origin_country' ).css('background', 'none');   
                            }
                        }
                        else if( data.result === 'false' )
                        {
                            jQuery( '.not_allowed' ).show('slow');
                            jQuery( '#sefl_origin_city, #sefl_origin_state, #sefl_origin_country' ).css('background', 'none');   
                            setTimeout(function () {
                                jQuery('.not_allowed').hide('slow');
                            }, 5000);
                        }
                        else if( data.apiResp === 'apiErr' )
                        {
                            jQuery( '.wrng_credential' ).show('slow');
                            jQuery( '#sefl_origin_city, #sefl_origin_state, #sefl_origin_country' ).css('background', 'none');    
                            setTimeout(function () {
                                jQuery('.wrng_credential').hide('slow');
                            }, 5000);
                        }
                        else
                        {
                            jQuery( '.not_allowed' ).show('slow');
                            jQuery( '#sefl_origin_city, #sefl_origin_state, #sefl_origin_country' ).css('background', 'none');   
                            setTimeout(function () {
                                jQuery('.not_allowed').hide('slow');
                            }, 5000);
                        }
                    }
                }
            }); 
            return false;
        });
    });
    
    jQuery(function() {
        jQuery('input.alphaonly').keyup(function() {
            var location_field_id = jQuery(this).attr("id");
            var location_regex = location_field_id == 'en_wd_origin_city' || location_field_id == 'en_wd_dropship_city' ? /[^a-zA-Z-]/g : /[^a-zA-Z]/g;
            if (this.value.match(location_regex)) {
                this.value = this.value.replace(location_regex, '');
            }
        });
    });
</script>

    <div class="sefl_warehouse_section">
    <h1>Warehouses</h1><br>
    <a href="#sefl_add_warehouse_btn" title="Add Warehouse" class="sefl_add_warehouse_btn hide_val hoveraffect" name="avc">Add</a>
    <br>
    <div class="warehouse_text">
        <p>Warehouses that inventory all products not otherwise identified as drop shipped items. The warehouse with the lowest shipping cost to the destination is used for quoting purposes.</p>
    </div>
    <div id="message" class="updated inline warehouse_deleted">
        <p><strong>Success! Warehouse deleted successfully.</strong></p>
    </div>
    <div id="message" class="updated inline warehouse_created">
        <p><strong>Success! New warehouse added successfully.</strong></p>
    </div>
    <div id="message" class="updated inline warehouse_updated">
        <p><strong>Success! Warehouse updated successfully.</strong></p>
    </div>
    <table class="sefl_warehouse_list" id="append_warehouse">
        <thead>
            <tr>
                <th class="sefl_warehouse_list_heading">City</th>
                <th class="sefl_warehouse_list_heading">State</th>
                <th class="sefl_warehouse_list_heading">Zip</th>
                <th class="sefl_warehouse_list_heading">Country</th>
                <th class="sefl_warehouse_list_heading">Action</th>
            </tr>
        </thead>
        <tbody>
<?php
    if ( count( $warehous_list ) > 0 ) 
    {
        foreach ( $warehous_list as $list ) 
        {
?>
            <tr id="row_<?php echo ( isset($list->id) ) ? esc_attr( $list->id ) : ''; ?>" data-id="<?php echo ( isset($list->id) ) ? esc_attr( $list->id ) : ''; ?>">
                <td class="sefl_warehouse_list_data"><?php echo ( isset( $list->city ) )    ? esc_attr( $list->city )    : ''; ?></td>
                <td class="sefl_warehouse_list_data"><?php echo ( isset( $list->state ) )   ? esc_attr( $list->state )   : ''; ?></td>
                <td class="sefl_warehouse_list_data"><?php echo ( isset( $list->zip ) )     ? esc_attr( $list->zip )     : ''; ?></td>
                <td class="sefl_warehouse_list_data"><?php echo ( isset( $list->country ) ) ? esc_attr( $list->country ) : ''; ?></td>
                <td class="sefl_warehouse_list_data">
                <a href="javascript(0)" onclick="return sefl_edit_warehouse(<?php echo ( isset( $list->id ) ) ? esc_attr( $list->id ) : ''; ?>);"><img src="<?php echo plugins_url(); ?>/ltl-freight-quotes-sefl-edition/warehouse-dropship/wild/assets/images/edit.png" title="Edit"></a>
                <a href="javascript(0)" onclick="return sefl_delete_current_warehouse(<?php echo ( isset( $list->id ) ) ? esc_attr( $list->id ) : ''; ?>);"><img src="<?php echo plugins_url(); ?>/ltl-freight-quotes-sefl-edition/warehouse-dropship/wild/assets/images/delete.png" title="Delete"></a></td>
            </tr>
<?php 
        }
    }
    else
    { 
?>
            <tr class="new_warehouse_add" data-id=0></tr>
<?php
    }
?>
        </tbody>
    </table>

    <!-- Add Popup for new warehouse -->
    <div id="sefl_add_warehouse_btn" class="sefl_warehouse_overlay">
        <div class="sefl_add_warehouse_popup">
            <h2 class="warehouse_heading">Warehouse</h2>
            <a class="close seflHideInfo" href="#">&times;</a>
            <div class="content">
                <div class="already_exist">
                   <strong>Error!</strong> Zip code already exists.
                </div>
                 <div class="sefl_warehouse_invalid_input_message">
                    <strong> Error! </strong> Invalid input data.
                </div>
                <div class="not_allowed">
                  <p><strong>Error!</strong> Please enter US / CA zip code.</p>
                </div>
                <div class="wrng_credential">
                  <p><strong>Error!</strong> Please verify credentials at connection settings panel.</p>
                </div>
                <form method="post">
                    <input type="hidden" name="edit_form_id" value="" id="edit_form_id">
                    <div class="sefl_add_warehouse_input">
                        <label for="sefl_origin_zip">Zip</label>
                        <input type="text" title="Zip" value="" name="sefl_origin_zip" maxlength="7" placeholder="30214" id="sefl_origin_zip">
                    </div>

                    <div class="sefl_add_warehouse_input city_input">
                        <label for="sefl_origin_city">City</label>
                        <input type="text" value="" title="City" name="sefl_origin_city" placeholder="Fayetteville" id="sefl_origin_city">
                    </div>

                    <div class="sefl_add_warehouse_input city_select" title="City" style="display:none;">
                        <label for="sefl_origin_city">City</label>
                        <select id="actname"></select>
                    </div>

                    <div class="sefl_add_warehouse_input">
                        <label for="sefl_origin_state">State</label>
                        <input type="text" value="" title="State" class="alphaonly" maxlength="2" name="sefl_origin_state" placeholder="GA" id="sefl_origin_state">
                    </div>

                    <div class="sefl_add_warehouse_input">
                        <label for="sefl_origin_country">Country</label>
                        <input type="text" title="Country" class="alphaonly" maxlength="2" name="sefl_origin_country" value="" placeholder="US" id="sefl_origin_country">
                        <input type="hidden" name="sefl_location" value="warehouse" id="sefl_location">
                    </div>
                    <input type="submit" name="sefl_submit_warehouse" value="Save" class="save_warehouse_form" onclick="return sefl_save_warehouse();">
                </form>
            </div>
        </div>
    </div>

