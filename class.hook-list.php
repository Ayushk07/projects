<?php

if ( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly.

/**
 * Class FwsHookList
 */

if( ! class_exists('FwsHookList', false) ){
    class FwsHookList{
        public static function init(){
            // add user role
            add_action( 'admin_init', [ __CLASS__, 'fws_custom_user_roles' ] );
            // register hook
            add_action( 'uwp_template_fields', [ __CLASS__, 'fws_add_user_register_field' ] );
            // register field save
            add_action( 'uwp_after_custom_fields_save', [ __CLASS__, 'fws_save_user_fields_listing_id' ], 10,4 );
          
            // filter to hide admin bar after login
            add_filter( 'show_admin_bar' , [ __CLASS__, 'fws_hide_wordpress_admin_bar' ] );
            // hook to redirect based on user role
            // add_action( 'wp_login', [ __CLASS__, 'custom_redirect_after_login' ], 10, 2 );
            // Custom Packages
            add_filter( 'geodir_custom_field_input_text_packages', array( __CLASS__, 'av_geodir_custom_field_input_text_packages' ), 10, 2 );
            // save supplier_listing page fields
            add_action( 'save_post_gd_suppliers', array( __CLASS__, 'fws_supplier_listing_submit_cb' ), 10, 2 );
            // shortcode to display locations page process
            add_shortcode( 'fw_location_listings', [ __CLASS__, 'fws_listings_location_wise_cb' ] );
            // ajax for cards display
            add_action( 'wp_ajax_avlabs_gd_locations_search', [ __CLASS__, 'avlabs_gd_locations_search' ] );
            add_action( 'wp_ajax_nopriv_avlabs_gd_locations_search', [ __CLASS__, 'avlabs_gd_locations_search' ] );
            // ajax for featured cards display
            add_action( 'wp_ajax_avlabs_gd_locations_search_featured', [ __CLASS__, 'avlabs_gd_locations_search_featured' ] );
            add_action( 'wp_ajax_nopriv_avlabs_gd_locations_search_featured', [ __CLASS__, 'avlabs_gd_locations_search_featured' ] );
            // shortcode to display venue 
            add_shortcode( 'venues_and_suppliers_slider', [ __CLASS__, 'fws_venues_and_suppliers_slider_cb' ] );
            // shortcode to display supplier  
            add_shortcode( 'supplier_real_wedding_blog', [ __CLASS__, 'fws_supplier_real_wedding_blog_shortcode_cb' ] );
            // shortcode to display venue  
            add_shortcode( 'venue_real_wedding_blog', [ __CLASS__, 'fws_venue_real_wedding_blog_shortcode_cb' ] );

            add_action( 'edit_form_after_title', [__CLASS__, 'fws_heading_after_title'], 10);
            add_filter('enter_title_here', [__CLASS__, 'fws_venues_business_title_placeholder'], 10, 2);
            //add meta box for Best of blogs supplier field
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding'));
            //save meta box value for Best of blogs supplier field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_weding'), 99, 2);
            //add Best of blogs venue field 
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding_vanue'));
            //save meta box value for Best of blogs venue field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_weding_venue'), 99, 2);
            //add Best of blogs supplier categoryfield
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding_supplier_category'));
            //save meta box value for Best of blogs vsupplier category field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_weding_supplier_category'), 99, 2);
            //add Best of blogs venue categoryfield
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding_venue_category'));
            //save meta box value for Best of blogs venue category field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_weding_venue_category'), 99, 2);
            // add meta box for location detials in Best of blogs
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding_location_details'));
            //save meta box value for Best of blogs location detials field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_weding_location_details'), 99, 2);
            // add meta box for Sub Heading in Best of blogs
            add_action('add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box_gd_real_weding_subheading'));
            //save meta box value for Best of blogs Sub Heading field
            add_action('save_post', array( __CLASS__, 'fws_geodir_save_post_meta_gd_real_wedding_sub_heading'), 99, 2);
            // shortcode to display Sub heading in frontnend
            add_shortcode('real_wedding_blogs_sub_heading', array( __CLASS__, 'fws_geodir_display_real_wedding_sub_heading_shortcode'));
            //ADD CUSTOM STYLE
            add_action('admin_head', [__CLASS__, 'fws_admin_custom_style_cb']);
            //Supplier custom services
            add_filter( 'geodir_custom_field_input_text_supplier_services', array( __CLASS__, 'av_geodir_custom_field_input_text_supplier_services' ), 10, 2 );
            // custom meta field meta box at post type post
            add_action( 'add_meta_boxes', array( __CLASS__, 'fws_geodir_register_meta_box' ) );
            // save custom meta field value of post type post
            add_action( 'save_post', array( __CLASS__, 'fws_geodir_save_post_meta' ), 99, 2 );
             // City meta field meta box at post type post
            add_action( 'add_meta_boxes', array( __CLASS__, 'fws_geodir_city_meta_box' ) );
            // save city meta field value of post type post
            add_action( 'save_post', array( __CLASS__, 'fws_geodir_save_city_post_meta' ), 99, 2 );
            // place of interest meta field meta box at post type post
            add_action( 'add_meta_boxes', array( __CLASS__, 'fws_geodir_poi_meta_box' ) );
            // save place of interest meta field value of post type post
            add_action( 'save_post', array( __CLASS__, 'fws_geodir_save_poi_post_meta' ), 99, 2 );
            // Add Meta Field SUb Heading In Post Type Post 
            add_action( 'add_meta_boxes', array( __CLASS__, 'fws_geodir_post_sub_heading_box' ));
            // Save Meta Field SUb Heading In Post Type Post 
            add_action('save_post', array(__CLASS__, 'fws_geodir_save_sub_heading_post_meta'), 10, 2);
            //Short code for display Sub Heading in posts
            add_shortcode('post_sub_heading', array( __CLASS__, 'display_post_sub_heading_shortcode'));
            // Enque script
            add_action( 'admin_enqueue_scripts', array( __CLASS__, 'fws_geodir_city_enqueue_admin_scripts' ));
            // shortcode to display posts region wise on singel location page
            add_shortcode( 'fws_location_post_listing', array( __CLASS__, 'fws_location_post_listing_callback' ) );
           // shortcode to display supplier category corausal
            add_shortcode( 'fws_supplier_category_corasual', array( __CLASS__, 'fws_supplier_category_corausal' ) );
            // shortocde to fetch count and images of single location listing
            add_shortcode( 'fws_location_count_listing_images', array( __CLASS__, 'fws_location_count_listing_images_callback' ) );
            // shortcode to display Faq in frontend location page
            add_shortcode( 'fws_location_faq', array( __CLASS__, 'fws_location_faq' ) );
            // shortcode to display basetitle field in frontend location page
            add_shortcode( 'fws_display_basetitle', array( __CLASS__, 'fws_display_basetitle' ) );
            // shortcode to display overview field in frontend location page
            add_shortcode( 'fws_location_overview', array( __CLASS__, 'fws_location_overview_callback' ) );
            // shortcode to display FAQ field in frontend supplier category page
            add_shortcode( 'supplier_category_FAQ', array( __CLASS__, 'display_supplier_category_FAQ' ) );
            // shortcode to display Overview field in frontend supplier category page
            add_shortcode( 'supplier_category_Overview', array( __CLASS__, 'display_supplier_category_overview' ) );
            // shortcode to display hero image vendor field in frontend supplier category page
            add_shortcode( 'supplier_category_hero_image_vendor', array( __CLASS__, 'display_supplier_category_hero_image_vendor' ) );
            // shortcode to display hero image vendor field in frontend venue category page
            add_shortcode( 'venue_category_hero_image_vendor', array( __CLASS__, 'display_venue_category_hero_image_vendor' ) );
            // shortcode to display hero image banner image field in frontend supplier category page
            add_shortcode( 'vendor_profile_image_for_banner', array( __CLASS__, 'display_vendor_proile_image_for_banner_hero_image' ) );
             // shortcode to display hero image banner image field in frontend Venue category page
             add_shortcode( 'venue_profile_image_for_banner', array( __CLASS__, 'display_venue_proile_image_for_banner_hero_image' ) );
            // shortcode to display discription field in frontend supplier category page
            add_shortcode( 'supplier_category_description', array( __CLASS__, 'display_supplier_category_description' ) );
            // shortcode to display WOW Pklanner field in frontend supplier category page
            add_shortcode( 'supplier_category_wow_planner', array( __CLASS__, 'display_supplier_category_wow_planner' ) );
            // shortcode to display vendors details fields in frontend real wedding blogs page
            add_shortcode( 'wedding_vendor_details', array( __CLASS__, 'display_wedding_vendor_details' ), 10, 2 );
            // shortcode to display sub heading fields in frontend real wedding blogs page
            add_shortcode( 'wedding_sub_heading', array( __CLASS__, 'display_wedding_sub_heading' ), 10, 2 );
            // shortcode to display sub heading fields in frontend  blogs page
            add_shortcode( 'blogs_sub_heading', array( __CLASS__, 'display_blogs_sub_heading' ) );
            // shortcode to display hero image for home page fields in frontend real wedding blogs page
            add_shortcode( 'supplier_hero_image_homepage', array( __CLASS__, 'display_wedding_hero_image_for_homepage' ), 10, 2 );
            // Enque script
            add_action( 'wp_footer', [__CLASS__, 'fws_custom_scripts_cb']);
            // shortcode to display trust vendor fields in frontend supplier listings page
            add_shortcode( 'geodirectory_select_values_cp_link_supplier', [__CLASS__, 'fws_geodirectory_select_values_cp_link_supplier_shortcode' ]);
            // shortcode to display trust vendor fields in frontend venue listings page
            add_shortcode( 'geodirectory_select_values_cp_link_venue', [__CLASS__, 'fws_geodirectory_select_values_cp_link_venue_shortcode' ]);
            // shortcode to display region in trust vendor cards in frontend supplier listings page
            add_shortcode( 'region_supplier_shortcode', [__CLASS__, 'fws_suplier_region_shortcode' ]);
            // shortcode to display region in trust vendor cards in frontend venue listings page
            add_shortcode( 'region_venue_shortcode_cb', [__CLASS__, 'fws_geodirectory_region_venue_shortcode_cb' ]);
             // shortcode to display texonomy in frontend real wedding blogs page
            add_shortcode( 'real_wedding_blogs_geodirectory_tags', [__CLASS__, 'display_real_wedding_blogsgeodirectory_tags' ]);
            // shortcode venue category faq item
            add_shortcode( 'Venue_category_faqs', [__CLASS__, 'display_venue_category_FAQ' ]);
            //shortcode venue category Overview Heading And Overvie Description
            add_shortcode( 'Venue_category_overview_heading_overview_description', [__CLASS__, 'display_venue_category_overview' ]);
            //shortcode to display description field in frontend venue category page
            add_shortcode( 'Venue_category_description', [__CLASS__, 'display_venue_category_description' ]);
            // shortcode to display select memebership form
            add_shortcode( 'select_membership', [__CLASS__, 'package_select_membership' ]);
            // save select membership
            add_action('init', [__CLASS__, 'fws_save_custom_select_membership']);
            // shortcode to display general blogs select pois
            add_shortcode( 'display_region_selected_in_general_blog', [__CLASS__, 'fws_display_general_blog_select_poi_callback' ]);
            // add shortcode to display new bride-login page
            add_shortcode( 'bride_login_form', array(__CLASS__, 'bride_login_form_callback'));
            //Getting BrideLogin Ajax Request
            add_action('wp_ajax_bride_users_login', array(__CLASS__, 'bride_users_login' ), 0);
            add_action('wp_ajax_nopriv_bride_users_login', array(__CLASS__, 'bride_users_login' ) );
            // add shortcode to display new login page
            add_shortcode( 'login_form', array(__CLASS__, 'login_form_callback'));
            //Getting Login Ajax Request
            add_action('wp_ajax_users_login', array(__CLASS__, 'users_login' ), 0);
            add_action('wp_ajax_nopriv_users_login', array(__CLASS__, 'users_login' ) );
            // Venue Overvie fields shortcode
            add_shortcode( 'venue_overview_fields', array(__CLASS__, 'display_venue_overview_fields'));
             // supplier Overvie fields shortcode
            add_shortcode( 'suppliers_overview_fields', array(__CLASS__, 'display_supplier_overview_fields'));
            // display regions in single listing page of venue and supplier
            add_shortcode( 'display_shortcode_supplier_region', array(__CLASS__, 'display_shortcode_supplier_region_fields'));
            add_shortcode( 'display_shortcode_venue_region', array(__CLASS__, 'display_shortcode_venue_region_fields'));
            // update_select_membership_package_save 
            add_action( 'wp_ajax_update_select_membership_package_save', [ __CLASS__, 'update_select_membership_package_save' ] );
            add_action( 'wp_ajax_nopriv_update_select_membership_package_save', [ __CLASS__, 'update_select_membership_package_save' ] );
            // shortcode to display venue price, bedroom,guest
            add_shortcode( 'display_data_invanue_singlelisting', array(__CLASS__, 'display_data_invanue_single_listing_page'));
            // shortcode to display supplier price, bedroom,guest
            add_shortcode( 'display_data_in_supplier_singlelisting', array(__CLASS__, 'display_data_in_supplier_single_listing_page'));
            // shortcode vanue single pag amenitites
            add_shortcode('venue_single_page_amenities', array(__CLASS__, 'venue_single_listing_page_amenitites'));
            // shortcode vanue single pag amenitites
            add_shortcode('advice_and_idea_date', array(__CLASS__, 'display_date_advice_and_idea_page'));
            //get id, title from slug to check url post
           //add_shortcode('get_slug_title_url', array(__CLASS__,'get_posts_by_slugs'));
        }

        /**
         * get id, title from slug to check url post
         */
        public static function get_posts_by_slugs() {
            $slugs_to_find = array(
            'rock-and-glamour-international-wedding-photography-in-france',
'romantic-french-style-wedding-ideas',
'how-will-brexit-affect-your-destination-wedding',
'guide-destination-wedding-poitou-charentes',
'wedding-venues/domaine-michaud',
'wedding-venues/domaine-du-beyssac',
'wedding-venues/chateau-st-michel',
'wedding-venues/chateau-de-puissentut',
'wedding-venues/domaine-du-golf-country-club-de-bigorre',
'tartan-inspired-bordeaux-wedding',
'paris-wedding-at-george-v-paris',
'coco-chanel-wedding-theme',
'luxury-wedding-shangri-la-hotel-paris',
'shangri-la-hotel-elope-in-paris',
'destination-shangri-la-wedding-in-paris',
'wedding-16th-arrondissement-paris',
'saint-james-hotel-paris-engagement-love-story',
'south-of-paris-wedding-inspiration-at-chateau-de-bois-le-rois',
'eiffel-tower-elopement',
'elegant-le-meurice-wedding-catherine-ohara-photography',
'romantic-small-wedding-paris',
'eiffel-tower-inspired-shangri-la-paris-elopement',
'rendez-vous-in-front-of-the-hotel-ritz-paris',
'wedding-venues/chateau-de-sannes',
'wedding-venues/chateau-de-tourreau',
'wedding-venues/chateau-de-puissentut',
'destination-wedding-show-at-chateau-saint-georges',
'french-alps-wedding-venue',
'renaissance-styled-wedding-at-chateau-saint-martory',
'chic-chateau-mas-de-montet-real-wedding',
'fine-art-chateau-de-tourreau-wedding',
'destination-wedding-planning-in-gascony',
'bordeaux-wedding-at-chateau-gassies',
'real-wedding-at-chateau-saint-georges',
'fine-art-chateau-la-durantie-wedding-inspiration',
'chateau-de-reignac-wedding',
'fairytale-castle-wedding-at-chateau-challain',
'wedding-chateau-de-pommard',
'french-countryside-wedding-at-chateau-de-puissentut',
'diy-wedding-in-loire-valley-france',
'wedding-dress-inspiration-at-chateau-de-courtomer-in-normandy',
'jenny-packham-loire-valley-wedding',
'wedding-venues/chateau-de-pennautier',
'wedding-venues/chateau-des-demoiselles',
'wedding-venues/chateau-de-mazelieres',
'elegant-chateau-de-la-chevre-dor-real-wedding',
'wedding-venues/chateau-de-la-roche-courbon',
'french-country-chic-wedding-at-chateau-de-la-roche-courbon',
'rustic-chic-chateau-lagorce-real-wedding',
'chateau-de-la-roche-courbon-humanist-wedding-celebrations',
'an-intimate-affair-at-chateau-challain',
'exclusive-french-wedding-venue-chateau-le-lout',
'chateau-de-lisse-destination-wedding',
'chateau-de-saint-martory-real-wedding',
'chateau-de-lisse-wedding-in-gascony-france',
'chateau-lagorce-wedding-venue-france',
'french-wedding-inspiration-in-texas',
'south-west-france-chateau-de-lisse-real-wedding',
'south-west-of-france-wedding-at-chateau-lagorce',
'exquisite-chateau-de-varennes-real-wedding',
'fairytale-wedding-at-chateau-saint-martin-spa',
'destination-chateau-la-durantie-real-wedding',
'chateau-de-la-chevre-dor-wedding-inspiration',
'whimsical-wedding-at-chateay-challain',
'wedding-venue-france-spotlight-on-chateau-saint-martin',
'relaxed-wedding-in-provence-at-blanche-fleur',
'french-romantic-pastel-coloured-chateau-wedding',
'maggie-sottero-for-a-chateau-du-ludaix-wedding',
'unique-wedding-venues-france',
'summer-wedding-in-dordogne-france',
'chateau-de-belvoir-destination-wedding',
'normandy-wedding-venue-chateau-de-courtomer',
'romantic-wedding-at-chateau-de-saint-martory',
'olive-grove-wedding-feather-and-stone',
'supplier/articles/wedding-venues',
'supplier/articles/wedding-photograph',
'supplier/articles/wedding-flower',
'wedding-venues/dream-paris-wedding-2',
'top-8-wedding-photographers-in-south-west-france',
'the-paris-photographer',
'how-to-choose-destination-wedding-photographer',
'top-8-wedding-photographers-in-south-west-france',
'the-paris-photographer',
'how-to-choose-destination-wedding-photographer',
'wedding-venues/julia-basmann-photography',
'wedding-venues/chateau-de-champlatreux',
'vintage-glamour-kel-leigh-couture',
'personalised-gifts-for-your-bridal-party-from-onecklace',
'folk-style-wedding-inspiration-france',
'5-top-french-spring-weddings',
'elegant-chateau-diter-wedding-in-french-riviera',
'ocean-wedding-in-le-petit-nice',
'natural-modern-wedding-in-france',
'articles/provence-alpes-cote-dazur-venues',
'wedding-venues/chateau-de-sannes',
'planning-destination-wedding-in-provence-france',
'galia-lahav-wedding-in-provence',
'provence-romance-mas-de-la-rose-wedding-shoot',
'where-to-find-the-best-lavender-fields-in-provence',
'wedding-venues/awardweddings-photography',
'aquitaine',
'wedding-in-saint-emilion',
'tag/chateau-la-durantie',
'articles/shabby-chic-style',
'tag/chateau-de-varennes',
'tag/aquitaine-france',
'south-west-france-dordogne-vineyard-wedding',
'10-unexpected-destination-wedding-planning-questions',
'chateau-soulac-wedding',
'french-wedding-venue-chateau-rieutort',
'wedding-venue-near-bordeaux-chateau-sentout',
'classic-vineyard-wedding-at-chateau-carignan',
'a-pop-of-colour-at-chateau-de-la-garde',
'favourite-weddings-from-chateau-lagorce-france',
'vineyard-wedding-bordeaux',
'chateau-rigaud-wedding-venue-bordeaux',
'french-destination-wedding-with-marquee-reception',
'rustic-countryside-chateau-rigaud-wedding',
'wedding-in-monaco',
'luxury-wedding-monaco',
'wedding-on-the-french-riviera-greg-finck',
'grand-hotel-du-cap-ferrat-international-wedding',
'destination-wedding-show-at-chateau-saint-georges',
'best-wedding-backdrops-inspiration-for-your-big-day',
'real-life-chateau-wedding-in-poitou-charentes',
'chateau-wedding-normandy',
'relaxed-wedding-inspiration-in-saint-maixent-lecole',
'cannes-film-festival-wedding-ideas',
'tag/beach-wedding',
'intimate-wedding-mougins-on-french-riviera',
'timeless-wedding-champagne-france',
'wedding-film-chateau-de-reignac',
'french-wedding-venue-chateau-lagorce-near-bordeaux',
'top-dream-wedding-castles-in-france',
'wedding-chartreuse-de-pomier',
'rustic-wedding-saint-victor-la-grand-maison',
'a-rich-autumn-inspired-styled-shoot',
'ultimate-dream-french-castle-fairytale-wedding',
'wedding-venue-france-spotlight-chateau-challain',
'domaine-de-grolhier-south-west-france-wedding-venue',
'idyllic-wedding-in-the-french-countryside-kelly-sam',
'rustic-chateau-dordogne-wedding',
'art-deco-wedding-inspiration-reims',
'guide-to-your-destination-wedding-in-paris',
'rent-your-own-romantic-honeymoon-hideaway-in-paris',
'scenic-samedi-french-markets',
'houston-to-paris-city-of-love-elopement',
'real-wedding-make-midnight-chateau-colbert',
'chateau-rigaud-wedding-venue-bordeaux',
'tag/wedding-provence',
'exploring-the-auvergne-region',
'guide-destination-wedding-provence',
'guide-to-your-destination-wedding-on-the-french-riviera',
'luxury-french-chateau-wedding-at-chateau-de-varennes',
'vintage-inspired-wedding-dresses',
'celestina-agostino-wedding-anniversary-inspiration',
'fashion-forward-luxury-paris-elopement',
'nautical-inspired-wedding-provence',
'south-of-france-beachside-wedding-inspiration',
'romantique-engagement-on-the-french-riviera',
'glamorous-wedding-hills-provence',
'tag/winter-wedding',
'peacock-palette-wedding-with-a-beautiful-pregnant-bride',
'blanche-fleur-top-provence-wedding-venue',
'create-your-wedding-in-provencal-beauty',
'rustic-country-toulouse-wedding',
'luxury-wedding-event-on-french-riviera-wedding-royal',
'french-fairytale-wedding-venue-chateau-saint-martory',
'fine-art-inspired-chateau-des-alpilles-wedding-shoot',
'unique-wedding-venue-south-west-france-domaine-gayda',
'french-riviera-superyacht-wedding',
'provence-domaine-de-patras-real-wedding',
'romantic-wedding-chateau-massillan-provence',
'rock-and-glamour-international-wedding-photography-in-france',
'romantic-french-style-wedding-ideas',
'how-will-brexit-affect-your-destination-wedding',
'guide-destination-wedding-poitou-charentes',
'wedding-venues/domaine-michaud',
'wedding-venues/domaine-du-beyssac',
'wedding-venues/chateau-st-michel',
'wedding-venues/chateau-de-puissentut',
'wedding-venues/domaine-du-golf-country-club-de-bigorre',
'spring-wedding-vibe',
'wedding-venues/dream-paris-wedding-2',
'wedding-venues/chateau-de-champlatreux',
'paris-wedding-planners-cth-events-paris',
'literary-themed-wedding-between-two-book-lovers',
'valentines-photo-shoot-in-paris',
'destination-wedding-planning-in-gascony',
'french-style-wedding-at-chateau-de-villette',
'chateau-de-bouffemont-real-wedding',
'french-elegance-chateau-bouffemont-wedding',
'noces-du-monde-wedding-planner-france',
'love-filled-weekend-wedding-chateau-de-vallery',
'romantic-chateau-de-vallery-wedding',
'wedding-planning-in-provence-prestige',
'wedding-at-chateau-bouffemont',
'romantic-elopement-at-chateau-de-chantilly',
'wanderlust-exploring-vendee-france',
'exploring-aix-en-provence',
'exploring-the-auvergne-region',
'wanderlust-exploring-the-french-riviera',
'wedding-venues/lhotel',
'wedding-venues/domaine-du-beyssac',
'wedding-venues/chateau-de-puissentut',
'castle-wedding-in-france',
'rustic-chic-chateau-lagorce-real-wedding',
'south-west-of-france-wedding-at-chateau-lagorce',
'french-countryside-wedding-at-chateau-de-puissentut',
'hilltop-chateau-de-la-chevre-dor-wedding',
'tartan-inspired-bordeaux-wedding',
'paris-wedding-at-george-v-paris',
'coco-chanel-wedding-theme',
'luxury-wedding-shangri-la-hotel-paris',
'shangri-la-hotel-elope-in-paris',
'destination-shangri-la-wedding-in-paris',
'wedding-16th-arrondissement-paris',
'saint-james-hotel-paris-engagement-love-story',
'south-of-paris-wedding-inspiration-at-chateau-de-bois-le-rois',
'eiffel-tower-elopement',
'elegant-le-meurice-wedding-catherine-ohara-photography',
'romantic-small-wedding-paris',
'eiffel-tower-inspired-shangri-la-paris-elopement',
'rendez-vous-in-front-of-the-hotel-ritz-paris',
'wedding-venues/chateau-du-bijou',
'romantic-french-graden-wedding-photo-shoot',
'summer-destination-wedding-in-provence',
'6-ways-to-create-a-luxury-feel-for-your-wedding',
'infinity-bridesmaid-dresses',
'elegant-chateau-de-la-chevre-dor-real-wedding',
'sweet-rustic-provencal-wedding',
'glamorous-wedding-hills-provence',
'provence-styled-shoot-at-chateau-des-selves',
'romantic-chateau-saint-georges-wedding-in-grasse',
'black-tie-luxury-villa-florentine-wedding-inspiration',
'wedding-venues/chateau-de-sannes',
'wedding-venues/chateau-de-tourreau',
'wedding-venues/chateau-de-puissentut',
'destination-wedding-show-at-chateau-saint-georges',
'french-alps-wedding-venue',
'renaissance-styled-wedding-at-chateau-saint-martory',
'chic-chateau-mas-de-montet-real-wedding',
'fine-art-chateau-de-tourreau-wedding',
'destination-wedding-planning-in-gascony',
'bordeaux-wedding-at-chateau-gassies',
'real-wedding-at-chateau-saint-georges',
'fine-art-chateau-la-durantie-wedding-inspiration',
'chateau-de-reignac-wedding',
'fairytale-castle-wedding-at-chateau-challain',
'wedding-chateau-de-pommard',
'french-countryside-wedding-at-chateau-de-puissentut',
'diy-wedding-in-loire-valley-france',
'wedding-dress-inspiration-at-chateau-de-courtomer-in-normandy',
'jenny-packham-loire-valley-wedding',
'elegant-chateau-de-la-chevre-dor-real-wedding',
'wedding-venues/chateau-dartigny',
'chateau-de-la-chevre-dor-voted-number-1-in-france',
'renaissance-styled-wedding-at-chateau-saint-martory',
'simple-elegant-le-mas-de-la-rose-wedding',
'provence-wedding-venue-chateau-des-demoiselles',
'famous-chateau-smith-haut-lafitte-wedding',
'a-pop-of-colour-at-chateau-de-la-garde',
'wanderlust-exploring-the-french-riviera',
'fairytale-castle-wedding-at-chateau-challain',
'favourite-weddings-from-chateau-la-tour-vaucros',
'diy-wedding-in-loire-valley-france',
'wedding-dress-inspiration-at-chateau-de-courtomer-in-normandy',
'wedding-venues/chateau-de-pennautier',
'wedding-venues/chateau-des-demoiselles',
'wedding-venues/chateau-de-mazelieres',
'elegant-chateau-de-la-chevre-dor-real-wedding',
'wedding-venues/chateau-de-la-roche-courbon',
'french-country-chic-wedding-at-chateau-de-la-roche-courbon',
'rustic-chic-chateau-lagorce-real-wedding',
'chateau-de-la-roche-courbon-humanist-wedding-celebrations',
'an-intimate-affair-at-chateau-challain',
'exclusive-french-wedding-venue-chateau-le-lout',
'chateau-de-lisse-destination-wedding',
'chateau-de-saint-martory-real-wedding',
'chateau-de-lisse-wedding-in-gascony-france',
'chateau-lagorce-wedding-venue-france',
'french-wedding-inspiration-in-texas',
'south-west-france-chateau-de-lisse-real-wedding',
'south-west-of-france-wedding-at-chateau-lagorce',
'exquisite-chateau-de-varennes-real-wedding',
'fairytale-wedding-at-chateau-saint-martin-spa',
'destination-chateau-la-durantie-real-wedding',
'chateau-de-la-chevre-dor-wedding-inspiration',
'whimsical-wedding-at-chateay-challain',
'wedding-venue-france-spotlight-on-chateau-saint-martin',
'relaxed-wedding-in-provence-at-blanche-fleur',
'french-romantic-pastel-coloured-chateau-wedding',
'maggie-sottero-for-a-chateau-du-ludaix-wedding',
'unique-wedding-venues-france',
'summer-wedding-in-dordogne-france',
'chateau-de-belvoir-destination-wedding',
'normandy-wedding-venue-chateau-de-courtomer',
'romantic-wedding-at-chateau-de-saint-martory',
'olive-grove-wedding-feather-and-stone',
'vintage-inspired-wedding-dresses',
'summer-honeymoon-in-monaco',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-chateau-wedding-venues',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-48',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-luxury-wedding-planner-france',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-44',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-normandy-wedding-venue',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-french-weddings',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-normandy-chateau-wedding-venues',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-wedding-planner-france',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-49',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-wedding-venues-in-paris',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-50',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-51',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-french-chateau-wedding-venues-in-normandy',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-52',
'a-beautiful-french-wedding-at-chateau-de-courtomer/chateau-de-courtomer-rachael-ellen-events-53',
'supplier/articles/wedding-venues',
'supplier/articles/wedding-photograph',
'supplier/articles/wedding-flower',
'supplier/articles/wedding-venues',
'supplier/articles/wedding-photograph',
'supplier/articles/wedding-flower',
'wedding-venues/olya-kobruseva-photography',
'inspiration-board-fairytale-weddin',
'real-life-wedding-chateau-de-challain-franc',
'real-life-wedding-3-day-french-wedding-part-',
'wedding-venues/dream-paris-wedding-2',
'top-8-wedding-photographers-in-south-west-france',
'the-paris-photographer',
'how-to-choose-destination-wedding-photographer',
'top-8-wedding-photographers-in-south-west-france',
'the-paris-photographer',
'how-to-choose-destination-wedding-photographer',
'wedding-cake-with-fresh-flowers',
'light-blue-inspired-avignon-wedding',
'wedding-venues/dina-deykun-photography',
'wedding-venues/julia-basmann-photography',
'wedding-venues/chateau-de-champlatreux',
'rime-arodaky-wedding-dresses',
'trash-the-dress-france',
'scenic-samedi-lyon-france',
'scenic-samedi-perpignan-france',
'wedding-venue-in-france-spotlight-on-chateau-de-la-ligne-2',
'real-life-wedding-authie-valley-northern-france',
'real-life-wedding-chamonix-france',
'diy-shabby-chic-wedding-in-brittany-france',
'real-life-wedding-saint-tropez-france-the-afterparty',
'moroccan-french-fusion-south-west-france-wedding',
'vera-wang-monique-lhuiller-multicultural-wedding',
'real-life-weddings-south-west-france',
'real-life-wedding-denbies-vineyard-wedding-uk',
'madeleines-the-perfect-diy-french-wedding-favour',
'vintage-glamour-kel-leigh-couture',
'wanderlust-exploring-eze-south-of-france',
'save-15-vintage-bridal-headdresses',
'glitzy-secrets-classic-vintage-collection',
'chateau-chic-wedding-cakes',
'luxury-wedding-designer-maya-rose',
'transporting-wedding-cakes-long-distance',
'winter-wedding-cakes',
'fairytale-wedding-theme',
'how-to-create-a-floral-entrance-at-your-luxury-wedding',
'diy-projects-shabby-chic-chandelier',
'vintage-decor-and-prop-rental-for-weddings',
'french-shabby-chic-style-part-7-dresses',
'pink-wedding-dress',
'post-wedding-beach-party-outfits',
'girls-and-roses-florist-paris',
'wedding-bouquet-pinspiration',
'step-step-guide-bridal-hair-tutorial-updo',
'step-by-step-how-to-do-bridal-makeup',
'love-flower-headdress-for-brides',
'wedding-hair-and-make-up-in-a-warm-climate',
'beach-waves-with-straightener',
'winter-wedding-makeup-hair-trends',
'finding-your-hair-and-makeup-artist-for-your-destination-wedding',
'how-to-choose-destination-wedding-photographer',
'bridal-photography-in-paris',
'top-8-wedding-photographers-in-south-west-france',
'the-paris-photographer',
'wedding-abroad-insurance',
'marry-me-in-france-launches-sister-business-perfect-little-wedding',
'free-name-change-kit-easy-name-change',
'wedding-to-do-list',
'dordogne-wedding-venue-chateau-de-fayolle',
'wedding-venue-in-provence-blanche-fleur',
'venue-spotlight-chateau-de-fayolle-dordogne-france',
'wedding-venues-in-provence-france',
'venue-spotlight-lautre-vie-bordeaux-france',
'articles/the-study',
'discover-your-ideal-french-wedding-location',
'a-white-themed-wedding-chateau-near-bordeaux/destination-wedding-photography-204',
'personalised-gifts-for-your-bridal-party-from-onecklace',
'folk-style-wedding-inspiration-france',
'5-top-french-spring-weddings',
'elegant-chateau-diter-wedding-in-french-riviera',
'ocean-wedding-in-le-petit-nice',
'natural-modern-wedding-in-france',
'articles/provence-alpes-cote-dazur-venues',
'wedding-venues/chateau-de-sannes',
'planning-destination-wedding-in-provence-france',
'galia-lahav-wedding-in-provence',
'provence-romance-mas-de-la-rose-wedding-shoot',
'where-to-find-the-best-lavender-fields-in-provence',
'wedding-venues/awardweddings-photography',
'peacock-palette-wedding-with-a-beautiful-pregnant-bride',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-084',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-019',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-088',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-090',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-026',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-073',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-046',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-011',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-012',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-043',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-112',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-031',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-033',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-083',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-035',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-039',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-010',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-071',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-085-2',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-108',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-109',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-021',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-106',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-022',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-107',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-037',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-098',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-105',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-030',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-086',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-034',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-017',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-092',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-028',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-045',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-013',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-044',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-018',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-111',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-014',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-008',
'breathtaking-wedding-day-at-the-idyllic-chateau-la-durantie/chateau-la-durantie-wallflowers-weddings-bordeaux-wedding-050',
'newsletter',
'fairytale-wedding-chateau-esclimont',
'aquitaine',
'wedding-in-saint-emilion',
'tag/chateau-la-durantie',
'tag/chateau-rigaud',
'articles/cakes-and-cuisine',
'luxury-wedding-inspiration-at-chateau-de-varennes',
'articles/shabby-chic-style',
'tag/vintage-wedding-ideas',
'wedding-venues/chateau-de-carsix',
'wedding-venues/chateau-de-carsix',
'tag/belle-bride-fiona',
'documents/Legal Documents Required for French Wedding.pd',
'get-married-in-france-requirements',
'1920s-themed-wedding-grand-siecle-chateau',
'downton-abbey-wedding-inspiration-in-the-south-of-france',
'tag/chateau-de-varennes',
'tag/wedding-midi-pyrenees',
'wedding-venues/awardweddings-planning-2',
'wedding-venues/chateau-de-puissentut',
'tag/aquitaine-france',
'fashion-wedding-editorial-minimalism-and-modern-chic/chateau-de-bouffemont-theatre-of-life-photographer-14',
'wedding-venues/chateau-de-carsix',
'burgundy',
'black-tie-chateau-challain-real-wedding',
'wanderlust-exploring-the-french-riviera',
'wedding-on-the-french-riviera-greg-finck',
'wedding-venues/chateau-de-la-roche-courbon',
'articles/shabby-chic-style',
'south-west-france-dordogne-vineyard-wedding',
'tag/french-wedding-dress-designers',
'10-unexpected-destination-wedding-planning-questions',
'articles/the-study',
'chateau-soulac-wedding',
'french-wedding-venue-chateau-rieutort',
'wedding-venue-near-bordeaux-chateau-sentout',
'classic-vineyard-wedding-at-chateau-carignan',
'a-pop-of-colour-at-chateau-de-la-garde',
'favourite-weddings-from-chateau-lagorce-france',
'vineyard-wedding-bordeaux',
'chateau-rigaud-wedding-venue-bordeaux',
'french-destination-wedding-with-marquee-reception',
'rustic-countryside-chateau-rigaud-wedding',
'chateau-de-varennes-destination-wedding-burgundy',
'romantic-proposal-at-french-castle',
'claire-mischevani-bride-for-destination-wedding-in-france',
'kathryn-bass-bride-giverny-wedding-france',
'wedding-day-false-eyelashes',
'a-dream-french-wedding',
'french-chateau-wedding-international-flavour-just-outside-paris',
'dream-destination-wedding-in-paris',
'wedding-in-monaco',
'luxury-wedding-monaco',
'wedding-on-the-french-riviera-greg-finck',
'grand-hotel-du-cap-ferrat-international-wedding',
'destination-wedding-show-at-chateau-saint-georges',
'best-wedding-backdrops-inspiration-for-your-big-day',
'real-life-chateau-wedding-in-poitou-charentes',
'chateau-wedding-normandy',
'relaxed-wedding-inspiration-in-saint-maixent-lecole',
'micro-wedding-a-la-francaise',
'cannes-film-festival-wedding-ideas',
'tag/beach-wedding',
'intimate-wedding-mougins-on-french-riviera',
'timeless-wedding-champagne-france',
'wedding-film-chateau-de-reignac',
'french-wedding-venue-chateau-lagorce-near-bordeaux',
'top-dream-wedding-castles-in-france',
'wedding-chartreuse-de-pomier',
'rustic-wedding-saint-victor-la-grand-maison',
'a-rich-autumn-inspired-styled-shoot',
'ultimate-dream-french-castle-fairytale-wedding',
'wedding-venue-france-spotlight-chateau-challain',
'domaine-de-grolhier-south-west-france-wedding-venue',
'idyllic-wedding-in-the-french-countryside-kelly-sam',
'rustic-chateau-dordogne-wedding',
'art-deco-wedding-inspiration-reims',
'guide-to-your-destination-wedding-in-paris',
'rent-your-own-romantic-honeymoon-hideaway-in-paris',
'scenic-samedi-french-markets',
'houston-to-paris-city-of-love-elopement',
'real-wedding-make-midnight-chateau-colbert',
'chateau-rigaud-wedding-venue-bordeaux',
'french-art-de-vivre-nissim-de-camondo-40',
'relaxed-chateau-sentout-bordeaux-wedding',
'tag/wedding-provence',
'romantic-wedding-at-chateau-challain',
'exploring-the-auvergne-region',
'laure-de-sagazan-basque-country-wedding',
'guide-destination-wedding-provence',
'tag/lavender',
'articles/the-study',
'guide-to-your-destination-wedding-on-the-french-riviera',
'luxury-wedding-inspiration-at-chateau-de-varennes',
'a-modern-cultural-affair-at-chateau-de-fajac',
'workshops',
'parisian-bridal-beauty-in-the-city-of-love',
'wedding-venues/domaine-dessendieras',
'wedding-venues/domaine-dessendieras',
'articles/florists',
'articles/hair-and-make-up',
'best-ways-to-communicate-with-your-destination-wedding-guests-without-boring-them',
'exploring-aix-en-provence',
'family-wedding-in-france-chateau',
'paris-engagement-photo-shoot',
'lavender-engagement-wedding-photography-provence',
'relaxed-dordogne-wedding-marry-me-in-france',
'black-and-white-wedding-at-chateau-de-vallery',
'mountain-wedding-at-chateau-siradan',
'from-hong-kong-to-paris-engagement-shoot',
'pastel-burgundy-wedding-inspiration',
'a-rustic-chic-wedding-in-the-french-alps',
'modern-and-eco-friendly-wedding-in-france',
'holiday-style-wedding-at-chateau-rigaud',
'wedding-at-mas-de-capelou',
'wedding-chateau-soulac-dordogne',
'sultry-1920s-style-wedding',
'red-velvet-enchanted-forest-styled-shoot',
'romantic-wisteria-inspired-wedding-styled-shoot',
'celebrating-notre-dame-weddings-in-paris',
'rime-arodaky-bride-in-romantic-french-wedding',
'french-farm-wedding-inspiration',
'coco-chanel-wedding-inspiration-in-paris',
'wedding-venues/chateau-st-michel',
'meet-the-experts-estelle-preston-flowers-paris',
'tag/belle-bride-victoria',
'intimate-wedding-in-france',
'tag/fabienne-alagama',
'french-countryside-wedding-vendee',
'submissions',
'a-dreamy-french-alps-winter-wedding',
'snowy-vow-renewal-in-the-french-alps',
'tag/belle-bride-sophie',
'luxury-french-chateau-wedding-at-chateau-de-varennes',
'woman-with-a-parasol-a-monet-inspired-garden-wedding',
'a-secret-snowy-engagement-proposal',
'wedding-venues/le-manoir-du-bout-du-pont',
'provence-wedding',
'stylish-garden-party-french-wedding',
'grand-hotel-du-cap-ferrat-wedding',
'exclusive-french-wedding-venue-chateau-le-lout',
'venue-spotlight-chateau-de-fayolle-dordogne-france',
'luxury-cannes-yacht-wedding-inspiration-shoot',
'vintage-inspired-wedding-dresses',
'celestina-agostino-wedding-anniversary-inspiration',
'fashion-forward-luxury-paris-elopement',
'nautical-inspired-wedding-provence',
'guide-to-getting-married-in-france/?utm_source=rss&amp;utm_medium=rss&amp;utm_campaign=guide-to-getting-married-in-franc',
'sophisticated-villa-ephrussi-de-rothschild-wedding',
'destination-wedding-french-riviera',
'small-wedding-at-chateau-de-la-chevre-dor',
'intimate-wedding-at-chateau-de-la-chevre-dor',
'hilltop-chateau-de-la-chevre-dor-wedding',
'south-of-france-beachside-wedding-inspiration',
'romantique-engagement-on-the-french-riviera',
'glamorous-wedding-hills-provence',
'laure-de-sagazan-bridal-collection',
'tag/winter-wedding',
'tag/lavender-and-rose-wedding-planners',
'tag/centre-france-wedding',
'wedding-venues/lhotel',
'hong-kong-to-paris-hotel-raphael-elopement',
'romantic-french-riviera-sunset-wedding-reception',
'romantic-eiffel-tower-anniversary-shoot',
'luxury-destination-wedding-paris',
'classic-paris-style-destination-wedding',
'summer-wedding-in-provence',
'houston-to-paris-city-of-love-elopement',
'romantic-picnic-paris',
'intimate-spring-wedding-in-paris',
'romantic-pavillon-royal-paris-wedding-inspiration',
'small-wedding-on-the-seine-river-paris',
'luxury-paris-wedding-venue-lhotel',
'articles/the-study',
'peacock-palette-wedding-with-a-beautiful-pregnant-bride',
'blanche-fleur-top-provence-wedding-venue',
'create-your-wedding-in-provencal-beauty',
'rustic-country-toulouse-wedding',
'luxury-wedding-event-on-french-riviera-wedding-royal',
'french-fairytale-wedding-venue-chateau-saint-martory',
'fine-art-inspired-chateau-des-alpilles-wedding-shoot',
'unique-wedding-venue-south-west-france-domaine-gayda',
'french-riviera-superyacht-wedding',
'provence-domaine-de-patras-real-wedding',
'romantic-wedding-chateau-massillan-provence',
'wp-admin/real life wedding biarrit',
'la-vie-en-bleue-at-chateau-de-cons-la-grandville',
'snowy-real-life-wedding-in-chamonix',
'springtime-cherry-blossom-bridal-shoot-in-paris',
            
            );
            $post_types = array('post', 'gd_weddings'); 
            $output = '';
            foreach ($slugs_to_find as $slug) {
                $slug = trim($slug);
                $query = new WP_Query(array(
                    'name'           => $slug,
                    'post_type'      => $post_types,
                    'post_status'    => 'publish',
                    'posts_per_page' => 1
                ));
                
                // Debugging SQL query
                echo '<pre>';
                echo 'SQL Query: ' . $query->request;
                echo '</pre>';
                
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $id    = get_the_ID();
                        $title = get_the_title();
                        $post_type = get_post_type(); 
                         $get_link  = get_permalink( $id );
            
                        $output .= '<div class="main">';
                       
                        $output .= '<div class="Title">' . esc_html($get_link) . '</div>';
                        
                        $output .= '</div>';
                    }
                }
            }            
            return $output;
        }
       

        /**
         * short code to display date in single page of advice and idea
         */
        public static function display_date_advice_and_idea_page() {
            ob_start();
            global $wpdb, $post;
            $post_id = $post->ID;
            $table_name = $wpdb->prefix . 'posts';
            $query = $wpdb->prepare("SELECT post_date FROM $table_name WHERE ID = '$post_id'");
            $result = $wpdb->get_row($query);
            //echo '<pre>'; print_r($result->post_date); echo'</pre>'; die;
            if (!empty($result)) {
            ?>
            <div class="post-info-top"> 
                <?php if (
                    (isset($result->date_post))
                ) { ?> 
                    <div class="info-list">
                        <div class="post-price"><?php echo esc_html(number_format(floatval($result->date_post), 2)); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            }
            return ob_get_clean();
         }
        /**
         * vanue single pag amenitites
         */

         public static function venue_single_listing_page_amenitites(){
            ob_start();
            global $post, $wpdb;
            $post_id      =   $post->ID;
            
            $post_type    =   $post->post_type;
            $total_images =   $wpdb->get_row("SELECT COUNT(ID) as total FROM `".$wpdb->prefix."geodir_attachments` WHERE post_id=$post_id AND type='post_images'");
            $total_imgs   =   (isset($total_images->total) && !empty($total_images->total)) ? $total_images->total : 0;
            $amenities    =   $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."geodir_".$post_type."_detail` WHERE post_id=$post_id LIMIT 1");
            ?>
            <style>
                  ul.amenities_list {
                      list-style: none;
                      margin: 0;
                      padding: 0;
                      border-top: 1px solid #1e1e1e;
                  }
                  ul.amenities_list h3, ul.amenities_list p{
                      margin: 0
                  }
  
                  ul.amenities_list li {
                      display: grid;
                      grid-template-columns: 40% 60%;
                      border-bottom: 1px solid #1e1e1e;
                      padding: 10px 0;
                  }
  
                  ul.amenities_list li .amenities_title {
                      display: grid;
                      grid-template-columns: 25px auto;
                      gap: 40px;
                      align-items: center;
                  }
  
              ul.amenities_list li .amenities_title img {
                    width: 30px;
                    height: 30px;
                    object-fit: contain;
                  }
              </style>
            <?php
            if(!empty($total_imgs)){
              ?>
              <div class="total-imgs-count">
                <span class="img-c"><?= $total_imgs.'+ more' ?></span>
              </div>
              <?php
            }
            ?>
            <div class="amenities_block">
              <?php
              if(!empty($amenities)){
                ?>
                <ul class="amenities_list">
                  <?php
                  if(isset($amenities->minimum_stay__of_nights) && !empty($amenities->minimum_stay__of_nights)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/7606776_work-from-home_stay_home_online_new-normal_icon.svg">
                            </div>
                            <div class="content"><p>Min Stay <?= number_format($amenities->minimum_stay__of_nights) ?> nights</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->no_of_guests) && !empty($amenities->no_of_guests)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Group.png">
                            </div>
                            <div class="content"><p>Up to <?= number_format($amenities->no_of_guests) ?> guests</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->no_of_bedrooms) && !empty($amenities->no_of_bedrooms)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Accomodation-Icon.png">
                            </div>
                            <div class="content"><p>Sleeps up to <?= number_format($amenities->no_of_bedrooms) ?> guests</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->catering) && !empty($amenities->catering)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Catering-Icon.png">
                                <!-- <h3>Catering</h3> -->
                            </div>
                            <div class="content"><p><?= $amenities->catering ?></p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->chapel_description) && !empty($amenities->chapel_description)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Chapel-Icon.png">
                            </div>
                      <div class="content"><p>Chapel</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->yoga) && !empty($amenities->yoga)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/Screenshot_12-removebg-preview.png">
                            </div>
                      <div class="content"><p>Yoga</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->swimming_pool) && !empty($amenities->swimming_pool)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Pool-Icon.png">
                            </div>
                      <div class="content"><p>Swimming Pool</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->golf_course) && !empty($amenities->golf_course)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/golf-course-removebg-preview.png">
                            </div>
                      <div class="content"><p>Golf Course</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->gym) && !empty($amenities->gym)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/gym-icon-removebg-preview.png">
                            </div>
                      <div class="content"><p>Gym</p></div>
                        </li>
                    <?php
                  }
                  if((isset($amenities->lgbt_friendly) && !empty($amenities->lgbt_friendly))){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/7718770_business_success_teamwork_friendship_unity_icon.svg">
                            </div>
                      <div class="content"><p>LGBT Friendly</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->pet_friendly) && !empty($amenities->pet_friendly)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Pet-Friendly-Icon.png">
                            </div>
                      <div class="content"><p>Pet Friendly</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->disabled_access_description) && !empty($amenities->disabled_access_description)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Wheelchair-Icon.png">
                            </div>
                      <div class="content"><p>Disabled Facilities</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->air_conditioning) && !empty($amenities->air_conditioning)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2024/03/9132533_ac_air-conditioner_cold_air-conditioning_icon.svg">
                            </div>
                      <div class="content"><p>Air Conditioning</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->wifi_available) && !empty($amenities->wifi_available)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Wifi-Icon.png">
                            </div>
                            <div class="content"><p>Wifi Available</p></div>
                        </li>
                    <?php
                  }
                  if(isset($amenities->curfew_description) && !empty($amenities->curfew_description)){
                    ?>
                    <li>
                            <div class="amenities_title">
                                <img src="<?= site_url() ?>/wp-content/uploads/2023/12/Group-243.png">
                            </div>
                            <div class="content"><p><?= $amenities->curfew_description ?> </p></div>
                      </li>
                    <?php
                  }
                  ?>
                </ul>
                <?php
              }
              ?>
            </div>
            <?php
            return ob_get_clean();
          }
  
        /**
         * shortcode to display price, bedroom,guest
         */
        public static function display_data_invanue_single_listing_page($atts) {
             ob_start();
            global $wpdb, $gd_post;
            $post_id = $gd_post->ID;
            $table_name = $wpdb->prefix . 'geodir_gd_place_detail';
            $query = $wpdb->prepare("SELECT region,price, no_of_bedrooms, no_of_guests FROM $table_name WHERE post_id = %d", $post_id);
            $result = $wpdb->get_row($query);
            //echo '<pre>'; print_r($result->region); echo'</pre>'; die;
            if (!$result) {
                return '<p>Details not found for this post.</p>';
            }
            
            ?>
            <div class="post-info-top"> 
                <?php if (
                    (isset($result->region) && !empty($result->region)) || (isset($result->price) && !empty($result->price)) ||
                    (isset($result->no_of_bedrooms) && !empty($result->no_of_bedrooms)) ||
                    (isset($result->no_of_guests) && !empty($result->no_of_guests))
                ) { ?> 
                    
                    <div class="info-list">
                        <div class="post-price">
                            From €<?php echo esc_html(number_format(floatval($result->price), 2)); ?>
                        </div>
                    </div>
                    <div class="info-list">
                        <div class="post_no_of_bedrooms">
                            <?php echo esc_html($result->no_of_bedrooms); ?>
                        </div>
                    </div>
                    <div class="info-list">
                        <div class="post_no_of_guests">
                            <?php echo esc_html($result->no_of_guests); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            // wp_reset_postdata();
            // wp_reset_query();
            //rewind_posts();
            return ob_get_clean();
        }
        
         /**
         * shortcode to display supplier region price, bedroom,guest
         */
        public static function display_data_in_supplier_single_listing_page($atts) {
            global $wpdb;
            $atts = shortcode_atts(
                array(
                    'post_id' => get_the_ID(),
                ),
                $atts,
                'fws_listing_info'
            );
            $post_id = intval($atts['post_id']);
            $table_name = $wpdb->prefix . 'geodir_gd_suppliers_detail';
            $query = $wpdb->prepare("SELECT main_service_area,price FROM $table_name WHERE post_id = %d", $post_id);
            $result = $wpdb->get_row($query);
            // echo '<pre>'; print_r($result); echo'</pre>'; die;
            if (!$result) {
                return '<p>Details not found for this post.</p>';
            }
            ob_start();
            ?>
            <div class="post-info-top">
                <?php if (
                    (isset($result->main_service_area) && !empty($result->main_service_area)) || (isset($result->price) && !empty($result->price))
                ) { ?>
                    
                    <div class="info-list">
                        <div class="post-price">
                            From €<?php echo esc_html(number_format(floatval($result->price), 2)); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }
        

        /**
         * add shortcode to display region in signle listing page of venue
         */
        public static function display_shortcode_venue_region_fields() {
            ob_start();
            global $post, $wpdb;
            $post_id = $post->ID;
            $get_vendor_data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}geodir_gd_place_detail WHERE post_id = $post_id", ARRAY_A);
            if ($get_vendor_data) {
                ?>
                <div class="overview overview-text">
                    <?php if (!empty($get_vendor_data['region'])) { ?>
                        <div class="single-page-region">
                            <p class="singlePageregion"><?php echo wpautop(wp_kses_post($get_vendor_data['region'])); ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * add shortcode to display region in signle listing page of supplier
         */
        public static function display_shortcode_supplier_region_fields() {
            ob_start();
            global $post, $wpdb;
            $post_id = $post->ID;
            $get_vendor_data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post_id", ARRAY_A);
            if ($get_vendor_data) {
                ?>
                <div class="overview overview-text">
                    <?php if (!empty($get_vendor_data['main_service_area'])) { ?>
                        <div class="single-page-region">
                            <p class="singlePageregion"><?php echo wpautop(wp_kses_post($get_vendor_data['main_service_area'])); ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }
        
        /**
         * update_select_membership_package_save 
         */
        public static function update_select_membership_package_save() {
          $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
          $package_name = isset($_POST['package_name']) ? $_POST['package_name'] : '';

          if (!empty($user_id) && !empty($package_name)) {
              global $wpdb;
              $table_name = $wpdb->prefix . 'getpaid_invoice_items';
              $get_user_data = $wpdb->get_results("SELECT id FROM `".$wpdb->prefix."getpaid_customers` WHERE user_id = '$user_id' ORDER BY `id` DESC", ARRAY_A);
              if (!empty($get_user_data)) {
                  $customer_ids = array();
                  foreach ($get_user_data as $customer_id) {
                      $customer_ids[] = $customer_id['id'];
                  }
                  foreach ($customer_ids as $Customer_id) {
                      $invoices = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."getpaid_invoices` WHERE customer_id = '$Customer_id' ORDER BY `post_id` DESC", ARRAY_A);
                      if (!empty($invoices)) {
                          foreach ($invoices as $invoice) {
                              $post_id = $invoice['post_id'];
                              $update_result = $wpdb->update(
                                  $table_name,
                                  array('item_name' => $package_name),
                                  array('post_id' => $post_id)
                              );
                              if ($update_result !== false) {
                                  echo 'Success';
                              } else {
                                  echo 'Failed to update package';
                              }
                          }
                      } else {
                          echo 'Invoice not found';
                      }
                  }
              } else {
                  echo 'Customer not found';
              }
          } else {
              echo 'Invalid input';
          }
        }
        
        /**
         * Venue Overvie fields shortcode
         */
        public static function display_venue_overview_fields() {
            ob_start();
            global $post, $wpdb;
            $post_id = $post->ID;
            $get_venue_data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}geodir_gd_place_detail WHERE post_id = $post_id", ARRAY_A);
            if ($get_venue_data) {
                ?>
                <script src="/wp-content/plugins/frenchweddingstyle-customizations/front-end/assests/js/slick.js"></script>
                <div class="overview overview-text">
                    <?php if (!empty($get_venue_data['what_we_love_text'])) { ?>
                        <div class="overview-header">
                            <h3>What we Love </h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_venue_data['what_we_love_text'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_venue_data['about_the_venue'])) { ?>
                        <div class="overview-header">
                            <h3>About the Venue</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_venue_data['about_the_venue'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_venue_data['accomodation__amenities'])) { ?>
                        <div class="overview-header">
                            <h3>Accommodation & Amenities</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_venue_data['accomodation__amenities'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_venue_data['getting_there'])) { ?>
                        <div class="overview-header">
                            <h3>Getting there</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_venue_data['getting_there'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_venue_data['additional_offer_'])) { ?>
                        <div class="overview-header">
                            <h3>Additional offerings beyond weddings</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_venue_data['additional_offer_'])); ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * Supplier Overview fields shortcode
         */

         public static function display_supplier_overview_fields() {
            ob_start();
            global $post, $wpdb;
            $post_id = $post->ID;
            $get_vendor_data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post_id", ARRAY_A);
            if ($get_vendor_data) {
                ?>
                <script src="/wp-content/plugins/frenchweddingstyle-customizations/front-end/assests/js/slick.js"></script>
                <div class="overview overview-text">
                    <?php if (!empty($get_vendor_data['what_we_love_text'])) { ?>
                        <div class="overview-header">
                            <h3>What we Love</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_vendor_data['what_we_love_text'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_vendor_data['overview_style'])) { ?>
                        <div class="overview-header">
                            <h3>Style</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_vendor_data['overview_style'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_vendor_data['exprience'])) { ?>
                        <div class="overview-header">
                            <h3>Experience</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_vendor_data['exprience'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_vendor_data['availability__travel'])) { ?>
                        <div class="overview-header">
                            <h3>Availability & Travel</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_vendor_data['availability__travel'])); ?></p>
                        </div>
                    <?php } ?>
        
                    <?php if (!empty($get_vendor_data['awards__accomodation'])) { ?>
                        <div class="overview-header">
                            <h3>Awards & Accolades</h3>
                            <p class="overview-heading"><?php echo wpautop(wp_kses_post($get_vendor_data['awards__accomodation'])); ?></p>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }
        
        /**
         * login user
         */
        public static function login_form_callback(){
            if(!is_user_logged_in()){
                ob_start();
                ?>
                <script>
                    jQuery(document).ready(function($) {
                        $('body.page-template-default').addClass('uwp_login_page');
                    });

                    function togglePasswordVisibility() {
                        var passwordField = document.getElementById('user_password');
                        var passwordIcon = document.getElementById('password-icon');
                        
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            passwordIcon.classList.remove('fa-eye-slash');
                            passwordIcon.classList.add('fa-eye');
                        } else {
                            passwordField.type = 'password';
                            passwordIcon.classList.remove('fa-eye');
                            passwordIcon.classList.add('fa-eye-slash');
                        }
                    }
                </script>
                <fieldset class="sign_in_field">
                    <div class="form_grp">
                        <div class="form_title">Login</div>
                        <div class="msgError"></div>
                        <div class="msgSucess"></div>
                        <div class="form_itm">
                            <input type="email" name="user_email" id="user_email" placeholder="Email">
                        </div>
                        <div class="form_itm">
                            <input type="password" name="user_password" id="user_password" placeholder="Password">
                            <div class="input-group-append custom-login-rent" style="top:0;right:0;position: absolute;">
                                <span class="input-group-text c-pointer px-3" onclick="togglePasswordVisibility()">
                                    <i id="password-icon" class="far fa-fw fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        <div class="custom-checkbox mb-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="remember_me" value="0">
                                    <input type="checkbox" name="remember_me" id="remember_me" value="forever" class="form-control  custom-control-input ">
                                    <label for="remember_me" class="  custom-control-label">Remember Me</label>
                                </div>
                            </div>					
                        </div>
                        <div class="sign_up_btn">
                            <button type="button" id="login" class="w-100 btn btn-secondary submit-signupinotp">LOGIN</button>
                        </div>
                        <div class="vreat-section">
                            <div class="Create-account account d-inline-block">
                                <a href="<?= site_url().'/business-signup/' ?>" class="d-block text-center mt-2 small">Create account</a>
                            </div>
                            <div class="forget-password account float-right">
                                <a href="<?= site_url().'/forgot/' ?>" class="d-block text-center mt-2 small">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php
                return ob_get_clean();
            }else{
                ob_start();
                ?>
                <script>
                    window.location.replace("<?php echo site_url(); ?>");
                </script>
                <?php
                return ob_get_clean();
            }
            
        }

        /**
         * Getting Login Ajax Request
         */
        public static function users_login(){
            global $wpdb;
            $return = array();
            $ajaxdata = $_POST;
            $username = isset($ajaxdata['user_email']) ? $wpdb->escape($ajaxdata['user_email']) : '';
            $password = isset($ajaxdata['user_password']) ? $wpdb->escape($ajaxdata['user_password']) : '';
            $remember = isset($ajaxdata['remember_me']) ? $ajaxdata['remember_me'] : '';
            if (empty($username) || empty($password)) {
                $return['status'] = false;
                $return['msg'] = 'Please provide both username and password.';
                echo json_encode($return);
                die;
            }
            $user = get_user_by('email', $username);
            if (!$user) {
                $return['status'] = false;
                $return['msg'] = 'User not found.';
                echo json_encode($return);
                die;
            }
            $phone_number = get_user_meta($user->ID, 'phone_number', true);
            if (empty($phone_number)) {
                $return['status'] = false;
                $return['msg'] = 'Your Login Email or Password is not for this page.';
            } else {
                $login_data = array(
                    'user_login'    => $username,
                    'user_password' => $password,
                    'remember'      => $remember
                );
                $user_verify = wp_signon($login_data, false);
                if (is_wp_error($user_verify)) {
                    $return['status'] = false;
                    $return['msg'] = 'Your Login Email or Password is incorrect!';
                } else {
                    wp_set_current_user($user_verify->ID);
                    wp_set_auth_cookie($user_verify->ID, $remember);
                    $return['status'] = true;
                    $return['msg'] = 'Login Successfully!';
                }
            }
            echo json_encode($return);
            exit();
        }
       
        /**
         * Bride  Login Page
         */
        public static function bride_login_form_callback(){
            if(!is_user_logged_in()){
                ob_start();
                ?>
                <script>
                    jQuery(document).ready(function($) {
                        $('body.page-template-default').addClass('uwp_login_page');
                    });

                    function togglePasswordVisibilityBrideLogin() {
                        var passwordFieldBrideLogin = document.getElementById('user_password-bride-login');
                        var passwordIconBrideLogin = document.getElementById('password-icon-bride-login');
                        if (passwordFieldBrideLogin.type === 'password') {
                            passwordFieldBrideLogin.type = 'text';
                            passwordIconBrideLogin.classList.remove('fa-eye-slash');
                            passwordIconBrideLogin.classList.add('fa-eye');
                        } else {
                            passwordFieldBrideLogin.type = 'password';
                            passwordIconBrideLogin.classList.remove('fa-eye');
                            passwordIconBrideLogin.classList.add('fa-eye-slash');
                        }
                    }
                </script>
                <fieldset class="sign_in_field">
                    <div class="form_grp">
                        <div class="form_title">Bride Login</div>
                        <div class="msgError"></div>
                        <div class="msgSucess"></div>
                        <div class="form_itm">
                            <input type="email" name="user_email" id="user_email" placeholder="Email">
                        </div>
                        <div class="form_itm">
                            <input type="password" name="user_password" id="user_password-bride-login" placeholder="Password">
                            <div class="input-group-append custom-login-rent" style="top:0;right:0;position: absolute;">
                                <span class="input-group-text c-pointer px-3" onclick="togglePasswordVisibilityBrideLogin()">
                                    <i id="password-icon-bride-login" class="far fa-fw fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        <div class="custom-checkbox mb-3">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="remember_me" value="0">
                                    <input type="checkbox" name="remember_me" id="remember_me" value="forever" class="form-control  custom-control-input ">
                                    <label for="remember_me" class="  custom-control-label">Remember Me</label>
                                </div>
                            </div>					
                        </div>
                        <div class="sign_up_btn">
                            <button type="button" id="submit-login" class="w-100 btn btn-secondary submit-signupinotp">LOGIN</button>
                        </div>
                        <div class="vreat-section">
                            <div class="Create-account account d-inline-block">
                                <a href="<?= site_url().'/register/' ?>" class="d-block text-center mt-2 small">Create account</a>
                            </div>
                            <div class="forget-password account float-right">
                                <a href="<?= site_url().'/forgot/' ?>" class="d-block text-center mt-2 small">Forgot password?</a>
                            </div>
                        </div>
                        
                    </div>
                </fieldset>
                <?php
                return ob_get_clean();
            }else{
                ob_start();
                ?>
                <script>
                    window.location.replace("<?php echo site_url(); ?>");
                </script>
                <?php
                return ob_get_clean();
            }
            
        }

        /**
         * Getting BrideLogin Ajax Request
         */
        public static function bride_users_login(){
            global $wpdb;   
            $return = array(); 
            $ajaxdata = $_POST;
            $username   =   $wpdb->escape($ajaxdata['user_email']);  
            $password   =   $wpdb->escape($ajaxdata['user_password']);  
            $remember   =   $ajaxdata['remember_me']; 
            
            $user = get_user_by('email', $ajaxdata['user_email']);
            if (!$user) {
                $return['status'] = false;
                $return['msg'] = 'User not found.';
                echo json_encode($return);
                die;
            }
            $phone_number = get_user_meta($user->ID, 'phone_number', true);
            if ($phone_number){
                $return['status']   =   false;
                $return['msg']      =   'Your Login Email or Password is not for this page.';
            }else{
                $login_data                     =   array();  
                $login_data['user_login']       =   $username;  
                $login_data['user_password']    =   $password;  
                $login_data['remember']         =   $remember;
                $user_verify                    =   wp_signon($login_data, false);
                if (is_wp_error($user_verify)) {  
                    $return['status'] = false;
                    $return['msg'] = 'Your Login Email or Password is incorrect!';
                } else {    
                    wp_set_current_user($user_verify->ID);
                    wp_set_auth_cookie($user_verify->ID, $remember);
                    $return['status']   =   true;
                    $return['msg']      =   'Login Successfully!';
                } 
            }
            echo json_encode($return);
            exit();
        }
        
        /**
         *   shortcode to display select memebership form
         */
        public static function package_select_membership(){
            global $wpdb;
            $user_id       = (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : '';
            ob_start();
                ?>
                <style>
                    .accordion-item .panel {
                            display: none;
                        }
                        .accordion-item.active .panel {
                            display: block;
                        }
                        .accordion-item .toggle-icon:before {
                            content: '+';
                        }
                        .accordion-item.active .toggle-icon:before {
                            content: '-';
                        }
                        table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                        }

                        td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                        }

                        tr:nth-child(even) {
                        background-color: #dddddd;
                        }
                </style>
                <script>
                    jQuery(document).ready(function($) {
                        jQuery('.accordion-item').click(function(){
                            jQuery('.accordion-item').not(this).removeClass('active').children('.panel').slideUp();
                            jQuery(this).addClass('active').children('.panel').slideDown();
                        });
                        
                    });
                    jQuery(document).ready(function() {       
                        jQuery('.getpaid.bsui.sdel-10851df0, #registration_form').wrapAll('<div id="new_container"></div>');
                        });
    
                    jQuery(document).ready(function(){
                        // setTimeout(function(){
                        jQuery('body.page-template-default').addClass('Business-Login');
                    // }, 2000); 
                });
                </script>
                    <?php
                    $role = (isset($_REQUEST['item_id']) && !empty($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : '';
                    // $getrole       = (isset($_REQUEST['role']) && !empty($_REQUEST['role'])) ? $_REQUEST['role'] : '';
                    // $venue_essential_price = get_option('membership_package_venue_essential_price', '');
                    // $venue_premium_price = get_option('membership_package_venue_premium_price', '');
                    // $supplier_essential_price = get_option('membership_package_Supplier_essential_price', '');
                    // $supplier_premium_price = get_option('membership_package_Supplier_premium_price', '');

                    ?>
                    <!-- <script>
                        jQuery(document).ready(function($) {
                            setTimeout(function() {
                            var getRole = "<?php echo htmlspecialchars($getrole); ?>";
                            var role = "<?php echo htmlspecialchars($role); ?>";
                            var venueEssentialPrice = "<?php echo htmlspecialchars($venue_essential_price); ?>";
                            var venuePremiumPrice = "<?php echo htmlspecialchars($venue_premium_price); ?>";
                            var supplierEssentialPrice = "<?php echo htmlspecialchars($supplier_essential_price); ?>";
                            var supplierPremiumPrice = "<?php echo htmlspecialchars($supplier_premium_price); ?>";

                            console.log("getRole",getRole);
                            console.log("role",role);
                            console.log("venueEssentialPrice",venueEssentialPrice);
                            console.log("venuePremiumPrice",venuePremiumPrice);
                            console.log("supplierEssentialPrice",supplierEssentialPrice);
                            console.log("supplierPremiumPrice",supplierPremiumPrice);

                            var priceDiv = '<div class="display_price">' +
                            '<p>' + getRole + 'price</p>';

                            if (getRole === 'venue' && role == 111560) {
                                priceDiv += '<p class="price">' + venueEssentialPrice + '</p>';
                            } else if (getRole === 'supplier' && role == 111560) {
                                priceDiv += '<p class="price">' + supplierEssentialPrice + '</p>';
                            } else if (getRole === 'venue' && role == 113421) {
                                priceDiv += '<p class="price">' + venuePremiumPrice + '</p>';
                            } else if (getRole === 'supplier' && role == 113421) {
                                priceDiv += '<p class="price">' + supplierPremiumPrice + '</p>';
                            }

                            priceDiv += '</div>';
                             console.log("priceDiv", priceDiv)
                            $('.getpaid-address-field-wrapper__company').append(priceDiv);
                       
                        }, 2000);
                    });
                    </script> -->
                    <?php
                    if (isset($user_id)) { 
                        $get_user_data = $wpdb->get_results("SELECT id FROM `".$wpdb->prefix."getpaid_customers` WHERE user_id = '$user_id' ORDER BY `id` DESC", ARRAY_A);

                        if (!empty($get_user_data)) {
                            $customer_ids = array(); 
                            foreach ($get_user_data as $customer_id){
                                $customer_ids[] = $customer_id['id']; 
                            }
                            $get_invoice_data = array();
                            foreach ($customer_ids as $Customer_id) {
                                $invoices = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."getpaid_invoices` WHERE customer_id = '$Customer_id' ORDER BY `post_id` DESC", ARRAY_A);
                                if (!empty($invoices)) {
                                   
                                    $get_invoice_data = array_merge($get_invoice_data, $invoices); 
                                }
                            }
                            if (!empty($get_invoice_data)) {
                                $post_ids = array(); 
                                foreach ($get_invoice_data as $invoice) {
                                    $post_ids[] = $invoice['post_id'];
                                    $invoice_key[] = $invoice['invoice_key'];
                                }
                                $post_ids_str = implode(',', $post_ids); 
                                $get_invoice_items = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."getpaid_invoice_items` WHERE post_id IN ($post_ids_str) ORDER BY `post_id` DESC", ARRAY_A);
                            }
                        }
                    }
                    if (!empty($invoice_key)) {
                            if(!empty($get_invoice_data)){
                            ?>
                            <style>
                                div#new_container {
                                    display: none;
                                }
                            </style>
                            <table>
                                <h2>My Subscription</h2>
                                <tr>
                                    <th>Reference Id</th>
                                    <th>Package Name</th>
                                    <th>Total Payment</th>
                                    <th>Renewal Date</th>
                                    <th>View Invoice</th>
                                </tr>
                                <?php foreach ($get_invoice_data as $invoice) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($invoice['number']); ?></td>
                                    <td>
                                        <?php 
                                        foreach ($get_invoice_items as $invoiceitem) { 
                                            if ($invoiceitem['post_id'] == $invoice['post_id']) { 
                                                $item_name = htmlspecialchars($invoiceitem['item_name']);
                                                echo ($item_name == 'Silver') ? 'Essential' : $item_name;
                                                break; 
                                            }
                                        } 
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($invoice['total']); ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($invoice['completed_date'] . ' +1 year')); ?></td>
                                    <td><a href="https://frenchweddingstyle.com/invoice/invoice-<?php echo substr($invoice['number'], 4); ?>/?invoice_key=<?php echo $invoice['invoice_key']; ?>">View Invoice</a></td>
                                </tr>
                                <?php } ?>
                            </table>
                            <?php
                        }
                    } else {
                    ?>
                    <form id="registration_form" method="post">
                        <?php
                    $role = (isset($_REQUEST['item_id']) && !empty($_REQUEST['item_id'])) ? $_REQUEST['item_id'] : '';
                    $getrole       = (isset($_REQUEST['role']) && !empty($_REQUEST['role'])) ? $_REQUEST['role'] : '';
                    if($role == 113421){
                    ?>
                        <style>
                            .getpaid-custom-fields {
                                display: none;
                            }
                        </style>
                        <script>  
                            document.addEventListener("DOMContentLoaded", function() {
                                var form = document.querySelector('.getpaid-payment-form');
                                var quantityInput = document.createElement('input');
                                quantityInput.type = 'hidden';
                                quantityInput.name = 'getpaid-items[113421][quantity]';
                                quantityInput.value = '1';

                                // Create the hidden input for price
                                var priceInput = document.createElement('input');
                                priceInput.type = 'hidden';
                                priceInput.name = 'getpaid-items[113421][price]';
                                priceInput.value = '17';

                                // Create the hidden input for item
                                var getpaiditems = document.createElement('input');
                                getpaiditems.type = 'hidden';
                                getpaiditems.name = 'getpaid-form-items';
                                getpaiditems.value = '113421|1';

                                // Create the hidden input for key
                                var getpaidkey = document.createElement('input');
                                getpaidkey.type = 'hidden';
                                getpaidkey.name = 'getpaid-form-items-key';
                                getpaidkey.value = '74cbee2b658f1a00020068f889dcc27b';
                                

                                // Append the inputs to the form
                                form.appendChild(quantityInput);
                                form.appendChild(priceInput);
                                form.appendChild(getpaiditems);
                                form.appendChild(getpaidkey);
                            });
                        </script>
                        <?php } elseif($role == 111560){?>
                            <style>
                            .getpaid-custom-fields {
                                display: none;
                            }
                        </style>
                        <script>  
                            document.addEventListener("DOMContentLoaded", function() {
                                var form = document.querySelector('.getpaid-payment-form');
                                var quantityInput = document.createElement('input');
                                quantityInput.type = 'hidden';
                                quantityInput.name = 'getpaid-items[111560][quantity]';
                                quantityInput.value = '1';

                                // Create the hidden input for price
                                var priceInput = document.createElement('input');
                                priceInput.type = 'hidden';
                                priceInput.name = 'getpaid-items[111560][price]';
                                priceInput.value = '0';

                                // Create the hidden input for item
                                var getpaiditems = document.createElement('input');
                                getpaiditems.type = 'hidden';
                                getpaiditems.name = 'getpaid-form-items';
                                getpaiditems.value = '111560|1';

                                // Create the hidden input for key
                                var getpaidkey = document.createElement('input');
                                getpaidkey.type = 'hidden';
                                getpaidkey.name = 'getpaid-form-items-key';
                                getpaidkey.value = '14baf391a157e93ad5dbd3257e29a43b';
                                

                                // Append the inputs to the form
                                form.appendChild(quantityInput);
                                form.appendChild(priceInput);
                                form.appendChild(getpaiditems);
                                form.appendChild(getpaidkey);
                            });
                        </script>
                        <?php } ?>
                        
                        <input type="hidden" class="form-control" name="select_member_user_id" id="select_member_user_id" value="<?= $user_id ?>">
                        <label class="accordion-item">
                            <input type="radio" name="select_membership" id="silver_package" value="Silver" required> Essential
                            <div class="panel">
                                <p>Photo Gallery</p>
                                <p>FW Analytics</p>
                                <p>Guaranteed listing in FW Directory</p>
                                <p>Appearance on Supplier Home Page</p>
                                <p>Video Gallery</p>
                                <p>Contact Info on Supplier Profile</p>
                                <p>Social Links on Supplier Profile</p>
                                <p>Social Media Post</p>
                                <p>Real Wedding Submissions</p>
                                <p>Personalised Supplier Profile</p>
                                <p>Trusted Supplier Tick</p>
                                <p>SEO’d Profile</p>
                                <p>Supplier Spotlight Post</p>
                                <p>Promote Offers & Events</p>
                                <p>Welcome post on FW Social</p>
                            </div>
                        </label>
                        
                        <label class="accordion-item">
                            <input type="radio" name="select_membership" id="premium_package" value="Premium"> PREMIUM
                            <div class="panel">
                            <p>Photo Gallery</p>
                                <p>FW Analytics</p>
                                <p>Guaranteed listing in FW Directory</p>
                                <p>Appearance on Supplier Home Page</p>
                                <p>Video Gallery</p>
                                <p>Contact Info on Supplier Profile</p>
                                <p>Social Links on Supplier Profile</p>
                                <p>Social Media Post</p>
                                <p>Real Wedding Submissions</p>
                                <p>Personalised Supplier Profile</p>
                                <p>Trusted Supplier Tick</p>
                                <p>SEO’d Profile</p>
                                <p>Supplier Spotlight Post</p>
                                <p>Promote Offers & Events</p>
                                <p>Welcome post on FW Social</p>
                            </div>
                        </label>
                        <!-- <button type="submit" name="submit_select_membership">Register</button> -->
                    </form>
                    
                    <script>
                        jQuery(document).ready(function($) {
                            var selectedMembership = localStorage.getItem('selectedMembership');
                            if (selectedMembership) {
                                $('input[name="select_membership"][value="' + selectedMembership + '"]').prop('checked', true);
                            }

                            setTimeout(function() {
                                $('input[name="select_membership"]').change(function() {
                                    var itemId;
                                    if ($(this).val() === 'Silver') {
                                        itemId = 111560;
                                    } else if ($(this).val() === 'Premium') {
                                        itemId = 113421;
                                    }
                                    var currentUrl = window.location.href;
                                    var newUrl = currentUrl.replace(/item_id=\d+/, 'item_id=' + itemId);
                                    window.history.pushState({path: newUrl}, '', newUrl);
                                    localStorage.setItem('selectedMembership', $(this).val());

                                    window.location.reload();
                                });
                            }, 2000);
                        });
                    </script>
                <?php
                    }
                return ob_get_clean();
        }

        /**
         * save select membership
         */
        public static function fws_save_custom_select_membership() {
                global $wpdb;
                if (isset($_POST['submit_select_membership'])) { 
                if(isset($_POST['select_membership']) && isset($_POST['select_member_package_id'])) {
                    $selected_membership = sanitize_text_field($_POST['select_membership']);
                    if($selected_membership == 'Silver'){
                        $select_member_package_id = '1';
                    }elseif($selected_membership == 'Premium'){
                        $select_member_package_id = '9';
                    }
                }
            }
            if (isset($_POST['select_member_user_id'])) { 
                $select_member_user_id = $_POST['select_member_user_id'];
            }
             if(!empty($select_member_user_id)){
                self::redirect_url_on_payment_page($select_member_user_id, $select_member_package_id);
             }
        }

       /**
        *  redirect on payment method
        */    
        public static function redirect_url_on_payment_page($select_member_user_id, $select_member_package_id){
            global $wpdb;
            $userdata           =   get_user_by('id', $select_member_user_id);
            $item_id            =   get_user_meta($select_member_user_id, 'supplier_package_item_id', true);
            $package_id         = $select_member_package_id;
            if(empty($item_id)){
                $select_membership_item_id = $wpdb->get_row("SELECT meta_value FROM `".$wpdb->prefix."geodir_pricemeta` WHERE package_id='$package_id' AND meta_key='invoicing_product_id'");
                $item_id = $select_membership_item_id->meta_value;
               
                if(empty($item_id)){
                    $item_id = 113421;
                }
            }
            $creds              =   array(
                'user_login'    => $userdata->user_login,
                'user_password' => $userdata->user_password,
                'remember'      => true,
            );
            $user = wp_signon( $creds, false );
            wp_set_auth_cookie($select_member_user_id);
            $url = '?getpaid_embed=1&item='.$item_id.'';
            wp_redirect(home_url('/'.$url.''));
            exit();
        }

        /**
         *  
         * shortcode to display texonomy in frontend real wedding blogs page
         * 
        */
        public static function display_real_wedding_blogsgeodirectory_tags() {
            global $post;
            $args = array(
                'post_type' => 'gd_rwedding_blogs',
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                $tags = array();
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_tags = get_the_terms($post->ID, 'gd_rwedding_blogs_tags');
                    if ($post_tags && !is_wp_error($post_tags)) {
                        foreach ($post_tags as $tag) {
                            $term_link = get_term_link($tag);
                            if (!is_wp_error($term_link)) {
                                $tags[] = '<a href="' . esc_url($term_link) . '" class="-rweddingblogs-tags">' . $tag->name . '</a>';
                            } else {
                                $tags[] = '<span class="-rweddingblogs-tags">' . $tag->name . '</span>';
                            }
                        }
                    }
                }
                $tags = array_unique($tags);
                $output = '<div class="real-wedding-blogs-taxonomy"><style>.real-wedding-blogs-taxonomy a {
                    color: #1E1E1E;
                    font-family: Söhne, sans-serif !important;
                    font-size: 14px !important;
                    font-weight: 400 !important;
                    line-height: 17.84px;
                    border-radius: 22px;
                    padding: 3px 26px;
                    border: 1px solid black;
                    display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    margin-bottom: 3%;
                }</style>' . implode(' ', $tags) . '</div>';
                wp_reset_postdata();
                return $output;
            } else {
                return 'No tags found.';
            }
        }

        /**
         * shortcode to display region in trust vendor cards in frontend supplier listings page
         */
        public static function fws_suplier_region_shortcode() {
            ob_start(); 
            global $wpdb, $gd_post, $post;
            $gdpost_id = $gd_post->ID;
            $post_id = $post->ID;
            $linked_supplier_ids = $wpdb->get_results("SELECT linked_id FROM wp_geodir_cp_link_posts WHERE post_id = $post_id AND linked_post_type ='gd_suppliers'", ARRAY_A);
            // echo "SELECT linked_id FROM wp_geodir_cp_link_posts WHERE post_id = $post_id AND linked_post_type ='gd_suppliers'";
            // echo '<pre>';
            // print_r($linked_supplier_ids);
            // echo '</pre>';
            // exit;
            $selected_supplier_ids = [];
            foreach ($linked_supplier_ids as $supplier_id) {
                $selected_supplier_ids[] = $supplier_id['linked_id'];
            }

            
            if (!is_array($selected_supplier_ids) || empty($selected_supplier_ids)) {
                echo '';
                return ob_get_clean();
            }
            $args = [
                'post_type'     => 'gd_suppliers',
                'post_status'   => 'publish',
                'orderby'       => 'date',
                'order'         => 'DESC',
                'post__in'      =>  $selected_supplier_ids,
            ];
            $region_suppliers = get_posts($args);
            if (!empty($region_suppliers)) {
                foreach ($region_suppliers as $supplier) {
                    $post_id = $supplier->ID;
                    $region_supplier_card_text = $wpdb->get_row("SELECT main_service_area FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post->ID");
                    $region = $region_supplier_card_text->main_service_area;
                    ?>
                    <div class="region_venue" style="display:flex;">
                        <div class="region_value">
                            <?php 
                            if(isset($region) && !empty($region)){
                            echo $region;
                            } ?>
                        </div>
                    </div> 
                        <?php
                        $content = '<div class="post-info-top trust_venodor_cards">';
                        if(isset($gd_post->price) && !empty($gd_post->price)){
                            $content .= '
                            <div class="info-list">
                            <div class="post-price">
                                From [gd_post_meta id="'.$gdpost_id.'" key="price" show="value-strip" font_size="0"]
                            </div>
                            </div>
                            ';
                        }
                        $content .= '</div>';
                        echo do_shortcode($content);
                        ?>
                    
                    <?php
                    break;
                }
            } else {
               
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display region in trust vendor cards in frontend venue listings page
         */
        public static function fws_geodirectory_region_venue_shortcode_cb() {
            ob_start();
            global $wpdb, $gd_post, $post;
            $gdpost_id = $gd_post->ID;
            $post_id = $post->ID;
            $linked_venue_ids = $wpdb->get_results("SELECT linked_id FROM wp_geodir_cp_link_posts WHERE post_id = $post_id AND linked_post_type ='gd_suppliers'", ARRAY_A);
            $selected_venue_ids = [];
            foreach ($linked_venue_ids as $venue_id) {
                $selected_venue_ids[] = $venue_id['linked_id'];
            }
            if (!is_array($selected_venue_ids) || empty($selected_venue_ids)) {
                echo '';
                return ob_get_clean();
            }
            $args = [
                'post_type'     => 'gd_suppliers',
                'post_status'   => 'publish',
                'orderby'       => 'date',
                'order'         => 'DESC',
                'post__in'      =>  $selected_venue_ids,
            ];
            $region_venues = get_posts($args);
            if (!empty($region_venues)) {  
                foreach ($region_venues as $venue) {
                    $post_id = $venue->ID;
                    $no_of_guests   =   geodir_get_post_meta($gdpost_id, 'no_of_guests', true);
                    $no_of_bedrooms =   geodir_get_post_meta($gdpost_id, 'no_of_bedrooms', true);
                    $region_venue_card_text = $wpdb->get_row("SELECT region FROM {$wpdb->prefix}geodir_gd_place_detail WHERE post_id = $post->ID");
                    $region = $region_venue_card_text->region;
                    ?>
                    <div class="region_venue" style="display:flex;">
                        <div class="region_value">
                            <?php 
                            if(isset($region) && !empty($region)){
                            echo $region;
                            } ?>
                        </div>
                    </div>   
                        <?php
                        $content = '<div class="post-info-top trust_venodr_cards">';
                        if(isset($gd_post->price) && !empty($gd_post->price)){
                            $content .= '
                            <div class="info-list">
                            <div class="post-price">
                                From [gd_post_meta id="'.$gdpost_id.'" key="price" show="value-strip" font_size="0"]
                            </div>
                            </div>
                            ';
                        }
                        echo do_shortcode($content);
                        ?>
                            <div class="no_of_guests">
                                <?php 
                                if(isset($no_of_guests) && !empty($no_of_guests)){
                                    echo  $no_of_guests;
                                }  ?>
                            </div>
                            <div class="no_of_bedrooms">
                                <?php
                                if(isset($no_of_bedrooms) && !empty($no_of_bedrooms)){
                                echo $no_of_bedrooms; 
                                } ?>
                            </div>
                        </div>
                    <?php
                    break;
                }
            } else {
                echo '';
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display trust vendor fields in frontend venue listings page
         */
        public static function fws_geodirectory_select_values_cp_link_venue_shortcode()
        {
            ob_start();
            global $wpdb, $post;
            $post_id = $post->ID;
            $linked_venue_ids = $wpdb->get_results("SELECT linked_id FROM wp_geodir_cp_link_posts WHERE post_id = $post_id and linked_post_type ='gd_place'", ARRAY_A);
            $selected_venue_ids = [];
            foreach ($linked_venue_ids as $venue_id) {
                $selected_venue_ids[] = $venue_id['linked_id'];
            }
            if (!is_array($selected_venue_ids) || empty($selected_venue_ids)) {
                echo '<h3>No Records Found.</h3>';
                return ob_get_clean();
            }
            $args = [
                'post_type'     => 'gd_place',
                'post_status'   => 'publish',
                'orderby'       => 'date',
                'order'         => 'DESC',
                'post__in'      =>  $selected_venue_ids,
            ];
            $venue_post_real_wedding_blog = get_posts($args);
            if(!empty($venue_post_real_wedding_blog)){
                echo '<style>
                        .post-learn-more-btn {
                            margin-top: 10px;
                        }
                        .listing-box-link {
                            display: block;
                            position: relative;
                            overflow: hidden;
                            max-height: calc(1.2em * 3); /* Adjust as needed */
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            margin-top: 10px;
                        }
                        #avlabs_grid_listing_fullSearch_featured .slick-track {
                            opacity: 1;
                            width: 1586px !important;
                            left: 0px;
                        }
                        
                    </style>';
                echo '<div class="geodir-loop-container" id="custom-venue_real_wedding_blog">';
                foreach ($venue_post_real_wedding_blog as $post_real_wedding_blog):
                    $post_real_wedding_blog_id        =   $post_real_wedding_blog->ID;
                    $post_title        =   $post_real_wedding_blog->post_title;
                    $geodir_post    =   geodir_get_post_info( $post_real_wedding_blog_id );
                    $categories     =   (isset($geodir_post->post_category) && !empty($geodir_post->post_category)) ? explode(',', $geodir_post->post_category) : [];
                    $term           =   (isset($categories[1]) && !empty($categories[1])) ? get_term($categories[1]) : [];
                    $term_name      =   (isset($term->name) && !empty($term->name)) ? ucfirst($term->name) : '';
                    $post_real_wedding_blog_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_real_wedding_blog_id);
                    $card_text = $wpdb->get_row( "SELECT venue_card_text FROM " . $wpdb->prefix . "geodir_gd_place_detail WHERE post_id = $post_real_wedding_blog_id" );
                    $truncated_text_real_wedding_blog = wp_trim_words($card_text->venue_card_text, 20, '...');
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post_real_wedding_blog);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='gd-venue-listings-images'>
                    ";
                    if(!empty($post_real_wedding_blog_images)){
                        $content .= "<div class='custom-venue-supp-images-slider'>";
                        foreach($post_real_wedding_blog_images as $img){
                            if(!empty($img['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$img['src'].'"></div>';
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='category-badge'>
                        <span class='badge-text'>".$term_name."</span>
                    </div>
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted venue</span>
                    </div>
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    <a href='".$permalink."'><h2 class='title'>".$geodir_post->post_title."</h2></a>
                    </div>
                    <div class='post-meta-data'>
                        <span class='region'>[gd_post_meta key='region' show='value-raw' no_wrap='1']</span>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    <div class='post-content venue-card-text'> ". $truncated_text_real_wedding_blog ."</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
            }else{
                echo '<h3>No Records Found.</h3>';
            }
            ?>
            <?php
            return ob_get_clean();
        }

        /**
         * shortcode to display trust vendor fields in frontend supplier listings page
         */
        public static function fws_geodirectory_select_values_cp_link_supplier_shortcode()
        {
            ob_start();
            global $wpdb, $post;
            $post_id = $post->ID;
            $linked_supplier_ids = $wpdb->get_results("SELECT linked_id FROM wp_geodir_cp_link_posts WHERE post_id = $post_id AND linked_post_type ='gd_suppliers'", ARRAY_A);
            $selected_supplier_ids = [];
            foreach ($linked_supplier_ids as $supplier_id) {
                $selected_supplier_ids[] = $supplier_id['linked_id'];
            }
            if (!is_array($selected_supplier_ids) || empty($selected_supplier_ids)) {
                echo '<h3>No Records Found.</h3>';
                return ob_get_clean();
            }
            $args = [
                'post_type'     => 'gd_suppliers',
                'post_status'   => 'publish',
                'orderby'       => 'date',
                'order'         => 'DESC',
                'post__in'      =>  $selected_supplier_ids,
            ];
            $supplier_post_real_wedding_blog = get_posts($args);
            if(!empty($supplier_post_real_wedding_blog)){
                echo '<style>    
                    </style>';
                echo '<div class="geodir-loop-container" id="custom-venue_real_wedding_blog">';
                foreach ($supplier_post_real_wedding_blog as $post_real_wedding_blog_supplier):
                    $post_real_wedding_blog_supplier_id        =   $post_real_wedding_blog_supplier->ID;
                    $geodir_post    =   geodir_get_post_info( $post_real_wedding_blog_supplier_id );
                    $categories     =   (isset($geodir_post->post_category) && !empty($geodir_post->post_category)) ? explode(',', $geodir_post->post_category) : [];
                    $term           =   (isset($categories[1]) && !empty($categories[1])) ? get_term($categories[1]) : [];
                    $term_name      =   (isset($term->name) && !empty($term->name)) ? ucfirst($term->name) : '';
                    $post_real_wedding_blog_supplier_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_real_wedding_blog_supplier_id);
                    $supplier_card_text = $wpdb->get_row("SELECT supplier_card_text FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post_real_wedding_blog_supplier_id");
                    $limited_content_real_wedding_blog = $supplier_card_text->supplier_card_text;
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post_real_wedding_blog_supplier);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='gd-venue-listings-images'>
                    ";
                    if(!empty($post_real_wedding_blog_supplier_images)){
                        $content .= "<div class='custom-venue-supp-images-slider'>";
                        foreach($post_real_wedding_blog_supplier_images as $image){
                            if(!empty($image['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$image['src'].'"></div>';
                                break;
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='category-badge'>
                        <span class='badge-text'>".$term_name."</span>
                    </div>
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted venue</span>
                    </div>
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    <a href='".$permalink."'><h2 class='title'>".$geodir_post->post_title."</h2></a>
                    </div>
                    <div class='post-meta-data'>
                        <span class='region'>[gd_post_meta key='region' show='value-raw' no_wrap='1']</span>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    <div class='venue_card_text '> ".$limited_content_real_wedding_blog."</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
            }else{
                echo '<h3>No Records Found.</h3>';
            }
            ?>
            
            <?php
            return ob_get_clean();
        }
        
        /**
         * shortcode to display select suppliers and display cards accordingly in real wedding blogs frontend page
        */
        public static function fws_supplier_real_wedding_blog_shortcode_cb(){
            ob_start();
            global $wpdb;

            $selected_suppliers = get_post_meta(get_the_ID(), 'supplier_name', true);
            $selected_suppliers = is_array($selected_suppliers) ? $selected_suppliers : array($selected_suppliers);
            if(!empty($selected_suppliers)) {
            $args = [
                'post_type'      => 'gd_suppliers',
                'post_status'    => 'publish',
                'posts_per_page' => -1, 
                'post__in'       => $selected_suppliers,
                'orderby'        => 'post__in' 
            ];
            $supplier_post_real_wedding_blog = get_posts($args);
            if(!empty($supplier_post_real_wedding_blog)){
                echo '<style>
                    </style>';
                echo '<div class="geodir-loop-container" id="custom-venue_real_wedding_blog">';
                foreach ($supplier_post_real_wedding_blog as $post_real_wedding_blog_supplier):
                    $post_real_wedding_blog_supplier_id        =   $post_real_wedding_blog_supplier->ID;
                    $geodir_post    =   geodir_get_post_info( $post_real_wedding_blog_supplier_id );
                    $categories     =   (isset($geodir_post->post_category) && !empty($geodir_post->post_category)) ? explode(',', $geodir_post->post_category) : [];
                    $term           =   (isset($categories[1]) && !empty($categories[1])) ? get_term($categories[1]) : [];
                    $term_name      =   (isset($term->name) && !empty($term->name)) ? ucfirst($term->name) : '';
                    $post_real_wedding_blog_supplier_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_real_wedding_blog_supplier_id);
                    $price          =   geodir_get_post_meta($post_real_wedding_blog_supplier_id, 'price', true);
                    $supplier_card_text = $wpdb->get_row("SELECT supplier_card_text FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post_real_wedding_blog_supplier_id");
                    $limited_content_real_wedding_blog = $supplier_card_text->supplier_card_text;
                    $region_supplier_card_text = $wpdb->get_row("SELECT main_service_area FROM {$wpdb->prefix}geodir_gd_suppliers_detail WHERE post_id = $post_real_wedding_blog_supplier_id");
                    $region = $region_supplier_card_text->main_service_area;
                    $metaHtml       =   '';
                    if(!empty($price)){
                        $metaHtml .= "<span class='price'>From [gd_post_meta key='price' show='value-strip' no_wrap='1']</span>";
                    }
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post_real_wedding_blog_supplier);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='gd-venue-listings-images'>
                    ";
                    if(!empty($post_real_wedding_blog_supplier_images)){
                        $content .= "<div class='custom-venue-supp-images-slider'>";
                        foreach($post_real_wedding_blog_supplier_images as $image){
                            if(!empty($image['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$image['src'].'"></div>';
                                break;
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='category-badge'>
                        <span class='badge-text'>".$term_name."</span>
                    </div>
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted venue</span>
                    </div>
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    <a href='".$permalink."'><h3 class='title'>".$geodir_post->post_title."</h3></a>
                    </div>
                    <div class='post-meta-data'>
                        <span class='region'>".$region."</span>
                        <div class='meta-childs'>".$metaHtml."</div>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    <div class='venue_card_text '> ".$limited_content_real_wedding_blog."</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
            }
        }
        ?>
        <?php
        return ob_get_clean();
        }

        /**
         * shortcode to display select venue and display cards accordingly in real wedding blogs frontend page
        */
        public static function fws_venue_real_wedding_blog_shortcode_cb(){
            ob_start();
            global $wpdb;
        
            $selected_venues = get_post_meta(get_the_ID(), 'venue_name', true);
            $selected_venues = is_array($selected_venues) ? $selected_venues : array($selected_venues);
            if(!empty($selected_venues)) {
            $args = [
                'post_type'      => 'gd_place',
                'post_status'    => 'publish',
                'posts_per_page' => -1, 
                'post__in'       => $selected_venues,
                'orderby'        => 'post__in' 
            ];
            $venue_post_real_wedding_blog = get_posts($args);
            if(!empty($venue_post_real_wedding_blog)){
                echo '<style>
                        .post-learn-more-btn {
                            margin-top: 10px;
                        }
                        .listing-box-link {
                            display: block;
                            position: relative;
                            overflow: hidden;
                            max-height: calc(1.2em * 3); /* Adjust as needed */
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            margin-top: 10px;
                        }
                        #avlabs_grid_listing_fullSearch_featured .slick-track {
                            opacity: 1;
                            width: 1586px !important;
                            left: 0px;
                        }
                        
                    </style>';
                echo '<div class="geodir-loop-container" id="custom-venue_real_wedding_blog">';
                foreach ($venue_post_real_wedding_blog as $post_real_wedding_blog):
                    $post_real_wedding_blog_id        =   $post_real_wedding_blog->ID;
                    $post_title        =   $post_real_wedding_blog->post_title;
                    $geodir_post    =   geodir_get_post_info( $post_real_wedding_blog_id );
                    $categories     =   (isset($geodir_post->post_category) && !empty($geodir_post->post_category)) ? explode(',', $geodir_post->post_category) : [];
                    $term           =   (isset($categories[1]) && !empty($categories[1])) ? get_term($categories[1]) : [];
                    $term_name      =   (isset($term->name) && !empty($term->name)) ? ucfirst($term->name) : '';
                    $post_real_wedding_blog_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_real_wedding_blog_id);
                    $no_of_guests   =   geodir_get_post_meta($post_real_wedding_blog_id, 'no_of_guests', true);
                    $no_of_bedrooms =   geodir_get_post_meta($post_real_wedding_blog_id, 'no_of_bedrooms', true);
                    $price          =   geodir_get_post_meta($post_real_wedding_blog_id, 'price', true);
                    $card_text = $wpdb->get_row( "SELECT venue_card_text FROM " . $wpdb->prefix . "geodir_gd_place_detail WHERE post_id = $post_real_wedding_blog_id" );
                    $truncated_text_real_wedding_blog = wp_trim_words($card_text->venue_card_text, 20, '...');
                    $region_venue_card_text = $wpdb->get_row("SELECT region FROM {$wpdb->prefix}geodir_gd_place_detail WHERE post_id = $post_real_wedding_blog_id");
                    $region = $region_venue_card_text->region;
                    $metaHtml       =   '';
                    if(!empty($no_of_guests)){
                        $metaHtml .= "<span class='no_of_guests'>[gd_post_meta key='no_of_guests' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($no_of_bedrooms)){
                        $metaHtml .= "<span class='no_of_bedrooms'>[gd_post_meta key='no_of_bedrooms' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($price)){
                        $metaHtml .= "<span class='price'>From [gd_post_meta key='price' show='value-strip' no_wrap='1']</span>";
                    }
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post_real_wedding_blog);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='gd-venue-listings-images'>
                    ";
                    if(!empty($post_real_wedding_blog_images)){
                        $content .= "<div class='custom-venue-supp-images-slider'>";
                        foreach($post_real_wedding_blog_images as $img){
                            if(!empty($img['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$img['src'].'"></div>';
                                break;
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='category-badge'>
                        <span class='badge-text'>".$term_name."</span>
                    </div>
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted venue</span>
                    </div>
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    <a href='".$permalink."'><h3 class='title'>".$geodir_post->post_title."</h3></a>
                    </div>
                    <div class='post-meta-data'>
                    <span class='region'>".$region."</span>
                        <div class='meta-childs'>".$metaHtml."</div>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    <div class='post-content venue-card-text'> ". $truncated_text_real_wedding_blog ."</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
            }
        } 
        ?>
        <?php
        return ob_get_clean();
        }

        /**
         * Shortcode to display vendors name and url in real wedding blogs frontend page
         */
        public static function display_wedding_vendor_details(){
            ob_start();
            global $post;
            $post_id = $post->ID;
            $vendor_items = get_post_meta($post_id, 'vendor_data', true);
            if (!empty($vendor_items)) {
                ?>
                 <style>
                    .accordion-vendor-details {
                        display: flex;
                        flex-direction: column;
                        gap: 16px;
                    }
                    .accordion-vendor-details-item {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                </style>
                <script>
                    jQuery(document).ready(function(){
                        jQuery('.overlay_link').attr('rel', 'noopener noreferrer');
                        jQuery('.overlay_link').attr('target', '_blank');
                    });
                </script>
                <div class="accordion-vendor-details">
                    <?php foreach ($vendor_items as $vendor_item) {
                        ?>
                        <div class="accordion-vendor-details-item">
                            <h3 class="accordion-vendor-details-title"> <?php echo esc_html($vendor_item['vendor_details']); ?></h3><a href="<?php echo esc_html($vendor_item['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($vendor_item['vendor_name']); ?></a>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
        * Shortcode to display Sub Heading in real wedding blogs frontend page
        */
        public static function display_wedding_sub_heading(){
            ob_start();
            global $post;
            $post_id = $post->ID;
            $sub_wedding = get_post_meta($post_id, 'sub_heading', true);
            if (!empty($sub_wedding)) {
                ?>
                 <style>
                    .accordion-sub-wedding {
                        display: flex;
                        flex-direction: column;
                        gap: 16px;
                    }
                    .accordion-sub-wedding-item {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                </style>
                <div class="accordion-sub-wedding">
                    <div class="accordion-sub-wedding-item">
                        <h3 class="accordion-sub-wedding-title"> <?php echo esc_html($sub_wedding); ?></h3>
                    </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * Shortcode to display sub heading in blogs frontend page
         */
        public static function display_blogs_sub_heading(){
            ob_start();
            global $post;
            $post_id = $post->ID;
            $blogs_sub_wedding = get_post_meta($post_id, 'blogs_sub_heading', true);
            if (!empty($blogs_sub_wedding)) {
                ?>
                 <style>
                    .accordion-blogs-sub-wedding {
                        display: flex;
                        flex-direction: column;
                        gap: 16px;
                    }
                    .accordion-blogs-sub-wedding-item {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                </style>
                <div class="accordion-blogs-sub-wedding">
                    <div class="accordion-blogs-sub-wedding-item">
                        <h3 class="accordion-blogs-sub-wedding-title"> <?php echo esc_html($blogs_sub_wedding); ?></h3>
                    </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display hero image for home page fields in frontend real wedding blogs page
         */
        public static function display_wedding_hero_image_for_homepage(){
            ob_start();
            global $wpdb, $post;
            $post_id = $post->ID;
            $hero_image_for_homepage = $wpdb->get_row("SELECT  hero_image_text_for_home_page FROM `".$wpdb->prefix."geodir_gd_suppliers_detail` WHERE post_id='$post_id' ", ARRAY_A);
            if (!empty($hero_image_for_homepage)) {
                ?>
                <div class="accordion-hero_image_for_homepage">
                    <div class="accordion-hero_image_for_homepage-item">
                        <h3 class="accordion-hero_image_for_homepage-title"> <?php echo esc_html($hero_image_for_homepage['hero_image_text_for_home_page']); ?></h3>
                    </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display overview field in frontend location page
         */
        public static function fws_location_overview_callback(){
            ob_start();
            if( ! geodir_is_page('location') ){ return; }
            global $wp_query, $wpdb;
            $region     =   isset($wp_query->query_vars['region'])      ?   $wp_query->query_vars['region']     :   '';
            if( empty( $region ) ) { return; }
            $regionSeoData = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."geodir_location_seo` WHERE region_slug='$region' AND location_type = 'region' LIMIT 1", ARRAY_A);
            $overview = '';
            if( isset( $regionSeoData['location_overview'] ) && ! empty( $regionSeoData['location_overview'] ) ){
                $overview = $regionSeoData['location_overview'];
            }
            if( ! empty( $overview ) ):
                    $overview = wp_unslash(wpautop(wp_kses_post($overview)));
            ?>
            <div class="overview_disc"><?php echo  $overview ; ?></div>
            <?php
            else:
            ?>
            <div><?php echo $overview; ?></div>
            <?php
            endif;
            return ob_get_clean();
        }

        /**
         * shortcode display region which is inserted in general blog
         */
        public static function fws_display_general_blog_select_poi_callback($post_id) {
            ob_start();
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'meta_key'       => '_post_geodir_Pois',
                'meta_query'     => array(
                    array(
                        'key'     => '_post_geodir_Pois',
                        'compare' => 'EXISTS',
                    ),
                ),
            );
            $general_blogs_query = new WP_Query($args);
            ?>
            <div class="region-container">
                <div class="inner_region-box">
                    <?php
                    if ($general_blogs_query->have_posts()) {
                        while ($general_blogs_query->have_posts()) {
                            $general_blogs_query->the_post();
                            $general_blogs_post_id = get_the_ID();
                            $permalink = get_permalink($general_blogs_post_id);
                            $title = get_the_title($general_blogs_post_id);
                            $image = get_the_post_thumbnail_url($general_blogs_post_id, 'full'); 
                            $general_blogs_post_pois_serialized = get_post_meta($general_blogs_post_id, '_post_geodir_Pois', true);
                            $general_blogs_post_pois = unserialize($general_blogs_post_pois_serialized);
                            global $wp_query;
                            $region = isset($wp_query->query_vars['region']) ? $wp_query->query_vars['region'] : '';
        
                            if (!empty($region) && is_array($general_blogs_post_pois)) {
                                foreach ($general_blogs_post_pois as $poi) {
                                    if (strpos($poi, $region) !== false) {
                                        ?>
                                        <div id="region-post-<?php echo $general_blogs_post_id; ?>" class="slide-item">
                                            <div class="item-top">
                                                <div class="item-post-thumbnail">
                                                    <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
                                                </div>
                                            </div>
                                            <div class="item-bottom">
                                                <div class="bottom item-left">
                                                    <span class="item-title-link">
                                                        <a href="<?php echo $permalink ?>"><?php echo $title; ?></a>
                                                    </span>
                                                </div>
                                                <div class="bottom item-right">
                                                    <span class="item-read-time">
                                                        <a href="<?php echo $permalink ?>">5 min read</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        break; 
                                    }
                                }
                            }
                        }
                        wp_reset_postdata(); 
                    }
                    ?>
                </div>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    $('.region-container .inner_region-box').slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: true,
                        speed: 300,
                        arrows: true,
                        responsive: [{
                            breakpoint: 767,
                            settings: {
                                slidesToShow: 1,
                            }
                        }]
                    });
                });
            </script>
            <?php    
            return ob_get_clean(); 
        }

        /**
         * shortcode to display basetitle field in frontend location page
         */
        public static function fws_display_basetitle(){
            ob_start();
            if( ! geodir_is_page('location') ){ return; }
            global $wp_query, $wpdb;
            $region     =   isset($wp_query->query_vars['region'])      ?   $wp_query->query_vars['region']     :   '';
            if( empty( $region ) ) { return; }
            $regionSeoData = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."geodir_location_seo` WHERE region_slug='$region' AND location_type = 'region' LIMIT 1", ARRAY_A);
            $base_title = '';
            if( isset( $regionSeoData['base_title'] ) && ! empty( $regionSeoData['base_title'] ) ){
                $base_title = $regionSeoData['base_title'];
            }
            if( isset( $regionSeoData['region_slug'] ) && ! empty( $regionSeoData['region_slug'] ) ){
                $region_slug = ucwords(str_replace('-', ' ', $regionSeoData['region_slug']));
            }
            if( ! empty( $base_title ) ):
            ?>
                <style>
                    .basetitle {
                        color: var(--e-global-color-astglobalcolor5);
                        font-family: "PP Editorial New", Sans-serif;
                        font-size: 50px;
                        font-weight: 400;
                        font-style: italic;
                    }
                    .regionslug {
                        color: var(--e-global-color-astglobalcolor5);
                        font-family: "PP Editorial New", Sans-serif;
                        font-size: 50px;
                        font-weight: 400;
                        font-style: italic;
                        margin-top: 5%;
                    }
                </style>
                <div class="basetitle"><?php echo wp_unslash( $base_title ); ?>
                    <span class="regionslug"><?php echo wp_unslash( $region_slug ); ?></span>
                </div>
            <?php
            else:
            ?>
            <div><?php echo $base_title; ?></div>
            <?php
            endif;
            return ob_get_clean();
        }

        /**
         * shortocde to display count and images of single location listing
         */
        public static function fws_location_count_listing_images_callback(){
            ob_start();
            if( ! geodir_is_page('location') ){ return; }
            global $wp_query, $wpdb;
            $region     =   isset($wp_query->query_vars['region'])      ?   $wp_query->query_vars['region']     :   '';
            if( empty( $region ) ) { return; }
            $regionSeoData = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."geodir_location_seo` WHERE region_slug='$region' AND location_type = 'region' LIMIT 1", ARRAY_A);
            $rows = '';
            if( isset( $regionSeoData['selected_images'] ) && ! empty( $regionSeoData['selected_images'] ) ){
                $rows = unserialize( $regionSeoData['selected_images'] );
            }
            if( ! empty( $rows ) ){
                $counter = 0;
                $gallery = array();
                foreach( $rows as $row ):
                    $counter++;
                    $gallery_item = wp_get_attachment_image( $row, 'full' );
                    array_push( $gallery, $gallery_item );
                endforeach;

                if( $counter > 4 ):
                    $text = '4+ more';
                elseif( $counter > 3 ):
                    $text = '3+ more';
                elseif( $counter > 2):
                    $text = '2+ more';
                elseif( $counter > 1 ):
                    $text = '1+ more';
                else:
                    $text = '';
                endif;
                ?>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
                <div class="location-gallery-outer">
                    <div class="inner-box">
                        <div class="image-counter">
                            <button class="location-gallery-count" id="<?php echo $region ?>"><?php echo $text; ?></button>
                        </div>
                        <div class="gallery-images-container swiper-container">
                            <div class="gallery-modal-header">
                                <span class="close">&times;</span>
                            </div>
                            <div class="swiper-wrapper my-gallery">
                                <?php
                                    $i = 0;
                                    foreach( $gallery as $image ):
                                        ?>
                                        <div class="gallery-image swiper-slide  mySlides" id="gallery-image-<?php echo $i; ?>">
                                            <a title="click to zoom-in" itemprop="contentUrl" href="" data-fancybox="gallery">
                                                <div class="numbertext"><?php echo ( $i + 1 ); ?> / <?php echo count( $gallery ); ?></div>
                                                <?php echo $image; ?>
                                            </a>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
                <script>
                    jQuery(document).on('click', 'button.location-gallery-count', function(e){
                        e.preventDefault();

                        $button = jQuery(this);
                        $first = $button.closest('.location-gallery-outer').find('.mySlides:first a');
                        $first.click();
                    });

                    jQuery(document).ready(function($){
                        jQuery('.swiper-slide img').each(function(){
                            jQuery(this).parent().attr('href', jQuery(this).attr('src'));
                            jQuery(this).attr('itemprop', "thumbnail");
                        });

                        $("[data-fancybox]").fancybox({
                            loop: true,
                            infobar: true,
                            buttons: [
                                "zoom",
                                "share",
                                "fullScreen",
                                "download",
                                "close"
                            ],
                            animationEffect: "fade",
                            animationDuration: 600,
                            transitionEffect: "fade",
                            transitionDuration: 800
                        });
                    });

                    jQuery(document).on('click', '.gallery-images-container .close', function(e){
                        $button = jQuery(this);
                    });

                    jQuery(document).ready(function($){
                        $('.gallery-image.mySlides img').attr('draggable', 'false');
                    });
                </script>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display Faq in frontend location page
         */
        public static function fws_location_faq(){
            ob_start();
            if( ! geodir_is_page('location') ){ return; }
            global $wp_query, $wpdb;
            $locationregion     =   isset($wp_query->query_vars['region']) ?  $wp_query->query_vars['region'] :  '';
            if( empty( $locationregion ) ) { return; }
            $locationRegionSeoData = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."geodir_location_seo` WHERE region_slug='$locationregion' AND location_type = 'region'", ARRAY_A);
            $faq_data = '';
            if( isset( $locationRegionSeoData['faq'] ) && ! empty( $locationRegionSeoData['faq'] ) ){
                $faq_data = unserialize($locationRegionSeoData['faq']);
            }
            ?>
            <style>
                body {
                    background-color: #f4f4f4;
                    font-family: Arial, sans-serif;
                }

                .accordion {
                    max-width: 600px;
                    margin: 0 auto;
                    user-select: none;
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
                }

                .accordion-title::after {
                    content: "+";
                    position: absolute;
                    top: 50%;
                    right: 15px;
                    transform: translateY(-50%);
                    transition: transform 0.3s ease;
                    font-size: 24px;
                }

                .accordion-content {
                    padding: 15px;
                    background-color: #fff;
                    color: #333;
                    overflow: hidden;
                }

                .accordion-item.active .accordion-title::after {
                    content: "-";
                    transform: translateY(-50%);
                    font-size: 24px;
                }

                .accordion-item.active .accordion-content {
                    padding-top: 0;
                    padding-bottom: 15px;
                }
            </style>
            <script>
                    jQuery(document).ready(function($){
                        jQuery('.accordion-item').on('click', function(e){
                            e.preventDefault();
                            jQuery(this).toggleClass("active");
                            jQuery(this).siblings().each(function(){
                                jQuery(this).removeClass('active');
                                jQuery(this).find(".accordion-content").slideUp(200, 'linear');
                            })
                            jQuery(this).find(".accordion-content").slideToggle(300, 'linear');
                        });
                    });
            </script>
            <?php
            if (!empty($faq_data)) {
                echo '<div class="accordion">';
                $counter = 0;
                foreach ($faq_data as $faq_item) {
                    if (empty($faq_item['title']) && empty($faq_item['description'])) {
                        continue; 
                    }
                    $style = $counter == 0 ? 'block' : 'none';
                    $class = $counter == 0 ? 'active' : '';
                    $slashlessDescription = htmlspecialchars_decode(esc_html(wp_unslash($faq_item['description'])));
                    $description = wp_unslash(wpautop(wp_kses_post($slashlessDescription)));
                    echo '<div class="accordion-item '. $class .'">';
                    echo '<h3 class="accordion-title">' . esc_html($faq_item['title']) . '</h3>';
                    echo '<div class="accordion-content" style="display: '. $style .';">';
                    echo '<p>' . $description  . '</p>';
                    echo '</div>';
                    echo '</div>';
                    $counter++;
                }
                echo '</div>';
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display FAQ field in frontend supplier category page
         */
        public static function display_supplier_category_FAQ() {
            ob_start();
            $term_id = get_queried_object_id();
            $faq_items = get_term_meta($term_id, 'faq_items', true);
            if (!empty($faq_items)) {
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
                        content: "+";
                        position: absolute;
                        top: 50%;
                        right: 15px;
                        transform: translateY(-50%);
                        transition: transform 0.3s ease;
                        font-size: 24px;
                    }

                    .accordion-content {
                        padding: 15px;
                        display: none;
                        background-color: #fff;
                        color: #333;
                        transition: max-height 0.3s ease, padding 0.3s ease;
                        overflow: hidden;
                    }

                    .accordion-item.active .accordion-title::after {
                        content: "-";
                        transform: translateY(-50%);
                        font-size: 24px;
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
                                const title = item.querySelector(".accordion-title");
                                title.addEventListener("click", function () {
                                    if (!item.classList.contains("active")) {
                                        closeAllAccordions();
                                        item.classList.add("active");
                                    } else {
                                        item.classList.remove("active");
                                    }
                                });
                            });
                            items[0].classList.add("active");
                        });
                        function closeAllAccordions() {
                            const items = document.querySelectorAll(".accordion-item");
                            items.forEach((item) => {
                                item.classList.remove("active");
                            });
                        }
                </script>
                <div class="accordion">
                    <?php foreach ($faq_items as $faq_item) {
                        ?>
                        <div class="accordion-item">
                            <h3 class="accordion-title"><?php echo esc_html($faq_item['title']); ?></h3>
                            <div class="accordion-content">
                                <p>
                                    <?php
                                    $slashless = htmlspecialchars_decode(esc_html(wp_unslash($faq_item['description'])));
                                    $description = wp_unslash(wpautop(wp_kses_post($slashless)));
                                    echo $description;
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * venue category Faq Items
         */

         public static function display_venue_category_FAQ() {
            ob_start();
            $term_id = get_queried_object_id();
            $venue_faq_items = get_term_meta($term_id, 'venue_faq_items', true);
            if (!empty($venue_faq_items)) {
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
                        content: "+";
                        position: absolute;
                        top: 50%;
                        right: 15px;
                        transform: translateY(-50%);
                        transition: transform 0.3s ease;
                        font-size: 24px;
                    }

                    .accordion-content {
                        padding: 15px;
                        display: none;
                        background-color: #fff;
                        color: #333;
                        transition: max-height 0.3s ease, padding 0.3s ease;
                        overflow: hidden;
                    }

                    .accordion-item.active .accordion-title::after {
                        content: "-";
                        transform: translateY(-50%);
                        font-size: 24px;
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
                                const title = item.querySelector(".accordion-title");
                                title.addEventListener("click", function () {
                                    if (!item.classList.contains("active")) {
                                        closeAllAccordions();
                                        item.classList.add("active");
                                    } else {
                                        item.classList.remove("active");
                                    }
                                });
                            });
                            items[0].classList.add("active");
                        });
                        function closeAllAccordions() {
                            const items = document.querySelectorAll(".accordion-item");
                            items.forEach((item) => {
                                item.classList.remove("active");
                            });
                        }
                </script>
                <div class="accordion">
                    <?php foreach ($venue_faq_items as $venue_faq_item) {
                        ?>
                        <div class="accordion-item">
                            <h3 class="accordion-title"><?php echo esc_html($venue_faq_item['title']); ?></h3>
                            <div class="accordion-content">
                                <p>
                                    <?php
                                    $slashless = htmlspecialchars_decode(esc_html(wp_unslash($venue_faq_item['description'])));
                                    $description = wp_unslash(wpautop(wp_kses_post($slashless)));
                                    echo $description;
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display Overview field in frontend supplier category page
         */
        public static function display_supplier_category_overview() {
            ob_start();
            $term_id = get_queried_object_id();
            $overview = get_term_meta($term_id, 'overview', true);
            $Overview_text_heading = get_term_meta($term_id, 'Overview_text', true);
            if (!empty($overview)) {
                ?>
                <style>
                    .overview {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    }

                    .overview-header {
                    background-color: #f5f5f5;
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #ddd;
                    }

                    .overview-header:hover {
                    background-color: #e0e0e0;
                    }

                    .overview-heading {
                    margin: 0;
                    }

                    .overview-content {
                    display: none;
                    padding: 10px;
                    }

                    .overview.active .overview-content {
                    display: block;
                    }
                    .overview-text-heading p{
                        color: #808254;
                        font-family: "PP Editorial New", Sans-serif;
                        font-size: 50px;
                        font-weight: 300;
                        line-height: 54px;
                        margin-bottom: 1.0em;
                    }
                </style>
                <div class="overview overview-text">
                <div class="overview-header overview-text-header">
                    <h2 class="overview-heading overview-text-heading"><?php echo  wpautop(wp_kses_post($Overview_text_heading)); ?></h2>
                </div>
                <div class="overview-header">
                    <h2 class="overview-heading"><?php echo wpautop(wp_kses_post($overview)); ?></h2>
                </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * venue category overview text heading
         */
        public static function display_venue_category_overview() {
            ob_start();
            $term_id = get_queried_object_id();
            $venue_category_overview = get_term_meta($term_id, 'venue_category_overview', true);
            $Venue_Overview_text_heading = get_term_meta($term_id, 'venue_Overview_text', true);
            if (!empty($venue_category_overview)) {
                ?>
                <style>
                    .overview {
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    }

                    .overview-header {
                    background-color: #f5f5f5;
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #ddd;
                    }

                    .overview-header:hover {
                    background-color: #e0e0e0;
                    }

                    .overview-heading {
                    margin: 0;
                    }

                    .overview-content {
                    display: none;
                    padding: 10px;
                    }

                    .overview.active .overview-content {
                    display: block;
                    }
                    .overview-text-heading p{
                        color: #808254;
                        font-family: "PP Editorial New", Sans-serif;
                        font-size: 50px;
                        font-weight: 300;
                        line-height: 54px;
                        margin-bottom: 1.0em;
                    }
                </style>
                <div class="overview overview-text venue_overview-text">
                <div class="overview-header  overview-text-header venue_overview-header">
                    <h2 class="overview-heading overview-text-heading venue_overview-text-heading"><?php echo  wp_kses_post($Venue_Overview_text_heading); ?></h2>
                </div>
                <div class="overview-header venue_overview-header">
                    <p class="overview-heading venue_overview-heading"><?php echo wpautop(wp_kses_post($venue_category_overview)); ?></p>
                </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display hero image vendor field in frontend supplier category page
         */
        public static function display_supplier_category_hero_image_vendor(){
            ob_start();
            $term_id = get_queried_object_id();
            $hero_image_vendor_id = get_term_meta($term_id, 'hero_image_vendor', true);
            if (!empty($hero_image_vendor_id)) {
                $supplier_post = get_post($hero_image_vendor_id);
                if ($supplier_post) {
                    $url = get_permalink($supplier_post);
                    $title = $supplier_post->post_title;
                    ?>
                    <div class="hero_image_vendor">
                        <div class="hero_image_vendor-title">
                            <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($title); ?></a></p>
                        </div>
                    </div>
                    <?php
                }
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display hero image vendor field in frontend venue category page
         */
        public static function display_venue_category_hero_image_vendor(){
            ob_start();
            $term_id = get_queried_object_id();
            $venue_hero_image_vendor_id = get_term_meta($term_id, 'hero_image_vendor_venue_category', true);
            if (!empty($venue_hero_image_vendor_id)) {
                $venue_post = get_post($venue_hero_image_vendor_id);
                if ($venue_post) {
                    $url = get_permalink($venue_post);
                    $title = $venue_post->post_title;
                    ?>
                    <div class="hero_image_vendor">
                        <div class="hero_image_vendor-title">
                            <p class="hero_image_vendor-heading"><a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($title); ?></a></p>
                        </div>
                    </div>
                    <?php
                }
            }
            return ob_get_clean();
        }

        /**
         *  shortcode to display hero image banner image field in frontend supplier category page
         */
        public static function display_vendor_proile_image_for_banner_hero_image(){
            ob_start();
            $term_id = get_queried_object_id();
            $image_vendor_profile_id = get_term_meta($term_id, 'hero_image_vendor', true);
            if (!empty($image_vendor_profile_id)) {
                $vendor_profile_image = get_post($image_vendor_profile_id);
                if ($vendor_profile_image) {
                    $title = $vendor_profile_image->post_title;
                    $image = get_the_post_thumbnail_url($vendor_profile_image, 'full'); 
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

         /**
         *  shortcode to display hero image banner image field in frontend supplier category page
         */
        public static function display_venue_proile_image_for_banner_hero_image(){
            ob_start();
            $term_id = get_queried_object_id();
            
            $venue_image_profile_id = get_term_meta($term_id, 'hero_image_vendor_venue_category', true);
            if (!empty($venue_image_profile_id)) {
                $venue_profile_image = get_post($venue_image_profile_id);
                if ($venue_profile_image) {
                    $title = $venue_profile_image->post_title;
                    $image = get_the_post_thumbnail_url($venue_profile_image, 'full'); 
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

        /**
         * shortcode to display discription field in frontend supplier category page
         */
        public static function display_supplier_category_description(){
            ob_start();
            $term_id = get_queried_object_id();
            $description = get_term_meta($term_id, 'discription', true);
            if (!empty($description)) {
                ?>
               <div class="description">
                <div class="description-header">
                    <h2 class="description-heading"><?php echo wpautop(wp_kses_post($description)); ?></h2>
                </div>
                </div>
                <?php
            } else {
            }
            return ob_get_clean();
        }
        /**
         * shortcode to display description field in frontend venue category page
         */

         public static function display_venue_category_description(){
            ob_start();
            $term_id = get_queried_object_id();
            $venue_category_discription = get_term_meta($term_id, 'venue_category_discription', true);
            // echo '<pre>';
            // print_r($venue_category_discription);
            // echo '</pre>';
            if (!empty($venue_category_discription)) {
                ?>
               <div class="description">
                <div class="description-header">
                    <p class="description-heading"><?php echo wpautop(wp_kses_post($venue_category_discription)); ?></p>
                </div>
                </div>
                <?php
            } else {
            }
            return ob_get_clean();
        }
        /**
         * shortcode to display WOW Pklanner field in frontend supplier category page
         */
        public static function display_supplier_category_wow_planner(){
            ob_start();
            $term_id = get_queried_object_id();
            $wow_planner = get_term_meta($term_id, 'wow_planner', true);
            if (!empty($wow_planner)) {
                ?>
               <div class="wow_planner">
                <div class="wow_planner-header">
                    <p class="wow_planner-heading"><?php echo wpautop(wp_kses_post($wow_planner)); ?></p>
                </div>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        /**
         * shortcode to display supplier category corausal
         */
        public static function fws_supplier_category_corausal() {
            ob_start();
            global $wpdb;
             $category_slug_id = get_queried_object_id();
            $args = array(
                'post_type' => 'gd_suppliers', 
                'tax_query' => array(
                    array(
                        'taxonomy' => 'gd_supplierscategory', 
                        'field'    => 'term_id', 
                        'terms'    => $category_slug_id, 
                    ),
                ),
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                ?>
                <div class="region-posts-container">
                    <div class="inner-box">
                        <?php
                        while ($query->have_posts()) :
                            $query->the_post(); 
                            $post_id = get_the_ID();
                            $permalink = get_permalink($post_id);
                            $title = get_the_title();
                            $image = get_the_post_thumbnail_url($post_id, 'full'); 
                            ?>
                            <div id="region-post-<?php echo $post_id; ?>" class="slide-item">
                                <div class="item-top">
                                    <div class="item-post-thumbnail">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
                                    </div>
                                </div>
                                <div class="item-bottom">
                                    <div class="bottom item-left">
                                        <span class="item-title-link">
                                            <a href="<?php echo $permalink ?>"><?php echo $title; ?></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                </div>
                <style>
                   .elementor-element.elementor-element-7a3ef2e.elementor-widget.elementor-widget-shortcode {
                        display: none;
                    }
                </style>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.js"></script>
                <script>
                    jQuery(document).ready(function ($) {
                        $('.region-posts-container .inner-box').slick({
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            dots: true,
                            speed: 300,
                            arrows: true,
                            responsive: [{
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }]
                        });
                    });
                </script>
                <?php
            else :
            endif;
            return ob_get_clean();
        }

        /**
         * shortcode to display posts region wise on singel location page
         */
        public static function fws_location_post_listing_callback() {
            ob_start();
            global $wp_query, $wpdb;
           
            if (!geodir_is_page('location')) {
                return;
            }
            $page_type = '';
            if (isset($wp_query->query_vars['region'])) {
                $page_type = 'region';
                $region = $wp_query->query_vars['region'];
            } elseif (isset($wp_query->query_vars['place_of_interest'])) {
                $page_type = 'place_of_interest';
                $poi = $wp_query->query_vars['place_of_interest'];
            } elseif (isset($wp_query->query_vars['city'])) {
                $page_type = 'city';
                $city = $wp_query->query_vars['city'];
            }
            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'numberposts'    => 10,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            if ($page_type === 'region') {
                $args['meta_query'] = array(
                    array(
                        'key'     => '_post_geodir_region',
                        'value'   => $region,
                        'compare' => '=',
                    )
                );
            } elseif ($page_type === 'place_of_interest') {
                $args['meta_query'] = array(
                    array(
                        'key'     => '_post_geodir_Pois',
                        'value'   => $poi,
                        'compare' => '=',
                    )
                );
            } elseif ($page_type === 'city') {
                $args['meta_query'] = array(
                    array(
                        'key'     => '_post_geodir_city',
                        'value'   => $city,
                        'compare' => '=',
                    )
                );
            }
            $posts = get_posts($args);
            if (!empty($posts)) :
                ?>
                <div class="region-posts-container">
                    <div class="inner-box">
                        <?php
                        foreach ($posts as $p) :
                            $post_id = $p->ID;
                            $permalink = get_permalink($post_id);
                            $title = get_the_title($post_id);
                            $image = get_the_post_thumbnail($post_id);
                            ?>
                            <div id="region-post-<?php echo $post_id; ?>" class="slide-item">
                                <div class="item-top">
                                    <div class="item-post-thumbnail">
                                        <?php echo $image; ?>
                                    </div>
                                </div>
                                <div class="item-bottom">
                                    <div class="bottom item-left">
                                        <span class="item-title-link">
                                            <a href="<?php echo $permalink ?>"><?php echo $title; ?></a>
                                        </span>
                                    </div>
                                    <div class="bottom item-right">
                                        <span class="item-read-time">
                                            <a href="<?php echo $permalink ?>">5 min read</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        $('.region-posts-container .inner-box').slick({
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            dots: true,
                            speed: 300,
                            arrows: true,
                            responsive: [{
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }]
                        });
                    });
                </script>
            <?php
            else :
            endif;

            return ob_get_clean();
        }

        /**
         * Add Meta Box for real-wedding-blog
         */
        public static function fws_geodir_register_meta_box_gd_real_weding_subheading() {
            add_meta_box('gd_rwedding_blogs_meta_box_sub_heading', 'Sub Heading Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_sub_heading' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_sub_heading($post) {
            global $wpdb, $post;
            $sub_heading = get_post_meta($post->ID, 'real_wedding_blogs_sub_heading', true);
            ?>
            <style>
                .real-wedding-meta-box {
                    margin-bottom: 20px;
                }

                .form-label {
                    display: block;
                    margin-bottom: 5px;
                }

                input[type="text"] {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                input[type="text"]:focus {
                    outline: none;
                    border-color: #007bff;
                    box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);
                }
                .real-wedding-sub-heading {
                    margin-bottom: 10px;
                    font-size: 18px;
                    font-weight: bold;
                }
            </style>
            <div class="real-wedding-meta-box">
                <label for="real_wedding_sub_heading" class="form-label"><?php echo __('Sub Heading Text'); ?></label>
                <input type="text" id="real_wedding_blogs_sub_heading" name="real_wedding_blogs_sub_heading" value="<?php echo esc_attr($sub_heading); ?>" />
            </div>
            <?php
        }
        
        /**
         * save meta box value for Best of blogs Sub Heading field
         */
        public static function fws_geodir_save_post_meta_gd_real_wedding_sub_heading($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['real_wedding_blogs_sub_heading'])) {
                    update_post_meta($post_id, 'real_wedding_blogs_sub_heading', sanitize_text_field($_POST['real_wedding_blogs_sub_heading']));
                }
            }
        }

        /**
         * shortcode to display Sub heading in real wedding blogs page frontnend
         */
        public static function fws_geodir_display_real_wedding_sub_heading_shortcode() {
            global $post;
            $post_id = $post->ID;
            $sub_heading = get_post_meta($post_id, 'real_wedding_blogs_sub_heading', true);
            return '
            <style>
            .real-wedding-sub-heading .real_wedding_sub_head_title{
                color: #1E1E1E;
                font-family: "Rework Micro", Sans-serif;
                font-size: 16px;
                font-weight: 600;
                text-transform: uppercase;
            }
            </style>
            <div class="real-wedding-sub-heading"><h3 class="real_wedding_sub_head_title">' . esc_html($sub_heading) . '</h3></div>';
        }
       
        public static function fws_geodir_register_meta_box_gd_real_weding() {
            add_meta_box('gd_rwedding_blogs_meta_box', 'Supplier Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_blogs' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_blogs($post) {
            global $wpdb, $post;
            $heding_text = get_post_meta($post->ID, 'heding_field', true);
            ?>
            <style>
                #postbox-container-2 #normal-sortables div#geodir_post_info { 
                    display: none; 
                }
                div#gd_rwedding_blogs_meta_box label.form-label, div#gd_rwedding_blogs_meta_box_venue label.form-label {
                    display: block;
                    width: 100%;
                    margin: 10px 0;
                }
                div#gd_rwedding_blogs_meta_box input, div#gd_rwedding_blogs_meta_box_venue input {
                    display: block;
                    width: 100%;
                }
                div#gd_rwedding_blogs_meta_box ul#supplier-list_text li, div#gd_rwedding_blogs_meta_box_venue ul li {
                    display: grid;
                    grid-template-columns: auto 75px;
                    gap: 10px;
                }

                ul#supplier-list_text li select.regular-text, #gd_rwedding_blogs_meta_box_venue  #venue-list_text li select.regular-text {
                    width: 100%;
                    max-width: 100%;
                }
                .real-wedding-text {
                    margin-bottom: 20px;
                }
            </style>
            <div class="real-wedding-text">
                <label for="post-select-region" class="form-label"><?php echo __(' Supplier Heading Text'); ?></label>
                <input type="text" id="heding_field" name="heding_field" value="<?php echo esc_attr($heding_text); ?>" />
            </div>
        
            <div class="form-field" id="supplier-container-texonomy">
            <label for="post-select-region " class="form-label "><?php echo __('Supplier list'); ?></label>
                <label for="custom_field1"></label>
                <div>
                    <ul id="supplier-list_text">
                        <?php
                        $suppliers = get_posts(array(
                            'post_type' => 'gd_suppliers',
                            'posts_per_page' => -1,
                        ));
                        $selected_suppliers = get_post_meta($post->ID, 'supplier_name', true);
                        $selected_suppliers = is_array($selected_suppliers) ? $selected_suppliers : array($selected_suppliers);
                        foreach ($selected_suppliers as $selected_supplier) {
                            echo '<li>';
                            echo '<select name="supplier_name[]" class="regular-text">';
                            echo '<option value="">Select Supplier</option>';
                            foreach ($suppliers as $supplier) {
                                $supplier_id = $supplier->ID;
                                $selected = ($supplier_id == $selected_supplier) ? 'selected' : '';
                                echo '<option value="' . esc_attr($supplier_id) . '" ' . $selected . '>' . esc_html($supplier->post_title) . '</option>';
                            }
                            echo '</select>';
                            echo '<button type="button" class="remove-supplier button">REMOVE</button>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <button type="button" id="add-supplier-texonomy" class="button">ADD MORE</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var supplierContainer = document.getElementById('supplier-container-texonomy');
                    var addSupplierButton = document.getElementById('add-supplier-texonomy');
                    var suppliers = <?php echo json_encode($suppliers); ?>;
        
                    addSupplierButton.addEventListener('click', function () {
                        var newSupplierRow = document.createElement('li');
                        newSupplierRow.innerHTML = `
                            <select name="supplier_name[]" class="regular-text">
                                <option value="">Select Supplier</option>
                                ${suppliers.map(supplier => `
                                    <option value="${supplier.ID}">${supplier.post_title}</option>
                                `).join('')}
                            </select>
                            <button type="button" class="remove-supplier button">REMOVE</button>
                        `;
                        document.getElementById('supplier-list_text').appendChild(newSupplierRow);
                    });
                    supplierContainer.addEventListener('click', function (event) {
                        if (event.target.classList.contains('remove-supplier')) {
                            event.target.parentNode.remove();
                        }
                    });
                });
            </script>
            <?php
        }
        public static function fws_geodir_save_post_meta_gd_real_weding($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['heding_field'])) {
                    update_post_meta($post_id, 'heding_field', sanitize_text_field($_POST['heding_field']));
                }
        
                if (isset($_POST['supplier_name'])) {
                    $supplier_names = array_map('intval', $_POST['supplier_name']); 
                    
                  
                    if (!empty($supplier_names)) {
                        update_post_meta($post_id, 'supplier_name', $supplier_names);
                    } else {
                        
                        update_post_meta($post_id, 'supplier_name', array());
                    }
                } else {
                    
                    update_post_meta($post_id, 'supplier_name', array());
                }
            }
        }

        /**
         * add Best of blogs venue field 
         */
        public static function fws_geodir_register_meta_box_gd_real_weding_vanue() {
            add_meta_box('gd_rwedding_blogs_meta_box_venue', 'venue Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_blogs_venue' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_blogs_venue($post) {
            global $wpdb, $post;
            $venue_heding_text = get_post_meta($post->ID, 'venue_heding_field', true);
            ?>
            <div class="venue_real-wedding-text">
                <label for="venue_post-select-region" class="form-label"><?php echo __('Venue Heading Text'); ?></label>
                <input type="text" id="venue_heding_field" name="venue_heding_field" value="<?php echo esc_attr($venue_heding_text); ?>" />
            </div>
            <div class="form-field" id="venue-container-texonomy">
            <label for="venue_post-select-region " class="form-label "><?php echo __('Venue list'); ?></label>
                <label for="custom_field1"></label>
                <div>
                    <ul id="venue-list_text">
                        <?php
                        $venues = get_posts(array(
                            'post_type' => 'gd_place',
                            'posts_per_page' => -1,
                        ));
                        $selected_venues = get_post_meta($post->ID, 'venue_name', true);
                        $selected_venues = is_array($selected_venues) ? $selected_venues : array($selected_venues);
                        foreach ($selected_venues as $selected_venue) {
                            echo '<li>';
                            echo '<select name="venue_name[]" class="regular-text">';
                            echo '<option value="">Select Venue</option>';
                            foreach ($venues as $venue) {
                                $venue_id = $venue->ID;
                                $selected = ($venue_id == $selected_venue) ? 'selected' : '';
                                echo '<option value="' . esc_attr($venue_id) . '" ' . $selected . '>' . esc_html($venue->post_title) . '</option>';
                            }
                            echo '</select>';
                            echo '<button type="button" class="remove-venue button">REMOVE</button>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <button type="button" id="add-venue-texonomy" class="button">ADD MORE</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var venueContainer = document.getElementById('venue-container-texonomy');
                    var addvenueButton = document.getElementById('add-venue-texonomy');
                    var venues = <?php echo json_encode($venues); ?>;
        
                    addvenueButton.addEventListener('click', function () {
                        var newvenueRow = document.createElement('li');
                        newvenueRow.innerHTML = `
                            <select name="venue_name[]" class="regular-text">
                                <option value="">Select venue</option>
                                ${venues.map(venue => `
                                    <option value="${venue.ID}">${venue.post_title}</option>
                                `).join('')}
                            </select>
                            <button type="button" class="remove-venue button">REMOVE</button>
                        `;
                        document.getElementById('venue-list_text').appendChild(newvenueRow);
                    });
                    venueContainer.addEventListener('click', function (event) {
                        if (event.target.classList.contains('remove-venue')) {
                            event.target.parentNode.remove();
                        }
                    });
                });
            </script>
            <?php
        }

        /**
         * save meta box value for Best of blogs venue field
         */
        public static function fws_geodir_save_post_meta_gd_real_weding_venue($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['venue_heding_field'])) {
                    update_post_meta($post_id, 'venue_heding_field', sanitize_text_field($_POST['venue_heding_field']));
                }
        
                if (isset($_POST['venue_name'])) {
                    $venue_names = array_map('intval', $_POST['venue_name']); 
                    
                   
                    if (!empty($venue_names)) {
                        update_post_meta($post_id, 'venue_name', $venue_names);
                    } else {
                        
                        update_post_meta($post_id, 'venue_name', array());
                    }
                } else {
                   
                    update_post_meta($post_id, 'venue_name', array());
                }
            }
        }

        /**
         * add Best of blogs supplier categoryfield
         */
        public static function fws_geodir_register_meta_box_gd_real_weding_supplier_category() {
            add_meta_box('gd_rwedding_blogs_meta_box_supplier_category', 'Supplier Category Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_blogs_supplier_category' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_blogs_supplier_category($post) {
            global $wpdb, $post;
            $heding_text_supplier_category = get_post_meta($post->ID, 'heding_field_supplier_category', true);
            ?>
             <style>
                #postbox-container-2 #normal-sortables div#geodir_post_info { 
                    display: none; 
                }
                div#gd_rwedding_blogs_meta_box_supplier_category label.form-label {
                    display: block;
                    width: 100%;
                    margin: 10px 0;
                }
                div#gd_rwedding_blogs_meta_box_supplier_category input input {
                    display: block;
                    width: 100%;
                }
                div#gd_rwedding_blogs_meta_box_supplier_category ul#supplier-list-text-supplier-category li, div#gd_rwedding_blogs_meta_box_supplier_category ul li {
                    display: grid;
                    grid-template-columns: auto 75px;
                    gap: 10px;
                }

                ul#supplier-list-text-supplier-category li select.regular-text, #gd_rwedding_blogs_meta_box_supplier_category  li select.regular-text {
                    width: 100%;
                    max-width: 100%;
                }
                .real-wedding-text {
                    margin-bottom: 20px;
                }
            </style>
            <div class="real-wedding-text">
                <label for="post-select-region" class="form-label"><?php echo __(' Supplier Category Heading Text'); ?></label>
                <input type="text" id="heding_field_supplier_category" name="heding_field_supplier_category" value="<?php echo esc_attr($heding_text_supplier_category); ?>" />
            </div>
            <div class="form-field" id="supplier-container-supplier-category">
            <label for="post-select-region " class="form-label "><?php echo __('Supplier Category List'); ?></label>
                <label for="custom_field1"></label>
                <div>
                    <ul id="supplier-list-text-supplier-category">
                        <?php
                        $supplier_categories = get_terms(array(
                            'taxonomy' => 'gd_supplierscategory',
                            'hide_empty' => false, 
                        ));
        
                        $selected_categories = get_post_meta($post->ID, 'supplier_category', true);
                        $selected_categories = is_array($selected_categories) ? $selected_categories : array($selected_categories);
        
                        foreach ($selected_categories as $selected_category) {
                            echo '<li>';
                            echo '<select name="supplier_category[]" class="regular-text">';
                            echo '<option value="">Select Supplier Category</option>';
                            foreach ($supplier_categories as $category) {
                                $category_id = $category->term_id;
                                $selected = ($category_id == $selected_category) ? 'selected' : '';
                                echo '<option value="' . esc_attr($category_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                            }
                            echo '</select>';
                            echo '<button type="button" class="remove-supplier-category remove-supplier button">REMOVE</button>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <button type="button" id="add-supplier-supplier-category" class="button">ADD MORE</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var supplierContainer = document.getElementById('supplier-container-supplier-category');
                    var addSupplierButton = document.getElementById('add-supplier-supplier-category');
                    var suppliers = <?php echo json_encode($supplier_categories); ?>;
        
                    addSupplierButton.addEventListener('click', function () {
                        var newSupplierRow = document.createElement('li');
                        newSupplierRow.innerHTML = `
                        <select name="supplier_category[]" class="regular-text">
                            <option value="">Select Supplier Category</option>
                            <?php foreach ($supplier_categories as $category) : ?>
                                <?php
                                $category_id = $category->term_id;
                                $selected = ($category_id == $selected_category) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($category_id); ?>" <?php echo $selected; ?>><?php echo esc_html($category->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="remove-supplier-category remove-supplier button">REMOVE</button>
                        `;
                        document.getElementById('supplier-list-text-supplier-category').appendChild(newSupplierRow);
                    });
                    supplierContainer.addEventListener('click', function (event) {
                        if (event.target.classList.contains('remove-supplier-category')) {
                            event.target.parentNode.remove();
                        }
                    });
                });
            </script>
            <?php
        }
        /**
         * save meta box value for Best of blogs vsupplier category field
         */
        public static function fws_geodir_save_post_meta_gd_real_weding_supplier_category($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['heding_field_supplier_category'])) {
                    update_post_meta($post_id, 'heding_field_supplier_category', sanitize_text_field($_POST['heding_field_supplier_category']));
                }
        
                if (isset($_POST['supplier_category'])) {
                    $supplier_categorys = array_map('intval', $_POST['supplier_category']); 
                    
                   
                    if (!empty($supplier_categorys)) {
                        update_post_meta($post_id, 'supplier_category', $supplier_categorys);
                    } else {
                        
                        update_post_meta($post_id, 'supplier_category', array());
                    }
                } else {
                   
                    update_post_meta($post_id, 'supplier_category', array());
                }
            }
        }

        /**
         * add Best of blogs venue categoryfield
         */

        public static function fws_geodir_register_meta_box_gd_real_weding_venue_category() {
            add_meta_box('gd_rwedding_blogs_meta_box_venue_category', 'Venue Category Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_blogs_venue_category' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_blogs_venue_category($post) {
            global $wpdb, $post;
            $heding_text_venue_category = get_post_meta($post->ID, 'heding_field_venue_category', true);
            ?>
           <style>
                #postbox-container-2 #normal-sortables div#geodir_post_info { 
                    display: none; 
                }
                div#gd_rwedding_blogs_meta_box_venue_category label.form-label {
                    display: block;
                    width: 100%;
                    margin: 10px 0;
                }
                div#gd_rwedding_blogs_meta_box_venue_category input input {
                    display: block;
                    width: 100%;
                }
                div#gd_rwedding_blogs_meta_box_venue_category ul#venue-container-venue-category li, div#gd_rwedding_blogs_meta_box_venue_category ul li {
                    display: grid;
                    grid-template-columns: auto 75px;
                    gap: 10px;
                }

                ul#venue-container-venue-category li select.regular-text, #gd_rwedding_blogs_meta_box_venue_category li select.regular-text {
                    width: 100%;
                    max-width: 100%;
                }
                .real-wedding-text {
                    margin-bottom: 20px;
                }
            </style>
            <div class="real-wedding-text">
                <label for="post-select-region" class="form-label"><?php echo __(' Venue Category Heading Text'); ?></label>
                <input type="text" id="heding_field_venue_category" name="heding_field_venue_category" value="<?php echo esc_attr($heding_text_venue_category); ?>" />
            </div>
        
            <div class="form-field" id="venue-container-venue-category">
            <label for="post-select-region " class="form-label "><?php echo __('Venue Category List'); ?></label>
                <label for="custom_field1"></label>
                <div>
                    <ul id="supplier-list-text-venue-category">
                        <?php
                        $venue_categories = get_terms(array(
                            'taxonomy' => 'gd_placecategory',
                            'hide_empty' => false, 
                        ));
                        $selected_categories = get_post_meta($post->ID, 'venue_category', true);
                        $selected_categories = is_array($selected_categories) ? $selected_categories : array($selected_categories);
                        foreach ($selected_categories as $selected_category) {
                            echo '<li>';
                            echo '<select name="venue_category[]" class="regular-text">';
                            echo '<option value="">Select Venue Category</option>';
                            foreach ($venue_categories as $category) {
                                $category_id = $category->term_id;
                                $selected = ($category_id == $selected_category) ? 'selected' : '';
                                echo '<option value="' . esc_attr($category_id) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                            }
                            echo '</select>';
                            echo '<button type="button" class="remove-supplier remove-venue-category button">REMOVE</button>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <button type="button" id="add-venue-venue-category" class="button">ADD MORE</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var VenueContainer = document.getElementById('venue-container-venue-category');
                    var addvenueButton = document.getElementById('add-venue-venue-category');
                    var Venues = <?php echo json_encode($venue_categories); ?>;
        
                    addvenueButton.addEventListener('click', function () {
                        var newvenueRow = document.createElement('li');
                        newvenueRow.innerHTML = `
                        <select name="venue_category[]" class="regular-text">
                            <option value="">SelectVenue Category</option>
                            <?php foreach ($venue_categories as $category) : ?>
                                <?php
                                $category_id = $category->term_id;
                                $selected = ($category_id == $selected_category) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($category_id); ?>" <?php echo $selected; ?>><?php echo esc_html($category->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="remove-supplier remove-venue-category button">REMOVE</button>
                        `;
                        document.getElementById('supplier-list-text-venue-category').appendChild(newvenueRow);
                    });
                   VenueContainer.addEventListener('click', function (event) {
                        if (event.target.classList.contains('remove-venue-category')) {
                            event.target.parentNode.remove();
                        }
                    });
                });
            </script>
            <?php
        }

        /**
         * save meta box value for Best of blogs venue category field
         */
        public static function fws_geodir_save_post_meta_gd_real_weding_venue_category($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['heding_field_venue_category'])) {
                    update_post_meta($post_id, 'heding_field_venue_category', sanitize_text_field($_POST['heding_field_venue_category']));
                }
        
                if (isset($_POST['venue_category'])) {
                    $venue_categorys = array_map('intval', $_POST['venue_category']); 
                    
                   
                    if (!empty($venue_categorys)) {
                        update_post_meta($post_id, 'venue_category', $venue_categorys);
                    } else {
                        
                        update_post_meta($post_id, 'venue_category', array());
                    }
                } else {
                   
                    update_post_meta($post_id, 'venue_category', array());
                }
            }
        }

        /**
         * Add Location Detials
         */
        public static function fws_geodir_register_meta_box_gd_real_weding_location_details() {
            add_meta_box('gd_rwedding_blogs_meta_box_location_details', 'Location  Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback_gd_rwedding_blogs_location_details' ), 'gd_rwedding_blogs', 'normal','default'
            );
        }
        
        public static function fws_geodir_register_meta_box_callback_gd_rwedding_blogs_location_details($post) {
            global $wpdb;
            $wedding_region = get_post_meta($post->ID, 'wedding_region', true);
            $wedding_poi = get_post_meta($post->ID, 'wedding_poi', true);
            $wedding_city = get_post_meta($post->ID, 'wedding_city', true);
            ?>
            <style>
                #supplier-container-supplier-category .form-field p, .form-field select {
                    max-width: 100%;
                }
                #supplier-container-supplier-category span.select2-selection__clear {
                    display: none;
                }
                #supplier-container-supplier-category span.select2.select2-container.select2-container--default {
                    display: none;
                }
            </style>
            
            <div class="form-field" id="supplier-container-supplier-category">
                <label for="post-select-region" class="form-label"><?php echo __('Region'); ?></label>
                <div class="col-sm-10" id="fws-custom-region-section">
                    <?php
                    $regions = $wpdb->get_results("SELECT region FROM `".$wpdb->prefix."geodir_post_locations` WHERE region NOT LIKE '%-%' and place_of_interest='0' GROUP BY region ORDER BY location_id DESC");
                    ?>
                    <select style="width:100%;" class="custom-select aui-select2" name="wedding_region" id="select-custom-region-1" data-allow-clear="1" data-placeholder="Select Region…" option-ajaxchosen="false" data-select2-id="main_service_area" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <?php
                        if(!empty($regions) && is_array($regions)){
                            foreach($regions as $reg){
                                ?>
                                <option value="<?= $reg->region ?>" <?php selected($wedding_region, $reg->region); ?>><?= $reg->region ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        
            <div class="form-field" id="supplier-container-supplier-category">
                <label for="post-select-poi" class="form-label"><?php echo __('POI'); ?></label>
                <div class="col-sm-10" id="fws-custom-region-section">
                    <?php
                    $pois = $wpdb->get_results("SELECT region FROM `".$wpdb->prefix."geodir_post_locations` WHERE place_of_interest='1' GROUP BY region ORDER BY location_id DESC");
                    ?>
                    <select style="width:100%;" class="custom-select aui-select2" name="wedding_poi" id="select-custom-poi" data-allow-clear="1" data-placeholder="Select POI…" option-ajaxchosen="false" data-select2-id="main_service_area" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <?php
                        if(!empty($pois) && is_array($pois)){
                            foreach($pois as $poi){
                                ?>
                                <option value="<?= $poi->region ?>" <?php selected($wedding_poi, $poi->region); ?>><?= $poi->region ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        
            <div class="form-field" id="supplier-container-supplier-category">
                <label for="post-select-city" class="form-label"><?php echo __('City'); ?></label>
                <div class="col-sm-10" id="fws-custom-region-section">
                    <?php
                    $cities = $wpdb->get_results("SELECT city FROM `".$wpdb->prefix."geodir_post_locations`  GROUP BY city ORDER BY location_id DESC");
                    ?>
                    <select style="width:100%;" class="custom-select aui-select2" name="wedding_city" id="select-custom-real-wedding-city" data-allow-clear="1" data-placeholder="Select City…" option-ajaxchosen="false" data-select2-id="main_service_area" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <?php
                        if(!empty($cities) && is_array($cities)){
                            foreach($cities as $city){
                                ?>
                                <option value="<?= $city->city ?>" <?php selected($wedding_city, $city->city); ?>><?= $city->city ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {
                    setTimeout(function() {
                        jQuery("#select-custom-real-wedding-city").removeClass("select2-hidden-accessible");
                    }, 3000); 
                });
            </script>
            <?php
        }

        /**
         * save meta box value for Best of blogs location detials field
         */
        public static function fws_geodir_save_post_meta_gd_real_weding_location_details($post_id, $post) {
            if (isset($_POST['post_type']) && 'gd_rwedding_blogs' == $_POST['post_type']) {
                if (isset($_POST['wedding_region'])) {
                    update_post_meta($post_id, 'wedding_region', sanitize_text_field($_POST['wedding_region']));
                } else {
                  
                    update_post_meta($post_id, 'wedding_region', '');
                }
                
                if (isset($_POST['wedding_poi'])) {
                    update_post_meta($post_id, 'wedding_poi', sanitize_text_field($_POST['wedding_poi']));
                } else {
                    
                    update_post_meta($post_id, 'wedding_poi', '');
                }
                
                if (isset($_POST['wedding_city'])) {
                    update_post_meta($post_id, 'wedding_city', sanitize_text_field($_POST['wedding_city']));
                } else {
                   
                    update_post_meta($post_id, 'wedding_city', '');
                }
            }
        }
        
        /**
         * function to register a metabox in post type post 
         */
        public static function fws_geodir_register_meta_box(){
            add_meta_box( 'post-region-id', 'Additional Information', array( __CLASS__, 'fws_geodir_register_meta_box_callback' ), 'post', 'normal', 'high' );
        }
        public static function fws_geodir_save_post_meta( $post_id, $post ){
            if( isset( $_POST['_post_geodir_region'] ) && ! empty( $_POST['_post_geodir_region'] ) ){
                update_post_meta( $post_id, '_post_geodir_region', $_POST['_post_geodir_region'] );
            } else {
                delete_post_meta( $post_id, '_post_geodir_region' );
            }
        }
        public static function fws_geodir_register_meta_box_callback( $post ){
            $post_id = $post->ID;
            $postRegion = get_post_meta( $post_id, '_post_geodir_region', true );
            global $wpdb;
            $regions =  $wpdb->get_results("SELECT region,region_slug FROM `".$wpdb->prefix."geodir_post_locations` WHERE region NOT LIKE '%-%' and place_of_interest='0' GROUP BY region, region_slug");
            ?>
            <style>
                .regions-container label.form-label {
                    width: 100%;
                    display: block;
                    margin: 5px 0;
                    font-size: 1.2rem;
                    font-weight: 600;
                }
                .regions-container select.form-control{
                    display: block;
                    width: 100%;
                    padding: 10px;
                }
                .acf-postbox.seamless {
                    
                    display: none !important;
                }
                div#commentsdiv {
                    display: block !important;
                }
            </style>
            <div class="regions-container">
                <div class="inner-box">
                    <div class="form-group">
                        <label for="post-select-region" class="form-label"><?php echo __('Select Region'); ?></label>
                        <select id="post-select-region" class="form-control" name="_post_geodir_region">
                            <option value=""><?php echo __('Select a region'); ?></option>
                            <?php
                                foreach ($regions as $region) {
                                    ?>
                                    <?php
                                        $sl = ! empty( $postRegion ) && $postRegion == $region->region_slug ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $region->region_slug; ?>" <?php echo $sl; ?> ><?php echo $region->region; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * add select city field in post type post 
         */
        public static function fws_geodir_city_meta_box(){
            add_meta_box( 'post-city-id', 'Additional Information', array( __CLASS__, 'fws_geodir_city_meta_box_callback' ), 'post', 'normal', 'high' );
        }

         /**
         * save select city field in post type post 
         */
        public static function fws_geodir_save_city_post_meta( $post_id, $post ){
            if( isset( $_POST['_post_geodir_city'] ) && is_array( $_POST['_post_geodir_city'] ) ){
                update_post_meta( $post_id, '_post_geodir_city', serialize( $_POST['_post_geodir_city'] ) );
            } else {
                delete_post_meta( $post_id, '_post_geodir_city' );
            }
        }

        /**
         * enque script
         */
        public static function fws_geodir_city_enqueue_admin_scripts( $hook ){
            global $post;
            if ( $hook == 'post.php' && isset( $post ) && $post->post_type == 'post' ) {
                wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
                wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
                wp_enqueue_style( 'select2-bootstrap4', 'https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), null, true );
                wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), null, true );
                wp_enqueue_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array('jquery'), null, true );
            }
        }

        /**
         * call back function
         */
        public static function fws_geodir_city_meta_box_callback( $post ){
            $post_id = $post->ID;
            $postCity = get_post_meta( $post_id, '_post_geodir_city', true );
            if ( $postCity ) {
                $postCitysArray = unserialize( $postCity );
            } else {
                $postCitysArray = array();
            }
            global $wpdb;
            $Citys =  $wpdb->get_results("SELECT city,city_slug FROM `".$wpdb->prefix."geodir_post_locations` GROUP BY city");

           ?>
             <style>
                .city-wrapper {
                max-width: 100%;
                margin: auto;
                }

                select {
                width: 100%;
                min-height: 100px;
                border-radius: 3px;
                border: 1px solid #444;
                padding: 10px;
                color: #444444;
                font-size: 14px;
                }
                .select2-container {
                    display: block;
                }
                .form-label {
                    width: 100%;
                    display: block;
                    margin: 5px 0;
                    font-size: 1.2rem;
                    font-weight: 600;
                }
            </style>
            <div class="city-wrapper">
                <label for="post-select-city" class="form-label"><?php echo __('Select City(s)'); ?></label>
                <select multiple placeholder="Choose cities" name="_post_geodir_city[]" data-allow-clear="1">
                    <option value=""><?php echo __('Select a city'); ?></option>
                    <?php foreach ($Citys as $City) { ?>
                        <?php $selected = in_array($City->city_slug, $postCitysArray) ? 'selected' : ''; ?>
                        <option value="<?php echo $City->city_slug; ?>" <?php echo $selected; ?>><?php echo $City->city; ?></option>
                    <?php } ?>
                </select>
            </div>
            <script>
                jQuery(function () {
                jQuery('select').each(function () {
                    jQuery(this).select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: jQuery(this).attr('placeholder'),
                allowClear: Boolean(jQuery(this).data('allow-clear')),
                });
            });
            });
            </script>
        <?php
        }

        /**
        * add Sub Heading field in post type post 
        */
        public static function fws_geodir_post_sub_heading_box(){
            add_meta_box( 'post-sub-heading-id', 'Sub Heading Information', array( __CLASS__, 'fws_geodir_post_sub_heading_box_callback' ), 'post', 'normal', 'high' );
        }
        
        public static function fws_geodir_post_sub_heading_box_callback($post) {
            global $wpdb;
            $post_sub_heading = get_post_meta($post->ID, '_post_sub_heading', true);
            ?>
            <style>
                .post-meta-box {
                    margin-bottom: 20px;
                }
        
                .form-label {
                    display: block;
                    margin-bottom: 5px;
                }
        
                input[type="text"] {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }
        
                input[type="text"]:focus {
                    outline: none;
                    border-color: #007bff;
                    box-shadow: 0 0 0 0.1rem rgba(0,123,255,.25);
                }
        
            </style>
            <div class="post-meta-box">
                <label for="_post_sub_heading" class="form-label"><?php echo __('Sub Heading Text'); ?></label>
                <input type="text" id="_post_sub_heading" name="_post_sub_heading" value="<?php echo esc_attr($post_sub_heading); ?>" />
                <?php wp_nonce_field(basename(__FILE__), 'fws_geodir_sub_heading_nonce'); ?>
            </div>
            <?php
        }
        
         /**
        * save Sub Heading field in post type post 
        */
        public static function fws_geodir_save_sub_heading_post_meta($post_id, $post) {
            if (!isset($_POST['fws_geodir_sub_heading_nonce']) || !wp_verify_nonce($_POST['fws_geodir_sub_heading_nonce'], basename(__FILE__))) {
                return $post_id;
            }
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            if (isset($_POST['_post_sub_heading'])) {
                update_post_meta($post_id, '_post_sub_heading', sanitize_text_field($_POST['_post_sub_heading']));
            }
        }
        
         /**
        * shortcode to display Sub Heading field in post type post 
        */
        public static function display_post_sub_heading_shortcode() {
            global $post;
            $post_id = $post->ID;
            $sub_heading = get_post_meta($post_id, '_post_sub_heading', true);
            return '
            <style>
            .post_sub_heading .sub_head_title{
                color: #1E1E1E;
                font-family: "Rework Micro", Sans-serif;
                font-size: 16px;
                font-weight: 600;
                text-transform: uppercase;
            }
            </style>
            <div class="post_sub_heading">
            <h3 class="sub_head_title">' . esc_html($sub_heading) . '</h3></div>';
        }
        

        /**
         * add select poi field in metabox of post type post
         */
        public static function fws_geodir_poi_meta_box(){
            add_meta_box( 'post-poi-id', 'Additional Information', array( __CLASS__, 'fws_geodir_poi_meta_box_callback' ), 'post', 'normal', 'high' );
        }

         /**
         * save select poi field  of post type post
         */
        public static function fws_geodir_save_poi_post_meta( $post_id, $post ){
            if( isset( $_POST['_post_geodir_Pois'] ) && is_array( $_POST['_post_geodir_Pois'] ) ){
                update_post_meta( $post_id, '_post_geodir_Pois', serialize( $_POST['_post_geodir_Pois'] ) );
            } else {
                delete_post_meta( $post_id, '_post_geodir_Pois' );
            }
        }

         /**
         * callback function select poi field in metabox of post type post
         */
        public static function fws_geodir_poi_meta_box_callback($post){
            $post_id = $post->ID;
            $postpois = get_post_meta( $post_id, '_post_geodir_Pois', true );
            if ( $postpois ) {
                $postPoisArray = unserialize( $postpois );

            } else {
                $postPoisArray = array();
            }
            global $wpdb;
            $pois = $wpdb->get_results("SELECT region, region_slug FROM `".$wpdb->prefix."geodir_post_locations` WHERE place_of_interest='1' GROUP BY region, region_slug");
           ?>
            <style>
                .wrapper {
                max-width: 100%;
                margin: auto;
                }

                select {
                width: 100%;
                min-height: 100px;
                border-radius: 3px;
                border: 1px solid #444;
                padding: 10px;
                color: #444444;
                font-size: 14px;
                }
                .select2-container {
                    display: block;
                }
                .form-label {
                    width: 100%;
                    display: block;
                    margin: 5px 0;
                    font-size: 1.2rem;
                    font-weight: 600;
                }
            </style>
            <div class="wrapper">
                <label for="post-select-poi" class="form-label"><?php echo __('Select Poi(s)'); ?></label>
                <select multiple placeholder="Choose Pois" name="_post_geodir_Pois[]" data-allow-clear="1" >
                <option value=""><?php echo __('Select a poi'); ?></option>
                <?php foreach ($pois as $poi) { ?>
                    <?php $selected = in_array($poi->region_slug, $postPoisArray) ? 'selected' : ''; ?>
                    <option value="<?php echo $poi->region_slug; ?>" <?php echo $selected; ?>><?php echo $poi->region; ?></option>
                    <?php 
                    } ?>
                </select>
            </div>
        <?php
        }
        
        /**
         * save package and supplier services of post type post
         */
        public static function fws_supplier_listing_submit_cb( $post_id, $post ){
            global $wpdb;
            if ( wp_is_post_revision( $post_id ) ) {
                return;
            }
            if ( 'gd_suppliers' !== $post->post_type ) {
                return;
            }
            $tag_array          =   array();
            $packegs_setting    =   (isset($_POST['packages']) && is_array($_POST['packages'])) ? $_POST['packages'] : [];
            $supplier_services           =   (isset($_POST['supplier_services']) && is_array($_POST['supplier_services'])) ? $_POST['supplier_services'] : [];
            update_post_meta($post_id, 'avlabs_supp_packages', $packegs_setting);
            update_post_meta($post_id, 'supplier_services', $supplier_services);
        }

        /**
         * add custom user role 
         */
        public static function fws_custom_user_roles(){
            global $wp_roles;
            if ( ! isset( $wp_roles ) ){
                $wp_roles = new WP_Roles();
            }
            $service_rep_caps = array(
                'read'  => true,
            );
            add_role('venue', __('Venue'), $service_rep_caps);
            add_role('supplier', __('Supplier'), $service_rep_caps);
            add_role('user', __('User'), $service_rep_caps);
        }

        /**
         * adding custom field in user register form
         */

         public static function fws_add_user_register_field($args){
            global $wpdb;
            $user_id = wp_get_current_user();
            $user_type = isset($_GET['user']) ? $_GET['user'] : '';
            $role       = (isset($_REQUEST['role']) && !empty($_REQUEST['role'])) ? $_REQUEST['role'] : '';
            $package_id = (isset($_REQUEST['package_id']) && !empty($_REQUEST['package_id'])) ? $_REQUEST['package_id'] : '';

            if( $args == 'register' && $user_type == 'venue' || $role == 'supplier'  || $role == 'venue'){
                ?>
                
                    <?php
                    if(!empty($package_id)){
                        $package_data = $wpdb->get_row("SELECT name FROM `".$wpdb->prefix."geodir_price` WHERE id='$package_id'");
                        if(!empty($package_data)){
                            $itemData = $wpdb->get_row("SELECT meta_value FROM `".$wpdb->prefix."geodir_pricemeta` WHERE package_id='$package_id' AND meta_key='invoicing_product_id'");
                            if(!empty($itemData)){
                                ?>
                                <style>
                            form.uwp-registration-form.uwp_form .form-group {
                                display: none;
                            }

                            form.uwp-registration-form.uwp_form .form-group[data-argument="user_role"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="full_name"]{
                                display: none;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="email_address"]{
                                display: none;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="phone_number"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="bussiness_name"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="website_url"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="address"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="fws_category"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="username"]{
                                display: none;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="password"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="confirm_password"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="first_name"]{
                                display: block;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="last_name"]{
                                display: none;
                            }
                            form.uwp-registration-form.uwp_form .form-group[data-argument="email"]{
                                display: block;
                            }
                            .form-group.text-center.mb-0.p-0 {
                            display: none;
                            }
                            .uwp-footer-link {
                                display: none;
                            }
                        </style>
                       <script>
                            if (window.location.href === "https://frenchweddingstyle.com/register?role=venue&package_id=1") {
                                document.querySelector('.entry-title').innerText = "Claim Your Listing";
                                var bodyElement = document.querySelector('.page-template-default');
                                if (bodyElement) {
                                    bodyElement.classList.add('membership_data');
                                }
                            }
                            if (window.location.href === "https://frenchweddingstyle.com/register?role=venue&package_id=9") {
                                document.querySelector('.entry-title').innerText = "Claim Your Listing";                            
                                var bodyElement = document.querySelector('.page-template-default');
                                if (bodyElement) {
                                    bodyElement.classList.add('membership_data');
                                }
                            }
                            if (window.location.href === "https://frenchweddingstyle.com/register?role=supplier&package_id=1") {
                                document.querySelector('.entry-title').innerText = "Claim Your Listing";
                                var bodyElement = document.querySelector('.page-template-default');
                                if (bodyElement) {
                                    bodyElement.classList.add('membership_data');
                                }
                            }
                            if (window.location.href === "https://frenchweddingstyle.com/register?role=supplier&package_id=9") {
                                document.querySelector('.entry-title').innerText = "Claim Your Listing";                            
                                var bodyElement = document.querySelector('.page-template-default');
                                if (bodyElement) {
                                    bodyElement.classList.add('membership_data');
                                }
                            }
                              // Remove the old span element
                            jQuery('.input-group-append').remove();

                            // Add the new span element with the updated onclick function only to the password field
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
                            // jQuery(document).ready(function() {
                            //     jQuery('#last_name').attr('type', 'hidden');
                            //     jQuery('#username').attr('type', 'hidden');
                            // });

                        </script>
                         <div data-argument="full_name" class="form-group">
                            <label for="full_name" class="sr-only  ">Full Name <span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_full_name" name="full_name" placeholder="Full Name" id="full_name" value="<?php echo esc_attr(get_user_meta($user_id, 'full_name', true)); ?>">
                        </div>
                        <div data-argument="email_address" class="form-group">
                            <label for="email_address" class="sr-only  ">Email Address <span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_email_address" name="email_address" placeholder="Email Address" id="email_address" value="<?php echo esc_attr(get_user_meta($user_id, 'email_address', true)); ?>">
                        </div>
                        <div data-argument="phone_number" class="form-group">
                            <label for="phone_number" class="sr-only  ">Phone number<span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_phone_number" name="phone_number" placeholder="Phone Number" id="phone_number" maxlength="10"  value="<?php echo esc_attr(get_user_meta($user_id, 'phone_number', true)); ?>">
                        </div>
                        <div data-argument="bussiness_name" class="form-group">
                            <label for="bussiness_name" class="sr-only  ">Business Name<span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_bussiness_name" name="bussiness_name" id="bussiness_name" placeholder="Business Name" value="<?php echo esc_attr(get_user_meta($user_id, 'bussiness_name', true)); ?>">
                        </div>
                        <div data-argument="website_url" class="form-group">
                            <label for="website_url" class="sr-only  ">Website Url<span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_website_url" name="website_url" id="website_url" placeholder="Website Url" value="<?php echo esc_attr(get_user_meta($user_id, 'website_url', true)); ?>">
                        </div>
                        <div data-argument="address" class="form-group">
                            <label for="address" class="sr-only  ">Address<span class="text-danger"></span></label>
                            <input type="text" class="form-control registration_address" name="address" id="address" placeholder="Address" value="<?php echo esc_attr(get_user_meta($user_id, 'address', true)); ?>">
                            <input type="hidden" class="form-control" name="role" id="role" value="<?php echo esc_attr($role); ?>" placeholder="role">  
                        </div>
                        
                        <div data-argument="fws_category" class="form-group">
                        <label for="fws_category" class="sr-only  ">Select Category <span class="text-danger"></span></label>
                        </div>  
                        <div data-argument="user_role" class="form-group">
                            <?php
                                $package_name_value = ($package_data->name == "Silver") ? "Essential" : $package_data->name;
                            ?>
                            <input type="text" class="form-control" name="package_name" id="package_name" value="<?= $package_name_value ?>" readonly>
                            <input type="hidden" class="form-control" name="package_item_id" id="package_item_id" value="<?= $itemData->meta_value ?>">
                        </div>
                        <?php
                               
                            }
                        }
                    }
                    ?>
                </div>
                <?php
            }
        }
    

        /**
        * saving custom user register form fields value
        */
        
        public static function fws_save_user_fields_listing_id( $action, $data, $result, $user_id ){
            if($user_id){
                $user = get_user_by('id', $user_id);
                if(isset($data['fws_user_role']) && !empty($data['fws_user_role'])){
                    $role = $data['fws_user_role'];
                    $user->set_role($role);
                }
                if(isset($data['full_name']) && !empty($data['full_name'])){
                    update_user_meta($user_id, 'full_name', sanitize_text_field($data['full_name']));
                }
                if(isset($data['weding_date']) && !empty($data['weding_date'])){
                    update_user_meta($user_id, 'weding_date', sanitize_text_field($data['weding_date']));
                }
                if(isset($data['email_address']) && !empty($data['email_address'])){
                    update_user_meta($user_id, 'email_address', sanitize_text_field($data['email_address']));
                }
                if(isset($data['phone_number']) && !empty($data['phone_number'])){
                    update_user_meta($user_id, 'phone_number', sanitize_text_field($data['phone_number']));
                }
                if(isset($data['bussiness_name']) && !empty($data['bussiness_name'])){
                    update_user_meta($user_id, 'bussiness_name', sanitize_text_field($data['bussiness_name']));
                }
                if(isset($data['website_url']) && !empty($data['website_url'])){
                    update_user_meta($user_id, 'website_url', sanitize_text_field($data['website_url']));
                }
                if(isset($data['address']) && !empty($data['address'])){
                    update_user_meta($user_id, 'address', sanitize_text_field($data['address']));
                }
                if (isset($data['role']) && !empty($data['role'])) {
                    $role = sanitize_text_field($data['role']);
                    update_user_meta($user_id, 'role', $role);
                }
                if(isset($data['package_item_id']) && !empty($data['package_item_id'])){
                    update_user_meta($user_id, 'supplier_package_item_id', $data['package_item_id']);
                    self::fws_custom_registration_hook($user_id, $role);
                }
            }
        }
        
        /**
         * hiding admin bar
         */
        public static function fws_hide_wordpress_admin_bar( $hide ){

            if( is_user_logged_in() ){
                $user = wp_get_current_user();

                $roles = ( array ) $user->roles;
                $hide_for = [ 'venue', 'supplier', 'user' ];

                foreach( $hide_for as $hide_f ){
                    foreach( $roles as $role ){
                        if( $role == $hide_f ){
                            $hide = false;
                        }
                    }
                }
            }

            return $hide;
        }
        public static function fws_custom_registration_hook($user_id, $role){
            global $wpdb;  
                        
            $item_id = get_user_meta($user_id, 'supplier_package_item_id', true);
            $package_id = $item_id; 
            if (empty($package_id)) {
                $select_membership_item_id = $wpdb->get_row("SELECT meta_value FROM `".$wpdb->prefix."geodir_pricemeta` WHERE package_id='$package_id' AND meta_key='invoicing_product_id'");
                $item_id = $select_membership_item_id ? $select_membership_item_id->meta_value : 113421;
            }
            wp_set_auth_cookie($user_id);
            // $url = 'select-membership/?user_id=' . $user_id . '&item_id=' . $item_id . 'role=' .$role;
            $url = 'select-membership/?user_id=' . $user_id . '&item_id=' . $item_id . '&role=' . $role;
            wp_redirect(home_url('/' . $url));
            exit();
        }
        
        /**
         * LOCATION WISE LISTINGS
        */
        public static function fws_listings_location_wise_cb(){
            ob_start();
            global $wp_query, $wpdb;
            $country    =   isset($wp_query->query_vars['country'])     ?   $wp_query->query_vars['country']    :   '';
            $region     =   isset($wp_query->query_vars['region'])      ?   $wp_query->query_vars['region']     :   '';
            $city       =   isset($wp_query->query_vars['city'])        ?   $wp_query->query_vars['city']       :   '';
            ?>
            <style>
            .listing_filter_inner_fullSarch .custom-listings-loader-gif {
                text-align: center;
                margin-bottom: 25px;
            }
            .listing_filter_inner_fullSarch .custom-listings-loader-gif img.processing-loader-gif {
                width: 80px;
                height: 80px;
            }
            </style>
            <div class="locations-custom-content">
                <div class="full_width_container avlabs_fwc">
                    <div class="avlabs-mobile-search">
                        <input type="text" class="searchTerm" name="avlabs_search" id="search-term" placeholder="Search">
                        <button class="venue-searm-term-btn" id="venues-search-terms-button"><i class="fas fas fa-search" aria-hidden="true"></i></button>
                    </div>
                    <div class="avlabs-mobile-search-filters">
                        <button class="show-filters" id="venues-show-filters"><i class="fa-solid fa-filter"></i></button>
                    </div>
                    <div class="listing_filter">
                        <div class="geodir-search-container-s  geodir-advance-search-default-s" >
                            <div class="geodir-listing-search-s gd-search-bar-style-s" >
                                <input type="hidden" name="geodir_search" value="1">
                                <div class="geodir-search-s">
                                <div class="avlabs-search-s">
                                    <input type="number" name="price" id="price-no" placeholder="BUDGET">
                                </div>
                                <div class="avlabs-search-s">
                                    <input type="number" name="accomodation" id="accomodation-selector" placeholder="ACCOMODATION">
                                </div>
                                <div class="avlabs-search-s">
                                    <input type="number" name="guests" id="guests_number" placeholder="NO. OF GUESTS">
                                </div>
                                <button id="avlabs_custom_search_venue" class="geodir_submit_search" data-title="fas fa-search" aria-label="fas fa-search"><i class="fas fas fa-search" aria-hidden="true"></i><span class="sr-only">Search</span></button>
                                </div>
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="long" id="long">
                                <input type="hidden" name="city" id="city" value="<?= $city ?>">
                                <input type="hidden" name="region" id="region" value="<?= $region ?>">
                                <input type="hidden" name="country" id="country" value="<?= $country ?>">
                                <input name="sgeo_lat" class="sgeo_lat" type="hidden" value="">
                                <input name="sgeo_lon" class="sgeo_lon" type="hidden" value="">
                                <input id="avlabs_stype" type="hidden" value="gd_place">
                            </div>
                        </div>
                    </div>
                    <div class="step-two-fullSerch">
                        <div class="listing_filter_inner_fullSarch">
                            <div class="custom-listings-loader-gif">
                                <img class="processing-loader-gif" src="<?= site_url() ?>/wp-content/uploads/2024/02/loading-loading-forever.gif">
                            </div>
                            <div id="avlabs_grid_listing_fullSearch_featured" class="geodir-listings-feature listings-sections"></div>
                            <div id="avlabs_grid_listing_fullSearch" class="geodir-listings listings-sections"></div>
                            <div class="pagination_master"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            jQuery(document).ready(function(){
                avlabs_listing_ajax_callback ('1','<?= $city ?>','<?= $country ?>','<?= $region ?>','','gd_place','','','','','','');
                avlabs_listing_ajax_callback_featured ('1','<?= $city ?>','<?= $country ?>','<?= $region ?>','','gd_place','','','','','','','1');
            });

            jQuery('document').ready( function($){
                jQuery(document).on('click','.pagination_master .paginations div a',function(){
                    var attr            =   jQuery(this).attr('attr-page');
                    var stype           =   jQuery("#avlabs_stype").val();
                    var lat             =   jQuery("input[name='lat']").val();
                    var long            =   jQuery("input[name='long']").val();
                    var city            =   jQuery("input[name='city']").val();
                    var country         =   jQuery("input[name='country']").val();
                    var region          =   jQuery("input[name='region']").val();
                    var avlabs_search   =   jQuery("input[name='avlabs_search']").val();
                    var setting_type    =   jQuery("#setting_type").val();
                    var budget          =   jQuery("#price-no").val();
                    var accomodation    =   jQuery("#accomodation-selector").val();
                    var guests          =   jQuery("#guests_number").val();
                    var featured        =   1;
                    avlabs_listing_ajax_callback(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests);
                });

                jQuery(document).on('click', '#avlabs_custom_search_venue', function(){
                    jQuery('#avlabs_custom_search_venue').html('Please Wait...');
                    var attr            =   1;
                    var stype           =   jQuery("#avlabs_stype").val();
                    var lat             =   jQuery("input[name='lat']").val();
                    var long            =   jQuery("input[name='long']").val();
                    var city            =   jQuery("input[name='city']").val();
                    var country         =   jQuery("input[name='country']").val();
                    var region          =   jQuery("select[name='region']").val();
                    var avlabs_search   =   jQuery("input[name='avlabs_search']").val();
                    var setting_type    =   jQuery("#setting_type").val();
                    var budget          =   jQuery("#price-no").val();
                    var accomodation    =   jQuery("#accomodation-selector").val();
                    var guests          =   jQuery("#guests_number").val();
                    var featured        =   1;
                    avlabs_listing_ajax_callback(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests);
                    avlabs_listing_ajax_callback_featured(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests,featured);
                });

                /**
                 * MOBILE SEARCH
                 */
                jQuery(document).on('click', '#venues-search-terms-button', function(){
                    var attr            =   1;
                    var stype           =   jQuery("#avlabs_stype").val();
                    var lat             =   jQuery("input[name='lat']").val();
                    var long            =   jQuery("input[name='long']").val();
                    var city            =   jQuery("input[name='city']").val();
                    var country         =   jQuery("input[name='country']").val();
                    var region          =   jQuery("select[name='region']").val();
                    var avlabs_search   =   jQuery("input[name='avlabs_search']").val();
                    var setting_type    =   jQuery("#setting_type").val();
                    var budget          =   jQuery("#price-no").val();
                    var accomodation    =   jQuery("#accomodation-selector").val();
                    var guests          =   jQuery("#guests_number").val();
                    var featured        =   1;
                    avlabs_listing_ajax_callback(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests);
                    avlabs_listing_ajax_callback_featured(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests,featured);
                });
            });

            function avlabs_listing_ajax_callback (attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests){
                jQuery('#loading-main-fullSearch').show();
                jQuery(".listing_filter_inner_fullSarch").show();
                jQuery(".step-two-fullSerch").show();
                var map_canvas_name = 'gd_map_canvas_directory';
                var str = '&action=avlabs_gd_locations_search&paged='+attr+'&city='+city+'&country='+country+'&region='+region+'&search='+avlabs_search+'&stype='+stype+'&lat='+lat+'&long='+long+'&setting_type='+setting_type+'&budget='+budget+'&accomodation='+accomodation+'&guests='+guests;
                jQuery.ajax({
                    type: "POST",
                    dataType: "html",
                    url: '<?php echo admin_url('admin-ajax.php');?>',
                    data: str,
                    success: function(data){
                        jQuery('.custom-listings-loader-gif').hide();
                        jQuery("#avlabs_grid_listing_fullSearch").html(data);

                        /**
                         * geodirectory custom post images slider
                         */
                        jQuery(".custom-gd-posts-imgs-slider-second").slick({
                            dots: false,
                            slidesToShow:1,
                            slidesToScroll:1,
                            autoplay:false,
                            arrows:true,
                            speed: 300,
                            infinite:false,
                            responsive: [
                                {
                                    breakpoint: 767,
                                    settings: {
                                    slidesToShow: 1,
                                    }
                                }
                            ]
                        });

                        jQuery('div.geodir_post_meta a.gd-read-more').html('');
                        jQuery('div.geodir_post_meta a.gd-read-more').html('LEARN MORE');
                        jQuery('#avlabs_custom_search_venue').html('<svg class="svg-inline--fa fa-magnifying-glass" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>');

                    }
                });
            }

            /**
             * FOR FEATURED
             */
            function avlabs_listing_ajax_callback_featured(attr,city,country,region,avlabs_search,stype,lat,long,setting_type,budget,accomodation,guests,featured){
                var str = '&action=avlabs_gd_locations_search_featured&paged='+attr+'&city='+city+'&country='+country+'&region='+region+'&search='+avlabs_search+'&stype='+stype+'&lat='+lat+'&long='+long+'&setting_type='+setting_type+'&budget='+budget+'&accomodation='+accomodation+'&guests='+guests+'&featured='+featured;
                jQuery.ajax({
                    type        :   "POST",
                    dataType    :   "html",
                    url         :   '<?php echo admin_url('admin-ajax.php');?>',
                    data        :   str,
                    success: function(data){
                        jQuery('.custom-listings-loader-gif').hide();
                        jQuery("#avlabs_grid_listing_fullSearch_featured").html(data);

                        if( jQuery("#avlabs_grid_listing_fullSearch_featured .geodir-loop-container").length > 0 ){
                            jQuery("#avlabs_grid_listing_fullSearch_featured").prepend('<h2><?php echo __('Featured'); ?></h2>');
                        }
                        /**
                         * venus featured slider
                         */
                        jQuery("#featured-images-slider").slick({
                            dots: true,
                            slidesToShow:2,
                            slidesToScroll:1,
                            autoplay:false,
                            autoplaySpeed:5000,
                            arrows:true,
                            speed: 300,
                            infinite:false,
                            responsive: [
                                {
                                    breakpoint: 767,
                                    settings: {
                                    slidesToShow: 1,
                                    }
                                }
                            ]
                        });

                        /**
                         * geodirectory custom post images slider
                         */
                        jQuery(".custom-gd-posts-imgs-slider").slick({
                            dots: false,
                            slidesToShow:1,
                            slidesToScroll:1,
                            autoplay:false,
                            arrows:true,
                            speed: 300,
                            infinite:false,
                            draggable: false,
                            responsive: [
                                {
                                    breakpoint: 767,
                                    settings: {
                                    slidesToShow: 1,
                                    }
                                }
                            ]
                        });

                        jQuery('div.geodir_post_meta a.gd-read-more').html('');
                        jQuery('div.geodir_post_meta a.gd-read-more').html('LEARN MORE');
                        jQuery('#avlabs_custom_search_venue').html('<svg class="svg-inline--fa fa-magnifying-glass" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>');
                    }
                });
            }
            </script>
            <?php
            return ob_get_clean();
        }

        /**
         * LOCATION WISE LISTING...................
        */
        public static function avlabs_gd_locations_search(){
            global $gd_post, $wpdb, $post;

            $paged          = ( !empty($_REQUEST['paged']) )    ? $_REQUEST['paged']    :   1;
            $featured       = ( isset($_REQUEST['featured']))   ? $_REQUEST['featured'] :   0;
            $region         = ( isset($_REQUEST['region'])          && $_REQUEST['region'] != 'undefined')               ?  $_REQUEST['region']           :   '';
            $country        = ( isset($_REQUEST['country'])         && $_REQUEST['country'] != 'undefined')              ?  $_REQUEST['country']           :   '';
            $city           = ( isset($_REQUEST['city'])            && $_REQUEST['city'] != 'undefined')                 ?  $_REQUEST['city']           :   '';
            $stype          = ( isset($_REQUEST['stype'])           && $_REQUEST['stype'] != 'undefined' )               ?  $_REQUEST['stype']            :   'all';
            $setting_type   = ( isset($_REQUEST['setting_type'])    && $_REQUEST['setting_type'] != 'undefined' )        ?  $_REQUEST['setting_type']     :   '';
            $budget         = ( isset($_REQUEST['budget'])          && $_REQUEST['budget'] != 'undefined')               ?  $_REQUEST['budget']           :   '';
            $accomodation   = ( isset($_REQUEST['accomodation'])    && $_REQUEST['accomodation'] != 'undefined' )        ?  $_REQUEST['accomodation']     :   '';
            $guests         = ( isset($_REQUEST['guests'])          && $_REQUEST['guests'] != 'undefined')               ?  $_REQUEST['guests']           :   '';
            $search         = ( isset($_REQUEST['search'])          && !empty($_REQUEST['search']) )                     ?  $_REQUEST['search']           :   '';

            $query_args = array(
                'post_type'             =>  $stype,
                'search'                =>  $search,
                'post_status'           =>  'publish',
                'posts_per_page'        =>  12,
                'pageno'                =>  $paged,
            );

            $city_detail = [
                'region'        =>  $region,
                'country'       =>  $country,
                'city'          =>  $city,
                'settingtype'   =>  $setting_type,
                'price'         =>  $budget,
                'accommodation' =>  $accomodation,
                'no_of_guests'  =>  $guests,
                'featured'      =>  $featured
            ];

            $city_details       =   (object)$city_detail;
            $hotal              =   $city_details;
            $all_rows           =   self::av_location_page_ajax_search_Querymaker_count($query_args,true,$hotal);
            $rows               =   self::av_location_page_ajax_search_Querymaker($query_args,false,$hotal);
            $count              =   count($rows);
            $geodir_settings    =   get_option('geodir_settings');

            if($count > 0){
                echo '<style>
                        .post-learn-more-btn {
                            margin-top: 10px;
                        }
            
                        .listing-box-link {
                            display: block;
                            position: relative;
                            overflow: hidden;
                            max-height: calc(1.2em * 3); /* Adjust as needed */
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            margin-top: 10px;
                        }
                        #avlabs_grid_listing_fullSearch_featured .slick-track {
                            opacity: 1;
                            width: 1586px !important;
                            left: 0px;
                        }
                    </style>';
                echo '<div class="geodir-loop-container  sdel-bcebbf46"><div class="geodir-category-list-view av_listing_outer clearfix geodir-listing-posts geodir-gridview gridview_onefourth" style="display: flex; flex-wrap: wrap; width: 100%">';
                foreach ($rows as $post):
                    $post_id        =   $post->ID;
                    $geodir_post    =   geodir_get_post_info( $post_id );
                    $post_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_id);
                    $no_of_guests   =   geodir_get_post_meta($post_id, 'no_of_guests', true);
                    $no_of_bedrooms =   geodir_get_post_meta($post_id, 'no_of_bedrooms', true);
                    $price          =   geodir_get_post_meta($post_id, 'price', true);
                    $card_text = $wpdb->get_row( "SELECT venue_card_text FROM " . $wpdb->prefix . "geodir_gd_place_detail WHERE post_id = $post_id" );
                    $truncated_text = wp_trim_words($card_text->venue_card_text, 20, '...');
                    $metaHtml       =   '';
                    if(!empty($no_of_guests)){
                        $metaHtml .= "<span class='no_of_guests'>[gd_post_meta key='no_of_guests' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($no_of_bedrooms)){
                        $metaHtml .= "<span class='no_of_bedrooms'>[gd_post_meta key='no_of_bedrooms' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($price)){
                        $metaHtml .= "<span class='price'>From [gd_post_meta key='price' show='value-strip' no_wrap='1']</span>";
                    }
                    echo '<div class="av_listing_elements card ">';
                    setup_postdata($post);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='geodir-posts-custom-slider-section-second'>
                    ";
                    if(!empty($post_images)){
                        $content .= "<div class='custom-gd-posts-imgs-slider-second'>";
                        foreach($post_images as $img){
                            if(!empty($img['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$img['src'].'"></div>';
                                break;
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    [gd_post_title tag='h2']
                    </div>
                    <div class='post-meta-data'>
                        <span class='region'>[gd_post_meta key='region' show='value-raw' no_wrap='1']</span>
                        <div class='meta-childs'>".$metaHtml."</div>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    [gd_post_badge key='featured' condition='is_not_empty' icon_class='fas fa-certificate' badge='Featured' bg_color='#ffb100' txt_color='#ffffff' alignment='left']
                    [gd_post_badge key='claimed' condition='is_not_empty' search='+30' icon_class='fas fa-user-check fa-fw' badge='Verified' bg_color='#23c526' txt_color='#ffffff' alignment='left' list_hide_secondary='3']
                    [gd_author_actions author_page_only='1']
                    [gd_post_distance]
                    [gd_post_meta key='business_hours' location='listing' list_hide_secondary='2']
                    [gd_output_location location='listing']
                    <div class='venue_card_text featured_venue_card_text truncated_text_value'>$truncated_text</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
                echo '<div class="pagination_master">';
                avlabs_listing_pagination_gd_search($all_rows,12,$paged);
                echo '</div>';
                echo '</div>';
            }else{
                echo '<h3>No Records Found.</h3>';
            }
            die;
        }

        /**
         * LOCATION WISE  FEATURED LISTING..........
         */
        public static function avlabs_gd_locations_search_featured(){
            global $gd_post, $wpdb, $post;
            $paged          =   ( !empty($_REQUEST['paged']) )    ? $_REQUEST['paged']          :   1;
            $featured       =   ( isset($_REQUEST['featured']))   ? $_REQUEST['featured']       :   1;
            $region         =   ( isset($_REQUEST['region'])          && $_REQUEST['region'] != 'undefined')            ?  $_REQUEST['region']         :  '';
            $country        =   ( isset($_REQUEST['country'])         && $_REQUEST['country'] != 'undefined')           ?  $_REQUEST['country']        :  '';
            $city           =   ( isset($_REQUEST['city'])            && $_REQUEST['city'] != 'undefined')              ?  $_REQUEST['city']           :  '';
            $stype          =   ( isset($_REQUEST['stype'])         && $_REQUEST['stype'] != 'undefined'        )       ?  $_REQUEST['stype']          :  'gd_place';
            $setting_type   =   ( isset($_REQUEST['setting_type'])  && $_REQUEST['setting_type'] != 'undefined' )       ?  $_REQUEST['setting_type']   :  '';
            $budget         =   ( isset($_REQUEST['budget'])        && $_REQUEST['budget'] != 'undefined'       )       ?  $_REQUEST['budget']         :  '';
            $accomodation   =   ( isset($_REQUEST['accomodation'])  && $_REQUEST['accomodation'] != 'undefined' )       ?  $_REQUEST['accomodation']   :  '';
            $guests         =   ( isset($_REQUEST['guests'])        && $_REQUEST['guests'] != 'undefined'       )       ?  $_REQUEST['guests']         :  '';
            $search         =   ( isset($_REQUEST['search'])        && !empty($_REQUEST['search']) )                    ?  $_REQUEST['search']         :  '';

            $query_args = array(
                'post_type'             =>  $stype,
                'search'                =>  $search,
                'post_status'           =>  'publish',
                'posts_per_page'        =>  12,
                'pageno'                =>  $paged,
            );

            $city_detail = [
                'region'        =>  $region,
                'country'       =>  $country,
                'city'          =>  $city,
                'settingtype'   =>  $setting_type,
                'price'         =>  $budget,
                'accommodation' =>  $accomodation,
                'no_of_guests'  =>  $guests,
                'featured'      =>  $featured
            ];
            $city_details       =   (object)$city_detail;
            $hotal              =   $city_details;
            $rows               =   self::av_location_page_ajax_search_Querymaker($query_args,false,$hotal);
            $count              =   (is_array($rows) && !empty($rows)) ? count($rows) : '';
            $geodir_settings    =   get_option('geodir_settings');
            if($count > 0){
                echo '<style>
                        .post-learn-more-btn {
                            margin-top: 10px;
                        }
            
                        .listing-box-link {
                            display: block;
                            position: relative;
                            overflow: hidden;
                            max-height: calc(1.2em * 3); /* Adjust as needed */
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            margin-top: 10px;
                        }
                        #avlabs_grid_listing_fullSearch_featured .slick-track {
                            opacity: 1;
                            width: 1586px !important;
                            left: 0px;
                        }
                    </style>';
                echo '<div class="geodir-loop-container  sdel-bcebbf46">
                <div class="geodir-category-list-view av_listing_outer clearfix geodir-listing-posts geodir-gridview gridview_onefourth" style="display: flex; flex-wrap: wrap; width: 100%" id="featured-images-slider">';
                foreach ($rows as $post):
                    $post_id        =   $post->ID;
                    $geodir_post    =   geodir_get_post_info( $post_id );
                    $post_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_id);
                    $no_of_guests   =   geodir_get_post_meta($post_id, 'no_of_guests', true);
                    $no_of_bedrooms =   geodir_get_post_meta($post_id, 'no_of_bedrooms', true);
                    $price          =   geodir_get_post_meta($post_id, 'price', true);
                    $card_text = $wpdb->get_row( "SELECT venue_card_text FROM " . $wpdb->prefix . "geodir_gd_place_detail WHERE post_id = $post_id" );
                    $truncated_text = wp_trim_words($card_text->venue_card_text, 30, '...');
                    $metaHtml       =   '';
                    if(!empty($no_of_guests)){
                        $metaHtml .= "<span class='no_of_guests'>[gd_post_meta key='no_of_guests' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($no_of_bedrooms)){
                        $metaHtml .= "<span class='no_of_bedrooms'>[gd_post_meta key='no_of_bedrooms' show='value-raw' no_wrap='1']</span>";
                    }
                    if(!empty($price)){
                        $metaHtml .= "<span class='price'>From [gd_post_meta key='price' show='value-strip' no_wrap='1']</span>";
                    }
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post);
                    $content = "
                    [gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='geodir-posts-custom-slider-section'>
                    ";
                    if(!empty($post_images)){
                        $content .= "<div class='custom-gd-posts-imgs-slider'>";
                        foreach($post_images as $img){
                            if(!empty($img['src'])){
                                $content .= '<div class="gd-img-item"><img class="gd-post-image" src="'.$img['src'].'"></div>';
                                break;
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                        [gd_post_title tag='h2']
                    </div>
                    <div class='post-meta-data'>
                        <span class='region'>[gd_post_meta key='region' show='value-raw' no_wrap='1']</span>
                        <div class='meta-childs'>".$metaHtml."</div>
                    </div>
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted Supplier</span>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    [gd_post_badge key='featured' condition='is_not_empty' icon_class='fas fa-certificate' badge='Featured' bg_color='#ffb100' txt_color='#ffffff' alignment='left']
                    [gd_post_badge key='claimed' condition='is_not_empty' search='+30' icon_class='fas fa-user-check fa-fw' badge='Verified' bg_color='#23c526' txt_color='#ffffff' alignment='left' list_hide_secondary='3']
                    [gd_author_actions author_page_only='1']
                    [gd_post_distance]
                    [gd_post_meta key='business_hours' location='listing' list_hide_secondary='2']
                    [gd_output_location location='listing']
                    <div class='venue_card_text featured_venue_card_text truncated_text_value_featured'> $truncated_text </div>
                    
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
                echo '</div>';
            }else{
                echo '<h3>No Records Found.</h3>';
            }
            die;
        }

        /**
         * SEARCH GEODIRECTORY POST
         */
        public static function av_location_page_ajax_search_Querymaker($query_args = array(), $count_only = false, $hotal = array()){
            global $wp, $wpdb, $plugin_prefix, $table_prefix, $geodirectory;
            $paged      =   $query_args['pageno'];
            $pp_page    =   $query_args['posts_per_page'];
            $offset     =   ($paged-1)*$pp_page;
            $scondition = '';

            if(isset($hotal->region) && !empty($hotal->region)){
                $region      =  $hotal->region;
                $regionData  =  $wpdb->get_row("SELECT region FROM `".$wpdb->prefix."geodir_post_locations` WHERE region_slug='$region' LIMIT 1");
                $region      =  $regionData->region;
                $scondition .= ' AND ( (venue.region LIKE "'.$region.'") OR (venue.places_of_interest LIKE "' . $region . '") )';
            }
            if(isset($hotal->country) && !empty($hotal->country)){
                $country     =  $hotal->country;
                $countryData =  $wpdb->get_row("SELECT country FROM `".$wpdb->prefix."geodir_post_locations` WHERE country_slug='$country' LIMIT 1");
                $country     =  $countryData->country;
                $scondition .= ' AND (venue.country LIKE "'.$country.'")';
            }
            if(isset($hotal->city) && !empty($hotal->city)){
                $city      =  $hotal->city;
                $cityData  =  $wpdb->get_row("SELECT city FROM `".$wpdb->prefix."geodir_post_locations` WHERE city_slug='$city' LIMIT 1");
                $city      =  $cityData->city;
                $scondition .= ' AND (venue.city LIKE "'.$city.'")';
            }
            if(isset($hotal->featured) && !empty($hotal->featured)){
                $featured       =    $hotal->featured;
                $scondition     .=  ' AND (venue.featured='.$featured.')';
            }
            if(isset($hotal->price) && !empty($hotal->price)){
                $price = $hotal->price;
                $scondition     .=  ' AND (venue.price <='.intval($price).')';
            }
            if(isset($hotal->accommodation) && !empty($hotal->accommodation)){
                $accommodation = $hotal->accommodation;
                $scondition     .=  ' AND (venue.no_of_bedrooms >= '.$accommodation.')';
            }
            if(isset($hotal->no_of_guests) && !empty($hotal->no_of_guests)){
                $no_of_guests = $hotal->no_of_guests;
                $scondition     .=  ' AND (venue.no_of_guests >= '.$no_of_guests.')';
            }
            $rows   =   $wpdb->get_results("
                            SELECT p.* FROM `".$wpdb->prefix."posts` AS p
                            LEFT JOIN `".$wpdb->prefix."geodir_gd_place_detail` AS venue ON venue.post_id=p.ID
                            WHERE p.post_status='publish' AND p.post_type='gd_place'  " .$scondition. " ORDER BY ID DESC LIMIT $offset, $pp_page
                        ");
            return $rows;
        }

        public static function av_location_page_ajax_search_Querymaker_count($query_args = array(), $count_only = false, $hotal = array()){
            global $wp, $wpdb, $plugin_prefix, $table_prefix, $geodirectory;
            if(isset($hotal->region) && !empty($hotal->region)){
                $region      =  $hotal->region;
                $regionData  =  $wpdb->get_row("SELECT region FROM `".$wpdb->prefix."geodir_post_locations` WHERE region_slug='$region' LIMIT 1");
                $region      =  $regionData->region;
                $scondition .= ' AND ( (venue.region LIKE "'.$region.'") OR (venue.places_of_interest LIKE "' . $region . '") )';
            }
            if(isset($hotal->country) && !empty($hotal->country)){
                $country     =  $hotal->country;
                $countryData =  $wpdb->get_row("SELECT country FROM `".$wpdb->prefix."geodir_post_locations` WHERE country_slug='$country' LIMIT 1");
                $country     =  $countryData->country;
                $scondition .= ' AND (venue.country LIKE "'.$country.'")';
            }
            if(isset($hotal->city) && !empty($hotal->city)){
                $city      =  $hotal->city;
                $cityData  =  $wpdb->get_row("SELECT city FROM `".$wpdb->prefix."geodir_post_locations` WHERE city_slug='$city' LIMIT 1");
                $city      =  $cityData->city;
                $scondition .= ' AND (venue.city LIKE "'.$city.'")';
            }
            if(isset($hotal->featured) && !empty($hotal->featured)){
                $featured       =    $hotal->featured;
                $scondition     .=  ' AND (venue.featured='.$featured.')';
            }
            if(isset($hotal->price) && !empty($hotal->price)){
                $price = $hotal->price;
                $scondition     .=  ' AND (venue.price <='.intval($price).')';
            }
            if(isset($hotal->accommodation) && !empty($hotal->accommodation)){
                $accommodation = $hotal->accommodation;
                $scondition     .=  ' AND (venue.no_of_bedrooms >= '.$accommodation.')';
            }
            if(isset($hotal->no_of_guests) && !empty($hotal->no_of_guests)){
                $no_of_guests = $hotal->no_of_guests;
                $scondition     .=  ' AND (venue.no_of_guests >= '.$no_of_guests.')';
            }
            $rows   =   $wpdb->get_row("
                            SELECT COUNT(p.ID) AS total FROM `".$wpdb->prefix."posts` AS p
                            LEFT JOIN `".$wpdb->prefix."geodir_gd_place_detail` AS venue ON venue.post_id=p.ID
                            WHERE p.post_status='publish' AND p.post_type='gd_place' " .$scondition. "
                        ");
            return $rows->total;
        }

        /**
         * LATEST VENUES AND SUPPLIERS SLIDER
         */
        public static function fws_venues_and_suppliers_slider_cb(){
            ob_start();
            global $wpdb;
            $args = [
                'post_type'         =>  array('gd_suppliers', 'gd_place'),
                'post_status'       =>  'publish',
                'posts_per_page'    =>  10,
                'numberposts'       =>  10,
                'orderby'           =>  'date',
		        'order'             =>  'DESC',
            ];
            $getting_posts = get_posts($args);
            if(!empty($getting_posts)){
                echo '<style>
                        .post-learn-more-btn {
                            margin-top: 10px;
                        }
            
                        .listing-box-link {
                            display: block;
                            position: relative;
                            overflow: hidden;
                            max-height: calc(1.2em * 3); /* Adjust as needed */
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            margin-top: 10px;
                        }
                        #avlabs_grid_listing_fullSearch_featured .slick-track {
                            opacity: 1;
                            width: 1586px !important;
                            left: 0px;
                        }
                        
                    </style>';
                echo '<div class="geodir-loop-container" id="custom-venue-supp-listings">';
                foreach ($getting_posts as $post):
                    $post_id        =   $post->ID;
                    $geodir_post    =   geodir_get_post_info( $post_id );
                    $categories     =   (isset($geodir_post->post_category) && !empty($geodir_post->post_category)) ? explode(',', $geodir_post->post_category) : [];
                    $term           =   (isset($categories[1]) && !empty($categories[1])) ? get_term($categories[1]) : [];
                    $term_name      =   (isset($term->name) && !empty($term->name)) ? ucfirst($term->name) : '';
                    $post_images    =   get_post_images( $geodir_post );
                    $permalink      =   get_permalink($post_id);
                    $card_text = $wpdb->get_row( "SELECT venue_card_text FROM " . $wpdb->prefix . "geodir_gd_place_detail WHERE post_id = $post_id" );
                    $truncated_text = wp_trim_words($card_text->venue_card_text, 20, '...');
                    $no_of_guests   =   geodir_get_post_meta($post_id, 'no_of_guests', true);
                    $no_of_bedrooms =   geodir_get_post_meta($post_id, 'no_of_bedrooms', true);
                    $price          =   geodir_get_post_meta($post_id, 'price', true);
                   
                   
                    // $supplier_categories = get_the_terms($post_id, 'gd_suppliers');
                    // $venue_categories = get_the_terms($post_id, 'gd_place');
                    // $category_list = '';
                    // if (!empty($supplier_categories) && !is_wp_error($supplier_categories)) {
                    //     foreach ($supplier_categories as $category) {
                    //         $category_list .= '<span class="venue-category">' . esc_html($category->name) . '</span> ';
                    //     }
                    // }elseif(!empty($venue_categories) && !is_wp_error($venue_categories)){
                    //      foreach ($venue_categories as $category) {
                    //         $category_list .= '<span class="venue-category">' . esc_html($category->name) . '</span> ';
                    //     }
                    // }
                   
                   
                    $metaHtml       =   '';
                    // if(!empty($no_of_guests)){
                    //     $metaHtml .= "<span class='no_of_guests'>[gd_post_meta key='no_of_guests' show='value-raw' no_wrap='1']</span>";
                    // }
                    // if(!empty($no_of_bedrooms)){
                    //     $metaHtml .= "<span class='no_of_bedrooms'>[gd_post_meta key='no_of_bedrooms' show='value-raw' no_wrap='1']</span>";
                    // }
                    if(!empty($price)){
                        $metaHtml .= "<span class='price'>From [gd_post_meta key='price' show='value-strip' no_wrap='1']</span>";
                    }
                    echo '<div class="av_listing_elements card">';
                    setup_postdata($post);
                    $content = "[gd_archive_item_section type='open' position='left']
                    [gd_post_badge key='featured' condition='is_not_empty' badge='FEATURED' bg_color='#fd4700' txt_color='#ffffff' css_class='gd-ab-top-left-angle gd-badge-shadow']
                    <div class='venue_category'>
                    <style>
                            .venue_category {
                                position: absolute;
                                z-index: 15 !important;
                                color: white;
                                background: linear-gradient(45deg, rgb(79 79 79 / 30%), rgb(79 79 79 / 10%)) !important;
                                padding: 5px 0.4em 0;
                                width: 100;
                                transform: rotate(0deg);
                                top: 22px;
                                left: 25px;
                                backdrop-filter: blur(50px);
                                box-shadow: none !important;
                                border-radius: 50px !important;
                                min-width: 140px;
                                min-height: 21px;
                                font-family: 'Söhne', Sans-serif;
                                font-size: 14px !important;
                                font-weight: 400;
                                text-transform: capitalize;
                            }
                            </style>
                    
                    $term_name
                    </div>
                    <div class='gd-supplier-listings-images'>
                    ";
                    if(!empty($post_images)){
                        $content .= "<div class='custom-venue-supp-images-slider'>";
                        foreach($post_images as $img){
                            if(!empty($img['src'])){
                                $content .= '<div class="gd-img-item-second"><img class="gd-post-image" src="'.$img['src'].'"></div>';
                            }
                        }
                        $content .= "</div>";
                    }
                    $content .= "
                    </div>
                    [gd_archive_item_section type='close' position='left']
                    [gd_archive_item_section type='open' position='right']
                    
                    <div class='gd-default-link'>
                        <span class='trust-text'>Trusted Supplier</span>
                    </div>
                    <div class='fav'>
                    [gd_post_fav show='' alignment='right' list_hide_secondary='2']
                    </div>
                    <div class='heading'>
                    <a href='".$permalink."'><h2 class='title'>".$geodir_post->post_title."</h2></a>
                    </div>
                    
                    <div class='post-meta-data'>
                        <span class='region'>[gd_post_meta key='region' show='value-raw' no_wrap='1']</span>
                        <div class='meta-childs'>".$metaHtml."</div>
                    </div>
                    <div class='gd-link-main'>
                    <div class='gd-link-row right'>
                    [gd_post_rating show='short-count' size='0' border_type='border']
                    </div>
                    </div>
                    <div class='post-content venue-card-text'> ". $truncated_text ."</div>
                    <div class='post-learn-more-btn'>
                        <a href='".$permalink."' class='custom-learn-more-btn'>LEARN MORE</a>
                    </div>
                    <a href='".$permalink."' class='listing-box-link'></a>
                    [gd_archive_item_section type='close' position='right']";
                    echo do_shortcode($content);
                    echo '</div>';
                endforeach;
                echo '</div>';
            }else{
                echo '<h3>No Records Found.</h3>';
            }
            ?>
            <script>
                jQuery(document).ready(function(){
                    jQuery("#custom-venue-supp-listings").slick({
                        dots: true,
                        slidesToShow:3,
                        slidesToScroll:1,
                        autoplay:false,
                        arrows:true,
                        speed: 300,
                        infinite:false,
                        draggable:true,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint:767 ,
                                settings: {
                                slidesToShow: 1,
                                }
                            }
                        ]
                    });

                    jQuery(".custom-venue-supp-images-slider").slick({
                        dots:false,
                        slidesToShow:1,
                        slidesToScroll:1,
                        autoplay:false,
                        arrows:true,
                        infinite:false,
                        draggable:false,
                        responsive: [
                            {
                                breakpoint: 767,
                                settings: {
                                slidesToShow: 1,
                                }
                            }
                        ]
                    });
                });
            </script>
            <?php
            return ob_get_clean();
        }

        /**
         * ADD HEADING AFTER VENUE TITLE..
         */
        public static function fws_heading_after_title(){
            global $pagenow, $typenow;
            if ( 'gd_place' === get_post_type() ) {
                echo '<div class="gd-listing-heading"><h2 style="font-size:30px; padding:0px;"class="gd-custom-heading">Overview</h2></div>';
            }else if('gd_suppliers' === get_post_type()){
                echo '<div class="gd-listing-heading"><h2 style="font-size:30px; padding:0px;"class="gd-custom-heading">Overview</h2></div>';
            }
        }

        /**
         * CHANGE VENUE TITLE PLACEHOLDER
         */
        public static function fws_venues_business_title_placeholder($title_placeholder, $post){
            if($post->post_type === 'gd_place'){
                $title_placeholder = 'Business Name';
            }else if($post->post_type === 'gd_suppliers'){
                $title_placeholder = 'Name of Business';
            }
            return $title_placeholder;
        }

        /**
         * WP ADMIN CUSTOM STYLES
         */
        public static function fws_admin_custom_style_cb(){
            global $pagenow, $post_type;
            if(is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php') && $post_type == 'gd_place'){
                ?>
                <style>
                    div#geodir_address_map_row{
                        display: none;
                    }
                    .form-group.row[data-argument="address_latitude"], .form-group.row[data-argument="address_longitude"], .form-group.row[data-argument="address_mapview"], .form-group.row[data-argument="address_city"], .form-group.row[data-argument="address_region"], .form-group.row[data-argument="address_zip"], .form-group.row[data-argument="default_category"]{
                        display: none;
                    }
                    fieldset#geodir_fieldset_190[data-rule-key="images"]{
                        display: none;
                    }
                    .form-group.row[data-rule-type="checkbox"] .custom-control.custom-checkbox {
                        padding-left: 0;
                        padding-right: 0;
                        max-width: 22%;
                    }
                    .form-group.row[data-rule-type="checkbox"] label.custom-control-label {
                        width: 100%;
                        display: block;
                    }
                    .form-group.row[data-rule-type="checkbox"] label.custom-control-label:before, .form-group.row[data-rule-type="checkbox"] label.custom-control-label:after {
                        left: auto;
                        right: 0;
                    }
                    .form-group.row[data-rule-type="checkbox"] .col-sm-2.col-form-label {
                        display: none;
                    }
                    .supp-packages .packages-rows {
                        display: grid !important;
                        grid-template-columns: 200px 100px auto;
                    }
                    .supp-packages .packages-rows .text-packages {
                        width: 100% !important;
                    }
                    .supp-packages .packages-rows .text-packages iframe {
                        height: 150px !important;
                    }
                    .form-group.row[data-argument="package_id"] label.pt-0.col-sm-2.col-form-label.radio, .form-group.row[data-argument="featured"] label.custom-control-label {
                        font-weight: 700;
                    }
                    textarea#nearest_airport, textarea#nearest_airport_2, textarea#nearest_airport_3, #video, #videolink2, #videolink3 {
                        min-height: 45px !important;
                        height: 45px;
                    }
                </style>
                <?php
            }else if(is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php') && $post_type == 'gd_suppliers'){
                ?>
                <style>
                div#geodir_address_map_row{
                    display: none;
                }
                .form-group.row[data-argument="address_latitude"], .form-group.row[data-argument="address_city"], .form-group.row[data-argument="address_longitude"], .form-group.row[data-argument="address_mapview"], .form-group.row[data-argument="address_region"], .form-group.row[data-argument="address_zip"], .form-group.row[data-argument="default_category"]{
                    display: none;
                }
                fieldset#geodir_fieldset_171[data-rule-key="images"]{
                    display: none;
                }
                .supp-packages .packages-rows {
                    display: grid !important;
                    grid-template-columns: 200px 100px auto;
                }
                .supp-packages .packages-rows .text-packages {
                    width: 100% !important;
                }
                .supp-packages .packages-rows .text-packages iframe {
                    height: 150px !important;
                }
                .form-group.row[data-argument="package_id"] label.pt-0.col-sm-2.col-form-label.radio, .form-group.row[data-argument="featured"] label.custom-control-label {
                    font-weight: 700;
                }
                .form-group.row[data-rule-type="checkbox"] .custom-control.custom-checkbox {
                    padding-left: 0;
                    padding-right: 0;
                    max-width: 22%;
                }
                .form-group.row[data-rule-type="checkbox"] label.custom-control-label {
                    width: 100%;
                    display: block;
                }
                .form-group.row[data-rule-type="checkbox"] label.custom-control-label:before, .form-group.row[data-rule-type="checkbox"] label.custom-control-label:after {
                    left: auto;
                    right: 0;
                }
                .form-group.row[data-rule-type="checkbox"] .col-sm-2.col-form-label {
                    display: none;
                }
                textarea#nearest_airport, textarea#nearest_airport_2, textarea#nearest_airport_3, #video, #videolink2, #videolink3 {
                    min-height: 45px !important;
                    height: 45px;
                }
                </style>
                <?php
            }
        }

        /**
         * SUPPLIER CUSTOM SERVICES
         */
        public static function av_geodir_custom_field_input_text_supplier_services($html, $cf){
            ob_start();
            $htmlvar_name   =   $cf['htmlvar_name'];
            $html           =   '';
            $value          =   geodir_get_cf_value($cf);
            ?>
            <div data-argument="supplier_services" class="form-group row" data-rule-key="supplier_services" data-rule-type="time">
                <label for="supplier_services" class="col-sm-2 col-form-label text">Services</label>
                <div class="col-sm-10">
                    <div class="input-group-inside position-relative">
                        <style>
                            .supp-services .services-rows {
                                display: flex;
                                flex-direction: column;
                                padding-top: 20px;
                                padding-bottom: 20px;
                                gap: 10px;
                            }

                            .services-rows .text-services {
                                width: 30%;
                            }

                            .services-rows .text-services input[type="text"] {
                                width: 100%;
                            }

                            .text-services textarea.textareafor-answer {
                                width: 100%;
                            }

                            .text-services {
                                width: 30%;
                            }
                        </style>
                        <?php
                        if (!empty($value)){
                            ?>
                            <span class="btn btn-success add-services-btn-listing">Add Services</span>
                            <div class="supp-services">
                                <?php
                                if(is_admin()){
                                    global $post;
                                    $post_id    =   $post->ID;
                                    $services   =   get_post_meta($post_id, 'supplier_services', true);
                                    if(!empty($services) && is_array($services)){
                                        $supp_services  =  $services['supp_services'];
                                        foreach($supp_services as $key => $v){
                                            ?>
                                            <div class="services-rows">
                                                <div class="text-services">
                                                    <textarea class="textarea_service_detail" name="supplier_services[supp_services][<?= $key ?>][description]" title="Service Description"><?= isset($v['description']) ? esc_attr($v['description']) : '' ?></textarea>
                                                </div>
                                                <div class="text-services">
                                                    <span class="btn btn-danger remove-faq" onclick="remove_services(this);" title="Remove Service">Remove</span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }else{
                                    global $wp;
                                    $editListing_url    =   home_url( $wp->request );
                                    $explode_url        =   explode('/', $editListing_url);
                                    $post_id            =   (is_array($explode_url) && !empty($explode_url)) ? (int) end($explode_url) : '';
                                    if(is_int($post_id)){
                                        $services  =   get_post_meta($post_id, 'supplier_services', true);
                                        if(!empty($services) && is_array($services)){
                                            $supp_services  =  $services['supp_services'];
                                            foreach($supp_services as $key => $v){
                                                ?>
                                                <div class="services-rows">
                                                    <div class="text-services">
                                                        <textarea class="textarea_service_detail" name="supplier_services[supp_services][<?= $key ?>][description]"><?= isset($v['description']) ? esc_attr($v['description']) : '' ?></textarea>
                                                    </div>
                                                    <div class="text-services">
                                                        <span class="btn btn-danger remove-faq" onclick="remove_services(this);">Remove</span>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }else{
                            ?>
                            <span class="btn btn-success add-services-btn-listing">Add Services</span>
                            <div class="supp-services"></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            $html = ob_get_clean();
            return $html;
        }

        /**
         * FOOTER SCRIPTS
         */
        public static function fws_custom_scripts_cb(){
            if(is_single()){
                global $gd_post;
                $post_title = $gd_post->post_title;
                if((isset($gd_post->post_type)) && ($gd_post->post_type == 'gd_place' || $gd_post->post_type == 'gd_suppliers')){
                    ?>
                    <script>
                        jQuery(document).ready(function(){
                            var posttitle = 'Message <?= $post_title ?>';
                            if(posttitle != ''){
                                setTimeout(() => {
                                    jQuery('div.field-wrap.submit-wrap.textbox-wrap .nf-field-element input#nf-field-12[type="submit"]').attr("value", posttitle);
                                }, 800);
                            }
                        });
                    </script>
                    <?php
                }
            }
        }
    }

    FwsHookList::init();
}
