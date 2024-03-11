<?php
function pro_n_cons_post_type()
{
    $supports = array(
        'title',
        'custom-fields',
    );
    $labels = array(
        'name' => _x('ProNCons', 'plural'),
        'singular_name' => _x('ProNCons', 'singular'),
        'menu_name' => _x('ProNCons', 'admin menu'),
        'name_admin_bar' => _x('ProNCons', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New ProNCons'),
        'new_item' => __('New ProNCons'),
        'edit_item' => __('Edit ProNCons'),
        'view_item' => __('View ProNCons'),
        'all_items' => __('All ProNCons'),
        'search_items' => __('Search ProNCons'),
        'not_found' => __('No Input found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'proncons'),
        'hierarchical' => true,
        'taxonomies' => array('proncons_category'),
    );

    register_post_type('proncons', $args);
}
add_action('init', 'pro_n_cons_post_type');

function add_proncons_meta_box() {
    add_meta_box(
        'proncons_meta_box', 
        'ProNCons Meta Box', 
        'proncons_meta_box', 
        'proncons', 
        'normal', 
        'default' 
    );
}
add_action('add_meta_boxes', 'add_proncons_meta_box');

function proncons_meta_box() {
    global $post;
    
    // Retrieve saved values from post meta
    $proncons_pros = get_post_meta($post->ID, 'proncons_pros', true);
    $proncons_cons = get_post_meta($post->ID, 'proncons_cons', true);
    ?>
   <style>
    
    .proncons-container {
        
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

   
    .proncons-section {
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

   
    .proncons-remove-button {
        background-color: #ff6b6b;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

  
    #add-more-button_proncons {
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

    
    .proncons-remove-button:hover, #add-more-button_proncons:hover {
        opacity: 0.8;
    }

    
</style>
    <div class="proncons-container">
        <div id="proncons-container-table">
            <?php if (empty($proncons_pros)) : ?>
                <div class="proncons-section">
                    <textarea name="proncons_pros[]" class="form-group proncons-pros" placeholder="Enter Pros Here..."></textarea>
                    <textarea name="proncons_cons[]" class="form-group proncons-cons" placeholder="Enter Cons Here..."></textarea>
                    <input type="button" class="form-group proncons-remove-button " value="Remove">
                </div>
            <?php else :
                foreach ($proncons_pros as $key => $value) { ?>
                    <div class="proncons-section">
                        <textarea name="proncons_pros[]" class="form-group proncons-pros" placeholder="Enter Pros Here..."><?php echo esc_textarea($value); ?></textarea>
                        <textarea name="proncons_cons[]" class="form-group proncons-cons" placeholder="Enter Cons Here..."><?php echo esc_textarea($proncons_cons[$key]); ?></textarea>
                        <input type="button" class="form-group proncons-remove-button " value="Remove">
                    </div>
            <?php }
            endif; ?>
        </div>
        <input type="button" id="add-more-button_proncons" class="form-group proncons-addmore-button" value="Add More">
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#add-more-button_proncons').click(function() {
                $('#proncons-container-table').append('<div class="proncons-section"><textarea name="proncons_pros[]" class="form-group proncons-pros" placeholder="Enter Pros Here..."></textarea><textarea name="proncons_cons[]" class="form-group proncons-cons" placeholder="Enter Cons Here..."></textarea><input type="button" class="form-group proncons-remove-button " value="Remove"></div>');
            });

            $(document).on('click', '.proncons-remove-button', function() {
                $(this).parent('.proncons-section').remove();
            });
        });
    </script>
    <?php
}

function save_proncons_meta($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
 
    if ( isset( $_POST['proncons_pros'] ) ) {
        $proncons_pros = $_POST['proncons_pros'];
        
        update_post_meta( $post_id, 'proncons_pros', $proncons_pros );
    }
    if ( isset( $_POST['proncons_cons'] ) ) {
        $proncons_cons = $_POST['proncons_cons'];
        update_post_meta( $post_id, 'proncons_cons', $proncons_cons );
    }
}
add_action( 'save_post', 'save_proncons_meta' );
function display_proncons_fields($atts){
    $atts = shortcode_atts(
        array(
            'post_id' => null,
        ),
        $atts,
        'display_proncons_post_id'
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
    
    $proncons_pros = get_post_meta($post_id, 'proncons_pros', true);
    $proncons_cons = get_post_meta($post_id, 'proncons_cons', true);
    
    if (!empty($proncons_pros) && !empty($proncons_cons)) {
        echo '<table>';
        echo '<tr><th>Pros</th><th>Cons</th></tr>';
        
        foreach ($proncons_pros as $key => $proncons) {
            echo '<tr>';
            echo '<td>' . esc_html($proncons) . '</td>';
            echo '<td>' . esc_html($proncons_cons[$key]) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p>No pros and cons found.</p>';
    }
    
    return ob_get_clean();
}
add_shortcode('display_proncons_post_id', 'display_proncons_fields');

function add_shortcode_column($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_posts_columns', 'add_shortcode_column');
add_filter('manage_pages_columns', 'add_shortcode_column');

// Add shortcode column for Proncons post type
function add_shortcode_column_for_proncons($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_pro_n_cons_post_type_columns', 'add_shortcode_column_for_proncons');

// Populate the shortcode column with the shortcode for Proncons post type
function populate_shortcode_column($column_name, $post_id) {
    if ($column_name == 'shortcode') {
        // Get the post type of the current post
        $post_type = get_post_type($post_id);

        // Check if the post type is Proncons
        if ($post_type == 'proncons') {
            echo '[display_proncons_post_id post_id="' . $post_id . '"]';
        }
    }
}
add_action('manage_posts_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_pages_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_pro_n_cons_post_type_custom_column', 'populate_shortcode_column', 10, 2);
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-autocomplete');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
