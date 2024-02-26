<?php

/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles()
{

    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        HELLO_ELEMENTOR_CHILD_VERSION
    );
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20);


function custom_posttype_sports()
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
        'name' => _x('Sports', 'plural'),
        'singular_name' => _x('Sports', 'singular'),
        'menu_name' => _x('Sports', 'admin menu'),
        'name_admin_bar' => _x('Sports', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Sports'),
        'new_item' => __('New Sports'),
        'edit_item' => __('Edit Sports'),
        'view_item' => __('View Sports'),
        'all_items' => __('All Sports'),
        'search_items' => __('Search Sports'),
        'not_found' => __('No Sports found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'sports'),
        'hierarchical' => true,
        'taxonomies' => array('sports_category'),
    );

    register_post_type('sports', $args);
}

add_action('init', 'custom_posttype_sports');

// Add submenu for viewing all sports entries
// function add_viewAll_submenu_to_taxonomy()
// {
//     add_submenu_page(
//         'edit.php?post_type=sports',
//         'View All', // page title
//         'View All', // menu title
//         'manage_options',
//         'viewAll', // slug
//         'viewAll_page' // callback 
//     );
// }
// add_action('admin_menu', 'add_viewAll_submenu_to_taxonomy');

// Function to display the "View All" page
function custom_post_type()
{
    $labels = array(
        'name'               => _x('Sports', 'post type general name', 'your-text-domain'),
        'singular_name'      => _x('Sport', 'post type singular name', 'your-text-domain'),
        'menu_name'          => _x('Sports', 'admin menu', 'your-text-domain'),
        'name_admin_bar'     => _x('Sport', 'add new on admin bar', 'your-text-domain'),
        'add_new'            => _x('Add New', 'custom post', 'your-text-domain'),
        'add_new_item'       => __('Add New Sport', 'your-text-domain'),
        'new_item'           => __('New Sport', 'your-text-domain'),
        'edit_item'          => __('Edit Sport', 'your-text-domain'),
        'view_item'          => __('View Sport', 'your-text-domain'),
        'all_items'          => __('All Sports', 'your-text-domain'),
        'search_items'       => __('Search Sports', 'your-text-domain'),
        'not_found'          => __('No sports found', 'your-text-domain'),
        'not_found_in_trash' => __('No sports found in Trash', 'your-text-domain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'sports'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('sports', $args);
}

add_action('init', 'custom_post_type');


// Function to add a meta box to the custom post type
function sports_form_metabox()
{
    add_meta_box('sports_form', 'Sports Form', 'display_pagination_form', 'sports', 'normal', 'high');
}

add_action('add_meta_boxes', 'sports_form_metabox');

// Function to display the form inside the meta box
function display_pagination_form($post)
{
    // Retrieve any existing data from the database
    $name = get_post_meta($post->ID, '_sports_name', true);
    $email = get_post_meta($post->ID, '_sports_email', true);
    $phone_number = get_post_meta($post->ID, '_sports_phone_number', true);

    ob_start();
?>
    <label for="name">Name:</label>
    <input type="text" name="sports_name" id="name" value="<?php echo esc_attr($name); ?>"><br>

    <label for="email">Email:</label>
    <input type="text" name="sports_email" id="email" value="<?php echo esc_attr($email); ?>"><br>

    <label for="phone_number">Phone Number:</label>
    <input type="text" name="sports_phone_number" id="phone_number" value="<?php echo esc_attr($phone_number); ?>"><br>
<?php
    echo ob_get_clean();
}

// Save the form data when the post is saved
function save_pagination_form_data($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['sports_name'])) {
        update_post_meta($post_id, '_sports_name', sanitize_text_field($_POST['sports_name']));
    }

    if (isset($_POST['sports_email'])) {
        update_post_meta($post_id, '_sports_email', sanitize_email($_POST['sports_email']));
    }

    if (isset($_POST['sports_phone_number'])) {
        update_post_meta($post_id, '_sports_phone_number', sanitize_text_field($_POST['sports_phone_number']));
    }

    // Save data to the custom table
    global $wpdb;
    $name = sanitize_text_field($_POST['sports_name']);
    $email = sanitize_email($_POST['sports_email']);
    $phone_number = sanitize_text_field($_POST['sports_phone_number']);

    $table_name = $wpdb->prefix . 'pagination';

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
        )
    );
}
add_action('save_post', 'save_pagination_form_data');

function add_pagination_submenu()
{
    add_submenu_page(
        'edit.php?post_type=sports', // Parent menu
        'View All', // Page title
        'View All', // Menu title
        'manage_options', // Capability
        'view-all-pagination', // Menu slug
        'display_pagination_data' // Callback function
    );
}

add_action('admin_menu', 'add_pagination_submenu');
function enqueue_pagination_styles()
{
    wp_enqueue_style('pagination-styles', plugins_url('pagination-styles.css', __FILE__));
}

// Add the CSS enqueue action
add_action('admin_enqueue_scripts', 'enqueue_pagination_styles');
// Function to display the "View All" page with pagination
function display_pagination_data()
{
    global $wpdb;
    $count = 1;
    $table_name = $wpdb->prefix . 'pagination';

    // Determine the current page will neve less than 1 and check query parameter paged specify or not 
    $current_page = max(1, isset($_GET['paged']) ? intval($_GET['paged']) : 1);

    $per_page = 10; // Number of items to display per page
    $count = ($current_page - 1) * $per_page + 1;
    // Calculate the offset
    $offset = ($current_page - 1) * $per_page;
    echo '<form method="get" action="">';
    echo '<label for="user_search">Search:</label>';
    echo '<input type="text" id="user_search" name="user_search" value="' . esc_attr($_GET['user_search']) . '">';
    echo '<input type="submit" value="Search">';
    echo '</form>';

    // Modify the query based on the search input
    $search_term = isset($_GET['user_search']) ? sanitize_text_field($_GET['user_search']) : '';
    $where_clause = '';
    if (!empty($search_term)) {
        $where_clause = $wpdb->prepare(
            "WHERE name LIKE %s OR email LIKE %s OR phone_number LIKE %s",
            '%' . $wpdb->esc_like($search_term) . '%',
            '%' . $wpdb->esc_like($search_term) . '%',
            '%' . $wpdb->esc_like($search_term) . '%'
        );
    }

    // Query the database with pagination
    $results = $wpdb->get_results("SELECT * FROM $table_name LIMIT $per_page OFFSET $offset", ARRAY_A);



    echo '<style>
    /* Style the table */
    .pagination-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .pagination-table th,
    .pagination-table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ccc;
    }

    .pagination-table th {
        background-color: #f0f0f0;
    }

    /* Style the pagination links */
    .pagination {
        margin-top: 20px;
    }

    .pagination a {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 5px;
        border: 1px solid #ccc;
        background-color: #f0f0f0;
        text-decoration: none;
    }

    .pagination .current {
        background-color: #0073e6;
        color: #fff;
        border: 1px solid #0073e6;
    }
   
</style>';
    echo '<h1>All User Data</h1>';
    echo '<table class="pagination-table">';
    echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone-Number</th></tr>';

    foreach ($results as $row) {

        // echo '<tr>'.$count++;
        echo '<td>' . $count++ . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['phone_number'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    // Add pagination links
    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_items / $per_page);

    if ($total_pages > 1) {
        echo '<div class="pagination">';
        echo paginate_links(array(
            'base' => add_query_arg('paged',  '%#%'), //generate link on paged number 
            'format' => '',
            'prev_text' => __('&laquo; Previous'), //<<
            'next_text' => __('Next &raquo;'), //>>
            'total' => $total_pages,
            'current' => $current_page,
        ));
        echo '</div>';
    }
}

add_action('admin_menu', 'add_pagination_submenu');


add_action('woocommerce_thankyou', 'bbloomer_redirectcustom');

function bbloomer_redirectcustom($order_id)
{
    $order = wc_get_order($order_id);
    $url = 'http://localhost/0701/thankyou?order_id=' . $order_id;
    if (!$order->has_status('failed')) {
        wp_safe_redirect($url);
        exit;
    }
}

function shortcode($order_id)
{
    ob_start();

    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
    $order = wc_get_order($order_id);
    if ($order) {
        $billing_first_name = $order->get_billing_first_name();
        $billing_email = $order->get_billing_email();
    }
    return ob_get_clean();
?>

    <body>
        <div>
            <table>

                <tr>
                    <th>Order Id</th>
                    <td><?php echo $order_id ?></td>
                </tr>
                <tr>
                    <th>User</th>
                    <td><?php echo $billing_first_name ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $billing_email ?></td>
                </tr>
                <?php
                ob_start();
                $product = $order->get_items();

                foreach ($product as $product) {

                    $product_name = $product->get_name();
                    $product_price = $product->get_total();
                    $product_subtotal = $order->get_subtotal();
                }
                return ob_get_clean();
                ?>
                <tr>
                    <th>Product-Name</th>
                    <td><?php echo $product_name ?></td>
                </tr>
                <tr>
                    <th>SubTotal</th>
                    <td><?php echo wc_price($product_subtotal) ?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td><?php echo wc_price($product_price) ?></td>
                </tr>
        </div>
    </body>
<?php
    return ob_get_clean();
}


add_shortcode('code', 'shortcode');
