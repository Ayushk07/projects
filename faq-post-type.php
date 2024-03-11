<?php
function FAQ_post_type()
{
    $supports = array(
        'title',
        'custom-fields',
    );
    $labels = array(
        'name' => _x('FAQ', 'plural'),
        'singular_name' => _x('FAQ', 'singular'),
        'menu_name' => _x('FAQ', 'admin menu'),
        'name_admin_bar' => _x('FAQ', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New FAQ'),
        'new_item' => __('New FAQ'),
        'edit_item' => __('Edit FAQ'),
        'view_item' => __('View FAQ'),
        'all_items' => __('All FAQ'),
        'search_items' => __('Search FAQ'),
        'not_found' => __('No Input found.'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'faq'),
        'hierarchical' => true,
        'taxonomies' => array('faq_category'),
    );

    register_post_type('faq', $args);
}
add_action('init', 'FAQ_post_type');

function add_faq_meta_box() {
    add_meta_box(
        'faq_meta_box', 
        'faq Meta Box', 
        'faq_meta_box', 
        'faq', 
        'normal', 
        'default' 
    );
}
add_action('add_meta_boxes', 'add_faq_meta_box');

function faq_meta_box() {
    global $post;
    
    // Retrieve saved values from post meta
    $faq_questions = get_post_meta($post->ID, 'faq_question', true);
    $faq_contents = get_post_meta($post->ID, 'faq_content', true);
    ?>
   <style>
    
    .faq-container {
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

   
    .faq-section {
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

   
    .faq-remove-button {
        background-color: #ff6b6b;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

  
    #faq-add-more-button {
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

    
    .faq-remove-button:hover, #faq-add-more-button:hover {
        opacity: 0.8;
    }

    
</style>
    <div class="faq-container">
        <div id="faq-container_table">
            <?php if (empty($faq_questions)) : ?>
                <div class="faq-section">
                    <input type="text" name="faq_question[]" class="form-group faq-question" placeholder="Enter faq Question Here...">
                    <textarea name="faq_content[]" class="form-group faq-content" placeholder="Enter faq Content Here..."></textarea>
                    <input type="button" class="form-group faq-remove-button" value="Remove">
                </div>
            <?php else :
                foreach ($faq_questions as $key => $question) { ?>
                    <div class="faq-section">
                        <input type="text" name="faq_question[]" class="form-group faq-question" placeholder="Enter faq Question Here..." value="<?php echo esc_attr($question); ?>">
                        <textarea name="faq_content[]" class="form-group faq-content" placeholder="Enter faq Content Here..."><?php echo esc_textarea($faq_contents[$key]); ?></textarea>
                        <input type="button" class="form-group faq-remove-button" value="Remove">
                    </div>
            <?php }
            endif; ?>
        </div>
        <input type="button" id="faq-add-more-button" class="form-group faq-addmore-button" value="Add More">
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#faq-add-more-button').click(function() {
                $('#faq-container_table').append('<div class="faq-section"><input type="text" name="faq_question[]" class="form-group faq-question" placeholder="Enter faq Question Here..."><textarea name="faq_content[]" class="form-group faq-content" placeholder="Enter faq Content Here..."></textarea><input type="button" class="form-group faq-remove-button" value="Remove"></div>');
            });

            $(document).on('click', '.faq-remove-button', function() {
                $(this).parent('.faq-section').remove();
            });
        });
    </script>
    <?php
}

function save_faq_meta($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
 
    if ( isset( $_POST['faq_question'] ) ) {
        $faq_question = $_POST['faq_question'];
        update_post_meta( $post_id, 'faq_question', $faq_question );
    }

    if ( isset( $_POST['faq_content'] ) ) {
        $faq_content = $_POST['faq_content'];
        update_post_meta( $post_id, 'faq_content', $faq_content );
    }
}
add_action( 'save_post', 'save_faq_meta' );


function display_faq_fields($atts){
    $atts = shortcode_atts(
        array(
            'post_id' => null,
        ),
        $atts,
        'display_faq_post_id'
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
     body {
    background-color: #f4f4f4;
    font-family: Arial, sans-serif;
    }

    .accordion {
    max-width: 600px;
    margin: 0 auto;
    }

    .accordion-item {
    border-bottom: 1px solid #ccc;
    }

    .accordion-title {
    background-color: #f4f4f4;
    padding: 15px;
    cursor: pointer;
    border-top: 1px solid #ccc;
    color: #333;
    position: relative;
    transition: background-color 0.3s ease;
    }

    .accordion-title::after {
    content: "\25B8";
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
    }

    .accordion-content {
    padding: 15px;
    display: none;
    background-color: #fff;
    color: #333;
    transition: max-height 0.3s ease, padding 0.3s ease;
    overflow: hidden;
    }

    .accordion-item.active .accordion-title {
    background-color: #ddd;
    }

    .accordion-item.active .accordion-title::after {
    content: "\25BE";
    transform: translateY(-50%) rotate(180deg);
    }

    .accordion-item.active .accordion-content {
    display: block;
    padding-top: 0;
    padding-bottom: 15px;
    }
    </style>
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".accordion-item");
        items.forEach((item) => {
            item.addEventListener("click", function () {
                if (!this.classList.contains("active")) {
                    closeAllAccordions(); 
                    this.classList.add("active"); 
                }
            });
        });
        // Open the first accordion item on load
        items[0].classList.add("active");
        });
        function closeAllAccordions() {
            const items = document.querySelectorAll(".accordion-item");
            items.forEach((item) => {
                item.classList.remove("active"); 
            });
        }
    </script>
    <?php
    
    $faq_question = get_post_meta($post_id, 'faq_question', true);
    $faq_content = get_post_meta($post_id, 'faq_content', true);
    
    if (!empty($faq_question) && !empty($faq_content)) {
        echo '<h4>CFD Brokers FAQ</h4>';
        echo '<div class="accordion">';
        
        foreach ($faq_question as $key => $question) {
            echo '<div class="accordion-item ">';
            echo '<div class="accordion-title">' . esc_html($question) . '</div>';
            echo '<div class="accordion-content">';
            echo '<p>' . esc_html($faq_content[$key]) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    } else {
        echo '<p>No FAQs found.</p>';
    }
    
    return ob_get_clean();
}

add_shortcode('display_faq_post_id', 'display_faq_fields');

function add_shortcode_column($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_posts_columns', 'add_shortcode_column');
add_filter('manage_pages_columns', 'add_shortcode_column');

// Add shortcode column for FAQ post type
function add_shortcode_column_for_faq($columns) {
    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_FAQ_post_type_columns', 'add_shortcode_column_for_faq');

// Populate the shortcode column with the shortcode for FAQ post type
function populate_shortcode_column($column_name, $post_id) {
    if ($column_name == 'shortcode') {
        // Get the post type of the current post
        $post_type = get_post_type($post_id);

        // Check if the post type is FAQ
        if ($post_type == 'faq') {
            echo '[display_faq_post_id post_id="' . $post_id . '"]';
        }
    }
}
add_action('manage_posts_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_pages_custom_column', 'populate_shortcode_column', 10, 2);
add_action('manage_FAQ_post_type_custom_column', 'populate_shortcode_column', 10, 2);
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-autocomplete');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
