<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/* Enqueue Styles */
if (!function_exists('tw_enqueue_styles')) {
    function tw_enqueue_styles()
    {
        wp_enqueue_style('twenty-twenty-two-style', get_template_directory_uri() . '/style.css');
    }
    add_action('wp_enqueue_scripts', 'tw_enqueue_styles');
}
function create_custom_post_type()
{
    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'custom-fields',
        'comments',
        'revisions',
        'post-formats',
    );
    $labels = array(
        'name' => _x('Inputs', 'plural'),
        'singular_name' => _x('Inputs', 'singular'),
        'menu_name' => _x('Inputs', 'admin menu'),
        'name_admin_bar' => _x('Inputs', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Inputs'),
        'new_item' => __('New Inputs'),
        'edit_item' => __('Edit Inputs'),
        'view_item' => __('View Inputs'),
        'all_items' => __('All Inputs'),
        'search_items' => __('Search Inputs'),
        'not_found' => __('No Input found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'inputs'),
        'hierarchical' => true,
        'taxonomies' => array('inputs_category'),
    );

    register_post_type('inputs', $args);
}
add_action('init', 'create_custom_post_type');

function add_custom_taxonomies() {
   
    register_taxonomy('subcategories', 'inputs', array(
     
      'hierarchical' => true,
     
      'labels' => array(
        'name' => _x( 'subcategory', 'taxonomy general name' ),
        'singular_name' => _x( 'subcategory', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search subcategory' ),
        'all_items' => __( 'All subcategory' ),
        'parent_item' => __( 'Parent subcategory' ),
        'parent_item_colon' => __( 'Parent subcategory:' ),
        'edit_item' => __( 'Edit subcategory' ),
        'update_item' => __( 'Update subcategory' ),
        'add_new_item' => __( 'Add New subcategory' ),
        'new_item_name' => __( 'New subcategory Name' ),
        'menu_name' => __( 'subcategorys' ),
      ),
    
      'rewrite' => array(
        'slug' => 'subcategorys', 
        'with_front' => false, 
        'hierarchical' => true 
      ),
    ));
  }
  add_action( 'init', 'add_custom_taxonomies', 0 );
  function add_submenu_page_to_dragndrop()
  {
      add_submenu_page(
          'edit.php?post_type=inputs',
          'Dragndrop',
          'Dragndrop',
          'manage_options',
          'Dragndrop',
          'Dragndrop'
      );
  }
  add_action('admin_menu', 'add_submenu_page_to_dragndrop');
 
  function Dragndrop(){
    global $wpdb;
    $post_id = get_the_ID();
    $image1_url = get_post_meta($post_id, 'section2_image1', true);
    $image2_url = get_post_meta($post_id, 'section2_image2', true);
    $image3_url = get_post_meta($post_id, 'section2_image3', true);
    ?>
    <style>
    * {
    box-sizing: border-box;
    }
    .column {
    float: left;
    width: 50%;
    padding: 10px;
    height: 700px; 
    }
    .row:after {
    content: "";
    display: table;
    clear: both;
    }
    #div1a,#div1b,#div1c, #div2a,#div2b,#div2c {
    height: 193px;
    margin: -4px;
    padding: -7px;
    border: 1px solid black;
    }

    </style>
<script>
        function previewImages(input, targetContainerId) {
            var files = input.files;
            if (input.dataset.imageCount === undefined) {
                input.dataset.imageCount = 1;
            }
            var imageCount = parseInt(input.dataset.imageCount);

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = (function (file, count) {
                    return function (e) {
                        var image = document.createElement('img');
                        var imageId = 'drag' + count;
                        image.setAttribute('id', imageId);
                        image.setAttribute('class', 'dragged-image');
                        image.setAttribute('name', 'section2_images[]');
                        image.setAttribute('draggable', 'true');
                        image.setAttribute('ondragstart', 'drag(event)');
                        image.src = e.target.result;
                        console.log(image);
                        document.getElementById(targetContainerId).appendChild(image);

                        var hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'section2_images[]');
                        hiddenInput.setAttribute('id', imageId);
                        hiddenInput.setAttribute('class', 'section2_images');
                        hiddenInput.setAttribute('value', e.target.result);
                        document.getElementById(targetContainerId).appendChild(hiddenInput);
                        image.appendChild(hiddenInput);
                    };
                })(files[i], imageCount);

                reader.readAsDataURL(files[i]);
                imageCount++;
            }

            input.dataset.imageCount = imageCount;
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        var draggedElement = document.getElementById(data);
        console.log("Dragged Element ID:", data);
        console.log("Target Element ID:", ev.target.id);
        console.log("draggedElement:", draggedElement);
        var targetParent = ev.target.parentNode;
        console.log("targetParent",targetParent);
        var previousImage = targetParent.querySelector('.dragged-image');
        console.log("previousImage",previousImage);
        if (previousImage) {
            targetParent.insertBefore(draggedElement, previousImage.nextSibling);
        } else {
            ev.target.appendChild(draggedElement);
        }
        localStorage.setItem(data, JSON.stringify({
            parent: ev.target.id,
            index: Array.from(ev.target.parentNode.children).indexOf(draggedElement)
        }));
    }
        //    window.addEventListener('load', function () {
        //     for (var i = 1; i <= 3; i++) {
        //         var savedPosition = localStorage.getItem('drag' + i);
        //         if (savedPosition) {
        //             savedPosition = JSON.parse(savedPosition);
        //             var parentElement = document.getElementById(savedPosition.parent);
        //             var draggedElement = document.getElementById('drag' + i);
        //             parentElement.insertBefore(draggedElement, parentElement.children[savedPosition.index]);
        //             parentElement.style.color= "yellow";
        //         }
        //     }
        // });
    </script>

    <body>
        <h2>Two Equal Columns</h2>
        <div class="row">
            <div class="column" style="background-color:#aaa;">
                <h2>Section 1</h2>
                
                <div id="div1a" class="section1" ondrop="drop(event)" ondragover="allowDrop(event)">
                <input type="file" onchange="previewImages(this, 'div1a')" accept="image/*" multiple>
                </div>
                <br />
                <br />
            </div>
            <form method="POST" id="dragndropform" name="dragndropform">
                <div class="column" style="background-color:#bbb;">
                    <h2>Section 2</h2>
                    <?php wp_nonce_field('save_section2_images', 'section2_images'); ?>
                    <div id="div2a" class="section2" ondrop="drop(event)" ondragover="allowDrop(event)">
                    </div>
                    <br />
                    <br />
                </div>
                <input type="submit" style="background-color: green; float:left;color:#fff;" name="submit">
            </form>
        </div>
    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
            jQuery(document).ready(function(){
                jQuery('#dragndropform').submit(function(e){
                    e.preventDefault();
                    var formData = new FormData(this);                   
                    var nonceValue = jQuery('#section2_images').val();
                    formData.append('action', 'save_section2_images');
                    formData.append('nonce', nonceValue);
                   console.log("nonce",nonceValue);
                   console.log("formdata",formData);
                   jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl, 
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        console.log(response);
                    },
                });
                });
            });
            </script>
        <?php 
    }
    add_action('wp_ajax_save_section2_images', 'save_section2_images');
    add_action('wp_ajax_nopriv_save_section2_images', 'save_section2_images');
    function save_section2_images() {
        global $wpdb;
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'inputs'

         );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $post_id = get_the_ID() ;
                check_ajax_referer('save_section2_images', 'section2_images');
                print($_POST);
                $form_data = $_POST['form_data'];
                update_post_meta($post_id, 'form_data', $form_data);
                wp_send_json(array('status' => 'success'));
                wp_die(); 
            }
        }
    }
    add_action('admin_enqueue_scripts', 'enqueue_custom_admin_script');
    function enqueue_custom_admin_script() {
        wp_enqueue_script('custom-admin-script', get_template_directory_uri() . '/path/to/your/custom-admin-script.js', array('jquery'), null, true);
        wp_localize_script('custom-admin-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');  


function add_submenu_page_to_taxonomy()
{
    add_submenu_page(
        'edit.php?post_type=inputs',
        'Input',
        'Input',
        'manage_options',
        'input',
        'input_page'
    );
}
add_action('admin_menu', 'add_submenu_page_to_taxonomy');

function input_page()
{

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<style>
div#input_field {
    margin-top: 236px;
    margin-left: 112px;
}
</style>
<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_input';
    $query = $wpdb->get_results("SELECT useremail FROM $table_name", ARRAY_A);

    $user_emails = array();
    foreach ($query as $result) {
        $unserialized_emails = maybe_unserialize($result['useremail']);

        if ($unserialized_emails !== false && is_array($unserialized_emails)) {
            $user_emails = array_merge($user_emails, $unserialized_emails);
        } else {
            $user_emails[] = $result['useremail'];
        }
    }
    ?>
<div class="input_field" id="input_field">
    <form name="custom_field_form" method="POST">
        <?php wp_nonce_field('save_useremail', 'useremail_nonce'); ?>
        <label for="useremail">Select User Emails:</label>
        <select class="form-control select2-multi" name="useremail[]" id="useremail" multiple="multiple">
            <?php
                foreach ($user_emails as $email) {

                    echo "<option value='$email'>$email</option>";
                }
                ?>
        </select>
        <input type="submit" name="submit" value="Save">
    </form>
</div>

<script>
jQuery.noConflict();
jQuery(document).ready(function($) {
    $(".select2-multi").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });
});
</script>
   
<?php

    if (isset($_POST['submit']) && wp_verify_nonce($_POST['useremail_nonce'], 'save_useremail')) {

        $user_emails = isset($_POST['useremail']) ? array_map('sanitize_text_field', $_POST['useremail']) : array();
        $serialized_emails = serialize($user_emails);
        if (!empty($serialized_emails)) {
            $table_name = $wpdb->prefix . 'user_input';
            $wpdb->insert(
                $table_name,
                array(
                    'useremail' => $serialized_emails,
                ),
                array('%s') // Use '%s' for a string
            );
            if ($wpdb->last_error) {
                echo 'Database error: ' . $wpdb->last_error;
            } else {
                echo 'Data inserted successfully';
            }
        }
    }
}

function login_cookie()
{
    global $wpdb;
    $table = $wpdb->prefix . 'user_input';

    $select_email = $wpdb->prepare("SELECT * FROM $table ");
    $rows = $wpdb->get_results($select_email);

    foreach ($rows as $row) {
        $user_email = $row->useremail;
        echo "User Email: $user_email<br>";
    }
    $user = get_user_by('id', 1);
    $user_id = $user->ID;
    $user_login = $user->user_login;
    $useremail = $user->user_email;
    echo "User ID: $user_id, User Login: $user_login, User Email: $useremail";

    if ($useremail == $user_email) {
        global $woocommerce;
        $product_id = 38;
        $quantity = 1;
        WC()->cart->add_to_cart($product_id, $quantity);
        echo "Product added to the cart for user with email: $useremail";
    } else {
        echo "User email not found in the custom table";
    }
}
add_action('wp_login', 'login_cookie');


function cron_add_one_min($schedules)
{
    $schedules['one_min'] = array(
        'interval' => 60 * 1,
        'display' => 'Hourly'
    );

    return $schedules;
}
add_filter('cron_schedules', 'cron_add_one_min');

function my_activation()
{
    $cron_interval = 'hourly';

    if (!wp_next_scheduled('my_one_min_event')) {
        wp_schedule_event(time(), $cron_interval, 'my_one_min_event');
    }
}
add_action('wp', 'my_activation');

add_action('my_one_min_event', 'generate_pdf_for_custom_post_cron');

function generate_pdf_for_custom_post_cron()
{
   echo "hello";

}



 function role_post_type_()
{
    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'custom-fields',
        'revisions',
        'post-formats',
    );
    $labels = array(
        'name' => _x('Role', 'plural'),
        'singular_name' => _x('Role', 'singular'),
        'menu_name' => _x('Role', 'admin menu'),
        'name_admin_bar' => _x('Role', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Role'),
        'new_item' => __('New Role'),
        'edit_item' => __('Edit Role'),
        'view_item' => __('View Role'),
        'all_items' => __('All Role'),
        'search_items' => __('Search Role'),
        'not_found' => __('No Role found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'role'),
        'hierarchical' => true,
        'taxonomies' => array('role_category'),
    );

    register_post_type('role', $args);
}
function custom_fetch_api()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_input';
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    $user_emails = array();
    $query = $wpdb->get_results("SELECT useremail FROM $table_name", ARRAY_A);

    foreach ($query as $result) {
        $unserialized_emails = maybe_unserialize($result['useremail']);

        if ($unserialized_emails !== false && is_array($unserialized_emails)) {
            $user_emails = array_merge($user_emails, $unserialized_emails);
        }
    }
    foreach ($data as &$entry) {
        $entry['useremail'] = $user_emails[$entry['id']] ?? '';
    }
    return rest_ensure_response($data);
}
add_action(
    'rest_api_init',
    function () {

        register_rest_route('users/v1/wp-data', 'data', array(
            'methods'  => 'get',
            'callback' => 'custom_fetch_api',
        ));
    }
);

function insert_custom_data($data)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_input';
    $data_to_insert = isset($_POST['useremail']) ? $_POST['useremail'] : null;
    $wpdb->insert(
        $table_name,
        array('data' => $data_to_insert)
    );
    return_success_message_as_json('useremail inserted successfully.');
}
add_action(
    'rest_api_init',
    function () {

        register_rest_route('users/v1/wp-data', 'data', array(
            'methods'  => 'post',
            'callback' => 'insert_custom_data',
        ));
    }
);

function update_custom_data($data)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_input';
    $id = isset($useremail['id']) ? $useremail['id'] : null;
    $useremail_to_update = isset($useremail['useremail']) ? maybe_serialize($useremail['useremail']) : null;
    $wpdb->update(
        $table_name,
        array('useremail' => $useremail_to_update),
        array('id' => $id)
    );
    return_success_message_as_json('useremail updated successfully.');
}
add_action(
    'rest_api_init',
    function () {
        register_rest_route('users/v1/wp-data', 'data', array(
            'methods'  => 'put',
            'callback' => 'update_custom_data',
        ));
    }
);
function delete_custom_data($data)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_input';
    $id = isset($useremail['id']) ? $useremail['id'] : null;
    $wpdb->delete($table_name, array('id' => $id));
    return_success_message_as_json('useremail deleted successfully.');
}
add_action(
    'rest_api_init',
    function () {

        register_rest_route('users/v1/wp-data', 'data', array(
            'methods'  => 'delete',
            'callback' => 'delete_custom_data',
        ));
    }
);

add_action( 'woocommerce_new_order', 'wp_mail_with_hr_template' );
function wp_mail_with_hr_template( $email, $subject , $html, $headers, $order_id ){

    $order = wc_get_order( $order_id );
    $order_status  = $order->get_status();
    print($order_status);
    if($order_status === 'completed'){
    
    $finalmesssage_sub = $subject;
    $messages = '';
    ob_start();
    include_once dirname(__FILE__).'/email-templates/claim-verify-code.php';
    $messages = ob_get_contents();
    ob_end_clean();
    $body = $messages;
    $body_text = $html;
    $body = str_replace("[#body_text#]", $body_text, $body);
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $email = array('devwebnware@gmail.com', 'dev.avikalabs@gmail.com', 'ayushkarma007@gmail.com');
    foreach ( $email as $email_array ) {
        
    wp_mail($email_array, $finalmesssage_sub, $body, $headers);
    }
  }
}
