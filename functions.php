<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit('ggg');

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    
    function child_theme_configurator_css() {

        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'astra-theme-css','astra-contact-form-7' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );
// END ENQUEUE PARENT ACTION


function add_custom_stylesheet_above_meta() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/style.css"/>';
}
add_action('wp_head', 'add_custom_stylesheet_above_meta', -1); // Priority -1 to ensure it appears before meta tags

// Elementor Font swap
function update_font_display() {
	return 'swap'; // Or any other value.
}
add_filter( 'elementor_pro/custom_fonts/font_display', 'update_font_display' );

add_shortcode('custom_breadcrumbs', 'custom_breadcrumb_shortcode');
function custom_breadcrumb_shortcode() {
    ob_start();
    if (is_singular('gd_place') || is_singular('gd_suppliers') || is_singular('gd_weddings') || is_singular('gd_blogs') || is_singular('gd_rwedding_blogs')) {
        global $post;

        $parent_post_type_object = get_post_type_object($post->post_parent);
        if ($parent_post_type_object) {
            $parent_post_type = $parent_post_type_object->labels->singular_name;
        } else {
          
            $parent_post_type = 'Unknown';
        }
        $post_type = get_post_type($post);
        $post_type_object = get_post_type_object($post_type);
        if ($post_type_object) {
            $cpt_url = $post_type_object->rewrite['slug'];
            $post_title = get_the_title();
            // echo '<pre>';
            // print_r($post_title);
            // echo '</pre>';
            // die();
            echo '<a href="' . home_url() . '">French Weddings</a> > <a href="' . home_url() .'/' . $cpt_url . '"> ' . $post_type_object->label . '</a> <span class="bread_icn">></span> ' . $post_title;
        } else {
            echo 'Breadcrumb not available';
        }
    } else {
        echo 'Breadcrumb not available';
    }
    return ob_get_clean();
}


/*
add_shortcode('custom_breadcrumbs', 'custom_breadcrumb_shortcode');
function custom_breadcrumb_shortcode() {
    // if( is_admin() ){ return; }
    ob_start();
    // Check if it's a singular post
    if (is_singular('gd_place') || is_singular('gd_suppliers') || is_singular('gd_weddings') || is_singular('gd_blogs') || is_singular('gd_rwedding_blogs')) {
        global $post;

        // Get the parent post type
        $parent_post_type = get_post_type_object($post->post_parent)->labels->singular_name;

        $post_type = get_post_type($post);
        $post_type_object = get_post_type_object($post_type);

        $cpt_url = $post_type_object->rewrite['slug'];

        // Get the post title
        $post_title = get_the_title();

        echo '<a href="' . home_url() . '">French Weddings</a> > <a href="' . home_url() .'/' . $cpt_url . '"> ' . $post_type_object->label . '</a> > ' . $post_title;
    } else {
        echo 'Breadcrumb not available';
    }
    return ob_get_clean();
}*/



/* page revision filter */

add_action('wp_footer', function(){
	?>
    
	<script>
		jQuery(document).ready(function($){
			let $scrollContainer = jQuery('.gallery_mobile_slide');
			let $scrollContent = jQuery('.gallery_mobile_slide .elementor-gallery__container');
			let dragging = false;
			let touchMoveX = 0;
			let touchStartX = 0;
			let touchStartY = 0;
			let touchMoveY = 0;
			let deltaX = 0;
			let direction = '';

			// mousedown
			// $scrollContainer.on('touchstart', function (e) {
			// 	dragging = true;
			// 	touchStartX = e.originalEvent.touches[0].pageX;
			// });

			// mouseup
			// $scrollContainer.on('touchend', function (e) {
			// 	dragging = false;
			// 	touchStartX = 0;
			// });

			// mousedown
			$scrollContainer.on('touchstart', handleTouchStart);

			// mouseup
			$scrollContainer.on('touchend', handleTouchEnd);

			// mousemove
			$scrollContainer.on('touchmove', function (e) {
				if (!dragging) { return false; }
				// e.preventDefault();
				touchMoveX = e.originalEvent.touches[0].pageX;
				touchMoveY = e.originalEvent.touches[0].pageY;

				deltaX = touchStartX - touchMoveX;
				deltaY = touchStartY - touchMoveY;

				// direction = deltaX > 0 ? 'left' : 'right';

				if (Math.abs(deltaX) > Math.abs(deltaY)) {
					direction = (deltaX > 0) ? 'right' : 'left';
				} else {
					direction = (deltaY > 0) ? 'down' : 'up';
				}

				if( direction === 'down' || direction === 'up' ){
					return true;
				}

                let itemSize = $scrollContent.find('.e-gallery-item').innerWidth();


				if (direction == 'left') {
					e.preventDefault();
					$scrollContent.stop().animate({ scrollLeft: '-=' + '370' + 'px' }, 'fast');
				} else if (direction == 'right') {
					e.preventDefault();
					$scrollContent.stop().animate({ scrollLeft: '+=' + '370' + 'px' }, 'fast');
				}

				touchStartX = touchMoveX;
				touchStartY = touchMoveY;
			});


			let $scrolldiv = jQuery('.mob_wedding_links.mob_slider_listing');
			let $scroller_div = jQuery('.mob_wedding_links.mob_slider_listing .geodir_locations');

			// mousedown
			// $scrolldiv.on('touchstart', function (e) {
			// 	dragging = true;
			// 	touchStartX = e.originalEvent.touches[0].pageX;
			// });

			// mouseup
			// $scrolldiv.on('touchend', function (e) {
			// 	dragging = false;
			// 	touchStartX = 0;
			// });

			// mousedown
			$scrolldiv.on('touchstart', handleTouchStart);

			// mouseup
			$scrolldiv.on('touchend', handleTouchEnd);

			// mousemove
			$scrolldiv.on('touchmove', function (e) {
				if (!dragging) { return false; }
				// e.preventDefault();
				touchMoveX = e.originalEvent.touches[0].pageX;
				touchMoveY = e.originalEvent.touches[0].pageY;

				deltaX = touchStartX - touchMoveX;
				deltaY = touchStartY - touchMoveY;

				// direction = deltaX > 0 ? 'left' : 'right';

				if (Math.abs(deltaX) > Math.abs(deltaY)) {
					direction = (deltaX > 0) ? 'right' : 'left';
				} else {
					direction = (deltaY > 0) ? 'down' : 'up';
				}

				if( direction === 'down' || direction === 'up' ){
					return true;
				}

				if (direction == 'left') {
					e.preventDefault();
					$scroller_div.stop().animate({ scrollLeft: '-=' + '370' + 'px' }, 'fast');
				} else if (direction == 'right') {
					e.preventDefault();
					$scroller_div.stop().animate({ scrollLeft: '+=' + '370' + 'px' }, 'fast');
				}

				touchStartX = touchMoveX;
				touchStartY = touchMoveY;
			});

			let $trustedDiv = jQuery('.trusted_supplier_list.mob_slider_listing');
			let $trustedScroll = jQuery('.trusted_supplier_list.mob_slider_listing .geodir_locations');

			// mousedown
			// $trustedDiv.on('touchstart', function (e) {
			// 	dragging = true;
			// 	touchStartX = e.originalEvent.touches[0].pageX;
			// });

			// mouseup
			// $trustedDiv.on('touchend', function (e) {
			// 	dragging = false;
			// 	touchStartX = 0;
			// });

			// mousedown
			$trustedDiv.on('touchstart', handleTouchStart);

			// mouseup
			$trustedDiv.on('touchend', handleTouchEnd);

			// mousemove
			$trustedDiv.on('touchmove', function (e) {
				if (!dragging) { return false; }
				// e.preventDefault();
				touchMoveX = e.originalEvent.touches[0].pageX;
				touchMoveY = e.originalEvent.touches[0].pageY;

				deltaX = touchStartX - touchMoveX;
				deltaY = touchStartY - touchMoveY;

				// direction = deltaX > 0 ? 'left' : 'right';

				if (Math.abs(deltaX) > Math.abs(deltaY)) {
					direction = (deltaX > 0) ? 'right' : 'left';
				} else {
					direction = (deltaY > 0) ? 'down' : 'up';
				}

				if( direction === 'down' || direction === 'up' ){
					return true;
				}

				if (direction == 'left') {
					e.preventDefault();
					$trustedScroll.stop().animate({ scrollLeft: '-=' + '370' + 'px' }, 'fast');
				} else if (direction == 'right') {
					e.preventDefault();
					$trustedScroll.stop().animate({ scrollLeft: '+=' + '370' + 'px' }, 'fast');
				}

				touchStartX = touchMoveX;
				touchStartY = touchMoveY;
			});

			let $activity = jQuery('.activity_block');
            //   console.log("activity", $activity);
			// mousedown
			// $activity.on('touchstart', function (e) {
			// 	dragging = true;
			// 	touchStartX = e.originalEvent.touches[0].pageX;
			// });

			// mouseup
			// $activity.on('touchend', function (e) {
			// 	dragging = false;
			// 	touchStartX = 0;
			// });

			// mousedown
			$activity.on('touchstart', handleTouchStart);

			// mouseup
			$activity.on('touchend', handleTouchEnd);

			// mousemove
			$activity.on('touchmove', function (e) {
				if (!dragging) { return false; }
				// e.preventDefault();
				touchMoveX = e.originalEvent.touches[0].pageX;
				touchMoveY = e.originalEvent.touches[0].pageY;

				deltaX = touchStartX - touchMoveX;
				deltaY = touchStartY - touchMoveY;
				// direction = deltaX > 0 ? 'left' : 'right';

				if (Math.abs(deltaX) > Math.abs(deltaY)) {
					direction = (deltaX > 0) ? 'right' : 'left';
				} else {
					direction = (deltaY > 0) ? 'down' : 'up';
				}

				if( direction === 'down' || direction === 'up' ){
					return true;
				}

				if (direction == 'left') {
					e.preventDefault();
					$activity.stop().animate({ scrollLeft: '-=' + '370' + 'px' }, 'fast');
				} else if (direction == 'right') {
					e.preventDefault();
					$activity.stop().animate({ scrollLeft: '+=' + '370' + 'px' }, 'fast');
				}

				touchStartX = touchMoveX;
				touchStartY = touchMoveY;
			});

			// function to handle touch start
			function handleTouchStart(e){
				dragging = true;
				touchStartX = e.originalEvent.touches[0].pageX;
				touchStartY = e.originalEvent.touches[0].pageY;
			}

			// funciton to handle touch end
			function handleTouchEnd(e){
				dragging = false;
				touchStartX = 0;
				touchStartY = 0;
			}
		});


        jQuery(document).ready(function($) {
    tinymce.init({
        selector: "textarea",
        plugins: "textcolor image",
        toolbar: "forecolor image",
        menubar: false,
        textcolor_cols: "5",
        textcolor_rows: "5",
        image_advtab: true,
        image_dimensions: false,
        image_resizing: true
    });


});
    </script>
	<?php
});

/**
 * Export post menu on dashboard
 */
add_action('admin_menu', 'Export_Post_dashboard_menu');
function Export_Post_dashboard_menu() {
    add_menu_page(
        'Export Post',
        'Export Post',
        'manage_options',
        'export_post_menu',
        'export_post_menu_page',
        'dashicons-download',
        30
    );
}

/**
 * Call Back function Export Post
 */
function export_post_menu_page() {
    global $wpdb;
    $posts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish'");
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery("#multiple").select2({
                placeholder: "Select a Export post",
                allowClear: true
            });
        });
    </script>
    <form method="post" action="">
        <div class="select-export-post">
        <select name="export_posts[]" id="multiple" class="js-states form-control" multiple>
            <option value="">Select Export Posts</option>
            <?php foreach ($posts as $post) : ?>
                <option value="<?php echo esc_attr($post->ID); ?>"><?php echo esc_html($post->post_title); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="export" value="Export as CSV" class="button-primary">
        <input type="submit" name="export" value="Export as XML" class="button-primary">
        </div>

    </form>
    <?php
}


function export_port() {
    global $wpdb;

    if (isset($_POST['export']) && !empty($_POST['export_posts'])) {
        $selected_posts = $_POST['export_posts'];
        $csv_or_xml = $_POST['export'];

        $meta_keys_query = $wpdb->get_results("SELECT DISTINCT(meta_key) FROM $wpdb->postmeta");
        $meta_keys = array_map(function ($entry) {
            return $entry->meta_key;
        }, $meta_keys_query);

        if ($csv_or_xml == 'Export as CSV') {

            $channel_info = array(
                'title' => 'French Wedding Style',
                'link' => 'https://frenchweddingstyle.com',
                'description' => 'No 1 Platform for French styled weddings and weddings in France',
                'pubDate' => date('D, d M Y H:i:s O'),
                'language' => 'en-US',
                'wp:wxr_version' => '1.2',
                'wp:base_site_url' => 'https://frenchweddingstyle.com',
                'wp:base_blog_url' => 'https://frenchweddingstyle.com'
            );

            export_posts_as_csv($selected_posts, $meta_keys, $channel_info);
        } elseif ($csv_or_xml == 'Export as XML') {
            export_posts_as_xml($selected_posts, $meta_keys);
        }
    }
}

/**
 * export data from csv file
 */
function export_posts_as_csv($selected_posts, $meta_keys, $channel_info) {
    global $wpdb;
    $csv_filename = 'exported_posts.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $csv_filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $output = fopen('php://output', 'w');

    foreach ($selected_posts as $post_id) {
        $post = get_post($post_id);
        $post_title = $post->post_title;
        $post_content = apply_filters('the_content', $post->post_content);
        $featured_image_url = '';
        $featured_image_id = get_post_thumbnail_id($post_id);
        if ($featured_image_id) {
            $featured_image_url = wp_get_attachment_url($featured_image_id);
        }

        $post_title = htmlspecialchars($post_title);
        $post_content = htmlspecialchars($post_content);

        $post_content = str_replace(array("\r\n", "\r", "\n"), '[br]', $post_content);

        $csv_data = array(
            $post_title . PHP_EOL,
            $post_content . PHP_EOL,
            $featured_image_url
        );


        fputcsv($output, $csv_data);
    }

    fclose($output);
    exit;
}

/**
 * export data from xml file
 */
function export_posts_as_xml($posts, $meta_keys) {
    $filename = 'exported_posts.xml';
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    // Create the root <rss> element
    $rss = $dom->createElement('rss');
    $rss->setAttribute('xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
    $rss->setAttribute('xmlns:wp', 'http://wordpress.org/export/1.2/');
    $rss->setAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
    $rss->setAttribute('xmlns:excerpt', 'http://wordpress.org/export/1.2/excerpt/');
    $rss->setAttribute('version', '2.0');
    $dom->appendChild($rss);

    $channel = $dom->createElement('channel');
    $rss->appendChild($channel);

    foreach ($posts as $post_id) {
        $post = get_post($post_id);
        $author = get_userdata($post->post_author);
        $post_meta = get_post_meta($post_id);
        $xml_post = $channel->appendChild($dom->createElement('item'));
        $xml_post->appendChild($dom->createElement('title', htmlspecialchars($post->post_title)));

        $featured_image_url = get_the_post_thumbnail_url($post_id, 'full');
        if ($featured_image_url) {
            $xml_post->appendChild($dom->createElement('wp:featured_image', $featured_image_url));
        }
        $content_encoded = $xml_post->appendChild($dom->createElement('content:encoded'));
        $encoded_content = $dom->createCDATASection(htmlspecialchars($post->post_content));
        $content_encoded->appendChild($encoded_content);

        $excerpt_encoded = $xml_post->appendChild($dom->createElement('excerpt:encoded'));
        $encoded_excerpt = $dom->createCDATASection('');
        $excerpt_encoded->appendChild($encoded_excerpt);


        $wp_post_id = $xml_post->appendChild($dom->createElement('wp:post_id', $post_id));


        foreach ($meta_keys as $key) {
            $value = isset($post_meta[$key][0]) ? htmlspecialchars($post_meta[$key][0]) : '';
            $xml_post_meta = $xml_post->appendChild($dom->createElement('wp:postmeta'));
            $meta_key_elem = $xml_post_meta->appendChild($dom->createElement('wp:meta_key', $key));
            $meta_value_elem = $xml_post_meta->appendChild($dom->createElement('wp:meta_value'));
            $meta_value_elem->appendChild($dom->createCDATASection(htmlspecialchars($value)));
        }
        $comments = get_comments(['post_id' => $post_id]);
        foreach ($comments as $comment) {
            $xml_comment = $xml_post->appendChild($dom->createElement('wp:comment'));
            $xml_comment->appendChild($dom->createElement('wp:comment_id', $comment->comment_ID));
            $xml_comment->appendChild($dom->createElement('wp:comment_author', htmlspecialchars($comment->comment_author)));
            $xml_comment->appendChild($dom->createElement('wp:comment_author_email', htmlspecialchars($comment->comment_author_email)));
            $xml_comment->appendChild($dom->createElement('wp:comment_author_url', htmlspecialchars($comment->comment_author_url)));
            $xml_comment->appendChild($dom->createElement('wp:comment_author_IP', htmlspecialchars($comment->comment_author_IP)));
            $xml_comment->appendChild($dom->createElement('wp:comment_date', $comment->comment_date));
            $xml_comment->appendChild($dom->createElement('wp:comment_date_gmt', $comment->comment_date_gmt));
            $xml_comment->appendChild($dom->createElement('wp:comment_content', htmlspecialchars($comment->comment_content)));
            $xml_comment->appendChild($dom->createElement('wp:comment_approved', $comment->comment_approved));
            $xml_comment->appendChild($dom->createElement('wp:comment_type', 'comment'));
            $xml_comment->appendChild($dom->createElement('wp:comment_parent', $comment->comment_parent));
            $xml_comment->appendChild($dom->createElement('wp:comment_user_id', $comment->user_id));
        }
    }
    echo $dom->saveXML();
    exit();
}

add_action('admin_init', 'export_port');

function my_theme_sanitize_key($key) {
    $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
    $key = preg_replace('/^\d/', 'n', $key);
    return $key;
}

/**
 * Add location menu on Dashboard
 */
function location_dashboard_menu() {
    add_menu_page(
        'Location',
        'Location',
        'manage_options',
        'location_menu',
        'location_menu_page',
        'dashicons-location',
        30
    );

    // Add submenu items
    add_submenu_page(
        'location_menu',
        'City',
        'City',
        'manage_options',
        'city_menu',
        'redirect_to_cities'
    );

    add_submenu_page(
        'location_menu',
        'Region',
        'Region',
        'manage_options',
        'region_menu',
        'redirect_to_regions'
    );

    add_submenu_page(
        'location_menu',
        'Place of Interest',
        'Place of Interest',
        'manage_options',
        'poi_menu',
        'redirect_to_pois'
    );
}

// Callback functions for submenu pages
function location_menu_page() {
    wp_redirect(site_url('/wp-admin/admin.php?page=gd-settings&tab=locations'));
    exit;
}

function redirect_to_cities() {
    wp_redirect(site_url('/wp-admin/admin.php?page=gd-settings&tab=locations&section=cities'));
    exit;
}

function redirect_to_regions() {
    wp_redirect(site_url('/wp-admin/admin.php?page=gd-settings&tab=locations&section=regions'));
    exit;
}

function redirect_to_pois() {
    wp_redirect(site_url('/wp-admin/admin.php?page=gd-settings&tab=locations&section=place-of-interest'));
    exit;
}

add_action('admin_menu', 'location_dashboard_menu');

 /**
 * Add location menu on Dashboard
 */

 /*
function membership_packages_dashboard_menu() {
    add_menu_page(
        'packages',
        'packages',
        'manage_options',
        'packages_menu',
        'packages_menu_page',
        'dashicons-text-page',
        30
    );
}

// Callback functions for submenu pages
function packages_menu_page() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        if (check_admin_referer('save_membership_package', 'membership_package_nonce')) {
            update_option('membership_package_venue_essential_price', sanitize_text_field($_POST['membership_package_venue_essential_price']));
            update_option('membership_package_venue_premium_price', sanitize_text_field($_POST['membership_package_venue_premium_price']));
            update_option('membership_package_Supplier_essential_price', sanitize_text_field($_POST['membership_package_Supplier_essential_price']));
            update_option('membership_package_Supplier_premium_price', sanitize_text_field($_POST['membership_package_Supplier_premium_price']));
        }
    }
    $venue_essential_price = get_option('membership_package_venue_essential_price', '');
    $venue_premium_price = get_option('membership_package_venue_premium_price', '');
    $supplier_essential_price = get_option('membership_package_Supplier_essential_price', '');
    $supplier_premium_price = get_option('membership_package_Supplier_premium_price', '');
    ?>
    <style>
        .membership_package_essential_premium input {
            padding: 5px 15px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 15px;
        }
        .membership_package_essential_premium {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 15px;
            padding-bottom: 10px;
        }
        .membership_package_essential_premium .submit_package {
            font-weight: 600;
            border: none;
        }
        form#membership_package_form h3 {
            font-size: 22px;
            color: #fff;
            text-align: center;
            margin-bottom: 35px;
        }
        form#membership_package_form {
            width: 100%;
            max-width: 50%;
            justify-content: center; 
            border-radius: 15px;
            margin-top: 20px;
            padding: 15px 30px;
            background: #808254;
        }
    </style>
    <div class="membership_package">
        <form name="membership_package_form" id="membership_package_form" method="post">
           <h3>Manage packages</h3>
            <?php wp_nonce_field('save_membership_package', 'membership_package_nonce'); ?>
            <div class="membership_package_essential_premium">
                <input type="text" name="membership_package_venue_essential_price" class="form-control membership_package_venue_essential_price" id="membership_package_venue_essential_price" placeholder="Enter Venue Essential Package Price" value="<?php echo esc_attr($venue_essential_price); ?>">
                <input type="text" name="membership_package_venue_premium_price" class="form-control membership_package_venue_premium_price" id="membership_package_venue_premium_price" placeholder="Enter Venue Premium Package Price" value="<?php echo esc_attr($venue_premium_price); ?>">
            </div>
            <div class="membership_package_essential_premium">
                <input type="text" name="membership_package_Supplier_essential_price" class="form-control membership_package_Supplier_essential_price" id="membership_package_Supplier_essential_price" placeholder="Enter Supplier Essential Package Price" value="<?php echo esc_attr($supplier_essential_price); ?>">
                <input type="text" name="membership_package_Supplier_premium_price" class="form-control membership_package_Supplier_premium_price" id="membership_package_Supplier_premium_price" placeholder="Enter Supplier Premium Package Price" value="<?php echo esc_attr($supplier_premium_price); ?>">
            </div>
            <div class="membership_package_essential_premium">
                <input type="submit" name="submit" class="form-control submit_package" id="submit_package" value="Submit">
            </div>
        </form>
    </div>
    <?php
}

add_action('admin_menu', 'membership_packages_dashboard_menu');
*/

/**
 * Function to retrieve and display the membership package prices
 */

 /*
function display_membership_package_prices() {
    $venue_essential_price = get_option('membership_package_venue_essential_price', '');
    $venue_premium_price = get_option('membership_package_venue_premium_price', '');
    $supplier_essential_price = get_option('membership_package_Supplier_essential_price', '');
    $supplier_premium_price = get_option('membership_package_Supplier_premium_price', '');
    ob_start(); 
    ?>
    <div class="membership_package_prices">
        <h3>Membership Package Prices</h3>
        <div class="membership_package_price">
            <strong>Venue Essential Package Price:</strong> <?php echo esc_html($venue_essential_price); ?>
        </div>
        <div class="membership_package_price">
            <strong>Venue Premium Package Price:</strong> <?php echo esc_html($venue_premium_price); ?>
        </div>
        <div class="membership_package_price">
            <strong>Supplier Essential Package Price:</strong> <?php echo esc_html($supplier_essential_price); ?>
        </div>
        <div class="membership_package_price">
            <strong>Supplier Premium Package Price:</strong> <?php echo esc_html($supplier_premium_price); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('membership_package_prices', 'display_membership_package_prices');
*/

/**
 *  shortcode display venue price of packages into bussines listing page
 */
function display_membership_premium_package_prices() {
    global $wpdb, $post; 
    ob_start(); 
    $post_id = 113421;
    $get_premium_price = get_post_meta($post_id,'_wpinv_price',true);
    if (!empty($get_premium_price)) {
        ?>
        <style>
            p.membership_package {
                color: #E9E9DE;
                font-family: "Söhne", Sans-serif;
                font-size: 18px;
                font-weight: 400;
                line-height: 26px;
                text-align: center;
            }
        </style>
        <div class="membership_package_prices">
            <div class="membership_package_price">
            <p class="membership_package"><?php echo '$' . esc_html($get_premium_price) . '/ MONTH'; ?></p>
            </div>
        </div>
        <?php
    } 
    return ob_get_clean();
}
add_shortcode('membership_package_prices', 'display_membership_premium_package_prices');

/**
 *  shortcode display supplier price of packages into bussines listing page
 */
function display_membership_essential_package_prices() {
    global $wpdb; 
    ob_start(); 
    $post_id = 111560;
    $get_premium_price = get_post_meta($post_id,'_wpinv_price',true);
    if (!empty($get_premium_price)) {
        ?>
        <style>
            p.membership_package {
                color: #E9E9DE;
                font-family: "Söhne", Sans-serif;
                font-size: 18px;
                font-weight: 400;
                line-height: 26px;
                text-align: center;
            }
        </style>
        <div class="membership_package_prices">
            <div class="membership_package_price">
            <p class="membership_package"><?php echo '$' . esc_html($get_premium_price) . '/ MONTH'; ?></p>
            </div>
        </div>
        <?php
    } 
    return ob_get_clean();
}
add_shortcode('membership_essential_package_prices', 'display_membership_essential_package_prices');


/*
function display_membership_essential_package_prices() {
    global $wpdb; 
    $get_silver_invoice_data = $wpdb->get_row("SELECT item_price FROM `".$wpdb->prefix."getpaid_invoice_items` WHERE item_id = '111560' AND item_name='Silver'");
    ob_start(); 
    if (!empty($get_silver_invoice_data)) {
        $get_premium_price = $get_silver_invoice_data->item_price;
        $formatted_price = '$' . number_format((float) $get_premium_price, 2);
        ?>
         <style>
            p.membership_package_essential {
                color: #1E1E1E;
                font-family: "Söhne", Sans-serif;
                font-size: 18px;
                font-weight: 400;
                line-height: 26px;
                text-align: center;
            }
        </style>
        <div class="membership_package_prices">
            <div class="membership_package_price">
                <p class="membership_package_essential"><?php echo esc_html($formatted_price); ?></p>
            </div>
        </div>
        <?php
    } 
    return ob_get_clean();
}
add_shortcode('membership_essential_package_prices', 'display_membership_essential_package_prices');
*/

/**
 * Add js/jquery in wp_footer
 */
add_action('wp_footer', 'wp_footer_function');
function wp_footer_function(){
    ?>

  <script>

		  jQuery('.header_fav_btn').each(function(){
		    var btnLink = jQuery(this).find('.elementor-icon').attr('href');
		    jQuery(this).append('<a class="link_btn"></a>');
		    jQuery(this).find('.link_btn').attr('href', btnLink)
		}); 
    	jQuery('.plan_toggle_btn ul li:first').addClass('active_plan');
		jQuery(document).on('click', '.plan_toggle_btn ul li', function(){
		    jQuery('.plan_toggle_btn ul li').removeClass('active_plan');
		    jQuery(this).addClass('active_plan');
		});

		jQuery(document).on('click', '.plan_toggle_btn ul li:nth-child(2)', function(){
		    jQuery('.mob_price_table').addClass('premium_tab');    
		});
		jQuery(document).on('click', '.plan_toggle_btn ul li:nth-child(1)', function(){
		    jQuery('.mob_price_table').removeClass('premium_tab');    
		});

        jQuery('.save_post_btn span[data-icon="fas fa-heart"]').append('<span class="btn_text">Save</span>');
        jQuery(document).on('click', '.login_tab', function(){
			jQuery('.login_box ').slideToggle();
		});
        jQuery(".vanue_tabs li a").click(function(){
            jQuery(".vanue_tabs li a").removeClass('active_tab');
            jQuery(this).addClass("active_tab");
        });

        jQuery(document).on('click', '.add_review_btn', function(event){
            event.preventDefault();
            $button = jQuery(this);
            $iconContainer = $button.next('.review-main-hide-show');

            $plusIcon = $iconContainer.find('.review_plus');
            $minusIcon = $iconContainer.find('.review_minus');

            $plusIconCss = $plusIcon.css('display') == 'block' ? 'none' : 'block';
            $minusIconCss = $minusIcon.css('display') == 'block' ? 'none' : 'block';

            $plusIcon.css('display', $plusIconCss);
            $minusIcon.css('display', $minusIconCss);
            jQuery('.review_form div#respond').slideToggle();
        });

        jQuery(document).on('click', '.review-main-hide-show', function(e){
            e.preventDefault();
            $button = jQuery(this);
            jQuery('.review_form div#respond').slideToggle();
        });

        jQuery('.listing_filter button#venues-show-filters').click(function(){
            jQuery('.listing_filter .geodir-advance-search-default-s').slideToggle();
        });

        jQuery(document).ready(function(){
            jQuery('.supplier_filter .listing_filter .geodir-search-s button#supplier-filter-btn').html('Apply Filter');
        });

        jQuery('.more_btn h2 span').each(function(){
            var gallery_item = jQuery('.featured_img_gallery a.e-gallery-item').length;
            jQuery(this).text(gallery_item);
        });

        jQuery('.social_share').hide();
        jQuery('.share_btn').click(function(){
            jQuery('.social_share').slideToggle();
        });

        jQuery('#mob_blog_accrordion.blog_details_sections .blog_detail_content h2').click(function(){
            jQuery(this).parent().children('div').slideToggle();
        });
		jQuery('#mob_blog_accrordion.blog_details_sections .blog_detail_content > div ').hide();
		jQuery('#mob_blog_accrordion.blog_details_sections .blog_detail_content:first-child > div ').show();

		jQuery(function(){
			var current = location.pathname;
			jQuery('.vanue_tabs ul.elementor-icon-list-items li a').each(function(){
				var $this = jQuery(this);
				if($this.attr('href').indexOf(current) !== -1){
					$this.addClass('active_tab');
				}
			});
		});

		jQuery(function(){
			var activeurl = location.pathname;
			jQuery('.form_nav ul li a').each(function(){
				var $tab = jQuery(this);
				if($tab.attr('href').indexOf(activeurl) !== -1){
					$tab.addClass('active');
				}
			})
		});

		jQuery('.mobile_menu_toggle').click(function(){
		    jQuery('.mobile_menu').show();
		    jQuery('body').addClass('hidden');
		});

		jQuery('.close_menu').click(function(){
		    jQuery('.mobile_menu').hide();
		    jQuery('body').removeClass('hidden');
		});

        jQuery('#gallery_popup_button').on('click', function(){
            jQuery(window).resize();
            jQuery('.featured_img_gallery a.e-gallery-item:first').trigger('click');
        });

		jQuery('.minus').click(function(){
			jQuery(this).hide();
			jQuery('.plus').show();
			jQuery('.package_content').slideUp();
		});

		jQuery('.plus').click(function(){
			jQuery(this).hide();
			jQuery('.minus').show();
			jQuery('.package_content').slideDown();
		});

		jQuery(document).on('click', '.package_title', function () {
            if(!jQuery(this).parent('').hasClass('active')){
                jQuery('.package-items').removeClass('active');
            }else{
                jQuery(this).parent().addClass('active');
            }
            jQuery(this).parent().toggleClass('active');
		});


        jQuery('.review_plus').click(function(){
			jQuery(this).hide();
			jQuery('.review_minus').show();
			jQuery('.commentlist.list-unstyled').show();
		});

		jQuery('.review_minus').click(function(){
			jQuery(this).hide();
			jQuery('.review_plus').show();
			jQuery('.commentlist.list-unstyled').hide();
		});


	    jQuery(document).ready(function($) {

            setTimeout(function(){
                // console.log('function called');
                let $articlesParentClass = jQuery('.venue_gallery .elementor-gallery__container');

                let $maxLoad = 3;
                let startIndex = 0;
                function hideArticles() {
                    // console.log('hidearticles');
                    jQuery('.venue_gallery .e-gallery-item').each(function(index) {

                    if (index > $maxLoad) {
                        jQuery(this).hide();
                    }
                    });
                    startIndex = $maxLoad + 1;
                    // console.log(startIndex);
                }
                hideArticles();

                function handleViewMore() {
                    // console.log('function is called');
                    let $allArticles = jQuery('.venue_gallery .e-gallery-item');

                    let $viewMoreButton = jQuery('<button>').attr({'type': 'submit','name': 'button'}).text('Show More');

                    $viewMoreButton.addClass("my-class");
                    $viewMoreButton.attr('style', 'background-color: transparent; color: #808254; border: none; border-radius: 5px; cursor: pointer; background: url(https://frenchweddingstyle.com/wp-content/uploads/2024/03/down_arrows.svg); background-repeat: no-repeat; background-size: 25px; background-position: right top; padding:5px 40px 8px 0; margin-top: 30px;');

                    $viewMoreButton.on('click', function() {
                        $allArticles.slice(startIndex, startIndex  + $maxLoad).show();
                        startIndex += $maxLoad;
                        if (startIndex >= $allArticles.length) {
                            $viewMoreButton.hide();
                        }
                    });

                    if ($allArticles.length >= $maxLoad) {
                    //       $articlesParentClass.find('.my-class').remove();
                        let $buttonContainer = jQuery('<div class="load_more_btn">').css({
                            'overflow': 'hidden',
                            'width': '100%',
                            'height': '60px',
                    //         'position': 'absolute',
                            'bottom': '0',
                            'left': '0'
                        });

                    $buttonContainer.append($viewMoreButton);
                    $articlesParentClass.append($buttonContainer);

                    } else {
                        $viewMoreButton.hide();
                    }
                }
                handleViewMore();
            }, 4000);
	    });

        jQuery(document).ready(function($) {
            setTimeout(function(){
                // console.log('function called');
                $real_wedding_list = jQuery('.real_wedding_link .elementor-posts-container');
                let $maxLoads = 3;
                let startIndexs = 0;

                function hideItems() {
                    // console.log('hide articles');
                    jQuery('.real_wedding_link article .gd_weddings.type-gd_weddings').each(function(index) {
                        if (index >= $maxLoads) {
                            jQuery(this).hide();
                        }
                    });
                    startIndexs = $maxLoads;
                    // console.log(startIndexs);
                }

                hideItems();

                function handleViewMore() {
                    // console.log('function is called');
                    let $allPosts = jQuery('.real_wedding_link article .gd_weddings.type-gd_weddings');
                    // console.log("All post html",$allPosts);
                    let $loadMoreButton = jQuery('<button>').attr({
                        'type': 'submit',
                        'name': 'button'
                    }).text('Show More');

                    $loadMoreButton.addClass("my-class");
                    $loadMoreButton.attr('style', 'background-color: transparent; color: #808254; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; background: url(https://frenchweddingstyle.com/wp-content/uploads/2024/03/down_arrows.svg); background-repeat: no-repeat; background-size: 25px; background-position: right top; padding: 0px 40px 0px 0; margin-top: 30px;');

                    $loadMoreButton.on('click', function() {
                        $allPosts.slice(startIndexs, startIndexs + $maxLoads).show();
                        startIndexs += $maxLoads;
                        // console.log("allpost length",$allPosts.length);
                        // console.log("startIndexs",startIndexs);
                        if (startIndexs >= $allPosts.length) {
                            $loadMoreButton.hide();
                        }
                    });

                    if ($allPosts.length >= $maxLoads) {
                        let $button = jQuery('<div class="load_more_btn">').css({
                            'overflow': 'hidden',
                            'width': '100%',
                            'height': '60px',
                            'bottom': '0',
                            'left': '0'
                        });

                        $button.append($loadMoreButton);
                        $real_wedding_list.append($button);
                    } else {
                        $loadMoreButton.hide();
                    }
                }

                handleViewMore();

            }, 4000);
	    });

		jQuery('.features_list .elementor-tab-title').on('click', function(){
			jQuery('.features_list ul.amenities_list li').toggleClass('show');
		});

        jQuery('.gallery_count_btn h2 span').each(function(){
            var gallery_item = jQuery('.location_gallery a.e-gallery-item').length;
            jQuery(this).text(gallery_item);
        });

        jQuery('.gallery_count_btn').on('click', function(){
            jQuery('.location_gallery a.e-gallery-item:first').trigger('click');
        });

        jQuery('.venue_form_btn').on('click', function(){
            var formtitle = jQuery('.form_title h2').html();
            setTimeout(function() {
            jQuery('.form_popup_title h2').html(formtitle);

            }, 200);
        });

        jQuery('.locations-custom-content button#venues-show-filters').on('click', function(){
            jQuery('.locations-custom-content .listing_filter .geodir-advance-search-default-s').slideToggle();
        });

        jQuery( ".feat_wedding_post" ).each(function(){
		    var postLink = jQuery(this).find('article').children('a').attr('href');
		    jQuery(this).find('article').append( "<a class='overlay_links'></a>" );
		    jQuery(this).find('article').children('.overlay_links').attr('href', postLink );
        });

        jQuery( ".activity_item" ).each(function(){
		    var postLinks = jQuery(this).find('a').attr('href');
		    jQuery(this).append( "<a class='overlay_links'></a>" );
		    jQuery(this).children('.overlay_links').attr('href', postLinks );
        });

        jQuery( ".gd_supplierscategory_container .card" ).each(function(){
		    var sup_cat_Links = jQuery(this).find('a').attr('href');
		    jQuery(this).append( "<a class='overlay_links'></a>" );
		    jQuery(this).children('.overlay_links').attr('href', sup_cat_Links );
        });

        jQuery( ".category_list_cards > .elementor-element" ).each(function(){
		    var sup_cat_tab = jQuery(this).find('a').attr('href');
		    jQuery(this).append( "<a class='overlay_links'></a>" );
		    jQuery(this).children('.overlay_links').attr('href', sup_cat_tab );
        });

        jQuery( ".region-posts-container .slide-item" ).each(function(){
		    var slide_links = jQuery(this).find('a').attr('href');
		    jQuery(this).append( "<a class='overlay_links'></a>" );
		    jQuery(this).children('.overlay_links').attr('href', slide_links );
        });

        jQuery('.real-weddings-page .show-filters').on('click', function(){
		    jQuery('.real-weddings-page .listing_filter .geodir-search-container-s').slideToggle();
		});

        jQuery('.slider_mobile_visible .geodir_locations .elementor-posts-container').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            arrows: false,
        });

        jQuery('#thing-main .e-con-inner').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            arrows: false,
        });

        jQuery('.activity_block.mob_slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            arrows: false,
        });

        jQuery('.gallery_mobile_slide .elementor-gallery__container').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 300,
            arrows: false,
        });


		jQuery('button#blogs-show-filters').on('click', function(){
			jQuery('.blogs-filter .geodir-advance-search-default-s').slideToggle();
		});


		function scrollNav() {
		  jQuery('.mobile_sticky_bar .vanue_tabs li a').click(function(){
			jQuery(".active").removeClass("active");
			jQuery(this).addClass("active");

			jQuery('html, body').stop().animate({
			  scrollTop: jQuery(jQuery(this).attr('href')).offset().top - 70
			}, 300);
			return false;
		  });
		}
		scrollNav();

		jQuery(document).ready(function(){
        // Get the text content of the element
        var text = jQuery('.entry-title').text();

        // Define conditions based on text content
        if (text.includes('Claim Your Listing')) {
            // If the text contains 'some', add class1
            jQuery('body').addClass('claim_list_page');
        }
    });
		
		// jQuery('.real-weddings-page button#venues-show-filters').on('click', function(){
		// 	jQuery('.real-weddings-page .listing_filter .geodir-advance-search-default-s').slideToggle();
		// });

	  jQuery(document).on('click', '.venue_form_btn', function(){
			jQuery('.from_block').toggleClass('show_popup')
		});
	  
	   jQuery(document).on('click', '.popup_close ', function(){
			jQuery('.from_block').removeClass('show_popup')
		});
	 
	</script>
    <?php
}

add_action('wp_footer', function(){
	?>
    <script>
        [
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "weight": "2.00"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#9c9c9c"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "-100"
                    },
                    {
                        "gamma": "0.00"
                    },
                    {
                        "weight": "0.68"
                    },
                    {
                        "color": "#09a682"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": "-100"
                    },
                    {
                        "lightness": "-100"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "saturation": "-100"
                    },
                    {
                        "lightness": "-100"
                    },
                    {
                        "gamma": "0.00"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#7b7b7b"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c8d7d4"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#070707"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            }
        ]
    </script>
<?php
});

add_action('admin_footer', 'fws_admin_footer_callback', 999);
function fws_admin_footer_callback(){
    ?>
    <script>
    jQuery(document).ready(function(){
        tinymce.init({
            selector: "textarea:not(.the-tags, #venue_card_text)",
            image_advtab: true,
            image_dimensions: false,
            image_resizing: true,
            plugins: [
                'lists link image',
                'media paste'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat'
        });
    });

    jQuery(document).ready(function() {
        tinymce.remove('#nearest_airport');
        tinymce.remove('#nearest_airport_2');
        tinymce.remove('#video');
        tinymce.remove('#videolink2');
        tinymce.remove('#videolink3');
    });

    jQuery("body").delegate(".add-faqs-btn-listing, .add-services-btn-listing, #add-faq-texonomy, #add-faq", "click", function(){
        jQuery(document).ready(function(){
            tinymce.init({
                selector: ".textareafor-answer, .textarea_package_detials, #faq-list textarea, td.forminp.forminp-text textarea.regular-text.code ",
                image_advtab: true,
                image_dimensions: false,
                image_resizing: true,
                plugins: [
                    'lists link image',
                    'media paste'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat'
            });
        });
    });
    </script>
    <style>
        tr#faq-container tr {
            width: 100% !important;
            min-width: 1450px;
        }
        tr#faq-container tr td:first-child {
            width: 33% !important;
            padding-right: 26px !important;
        }
        tr#faq-container tr td {
            width: 100%;
        }
        .for_answer {
            width: 65% !important;
        }
        textarea#nearest_airport, textarea#nearest_airport_2, textarea#video, textarea#videolink2, textarea#videolink3 {
            visibility: visible !important;
        }
        .geodir-admin-page-edit-gd_supplierscategory form#edittag {
            width: 100% !important;
            max-width: 1920px !important;
        }
        .dropdown-menu.dropdown-caret-0.w-100.show.scrollbars-ios.overflow-auto.p-0.m-0.gd-suggestions-dropdown.gdlm-street-suggestions.gd-ios-scrollbars {
            display: none !important;
        }
        .services-rows .text-services {
            width: 100% !important;
        }
        .services-rows .text-services:last-child{
            margin-top: 20px !important;
        }

        .supp-packages .packages-rows {
            display: flex !important;
            flex-direction: column;
            padding-top: 20px;
            padding-bottom: 20px;
            gap: 10px;
        }

        .faqs-section-content .faqs-rows {
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            padding-bottom: 20px;
            gap: 10px;
        }

        .faqs-section-content .faqs-rows .forQuestion,
        .faqs-section-content .faqs-rows .for_answer{
            width: 100% !important;
        }
    </style>
    <?php
}

function fws_remove_cpt_slug( $post_link, $post ) {
    if ( 'gd_suppliers' === $post->post_type && 'publish' === $post->post_status ) {
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }
    return $post_link;
}
// add_filter( 'post_type_link', 'fws_remove_cpt_slug', 10, 2 );

function fws_wpadmin_show_all_tags( $args ) {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] === 'get-tagcloud' )
        unset( $args['number'] );
        $args['hide_empty'] = 0;
    return $args;
}
add_filter( 'get_terms_args', 'fws_wpadmin_show_all_tags' );

/**
 * Add custom css in admin panel
 */
function fws_wpadmin_custom_css() {
    echo '<script>
        jQuery(window).load(function() {
            jQuery("body.wp-admin #tagsdiv-post_tag #link-post_tag").trigger("click");
            // jQuery("body.wp-admin #tagsdiv-post_tag #link-post_tag").hide();
        });
    </script>';
    echo '<style>
        body.wp-admin .ac-image img:not(body) { max-height: 67px;}
        body.wp-admin .author-self .ac-image img:not(body) { height: 100%; max-height: 67px; }
        body.wp-admin #tagsdiv-post_tag #link-post_tag{visibility:hidden;}
        body.wp-admin #tagsdiv-post_tag #post_tag .jaxtag{display:none;} //this line hides the manual add tag box - delete if not required
        body.wp-admin #tagsdiv-post_tag #tagcloud-post_tag a{display:block;} //this line puts each displayed tag on a new line - delete if not required
    </style>';
}
add_action('admin_head', 'fws_wpadmin_custom_css');

add_filter('block_editor_settings', function ($settings) {
    unset($settings['styles'][0]);
    return $settings;
});


/**
 * Start
 * Sub menu add in gd_suppliers post type for adding hero image banner image, hero image text and url
 */
add_action('admin_menu', 'add_gd_suppliers_submenu_dynamic_fields');

function add_gd_suppliers_submenu_dynamic_fields() {
    add_submenu_page(
        'edit.php?post_type=gd_suppliers',
        'Add Supplier Dynamic Fields',
        'Add Supplier Dynamic Fields',
        'manage_options',
        'gd_suppliers_submenu_dynamic_fields',
        'gd_suppliers_submenu_dynamic_fields_callback'
    );
}
function gd_suppliers_submenu_dynamic_fields_callback() {
    global $wpdb;

    if (isset($_POST['submit'])) {
        $selected_supplier_id = $_POST['supplier_hero_image_vendor'];
        update_option('supplier_hero_image_vendor', $selected_supplier_id);
    }

    $selected_supplier_id = get_option('supplier_hero_image_vendor');
    $suppliers = get_posts(array(
        'post_type' => 'gd_suppliers',
        'posts_per_page' => -1,
    ));
    ?>
    <style>
        .dynamic-hero-image-text select {
        margin-bottom: 20px;
        }

        .dynamic-hero-image-text {
            margin-right: 10px;
        }

        .dynamic-hero-image-text input[type="submit"] {
            display: block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            min-height: 32px;
            line-height: 2.30769231;
            padding: 0 12px;
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }
        .dynamic-hero-image-text label {
        font-weight: bold;
        display: block;
        padding-top: 3%;
        margin-bottom: 10px;
        }
    </style>
    <div class="submenu-dynamic-fields">
        <form method="post" action="">
            <div class="dynamic-hero-image-text">
                <label for="supplier_hero_image_vendor">Select Supplier</label>
                <select name="supplier_hero_image_vendor" id="supplier_hero_image_vendor" class="regular-text">
                    <option value="">Select Supplier</option>
                    <?php foreach ($suppliers as $supplier) :
                        $supplier_id = $supplier->ID;
                        $selected = ($selected_supplier_id == $supplier_id) ? 'selected' : '';
                        ?>
                        <option value="<?php echo esc_attr($supplier_id); ?>" <?php echo $selected; ?>><?php echo esc_html($supplier->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>
    <?php

}

/**
 * Short code to display hero image text
 */
add_shortcode('supplier_home_hero_image_text', 'display_supplier_link_shortcode');
function display_supplier_link_shortcode() {
    $selected_supplier_id = get_option('supplier_hero_image_vendor');

    if ($selected_supplier_id) {
        $supplier = get_post($selected_supplier_id);
        if ($supplier) {
            $supplier_title = $supplier->post_title;
            $supplier_permalink = get_permalink($selected_supplier_id);
            ?>
            <div class="hero_image_vendor">
                <div class="hero_image_vendor-title">
                    <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($supplier_permalink); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($supplier_title); ?></a></p>
                </div>
            </div>
            <?php
        }
    }
}
/**
 * End Supplier
 */



/**
 * Start
 * Sub menu add in gd_place post type for adding hero image banner image, hero image text and url
 */

add_action('admin_menu', 'add_gd_place_submenu_dynamic_fields');

function add_gd_place_submenu_dynamic_fields() {
    add_submenu_page(
        'edit.php?post_type=gd_place',
        'Add Venue Dynamic Fields',
        'Add Venue Dynamic Fields',
        'manage_options',
        'gd_place_submenu_dynamic_fields',
        'gd_place_submenu_dynamic_fields_callback'
    );
}

function gd_place_submenu_dynamic_fields_callback() {
    global $wpdb;

    if (isset($_POST['submit'])) {
        $selected_venue_id = $_POST['venue_home_hero_text'];
        update_option('venue_home_hero_text', $selected_venue_id);
    }

    $selected_venue_id = get_option('venue_home_hero_text');
    $venues = get_posts(array(
        'post_type' => 'gd_place',
        'posts_per_page' => -1,
    ));
    ?>
   <style>
        .dynamic-hero-image-text select {
        margin-bottom: 20px;
        }

        .dynamic-hero-image-text {
            margin-right: 10px;
        }

        .dynamic-hero-image-text input[type="submit"] {
            display: block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            min-height: 32px;
            line-height: 2.30769231;
            padding: 0 12px;
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }
        .dynamic-hero-image-text label {
        font-weight: bold;
        display: block;
        padding-top: 3%;
        margin-bottom: 10px;
        }
    </style>
    <div class="submenu-dynamic-fields">
        <form method="post" action="">
            <div class="dynamic-hero-image-text">
                <label for="venue_home_hero_text">Select Venue</label>
                <select name="venue_home_hero_text" id="venue_home_hero_text" class="regular-text">
                    <option value="">Select Venue</option>
                    <?php foreach ($venues as $venue) :
                        $venue_id = $venue->ID;
                        $selected = ($selected_venue_id == $venue_id) ? 'selected' : '';
                        ?>
                        <option value="<?php echo esc_attr($venue_id); ?>" <?php echo $selected; ?>><?php echo esc_html($venue->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>
    <?php

}

/**
 *  Shortcode to display venue home hero image text
 */
add_shortcode('venue_home_hero_image_text', 'display_venue_link_shortcode');
function display_venue_link_shortcode() {
    $selected_venue_id = get_option('venue_home_hero_text');

    if ($selected_venue_id) {
        $venue = get_post($selected_venue_id);
        if ($venue) {
            $venue_title = $venue->post_title;
            $venue_permalink = get_permalink($selected_venue_id);
            ?>
            <div class="hero_image_vendor">
                <div class="hero_image_vendor-title">
                    <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($venue_permalink); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($venue_title); ?></a></p>
                </div>
            </div>
            <?php
        }
    }
}

/**
 *  Short code to display venue home hero image
 */
add_shortcode('venue_home_hero_image', 'display_venue_image_link_shortcode');
function display_venue_image_link_shortcode() {
    $selected_venue_id = get_option('venue_home_hero_text');
    if ($selected_venue_id) {
        $venue = get_post($selected_venue_id);
        if ($venue) {
            $venue_title = $venue->post_title;
            $venue_image_url = get_the_post_thumbnail_url($selected_venue_id, 'full');
            ?>
            <div class="hero_image_vendor">
                <?php if ($venue_image_url) : ?>
                    <img src="<?php echo esc_url($venue_image_url); ?>" alt="<?php echo esc_attr($venue_title); ?>" class="hero_image_vendor-image">
                <?php endif; ?>

            </div>
            <?php
        }
    }
}
/**
 * END for venue
 */



 /**
 * Start
 * Sub menu add in gd_weddings post type for adding hero image banner image, hero image text and url
 */

add_action('admin_menu', 'add_gd_weddings_submenu_dynamic_fields');

function add_gd_weddings_submenu_dynamic_fields() {
    add_submenu_page(
        'edit.php?post_type=gd_weddings',
        'Add Wedding Dynamic Fields',
        'Add Wedding Dynamic Fields',
        'manage_options',
        'gd_weddings_submenu_dynamic_fields',
        'gd_weddings_submenu_dynamic_fields_callback'
    );
}

function gd_weddings_submenu_dynamic_fields_callback() {
    global $wpdb;

    if (isset($_POST['submit'])) {
        $selected_wedding_id = $_POST['wedding_home_hero_text'];
        update_option('wedding_home_hero_text', $selected_wedding_id);
    }

    $selected_wedding_id = get_option('wedding_home_hero_text');
    $weddings = get_posts(array(
        'post_type' => 'gd_weddings',
        'posts_per_page' => -1,
    ));
    ?>
   <style>
        .dynamic-hero-image-text select {
        margin-bottom: 20px;
        }

        .dynamic-hero-image-text {
            margin-right: 10px;
        }

        .dynamic-hero-image-text input[type="submit"] {
            display: block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            min-height: 32px;
            line-height: 2.30769231;
            padding: 0 12px;
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }
        .dynamic-hero-image-text label {
        font-weight: bold;
        display: block;
        padding-top: 3%;
        margin-bottom: 10px;
        }
    </style>
    <div class="submenu-dynamic-fields">
        <form method="post" action="">
            <div class="dynamic-hero-image-text">
                <label for="wedding_home_hero_text">Select Wedding</label>
                <select name="wedding_home_hero_text" id="wedding_home_hero_text" class="regular-text">
                    <option value="">Select wedding</option>
                    <?php foreach ($weddings as $wedding) :
                        $wedding_id = $wedding->ID;
                        $selected = ($selected_wedding_id == $wedding_id) ? 'selected' : '';
                        ?>
                        <option value="<?php echo esc_attr($wedding_id); ?>" <?php echo $selected; ?>><?php echo esc_html($wedding->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>
    <?php

}

/**
 *  shortcode to display wedding home hero image text
 */

add_shortcode('wedding_home_hero_image_text', 'display_wedding_link_shortcode');
function display_wedding_link_shortcode() {
    $selected_wedding_id = get_option('wedding_home_hero_text');

    if ($selected_wedding_id) {
        $wedding = get_post($selected_wedding_id);
        if ($wedding) {
            $wedding_title = $wedding->post_title;
            $wedding_permalink = get_permalink($selected_wedding_id);
            ?>
            <div class="hero_image_vendor">
                <div class="hero_image_vendor-title">
                    <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($wedding_permalink); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($wedding_title); ?></a></p>
                </div>
            </div>
            <?php
        }
    }
}
/**
 * END for Real Wedding Blogs
 */

/**
 * Start for post
 */

add_action('admin_menu', 'add_post_submenu_dynamic_fields');

function add_post_submenu_dynamic_fields() {
    add_submenu_page(
        'edit.php',
        'Add Post Dynamic Fields',
        'Add Post Dynamic Fields',
        'manage_options',
        'post_submenu_dynamic_fields',
        'post_submenu_dynamic_fields_callback'
    );
}

function post_submenu_dynamic_fields_callback() {
    global $wpdb;

    if (isset($_POST['submit'])) {
        // Sanitize and save the selected image ID
        $selected_image_id = sanitize_text_field($_POST['post_image_id']);
        update_option('post_image_id', $selected_image_id);
    }

    $selected_image_id = get_option('post_image_id');
    ?>
    <style>
        .dynamic-hero-image-text select {
            margin-bottom: 20px;
        }

        .dynamic-hero-image-text {
            margin-right: 10px;
        }

        .dynamic-hero-image-text input[type="submit"] {
            display: block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            min-height: 32px;
            line-height: 2.30769231;
            padding: 0 12px;
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }

        .dynamic-hero-image-text label {
            font-weight: bold;
            display: block;
            padding-top: 3%;
            margin-bottom: 10px;
        }
    </style>
    <div class="submenu-dynamic-fields">
        <form method="post" action="">
            <style>
                div#post_image_preview {
                    padding-top: 10px;
                }
            </style>
            <div class="dynamic-hero-image-text">
                <label for="post_home_hero_text">Select Image</label>
                <input type="hidden" id="post_image_id" name="post_image_id" value="<?php echo esc_attr($selected_image_id); ?>">
                <button id="upload_image_button" class="button">Select Photo</button>
                <?php if (!empty($selected_image_id)) : ?>
                    <div id="post_image_preview">
                        <?php echo wp_get_attachment_image($selected_image_id, 'thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>

    <script>
        jQuery(document).ready(function($){

            $('#upload_image_button').click(function(e) {
                e.preventDefault();

                var custom_uploader = wp.media({
                    title: 'Select Post Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                custom_uploader.on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $('#post_image_id').val(attachment.id);
                    $('#post_image_preview').html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto;">');
                });

                custom_uploader.open();
            });

        });
    </script>
    <?php
}

function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' );


//shortcode to display image in hero image banner in advice idea home page

add_shortcode('display_selected_post_image', 'display_selected_image_shortcode');

function display_selected_image_shortcode() {
    $selected_image_id = get_option('post_image_id');
    if (!empty($selected_image_id)) {
        $image_html = wp_get_attachment_image($selected_image_id, 'full');
         echo '<div class="banner_img"><div class="selected-image-container">' . $image_html . '</div></div>';
        // return $image_html;
    } 
}

/**
 * End for post
 */


 /**
 * Start
 * Sub menu add in gd_blogs post type for adding hero image banner image, hero image text and url
 */
add_action('admin_menu', 'add_gd_blogs_submenu_dynamic_fields');

function add_gd_blogs_submenu_dynamic_fields() {
    add_submenu_page(
        'edit.php?post_type=gd_blogs',
        'Add Blogs Dynamic Fields',
        'Add Blogs Dynamic Fields',
        'manage_options',
        'gd_blogs_submenu_dynamic_fields',
        'gd_blogs_submenu_dynamic_fields_callback'
    );
}

function gd_blogs_submenu_dynamic_fields_callback() {
    global $wpdb;

    if (isset($_POST['submit'])) {
        $selected_blogs_id = $_POST['blogs_home_hero_text'];
        update_option('blogs_home_hero_text', $selected_blogs_id);
    }

    $selected_blogs_id = get_option('blogs_home_hero_text');
    $blogss = get_posts(array(
        'post_type' => 'gd_blogs',
        'posts_per_page' => -1,
    ));
    ?>
   <style>
        .dynamic-hero-image-text select {
        margin-bottom: 20px;
        }

        .dynamic-hero-image-text {
            margin-right: 10px;
        }

        .dynamic-hero-image-text input[type="submit"] {
            display: block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            min-height: 32px;
            line-height: 2.30769231;
            padding: 0 12px;
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            text-decoration: none;
            text-shadow: none;
        }
        .dynamic-hero-image-text label {
        font-weight: bold;
        display: block;
        padding-top: 3%;
        margin-bottom: 10px;
        }
    </style>
    <div class="submenu-dynamic-fields">
        <form method="post" action="">
            <div class="dynamic-hero-image-text">
                <label for="blogs_home_hero_text">Select Blogs</label>
                <select name="blogs_home_hero_text" id="blogs_home_hero_text" class="regular-text">
                    <option value="">Select blogs</option>
                    <?php foreach ($blogss as $blogs) :
                        $blogs_id = $blogs->ID;
                        $selected = ($selected_blogs_id == $blogs_id) ? 'selected' : '';
                        ?>
                        <option value="<?php echo esc_attr($blogs_id); ?>" <?php echo $selected; ?>><?php echo esc_html($blogs->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>
    <?php

}

/**
 * shortcode to display blogs home hero image text
 */
add_shortcode('blogs_home_hero_image_text', 'display_blogs_link_shortcode');
function display_blogs_link_shortcode() {
    $selected_blogs_id = get_option('blogs_home_hero_text');

    if ($selected_blogs_id) {
        $blogs = get_post($selected_blogs_id);
        if ($blogs) {
            $blogs_title = $blogs->post_title;
            $blogs_permalink = get_permalink($selected_blogs_id);
            ?>
            <div class="hero_image_vendor">
                <div class="hero_image_vendor-title">
                    <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($blogs_permalink); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($blogs_title); ?></a></p>
                </div>
            </div>
            <?php
        }
    }
}
/**
 * END for Blogs
 */


 /**
  * shortcode to display supplier home hero image
  */
add_shortcode('supplier_home_hero_image', 'display_supplier_image_link_shortcode');
function display_supplier_image_link_shortcode() {
    $selected_supplier_id = get_option('supplier_hero_image_vendor');

    if ($selected_supplier_id) {
        $supplier = get_post($selected_supplier_id);
        if ($supplier) {
            $supplier_title = $supplier->post_title;
            $supplier_image_url = get_the_post_thumbnail_url($selected_supplier_id, 'full');
            ?>
            <div class="hero_image_vendor">
            <?php if ($supplier_image_url) : ?>
                    <img src="<?php echo esc_url($supplier_image_url); ?>" alt="<?php echo esc_attr($supplier_title); ?>" class="hero_image_vendor-image">
                <?php endif; ?>
            </div>
            <?php
        }
    }
}

/**
 * shortcode to display wedding home hero image
 */

add_shortcode('wedding_home_hero_image', 'display_wedding_image_link_shortcode');
function display_wedding_image_link_shortcode() {
    $selected_wedding_id = get_option('wedding_home_hero_text');

    if ($selected_wedding_id) {
        $wedding = get_post($selected_wedding_id);
        if ($wedding) {
            $wedding_title = $wedding->post_title;
            $wedding_image_url = get_the_post_thumbnail_url($selected_wedding_id, 'full');
            ?>
            <div class="hero_image_vendor">
            <?php if ($wedding_image_url) : ?>
                    <img src="<?php echo esc_url($wedding_image_url); ?>" alt="<?php echo esc_attr($wedding_title); ?>" class="hero_image_vendor-image">
                <?php endif; ?>
            </div>
            <?php
        }
    }
}

/**
 * short code to display blogs home hero image
 */
add_shortcode('blogs_home_hero_image', 'display_blogs_image_link_shortcode');
function display_blogs_image_link_shortcode() {
    $selected_blogs_id = get_option('blogs_home_hero_text');
    if ($selected_blogs_id) {
        $blogs = get_post($selected_blogs_id);
        if ($blogs) {
            $blogs_title = $blogs->post_title;
            $blogs_image_url = get_the_post_thumbnail_url($selected_blogs_id, 'full');
            ?>
            <div class="hero_image_vendor">
            <?php if ($blogs_image_url) : ?>
                    <img src="<?php echo esc_url($blogs_image_url); ?>" alt="<?php echo esc_attr($blogs_title); ?>" class="hero_image_vendor-image">
                <?php endif; ?>
            </div>
            <?php
        }
    }
}

/**
 * Change Posts lable name
 */

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'General Blogs';
    $submenu['edit.php'][5][0] = 'General Blogs';
    $submenu['edit.php'][10][0] = 'Add General Blogs';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'General Blogs';
        $labels->singular_name = 'General Blogs';
        $labels->add_new = 'Add General Blogs';
        $labels->add_new_item = 'Add General Blogs';
        $labels->edit_item = 'Edit General Blogs';
        $labels->new_item = 'General Blogs';
        $labels->view_item = 'View General Blogs';
        $labels->search_items = 'Search General Blogs';
        $labels->not_found = 'No General Blogs found';
        $labels->not_found_in_trash = 'No General Blogs found in Trash';
        $labels->name_admin_bar = 'Add General Blogs';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

/**
 * Change menu order
 */
function custom_menu_order($menu_ord) {

    return array(
        'index.php', // Dashboard
        'file_manager_advanced_ui', // File Manager
        'upload.php', // Media
        'edit.php?post_type=page', // Pages
        'edit.php', // Posts
        'edit.php?post_type=gd_rwedding_blogs', // Best of Blogs
        'edit.php?post_type=gd_weddings', // Real Wedding Blogs
        'edit.php?post_type=gd_place', // Venues
        'edit.php?post_type=gd_suppliers', // Suppliers
        'location_menu', // Location
        'link-manager.php', // links
        'wpcf7', // Contact
        'edit-comments.php', // Comments
        'ninja-forms', // Ninja Form
        'wpinv', // Get Paid Items
        'geodirectory', // GeoDirectory
    );
}
add_filter('custom_menu_order', '__return_true', 99,1);
add_filter('menu_order', 'custom_menu_order', 99999,1);

function hidegeodirectoryblogposttype(){
    ?>
    <style>
        li#menu-posts-gd_blogs {
            display: none !important;
        }
    </style>
    <?php
}
add_action('admin_head', 'hidegeodirectoryblogposttype');


/**
 * add menu for importing the post
 */
add_action('admin_menu', 'import_Post_dashboard_menu');
function import_Post_dashboard_menu() {
    add_menu_page(
        'Import Post',
        'Import Post',
        'manage_options',
        'import_post_menu',
        'import_post_menu_page',
        'dashicons-database-import',
        30
    );
}

/**
 * Select post type and  choose file for import the csv and xml file
 */
function import_post_menu_page() {
    $post_types = get_post_types(array('public' => true), 'objects');
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery("#post_types").select2({
                placeholder: "Select a Post Type",
                allowClear: true
            });
        });
    </script>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="select-post-type">
            <select name="post_type[]" id="post_types" class="js-states form-control" multiple>
                <option value="">Select Post Type</option>
                <?php foreach ($post_types as $post_type) : ?>
                    <?php if (!in_array($post_type->labels->singular_name, array('Media', 'Landing Page', 'Invoice', 'Quote', 'Template', 'Blog'))) : ?>
                        <option value="<?php echo esc_attr($post_type->name); ?>"><?php echo esc_html($post_type->labels->singular_name); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <input type="file" name="import_file" value="Insert File" class="form-group">
            <input type="submit" name="select_post_type" value="Select Post Type" class="button-primary">
        </div>
    </form>
    <?php
}


add_action('admin_init', 'import_post');
function import_post() {
    global $wpdb;
    if (isset($_POST['select_post_type']) && isset($_FILES['import_file'])) {
        $selected_post_types = isset($_POST['post_type']) ? $_POST['post_type'] : array();
        $file = $_FILES['import_file']['tmp_name'];
        $file_type = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
        if ($file_type == 'xml') {
            parse_xml_and_create_posts($file, $selected_post_types);
        } elseif ($file_type == 'csv'){
            parse_csv_and_create_posts($file, $selected_post_types);
        }else {
            echo 'Invalid file format. Please upload an XML file.';
        }
    }
}

/**
 * import post by xml file
 */
function parse_xml_and_create_posts($file, $selected_post_types) {
    $xml = simplexml_load_file($file);
    global $wpdb;
    if ($xml) {
        foreach ($xml->channel->item as $item) {
            $gettitle = (string) $item->title;
            $title  = sanitize_text_field($gettitle);
            $content = htmlspecialchars_decode(esc_html(wp_unslash(wp_kses_post((string) $item->children('content', true)->encoded))));
            $featured_image_url = (string) $item->children('wp', true)->featured_image;
            $post_name = sanitize_title((string) $item->children('wp', true)->post_name);
            $image_relative_path = str_replace('/wp-content/uploads', '', parse_url($featured_image_url, PHP_URL_PATH));
            $current_date_time = date('Y-m-d H:i:s');
            $user_id = get_current_user_id();
            foreach ($selected_post_types as $post_type) {
                $existing_post = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_title = '$title' AND post_type='$post_type'", ARRAY_A);
                if (!$existing_post) {
                    if ($post_type === 'gd_place' || $post_type === 'gd_suppliers' || $post_type === 'gd_weddings' || $post_type === 'gd_rwedding_blogs') {
                        $post_data = array(
                            'post_title'    => $title,
                            'post_content'  => $content,
                            'post_status'   => 'publish',
                            'post_type'     => $post_type,
                            'post_name'     => $post_name
                        );
                        $post_id = wp_insert_post($post_data);
                        $wpdb->insert(
                            'wp_geodir_attachments',
                            array(
                                'file'      => $image_relative_path,
                                'post_id'   => $post_id,
                                'mime_type' => 'image/jpeg',
                                'date_gmt'  => $current_date_time,
                                'user_id'   => $user_id,
                                'other_id'  => '0',
                                'title'     => '',
                                'caption'   => '',
                                'metadata'  => ''
                            )
                        );
                        $wpdb->insert(
                            $wpdb->prefix . 'geodir_' . $post_type . '_detail',
                            array(
                                'featured_image' => $image_relative_path,
                                'post_id'        => $post_id,
                            )
                        );
                        $image_id = attachment_url_to_postid($featured_image_url);
                        if (!is_wp_error($image_id)) {
                            set_post_thumbnail($post_id, $image_id);
                            update_post_meta($post_id, '_featured_image_url', $featured_image_url);
                        } else {
                            error_log('Failed to sideload image for post ID: ' . $post_id . '. Error: ' . $image_id->get_error_message());
                        }
                    } else {
                        $post_data = array(
                            'post_title'    => $title,
                            'post_content'  => $content,
                            'post_status'   => 'publish',
                            'post_type'     => $post_type,
                            'post_name'     => $post_name
                        );
                        $post_id = wp_insert_post($post_data);
                        $image_id = attachment_url_to_postid($featured_image_url);
                        if (!is_wp_error($image_id)) {
                            set_post_thumbnail($post_id, $image_id);
                            update_post_meta($post_id, '_featured_image_url', $featured_image_url);
                        } else {
                            error_log('Failed to sideload image for post ID: ' . $post_id . '. Error: ' . $image_id->get_error_message());
                        }
                    }
                } else {
                    error_log('Skipped inserting duplicate post: ' . $title);
                }
            }
        }
    } else {
        error_log('Failed to load XML file: ' . $file);
        echo 'Failed to load XML file.';
    }
}

/**
 * import post by csv file
 */
function parse_csv_and_create_posts($file, $selected_post_types) {
    global $wpdb;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            $title = sanitize_text_field($data[0]);
            $content_lines = array_slice($data, 1, -1);
            $content = implode("\n", $content_lines);
            $content = str_replace('[br]', '<br>', $content);
            $featured_image_url = $data[count($data) - 2];
            $post_name = end($data);
            $image_relative_path = str_replace('/wp-content/uploads', '', parse_url($featured_image_url, PHP_URL_PATH));
            $current_date_time = date('Y-m-d H:i:s');
            $user_id = get_current_user_id();
            foreach ($selected_post_types as $post_type) {
                $existing_post = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_title = '$title' AND post_type='$post_type'", ARRAY_A);
                 if (!$existing_post) {
                    if ($post_type === 'gd_place' || $post_type === 'gd_suppliers' || $post_type === 'gd_weddings' || $post_type === 'gd_rwedding_blogs') {
                        $post_data = array(
                            'post_title'    => $title,
                            'post_content'  => htmlspecialchars_decode(wpautop(esc_html(wp_unslash(wp_kses_post($content))))),
                            'post_status'   => 'publish',
                            'post_type'     => $post_type,
                            'post_name'     => $post_name
                        );
                        $post_id = wp_insert_post($post_data);
                        $wpdb->insert(
                            'wp_geodir_attachments',
                            array(
                                'file'      => $image_relative_path,
                                'post_id'   => $post_id,
                                'mime_type' => 'image/jpeg',
                                'date_gmt'  => $current_date_time,
                                'user_id'   => $user_id,
                                'other_id'  => '0',
                                'title'     => '',
                                'caption'   => '',
                                'metadata'  => ''
                            )
                        );
                        $wpdb->insert(
                            $wpdb->prefix . 'geodir_' . $post_type . '_detail',
                            array(
                                'featured_image' => $image_relative_path,
                                'post_id'        => $post_id,
                            )
                        );
                        $image_id = attachment_url_to_postid($featured_image_url);
                        if (!is_wp_error($image_id)) {
                            set_post_thumbnail($post_id, $image_id);
                            update_post_meta($post_id, '_featured_image_url', $featured_image_url);
                        } else {
                            error_log('Failed to sideload image for post ID: ' . $post_id . '. Error: ' . $image_id->get_error_message());
                        }
                    } else {

                        $post_data = array(
                            'post_title'    => $title,
                            'post_content'  =>  htmlspecialchars_decode(wpautop(esc_html(wp_unslash(wp_kses_post($content))))),
                            'post_status'   => 'publish',
                            'post_type'     => $post_type,
                            'post_name'     => $post_name
                        );
                
                        $post_id = wp_insert_post($post_data);
                        $image_id = attachment_url_to_postid($featured_image_url);
                        if (!is_wp_error($image_id)) {
                            set_post_thumbnail($post_id, $image_id);
                            update_post_meta($post_id, '_featured_image_url', $featured_image_url);
                        } else {
                            error_log('Failed to sideload image for post ID');
                        }
                    }
                } else {
                    error_log('Skipped inserting duplicate post: ' . $title);
                }
            }
        }
        fclose($handle);
    } else {
        error_log('Failed to open CSV file: ' . $file);
        echo 'Failed to open CSV file.';
    }
}


/**
 * redirect on login page if user not login
 */
// add_action('template_redirect', 'redirect_if_not_logged_in');
function redirect_if_not_logged_in() {

    if (is_page('user-profile') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('dashboard') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/weddings-list') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/add-venue') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/venue-list') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/business-listing') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('select-membership/') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/wedding-submit') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }
    elseif (is_page('my-profile') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }
    elseif (is_page('user-profile/wedding-details') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }
    elseif (is_page('user-profile/my-favourites') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/add-supplier') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (is_page('user-profile/add-supplier') && !is_user_logged_in()) {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (! is_user_logged_in() && is_page('register') && isset($_GET['user']) && $_GET['user'] === 'venue') {
        wp_redirect(home_url('/bride-login/'));
        exit;
    }elseif (! is_user_logged_in() && is_page('register') && isset($_GET['user']) && $_GET['user'] === 'supplier') {
        wp_redirect(home_url('/register'));
        exit;
    }
}


/**
 *  if page not found then it's automatically go for home page
 */
function page_not_found_redirect() {
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, '/directory/') !== false) {
        $new_uri = str_replace('/directory/', '/wedding-venues/', $request_uri);
        wp_redirect(home_url($new_uri));
        exit;
    }elseif(strpos($request_uri, '/category/') !== false) {
        $new_uri = str_replace('/category/', '/articles/', $request_uri);
        wp_redirect(home_url($new_uri));
        exit;
    // }elseif(is_404()) 
    // {
    //     wp_safe_redirect(home_url());
    //     exit();
    }
}

add_action('template_redirect', 'page_not_found_redirect');


/**
 *  blogs page redirect to home page
 */
function blogs_page_redirect() {
    $current_page = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if( strpos( $current_page, '/blogs' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/wedding-venues/vanue-single-page/' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/wedding-supplier/' ) !== false ){
        wp_redirect( home_url('/wedding-vendors') );
        exit;
    }
    if( strpos( $current_page, '/venue-business-list/' ) !== false ){
        wp_redirect( home_url('/contact-us') );
        exit;
    }
    if( strpos( $current_page, 'user-profile/add-venue/venuess/' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/suppliers' ) !== false ){
        wp_redirect( home_url('/wedding-vendors') );
        exit;
    }
    if( strpos( $current_page, '/tim-fox-photography-france' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/editorial-wedding-photography-workshop/' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/wedding-photographer-lauren-michelle/' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
    if( strpos( $current_page, '/rock-and-glamour-international-wedding-photography-in-france/' ) !== false ){
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'template_redirect', 'blogs_page_redirect');
 

/**
 * General post feature image field added
 */

add_theme_support('post-thumbnails', array(
    'post',
    'page',
    'post',
    ));

/**
 * Add custom fields to the payment form
 */
function custom_getpaid_fields() {
    ?>
    <style>
        form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__address {
            display: none;
        }
        .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__city {
            display: none;
        }
        .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__state {
            display: none;
        }
        .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__phone {
            display: none;
        }
        .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__vat-number {
            display: none;
        }
        .getpaid-payment-form-element.getpaid-payment-form-element-items {
            display: none;
        }
        .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__address {
            display: none;
        }
        form.getpaid-payment-form.getpaid-payment-form-111553.bsui.position-relative .entry-title {
            color: #fff;
            text-align: left;
            margin-bottom: 40px !important;
            position: relative;
            font-family: "PP Editorial New", Sans-serif;
            font-size: 35px;
            font-weight: 200;
            line-height: 40px;
        }
    </style>
    <header class="entry-header ast-no-thumbnail">
        <h1 class="entry-title" itemprop="headline">Membership Payment</h1>
    </header>
    <div class="getpaid-custom-fields">
        <div data-argument="getpaid-card-number" class="form-group">
                <label for="getpaid-card-number"><?php esc_html_e( 'Card Number', 'text-domain' ); ?><span class="text-danger"> *</span></label>
                <input type="text" name="card_number" id="getpaid-card-number" placeholder="Card Number" class="form-control wpinv_billing_card_number" autocomplete="Billing Card Number" required />
        </div>
        <div data-argument="getpaid-secure-code" class="form-group">
                <label for="getpaid-secure-code"><?php esc_html_e( 'Secure Code(CVC)', 'text-domain' ); ?><span class="text-danger"> *</span></label>
                <input type="text" name="secure_code" id="getpaid-secure-code" placeholder="Secure Code(CVC)" class="form-control wpinv_billing_secure_code" autocomplete="Billing Secure Code" required />
        </div>
        <div data-argument="getpaid-expiry-date" class="form-group">
                <label for="getpaid-expiry-date"><?php esc_html_e( 'Expiry Date', 'text-domain' ); ?><span class="text-danger"> *</span></label>
                <input type="date" name="expiry_date" id="getpaid-expiry-date" placeholder="MM/YYYY" class="form-control wpinv_billing_expiry_date" autocomplete="Billing Expiry Date" required />
        </div>
        <div data-argument="getpaid-name-on-card" class="form-group">
                <label for="getpaid-name-on-card"><?php esc_html_e( 'Name on Card', 'text-domain' ); ?><span class="text-danger"> *</span></label>
                <input type="text" name="name_on_card" id="getpaid-name-on-card" placeholder="MM/YYYY" class="form-control wpinv_billing_name_on_card" autocomplete="Billing Name on Card" required />
        </div>
    </div>
    <?php
}
add_action( 'getpaid_payment_form_top', 'custom_getpaid_fields' );

/**
 * Validate custom fields before processing payment
 */
function custom_getpaid_validate_fields( $data, $submission ) {
    $secure_code = sanitize_text_field( $_POST['secure_code'] );
    $card_number = sanitize_text_field( $_POST['card_number'] );
    $expiry_date = sanitize_text_field( $_POST['expiry_date'] );
    $name_on_card = sanitize_text_field( $_POST['name_on_card'] );

    // Add custom field values to payment data
    $data['secure_code'] = $secure_code;
    $data['card_number'] = $card_number;
    $data['expiry_date'] = $expiry_date;
    $data['name_on_card'] = $name_on_card;

    return $data;
}
add_filter( 'getpaid_process_payment_data', 'custom_getpaid_validate_fields', 10, 2 );

/**
 * Add custom button to GP Receipt page
 */
function custom_gp_receipt_button() {

    if ( is_page( 'gp-receipt' ) ) {
        ?>
        <style>
            .wpinv-receipt {
                display: none;
            }
            h1.entry-title {
                display: none;
            }

        </style>
        <!-- <script>
            jQuery(document).ready(function() {
            jQuery(".page-template-default").addClass("membership_data");
            });
        </script> -->
        <h1> THANK YOU WE'LL BE IN TOUCH SOON </h1>
        <P>
            we appriciate your submission to becomea member of french weddings. you can  expect an email  within the 24-48 hours.ifyou have any questions please feel free to email  info@frenchwedding.com
        </P>
        <a href="https://frenchweddingstyle.com/user-profile/" class="button">Take me to Dashboard</a>
        <?php
    }
}
add_action( 'wpinv_before_receipt', 'custom_gp_receipt_button' );

/**
 * Hide admin bar when user not admministrator
 */
function hide_wordpress_admin_bar($hide){
if (!current_user_can('administrator')) {
return false;
}
return $hide;
}
add_filter( 'show_admin_bar','hide_wordpress_admin_bar');


// function get_current_user_role() {
//     if (is_user_logged_in()) {
//         $user = wp_get_current_user();
//         $roles = $user->roles;
//         return $roles[0]; 
//     }
//     return null;
// }

// function enqueue_custom_script() {
//     wp_enqueue_script('custom-script', get_template_directory_uri() . 'astra-child/assets/js/script.js', array('jquery'), null, true);
//     $user_role = get_current_user_role();
//     wp_localize_script('custom-script', 'userRoleData', array(
//         'userRole' => $user_role
//     ));
// }
// add_action('wp_enqueue_scripts', 'enqueue_custom_script');
    
    
/**
 * Add class in body tag  
 */
function add_class_body() {
    
    $user_id = get_current_user_id();
    $item_id =   get_user_meta($user_id, 'supplier_package_item_id', true);
    $role =   get_user_meta($user_id, 'role', true);
    $user_role = get_user_meta($user_id, 'wp_user_role', true); 
    if ($user_role != 'venue' && $user_role != 'supplier' && $item_id != 111560 && $item_id != 113421) {
        ?> 
          <!-- <link rel="stylesheet" href="https://frenchweddingstyle.com/wp-content/themes/astra-child/style.css"> -->
        <script>
            setTimeout(function() {
                jQuery(document).ready(function($) {
                $('body').addClass('Bride-Login'); 
            });
            },200);
        </script>
        <?php }elseif($user_role == 'venue' || $user_role == 'supplier' || $item_id == 111560 || $item_id == 113421){
            ?>
            
            <script>
                setTimeout(function() {
                jQuery(document).ready(function($) {
                    $('body').addClass('Business-Login'); 
                });
                },200);
            </script>
            <?php
        }
    }
add_action('wp_head', 'add_class_body');
function add_script_body() {
        ?>
        <script>
           jQuery(document).ready(function($) {
                if(window.location.href.indexOf("register") > -1) {
                    $('body').addClass('membership_data');
                }
            });

            var wordToRemove = "Tag:";  
            var content = jQuery(".elementor-widget-theme-archive-title h1").text();  
            var updatedContent = content.replace(wordToRemove, "");  
            jQuery(".elementor-widget-theme-archive-title h1").text(updatedContent); 
            jQuery(".venue_tags_page .elementor-icon-list--layout-inline li:nth-child(3) span").text(updatedContent);

            var wordToRemove = ".00";  
            var content = jQuery(".sleep-main .post-price").text();  
            var updatedContent = content.replace(wordToRemove, "");  
            jQuery(".sleep-main .post-price").text(updatedContent); 
            
        </script>
        <?php             
    }
add_action('wp_footer', 'add_script_body');
function add_css_in_register_body() {
     
    if (strpos($_SERVER['REQUEST_URI'], 'register') !== false) {
        $role = (isset($_REQUEST['role']) && !empty($_REQUEST['role'])) ? $_REQUEST['role'] : '';
        if (!isset($role) || empty($role)){
        ?>
        <style>
            .form-group.text-center.mb-0.p-0 {
                display: none;
            }
            .uwp-footer-links {
                display: none;
            }
            input#last_name {
                display: none;
            }
            input#username {
                display: none;
            }
            span.select2.select2-container.select2-container--default.select2-container--above {
                display: none;
            }
            select#select_your_type {
                display: none;
            }
            .select2-container {
                display: none;
            }
        </style>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script>
        jQuery(document).ready(function($) {
            var weddingloginforgetlink = `
                <div class="Create-account-link">
                    <a href="<?= site_url().'/bride-login/' ?>" class="sign_in_link" style="color: white;">If you already have an account <span style="color: darkblue;">sign in</span></a>
                </div>
                <div class="forget-password-link">
                    <a href="<?= site_url().'/forgot/' ?>" class="forget_link" style="color: white;">Forgot password?</a>
                </div>`;
            $('.uwp-registration-form .uwp_register_submit').after(weddingloginforgetlink);
        });

        jQuery(document).ready(function($) {
            var weddingDateField = '<div data-argument="weding_date" class="form-group">'+
                '<label for="weding_date" class="sr-only">Wedding Date<span class="text-danger"></span></label>'+
                '<input type="text" class="form-control registration_weding_date" name="weding_date" id="weding_date" placeholder="Enter Your Wedding date">'+
                '</div>';
            $('.uwp-registration-form .form-group[data-argument="last_name"]').after(weddingDateField);

            $("#weding_date").datepicker({
                dateFormat: "mm/dd/yy",
                showAnim: "fadeIn"
            });

            $("#weding_date").focus(function() {
                if ($(this).val() === "Enter Your Wedding date") {
                $(this).val('');
                }
            });

            $("#weding_date").blur(function() {
                if ($(this).val() === '') {
                $(this).val('Enter Your Wedding date');
                }
            });
        });

        jQuery('#password').parent().append(`
                <div class="input-group-append" style="top:0;right:0;">
                    <span class="input-group-text c-pointer px-3" onclick="toggleClaimListingPasswordVisibility()">
                        <i id="claim-password-icon" class="far fa-fw fa-eye-slash"></i>
                    </span>
                </div>
            `);

            // Function to toggle password visibility
            function toggleClaimListingPasswordVisibility() {
                var claimPasswordInput = jQuery('#password');
                var claimIcon = jQuery('#claim-password-icon');

                if (claimPasswordInput.attr('type') === 'password') {
                    claimPasswordInput.attr('type', 'text');
                    claimIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    claimPasswordInput.attr('type', 'password');
                    claimIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            }

            // Add the new span element with the updated onclick function only to the Confirm password field
            jQuery('#confirm_password').parent().append(`
                <div class="input-group-append" style="top:0;right:0;">
                    <span class="input-group-text c-pointer px-3" onclick="toggleClaimListingConfirmPasswordVisibility()">
                        <i id="claim-confirm-password-icon" class="far fa-fw fa-eye-slash"></i>
                    </span>
                </div>
            `);

            // Function to toggle Confirm password visibility
            function toggleClaimListingConfirmPasswordVisibility() {
                var claimConfirmPasswordInput = jQuery('#confirm_password');
                var claimConfirmIcon = jQuery('#claim-confirm-password-icon');

                if (claimConfirmPasswordInput.attr('type') === 'password') {
                    claimConfirmPasswordInput.attr('type', 'text');
                    claimConfirmIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    claimConfirmPasswordInput.attr('type', 'password');
                    claimConfirmIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            }

            jQuery(document).ready(function($) {
            $('.uwp_register_submit').on('click', function(e) {
                
                let first_name = $('#first_name').val();
                if (!first_name) {
                    alert('Please fill first name');
                    e.preventDefault();
                    return false;
                }

                let email = $('#email').val();
                if (!email) {
                    alert('Please fill email');
                    e.preventDefault();
                    return false;
                }

                let password = $('#password').val();
                if (!password) {
                    alert('Please fill password');
                    e.preventDefault();
                    return false;
                }

                let confirm_password = $('#confirm_password').val();
                if (!confirm_password) {
                    alert('Please fill confirm password');
                    e.preventDefault();
                    return false;
                }
                });
            });
        </script>
        <?php
        }
    }
    if (strpos($_SERVER['REQUEST_URI'], 'forgot') !== false) {
        ?>
        <script>
           jQuery(document).ready(function($) {
                $('body').addClass('membership_data');
            });
        </script>
        <style>
           .uwp-footer-links {
                display: none;
            }
        </style>
        <?php
    }
    if (strpos($_SERVER['REQUEST_URI'], 'reset') !== false) {
        ?>
        <script>
           jQuery(document).ready(function($) {
                $('body').addClass('membership_data');
            });
        </script>
        <style>
           .uwp-footer-links {
                display: none;
            }
        </style>
        <?php
    }
    if (strpos($_SERVER['REQUEST_URI'], 'register') !== false) {
        $role       = (isset($_REQUEST['role']) && !empty($_REQUEST['role'])) ? $_REQUEST['role'] : '';
        // $package_id = (isset($_REQUEST['package_id']) && !empty($_REQUEST['package_id'])) ? $_REQUEST['package_id'] : '';
        if($role == 'supplier'  || $role == 'venue'){
        ?>
         <script>
            jQuery(document).ready(function($) {
                var businessloginforgetlink = `
                    <div class="Create-account-link">
                        <a href="<?= site_url().'/bride-login/' ?>" class="sign_in_link" style="color: white;">If you already have an account <span style="color: darkblue;">sign in</span></a>
                    </div>
                    <div class="forget-password-link">
                        <a href="<?= site_url().'/forgot/' ?>" class="forget_link" style="color: white;">Forgot password?</a>
                    </div>`;
                $('.uwp_register_submit').after(businessloginforgetlink);
                jQuery('#first_name').attr('placeholder', 'Full Name');
            });

            jQuery(document).ready(function($) {
                $('.uwp_register_submit').on('click', function(e) {
            let phone_number = $('#phone_number').val();
                    if (!phone_number) {
                        alert('Please fill phone number');
                        e.preventDefault();
                        return false;
                    }
                    let bussiness_name = $('#bussiness_name').val();
                    if (!bussiness_name) {
                        alert('Please fill business name');
                        e.preventDefault();
                        return false;
                    }
                    let website_url = $('#website_url').val();
                    if (!website_url) {
                        alert('Please fill website url');
                        e.preventDefault();
                        return false;
                    }
                    let address = $('#address').val();
                    if (!address) {
                        alert('Please fill address');
                        e.preventDefault();
                        return false;
                    }
                });
                
            });
         </script>
        <?php
        } elseif($role != 'supplier'  || $role != 'venue'){
            ?>
            <script>
                 jQuery(document).ready(function($) {
                    jQuery('#first_name').attr('placeholder', 'Full Name');
                 });
            </script>
            <?php
        }
    }
    if (strpos($_SERVER['REQUEST_URI'], 'select-membership') !== false) {
        ?>
        <style>
            .form-group.col-12.getpaid-address-field-wrapper.getpaid-address-field-wrapper__last-name {
                display: none;
            }
        </style>
         <script>
            jQuery(document).ready(function($) {
                $('.uwp_register_submit').on('click', function(e) {
                    let getpaid_billing_email = $('#getpaid-billing-email').val();
                    if (!getpaid_billing_email) {
                        alert('Please fill email address');
                        e.preventDefault();
                        return false;
                    }
                });
                if ($('.getpaid-address-field-label__first-name').text() === 'First Name') {
                    $('.getpaid-address-field-label__first-name').text('Full Name');
                }
            });
         </script>
        <?php
    }
}
add_action('wp_footer', 'add_css_in_register_body');

     
/**
 * Redirect dashboard if page is "account"
 */
function redirect_account_to_user_profile() {
    
    if (is_page('account')) {
        wp_redirect(home_url('/'));
        exit;
    }
}
add_action('template_redirect', 'redirect_account_to_user_profile');

/**
 * display none view recipt
 */
function custom_invoice_css() {
        ?>
        <style>
            .getpaid-header-left-actions{
                display: none;
            }
            a.btn.btn-sm.btn-secondary.text-white.m-1.d-inline-block.invoice-action-history::before {
                content: 'Dashboard';
                position: absolute;
                left: 50%;
                top: 49%;
                transform: translate(-50%, -50%);
                font-size: 0.875rem;
                line-height: 1.5;
            }
            a.btn.btn-sm.btn-secondary.text-white.m-1.d-inline-block.invoice-action-history {
                font-size: 0;
                position: relative;
                height: 31px;
                width: 120px;
            }
        </style>
        <?php
    }
add_action('wpinv_invoice_display_left_actions', 'custom_invoice_css');


/**
 *   Date flatpicker date picker for ninja form
 */



/**
 * Add field in post category
 */


add_action('category_edit_form_fields', 'add_post_category_fields', 10, 2);

function add_post_category_fields($term, $taxonomy) {
    $term_id = $term->term_id;
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="hero_image_post_category">Hero Image Post</label></th>
        <td>
            <?php
            $posts = get_posts(array(
                'post_type' => 'post',
                'posts_per_page' => -1,
            ));
            $saved_value = get_term_meta($term_id, 'hero_image_post_category', true);
            ?>
            <select name="hero_image_post_category" id="hero_image_post_category" class="regular-text">
                <option value="">Select Post</option>
                <?php foreach ($posts as $post) : setup_postdata($post); ?>
                    <?php
                    $post_id = $post->ID;
                    $selected = selected($saved_value, $post_id, false);
                    ?>
                    <option value="<?php echo esc_attr($post_id); ?>" <?php echo $selected; ?>><?php echo esc_html($post->post_title); ?></option>
                <?php endforeach; wp_reset_postdata(); ?>
            </select>
        </td>
    </tr>
    <?php
}


/**
 * Save data in post category
 */
 
add_action('edited_category', 'save_post_category_fields', 10, 2);
add_action('create_category', 'save_post_category_fields', 10, 2);

function save_post_category_fields($term_id) {
    if (isset($_POST['hero_image_post_category'])) {
        update_term_meta($term_id, 'hero_image_post_category', sanitize_text_field($_POST['hero_image_post_category']));
    }
}


/**
 * Add shortcode to display post category hero image
 */
 
add_shortcode('display_post_category_hero_image','post_category_hero_image');
function post_category_hero_image($term_id){
    ob_start();
    $term_id = get_queried_object_id();
    $image_post_profile_id = get_term_meta($term_id, 'hero_image_post_category', true);
    if (!empty($image_post_profile_id)) {
        $post_profile_image = get_post($image_post_profile_id);
        if ($post_profile_image) {
            $title = $post_profile_image->post_title;
            $image = get_the_post_thumbnail_url($post_profile_image, 'full'); 
            ?>
            <div class="image_vendor">
                <div class="image_vendor-title">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
                </div>
            </div>
            <?php
        }
    }
    return ob_get_clean();
}



// add_filter('the_content', 'remove_empty_p', 20, 1);
// function remove_empty_p($content){
//     $content = force_balance_tags($content);
//     return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
// }


// remove_filter('the_content', 'wpautop');


add_filter( 'the_content', 'remove_empty_p', 20, 1 );
function remove_empty_p( $content ){
	// clean up p tags around block elements
	$content = preg_replace( array(
		'#<p>\s*<(div|aside|section|article|header|footer)#',
		'#</(div|aside|section|article|header|footer)>\s*</p>#',
		'#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
		'#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
		'#<p>\s*</(div|aside|section|article|header|footer)#',
	), array(
		'<$1',
		'</$1>',
		'</$1>',
		'<$1$2>',
		'</$1',
	), $content );

	return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
	
}

function remove_nbsp_from_content($content) {
    // Remove &nbsp; from content
    $content = str_replace('&nbsp;', ' ', $content);
    return $content;
}

add_filter('the_content', 'remove_nbsp_from_content');



add_action('wp_footer', 'link_box_script_function');
function link_box_script_function(){
	?>
	<script>
		jQuery('.geodir_location_listing article').each(function(){
		  var boxLink = jQuery(this).find('a.elementor-button').attr('href');
		    jQuery(this).append('<a class="overlay_link"></a>');
		    jQuery(this).find('.overlay_link').attr('href', boxLink)
		    
		});
        jQuery('.real_wedding-slider article').each(function(){
		  var boxLink = jQuery(this).find('a.item-link').attr('href');
		    jQuery(this).append('<a class="overlay_link"></a>');
		    jQuery(this).find('.overlay_link').attr('href', boxLink)
		    
		});
		jQuery('.real_wedding_link article, .geodir_location_listing article').each(function(){
			var buttonLinks = jQuery(this).find('a.elementor-icon.elementor-animation-').attr('href');
			jQuery(this).find('.overlay_link').attr('href', buttonLinks);
		});
		jQuery('.related_article .e-loop-item ').each(function(){
			var buttonLinks = jQuery(this).find('a.elementor-button-link').attr('href');
            jQuery(this).append('<a class="overlay_link"></a>');
			jQuery(this).find('.overlay_link').attr('href', buttonLinks);
		});

		jQuery('.e-loop-item .article_block').each(function(){
			var buttonLinks = jQuery(this).find('a.elementor-button-link').attr('href');
            jQuery(this).append('<a class="overlay_link"></a>');
			jQuery(this).find('.overlay_link').attr('href', buttonLinks);
		});
		
		jQuery('.vendors_items article').each(function(){
			var buttonLinks = jQuery(this).find('h2.elementor-heading-title a').attr('href');
			jQuery(this).find('.overlay_link').attr('href', buttonLinks);
		});
		
		 jQuery('.discover_block').each(function(){
		  var boxLink = jQuery(this).find('a.elementor-button').attr('href');
		    jQuery(this).append('<a class="overlay_link"></a>');
		    jQuery(this).find('.overlay_link').attr('href', boxLink)
		    
		});
		
		
	</script>
	<?php
}



function astra_force_remove_style() {
    wp_dequeue_style( 'astra-theme-css' );
    wp_dequeue_style( 'astra-addon-css' );
}

add_action( 'wp_enqueue_scripts', 'astra_force_remove_style', 99 );



// add_action('init', 'custom_rewrite_rules');
// function custom_rewrite_rules() {
//     // Custom rule for posts
//     add_rewrite_rule(
//         '^([^/]+)/?$',
//         'index.php?name=$matches[1]',
//         'top'
//     );

//     // Custom rule for media
//     add_rewrite_rule(
//         '^wp-content/uploads/([^/]+)/?$',
//         'index.php?attachment=$matches[1]',
//         'top'
//     );
// }


// add_action('template_redirect', 'handle_slug_conflict');
// function handle_slug_conflict() {
//     if (is_attachment()) {
//         global $wp_query;
//         $attachment_slug = $wp_query->post->post_name;

//         // Check if a post exists with the same slug
//         $post = get_page_by_path($attachment_slug, OBJECT, 'post');
//         if ($post) {
//             // Redirect to the post if an attachment with the same slug exists
//             wp_redirect(get_permalink($post), 301);
//             exit();
//         }
//     }
// }
