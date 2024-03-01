<?php
/**
 * Class VendorQuote
 */
if(!class_exists('VendorQuote', true)){

    class VendorQuote{
        
        public static function init(){
            add_action( 'wp_head', [__CLASS__, 'av_enque_styles_scripts'] );
            add_action( 'woocommerce_after_add_to_cart_button', [__CLASS__, 'av_write_quote_cb'] );

            //submit Product Quote
            add_action( 'wp_ajax_av_submit_quote', [__CLASS__, 'av_submit_quote'] );
            add_action( 'wp_ajax_nopriv_av_submit_quote', [__CLASS__, 'av_submit_quote'] );
        }
        
        /**
         * Enqueue Additional Stylesheet And Scripts
         */
        public static function av_enque_styles_scripts(){
            if(is_product()){
                wp_enqueue_script( 'bootstrap-scrjipt', get_stylesheet_directory_uri(). '/assets/bootstrap.min.js', array(), time(), true );
                wp_enqueue_style('bootstrap-stylesheet', get_stylesheet_directory_uri().'/assets/bootstrap.min.css', array(), time(), 'all');
            }
        }
        
        /**
         * Write A Product Quote Process
         */
        public static function av_write_quote_cb(){
            global $product;
            $product_id = $product->get_id();
            $vendor_id = 0;
            $get_user_id            =   get_current_user_id(); 
            $user_id     =   $get_user_id;
            ?>
            <div class="single-quote-process">
                <a class="btn btn-info" id="write-a-quote-btn" data-toggle="modal" data-target="#write-cw-quote">Write a Quote</a>
            </div>
            <style>
                div#write-cw-quote .modal-header {
                    display: grid;
                    position: relative;
                    overflow: hidden;
                }
                div#write-cw-quote .modal-header {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                }
                div#write-cw-quote {
                    z-index: 99999;
                }
            </style>
            <div class="modal fade" id="write-cw-quote" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h4 class="modal-title">Write Quote</h4>
                            </div>
                            <div>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body" id="quote-center">
                            <form id="av-quote-form">  
                                <input type="hidden" value="<?= $product_id ?>" name="product_id" id="product_id">
                                <input type="hidden" value="<?= $user_id ?>" name="user_id" id="user_id">
                                <?php
                                if(!is_user_logged_in()){
                                ?>
                                
                                <div class="form-group">
                                    <label for="to_name">First Name : </label>
                                    <input type="text" class="form-control" id="f_name" name="f_name">
                                </div>
                                <div class="form-group">
                                    <label for="to_name">Last Name : </label>
                                    <input type="text" class="form-control" id="l_name" name="l_name">
                                </div>
                                <div class="form-group">
                                    <label for="to_email">Email Address : </label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>                  
                                <?php } else { ?>
                                    <input type="hidden" value="<?= $vendor_id ?>" name="vendor_id" id="vendor_id">
                                <?php } ?>
                                <div class="form-group">
                                    <label for="message">Quote Description : </label>
                                    <textarea id="quote_desc" class="form-control" name="quote"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary form-control" onclick="write_a_Quote();" id="av-submit-quote-btn">Submit</button>
                            <button type="button" id="quote-modal-close-btn" class="btn btn-default form-control" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function write_a_Quote(){
                var product_id  =  jQuery('#product_id').val();
                var f_name      =  jQuery('#f_name').val();
                var l_name      =  jQuery('#l_name').val();
                var email       =  jQuery('#email').val();
                var quote       =  jQuery('#quote_desc').val();
                var vendor_id   =  jQuery('#vendor_id').val();
                var user_id     =  jQuery('#user_id').val();
                var status      =  true;
                //check product id
                if(product_id == ''){
                    jQuery('.product-id-error').remove();
                    jQuery('#product-id').after('<span class="product-id-error" style="color:red;"><strong>Product ID Error</strong></span>');
                    status = false;
                }else{
                    jQuery('.product-id-error').remove();
                }
                //check first name
                if(f_name == ''){
                    jQuery('.f_name-error').remove();
                    jQuery('#f_name').after('<span class="f_name-error" style="color:red;"><strong>This field is required.</strong></span>');
                    status = false;
                }else{
                    jQuery('.f_name-error').remove();
                }
                //check email
                if(email == ''){
                    jQuery('.email-error').remove();
                    jQuery('#email').after('<span class="email-error" style="color:red;"><strong>This field is required.</strong></span>');
                    status = false;
                }else{
                    jQuery('.email-error').remove();
                }
                //check quote description
                if(quote == ''){
                    jQuery('.quote_desc-error').remove();
                    jQuery('#quote_desc').after('<span class="quote_desc-error" style="color:red;"><strong>This field is required.</strong></span>');
                    status = false;
                }else{
                    jQuery('.quote_desc-error').remove();
                }
                //check vendor_id
                if(vendor_id == ''){
                    jQuery('.vendor-id-error').remove();
                    jQuery('#vendor-id').after('<span class="vendor-id-error" style="color:red;"><strong>Vendor ID Error</strong></span>');
                    status = false;
                }else{
                    jQuery('.vendor-id-error').remove();
                }
               // check user_id
               if(user_id == ''){
                    jQuery('.user_id-error').remove();
                    jQuery('#user_id').after('<span class="user_id-error" style="color:red;"><strong>Product ID Error</strong></span>');
                    status = false;
                }else{
                    jQuery('.user_id-error').remove();
                }
                if(status){
                    jQuery('#av-submit-quote-btn').html('Please Wait...');
                    jQuery.ajax({
                        type : "POST",
                        url : "<?php echo admin_url('admin-ajax.php'); ?>",
                        data : {
                            'action'   :  'av_submit_quote',
                            product_id :  product_id,
                            f_name     :  f_name,
                            l_name     :  l_name,
                            email      :  email,
                            quote      :  quote,
                            vendor_id  :   vendor_id,
                            user_id    :  user_id,
                        },
                        success : function(result){
                            const obj   =   JSON.parse(result);
                            var status  =   obj.status;
                            if(status){
                                jQuery('.quote-success').remove();
                                jQuery('div#quote-center').last().append('<div class="quote-success" style="width:100%; text-align:center; color:green;"><strong>Quote Submitted Successfully.</strong></div>');
                                jQuery('#av-submit-quote-btn').html('Submit');
                                setTimeout(() => {
                                    jQuery('#quote-modal-close-btn').click();
                                    location.reload();
                                }, 600);
                            }else{
                                alert('There is Something Went Wrong.');
                            }
                        },
                        error: function(xhr, status, error){
                            console.error(xhr.responseText);
                        } 
                    });
                }
            }
            </script>
            <?php
        }
        /**
         * Get Write A Quote Ajax Request
         */
        public static function av_submit_quote()
        {
            global $wpdb;
            $quotes_lists = $wpdb->prefix . 'quotes_lists';
            $users = $wpdb->prefix . 'users';

            $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
            $f_name = isset($_REQUEST['f_name']) ? $_REQUEST['f_name'] : '';
            $l_name = isset($_REQUEST['l_name']) ? $_REQUEST['l_name'] : '';
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
            $quote = isset($_REQUEST['quote']) ? $_REQUEST['quote'] : '';
            $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
          
            // existing user data inserted
            if (is_user_logged_in()) {
                $data = [
                    'product_id' => $product_id,
                    'f_name' => $f_name,
                    'l_name' => $l_name,
                    'email' => $email,
                    'quote' => $quote,
                    'user_id' => $user_id
                ];
    
                $inserted = $wpdb->insert($quotes_lists, $data);
    
                if ($inserted !== false) {
                    echo json_encode(['status' => true]);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to insert quote into database.']);
                }
    
                wp_die();
            }

            // new user registration
            if (!is_user_logged_in()) {
               
                $username = $email;
                $password = wp_generate_password(); 
                $user_id = wp_create_user($username, $password, $email);

                $new_user_data = [
                    'username' => $username,
                    'password' => $password,
                    'user_id' => $user_id,
                    
                ];
                if (is_wp_error($user_id)) {
                    echo json_encode(['status' => false, 'message' => $user_id->get_error_message()]);
                    wp_die();
                }
                $new_user_created= $wpdb->insert($users, $new_user_data);

                if ($new_user_created !== false) {
                    echo json_encode(['status' => true]);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to new user created into database.']);
                }
                
                $data = [
                    'product_id' => $product_id,
                    'f_name' => $f_name,
                    'l_name' => $l_name,
                    'email' => $email,
                    'quote' => $quote,
                    'user_id' => $user_id
                ];
    
                $inserted = $wpdb->insert($quotes_lists, $data);
    
                if ($inserted !== false) {
                    echo json_encode(['status' => true]);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to insert quote into database.']);
                }
    
                wp_die();
            }
            
        }
    }
    /**
     * Call VendorQuote init method.
     */
    VendorQuote::init();

}
