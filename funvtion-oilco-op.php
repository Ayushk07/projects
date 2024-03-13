<?php 

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 

function my_enqueue_assets() { 

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' ); 

}


add_filter('add_to_cart_redirect', 'cw_redirect_add_to_cart');
function cw_redirect_add_to_cart() {
    global $woocommerce;
    $cw_redirect_url_checkout = $woocommerce->cart->get_checkout_url();
    return $cw_redirect_url_checkout;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'cw_btntext_cart' );
add_filter( 'woocommerce_product_add_to_cart_text', 'cw_btntext_cart' );
function cw_btntext_cart() {
    return __( 'Go To Checkout', 'woocommerce' );
}

function dequeue_jquery_ui_tabs() {
    if ( ! is_account_page() || ! is_wc_endpoint_url( 'payment-methods' ) ) {
        return;
    }
    wp_dequeue_script( 'jquery-ui-tabs' );
    wp_dequeue_script( "jquery-ui-dialog" );
    wp_dequeue_script( 'jquery-ui-core' );
	wp_dequeue_script( 'jquery-ui-sortable' );
	wp_dequeue_script( 'jquery-ui-widget' );
	wp_dequeue_script( 'jquery-ui-resizable' );
	wp_dequeue_script( 'jquery-effects-core' );
    wp_dequeue_script( 'layout'); 						
	wp_dequeue_script( 'locale'); 						
	wp_dequeue_script( 'jqgrid'); 						
	wp_dequeue_script( 'jqplot');						
	wp_dequeue_script( 'jqplot-json2');					
	wp_dequeue_script( 'jqplot-barRenderer'); 			
	wp_dequeue_script( 'jqplot-categoryAxisRenderer');
	wp_dequeue_script( 'jqplot-pointLabels'); 			
    wp_dequeue_script( 'datatable');       
	wp_dequeue_script( 'tablednd');		        
	wp_dequeue_script( 'addons');		       
	wp_dequeue_script( 'dataTables');
    echo "<script>console.log('heelo');</script>";
}
add_action( 'wp_enqueue_scripts', 'dequeue_jquery_ui_tabs', 100 );

function quantity_wp_head() {
       
    if ( is_product() ) {
        ?>
        <style type="text/css">
        .quantity,
        .buttons_added {
            width: 0;
            height: 0;
            display: none;
            visibility: hidden;
        }
        </style>
    <?php
    }
}
add_action( 'wp_head', 'quantity_wp_head' );

function nav_menu_description( $item_output, $item, $depth, $args ) {
  if ( !empty( $item->description ) ) {
   $item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
 }
return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'nav_menu_description', 10, 4 );

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );




/**
 * 
 * Avlabs Customization Start
 * 
 */

/**
 * 
 * Create Shortcode
 * Features: Subscription Form, Join Uers
 * 
 */


//Text Domain
define( 'OILCO_TEXT_DOMAIN', 'oilco-avlabs' );

add_shortcode('join_subscription','avlabs_join_subscription');
function avlabs_join_subscription(){
    global $wpdb;

    if ( !class_exists( 'WooCommerce' ) ) {
        return true;
    }

    if(current_user_can('editor') || current_user_can('administrator') || !is_user_logged_in())
    {       
   
    ob_start();

    $args = array(
        'status'        => 'publish',
        'type'          => array('subscription','variable-subscription'),
        'limit'         => -1,
        'orderby'       => 'date',
        'order'         => 'DESC'
    );
    
    $query = new WC_Product_Query($args);
    
    $products = $query->get_products();
    
    $filtered_products = array_filter($products, function($product) {
        $price = $product->get_price();
        return ($price > 0);
    });
    

    $product_info = array();

    if(!empty($filtered_products)) : 

        foreach( $filtered_products as $product ) {
        
            $product_id   = $product->get_id();
        
            $product_name = $product->get_name();
            
            $price = wc_price($product->get_price());
        
            $product_info[$product_id] = $product_name . ' - ' . $price;        
        }

        ?>

        <form id="oilcorp_registration" method="post">
            <div class="oc_container">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Membership Plans <span>*</span></label>
                        <div class="element"><select name="membership_product_id" required>
                            <?php foreach($product_info as $pid => $membership_name){
                                $selected = '';
                                if($pid == '1851'){
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $pid . '" '.$selected.'>' . $membership_name . '</option>';
                            }?>
                        </select></div>
                        <div class="sub">
                            <span>* Senior Membership is for members ages 55 & older.</span>
                        </div>
                        <div class="sub">
                            <span>* Low Volume Membership requires an annual volume of under 300 gallons annually</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="element"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-xs-6">
                        <label>Processing Fee: </label>
                    </div>
                    <div class="col-sm-8 col-xs-6">
                        <div class="element"><strong>$10.00</strong></div>
                    </div>
    
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Name <span>*</span></label>
                    </div>
                    <div class="col-sm-5 sm-mb-10">
                        <div class="element"><input type="text" name="first_name" placeholder="First Name" required /></div>
                    </div>
                    <div class="col-sm-2 sm-mb-10">
                        <div class="element"><input type="text" name="middle_name" placeholder="MI" /></div>
                    </div>
                    <div class="col-sm-5 sm-mb-10">
                        <div class="element"><input type="text" name="last_name" placeholder="Last Name" /></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-8 no_right_padding">
                        <label>Home address <span>*</span></label>
                        <div class="element">
                            <div class="col-sm-12"><input type="text" name="address_1" id="address_1" placeholder="Address Line 1" required />
                            </div>
                            <div class="col-sm-4"><input type="text" name="city" id="city" placeholder="City" required /></div>
                            <div class="col-sm-4">
                                <select name="state" id="state" required>
                                    <?php echo avlabs_join_field_type_options('state','');?>
                                </select>
                            </div>
                            <div class="col-sm-4"><input type="text" name="zip" id="zip" placeholder="Zip" required /></div>
                            <span id="zip-error" class="error"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Mailing Address Same as Home</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="same_mailing_address" value="1" checked /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="same_mailing_address" value="0" /> No</div>
                        </div>
                    </div>
                </div>

                <div class="form-group row hidden mailing_section">
                    <div class="col-sm-12">
                        <label>Mailing address</label>
                        <div class="element">
                            <div class="col-sm-12 no_right_padding"><input type="text" name="mailing_address_1" id="mailing_address_1"
                                    placeholder="Address Line" /></div>
                            <div class="col-sm-4 no_right_padding_mb"><input type="text" name="mailing_city" id="mailing_city" placeholder="City" /></div>
                            <div class="col-sm-4 no_right_padding_mb">
                                <select name="mailing_state" id="mailing_state">
                                    <?php echo avlabs_join_field_type_options('state','');?>
                                </select>
                            </div>
                            <div class="col-sm-4 no_right_padding"><input type="text" name="mailing_zip_code" id="mailing_zip_code" placeholder="Zip" /></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Email <span>*</span></label>
                        <div class="element"><input type="email" name="email" required /></div>
                    </div>
                    
                </div>

                <div class="form-group row">

                    <div class="col-sm-3">
                        <label>Primary Phone <span>*</span></label>
                        <div class="element"><input type="tel" name="phone" required /></div>
                    </div>
                    <div class="col-sm-3">
                        <label>Primary Phone Type</label>
                        <div class="element">
                            <select name="primary_phone_type">
                                <option value="cell" seleceted>CELL</option>
                                <option value="home">HOME</option>
                                <!-- <option value="fax">FAX</option> -->
                                <option value="business">BUSINESS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>Secondary Phone</label>
                        <div class="element"><input type="tel" name="secondary_phone" /></div>
                    </div>
                    <div class="col-sm-3">
                        <label>Secondary Phone Type</label>
                        <div class="element">
                            <select name="second_phone">
                                <option value="cell">CELL</option>
                                <option value="home" seleceted>HOME</option>
                                <!-- <option value="fax">FAX</option> -->
                                <option value="business">BUSINESS</option>
                            </select>
                        </div>
                    </div>
                </div>                    

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in discounted oil deliveries</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_oil_del" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_oil_del" value="0" checked /> No</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Current Oil Provider (optional) </label>
                        <div class="element"><input type="text" name="current_oil_provider" placeholder="Optional" /></div>
                    </div>
                </div>
                <div class="form-group row hidden current_pro_oil">
                    <div class="col-sm-12">
                        <label>I would like to stay with my current oil provider if they participate in the Co-op</label>
                        <div class="element">
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_oil_provider" value="1" /> Yes</div>
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_oil_provider" value="0" checked /> No</div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in discounted propane deliveries</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_propane_del" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_propane_del" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Current Propane Provider (optional) </label>
                        <div class="element"><input type="text" name="current_propane_provider" placeholder="Optional" /></div>
                    </div>
                </div>                
                
                <div class="form-group row hidden current_pro_propane">
                    <div class="col-sm-12">
                        <label>I would like to stay with my current propane provider if they participate in the Co-op</label>
                        <div class="element">
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_propane_provider" value="1" /> Yes</div>
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_propane_provider" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in FREE solar consultation for my home</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_free_solar_con" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_free_solar_con" value="0" checked />
                                No</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>I'm interested in home energy audit</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_energy_audit" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_energy_audit" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I would like FREE home or auto insurance quote</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_h_a_insurance" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_h_a_insurance" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Did a member or organization refer you?</label>
                        <div class="element"><input type="text" name="who_refer_you" placeholder="Optional" /></div>
                        <div class="sub"><span>Please enter the Oil Co-op members full name so we can make sure that they get the credit! Thanks!</span></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Are you affiliated with any organizations that might want to know about the Co-op?</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="affiliated_organization" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="affiliated_organization" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Organization(s)</label>
                        <div class="element"><input type="text" name="organization" placeholder="Optional" /></div>
                    </div>
                </div>

                <div class="form-group row oilco-join-btn-outer">
                    <div class="col-sm-6">
                        <input type="submit" name="submit" class="oilco-join-btn" value="Join the Co-op" />
                    </div>
                </div>

                <input type="hidden" name="op_membership_" value="1">

            </div>
        </form>   
        
        <script>
            jQuery('#zip').on('input', function(e) {
                
                var zipValue = jQuery(this).val();
                var zipError = jQuery('#zip-error');
                var isValid = /^\d{5}(-\d{4})?$/.test(zipValue);

                if (isValid || zipValue.length === 5) {
                    zipError.text('');
                } else {
                    zipError.text('Invalid ZIP format. Correct format: 12345 or 12345-1234');
                }
            });

            jQuery('.oilco-join-btn').on('click', function(e){
                    var zipError = $('#zip-error');
                    let text = "Is this your correct billing zip code?";                

                    if (zipError.text().trim() !== '') {
                        e.preventDefault();
                        window.stop();
                    } else {
                        if (confirm(text) == true) {                              
                        
                        }else{
                            e.preventDefault();
                            window.stop();
                        }
                    }
            });
        </script>
        <?php 
        endif; 
    }
    else
    {
        if ( is_user_logged_in() )
        {
            $user = wp_get_current_user();
            $display_name = $user->display_name;
            return '<p>Hello '.$display_name.'<br>You can Edit your profile from <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="My Account">Member Dashboard</a></p>';
            
        } 
    }

    

    $data = ob_get_clean();

    return $data;
}

/**
 * 
 * Join Subscrition for handler
 * Add product in cart
 * Move user on checkout
 *  
 */
add_action( 'template_redirect', 'add_product_to_cart' );
function add_product_to_cart() {

	if( defined('DOING_AJAX') ) {
		return true;
	}

	if( is_admin() ) {
		return true;
	}

    if ( !class_exists( 'WooCommerce' ) ) {
        return true;
    }

    global $post;

    $product_id = ( isset( $_POST['membership_product_id'] ) && !empty( $_POST['membership_product_id'] ) ) ? $_POST['membership_product_id'] : 0;

    if( empty( $product_id ) ) {
		return true;
	}

    if( !isset($_POST['op_membership_'] ) || isset($_POST['op_membership_'] ) && empty( $_POST['op_membership_'] ) ) {
		return true;
	}

    $join_data = $_POST;

    unset($join_data['op_membership_']);

    $found = false;
    $current_item_key = false;

    /* check if product already in cart */
    if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
        
        foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $_product = $values['data'];
            if ( $_product->get_id() == $product_id ){
                $found = true;
                $current_item_key = $cart_item_key;
            }else{
                WC()->cart->remove_cart_item( $cart_item_key );
            }
                
        }
        
        /* if product not found, add it */
        if ( ! $found ){
            $current_item_key = WC()->cart->add_to_cart( $product_id );
        }
            
    } else {

        /*  if no products in cart, add it */
        $current_item_key = WC()->cart->add_to_cart( $product_id );

    }


    /* Set Post Join Data in Cart */
    $cart = WC()->cart->cart_contents;
    foreach( $cart as $cart_item_id=>$cart_item ) {

        if($current_item_key == $cart_item_id){
        
            $cart_item['user_join_data'] = $join_data;
            WC()->cart->cart_contents[$cart_item_id] = $cart_item;

        }
        
    }
    WC()->cart->set_session();

    /* Redirect user on Checkout page.  */
    wp_redirect( wc_get_checkout_url() );

    exit;
	
}


add_filter( 'default_checkout_billing_state', 'change_default_checkout_state' );

function change_default_checkout_state() {

    $join_data = array();

    $cart = WC()->cart->cart_contents;

    foreach( $cart as $cart_item_id=>$cart_item ) {

        if(isset( $cart_item['user_join_data'] ) ) {

            $join_data = ( isset($cart_item['user_join_data'] ) ? $cart_item['user_join_data'] : array() );
            //echo '<pre>';print_r($join_data);echo '</pre>';
        }        
    }

    if( !empty( $join_data ) ){

        return $join_data['state'];    
    }else{
        return '';
    }  
}


/**
 * @param fields object $fields
 * Set default value
 */
add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
function default_values_checkout_fields( $fields ) {

    $join_data = array();

    $cart = WC()->cart->cart_contents;

    foreach( $cart as $cart_item_id=>$cart_item ) {

        if(isset( $cart_item['user_join_data'] ) ) {

            $join_data = ( isset($cart_item['user_join_data'] ) ? $cart_item['user_join_data'] : array() );

            //echo '<pre>';print_r($join_data);echo '</pre>';

        }
        
    }

    if( !empty( $join_data ) ){
        
        $checklist = array(
            'billing_first_name'    =>  'first_name',
            'billing_last_name'     =>  'last_name',
            'billing_company'       =>  'organization',
            'billing_address_1'     =>  'address_1',
            'billing_city'          =>  'city',
            //'billing_state'         =>  'state',
            'billing_postcode'      =>  'zip',
            'billing_email'         =>  'email',
            'billing_phone'         =>  'phone',
            'billing_phone_type'    =>  'primary_phone_type'
        );
            
        foreach($checklist as $field_key => $fieldname ){

            if(isset($fields['billing'][$field_key])){

                $fields['billing'][$field_key]['default'] = $join_data[$fieldname];

            }
        }
    }
         
    return $fields;

}

/**
 * 
 * @param ID object $order_id
 * Update User Meta After a Successful Order - WooCommerce
 * 
 */
add_action( 'woocommerce_checkout_update_order_meta', 'avlabs_checkout_save_user_meta', 10,1 );
function avlabs_checkout_save_user_meta( $order_id ) {

    $order = wc_get_order( $order_id );

    $user_id = $order->get_user_id();

    foreach ( $order->get_items() as $item_id => $item ) {

        
        $user_join_data = $item->get_meta( 'user_join_data' );

        if( !empty( $user_join_data ) ){

            foreach( $user_join_data as $mk => $mv ){

                update_user_meta( $user_id, $mk, $mv );

            }

            update_post_meta( $order_id , 'user_join_data' , $user_join_data );

        }

    }

}

/**
 * @param item object $item
 * @param key of item $cart_item_key
 * @param value object $values
 * @param order object $order
 * Save custom field as order item meta
 * 
 */
add_action('woocommerce_checkout_create_order_line_item', 'avlabs_add_date_order_meta', 10, 4 );
function avlabs_add_date_order_meta( $item, $cart_item_key, $values, $order ) {

    // Ensure the product supports our custom field
    if ( array_key_exists( 'user_join_data',$values ) ) {

        // Retrieve the date which was assigned previously
        $join_data = $values['user_join_data'];
        
        // If the date is available, save it as item metadata. Otherwise use a default value (optional).
        // Note that item meta key can have uppercase characters and spaces. This is not a slug or HTML id.
        
        if ( $join_data ){
            
            unset($join_data['submit']);
            
            $item->update_meta_data( 'user_join_data', $join_data );
            
        } 

    }

}

/**
 * @param Order object $order
 * woo order edit in admin
 * get custom item meta in admin
 */
add_action( 'woocommerce_admin_order_data_after_order_details', 'avlabs_editable_order_meta_general' );
function avlabs_editable_order_meta_general( $order ){  

    // echo "Test";

	if(!is_admin()) return;

    $n = get_post_meta($order->get_ID(),'user_join_data',true);
    if($n){
        //        echo '<pre>';print_r($n);echo '</pre>';
    }

   /*  foreach ( $order->get_items() as $item_id => $item ) {

        
        $user_join_data = $item->get_meta('user_join_data');

        //echo '<pre>';print_r($user_join_data);echo '</pre>';
    } */
 
}

/**
 * 
 * @param User object $user
 * Display and Edit Custom Join field
 *  
 */
add_action( 'show_user_profile', 'avlabs_join_profile_fields' );
add_action( 'edit_user_profile', 'avlabs_join_profile_fields' );
function avlabs_join_profile_fields( $user ){ 

	$first_name                     = get_user_meta( $user->ID, 'first_name', true );
	$last_name                      = get_user_meta( $user->ID, 'last_name', true );
	$middle_name                    = get_user_meta( $user->ID, 'middle_name', true );
	$address_1                      = get_user_meta( $user->ID, 'address_1', true );
	$city                           = get_user_meta( $user->ID, 'city', true );
	$state                          = get_user_meta( $user->ID, 'state', true );
	$zip                            = get_user_meta( $user->ID, 'zip', true );
	$same_mailing_address           = get_user_meta( $user->ID, 'same_mailing_address', true );
	$mailing_address_1              = get_user_meta( $user->ID, 'mailing_address_1', true );
	$mailing_city                   = get_user_meta( $user->ID, 'mailing_city', true );
	$mailing_state                  = get_user_meta( $user->ID, 'mailing_state', true );
    $mailing_zip_code               = get_user_meta( $user->ID, 'mailing_zip_code', true );
	$email                          = $user->user_email;
	$phone                          = get_user_meta( $user->ID, 'phone', true );
	$primary_phone_type             = get_user_meta( $user->ID, 'primary_phone_type', true );
	$organization                   = get_user_meta( $user->ID, 'organization', true );
	$secondary_phone                = get_user_meta( $user->ID, 'secondary_phone', true );
	$second_phone                   = get_user_meta( $user->ID, 'second_phone', true );
	$interested_in_oil_del          = get_user_meta( $user->ID, 'interested_in_oil_del', true );
	$current_oil_provider           = get_user_meta( $user->ID, 'current_oil_provider', true );
	$staywith_oil_provider          = get_user_meta( $user->ID, 'staywith_oil_provider', true );
	$interested_in_propane_del      = get_user_meta( $user->ID, 'interested_in_propane_del', true );
	$current_propane_provider       = get_user_meta( $user->ID, 'current_propane_provider', true );
	$staywith_propane_provider      = get_user_meta( $user->ID, 'staywith_propane_provider', true );
	$interested_in_free_solar_con   = get_user_meta( $user->ID, 'interested_in_free_solar_con', true );
	$interested_in_energy_audit     = get_user_meta( $user->ID, 'interested_in_energy_audit', true );
	$interested_in_h_a_insurance    = get_user_meta( $user->ID, 'interested_in_h_a_insurance', true );
	$who_refer_you                  = get_user_meta( $user->ID, 'who_refer_you', true );
	$affiliated_organization        = get_user_meta( $user->ID, 'affiliated_organization', true );

    ?>
    <h3>Join Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="first_name">First Name</label></th>
            <td>
                <input type="text" id="first_name" value="<?php echo esc_attr( $first_name ) ?>" class="regular-text" readonly />
                <br/>
                <span class="description">User First Name</span>
            </td>
        </tr>
        <tr>
            <th><label for="middle_name">Middle Name</label></th>
            <td>
                <input type="text" name="middle_name" id="middle_name" value="<?php echo esc_attr( $middle_name ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Middle Name</span>
            </td>
        </tr>
        <tr>
            <th><label for="last_name">Last Name</label></th>
            <td>
                <input type="text" id="last_name" value="<?php echo esc_attr( $last_name ) ?>" class="regular-text" readonly/>
                <br/>
                <span class="description">User Last Name</span>
            </td>
        </tr>
        <tr>
            <th><label for="address_1">Address</label></th>
            <td>
                <input type="text" name="address_1" id="address_1" value="<?php echo esc_attr( $address_1 ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Address</span>
            </td>
        </tr>
        <tr>
            <th><label for="city">City</label></th>
            <td>
                <input type="text" name="city" id="city" value="<?php echo esc_attr( $city ) ?>" class="regular-text" />
                <br/>
                <span class="description">User City</span>
            </td>
        </tr>
        <tr>
            <th><label for="state">State</label></th>
            <td>
                <select name="state" id="state" class="regular-text" style="min-width:350px;">
                    <?php echo avlabs_join_field_type_options('state',$state);?>
                </select>
                <br/>
                <span class="description">User State</span>
            </td>
        </tr>
        <tr>
            <th><label for="zip">Zip</label></th>
            <td>
                <input type="text" name="zip" id="zip" value="<?php echo esc_attr( $zip ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Zip</span>
            </td>
        </tr>
        <tr>
            <th><label >Same Mailing Address</label></th>
            <td>
                <label><input type="radio" name="same_mailing_address" id="same_mailing_address_yes" value="1" <?php echo ($same_mailing_address == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="same_mailing_address" id="same_mailing_address_No" value="0" <?php echo ($same_mailing_address == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>
        <tr>
            <th><label for="mailing_address_1">Mailing Address</label></th>
            <td>
                <input type="text" name="mailing_address_1" id="mailing_address_1" value="<?php echo esc_attr( $mailing_address_1 ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Mailing Address</span>
            </td>
        </tr>
        <tr>
            <th><label for="mailing_city">Mailing City</label></th>
            <td>
                <input type="text" name="mailing_city" id="mailing_city" value="<?php echo esc_attr( $mailing_city ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Mailing City</span>
            </td>
        </tr>
        <tr>
            <th><label for="mailing_state">Mailing State</label></th>
            <td>
                <select name="mailing_state" id="mailing_state" class="regular-text" style="min-width:350px;">
                    <?php echo avlabs_join_field_type_options('state',$mailing_state);?>
                </select>
                <br/>
                <span class="description">User Mailing State</span>
            </td>
        </tr>
        <tr>
            <th><label for="mailing_zip_code">Mailing Zip</label></th>
            <td>
                <input type="text" name="mailing_zip_code" id="mailing_zip_code" value="<?php echo esc_attr( $mailing_zip_code ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Mailing Zip</span>
            </td>
        </tr>
        <tr>
            <th><label for="email">Email</label></th>
            <td>
                <input type="text" id="email" value="<?php echo esc_attr( $email ) ?>" class="regular-text" readonly />
                <br/>
                <span class="description">User Email</span>
            </td>
        </tr>
        <tr>
            <th><label for="phone">Phone</label></th>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( $phone ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Phone</span>
            </td>
        </tr>
        <tr>
            <th><label for="organization">Organization</label></th>
            <td>
                <input type="text" name="organization" id="organization" value="<?php echo esc_attr( $organization ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Organization</span>
            </td>
        </tr>
        <tr>
            <th><label for="primary_phone_type">Primary Phone Type</label></th>
            <td>
                <select name="primary_phone_type" id="primary_phone_type" class="regular-text" style="min-width:350px;" >
                    <?php echo avlabs_join_field_type_options('phone_type',$primary_phone_type);?>
                </select>
                <br/>
                <span class="description">User Primary Phone Type</span>
            </td>
        </tr>
        <tr>
            <th><label for="secondary_phone">Secondary Phone</label></th>
            <td>
                <input type="text" name="secondary_phone" id="secondary_phone" value="<?php echo esc_attr( $secondary_phone ) ?>" class="regular-text" />
                <br/>
                <span class="description">User Secondary Phone</span>
            </td>
        </tr>
        <tr>
            <th><label for="second_phone">Second Phone Type</label></th>
            <td>
                <select name="second_phone" id="second_phone" class="regular-text" style="min-width:350px;">
                    <?php echo avlabs_join_field_type_options('phone_type',$second_phone);?>
                </select>
                <br/>
                <span class="description">User Second Phone Type</span>
            </td>
        </tr>
        <tr>
            <th><label >Interested in discounted oil deliveriese</label></th>
            <td>
                <label><input type="radio" name="interested_in_oil_del" id="interested_in_oil_del_yes" value="1" <?php echo ($interested_in_oil_del == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="interested_in_oil_del" id="interested_in_oil_del_No" value="0" <?php echo ($interested_in_oil_del == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>
        <tr>
            <th><label for="current_oil_provider">Current Oil Provider (optional)</label></th>
            <td>
                <input type="text" name="current_oil_provider" id="current_oil_provider" value="<?php echo esc_attr( $current_oil_provider ) ?>" class="regular-text" />
                <br/>
                <span class="description">User's Current Oil Provider (optional)</span>
            </td>
        </tr>
        <tr>
            <th><label >Interested in discounted propane deliveries</label></th>
            <td>
                <label><input type="radio" name="interested_in_propane_del" id="interested_in_propane_del_yes" value="1" <?php echo ($interested_in_propane_del == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="interested_in_propane_del" id="interested_in_propane_del_No" value="0" <?php echo ($interested_in_propane_del == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>
        <tr>
            <th><label >I would like to stay with my current oil provider if they participate in the Co-op</label></th>
            <td>
                <label><input type="radio" name="staywith_oil_provider" id="staywith_oil_provider_yes" value="1" <?php echo ($staywith_oil_provider == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="staywith_oil_provider" id="staywith_oil_provider_No" value="0" <?php echo ($staywith_oil_provider == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>
        <tr>
            <th><label for="current_propane_provider">Current Propane Provider (optional)</label></th>
            <td>
                <input type="text" name="current_propane_provider" id="current_propane_provider" value="<?php echo esc_attr( $current_propane_provider ) ?>" class="regular-text" />
                <br/>
                <span class="description">User's Current Propane Provider (optional)</span>
            </td>
        </tr>
        
        <tr>
            <th><label >I would like to stay with my current oil provider if they participate in the Co-op</label></th>
            <td>
                <label><input type="radio" name="staywith_propane_provider" id="staywith_propane_provider_yes" value="1" <?php echo ($staywith_propane_provider == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="staywith_propane_provider" id="staywith_propane_provider_No" value="0" <?php echo ($staywith_propane_provider == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>
        <tr>
        <tr>
            <th><label >Interested in FREE solar consultation for my home</label></th>
            <td>
                <label><input type="radio" name="interested_in_free_solar_con" id="interested_in_free_solar_con_yes" value="1" <?php echo ($interested_in_free_solar_con == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="interested_in_free_solar_con" id="interested_in_free_solar_con_No" value="0" <?php echo ($interested_in_free_solar_con == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>            
        <tr>
            <th><label >Interested in home energy audit</label></th>
            <td>
                <label><input type="radio" name="interested_in_energy_audit" id="interested_in_energy_audit_yes" value="1" <?php echo ($interested_in_energy_audit == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="interested_in_energy_audit" id="interested_in_energy_audit_No" value="0" <?php echo ($interested_in_energy_audit == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>            
        <tr>
            <th><label >Like FREE home or auto insurance quote</label></th>
            <td>
                <label><input type="radio" name="interested_in_h_a_insurance" id="interested_in_h_a_insurance_yes" value="1" <?php echo ($interested_in_h_a_insurance == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="interested_in_h_a_insurance" id="interested_in_h_a_insurance_No" value="0" <?php echo ($interested_in_h_a_insurance == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>           
        <tr>
            <th><label for="city">Did a member or organization refer you?</label></th>
            <td>
                <input type="text" name="who_refer_you" id="who_refer_you" value="<?php echo esc_attr( $who_refer_you ) ?>" class="regular-text" />
                <br/>
                <span class="description">Did a member or organization refer you?</span>
            </td>
        </tr>           
        <tr>
            <th><label >Are you affiliated with any organizations that might want to know about the Co-op?</label></th>
            <td>
                <label><input type="radio" name="affiliated_organization" id="affiliated_organization_yes" value="1" <?php echo ($affiliated_organization == 1 ) ? 'checked' : ''; ?>  /> Yes</label> &nbsp;&nbsp;
                <label><input type="radio" name="affiliated_organization" id="affiliated_organization_No" value="0" <?php echo ($affiliated_organization == 0 ) ? 'checked' : ''; ?>  /> No</label>
            </td>
        </tr>  

    </table>

    <style>
    .address-card{
            padding: 20px;
    border: 1px solid #cecece;
    border-radius: 8px;
    font-size: 16px;
    line-height: 26px;
    }

    .adress{
        padding: 20px;
        border: 1px solid #cecece;
        border-radius: 8px;
        font-size: 16px;
        line-height: 26px;
    }
    .adress:hover{
        box-shadow: 0 0 30px #0001;
    }
    .adress p {
        padding: 0;
        margin: 0;
        margin-bottom: 7px;
    }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    button.remove-user{ font-size: 16px; padding: 6px 15px; background: linear-gradient(to bottom, #2c8400 5%, #72b352 100%); color: #fff; line-height: 20px; border: none; border-radius: 4px;}
    .heading-address {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 50px;
        padding-bottom: 25px;
        border-bottom: 1px solid #e3e3e3;
        margin-bottom: 30px;
    }
        .heading-address h3 {
        margin: 0;
        padding: 0;
    }
    .address-card-outer-admin {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 30px;
        row-gap: 30px;
        margin-bottom: 30px;
        max-width: 650px;
    }
    .save-btn-outer {
        margin-top:20px;
        text-align: center;
    }

    form#add_multiple_address input{
        width: 100%;
        margin: 5px 0 15px;
        padding: 10px;
        border-radius: 4px;
    }
    @media (max-width:576px){
        .address-card-outer-admin {
            grid-template-columns: repeat(1, 1fr);
        }
    }
    @media (max-width:425px){
        form#add_multiple_address .col-xs-6 {
        width: 100%;
    }
    }
    </style>

<div class="heading-address">
    <h3>Additional Addresses:</h3>
    
    <!-- <div class="add-address-outer">
        <button type="button" name="submit" class="add-address-btn" id="address_data_button" data-toggle="modal" data-target=".bs-example-modal-lg">+ Add Address</button>
    </div> -->
    </div>
    <?php
        global $wpdb;

        $user_id = get_current_user_id();
        $subscriptions = wcs_get_users_subscriptions($user_id);
        if ($subscriptions) {

            echo '<div class="address-card-outer">';
            foreach ($subscriptions as $subscription) {
            
            if ($subscription->has_product(2816)) {
                // Access subscription information
                $subscription_id = $subscription->get_id();
                $subscription_status = $subscription->get_status();
                $first_name     = get_post_meta($subscription_id, '_billing_first_name', true);
                $last_name      = get_post_meta($subscription_id, '_billing_last_name', true);
                $city           = get_post_meta($subscription_id, '_billing_city', true);
                $state          = get_post_meta($subscription_id, '_billing_state', true);
                $postcode       = get_post_meta($subscription_id, '_billing_postcode', true);
                $address_1      = get_post_meta($subscription_id, '_billing_address_1', true);
               
            ?>       
          
            <div class="adress">
                    <p class="username"><?php echo $first_name .' '.  $last_name ?></p>
                    <address><?php echo $address_1; ?></address>
                    <p class="state"> <?php echo $city; ?></p>
                    <p class="country"><?php echo $state; ?></p>
                    <p class="zipcode"><?php echo $postcode; ?></p>
                    <!-- <button class="remove-user" data-id="<?php //echo $row->id; ?>"> Delete</button> -->
            </div>
            <?php
            }               
            }
            echo '</div>';
        } else {
            echo 'No Additional Addresses found.';
        }
    ?>

    <script>
        jQuery(document).on('click', '.remove-user', function(e) {

            e.preventDefault();            
            var addressId = jQuery(this).data('id');
    
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action': 'delete_address',
                    'address_id': addressId,
                },
                success: function (data) {
                    var json = jQuery.parseJSON(data);

                    if(json.result == true){

                        alert('Successfully Deleted');
                        location.reload();

                    }else{
                        alert('There might be some error');
                    }
                }
            }); 
        });
    </script>
    <?php 
}

/**
 * @param type field_type $type
 * @param Default value $value
 */
function avlabs_join_field_type_options($type,$value){

    $response = '';
    
    switch ($type) {

        case 'phone_type':

            $lists = array(
                'cell' => 'CELL', 
                'home' => 'HOME', 
                /*'fax' => 'FAX', */ 
                'business' => 'BUSINESS'
            );
            
            foreach($lists as $key => $val){
                $selected = ( $key == $value ) ? ' selected ' : '';
                $response .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
            break;

        case 'state':

            $lists = array('AL' => 'Alabama', 'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District Of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming');
            $response .= '<option value="">State</option>';
            foreach($lists as $key => $val){
                $selected = ( $key == $value ) ? ' selected ' : '';
                $response .= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
            break;
        
        default:
            
            break;

    }

    return $response;
}

/**
 * @param User Id $user_id
 * Save profile Join Fields Data
 */
add_action( 'edit_user_profile_update', 'avlabs_save_join_user_profile_fields' );
function avlabs_save_join_user_profile_fields( $user_id )
{

    if( ! isset( $_POST[ '_wpnonce' ] ) || ! wp_verify_nonce( $_POST[ '_wpnonce' ], 'update-user_' . $user_id ) ) {
		return;
	}
	
	if( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}
    //echo '';print_r($_POST);die;
        
    update_user_meta( $user_id, 'middle_name', sanitize_text_field( $_POST[ 'middle_name' ] ) );
    update_user_meta( $user_id, 'address_1', sanitize_text_field( $_POST[ 'address_1' ] ) );
    update_user_meta( $user_id, 'city', sanitize_text_field( $_POST[ 'city' ] ) );
    update_user_meta( $user_id, 'state', sanitize_text_field( $_POST[ 'state' ] ) );
    update_user_meta( $user_id, 'zip', sanitize_text_field( $_POST[ 'zip' ] ) );
    update_user_meta( $user_id, 'same_mailing_address', sanitize_text_field( $_POST[ 'same_mailing_address' ] ) );
    update_user_meta( $user_id, 'mailing_address_1', sanitize_text_field( $_POST[ 'mailing_address_1' ] ) );
    update_user_meta( $user_id, 'mailing_city', sanitize_text_field( $_POST[ 'mailing_city' ] ) );
    update_user_meta( $user_id, 'mailing_state', sanitize_text_field( $_POST[ 'mailing_state' ] ) );
    update_user_meta( $user_id, 'mailing_zip_code', sanitize_text_field( $_POST[ 'mailing_zip_code' ] ) );
    update_user_meta( $user_id, 'phone', sanitize_text_field( $_POST[ 'phone' ] ) );
    update_user_meta( $user_id, 'primary_phone_type', sanitize_text_field( $_POST[ 'primary_phone_type' ] ) );
    update_user_meta( $user_id, 'organization', sanitize_text_field( $_POST[ 'organization' ] ) );
    update_user_meta( $user_id, 'secondary_phone', sanitize_text_field( $_POST[ 'secondary_phone' ] ) );
    update_user_meta( $user_id, 'second_phone', sanitize_text_field( $_POST[ 'second_phone' ] ) );
    update_user_meta( $user_id, 'interested_in_oil_del', sanitize_text_field( $_POST[ 'interested_in_oil_del' ] ) );
    update_user_meta( $user_id, 'current_oil_provider', sanitize_text_field( $_POST[ 'current_oil_provider' ] ) );
    update_user_meta( $user_id, 'staywith_oil_provider', sanitize_text_field( $_POST[ 'staywith_oil_provider' ] ) );
    update_user_meta( $user_id, 'staywith_propane_provider', sanitize_text_field( $_POST[ 'staywith_propane_provider' ] ) );
    update_user_meta( $user_id, 'interested_in_propane_del', sanitize_text_field( $_POST[ 'interested_in_propane_del' ] ) );
    update_user_meta( $user_id, 'current_propane_provider', sanitize_text_field( $_POST[ 'current_propane_provider' ] ) );
    update_user_meta( $user_id, 'interested_in_free_solar_con', sanitize_text_field( $_POST[ 'interested_in_free_solar_con' ] ) );
    update_user_meta( $user_id, 'interested_in_energy_audit', sanitize_text_field( $_POST[ 'interested_in_energy_audit' ] ) );
    update_user_meta( $user_id, 'interested_in_h_a_insurance', sanitize_text_field( $_POST[ 'interested_in_h_a_insurance' ] ) );
    update_user_meta( $user_id, 'who_refer_you', sanitize_text_field( $_POST[ 'who_refer_you' ] ) );
    update_user_meta( $user_id, 'affiliated_organization', sanitize_text_field( $_POST[ 'affiliated_organization' ] ) );
    


}


/**
 * 
 * Custom tabs in User Dashboard
 * 
 **/
function avlabs_custom_tabs_endpoint() {

    if ( !class_exists( 'WooCommerce' ) ) {
        return true;
    }

    //add_rewrite_endpoint( 'my-information', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'additional-locations', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'members-information', EP_ROOT | EP_PAGES ); 
}
  
add_action( 'init', 'avlabs_custom_tabs_endpoint' );
  
/**
 * 
 */
add_filter( 'woocommerce_account_menu_items', 'avlabs_custom_tabs_links' );
function avlabs_custom_tabs_links( $items ) {
    // $items['my-information'] = 'My Information';

    $current_user = get_current_user_id();
    $users_subscriptions = wcs_get_users_subscriptions($current_user);
    foreach ($users_subscriptions as $subscription){

        $subscription_id = $subscription->get_id(); 

        $subscription = new WC_Subscription( $subscription_id );
        $subscription_price = $subscription->get_total();
        $s_price = wc_price( $subscription_price );
        if($s_price > 0){
            // $items['additional-locations'] = 'Additional Locations';   
        }
        
    }     
    $items['additional-locations'] = 'Additional Locations';   
    $items['members-information'] = 'Members Information'; 

    unset($items['members-information']); // We are unsetting it for now.

    unset($items['orders']);
    unset($items['downloads']);
    // unset($items['edit-address']);

    $items['edit-account'] = 'My Information';

    $new_item = array();
    foreach($items as $key => $item){
        if($key == 'customer-logout'){

            // $new_item['my-information'] = 'My Information';
            //$new_item['members-information'] = 'Members Information';
            $new_item[$key] = $item;

        }else{
            
            $new_item[$key] = $item;

        }
        
    }
    if(empty($new_item)){
        return $items;
    }

    return $new_item;
}
  
add_filter( 'woocommerce_endpoint_edit-account_title', 'change_my_account_edit_account_title', 10, 2 );
function change_my_account_edit_account_title( $title, $endpoint ) {
    $title = __( "Edit Account Information", "woocommerce" );

    return $title;
}

function avlabs_my_information_content() {
    echo '<h3>Membership Information</h3>'; 
}

function avlabs_additional_locations_content() {
    ?>

<style>
    .content_panel {
        display: none;
    }
    .modal.popup-modal{
        z-index: 999999;
    }
    .modal.popup-modal .modal-title {
        color: #2b8400;
    }
    #modal_user_content .row input[type="text"] {
        width: 100%;
        padding: 10px 10px;
        background: #fcfcfc;
        border: 1px solid #ccc;
    }
    #modal_user_content .row .mb-30 {
        margin-bottom: 20px;
    }
    @media (min-width: 992px){
        .popup-modal .modal-lg {
            max-width: 1200px;
            width:95%;
        }
    }

    .address-card{
            padding: 20px;
    border: 1px solid #cecece;
    border-radius: 8px;
    font-size: 16px;
    line-height: 26px;
    }

    .adress{
        padding: 20px;
        border: 1px solid #cecece;
        border-radius: 8px;
        font-size: 16px;
        line-height: 26px;
    }
    .adress:hover{
        box-shadow: 0 0 30px #0001;
    }
    .adress p {
        padding: 0;
        margin: 0;
        margin-bottom: 7px;
    }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    button.remove-location-subscription{ font-size: 16px; padding: 6px 15px; background: linear-gradient(to bottom, #2c8400 5%, #72b352 100%); color: #fff; line-height: 20px; border: none; border-radius: 4px;}
    .heading-address {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 50px;
        padding-bottom: 25px;
        border-bottom: 1px solid #e3e3e3;
        margin-bottom: 30px;
    }
        .heading-address h3 {
        margin: 0;
        padding: 0;
    }
    .address-card-outer {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 30px;
        row-gap: 30px;
        margin-bottom: 30px;
    }
    .save-btn-outer {
        margin-top:20px;
        text-align: center;
    }

    form#add_multiple_location input{
        width: 100%;
        margin: 5px 0 15px;
        padding: 10px;
        border-radius: 4px;
    }
    @media (max-width:576px){
        .address-card-outer {
            grid-template-columns: repeat(1, 1fr);
        }
    }
    @media (max-width:425px){
        form#add_multiple_location .col-xs-6 {
        width: 100%;
    }
    }

    .modal-content {
        margin-top: 100px !important;
    }
    </style>
    <div class="heading-address">
        <h3>Additional Locations</h3>

        <div class="add-address-outer">
            <button type="button" name="submit" class="add-address-btn" id="location_data_button" data-toggle="modal" data-target=".bs-example-modal-lg">+ Add Address</button>
        </div>
    </div>

    <?php
        global $wpdb;

        $user_id = get_current_user_id();       

        $subscriptions = wcs_get_users_subscriptions( $user_id, array( 'status' => 'active' ) );
        $subscription_ids       = array();

        foreach ( $subscriptions as $subscription ) {
            $subscription_ids[]     = $subscription->get_id();
        }

        $new_user = get_userdata( $user_id );
        // Get the user's first and last name
        $first_name = $new_user->first_name;
        $last_name  = $new_user->last_name;      

        if ($subscription_ids) {
                            
                echo '<div class="address-card-outer">';
                foreach ($subscription_ids as $n_subscription) {

                    $subscription = wcs_get_subscription( $n_subscription );

                    // Check if the subscription is valid
                    if ( $subscription && $subscription->get_total() == 0) {
                        // Get the subscription status
                        $status = $subscription->get_status();

                        // $parent_id = $subscription->get_parent_id();
                        // $order = wc_get_order( $parent_id );
                       
                        // Get the billing address details
                        $address_1 = $subscription->get_billing_address_1();
                        $city = $subscription->get_billing_city();
                        $state = $subscription->get_billing_state();
                        $postcode = $subscription->get_billing_postcode();
                        $country = $subscription->get_billing_country(); 
                    
                        if($status == 'active'){                    
                        ?>
                        <div class="adress">
                                <p class="username"><?php echo $first_name .' '.  $last_name ?></p>
                                <address><?php echo $address_1; ?></address>
                                <p class="state"> <?php echo $city; ?></p>
                                <p class="country"><?php echo $state; ?></p>
                                <p class="zipcode"><?php echo $postcode; ?></p>
                                <button class="remove-location-subscription" data-id="<?php echo $n_subscription; ?>"> Delete</button>
                        </div>
                        <?php                       
                        }                                 
                    }else {
                        echo 'No Additional Addresses found.';
                        exit;
                    }
                } 
                echo '</div>';
            } else {
                echo 'No Additional Addresses found.';
            }
        ?>
        <!-- Address Modal -->    
        <div class="modal fade bs-example-modal-lg popup-modal" tabindex="-1" role="dialog" aria-labelledby="AddressLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="AddressLargeModalLabel">Add Address</h4>
                    </div>
                    <div class="modal-body"  id="modal_add_address">              

                        <div class="user_data_container" id="location_data_button">
                        <form id="add_multiple_location" method="post">
                            <div class="row">

                                <!-- <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="first_name"><?php //esc_html_e( 'First Name', 'woocommerce' ); ?></label><p><input type="text" name="first_name" value="<?php //echo $first_name; ?>"> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="middle_name"><?php //esc_html_e( 'Middle Name', 'woocommerce' ); ?></label><p><input type="text" name="middle_name" value="<?php //echo $middle_name; ?>"> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="last_name"><?php //esc_html_e( 'Last Name', 'woocommerce' ); ?></label><p><input type="text" name="last_name" value="<?php //echo $last_name; ?>"> </p></div> -->

                                <!-- <div class="clear"></div> -->

                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="address_1"><?php esc_html_e( 'Home address', 'woocommerce' ); ?></label><p><input type="text" name="address_1" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="city"><?php esc_html_e( 'City', 'woocommerce' ); ?></label><p><input type="text" name="city" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="state"><?php esc_html_e( 'State', 'woocommerce' ); ?></label><p><input type="text" name="state" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="zip"><?php esc_html_e( 'Zip', 'woocommerce' ); ?></label><p><input type="text" name="postcode" value=""> </p></div>

                                <!-- <div class="clear"></div> -->

                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_address_1"><?php esc_html_e( 'Mailing address', 'woocommerce' ); ?></label><p><input type="text" name="mailing_address_1" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_city"><?php esc_html_e( 'Mailing City', 'woocommerce' ); ?></label><p><input type="text" name="mailing_city" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_state"><?php esc_html_e( 'Mailing State', 'woocommerce' ); ?></label><p><input type="text" name="mailing_state" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_zip_code"><?php esc_html_e( 'Mailing Zip', 'woocommerce' ); ?></label><p><input type="text" name="mailing_zip_code" value=""> </p></div>
                                <!-- <div class="clear"></div> -->

                                <!-- <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="organization"><?php //esc_html_e( 'Organization', 'woocommerce' ); ?></label><p><input type="text" name="organization" value=""> </p></div> -->

                                <!-- <div class="clear"></div> -->

                                <!-- <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="phone"><?php //esc_html_e( 'Phone', 'woocommerce' ); ?></label><p><input type="text" name="phone" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="primary_phone_type"><?php //esc_html_e( 'Primary Phone Type', 'woocommerce' ); ?></label><p><input type="text" name="primary_phone_type" value=""> </p></div> -->

                                <!-- <div class="clear"></div> -->

                                <!-- <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="secondary_phone"><?php //esc_html_e( 'Secondary Phone', 'woocommerce' ); ?></label><p><input type="text" name="secondary_phone" value=""> </p></div>
                                <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="second_phone"><?php //esc_html_e( 'Secondary Phone Type', 'woocommerce' ); ?></label><p><input type="text" name="second_phone" value=""> </p></div> -->

                                <div class="clear"></div>                          

                            </div>
                            <div class="save-btn-outer">
                                <button type="button" name="submit" class="add-address-btn" id="location_add_button">Save Address</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>

    jQuery(document).ready(function(){

        ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

        jQuery('#location_add_button').on('click', function(e){

            e.preventDefault();
            form_data = new FormData(jQuery('#add_multiple_location')[0]);
            form_data.append('action', 'add_multiple_location');

            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                contentType: false,
                processData: false,
                data: form_data,

                success: function(response) {
                    alert('Location added Successfully!');
                    location.reload();
                },
                error: function(response) {
                    alert('Error adding location!');
                }
            }); 
        });
        
        jQuery(document).on('click', '.remove-location-subscription', function(e) {

            e.preventDefault();            
            var addressId = jQuery(this).data('id');
    
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action': 'delete_location_subscription',
                    'subscription_id': addressId,
                },
                success: function (data) {
                    var json = jQuery.parseJSON(data);

                    if(json.result == true){

                        alert('Successfully Deleted');
                        location.reload();

                    }else{
                        alert('There might be some error');
                    }
                }
            }); 
        });
    });
    </script>
    <?php 
}

/**
 * Delete Multiple address Ajax
 */
function delete_location_subscription(){

    if (isset($_POST['subscription_id']) && !empty($_POST['subscription_id'])) {

        $subscription_id = $_POST['subscription_id'];          
        $subscription = wcs_get_subscription( $subscription_id );

        // Check if the subscription is valid
        if ( $subscription ) {

            // Cancel the subscription
            $subscription->update_status( 'cancelled' );   
        }   

        $return['result'] = true;
        $return['location'] = '';
        $return['message'] = "Success";

        echo json_encode($return);
        die;
    }

}

add_action('wp_ajax_delete_location_subscription', 'delete_location_subscription');
add_action('wp_ajax_nopriv_delete_location_subscription', 'delete_location_subscription');

/**
 * Add Multiple address function Ajax
 */
function add_multiple_location(){

    global $wpdb;

    $user_id = get_current_user_id();

    $new_user = get_userdata( $user_id );
    # Get the user's first and last name
    $first_name = $new_user->first_name;
    $last_name  = $new_user->last_name;
    $email      = $new_user->user_email;
    $phone      = get_user_meta($user_id,'user_phone',true);


    // Get the form data
    $customer_name = sanitize_text_field( $first_name );
    $customer_email = sanitize_email( $email );
    $customer_phone = sanitize_text_field( $_POST['phone'] );
    
    $shipping_address = sanitize_textarea_field( $_POST['address_1'] );

    $product_id = 2816;
  
    // Get the product
    $product = wc_get_product( $product_id );
  
    // Create the customer
    $customer_data = array(
      'first_name' => $customer_name,
      'email' => $customer_email,
      'phone' => $customer_phone,
    );

    $customer_id = get_current_user_id();  

    $order = wc_create_order();
    $product_price = $product->get_price(); // get current price
    $new_price = $product_price; // add 10 to current price
    $product->set_price($new_price); // set the new price
    $order->add_product( $product, 1 );
    $order->set_created_via( 'admin' );
    $order->calculate_totals();
    $order->set_total( $product->get_price() );
    $order->set_customer_id( $customer_id );

    update_post_meta( $order->get_id(), '_billing_first_name', $first_name );
    update_post_meta( $order->get_id(), '_billing_last_name', $last_name );
    update_post_meta( $order->get_id(), '_billing_email', $customer_email );
    update_post_meta( $order->get_id(), '_billing_address_1', $shipping_address );
    update_post_meta( $order->get_id(), '_billing_city', $_POST['city'] );
    update_post_meta( $order->get_id(), '_billing_state', $_POST['state'] );
    update_post_meta( $order->get_id(), '_billing_postcode', $_POST['zip'] );
    update_post_meta( $order->get_id(), '_billing_phone', $customer_phone );

    // Set payment method to cash
    $order->set_payment_method( 'cash' );

    // Update order status to processing
    $order->update_status( 'processing' );

    // Save the order
    $order->save();

    $parent_order_id = $order->get_id(); // get the parent product id

    $subscription_data = array(
          'status'              => 'pending', // subscription status
          'customer_id'         => $customer_id,    // ID of the customer associated with the subscription
          'billing_period'      => 'year',          // billing period
          'billing_interval'    => 1,               // billing interval
          'start_date'          => gmdate( 'Y-m-d H:i:s', time() ), // start date
          'trial_length'        => 0, // trial length in days
          'trial_period'        => '', // trial period
          'expiry_date'         => '', // expiry date
          'product_id'          => $product_id, // ID of the subscription product
          'variation_id'        => '', // ID of the subscription product variation
          'price'               => '', // price of the subscription product
          'tax_percent'         => '', // tax percentage
          'sign_up_fee'         => 0, // sign-up fee
          'meta_data'           => array() // any additional metadata
          
      );

      $subscription_id = wcs_create_subscription( $subscription_data );

      if ( is_wp_error( $subscription_id ) ) {
          echo "Oops! Something went wrong.";
  
      } else {
  
          // Subscription created successfully
          $item = new WC_Order_Item_Product();
          $item->set_product( $product );
          $item->set_quantity( 1 );
          $item->set_total( $product->get_price() );
          
          $subscription = new WC_Subscription( $subscription_id );
          $subscription->set_parent_id( $parent_order_id ); // set parent order id
          $subscription->add_item( $item );
          $subscription->update_status( 'active' );

          update_post_meta( $subscription->get_id(), '_billing_first_name', $first_name );
          update_post_meta( $subscription->get_id(), '_billing_last_name', $last_name );
          update_post_meta( $subscription->get_id(), '_billing_email', $customer_email );
          update_post_meta( $subscription->get_id(), '_billing_address_1', $shipping_address );
          update_post_meta( $subscription->get_id(), '_billing_city', $_POST['city'] );
          update_post_meta( $subscription->get_id(), '_billing_state', $_POST['state'] );
          update_post_meta( $subscription->get_id(), '_billing_postcode', $_POST['zip'] );
          update_post_meta( $subscription->get_id(), '_billing_phone', $customer_phone );

          $created_date = $subscription->get_date_created(); 

          $current_date = new DateTime();
          $current_year = $current_date->format('Y');
          $next_payment_date = new DateTime();
      
          if ($created_date->format('n') >= 6 && $created_date->format('n') <= 12) {
              // Subscription was created between June of the previous year and February 1 of the current year
              $next_payment_date->setDate($current_year, 6, 15);
          } else if ($created_date->format('n') == 15) {
              // If Subscription was  created in January
              $next_payment_date->setDate($current_year, 6, 15);
          } else {
              // Subscription was created after February 1 of the current year
              $next_payment_date->setDate($current_year + 1, 6, 15);
          }
      
          $subscription->update_dates(array(
              'next_payment' => $next_payment_date->format('Y-m-d H:i:s'),
          ));

          // Calculate totals and save the subscription
          $subscription->calculate_totals();
          $subscription->save();
  
          // Return a response to the AJAX request
          wp_send_json_success( 'Subscription created successfully!' );
      }
}

add_action('wp_ajax_add_multiple_location', 'add_multiple_location');
add_action('wp_ajax_nopriv_add_multiple_location', 'add_multiple_location');




function avlabs_members_information_content(){

    global $wpdb;

    echo '<h3>Members Information</h3><hr>';
    // Check if user is logged in.
    if ( is_user_logged_in() ) {

        // Check if search term is set
        $search_term = isset( $_POST['search_user'] ) ? sanitize_text_field( $_POST['search_user'] ) : '';

        // Search users with role "customer"
        $args = array(
            'role_in'         => array('Subscriber'),
            'search'       => '*' . $search_term . '*',
            'search_columns' => array(
                'user_login',
                'user_email',
                'user_nicename',
                'user_url',
                'display_name'
            )
        );
        $customers = get_users( $args );
        //echo 'Last Query: '.$wpdb->last_query;

        // Display search form
        ?>
            <form method="post">
                
            <div class="search-filter usersearch">
            <label>Search Users:</label>
            <input type="text" name="search_user" id="search_user" placeholder="Search users" value="<?php echo $search_term;?>"/>
            <input type="submit" value="Search"/>
            <input type="reset" value="Clear">
            </div>
            </form>    <hr>        

        <?php
        // Display results
        if ( !empty( $customers ) ) {  ?>
        
        
        <?php
            echo '<div class="members-list">';        
            foreach ( $customers as $customer ) {
                ?>

                <div class="member_accordion" data-user-id="<?php echo $customer->ID;?>" data-title = "<?php echo $customer->display_name; ?>  (  <?php echo $customer->user_email; ?> )"><?php echo $customer->display_name; ?>  (  <?php echo $customer->user_email; ?> )</div>                
                <div class="content_panel">
                <?php
                    $first_name                     = get_user_meta( $customer->ID, 'first_name', true );
                    $last_name                      = get_user_meta( $customer->ID, 'last_name', true );
                    $middle_name                    = get_user_meta( $customer->ID, 'middle_name', true );
                    $address_1                      = get_user_meta( $customer->ID, 'address_1', true );
                    $city                           = get_user_meta( $customer->ID, 'city', true );
                    $state                          = get_user_meta( $customer->ID, 'state', true );
                    $zip                            = get_user_meta( $customer->ID, 'zip', true );
                    $same_mailing_address           = get_user_meta( $customer->ID, 'same_mailing_address', true );
                    $mailing_address_1              = get_user_meta( $customer->ID, 'mailing_address_1', true );
                    $mailing_city                   = get_user_meta( $customer->ID, 'mailing_city', true );
                    $mailing_state                  = get_user_meta( $customer->ID, 'mailing_state', true );
                    $mailing_zip_code               = get_user_meta( $customer->ID, 'mailing_zip_code', true );
                    $email                          = $customer->user_email;
                    $phone                          = get_user_meta( $customer->ID, 'phone', true );
                    $primary_phone_type             = get_user_meta( $customer->ID, 'primary_phone_type', true );
                    $organization                   = get_user_meta( $customer->ID, 'organization', true );
                    $secondary_phone                = get_user_meta( $customer->ID, 'secondary_phone', true );
                    $second_phone                   = get_user_meta( $customer->ID, 'second_phone', true );
                    $interested_in_oil_del          = get_user_meta( $customer->ID, 'interested_in_oil_del', true );
                    $current_oil_provider           = get_user_meta( $customer->ID, 'current_oil_provider', true );
                    $staywith_oil_provider          = get_user_meta( $customer->ID, 'staywith_oil_provider', true );
                    $interested_in_propane_del      = get_user_meta( $customer->ID, 'interested_in_propane_del', true );
                    $current_propane_provider       = get_user_meta( $customer->ID, 'current_propane_provider', true );
                    $staywith_propane_provider      = get_user_meta( $customer->ID, 'staywith_propane_provider', true );
                    $interested_in_free_solar_con   = get_user_meta( $customer->ID, 'interested_in_free_solar_con', true );
                    $interested_in_energy_audit     = get_user_meta( $customer->ID, 'interested_in_energy_audit', true );
                    $interested_in_h_a_insurance    = get_user_meta( $customer->ID, 'interested_in_h_a_insurance', true );
                    $who_refer_you                  = get_user_meta( $customer->ID, 'who_refer_you', true );
                    $affiliated_organization        = get_user_meta( $customer->ID, 'affiliated_organization', true );    
           
                ?>
                    <button type="button" class="btn btn-primary" id="user_data_button_<?php echo $customer->ID;?>" data-toggle="modal" data-target=".bs-example-modal-lg">View</button>

                    <div class="user_data_container" id="user_data_<?php echo $customer->ID?>">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-30"><label for="first_name"><?php esc_html_e( 'First Name', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $first_name ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-30"><label for="middle_name"><?php esc_html_e( 'Middle Name', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $middle_name ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-4 mb-30"><label for="last_name"><?php esc_html_e( 'Last Name', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $last_name ); ?>" disabled> </p></div>
                            <div class="clear"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="address_1"><?php esc_html_e( 'Home address', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $address_1 ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="city"><?php esc_html_e( 'City', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $city ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="state"><?php esc_html_e( 'State', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $state ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="zip"><?php esc_html_e( 'Zip', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $zip ); ?>" disabled> </p></div>
                            <div class="clear"></div>

                            <?php if($same_mailing_address != 1 ){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="mailing_address_1"><?php esc_html_e( 'Mailing address', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $mailing_address_1 ); ?>" disabled> </p></div>
                                <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="mailing_city"><?php esc_html_e( 'Mailing City', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $mailing_city ); ?>" disabled> </p></div>
                                <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="mailing_state"><?php esc_html_e( 'Mailing State', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $mailing_state ); ?>" disabled> </p></div>
                                <div class="col-xs-12 col-sm-6 col-md-2 mb-30"><label for="mailing_zip_code"><?php esc_html_e( 'Mailing Zip', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $mailing_zip_code ); ?>" disabled> </p></div>
                                <div class="clear"></div>
                            <?php } ?>

                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="email"><?php esc_html_e( 'Email', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $email ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="organization"><?php esc_html_e( 'Organization', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $organization ); ?>" disabled> </p></div>
                            <div class="clear"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="phone"><?php esc_html_e( 'Phone', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $phone ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="primary_phone_type"><?php esc_html_e( 'Primary Phone Type', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( strtoupper($primary_phone_type) ); ?>" disabled> </p></div>
                            <div class="clear"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="secondary_phone"><?php esc_html_e( 'Secondary Phone', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $secondary_phone ); ?>" disabled> </p></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="second_phone"><?php esc_html_e( 'Secondary Phone Type', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( strtoupper($second_phone) ); ?>" disabled> </p></div>
                            <div class="clear"></div>  

                            <?php if($current_oil_provider != '' ){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="current_oil_provider"><?php esc_html_e( 'Current Oil Provider', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $current_oil_provider ); ?>" disabled> </p></div>
                                <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="staywith_oil_provider"><?php esc_html_e( 'I would like to stay with my current oil provider if they participate in the Co-op', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo ($staywith_oil_provider == 1 ) ? 'Yes' : 'No'; ?>" disabled> </p></div>
                            <?php } ?>


                            <?php if($current_propane_provider != '' ){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="current_propane_provider"><?php esc_html_e( 'Current Propane Provider', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo esc_attr( $current_propane_provider ); ?>" disabled> </p></div>
                                <div class="col-xs-12 col-sm-6 col-md-6 mb-30"><label for="staywith_propane_provider"><?php esc_html_e( 'I would like to stay with my current propane provider if they participate in the Co-op', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo ($staywith_propane_provider == 1 ) ? 'Yes' : 'No'; ?>" disabled> </p></div>
                            <?php } ?>
                            <div class="clear"></div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-8 mb-30"><label for="affiliated_organization"><?php esc_html_e( 'Are you affiliated with any organizations that might want to know about the Co-op?', 'woocommerce' ); ?></label><p><input type="text" value="<?php echo ($affiliated_organization == 1 ) ? 'Yes' : 'No'; ?>" disabled> </p></div>
                            <div class="clear"></div>
                        </div>

                    </div>
                </div>

                <?php
            }

            echo '</div>


            <div class="modal fade bs-example-modal-lg popup-modal" tabindex="-1" role="dialog" aria-labelledby="userDataLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="userDataLargeModalLabel">Title</h4>
                        </div>
                        <div class="modal-body"  id="modal_user_content">
                            ...
                        </div>
                    </div>
                </div>
            </div>
            
            ';

            echo '
            <script>
                jQuery(document).on("click",".member_accordion",function(){
                    var customer_id = jQuery(this).data("user-id");
                    var title = jQuery(this).data("title");
                    var user_html = jQuery("#user_data_"+customer_id).html();
                    jQuery("#modal_user_content").html(user_html);
                    jQuery("#userDataLargeModalLabel").html(title);
                    console.log("user id: ",customer_id)
                    console.log("user_html",user_html)
                    jQuery("#user_data_button_"+customer_id).trigger("click");
                })
            </script>
            <style>
                .search-filter.usersearch input[type="text"] {
                    padding: 8px 10px;
                    border: 1px solid #ccc;
                    background: #fcfcfc;
                }
                .usersearch input[type="submit"], .usersearch input[type="reset"] {
                    background: #2b8400;
                    padding: 8px 10px;
                    border-radius: 5px;
                    color: #fff;
                    border: 1px solid #2b8400;
                }
                .member_accordion {
                    background-color: #dec2640f;
                    color: #2b8400;
                    padding: 10px 15px;
                    width: 100%;
                    border: 1px solid #e8e8e8;
                    margin: 5px 0;
                    font-size: 14px;
                    cursor: pointer;
                }
                .member_accordion:hover {
                    background-color: #fefefe; 
                }
                .content_panel {
                    display: none;
                }
                .modal.popup-modal{
                    z-index: 999999;
                }
                .modal.popup-modal .modal-title {
                    color: #2b8400;
                }
                #modal_user_content .row input[type="text"] {
                    width: 100%;
                    padding: 10px 10px;
                    background: #fcfcfc;
                    border: 1px solid #ccc;
                }
                #modal_user_content .row .mb-30 {
                    margin-bottom: 20px;
                }
                @media (min-width: 992px){
                    .popup-modal .modal-lg {
                        max-width: 1200px;
                        width:95%;
                    }
                }
            </style>
            ';
        } else {
            echo '<p>No customers found.</p>';
        }
    } else {
        echo '<p>You do not have permission to access this page.</p>';
    }
}


/**
 * Introduce functions for custom pages in woocommerce Account
 */
add_action( 'woocommerce_account_additional-locations_endpoint', 'avlabs_additional_locations_content' );
add_action( 'woocommerce_account_my-information_endpoint', 'avlabs_my_information_content' );
add_action( 'woocommerce_account_members-information_endpoint', 'avlabs_members_information_content' ); 


/**
 * Remove content from Dashboard tab 
 */
add_action( 'woocommerce_account_dashboard_endpoint', 'avlabs_dashboard_content' );
function avlabs_dashboard_content(){

}

add_action('woocommerce_edit_account_form','avlabs_woocommerce_edit_account_form');
function avlabs_woocommerce_edit_account_form(){

    $user = wp_get_current_user();

	$first_name                     = get_user_meta( $user->ID, 'first_name', true );
	$last_name                      = get_user_meta( $user->ID, 'last_name', true );
	$middle_name                    = get_user_meta( $user->ID, 'middle_name', true );
	$address_1                      = get_user_meta( $user->ID, 'address_1', true );
	$city                           = get_user_meta( $user->ID, 'city', true );
	$state                          = get_user_meta( $user->ID, 'state', true );
	$zip                            = get_user_meta( $user->ID, 'zip', true );
	$same_mailing_address           = get_user_meta( $user->ID, 'same_mailing_address', true );
	$mailing_address_1              = get_user_meta( $user->ID, 'mailing_address_1', true );
	$mailing_city                   = get_user_meta( $user->ID, 'mailing_city', true );
	$mailing_state                  = get_user_meta( $user->ID, 'mailing_state', true );
    $mailing_zip_code               = get_user_meta( $user->ID, 'mailing_zip_code', true );
	$email                          = $user->user_email;
	$phone                          = get_user_meta( $user->ID, 'phone', true );
	$primary_phone_type             = get_user_meta( $user->ID, 'primary_phone_type', true );
	$organization                   = get_user_meta( $user->ID, 'organization', true );
	$secondary_phone                = get_user_meta( $user->ID, 'secondary_phone', true );
	$second_phone                   = get_user_meta( $user->ID, 'second_phone', true );
	$interested_in_oil_del          = get_user_meta( $user->ID, 'interested_in_oil_del', true );
	$current_oil_provider           = get_user_meta( $user->ID, 'current_oil_provider', true );
	$staywith_oil_provider          = get_user_meta( $user->ID, 'staywith_oil_provider', true );
	$interested_in_propane_del      = get_user_meta( $user->ID, 'interested_in_propane_del', true );
	$current_propane_provider       = get_user_meta( $user->ID, 'current_propane_provider', true );
	$staywith_propane_provider      = get_user_meta( $user->ID, 'staywith_propane_provider', true );
	$interested_in_free_solar_con   = get_user_meta( $user->ID, 'interested_in_free_solar_con', true );
	$interested_in_energy_audit     = get_user_meta( $user->ID, 'interested_in_energy_audit', true );
	$interested_in_h_a_insurance    = get_user_meta( $user->ID, 'interested_in_h_a_insurance', true );
	$who_refer_you                  = get_user_meta( $user->ID, 'who_refer_you', true );
	$affiliated_organization        = get_user_meta( $user->ID, 'affiliated_organization', true );

    ?>
    	<fieldset>
		<legend><?php esc_html_e( 'Additional Info', 'woocommerce' ); ?></legend>

		<!-- <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="middle_name"><?php //esc_html_e( 'Middle Name', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="middle_name" id="middle_name" autocomplete="off" value="<?php //echo esc_attr( $middle_name ); ?>" disabled/>
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="organization"><?php //esc_html_e( 'Organization', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="organization" id="organization" autocomplete="off" value="<?php //echo esc_attr( $organization ); ?>" disabled />
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="address_1"><?php //esc_html_e( 'Home address', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="address_1" id="address_1" autocomplete="off" value="<?php //echo esc_attr( $address_1 ); ?>" disabled />
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="city"><?php //esc_html_e( 'City', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="city" id="city" autocomplete="off" value="<?php //echo esc_attr( $city ); ?>" disabled/>
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="state"><?php //esc_html_e( 'State', 'woocommerce' ); ?></label>
            <select name="state" id="state" class="woocommerce-select woocommerce-Input--select input-text" disabled>
                <?php //echo avlabs_join_field_type_options('state',esc_attr( $state ));?>
            </select>
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="zip"><?php //esc_html_e( 'Zip', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="zip" id="zip" autocomplete="off" value="<?php //echo esc_attr( $zip ); ?>" disabled/>
		</p>

        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="secondary_phone"><?php //esc_html_e( 'Mailing Address Same as Home', 'woocommerce' ); ?></label>
			<input type="radio" name="same_mailing_address" value="1" <?php //echo ($same_mailing_address == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="same_mailing_address" value="0" <?php //echo ($same_mailing_address == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>   -->



        <!-- <div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="mailing_address_1"><?php //esc_html_e( 'Mailing Address', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="mailing_address_1" id="mailing_address_1" autocomplete="off" value="<?php //echo esc_attr( $mailing_address_1 ); ?>" disabled/>
		</p>
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="mailing_city"><?php //esc_html_e( 'Mailing City', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="mailing_city" id="mailing_city" autocomplete="off" value="<?php //echo esc_attr( $mailing_city ); ?>" disabled/>
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="mailing_state"><?php //esc_html_e( 'Mailing State', 'woocommerce' ); ?></label>
            <select name="mailing_state" id="mailing_state" class="woocommerce-select woocommerce-Input--select input-text" disabled>
                <?php //echo avlabs_join_field_type_options('state',esc_attr( $mailing_state ));?>
            </select>
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="mailing_zip_code"><?php //esc_html_e( 'Mailing Zip', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="mailing_zip_code" id="mailing_zip_code" autocomplete="off" value="<?php //echo esc_attr( $mailing_zip_code ); ?>" disabled/>
		</p> -->

        <div class="clear"></div>
        
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="phone"><?php esc_html_e( 'Phone', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="phone" autocomplete="off" value="<?php echo esc_attr( $phone ); ?>" />
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="primary_phone_type"><?php esc_html_e( 'Primary Phone Type', 'woocommerce' ); ?></label>
            <select name="primary_phone_type" class="woocommerce-select woocommerce-Input--select input-text">
                <?php echo avlabs_join_field_type_options('phone_type',esc_attr( $primary_phone_type ));?>
            </select>
        </p>
        <div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="secondary_phone"><?php esc_html_e( 'Secondary Phone', 'woocommerce' ); ?></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="secondary_phone" id="secondary_phone" autocomplete="off" value="<?php echo esc_attr( $secondary_phone ); ?>"/>
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="second_phone"><?php esc_html_e( 'Secondary Phone Type', 'woocommerce' ); ?></label>
            <select name="second_phone" class="woocommerce-select woocommerce-Input--select input-text">
                <?php echo avlabs_join_field_type_options('phone_type',esc_attr( $second_phone ));?>
            </select>
        </p>
        <div class="clear"></div>
        
		<!-- <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="interested_in_oil_del"><?php //esc_html_e( 'I\'m interested in discounted oil deliveries', 'woocommerce' ); ?></label>
			<input type="radio" name="interested_in_oil_del" value="1" <?php //echo ($interested_in_oil_del == 1 ) ? 'checked' : ''; ?>  disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="interested_in_oil_del" value="0" <?php //echo ($interested_in_oil_del == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="current_oil_provider"><?php //esc_html_e( 'Current Oil Provider (optional)', 'woocommerce' ); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="current_oil_provider" id="current_oil_provider" autocomplete="off" value="<?php //echo esc_attr( $current_oil_provider ); ?>" disabled/>
        </p>
        <div class="clear"></div>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="staywith_oil_provider"><?php //esc_html_e( 'I would like to stay with my current oil provider if they participate in the Co-op', 'woocommerce' ); ?></label>
			<input type="radio" name="staywith_oil_provider" value="1" <?php //echo ($staywith_oil_provider == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="staywith_oil_provider" value="0" <?php //echo ($staywith_oil_provider == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>   
        <div class="clear"></div>      
        

        
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="interested_in_propane_del"><?php //esc_html_e( 'I\'m interested in discounted propane deliveries', 'woocommerce' ); ?></label>
			<input type="radio" name="interested_in_propane_del" value="1" <?php //echo ($interested_in_propane_del == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="interested_in_propane_del" value="0" <?php //echo ($interested_in_propane_del == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="current_propane_provider"><?php //esc_html_e( 'Current Propane Provider (optional)', 'woocommerce' ); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="current_propane_provider" id="current_propane_provider" autocomplete="off" value="<?php //echo esc_attr( $current_propane_provider ); ?>" disabled/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="staywith_propane_provider"><?php //esc_html_e( 'I would like to stay with my current propane provider if they participate in the Co-op', 'woocommerce' ); ?></label>
			<input type="radio" name="staywith_propane_provider" value="1" <?php //echo ($staywith_propane_provider == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="staywith_propane_provider" value="0" <?php //echo ($staywith_propane_provider == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>   
        <div class="clear"></div>
        
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="interested_in_free_solar_con"><?php //esc_html_e( 'I\'m interested in FREE solar consultation for my home', 'woocommerce' ); ?></label>
			<input type="radio" name="interested_in_free_solar_con" value="1" <?php //echo ($interested_in_free_solar_con == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="interested_in_free_solar_con" value="0" <?php //echo ($interested_in_free_solar_con == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="interested_in_energy_audit"><?php //esc_html_e( 'I\'m interested in home energy audit', 'woocommerce' ); ?></label>
            <input type="radio" name="interested_in_energy_audit" value="1" <?php //echo ($interested_in_energy_audit == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="interested_in_energy_audit" value="0" <?php //echo ($interested_in_energy_audit == 0 ) ? 'checked' : ''; ?> disabled/> No
        </p>
        <div class="clear"></div>
        
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="interested_in_h_a_insurance"><?php //esc_html_e( 'I would like FREE home or auto insurance quote', 'woocommerce' ); ?></label>
			<input type="radio" name="interested_in_h_a_insurance" value="1" <?php //echo ($interested_in_h_a_insurance == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="interested_in_h_a_insurance" value="0" <?php //echo ($interested_in_h_a_insurance == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p>        
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="who_refer_you"><?php //esc_html_e( 'Did a member or organization refer you?', 'woocommerce' ); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="who_refer_you" id="who_refer_you" autocomplete="off" value="<?php //echo esc_attr( $who_refer_you ); ?>" disabled/>
        </p>

        <div class="clear"></div>
        
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="interested_in_free_solar_con"><?php //esc_html_e( 'Are you affiliated with any organizations that might want to know about the Co-op?', 'woocommerce' ); ?></label>
			<input type="radio" name="affiliated_organization" value="1" <?php //echo ($affiliated_organization == 1 ) ? 'checked' : ''; ?> disabled/> Yes &nbsp;&nbsp;
            <input type="radio" name="affiliated_organization" value="0" <?php //echo ($affiliated_organization == 0 ) ? 'checked' : ''; ?> disabled/> No
		</p> -->
        

	</fieldset>
	<div class="clear"></div>
    <?php 
}


// Save field value
add_action( 'woocommerce_save_account_details', 'misha_save_account_details' );
function misha_save_account_details( $user_id ) {
	
	if( isset( $_POST[ 'middle_name' ] ) ) { update_user_meta( $user_id, 'middle_name', wc_clean( $_POST[ 'middle_name' ] ) ); }
	if( isset( $_POST[ 'address_1' ] ) ) { update_user_meta( $user_id, 'address_1', wc_clean( $_POST[ 'address_1' ] ) ); }
	if( isset( $_POST[ 'city' ] ) ) { update_user_meta( $user_id, 'city', wc_clean( $_POST[ 'city' ] ) ); }
	if( isset( $_POST[ 'state' ] ) ) { update_user_meta( $user_id, 'state', wc_clean( $_POST[ 'state' ] ) ); }
	if( isset( $_POST[ 'zip' ] ) ) { update_user_meta( $user_id, 'zip', wc_clean( $_POST[ 'zip' ] ) ); }
	if( isset( $_POST[ 'same_mailing_address' ] ) ) { update_user_meta( $user_id, 'same_mailing_address', wc_clean( $_POST[ 'same_mailing_address' ] ) ); }
	if( isset( $_POST[ 'mailing_address_1' ] ) ) { update_user_meta( $user_id, 'mailing_address_1', wc_clean( $_POST[ 'mailing_address_1' ] ) ); }
	if( isset( $_POST[ 'mailing_city' ] ) ) { update_user_meta( $user_id, 'mailing_city', wc_clean( $_POST[ 'mailing_city' ] ) ); }
	if( isset( $_POST[ 'mailing_state' ] ) ) { update_user_meta( $user_id, 'mailing_state', wc_clean( $_POST[ 'mailing_state' ] ) ); }
	if( isset( $_POST[ 'mailing_zip_code' ] ) ) { update_user_meta( $user_id, 'mailing_zip_code', wc_clean( $_POST[ 'mailing_zip_code' ] ) ); }
	if( isset( $_POST[ 'phone' ] ) ) { update_user_meta( $user_id, 'phone', wc_clean( $_POST[ 'phone' ] ) ); }
	if( isset( $_POST[ 'primary_phone_type' ] ) ) { update_user_meta( $user_id, 'primary_phone_type', wc_clean( $_POST[ 'primary_phone_type' ] ) ); }
	if( isset( $_POST[ 'organization' ] ) ) { update_user_meta( $user_id, 'organization', wc_clean( $_POST[ 'organization' ] ) ); }
	if( isset( $_POST[ 'secondary_phone' ] ) ) { update_user_meta( $user_id, 'secondary_phone', wc_clean( $_POST[ 'secondary_phone' ] ) ); }
	if( isset( $_POST[ 'second_phone' ] ) ) { update_user_meta( $user_id, 'second_phone', wc_clean( $_POST[ 'second_phone' ] ) ); }
	if( isset( $_POST[ 'interested_in_oil_del' ] ) ) { update_user_meta( $user_id, 'interested_in_oil_del', wc_clean( $_POST[ 'interested_in_oil_del' ] ) ); }
	if( isset( $_POST[ 'current_oil_provider' ] ) ) { update_user_meta( $user_id, 'current_oil_provider', wc_clean( $_POST[ 'current_oil_provider' ] ) ); }
	if( isset( $_POST[ 'staywith_oil_provider' ] ) ) { update_user_meta( $user_id, 'staywith_oil_provider', wc_clean( $_POST[ 'staywith_oil_provider' ] ) ); }
	if( isset( $_POST[ 'interested_in_propane_del' ] ) ) { update_user_meta( $user_id, 'interested_in_propane_del', wc_clean( $_POST[ 'interested_in_propane_del' ] ) ); }
	if( isset( $_POST[ 'current_propane_provider' ] ) ) { update_user_meta( $user_id, 'current_propane_provider', wc_clean( $_POST[ 'current_propane_provider' ] ) ); }
	if( isset( $_POST[ 'staywith_propane_provider' ] ) ) { update_user_meta( $user_id, 'staywith_propane_provider', wc_clean( $_POST[ 'staywith_propane_provider' ] ) ); }
	if( isset( $_POST[ 'interested_in_free_solar_con' ] ) ) { update_user_meta( $user_id, 'interested_in_free_solar_con', wc_clean( $_POST[ 'interested_in_free_solar_con' ] ) ); }
	if( isset( $_POST[ 'interested_in_energy_audit' ] ) ) { update_user_meta( $user_id, 'interested_in_energy_audit', wc_clean( $_POST[ 'interested_in_energy_audit' ] ) ); }
	if( isset( $_POST[ 'interested_in_h_a_insurance' ] ) ) { update_user_meta( $user_id, 'interested_in_h_a_insurance', wc_clean( $_POST[ 'interested_in_h_a_insurance' ] ) ); }
	if( isset( $_POST[ 'who_refer_you' ] ) ) { update_user_meta( $user_id, 'who_refer_you', wc_clean( $_POST[ 'who_refer_you' ] ) ); }
	if( isset( $_POST[ 'affiliated_organization' ] ) ) { update_user_meta( $user_id, 'affiliated_organization', wc_clean( $_POST[ 'affiliated_organization' ] ) ); }
	
}
add_action('wp_footer','mailing_address_is_same_copy_action');
function mailing_address_is_same_copy_action(){
    
    if(is_page('checkout')){
        ?>
        <script>
            jQuery(document).ready(function(){
                jQuery("#billing_phone_type").select2().val("Cell").trigger("change");                
            });  
            
            jQuery('#place_order').on('click', function(e){      
                e.preventDefault();

                var zipValue = jQuery('input#billing_postcode').val();

                if (zipValue.length === 5 || /^\d{5}(-\d{4})?$/.test(zipValue)) {
                } else {
                    alert('Invalid format. Correct format: 12345 or 12345-1234');
                    e.preventDefault();
                    window.stop();
                }
            });

        </script>
        <style>
            dl.variation {
                display: none;
            }
        </style>
        <?php
    }
    ?>
    <script>

        jQuery(document).ready(function(){   
            
            jQuery('.button.delete').on('click', function(e){
                var currentPage = window.location.pathname;        
                var allowedPages = [
                    '/my-account/payment-methods/',
                ];

                if (allowedPages.includes(currentPage)) {
                    var redirect = jQuery(this).attr('href');
                    window.location.href = redirect;
                }     
            });         

            jQuery(document).on('change','input[name="same_mailing_address"]',function(){

                console.log('same_mailing_address',jQuery("input[name='same_mailing_address']:checked").val())

                if( jQuery("input[name='same_mailing_address']:checked").val() == 1 ){

                    jQuery('.mailing_section').addClass('hidden');
                    jQuery('#mailing_address_1').val( jQuery('#address_1').val())
                    jQuery('#mailing_city').val( jQuery('#city').val())
                    jQuery('#mailing_state').val( jQuery('#state').val())
                    jQuery('#mailing_zip_code').val( jQuery('#zip').val())
                }else{
                    jQuery('.mailing_section').removeClass('hidden');
                }

            })            
            
            
            jQuery(document).on('change','input[name="current_oil_provider"]',function(){

                if( jQuery(this).val().trim() == '' ){
                    jQuery('.current_pro_oil').addClass('hidden');
                }else{
                    jQuery('.current_pro_oil').removeClass('hidden');
                }

            })            
            jQuery(document).on('change','input[name="current_propane_provider"]',function(){

                if( jQuery(this).val().trim() == '' ){
                    jQuery('.current_pro_propane').addClass('hidden');
                }else{
                    jQuery('.current_pro_propane').removeClass('hidden');
                }

            })

        })

    </script>    

    <?php
}


/********* Subscriptions Customization  ********/

function avlabs_get_months() {
    $months = array(
     1=> 'Jan',
     2=> 'Feb',
     3=> 'Mar',
     4=> 'Apr',
     5=> 'May',
     6=> 'Jun',
     7=> 'Jul',
     8=> 'Aug',
     9=> 'Sep',
     10=> 'Oct',
     11=> 'Nov',
     12=> 'Dec',
    );
    return $months;
}

add_action('admin_menu', 'subscriptions_settings_submenu_page');

function subscriptions_settings_submenu_page() {
    add_submenu_page( 'woocommerce', 'Subscriptions Custom Settings', 'Subscriptions Custom Settings', 'manage_options', 'subscriptions-custom-settings-page', 'subscriptions_custom_settings_callback' ); 
}

function subscriptions_custom_settings_callback() {
    
    $months = avlabs_get_months();  

    // Get late fee value from option
    $late_fee           = get_option( 'oilco_subscription_late_fee', 5 ); // default value of 5 if option not set
    $renewal_late_fee   = get_option( 'oilco_subscription_late_fee_status', 'off' ); // default value is off if optio is not set

    ?>
    <style>
    input[type="checkbox"] {
        position: relative;
        appearance: none;
        width: 62px;
        height: 30px;
        background: #ccc;
        border-radius: 50px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: 0.4s;
    }

    input:checked[type="checkbox"] {
        background: #2b8400;
    }

    input[type="checkbox"]::after {
        position: absolute;
        content: "";
        width: 30px;
        height: 30px;
        top: 0;
        left: 0;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        transform: scale(1.1);
        transition: 0.4s;
    }

    input:checked[type="checkbox"]::after {
        left: 50%;
    }

    .select2-selection { overflow: hidden !important; }
    .select2-selection__rendered { white-space: normal !important; word-break: break-all !important; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <h1>Subscriptions Settings</h1>  

    <!-- <form method="post" action="" novalidate="novalidate"> -->
    <form method="post" action="options.php">
       <table class="form-table">
           <tbody>
                <tr>
                   <th scope="row"><label for="oilco_late_fee"><?php echo __('Late Fee Status', OILCO_TEXT_DOMAIN);?></label></th>
                   <td>
                        <div class="check-box">
                            <input type="hidden" name="hidden_renewal_status" value="off" />
                            <input type="checkbox" name="renewal_late_fee" id="renewal_late_fee" 
                            <?php if($renewal_late_fee == 'on'){
                                echo 'checked';                                
                            }
                            ?>
                            >
                        </div>
                   </td>
               </tr>
                    
               <tr>
                   <th scope="row"><label for="oilco_late_fee"><?php echo __('Late Fee', OILCO_TEXT_DOMAIN);?></label></th>
                   <td><input name="oilco_late_fee" type="text" id="oilco_late_fee" value="<?php echo $late_fee; ?>" class="regular-text"></td>
               </tr>
               
           </tbody>
       </table>

        <div class="wrap">
            <h2>Fee Excluded Users</h2>
                    <?php
                        $args  = array(

                            'orderby'   => 'display_name',
                            'role__in' => array( 'editor','administrator', 'subscriber', 'customer' ) ,
                            'order'     => 'ASC',
                        
                        );
                
                    // Create the WP_User_Query object
                    $wp_user_query = new WP_User_Query($args);

                    // Get the results
                    $all_agents = $wp_user_query->get_results();
                    $active_users = get_option('active_users_id');
                    ?>

                
                    <table class="wp-list-table widefat fixed striped users" style="width:50%">
                        <tbody>
                            <tr>
                                <td class="column-primary" colspan="3">
                                    <p><label>User's ID</label></p>

                                    <select class="user_filter_dropdown select2" id="active_users_id" name="active_users_id[]" style="width: 100%"  multiple="multiple">
                                        <option value="">All</option>
                                        <?php foreach($all_agents as $agents){
                                            $user_name = $agents->first_name.' '.$agents->last_name;

                                            if(empty(trim($user_name))){
                                                $user_name = $agents->display_name;
                                            }
                                            $selected = '';
                                            if(!empty($active_users) && in_array($agents->ID,$active_users) ){
                                                $selected = 'selected';
                                            }
                                            echo '<option value="'.$agents->ID.'" '.$selected .'>'.$user_name.' '. $agents->ID.' - '.' ('.$agents->user_email.')</option>';
                                        }?>
                                    </select>
                                </td>
                            </tr>  
                        </tbody>
                    </table>

                    <script>
                        jQuery(document).ready(function(){
                            jQuery("#active_users_id").select2({
                                tags: true
                            });
                        })
                    </script>

                <?php settings_fields( 'avlabs_options_group' ); ?>
                <input type="hidden" value="1" name="exclude_late_fee" />
                <?php  submit_button(); ?>

            </form>
        </div>
    <?php
}

function avlabs_save_exclude_late_fee() {
    
    global $wpdb;
	if(isset($_REQUEST['exclude_late_fee'])){

         // Check if form is submitted
        if ( isset( $_REQUEST['oilco_late_fee'] ) ) {

            // Save late fee value in option
            $late_fee = isset( $_REQUEST['oilco_late_fee'] ) ? sanitize_text_field( $_REQUEST['oilco_late_fee'] ) : '';
            update_option( 'oilco_subscription_late_fee', $late_fee );
        }

        if( isset( $_REQUEST['renewal_late_fee'] ) ) {

            $renewal_late_fee = sanitize_text_field( $_REQUEST['renewal_late_fee'] );
            update_option( 'oilco_subscription_late_fee_status', $renewal_late_fee );

        }
        if( !isset( $_REQUEST['renewal_late_fee'] ) && isset( $_REQUEST['hidden_renewal_status'] )){

            $renewal_late_fee = 'off';
            update_option( 'oilco_subscription_late_fee_status', $renewal_late_fee );
        }

		update_option('active_users_id',$_REQUEST['active_users_id'] );		

		register_setting( 'avlabs_options_group', 'avlabs_active_users_id', 'esc_attr' );
	
	}	
}

add_action( 'admin_init', 'avlabs_save_exclude_late_fee' );


/**
 * Add Additional Address Functionality in Woocommerce Address Tab
 */
add_action( 'woocommerce_after_edit_account_address_form', 'custom_woocommerce_after_edit_account_address_form' );
function custom_woocommerce_after_edit_account_address_form() {
    ?>
    <style>
    .content_panel {
        display: none;
    }
    .modal.popup-modal{
        z-index: 999999;
    }
    .modal.popup-modal .modal-title {
        color: #2b8400;
    }
    #modal_user_content .row input[type="text"] {
        width: 100%;
        padding: 10px 10px;
        background: #fcfcfc;
        border: 1px solid #ccc;
    }
    #modal_user_content .row .mb-30 {
        margin-bottom: 20px;
    }
    @media (min-width: 992px){
        .popup-modal .modal-lg {
            max-width: 1200px;
            width:95%;
        }
    }

    .address-card{
            padding: 20px;
    border: 1px solid #cecece;
    border-radius: 8px;
    font-size: 16px;
    line-height: 26px;
    }

    .adress{
        padding: 20px;
        border: 1px solid #cecece;
        border-radius: 8px;
        font-size: 16px;
        line-height: 26px;
    }
    .adress:hover{
        box-shadow: 0 0 30px #0001;
    }
    .adress p {
        padding: 0;
        margin: 0;
        margin-bottom: 7px;
    }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    .adress p.username{ font-size: 20px; line-height: 26px; font-weight: 600;  }
    button.remove-user{ font-size: 16px; padding: 6px 15px; background: linear-gradient(to bottom, #2c8400 5%, #72b352 100%); color: #fff; line-height: 20px; border: none; border-radius: 4px;}
    .heading-address {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 50px;
        padding-bottom: 25px;
        border-bottom: 1px solid #e3e3e3;
        margin-bottom: 30px;
    }
        .heading-address h3 {
        margin: 0;
        padding: 0;
    }
    .address-card-outer {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 30px;
        row-gap: 30px;
        margin-bottom: 30px;
    }
    .save-btn-outer {
        margin-top:20px;
        text-align: center;
    }

    form#add_multiple_address input{
        width: 100%;
        margin: 5px 0 15px;
        padding: 10px;
        border-radius: 4px;
    }
    @media (max-width:576px){
        .address-card-outer {
            grid-template-columns: repeat(1, 1fr);
        }
    }
    @media (max-width:425px){
        form#add_multiple_address .col-xs-6 {
        width: 100%;
    }
    }
    </style>

    <div class="heading-address">
        <h3>Additional Addresses:</h3>
    </div>
    <?php
        global $wpdb;

        $user_id = get_current_user_id();
        $subscriptions = wcs_get_users_subscriptions($user_id);
        if ($subscriptions) {           
            
            echo '<div class="address-card-outer">';
            foreach ($subscriptions as $subscription) {
           
            if ($subscription->has_product(2816)) {
                // Access subscription information
                $subscription_id = $subscription->get_id();
                $subscription_status = $subscription->get_status();
                $first_name     = get_post_meta($subscription_id, '_billing_first_name', true);
                $last_name      = get_post_meta($subscription_id, '_billing_last_name', true);
                $city           = get_post_meta($subscription_id, '_billing_city', true);
                $state          = get_post_meta($subscription_id, '_billing_state', true);
                $postcode       = get_post_meta($subscription_id, '_billing_postcode', true);
                $address_1      = get_post_meta($subscription_id, '_billing_address_1', true);
               
            ?>       
          
            <div class="adress">
                    <p class="username"><?php echo $first_name .' '.  $last_name ?></p>
                    <address><?php echo $address_1; ?></address>
                    <p class="state"> <?php echo $city; ?></p>
                    <p class="country"><?php echo $state; ?></p>
                    <p class="zipcode"><?php echo $postcode; ?></p>
                    <!-- <button class="remove-user" data-id="<?php //echo $row->id; ?>"> Delete</button> -->
            </div>
            <?php
            }               
            }
            echo '</div>';
        } else {
            echo 'No Additional Addresses found.';
        }
    ?> 
        
    <!-- Address Modal -->    
    <div class="modal fade bs-example-modal-lg popup-modal" tabindex="-1" role="dialog" aria-labelledby="AddressLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="AddressLargeModalLabel">Add Address</h4>
                </div>
                <div class="modal-body"  id="modal_add_address">              

                    <div class="user_data_container" id="address_data_button">
                    <form id="add_multiple_address" method="post">
                        <div class="row">

                            <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="first_name"><?php esc_html_e( 'First Name', 'woocommerce' ); ?></label><p><input type="text" name="first_name" value="<?php echo $first_name; ?>"> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="middle_name"><?php esc_html_e( 'Middle Name', 'woocommerce' ); ?></label><p><input type="text" name="middle_name" value="<?php echo $middle_name; ?>"> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-4 mb-30"><label for="last_name"><?php esc_html_e( 'Last Name', 'woocommerce' ); ?></label><p><input type="text" name="last_name" value="<?php echo $last_name; ?>"> </p></div>

                            <!-- <div class="clear"></div> -->

                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="address_1"><?php esc_html_e( 'Home address', 'woocommerce' ); ?></label><p><input type="text" name="address_1" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="city"><?php esc_html_e( 'City', 'woocommerce' ); ?></label><p><input type="text" name="city" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="state"><?php esc_html_e( 'State', 'woocommerce' ); ?></label><p><input type="text" name="state" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="zip"><?php esc_html_e( 'Zip', 'woocommerce' ); ?></label><p><input type="text" name="postcode" value=""> </p></div>

                            <!-- <div class="clear"></div> -->

                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_address_1"><?php esc_html_e( 'Mailing address', 'woocommerce' ); ?></label><p><input type="text" name="mailing_address_1" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_city"><?php esc_html_e( 'Mailing City', 'woocommerce' ); ?></label><p><input type="text" name="mailing_city" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_state"><?php esc_html_e( 'Mailing State', 'woocommerce' ); ?></label><p><input type="text" name="mailing_state" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="mailing_zip_code"><?php esc_html_e( 'Mailing Zip', 'woocommerce' ); ?></label><p><input type="text" name="mailing_zip_code" value=""> </p></div>
                            <!-- <div class="clear"></div> -->

                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="organization"><?php esc_html_e( 'Organization', 'woocommerce' ); ?></label><p><input type="text" name="organization" value=""> </p></div>

                            <!-- <div class="clear"></div> -->

                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="phone"><?php esc_html_e( 'Phone', 'woocommerce' ); ?></label><p><input type="text" name="phone" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="primary_phone_type"><?php esc_html_e( 'Primary Phone Type', 'woocommerce' ); ?></label><p><input type="text" name="primary_phone_type" value=""> </p></div>

                            <!-- <div class="clear"></div> -->

                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="secondary_phone"><?php esc_html_e( 'Secondary Phone', 'woocommerce' ); ?></label><p><input type="text" name="secondary_phone" value=""> </p></div>
                            <div class="col-xs-6 col-sm-4 col-md-3 mb-30"><label for="second_phone"><?php esc_html_e( 'Secondary Phone Type', 'woocommerce' ); ?></label><p><input type="text" name="second_phone" value=""> </p></div>

                            <div class="clear"></div>                          

                        </div>
                        <div class="save-btn-outer">
                            <button type="button" name="submit" class="add-address-btn" id="address_add_button">Save Address</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    jQuery(document).ready(function(){

        ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

        jQuery('#address_add_button').on('click', function(e){

            e.preventDefault();
            form_data = new FormData(jQuery('#add_multiple_address')[0]);
            form_data.append('action', 'add_multiple_address');

            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                contentType: false,
                processData: false,
                data: form_data,

                success: function (data) {
                    var json = $.parseJSON(data);

                    if(json.result == true){

                        alert('Successfully Updated');
                        location.reload();

                    }else{
                        alert('There might be some error');
                    }
                }
            }); 
        });
        
        jQuery(document).on('click', '.remove-user', function(e) {
            
            e.preventDefault();
            var addressId = jQuery(this).data('id');
    
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action': 'delete_address',
                    'address_id': addressId,
                },
                success: function (data) {
                    var json = $.parseJSON(data);

                    if(json.result == true){

                        alert('Successfully Deleted');
                        location.reload();

                    }else{
                        alert('There might be some error');
                    }
                }
            }); 
        });
    });

    </script>

    <?php
}


/**
 * Delete Multiple address Ajax
 */
function delete_address(){

    if (isset($_POST['address_id']) && !empty($_POST['address_id'])) {

        global $wpdb;
      
        $table = 'user_addresses';

        $id = $_POST['address_id'];
        $delete_id = $wpdb->delete( $table, array( 'id' => $id ) );      

        if($delete_id){

            $return['result'] = true;
            $return['location'] = '';
            $return['message'] = "Success";
    
        }else{
            $return['result'] = false;
            $return['error'] = $wpdb->last_error;
        }
        echo json_encode($return);
        die;
    }

}

add_action('wp_ajax_delete_address', 'delete_address');
add_action('wp_ajax_nopriv_delete_address', 'delete_address');


/**
 * Add Multiple address function Ajax
 */
function add_multiple_address(){

    global $wpdb;

    $return = array();
    $errors = array();

    $table_name = 'user_addresses';

    $user_id            = get_current_user_id();
    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $middle_name        = $_POST['middle_name'];
    $address_1          = $_POST['address_1'];
    $city               = $_POST['city'];
    $state              = $_POST['state'];
    $zipcode            = $_POST['postcode'];
    $organization       = $_POST['organization'];
    $phone              = $_POST['phone'];
    $primary_phone_type = $_POST['primary_phone_type'];
    $secondary_phone    = $_POST['secondary_phone'];
    $second_phone       = $_POST['second_phone'];

    $data = array(
        'user_id'               => $user_id,
        'first_name'            => $first_name,
        'last_name'             => $last_name,
        'address_1'             => $address_1 ,
        'city'                  => $city,
        'state'                 => $state,
        'postcode'              => $zipcode,
        'company'               => $organization,
        'phone'                 => $phone,
        'primary_phone_type'    => $primary_phone_type,
        'secondary_phone'       => $secondary_phone,
        'second_phone'          => $second_phone,
    );
    $post_id = $wpdb->insert($table_name, $data);

    if($post_id){

        $return['result'] = true;
        $return['location'] = 'my-account/edit-address/';
        $return['message'] = "Success";

    }else{
        $return['result'] = false;
		// $return['error'] = $errors;
        $return['error'] = $wpdb->last_error;
    }
    echo json_encode($return);
    die;
}

add_action('wp_ajax_add_multiple_address', 'add_multiple_address');
add_action('wp_ajax_nopriv_add_multiple_address', 'add_multiple_address');


function add_create_user_page_to_menu() {
    add_menu_page(
        'Create User',
        'Create User',
        'manage_options',
        'create-user',
        'create_user_page_callback',
        'dashicons-admin-users',
        10
    );
}
//add_action( 'admin_menu', 'add_create_user_page_to_menu' );

function create_user_page_callback() {
    ?>
    <div class="wrap">
        <h1>Create User</h1>
        <?php
          ?>

        <form id="order-form">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>
            <br>

            <label for="customer_email">Customer Email:</label>
            <input type="email" id="customer_email" name="customer_email" required>
            <br>

            <label for="customer_phone">Customer Phone:</label>
            <input type="tel" id="customer_phone" name="customer_phone" required>
            <br>

            <label for="billing_address">Billing Address:</label>
            <textarea id="billing_address" name="billing_address" required></textarea>
            <br>

            <label for="shipping_address">Shipping Address:</label>
            <textarea id="shipping_address" name="shipping_address" required></textarea>
            <br>

            <label for="product">Product:</label>
            <select id="product" name="product" required>
                <?php
                $products =  wc_get_products(array(
                    'status' => 'publish',
                ) );

                foreach ( $products as $product ) {
                    echo '<option value="' . $product->get_id() . '">' . $product->get_name() . '</option>';
                }
                ?>
            </select>
            <br>

            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <?php
                $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
                foreach ( $available_gateways as $gateway ) {
                    $fields = $gateway->get_form_fields();
                    echo '<option value="' . $gateway->id . '">' . $gateway->get_title() . '</option>';
                }
                ?>
            </select>
            <br>

            <?php
                foreach ( $available_gateways as $gateway ) {
                $fields = $gateway->get_form_fields();
                echo '<div class="payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display:none;">';
                echo '<h3>' . $gateway->get_title() . '</h3>';
                echo '<div class="form-row">';
                foreach ( $fields as $field ) {
                    woocommerce_form_field( $field['id'], $field, WC()->checkout->get_value( $field['id'] ) );
                }
                echo '</div>';
                echo '</div>';
                }
            ?>

            <button type="submit">Submit</button>
        </form>

    </div>

    
    <script>
        jQuery(document).ready(function($) {
            $('#order-formss').submit(function(e) {
            e.preventDefault();
        
            var customer_name = $('#customer_name').val();
            var customer_email = $('#customer_email').val();
            var customer_phone = $('#customer_phone').val();
            var billing_address = $('#billing_address').val();
            var shipping_address = $('#shipping_address').val();
            var product_id = $('#product').val();
            var product_name = $('#product option:selected').text();
        
            var data = {
                'action': 'create_subscription',
                'customer_name': customer_name,
                'customer_email': customer_email,
                'customer_phone': customer_phone,
                'billing_address': billing_address,
                'shipping_address': shipping_address,
                'product_id': product_id,
                'product_name': product_name
            };
        
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                success: function(response) {
                    alert('Order created successfully!');
                },
                error: function(response) {
                    alert('Error creating order: ' + response.responseText);
                }
            });
            });
        });        
    </script>
    <?php
}


add_action( 'wp_ajax_create_order', 'create_order' );
add_action( 'wp_ajax_nopriv_create_order', 'create_order' );

function create_order() {
  // Get the form data
  $customer_name = sanitize_text_field( $_POST['customer_name'] );
  $customer_email = sanitize_email( $_POST['customer_email'] );
  $customer_phone = sanitize_text_field( $_POST['customer_phone'] );
  $billing_address = sanitize_textarea_field( $_POST['billing_address'] );
  $shipping_address = sanitize_textarea_field( $_POST['shipping_address'] );
  $product_id = absint( $_POST['product_id'] );
  $product_name = sanitize_text_field( $_POST['product_name'] );

  // Create the customer
  $customer = new WC_Customer();
  $customer->set_email( $customer_email );
  $customer->set_billing_first_name( $customer_name );
  $customer->set_billing_phone( $customer_phone );
  $customer_id = $customer->save();

  // Create the order
  $order = wc_create_order();
  $order->set_customer_id( $customer_id );
  $order->set_billing_first_name( $customer_name );
  $order->set_billing_address_1( $billing_address );
  $order->set_shipping_first_name( $customer_name );
  $order->set_shipping_address_1( $shipping_address );


  // Add the product to the order
  $product = wc_get_product( $product_id );
  $item = new WC_Order_Item_Product();
  $item->set_product( $product );
  $item->set_quantity( 1 );
  $item->set_total( $product->get_price() ); // Set the product price
  $order->add_item( $item );
  
  // Set the payment method
  $payment_method = sanitize_text_field( $_POST['payment_method'] );
  $order->set_payment_method( $payment_method );
  
  // Calculate the order totals and save
  $order->calculate_totals();
  $order->save();

  // Return a response to the AJAX request
  wp_send_json_success( 'Order created successfully!' );
}



add_action( 'wp_ajax_create_subscription', 'create_subscription' );
add_action( 'wp_ajax_nopriv_create_subscription', 'create_subscription' );


add_shortcode('admin_join_subscription','admin_join_subscription');
function admin_join_subscription(){
    global $wpdb;

    if ( !class_exists( 'WooCommerce' ) ) {
        return true;
    }

    if(current_user_can('editor') || current_user_can('administrator') && is_user_logged_in())
    {       
   
    ob_start();

    $query = new WC_Product_Query( array(
        'limit'         => -1,
        'orderby'       => 'date',
        'post_status'   => 'publish',
        'order'         => 'DESC',
        'type'          => array('subscription','variable-subscription')
    ) );
    $products = $query->get_products();
    
    $filtered_products = array_filter($products, function($product) {
        $price = $product->get_price();
        return ($price > 0);
    });
    

    $product_info = array();

    if(!empty($filtered_products)) : 

        foreach( $filtered_products as $product ) {
        
            $product_id   = $product->get_id();        
            $product_name = $product->get_name();            
            $price = wc_price($product->get_price());        
            $product_info[$product_id] = $product_name . ' - ' . $price;                
        }

        ?>

        <form id="admin_oilcorp_registration" method="post">
            <div class="oc_container">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Membership Plans <span>*</span></label>
                        <div class="element"><select name="membership_product_id" id="membership_product_id" required>
                            <?php foreach($product_info as $pid => $membership_name){
                                $selected = '';
                                if($pid == '1851'){
                                    $selected = 'selected';
                                }
                                echo '<option value="' . $pid . '" '.$selected.'>' . $membership_name . '</option>';
                            }?>
                        </select></div>
                        <div class="sub">
                            <span>* Senior Membership is for members ages 55 & older.</span>
                        </div>
                        <div class="sub">
                            <span>* Low Volume Membership requires an annual volume of under 300 gallons annually</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="element"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-xs-6">
                        <label>Processing Fee: </label>
                    </div>
                    <div class="col-sm-8 col-xs-6">
                        <div class="element"><strong>$10.00</strong></div>
                    </div>
    
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Name <span>*</span></label>
                    </div>
                    <div class="col-sm-5 sm-mb-10">
                        <div class="element"><input type="text" name="first_name" placeholder="First Name" required /></div>
                    </div>
                    <div class="col-sm-2 sm-mb-10">
                        <div class="element"><input type="text" name="middle_name" placeholder="MI" /></div>
                    </div>
                    <div class="col-sm-5 sm-mb-10">
                        <div class="element"><input type="text" name="last_name" placeholder="Last Name" /></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-8 no_right_padding">
                        <label>Home address <span>*</span></label>
                        <div class="element">
                            <div class="col-sm-12"><input type="text" name="address_1" id="address_1" placeholder="Address Line 1" required />
                            </div>
                            <div class="col-sm-4"><input type="text" name="city" id="city" placeholder="City" required /></div>
                            <div class="col-sm-4">
                                <select name="state" id="state" required>
                                    <?php echo avlabs_join_field_type_options('state','');?>
                                </select>
                            </div>
                            <div class="col-sm-4"><input type="text" name="zip" id="zip" placeholder="Zip" required /></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Mailing Address Same as Home</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="same_mailing_address" value="1" checked /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="same_mailing_address" value="0" /> No</div>
                        </div>
                    </div>
                </div>

                <div class="form-group row hidden mailing_section">
                    <div class="col-sm-12">
                        <label>Mailing address</label>
                        <div class="element">
                            <div class="col-sm-12 no_right_padding"><input type="text" name="mailing_address_1" id="mailing_address_1"
                                    placeholder="Address Line" /></div>
                            <div class="col-sm-4 no_right_padding_mb"><input type="text" name="mailing_city" id="mailing_city" placeholder="City" /></div>
                            <div class="col-sm-4 no_right_padding_mb">
                                <select name="mailing_state" id="mailing_state">
                                    <?php echo avlabs_join_field_type_options('state','');?>
                                </select>
                            </div>
                            <div class="col-sm-4 no_right_padding"><input type="text" name="mailing_zip_code" id="mailing_zip_code" placeholder="Zip" /></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Email <span>*</span></label>
                        <div class="element"><input type="email" name="email"/></div>
                    </div>
                    
                </div>

                <div class="form-group row">

                    <div class="col-sm-3">
                        <label>Primary Phone <span>*</span></label>
                        <div class="element"><input type="tel" name="phone" required /></div>
                    </div>
                    <div class="col-sm-3">
                        <label>Primary Phone Type</label>
                        <div class="element">
                            <select name="primary_phone_type">
                                <option value="cell" seleceted>CELL</option>
                                <option value="home">HOME</option>
                                <!-- <option value="fax">FAX</option> -->
                                <option value="business">BUSINESS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label>Secondary Phone</label>
                        <div class="element"><input type="tel" name="secondary_phone" /></div>
                    </div>
                    <div class="col-sm-3">
                        <label>Secondary Phone Type</label>
                        <div class="element">
                            <select name="second_phone">
                                <option value="cell">CELL</option>
                                <option value="home" seleceted>HOME</option>
                                <!-- <option value="fax">FAX</option> -->
                                <option value="business">BUSINESS</option>
                            </select>
                        </div>
                    </div>
                </div>                    

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in discounted oil deliveries</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_oil_del" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_oil_del" value="0" checked /> No</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Current Oil Provider (optional) </label>
                        <div class="element"><input type="text" name="current_oil_provider" placeholder="Optional" /></div>
                    </div>
                </div>
                <div class="form-group row hidden current_pro_oil">
                    <div class="col-sm-12">
                        <label>I would like to stay with my current oil provider if they participate in the Co-op</label>
                        <div class="element">
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_oil_provider" value="1" /> Yes</div>
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_oil_provider" value="0" checked /> No</div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in discounted propane deliveries</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_propane_del" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_propane_del" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Current Propane Provider (optional) </label>
                        <div class="element"><input type="text" name="current_propane_provider" placeholder="Optional" /></div>
                    </div>
                </div>                
                
                <div class="form-group row hidden current_pro_propane">
                    <div class="col-sm-12">
                        <label>I would like to stay with my current propane provider if they participate in the Co-op</label>
                        <div class="element">
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_propane_provider" value="1" /> Yes</div>
                            <div class="col-sm-3 col-xs-6"><input type="radio" name="staywith_propane_provider" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I'm interested in FREE solar consultation for my home</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_free_solar_con" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_free_solar_con" value="0" checked />
                                No</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>I'm interested in home energy audit</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_energy_audit" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_energy_audit" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>I would like FREE home or auto insurance quote</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="interested_in_h_a_insurance" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="interested_in_h_a_insurance" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label>Did a member or organization refer you?</label>
                        <div class="element"><input type="text" name="who_refer_you" placeholder="Optional" /></div>
                        <div class="sub"><span>Please enter the Oil Co-op members full name so we can make sure that they get the credit! Thanks!</span></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Are you affiliated with any organizations that might want to know about the Co-op?</label>
                        <div class="element">
                            <div class="col-sm-6"><input type="radio" name="affiliated_organization" value="1" /> Yes</div>
                            <div class="col-sm-6"><input type="radio" name="affiliated_organization" value="0" checked /> No
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Organization(s)</label>
                        <div class="element"><input type="text" name="organization" placeholder="Optional" /></div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Payment Method:</label>
                        <div class="element">
                            <select name="primary_phone_type">
                                <option value="cell" seleceted>Cheque Payments</option>
                                <option value="home">Cash</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row oilco-join-btn-outer">
                    <div class="col-sm-6">
                        <input type="submit" name="submit" class="oilco-join-btn" value="Register" />
                    </div>
                </div>              

                <input type="hidden" name="op_membership_" value="1">

            </div>
        </form>

            
        <?php 
        endif; 
    }
    else
    {
        if ( is_user_logged_in() )
        {
            $user = wp_get_current_user();
            $display_name = $user->display_name;
            return '<p>Hello '.$display_name.'<br>You can Edit your profile from <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="My Account">Member Dashboard</a></p>';
            
        } 
        else  if ( !is_user_logged_in() ){
            ?>
            <div class="alert alert-danger" role="alert">
                Sorry. You must be logged-in!
            </div>
            <?php
        }

        
    }
    ?>

    <script>

        ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery(document).ready(function($) {        
  
           $('#admin_oilcorp_registration').submit(function(e) {
                e.preventDefault();       
                
                form_data = new FormData(jQuery('#admin_oilcorp_registration')[0]);
                form_data.append('action', 'create_subscription');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        var json = $.parseJSON(data);
                        if(json.result == true){                            

                            alert(json.message)
                            if(json.redirect != false){
                                location.reload();
                            }                            

                        }
                        else
                        {
                        let errors = json.error;
                            jQuery.each(errors, function( index, value ) {
                            alert(value);
                        });
                        }
                    }

                });
            });
        });        
    </script>
    <?php   

    $data = ob_get_clean();

    return $data;
}

function create_subscription() {

    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    global $wpdb;

    // Get the form data
    $customer_name = sanitize_text_field( $_POST['first_name'] );
    $customer_email = sanitize_email( $_POST['email'] );
    $customer_phone = sanitize_text_field( $_POST['phone'] );
    $billing_addresss = sanitize_textarea_field( $_POST['address_1'] );
    $shipping_address = sanitize_textarea_field( $_POST['address_1'] );
    $product_id = absint( $_POST['membership_product_id'] );

    $errors = array();
    $return = array();

    if(email_exists($customer_email)){
        // wp_send_json_error("Email ID already exists!!");     
        $return['result'] = true;
        $return['message'] = 'Email ID already exists!!';
        $return['redirect'] = false;  

        echo json_encode($return);
        die;  
    }
    else if(empty($customer_email)){
        $customer_email = 'placeholder@example.com';
    }

    // Get the product
    $product = wc_get_product( $product_id );
  
    // Create the customer
    $customer_data = array(
      'first_name' => $customer_name,
      'last_name' => $_POST['last_name'],
      'email' => $customer_email,
      'phone' => $customer_phone,
    );

    $customer_username = strtolower($customer_data['first_name']) . '_' . strtolower($customer_data['last_name']);

    if (username_exists($customer_username)) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$';
        $random_string = '';
        $length = 5; // Set the desired length of the random string
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, strlen($characters) - 1)];
        }
        $customer_username .= '_' . $random_string;
        
    }
 
    // Create the customer
    $customer = new WC_Customer();
    $customer->set_email( $customer_email );
    $customer->set_username($customer_username);    
    $customer->set_billing_first_name( $customer_name );
    $customer->set_billing_phone( $customer_phone );
    $customer_id = $customer->save();   

    if ($customer_data['email'] == 'placeholder@example.com') {
        $customer->set_email('');
        $customer->save();
    }

    // Loop through the form data
    foreach ($_POST as $key => $value) {

        // Save the data as usermeta for the logged-in user
        update_user_meta($customer_id, $key, $value);    
    }  

    $order = wc_create_order();
    $product_price = $product->get_price(); // get current price

    $new_price = $product_price + 10; // add 10 to current price

    $product->set_price($new_price); // set the new price
    $order->add_product( $product, 1 );
    $order->set_created_via( 'admin' );
    // $order->add_fee('Processing Fee', 10);
    $order->calculate_totals();
    $order->set_total( $product->get_price() );
    $order->set_customer_id( $customer_id );
    
    update_post_meta( $order->get_id(), '_billing_first_name', $_POST['first_name'] );
    update_post_meta( $order->get_id(), '_billing_last_name', $_POST['last_name'] );
    update_post_meta( $order->get_id(), '_billing_email', $_POST['email'] );
    update_post_meta( $order->get_id(), '_billing_address_1', $_POST['address_1'] );

    update_post_meta( $order->get_id(), '_billing_city', $_POST['city'] );
    update_post_meta( $order->get_id(), '_billing_state', $_POST['state'] );
    update_post_meta( $order->get_id(), '_billing_postcode', $_POST['zip'] );                        
    update_post_meta( $order->get_id(), '_billing_phone', $_POST['phone'] );

    // Set payment method to cash
    $order->set_payment_method( 'cash' );

    // Update order status to processing
    $order->update_status( 'processing' );

    // Save the order
    $order->save();

    $parent_order_id = $order->get_id(); // get the parent product id

    $subscription_data = array(
        'status'              => 'pending', // subscription status
        'customer_id'         => $customer_id,    // ID of the customer associated with the subscription
        'billing_period'      => 'year',          // billing period
        'billing_interval'    => 1,               // billing interval
        'start_date'          => gmdate( 'Y-m-d H:i:s', time() ), // start date
        'trial_length'        => 0, // trial length in days
        'trial_period'        => '', // trial period
        'expiry_date'         => '', // expiry date
        'product_id'          => $product_id, // ID of the subscription product
        'variation_id'        => '', // ID of the subscription product variation
        'price'               => '', // price of the subscription product
        'tax_percent'         => '', // tax percentage
        'sign_up_fee'         => 0, // sign-up fee
        'meta_data'           => array() // any additional metadata                                
    );

    $subscription_id = wcs_create_subscription( $subscription_data );


    if ( is_wp_error( $subscription_id ) ) {

        // echo "Oops! Something went wrong.";
        $errors['wp_error'] = __('Oops! Something went wrong.', 'avlabs-my-account');
        $return['result'] = false;
        $return['error'] = $errors;  

    } else {

        // Subscription created successfully
        $item = new WC_Order_Item_Product();
        $item->set_product( $product );
        $item->set_quantity( 1 );
        $item->set_total( $product->get_price() - 10 );
        
        $subscription = new WC_Subscription( $subscription_id );
        $subscription->set_parent_id( $parent_order_id ); // set parent order id
        $subscription->add_item( $item );
        $subscription->update_status( 'active' );                                

        update_post_meta( $order->get_id(), '_billing_first_name', $_POST['first_name'] );
        update_post_meta( $order->get_id(), '_billing_last_name', $_POST['last_name'] );
        update_post_meta( $order->get_id(), '_billing_email', $_POST['email'] );
        update_post_meta( $order->get_id(), '_billing_address_1', $_POST['address_1'] );

        update_post_meta( $order->get_id(), '_billing_city', $_POST['city'] );
        update_post_meta( $order->get_id(), '_billing_state', $_POST['state'] );
        update_post_meta( $order->get_id(), '_billing_postcode', $_POST['zip'] );                        
        update_post_meta( $order->get_id(), '_billing_phone', $_POST['phone'] );

        $created_date = $subscription->get_date_created(); 

        $current_date = new DateTime();
        $current_year = $current_date->format('Y');
        $next_payment_date = new DateTime();
    
        if ($created_date->format('n') >= 6 && $created_date->format('n') <= 12) {
            // Subscription was created between June of the previous year and January 31 of the current year
            $next_payment_date->setDate($current_year + 1, 6, 1);
        } else {
            // Subscription was created between February 1 and May 31 of the current year
            $next_payment_date->setDate($current_year + 1, 6, 1);
        }
    
        $subscription->update_dates(array(
            'next_payment' => $next_payment_date->format('Y-m-d H:i:s'),
        ));

        // Calculate totals and save the subscription
        $subscription->calculate_totals();
        $subscription->save();         

        //Update record in wp_approach_users when subscription is generate.
        $table_name = $wpdb->prefix . 'approach_users'; 
        // Get the last rec_id from the table
        $last_rec_id = $wpdb->get_var("SELECT rec_id FROM $table_name ORDER BY id DESC LIMIT 1");

        // Increment the last rec_id
        $new_rec_id = $last_rec_id + 1;
        $addresses = $_POST['address_1'];
        $numericDigits = array();
        $nonNumericString = '';

        preg_match_all('/(\d+)|([^0-9\s]+)/', $addresses, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $street_no = $match[1];
            } elseif (!empty($match[2])) {
                $street_name .= trim($match[2]) . ' ';  
            }
        }    

        $date_add = date("Y-m-d");
        
        $entry_id = $wpdb->insert(
            $table_name,
            array(
                'rec_id'        => $new_rec_id,
                'rec_type'      => 'IND',
                'FIRST_NAME'    => $_POST['first_name'],
                'LAST_NAME'     => $_POST['last_name'],
                'E_MAIL_1'      => $_POST['email'],
                'street_no'     => $street_no,
                'Street_name'   => $street_name,
                'city'          => $_POST['city'],
                'state'         => $_POST['state'],
                'zip'           => $_POST['zip'],        
                'phone_1'       => $_POST['phone'],
                'date_add'      => $date_add,
                'user_id'       => $customer_id
            )
        );
        // wp_send_json_success( 'Subscription created successfully!' );        
        $return['result'] = true;
        $return['message'] = __('Subscription created successfully', 'avlabs-my-account'); 
        $return['redirect'] = 'home'; 
        
    }    
    echo json_encode($return);
    die;
}

add_action( 'woocommerce_order_calculated_total', 'my_renewal_order_discount', 10, 2 );

function my_renewal_order_discount( $order_total, $order ) {
    // Check if the order is a renewal order.
    if ( $order->get_created_via() == 'subscription' ) {
        // Reduce the order total by $10.
        $order_total -= 10;
    }

    // Return the modified order total.
    return $order_total;
}

// add_filter( 'woocommerce_email_recipient_customer_on_hold_order', 'bbloomer_disable_customer_emails_if_disabled', 9999, 2 );
// add_filter( 'woocommerce_email_recipient_customer_processing_order', 'bbloomer_disable_customer_emails_if_disabled', 9999, 2 );
// add_filter( 'woocommerce_email_recipient_customer_completed_order', 'bbloomer_disable_customer_emails_if_disabled', 9999, 2 );
   
// function bbloomer_disable_customer_emails_if_disabled( $recipient, $order ) {

//     $page = $_GET['page'] = isset( $_GET['page'] ) ? $_GET['page'] : '';
//     if ( 'wc-settings' === $page ) {
//         return $recipient; 
//     }

//     $recipient = 'sam@itabix.com';

//     $items = $order->get_items();

//     foreach ( $items as $item ) {
//         $product_name = $item['name'];
//         $product_id = $item['product_id'];
//         $product_variation_id = $item['variation_id'];

//         // If product is Free subscription then the order email will not be sent to the user.
//         if ( $product_id == '2816' ) $recipient = 'sam@itabix.com';
//     }
    
//     return $recipient;
// }



/**
 * Add Custom Columns in Woocommerce Subscription Table list 
 */
add_filter( 'manage_edit-shop_subscription_columns', function ($columns) {
    $columns['user_details']    = __('Action');
    $columns['record_id']       = __('Record ID');
    $columns['last_name']       = __('Last Name');
    return $columns;
}, 1000);

/**
 * ADD Custom Columns Data 
 */
function avlabs_add_ownership_recordid_column_content( $column ) {
    global $post,$wpdb;
    $table_name = $wpdb->prefix . "approach_users";
   

    if ( 'record_id' === $column ) {
        // $subscription = new WC_Subscription($post->ID);
        // $customer_id = $subscription->get_customer_id();
        // $get_data = $wpdb->get_row($wpdb->prepare( "SELECT rec_id FROM $table_name WHERE user_id='$customer_id'" ) );
        // echo $get_data->rec_id;
        echo get_post_meta($post->ID, '_rec_id', true);
    }
    if ( 'last_name' === $column ) {
        $subscription_d = new WC_Subscription($post->ID);
        echo $subscription_d->get_billing_last_name();
    }
    if ( 'user_details' === $column) {
        $_rec_id = get_post_meta($post->ID, '_rec_id', true);
        $subscription_id = $post->ID;
        echo '<a href="/wp-admin/admin.php?page=user-details&sub_id='.$subscription_id.'&rec_id='. $_rec_id .'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 576 512"><path d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"/></svg></a>';
    }
}
add_action('manage_shop_subscription_posts_custom_column','avlabs_add_ownership_recordid_column_content' );

/**
 * Make Last Name column Sortable
 */
function filter_manage_edit_shop_subscription_sortable_columns( $sortable_columns ) {  
    return wp_parse_args( array( 'last_name' => '_billing_last_name', 'record_id' => '_rec_id' ), $sortable_columns );
}
add_filter( 'manage_edit-shop_subscription_sortable_columns', 'filter_manage_edit_shop_subscription_sortable_columns', 10, 1 );

/**
 * Customize Login Page
 */
add_action( 'woocommerce_after_customer_login_form', 'custom_login_text' );
function custom_login_text() {
    if( ! is_user_logged_in() ){
        //Your link
        $link = home_url( '/my-account/lost-password/' );

        // The displayed (output)
        echo '<h4>'. __("If you are an existing Co-op member logging into the new system for the first time, you'll need to create a password for your account. 
        <br /><br />Use the same email address that we send emails to.<center>
        <br /><br />
        <a href='$link'>Click here to create your password<a/>", "woocommerce").'</center></h4>';
    }
}

function add_custom_section_before_custom_fields() {
    echo '<div class="custom-section">This is a custom section.</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'add_custom_section_before_custom_fields', 5 );


// Add meta box to subscription order page
function add_oil_propane_status() {
    add_meta_box(
        'oil_propane_meta_box',
        'Oil & Propane',
        'render_oil_propane_meta_box',
        'shop_subscription',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_oil_propane_status' );

// Render content inside the meta box
function render_oil_propane_meta_box( $post ) {

    global $wpdb, $woocommerce, $post;

    $order = new WC_Order($post->ID);
    $user_id = $order->get_user_id( );

    $sql = "SELECT * FROM ". $wpdb->prefix ."approach_users WHERE user_id = '$user_id'";
    $results = $wpdb->get_results($sql);

    foreach($results as $result){
        $oil_co         = $result->oil_co;
        $oil_acct_id    = $result->OIL_ACCT_NUMBER;
        $oil_acct_id_2  = $result->OIL_ACCT_NUMBER_2;
        $oil_member     = $result->oil_member;
        $oil_program    = $result->oil_progra;
        $oil_start_date = $result->new_member;

        $timestamp = strtotime($oil_start_date);
        $formattedDate = date("M d, Y", $timestamp);
        $oil_start_date = $formattedDate;

        $propane_status = $result->PROPANE_ME;
        $propane_co     = $result->PROPANE_CO_CODE;
        $prop_start_date= $result->PROPANE_START_DATE;
        $prop_acc_number= $result->PROP_ACCT_NUMBER;
        $propane        = $result->propane;
        $type_of_ph     = $result->type_of_ph;
        $PROPANE_CO_CODE= $result->PROPANE_CO_CODE;
        $electric_c     = $result->electric_c;
        $second_loc     = $result->second_loc;        
        $how_joined     = $result->how_joined;        

        $rec_id = get_post_meta($post->ID, '_rec_id', true);  
        
        if($rec_id == $result->rec_id){
    ?>
    <style>
    .oil-formsection {  
        border: 3px solid #1d52bd;
        padding: 10px 10px 7px 10px;
        border-radius: 10px;
        background: #c3dbefd6;
        margin-bottom: 15px;
    }
    .propane-formsection {
        border: 3px solid #752f86;
        padding: 10px 10px 7px 10px;
        border-radius: 10px;
        background: #752f862e;
        margin-bottom: 15px;
    }
    .oil-form-heading{
        color: #144e98;
        font-size: 20px;
        font-weight: 600;
    }
    .propane-form-heading{
        color: #752f86;
        font-size: 20px;
        font-weight: 600;
    }    
    .form {
        display: flex;
        justify-content: left;
        align-items: center;
        column-gap: 20px;
        row-gap: 20px;
    }
    .inputgroup label {
        display: block;
        font-size: 15px;
        font-weight: 500;
        font-family: 'roboto';
        line-height: 26px;
        margin-bottom: 8px;
    }
    .inputgroup input {
        font-size: 14px;
        color: #000;
        border: 1px solid #ceceff;
        border-radius: 8px;
        line-height: 26px;
        width: 100%;
        max-width: 100%;
    }
    .inputgroup {
        width: 100%;
    }

    .inputgroup.oil-text > label{
        color: #06326a !important;
    }

    .inputgroup.propane-text > label{
        color: #752f86 !important;    
    }

    @media (max-width:992px){
        .form {
        flex-wrap: wrap;
    }
    }
    </style>

    <div class="oil-formsection">
        <div class="oil-form-heading">
            OIL 
        </div>
        <div class="form">
            <div class="inputgroup oil-text">
                <label for="">OIL Status</label>
                <input type="text" value="<?= $oil_member; ?>"> 
            </div>
            <div class="inputgroup oil-text">
                <label for="">OIL Comp.</label>
                <input type="text" value="<?= $oil_co; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">OIL Acct ID 1</label>
                <input type="text" value="<?= $oil_acct_id; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">OIL Acct ID 2</label>
                <input type="text" value="<?= $oil_acct_id_2; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">OIL Start Date</label>
                <input type="text" value="<?= $oil_start_date; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">OIL Prog.</label>
                <input type="text" value="<?= $oil_program; ?>">
            </div>
        </div>    
    </div> 

    <div class="propane-formsection">
        <div class="propane-form-heading">
            PROPANE 
        </div>
        <div class="form">
            <div class="inputgroup propane-text">
                <label for="">PROP Status</label>
                <input type="text" value="<?= $propane_status;?>">
            </div>
            <div class="inputgroup propane-text">
                <label for="">PROP Comp.</label>
                <input type="text" value="<?= $propane_co; ?>">
            </div>
            <div class="inputgroup propane-text">
                <label for="">PROP ID</label>
                <input type="text" value="<?= $propane; ?>">
            </div>         
            <div class="inputgroup propane-text">
                <label for="">PROP Start Date</label>
                <input type="text" value="<?= $prop_start_date; ?>">
            </div>
            <div class="inputgroup propane-text">
                <label for="">PROP ACCT NUMBER</label>
                <input type="text" value="<?= $prop_acc_number; ?>">
            </div>            
        </div>    
    </div>
    <div class="oil-formsection">
        <div class="oil-form-heading">
            Additional 
        </div>
        <div class="form">
            <div class="inputgroup oil-text">
                <label for="">JOINED METHOD</label>
                <input type="text" value="<?= $how_joined; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">Type of Phone</label>
                <input type="text" value="<?= $type_of_ph; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">Propane Co. Code</label>
                <input type="text" value="<?= $PROPANE_CO_CODE; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">Electric Company</label>
                <input type="text" value="<?= $electric_c; ?>">
            </div>
            <div class="inputgroup oil-text">
                <label for="">Additional Addreses</label>
                <input type="text" value="<?= $second_loc; ?>">
            </div>
        </div>    
    </div>
    <?php
        }
    }
}



/**
 * Add Custom User Profile Feild
 */
add_action( 'show_user_profile', 'avlabs_opted_out_user_profile_field_cb' );
add_action( 'edit_user_profile', 'avlabs_opted_out_user_profile_field_cb' );
function avlabs_opted_out_user_profile_field_cb( $user ) { ?>
    <style>
    .form-table input#cm-opted-out {
        position: relative;
        border: 2px solid #000;
        border-radius: 2px;
        background: none;
        cursor: pointer;
        line-height: 0;
        margin: 0 .6em 0 0;
        outline: 0;
        padding: 0 !important;
        vertical-align: text-top;
        height: 20px;
        width: 20px;
	    -webkit-appearance: none;
        opacity: .5;
    }

    .form-table input#cm-opted-out:hover {
        opacity: 1;
    }

    .form-table input#cm-opted-out:checked {
        background-color: #000;
        opacity: 1;
    }

    .form-table input#cm-opted-out:before {
        content: '';
        position: absolute;
        right: 50%;
        top: 50%;
        width: 4px;
        height: 10px;
        border: solid #FFF;
        border-width: 0 2px 2px 0;
        margin: -1px -1px 0 -1px;
        transform: rotate(45deg) translate(-50%, -50%);
        z-index: 2;
    }
    </style>
    <h3>Extra profile information</h3>
    <?php 
    $cm_opted_out = get_the_author_meta( 'opted_out_status', $user->ID );
    ?>
    <table class="form-table">
    <tr>
        <th><label for="cm-opted-out">Opted Out</label></th>
        <td><input type="checkbox" name="cm_opted_out" id="cm-opted-out" <?php if($cm_opted_out == '1' ){ ?> checked <?php } ?> value="1" class="regular-text"></td>
    </tr>
    </table>
    <?php 
}

/**
 * Saving Custom User Profile Feild 
 */
add_action( 'personal_options_update', 'avlabs_save_user_profile_field_cb' );
add_action( 'edit_user_profile_update', 'avlabs_save_user_profile_field_cb' );

function avlabs_save_user_profile_field_cb( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }
    
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }

    $cm_opted_out = sanitize_text_field( $_POST['cm_opted_out'] );
    if(!empty($cm_opted_out)){

        update_user_meta( $user_id, 'opted_out_status', $cm_opted_out );

    }else{

        delete_user_meta( $user_id, 'opted_out_status' );
        
    }
}


/**
 * Add Custom Join Message on Login Form woocommerce
 */
add_action('woocommerce_before_customer_login_form', 'custom_login_text_oilcoop', 10);
function custom_login_text_oilcoop(){
    ?>
    <style>
    .woocommerce-form-before-login {
        border: 1px solid #d3ced2;
        padding: 20px;
        margin: 10px 10px 30px 10px;
        text-align: center;
        border-radius: 5px;
        border-color: #eee;
    }
    .woocommerce-form-before-login > p {
        font-size: 16px;
        line-height: 25px;
        font-weight: 400;
    }
    </style>
    <div class="woocommerce-form-before-login">
        <p>In order to get set-up in the new system, you will need to create a password for your account.<br>When creating your password, please use the same email address where you receive emails from us.<br><br></p>
        <button type="submit" id="reset-oilcoop-pass" class="woocommerce-Button button wp-element-button" value="Click here to Create your Password">Click here to Create your Password</button>
    </div>
    <script>
        jQuery(document).ready(function(){            
            jQuery('#reset-oilcoop-pass').on('click', function(e){
                e.preventDefault();
                window.location.href = '/my-account/lost-password/';
            })
        })
    </script>
    <?php
}

/*** Year Wise Filter On Shop Subscription List ***/
function avlabs_shop_subscriptin_ct_year_filter_cb($post_type) {

    $post_slug = $post_type; 
    if($post_slug == 'shop_subscription') {
        ?>
        <input type="number" placeholder="Filter By Year" name="ss_next_p_year" id="ss-year" class="ss-year" />
        <?php
    }
}
add_action( 'restrict_manage_posts', 'avlabs_shop_subscriptin_ct_year_filter_cb' );

/*** Filter Year ***/
add_filter( 'parse_query', 'avlabs_shop_subscription_f_prefix_parse_filter' );
function  avlabs_shop_subscription_f_prefix_parse_filter($query) {
   global $pagenow;
   $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
   
   if( is_admin() && 'shop_subscription' == $current_page && 'edit.php' == $pagenow && isset( $_GET['ss_next_p_year'] ) && !empty( $_GET['ss_next_p_year'] )) {
   
        $filter_by_year = $_GET['ss_next_p_year'];

        $query->query_vars['meta_key']     = '_schedule_next_payment';
        $query->query_vars['meta_value']   = $filter_by_year;
        $query->query_vars['meta_compare'] = 'LIKE';
    }
    return $query;
}   

add_action( 'woocommerce_checkout_subscription_created', 'sw_custom_subscriptions_next_payment', 10, 3);
function sw_custom_subscriptions_next_payment( $subscription, $order, $recurring_cart ) {
  
  $order_items  = $subscription->get_items();
  $product_id   =  [];

  // Loop through order items
  foreach ( $order_items as $item_id => $item ) {
    // To get the subscription variable product ID and simple subscription  product ID
    $product_id[] = $item->get_product_id();
  }

    $upload_dir   = wp_upload_dir();
    $file = fopen( $upload_dir['basedir'].'/woocommerce_checkout_subscription_created.txt',"a");
    fwrite($file,print_r('I am In.', true));
    fclose($file);

    $new_dates = array(
        'next_payment' => date('Y-06-01 H:i:s', strtotime('+1 year', strtotime(date('Y').'-06-01')))
    );
  
    try {
        $subscription->update_dates($new_dates, 'site');
    } catch ( Exception $e ) {
        $upload_dir   = wp_upload_dir();
        $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_error_direct.txt',"a");
        fwrite($file,print_r($e->getMessage(), true));
        fclose($file);
    }
}




function check_renewal_order_status_change( $order_id, $old_status, $new_status, $order ) {
        
    global $wpdb;
    // Check for the specific status transition

    $upload_dir   = wp_upload_dir();
    
    $order_status_str = 'Order ID: '. $order_id . ', Old Status: ' . $old_status .', New Satus: '. $new_status .'\n';

    $file = fopen( $upload_dir['basedir'].'/woocommerce_order_status_change.txt',"a");
    fwrite($file,print_r($order_status_str, true));
    fclose($file);
    

    if ( $old_status === 'on-hold' && $new_status === 'processing' ) {

        $order = wc_get_order( $order_id );

        $subscription_id = get_post_meta($order_id, '_subscription_renewal', true);
        $subscription = new WC_Subscription( $subscription_id ); //added by tarun

        $new_dates = array(
            'next_payment' => date('Y-06-01 H:i:s', strtotime('+1 year', strtotime(date('Y').'-06-01')))
        );

        /**
         * Update records in wp_approach_users table
         */           
        $table_name = 'wp_approach_users'; 
        // Get the last rec_id from the table
        $last_rec_id = $wpdb->get_var("SELECT rec_id FROM $table_name ORDER BY id DESC LIMIT 1");

        // Increment the last rec_id
        $new_rec_id = $last_rec_id + 1;

        update_post_meta($subscription_id, '_rec_id', $new_rec_id);

        $user_id            = get_post_meta($subscription_id, '_customer_user', true);
        $first_name         = get_post_meta($subscription_id, '_billing_first_name', true);
        $last_name          = get_post_meta($subscription_id, '_billing_last_name', true);
        $email              = get_post_meta($subscription_id, '_billing_email', true);
        $_billing_city      = get_post_meta($subscription_id, '_billing_city', true);
        $_billing_postcode  = get_post_meta($subscription_id, '_billing_postcode', true);
        $_billing_phone     = get_post_meta($subscription_id, '_billing_phone', true);
        $_billing_state     = get_post_meta($subscription_id, '_billing_state', true);

        $billing_address    = get_post_meta($subscription_id, '_billing_address_1', true);
        $addresses = $billing_address;
        $numericDigits = array();
        $nonNumericString = '';

        preg_match_all('/(\d+)|([^0-9\s]+)/', $addresses, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $street_no = $match[1];
            } elseif (!empty($match[2])) {
                $street_name .= trim($match[2]) . ' ';    
            }
        }               
                

        // Insert into wp_approach_users table
        global $wpdb;
        $table_name = $wpdb->prefix . 'approach_users'; 
        // Check if the data already exists in the table
        $existing_user = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE user_id = %d AND FIRST_NAME LIKE %s AND LAST_NAME LIKE %s AND E_MAIL_1 = %s",
                $user_id,
                $first_name,
                $last_name,
                $email
            )
        );

        if ($existing_user) {
            // Data exists, update the post meta
            update_post_meta($new_subscription_id, '_rec_id', $existing_user->rec_id);
        } else {

            $date_add = date("Y-m-d");

            // Data doesn't exist, insert into wp_approach_users table
            $wpdb->insert(
                $table_name,
                array(
                    'rec_id'        => $new_rec_id,
                    'rec_type'      => 'IND',
                    'FIRST_NAME'    => $first_name,
                    'LAST_NAME'     => $last_name,
                    'E_MAIL_1'      => $email,
                    'street_no'     => $street_no,
                    'Street_name'   => $street_name,
                    'city'          => $_billing_city,
                    'state'         => $_billing_state,
                    'zip'           => $_billing_postcode,
                    'phone_1'       => $_billing_phone,
                    'date_add'      => $date_add,
                    'user_id'       => $user_id
                )
            );

            // Update the post meta with the new rec_id
            update_post_meta($new_subscription_id, '_rec_id', $new_rec_id);
        }
        /****************************** */
        if (wcs_order_contains_renewal($order)){
            $new_renew = 'Renew';
        }else{
            $new_renew = 'New';
        }
        $amount_rec                 =   $order->get_total();
        $date_recei                 =   $order->get_date_paid();
        $billing_ye                 =   date('Y', strtotime($date_recei));
        $formated_date_received     =   date('Y-m-d', strtotime($date_recei));
        $approach_payment_history   =   $wpdb->prefix . 'approach_payment_history'; 
        $wpdb->insert(
            $approach_payment_history,
            array(
                'rec_id'            =>  $new_rec_id,
                'date_recei'        =>  $formated_date_received,
                'billing_ye'        =>  $billing_ye,
                'amount_rec'        =>  $amount_rec,
                'payment_me'        =>  'CREDIT',
                'check_numb'        =>  '',
                'fee_waived'        =>  '',
                'payment_ty'        =>  '',
                'new_renew'         =>  $new_renew,
                'user_id'           =>  $user_id
            )
        );
        /********** Insert into wp_approach_payment_history table end *******/

        try {
            
            $subscription->update_dates($new_dates, 'site');

            $new_rec_id_str = 'Rec_id: ' . $new_rec_id . ', ';
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_gen.txt',"a");
            fwrite($file,print_r($new_rec_id_str, true));
            fclose($file);

        } catch ( Exception $e ) {
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_error_a.txt',"a");
            fwrite($file,print_r($e->getMessage(), true));
            fclose($file);
        }
    }

    if ( $old_status === 'pending' && $new_status === 'processing' ) {

        $order = wc_get_order( $order_id );            

        $subscription_id = get_post_meta($order_id, '_subscription_renewal', true);            
        $subscription = new WC_Subscription( $subscription_id ); //added by tarun

        $new_dates = array(
            'next_payment' => date('Y-06-01 H:i:s', strtotime('+1 year', strtotime(date('Y').'-06-01')))
            );

        $upload_dir   = wp_upload_dir();
        $file = fopen( $upload_dir['basedir'].'/debug-subscription-a.txt',"a");
        fwrite($file,print_r($order, true));
        fclose($file);

        /**
         * Update records in wp_approach_users table
        */           
        $table_name = 'wp_approach_users'; 
        // Get the last rec_id from the table
        $last_rec_id = $wpdb->get_var("SELECT rec_id FROM $table_name ORDER BY id DESC LIMIT 1");
        // Increment the last rec_id
        $new_rec_id = $last_rec_id + 1;

        $new_subscription_id = $order_id + 1;

        // update_post_meta($new_subscription_id, '_rec_id', $new_rec_id);

        $user_id            = get_post_meta($order_id, '_customer_user', true);
        $first_name         = get_post_meta($order_id, '_billing_first_name', true);
        $last_name          = get_post_meta($order_id, '_billing_last_name', true);
        $email              = get_post_meta($order_id, '_billing_email', true);
        $_billing_city      = get_post_meta($order_id, '_billing_city', true);
        $_billing_postcode  = get_post_meta($order_id, '_billing_postcode', true);
        $_billing_phone     = get_post_meta($order_id, '_billing_phone', true);
        $_billing_state     = get_post_meta($order_id, '_billing_state', true);

        $billing_address    = get_post_meta($order_id, '_billing_address_1', true);
        $addresses = $billing_address;
        $numericDigits = array();
        $nonNumericString = '';

        preg_match_all('/(\d+)|([^0-9\s]+)/', $addresses, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $street_no = $match[1];
            } elseif (!empty($match[2])) {
                $street_name .= trim($match[2]) . ' ';
            }
        }               
                

        // Insert into wp_approach_users table
        // global $wpdb;
        $table_name = $wpdb->prefix . 'approach_users'; 

        // Check if the data already exists in the table
        $existing_user = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE user_id = %d AND FIRST_NAME LIKE %s AND LAST_NAME LIKE %s AND E_MAIL_1 = %s",
                $user_id,
                $first_name,
                $last_name,
                $email
            )
        );

        if ($existing_user) {
            // Data exists, update the post meta
            update_post_meta($new_subscription_id, '_rec_id', $existing_user->rec_id);
        } else {

            $date_add = date("Y-m-d");

            // Data doesn't exist, insert into wp_approach_users table
            $wpdb->insert(
                $table_name,
                array(
                    'rec_id'        => $new_rec_id,
                    'rec_type'      => 'IND',
                    'FIRST_NAME'    => $first_name,
                    'LAST_NAME'     => $last_name,
                    'E_MAIL_1'      => $email,
                    'street_no'     => $street_no,
                    'Street_name'   => $street_name,
                    'city'          => $_billing_city,
                    'state'         => $_billing_state,
                    'zip'           => $_billing_postcode,
                    'phone_1'       => $_billing_phone,
                    'date_add'      => $date_add,
                    'user_id'       => $user_id
                )
            );

            // Update the post meta with the new rec_id
            update_post_meta($new_subscription_id, '_rec_id', $new_rec_id);
        }
        /****************************** */

            /********** Insert into wp_approach_payment_history table start *******/
        
        if (wcs_order_contains_renewal($order)){
            $new_renew = 'Renew';
        }else{
            $new_renew = 'New';
        }
        $amount_rec                 =   $order->get_total();
        $date_recei                 =   $order->get_date_paid();
        $billing_ye                 =   date('Y', strtotime($date_recei));
        $formated_date_received     =   date('Y-m-d', strtotime($date_recei));
        $approach_payment_history   =   $wpdb->prefix . 'approach_payment_history'; 
        $wpdb->insert(
            $approach_payment_history,
            array(
                'rec_id'            =>  $new_rec_id,
                'date_recei'        =>  $formated_date_received,
                'billing_ye'        =>  $billing_ye,
                'amount_rec'        =>  $amount_rec,
                'payment_me'        =>  'CREDIT',
                'check_numb'        =>  '',
                'fee_waived'        =>  '',
                'payment_ty'        =>  '',
                'new_renew'         =>  $new_renew,
                'user_id'           =>  $user_id
            )
        );
        /********** Insert into wp_approach_payment_history table end *******/

        try {

            $subscription->update_dates($new_dates, 'site');

            $new_rec_id_str = 'Rec_id: ' . $new_rec_id . ', ';
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_gen.txt',"a");
            fwrite($file,print_r($new_rec_id_str, true));
            fclose($file);

        } catch ( Exception $e ) {
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_error_b.txt',"a");
            fwrite($file,print_r($e->getMessage(), true));
            fclose($file);
        }


    }

    if ( $old_status === 'pending' && $new_status === 'failed' ) {

        $order = wc_get_order( $order_id );            

        $subscription_id = get_post_meta($order_id, '_subscription_renewal', true);            
        $subscription = new WC_Subscription( $subscription_id ); //added by tarun

        $new_dates = array(
            'next_payment' => date('Y-06-01 H:i:s', strtotime('+1 year', strtotime(date('Y').'-06-01')))
            );

        $upload_dir   = wp_upload_dir();
        $file = fopen( $upload_dir['basedir'].'/debug-subscription-a.txt',"a");
        fwrite($file,print_r($order, true));
        fclose($file);

        /**
         * Update records in wp_approach_users table
        */           
        $table_name = 'wp_approach_users'; 
        // Get the last rec_id from the table
        $last_rec_id = $wpdb->get_var("SELECT rec_id FROM $table_name ORDER BY id DESC LIMIT 1");
        // Increment the last rec_id
        $new_rec_id = $last_rec_id + 1;

        $new_subscription_id = $order_id + 1;

        // update_post_meta($new_subscription_id, '_rec_id', $new_rec_id);

        $user_id            = get_post_meta($order_id, '_customer_user', true);
        $first_name         = get_post_meta($order_id, '_billing_first_name', true);
        $last_name          = get_post_meta($order_id, '_billing_last_name', true);
        $email              = get_post_meta($order_id, '_billing_email', true);
        $_billing_city      = get_post_meta($order_id, '_billing_city', true);
        $_billing_postcode  = get_post_meta($order_id, '_billing_postcode', true);
        $_billing_phone     = get_post_meta($order_id, '_billing_phone', true);
        $_billing_state     = get_post_meta($order_id, '_billing_state', true);

        $billing_address    = get_post_meta($order_id, '_billing_address_1', true);
        $addresses = $billing_address;
        $numericDigits = array();
        $nonNumericString = '';

        preg_match_all('/(\d+)|([^0-9\s]+)/', $addresses, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $street_no = $match[1];
            } elseif (!empty($match[2])) {
                $street_name .= trim($match[2]) . ' ';
            }
        }               
                

        // Insert into wp_approach_users table
        // global $wpdb;
        $table_name = $wpdb->prefix . 'approach_users'; 

        // Check if the data already exists in the table
        $existing_user = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE user_id = %d AND FIRST_NAME LIKE %s AND LAST_NAME LIKE %s AND E_MAIL_1 = %s",
                $user_id,
                $first_name,
                $last_name,
                $email
            )
        );

        if ($existing_user) {
            // Data exists, update the post meta
            update_post_meta($new_subscription_id, '_rec_id', $existing_user->rec_id);
        } else {

            $date_add = date("Y-m-d");

            // Data doesn't exist, insert into wp_approach_users table
            $wpdb->insert(
                $table_name,
                array(
                    'rec_id'        => $new_rec_id,
                    'rec_type'      => 'IND',
                    'FIRST_NAME'    => $first_name,
                    'LAST_NAME'     => $last_name,
                    'E_MAIL_1'      => $email,
                    'street_no'     => $street_no,
                    'Street_name'   => $street_name,
                    'city'          => $_billing_city,
                    'state'         => $_billing_state,
                    'zip'           => $_billing_postcode,
                    'phone_1'       => $_billing_phone,
                    'date_add'      => $date_add,
                    'user_id'       => $user_id
                )
            );

            // Update the post meta with the new rec_id
            update_post_meta($new_subscription_id, '_rec_id', $new_rec_id);
        }
        /****************************** */
        try {

            $subscription->update_dates($new_dates, 'site');

            $new_rec_id_str = 'Rec_id: ' . $new_rec_id . ', ';
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_gen.txt',"a");
            fwrite($file,print_r($new_rec_id_str, true));
            fclose($file);

        } catch ( Exception $e ) {
            $upload_dir   = wp_upload_dir();
            $file = fopen( $upload_dir['basedir'].'/woocommerce_subscription_error_b.txt',"a");
            fwrite($file,print_r($e->getMessage(), true));
            fclose($file);
        }


    }
}
add_action( 'woocommerce_order_status_changed', 'check_renewal_order_status_change', 10, 4 );


// Remove Email required field from user profile
add_action('user_profile_update_errors', 'my_user_profile_update_errors', 10, 3 );
function my_user_profile_update_errors($errors, $update, $user) {
    $errors->remove('empty_email');
}

// Remove Email required field from user profile, Works for new user, user profile and edit user profile
add_action('user_new_form', 'my_user_new_form', 10, 1);
add_action('show_user_profile', 'my_user_new_form', 10, 1);
add_action('edit_user_profile', 'my_user_new_form', 10, 1);
function my_user_new_form($form_type) {
    ?>
    <script type="text/javascript">
        jQuery('#email').closest('tr').removeClass('form-required').find('.description').remove();
        // Uncheck send new user email option by default
        <?php if (isset($form_type) && $form_type === 'add-new-user') : ?>
            jQuery('#send_user_notification').removeAttr('checked');
        <?php endif; ?>
    </script>
    <?php
}

/**
 * Remove the "Change Payment Method" button from the My Subscriptions table.
 *
 * This isn't actually necessary because @see eg_subscription_payment_method_cannot_be_changed()
 * will prevent the button being displayed, however, it is included here as an example of how to
 * remove just the button but allow the change payment method process.
 */
function eg_remove_my_subscriptions_button( $actions, $subscription ) {

	foreach ( $actions as $action_key => $action ) {
		switch ( $action_key ) {
//			case 'change_payment_method':	// Hide "Change Payment Method" button?
//			case 'change_address':		// Hide "Change Address" button?
//			case 'switch':			// Hide "Switch Subscription" button?
//			case 'resubscribe':		// Hide "Resubscribe" button from an expired or cancelled subscription?
//			case 'pay':			// Hide "Pay" button on subscriptions that are "on-hold" as they require payment?
//			case 'reactivate':		// Hide "Reactive" button on subscriptions that are "on-hold"?
			case 'cancel':			// Hide "Cancel" button on subscriptions that are "active" or "on-hold"?
				unset( $actions[ $action_key ] );
				break;
			default: 
				error_log( '-- $action = ' . print_r( $action, true ) );
				break;
		}
	}

	return $actions;
}
add_filter( 'wcs_view_subscription_actions', 'eg_remove_my_subscriptions_button', 100, 2 );

function formatPhoneNumber($phone) {
    // Remove any non-numeric characters from the phone number
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 1) == '1') {
        $areaCode = substr($phone, 1, 3);
        $firstPart = substr($phone, 4, 3);
        $secondPart = substr($phone, 7, 4);
    } else {
        $areaCode = substr($phone, 0, 3);
        $firstPart = substr($phone, 3, 3);
        $secondPart = substr($phone, 6, 4);
    }

    $formattedPhoneNumber = "($areaCode) $firstPart-$secondPart";

    return $formattedPhoneNumber;
}


add_filter( 'woocommerce_subscriptions_is_recurring_fee', '__return_true' );

add_filter( 'woocommerce_cart_calculate_fees', 'add_fees', 10, 1 );

/**
 * Add Late Fee to renewals
 */
function add_fees($cart) {

    // Get the cart instance
    $cart_instance = WC()->cart;

    // Check if the cart is empty
    if ($cart_instance->is_empty()) {
        return;
    }

    // Check if late fees are enabled
    $renewal_late_fee = get_option('oilco_subscription_late_fee_status', 'off');
    if ($renewal_late_fee == 'off') {
        return;
    }

    // Get the active user IDs
    $active_users = get_option('active_users_id');

    // Loop through cart items to check if any of them is a renewal order
    foreach ($cart_instance->get_cart() as $cart_item_key => $cart_item) {

        $product = $cart_item['data'];

        $subscription_signup_fee = $product->get_meta('_subscription_sign_up_fee');

        // Check if the user ID is in the active_users array
        $user_id = get_current_user_id(); // Assuming you're checking the current user
        if(!empty($active_users)){
            if (in_array($user_id, $active_users)) {
                continue; // Skip this item for active users
            }
        }

        if(!empty($listed)){

        }

        if (!$subscription_signup_fee > 0) {
            $late_fee = get_option('oilco_subscription_late_fee', 5);
            $cart_instance->add_fee('Late Renewal Fee', $late_fee);
        }
    }
}

/**
 * Change Recurring Total Field Date on Checkout Page
 */
function avlabs_add_cart_first_renewal_payment_date( $order_total_html, $cart ) {

	if ( 0 !== $cart->next_payment_date ) {
        
		$first_renewal_date = 'June 1, 2025';
		// translators: placeholder is a date
		$order_total_html .= '<div class="first-payment-date"><small>' . sprintf( __( 'First renewal: %s', 'woocommerce-subscriptions' ), $first_renewal_date ) . '</small></div>';
	}

	return $order_total_html;
}

//First remove the original filter
remove_filter( 'wcs_cart_totals_order_total_html', 'wcs_add_cart_first_renewal_payment_date', 10, 2 );

// Our own filter to customize date.
add_filter( 'wcs_cart_totals_order_total_html', 'avlabs_add_cart_first_renewal_payment_date', 10, 2 );

// function custom_update_wp_approach_import( $post_id, $xml_node, $is_update ){
//     global $wpdb;

//     $record = json_decode( json_encode( ( array ) $xml_node), 1 );

//     $import_id = wp_all_import_get_import_id();    
    
//     $rec_id                 = $record['id'];
//     $referred_by_name       = $record['referredbyname'];
//     $date_referred          = $record['datereferred'];
//     $solar_referral_date    = $record['solarreferralsentdate'];
//     $insurance_sent_date    = $record['insurancereferralsentdate'];
//     $energy_referral_date   = $record['energyauditreferralsentdate'];
//     $other_referral_date    = $record['otherreferralsource'];
//     $referral_customer_id   = $record['referredcustomerid'];
//     $referral_calculation   = $record['referralcalculationinternalcode'];
//     $referral_status        = $record['referralstatus'];
//     $total_Referrals        = $record['totalreferrals'];


//     if(!empty($rec_id)){
//         $wpdb->query(
//             $wpdb->prepare("INSERT INTO wp_referral_records (rec_id, referred_by_name, date_referred, solar_referral_date, insurance_sent_date, energy_referral_date, other_referral_source, referred_customer_id, referral_calculation, referral_status, total_Referrals) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $rec_id, $referred_by_name, $date_referred, $solar_referral_date, $insurance_sent_date, $energy_referral_date, $other_referral_date, $referral_customer_id, $referral_calculation, $referral_status, $total_Referrals)
//         );           
//     }
// }

// add_action('pmxi_saved_post', 'custom_update_wp_approach_import', 10, 3);



// function custom_update_wp_approach_import( $post_id, $xml_node, $is_update ){
//     global $wpdb;

//     $record = json_decode( json_encode( ( array ) $xml_node), 1 );

//     $import_id = wp_all_import_get_import_id();    
    
//     $rec_id                 = $record['id'];
//     $ELECTRIC_C             = $record['electric_c'];
//     $ELECTRICI2             = $record['electrici2'];
//     $ELEC_SIGN_             = $record['elec_sign_'];
//     $ELEC_START             = $record['elec_start'];

//     if(!empty($rec_id)){
//         $wpdb->query(
//             $wpdb->prepare("INSERT INTO wp_custom_electric (rec_id, electric_status, electric_ID, electric_signup_date, electric_exp_date) VALUES (%d, %s, %s, %s, %s)", $rec_id, $ELECTRIC_C, $ELECTRICI2, $ELEC_SIGN_, $ELEC_START)
//         );           
//     }
// }

// add_action('pmxi_saved_post', 'custom_update_wp_approach_import', 10, 3);


function ar_admin_page() {
    add_menu_page(
        'Automatic Renewals',
        'Automatic Renewals',
        'manage_options',
        'ar-admin-page',
        'ar_admin_page_content'
    );
}
add_action('admin_menu', 'ar_admin_page');

function ar_admin_page_content() {

    global $wpdb;
    echo '<div class="wrap"><h2>Automatic Renewals</h2>';

    // Include necessary WooCommerce files
    if (!class_exists('WC_Subscriptions')) {
        echo '<p>WooCommerce Subscriptions is not active. Please activate it to use this feature.</p></div>';
        return;
    }

    $search_term            =   (isset($_GET['s'])) && !empty($_GET['s']) ? trim($_GET['s']) : '';
    // $search_term            =   $search_term);
    $search_key             =   isset($_GET['search_key']) && !empty($_GET['search_key']) ? $_GET['search_key'] : '';
    if(!empty($search_key) && $search_key == 'low-volume-oil-co-op-membership'){
        $product_id = '1854';
    }else if(!empty($search_key) && $search_key == 'senior-55-oil-co-op-membership'){
        $product_id = '1853';
    }else if(!empty($search_key) && $search_key == 'standard-oil-co-op-membership'){
        $product_id = '1851';
    }else{
        $product_id = '';
    }
    $query_string           =   $_SERVER['QUERY_STRING'];
    // if in the admin, your base should be the admin URL + your page
    $base = admin_url('admin.php') . '?' . remove_query_arg('p', $query_string) . '%_%';

    //get page number for pagination
    $current_page   =   max(1, isset($_GET['paged']) ? intval($_GET['paged']) : 1);
    $per_page       =   10;
    $offset         =   ($current_page - 1) * $per_page;
    $subsperpage    =   isset($_GET['pp']) && !empty($_GET['pp']) ? $_GET['pp'] : 20;	

    if(!empty($search_term)){
        // $get_subscriptions = "SELECT u.ID from `wp_users` as u LEFT JOIN `wp_posts` as p on u.ID=p.post_author 
        // WHERE p.post_type = 'shop_subscription' AND p.post_status = 'wc-active' 
        // AND u.user_email LIKE '%$search_term%' OR u.display_name LIKE '%$search_term%' 
        // GROUP BY u.ID ORDER BY u.ID DESC LIMIT $offset, $subsperpage";

        // echo $get_subscriptions;
        $args = array(
                'post_type' => 'shop_subscription',
                'post_status' => 'wc-active',
                'paged' => $current_page,
                'numberposts' => $per_page,
                'meta_query' => array(
                        array(
                                'key' => '_billing_email',
                                'value' => "$search_term",
                                'compare' => 'LIKE',
                            ),
                        array(
                                'key' => '_billing_first_name',
                                'value' => "$search_term",
                                'compare' => 'LIKE',
                            ),
                        array(
                                'key' => '_billing_last_name',
                                'value' => "$search_term",
                                'compare' => 'LIKE',
                            ),
                        'relation' => 'OR',
                    ),
            );
            
        
        $users_with_active_subscriptions =  get_posts( $args ); // $wpdb->get_results($get_subscriptions);

    }else{        
        // Display the users with active subscriptions and set per-page limit 50
        $subscriptions_args = array(
            'status' => 'active', 
            'subscriptions_per_page' => 50,
            'limit' => 50,
            'offset'=> $offset,
        );
        if(!empty($product_id)){
            $subscriptions_args['product_id'] = $product_id;
        }else{
            $subscriptions_args['product_id'] = '1851';
        }
        $users_with_active_subscriptions = wcs_get_subscriptions($subscriptions_args);
    }
    // echo '<pre>'; print_r( $users_with_active_subscriptions ); echo '</pre>';
    ?>
    <form method="get" action="<?php echo $base;?>">
        <div class="search-filter">	
                <label class="screen-reader-text" for="user-search-input">Search Subscription:</label>
                <input type="hidden" name="page" value="ar-admin-page">
                <input type="search" id="user-search-input" name="s" value="<?php echo $search_term;?>">
                <input type="submit" id="search-submit" class="button" value="Search Subscription">
        </div>
    </form>
    <!--  Advance filter -->
    <div class="filter-automatic-renewals">
        <label for="ar-filter">Memberships Filters : </label>
        <select name="filter" id="ar-filter" class="auto-rene-filters">
            <option value="">All</option>
            <option value="low-volume-oil-co-op-membership" <?php if($search_key == 'low-volume-oil-co-op-membership') echo 'selected'; ?>>Low Volume Oil Co-op Membership</option>
            <option value="senior-55-oil-co-op-membership" <?php if($search_key == 'senior-55-oil-co-op-membership') echo 'selected'; ?>>Senior (55+) Oil Co-op Membership</option>
            <option value="standard-oil-co-op-membership" <?php if($search_key == 'standard-oil-co-op-membership') echo 'selected'; ?>>Standard Oil Co-op Membership</option>
        </select>
    </div> 
    <style>
        /* Pagination Css */
       .autorenewalpagination {
        margin-top: 10px;
        text-align: left;
        }
        .autorenewalpagination a,
        .autorenewalpagination span {
            display: inline-block;
            padding: 5px 16px;
            margin-right: 5px;
            border: 1px solid #0073e6;
            background-color: #0073e6;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .autorenewalpagination a:hover {
            background-color: #005aa7;
            border-color: #005aa7;
        }
        .autorenewalpagination .current {
            background-color: #005aa7;
            border-color: #005aa7;
            pointer-events: none;
        }
    </style>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Next Payment Date</th>
            <th>Membership</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $records_count = 0; // Initialize records count variable
        foreach ($users_with_active_subscriptions as $subscription) {
            // Get the user ID
            $user_id =  get_post_meta( $subscription->ID, '_customer_user', true ); // $subscription->customer_id;
            $subscription = wc_get_order( $subscription->ID );
            // Check if the user ID meets the condition
            if (user_meets_condition($user_id, $records_count)) {
                $user_data = get_userdata($user_id);
                echo '<tr>';
                echo '<td>' . esc_html($user_id) . '</td>';
                echo '<td>' . esc_html($user_data->user_login) . '</td>';
                echo '<td>' . esc_html($user_data->user_email) . '</td>';
                echo '<td>' . esc_html($subscription->schedule_next_payment) . '</td>';
                $membership_product_id = ''; // Initialize membership product ID
                $subscription_items = $subscription->get_items();
                foreach ($subscription_items as $item) {
                    $membership_product_id = $item->get_product_id();
                    // Only retrieve the first membership product ID, assuming there is only one
                    break;
                }
                // Get the product name based on the product ID
                if ($membership_product_id) {
                    $membership_product = get_post($membership_product_id);
                    $membership_product_name = $membership_product ? $membership_product->post_title : '';
                    echo '<td>Membership: ' . esc_html($membership_product_name) . '</td>';
                } else {
                    echo '<td>Membership: N/A</td>';
                }
                echo '</tr>';
            }
        }
    ?>
    </tbody>
    </table>
    <p>Total Records Meeting the Condition: <?php echo esc_html($records_count); ?></p>
    <?php
    // Add paginatio
    //$get_count_subscriptions this is for counting the data 
    $get_count_subscriptions = array(
        'status' => 'active', 
        'subscriptions_per_page' => '-1',
        'limit' => '-1',
    );
    if(!empty($product_id)){
        $get_count_subscriptions['product_id'] = $product_id;
    }
    $count_subscriptions    =   wcs_get_subscriptions($get_count_subscriptions);
    $subscription_count     =   count($users_with_active_subscriptions);

    //Total data divided by per-page and showing in pagination link
    $total_pages = ceil($subscription_count / $per_page);
    if($total_pages > 1){
        echo '<div class="autorenewalpagination">';
        echo paginate_links(array(
            'base' => add_query_arg('paged',  '%#%'), 
            'format' => '',
            'prev_text' => __('&laquo; Previous'), 
            'next_text' => __('Next &raquo;'),
            'total' => $total_pages,
            'current' => $current_page,
        ));
        echo '</div>';
    }
    ?>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery('#ar-filter').select2();
        });
        
        jQuery(document).on('change', '#ar-filter', function(e){
            let valueSelected = jQuery(this).val();
            if(valueSelected != ''){
                let url = window.location.protocol + "//" + window.location.host + window.location.pathname;
                let newUrl = url + "?page=" + "ar-admin-page&search_key="+valueSelected;
                window.location.href = newUrl;
            }else{
                let url = window.location.protocol + "//" + window.location.host + window.location.pathname;
                let newUrl = url + "?page=" + "ar-admin-page";
                window.location.href = newUrl;
            }
        });
    </script>
    <?php
}

// Modified user_meets_condition function
function user_meets_condition($user_id, &$records_count) {
    global $wpdb;

    $sql = $wpdb->prepare(
        "SELECT tokens.token_id,
        tokens.user_id,
        tokens.gateway_id,
        tokens.token,
        tokenmeta.payment_token_id,
        tokenmeta.meta_key,
        tokenmeta.meta_value FROM wp_woocommerce_payment_tokens AS tokens
        JOIN wp_woocommerce_payment_tokenmeta AS tokenmeta
        ON tokens.token_id = tokenmeta.payment_token_id
        WHERE tokens.user_id = %d
        AND (tokenmeta.meta_key = 'last4' AND tokenmeta.meta_value != '' AND tokenmeta.meta_value != '0027')",
        $user_id
    );

    $result = $wpdb->get_var($sql);

    // Increment the records count if the condition is met
    if (!empty($result)) {
        $records_count++;
        return true;
    }

    return false;
}

