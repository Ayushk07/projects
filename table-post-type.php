<?php
function table_post_type()
{
    $supports = array(
        'title',
        'custom-fields',
    );
    $labels = array(
        'name' => _x('Table', 'plural'),
        'singular_name' => _x('Table', 'singular'),
        'menu_name' => _x('Table', 'admin menu'),
        'name_admin_bar' => _x('Table', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Table'),
        'new_item' => __('New Table'),
        'edit_item' => __('Edit Table'),
        'view_item' => __('View Table'),
        'all_items' => __('All Table'),
        'search_items' => __('Search Table'),
        'not_found' => __('No Input found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'table'),
        'hierarchical' => true,
        'taxonomies' => array('table_category'),
    );

    register_post_type('table', $args);
}
add_action('init', 'table_post_type');

function add_table_meta_box() {
    add_meta_box(
        'table_meta_box', 
        'Table Meta Box', 
        'table_meta_box', 
        'table', 
        'normal', 
        'default' 
    );
}
add_action('add_meta_boxes', 'add_table_meta_box');

function table_meta_box() {
    global $post;
    $table_titles = get_post_meta($post->ID, 'table_titles', true);
    $table_links = get_post_meta($post->ID, 'table_links', true);
    $table_buttons = get_post_meta($post->ID, 'table_buttons', true);
    ?>
    <style>
        .container {
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .section {
            display: flex;
            margin-bottom: 10px;
        }

        .form-group {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .remove-button {
            background-color: #ff6b6b;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        #add-more-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 2px 58px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-button:hover,
        #add-more-button:hover {
            opacity: 0.8;
        }
    </style>
    <div class="container">
        <div id="table-container">
            <?php if (empty($table_titles)) : ?>
                <div class="section">
                    <input type="text" name="table_title_name[]" class="form-group table-name" placeholder="Enter Title Name...">
                    <input type="text" name="table_link[]" class="form-group table-link" placeholder="Enter Link Here...">
                    <input type="text" name="table_button_name[]" class="form-group table-button" placeholder="Enter Button Name...">
                    <input type="button" class="form-group table-remove-button remove-button" value="Remove">
                </div>
            <?php else :
                foreach ($table_titles as $key => $value) { ?>
                    <div class="section">
                        <input type="text" name="table_title_name[]" class="form-group table-name" placeholder="Enter Title Name..." value="<?php echo esc_attr($value); ?>">
                        <input type="text" name="table_link[]" class="form-group table-link" placeholder="Enter Link Here..." value="<?php echo esc_attr($table_links[$key]); ?>">
                        <input type="text" name="table_button_name[]" class="form-group table-button" placeholder="Enter Button Name..." value="<?php echo esc_attr($table_buttons[$key]); ?>">
                        <input type="button" class="form-group table-remove-button remove-button" value="Remove">
                    </div>
            <?php }
            endif; ?>
        </div>
        <input type="button" id="add-more-button" class="form-group" value="Add More">
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#add-more-button').click(function() {
                $('#table-container').append('<div class="section"><input type="text" name="table_title_name[]" class="form-group table-name" placeholder="Enter Title Name..."><input type="text" name="table_link[]" class="form-group table-link" placeholder="Enter Link Here..."><input type="text" name="table_button_name[]" class="form-group table-button" placeholder="Enter Button Name..."><input type="button" class="form-group table-remove-button remove-button" value="Remove"></div>');
            });

            $(document).on('click', '.table-remove-button', function() {
                $(this).parent('.section').remove();
            });
        });
    </script>
<?php
}
function save_table_meta($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
 
    if ( isset( $_POST['table_title_name'] ) ) {
        $table_titles = $_POST['table_title_name'];
        update_post_meta( $post_id, 'table_titles', $table_titles );
    }

    if ( isset( $_POST['table_link'] ) ) {
        $table_links = $_POST['table_link'];
        update_post_meta( $post_id, 'table_links', $table_links );
    }

    if ( isset( $_POST['table_button_name'] ) ) {
        $table_buttons = $_POST['table_button_name'];
        update_post_meta( $post_id, 'table_buttons', $table_buttons );
    }
}
add_action( 'save_post', 'save_table_meta' );


function display_table_fields($atts){
    $atts = shortcode_atts(
        array(
            'post_id' => null,
        ),
        $atts,
        'display_table_post_id'
    );
    // Check if the post_id attribute is provided in the shortcode
    if (isset($atts['post_id']) && $atts['post_id']) {
        $post_id = intval($atts['post_id']);
    } else {
        // If not provided, get the current post ID
        $post_id = get_the_ID();
    }
    ob_start();
    ?>
    <style>
    table {
        width: 100%;
        border: 1px solid #ccc;
        margin-top: 20px;
        text-align: center;
    }
    
    
    th {
        background-color: #3850ac;
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
        color:white;
    }
    
    
    td {
        border: 1px solid #ccc;
        padding: 8px;
    }
    
    
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    
    a {
        color: #007bff; 
        text-decoration: none;
    }
    
    a:hover {
        text-decoration: underline;
    }
    </style>
    <?php

    $table_titles = get_post_meta($post_id, 'table_titles', true);
    $table_button_names = get_post_meta($post_id, 'table_buttons', true);
    $table_links = get_post_meta($post_id, 'table_links', true);
    //  print_r($table_button_names)
    if (!empty($table_titles) && !empty($table_links) && !empty($table_button_names)) {
        echo '<h2>Best Litecoin Casinos</h2>';
        echo '<table>';
        echo '<tr><th>Title</th><th>Link</th></tr>';
        foreach ($table_titles as $key => $title) {
            echo '<tr>';
            echo '<td>' . esc_html($title) . '</td>';
            echo '<td><a href="' . esc_url($table_links[$key]) . '">' . esc_html($table_button_names[$key]) . '</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No Data found.</p>';
    }
    return ob_get_clean();
}
add_shortcode('display_table_post_id', 'display_table_fields');

function add_shortcode_column($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_posts_columns', 'add_shortcode_column');
add_filter('manage_pages_columns', 'add_shortcode_column');

// Add shortcode column for Table post type
function add_shortcode_column_for_table($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_table_post_type_columns', 'add_shortcode_column_for_table');

// Populate the shortcode column with the shortcode for table post type
function populate_shortcode_column($column_name, $post_id) {
    if ($column_name == 'shortcode') {
        // Get the post type of the current post
        $post_type = get_post_type($post_id);

        // Check if the post type is table
        if ($post_type == 'table') {
            echo '[display_table_post_id post_id="' . $post_id . '"]';
        }
    }
}
add_action('manage_posts_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_pages_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_table_post_type_custom_column', 'populate_shortcode_column', 10, 2);
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-autocomplete');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
