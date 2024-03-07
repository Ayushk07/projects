<?php
if (!class_exists('AVCoreBackendEnd', false)) {

    class AVCoreBackendEnd
    {
        public static function init()
        {
            add_action('init', array(__CLASS__, 'create_posttype_directory'));
            add_action('admin_menu', array(__CLASS__, 'add_import_submenu_to_taxonomy'));
            add_action('admin_menu', array(__CLASS__, 'add_setting_submenu_to_taxonomy'));
            add_action('add_meta_boxes', array(__CLASS__, 'directory_form_metabox'));
            add_action('save_post', array(__CLASS__, 'save_directory_form_data'));
            add_action('trashed_post', array(__CLASS__, 'delete_custom_data_on_post_trash'));
            add_action('edit_post', array(__CLASS__, 'update_directory_form_data'));
        }

        public static function create_posttype_directory()
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
                'name' => _x('Directory', 'plural'),
                'singular_name' => _x('Directory', 'singular'),
                'menu_name' => _x('Directory', 'admin menu'),
                'name_admin_bar' => _x('Directory', 'admin bar'),
                'add_new' => _x('Add New', 'add new'),
                'add_new_item' => __('Add New Directory'),
                'new_item' => __('New Directory'),
                'edit_item' => __('Edit Directory'),
                'view_item' => __('View Directory'),
                'all_items' => __('All Directory'),
                'search_items' => __('Search Directory'),
                'not_found' => __('No Directory found.'),
            );

            $args = array(
                'supports' => $supports,
                'labels' => $labels,
                'public' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'directory'),
                'hierarchical' => true,
                'taxonomies' => array('directory_category'),
            );

            register_post_type('directory', $args);
        }

        public static function add_import_submenu_to_taxonomy()
        {
            add_submenu_page(
                'edit.php?post_type=directory',
                'Import',
                'Import',
                'manage_options',
                'directory_import',
                array(__CLASS__, 'directory_import_page')
            );
        }


        public static function add_setting_submenu_to_taxonomy()
        {
            add_submenu_page(
                'edit.php?post_type=directory',
                'Setting',
                'Setting',
                'manage_options',
                'directory_setting',
                array(__CLASS__, 'directory_setting_page')
            );
        }

        public static  function directory_setting_page()
        {
?>
<style>
.section_div {
    margin: 20px 30px;
}

.section_div label:not(.switch) {
    display: inline-block;
    width: 250px;
    color: #66813c;
    font-family: 'Helvetica Neue', 'Helvetica', arial, sans-serif;
    font-size: large;
}

.input-container {
    border: 1px solid black;
    width: 223px;
    height: 103px;
    overflow: scroll;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #66813c;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

.cantainer123 {
    margin: 20px 50px 50px;
    border: 1px solid #66813c;
}

h2 {
    padding-left: 40%;
    color: #66813c;
}

.section_div input[type="text"] {
    line-height: 32px;
    padding: 5px 15px;
    min-width: 300px;
}
</style>



<?php
            $stored_text = get_option('directory_setting');
            $location_value = $stored_text['location'];
            $phone_value = $stored_text['phone'];
            $locationtext = htmlspecialchars_decode($stored_text['locationtext']);
            $phonetext = htmlspecialchars_decode($stored_text['phonetext']);
            $phoneedit = htmlspecialchars_decode($stored_text['phoneedit']);
            $frontend_color = htmlspecialchars_decode($stored_text['frontend_color']);
            $search_color = htmlspecialchars_decode($stored_text['search_color']);
            $search_text = htmlspecialchars_decode($stored_text['search_text']);

            if (isset($_POST['submit'])) {

                $phone_value = isset($_POST['phone']) ? esc_html($_POST['phone']) : '';
                $location_value = isset($_POST['location']) ? esc_html($_POST['location']) : '';
                $locationtext_value = isset($_POST['locationtext']) ? esc_html($_POST['locationtext']) : '';
                $phonetext_value = isset($_POST['phonetext']) ? esc_html($_POST['phonetext']) : '';
                $search_text_value = isset($_POST['search_text']) ? esc_html($_POST['search_text']) : '';
                $phoneedit_value = isset($_POST['phoneedit']) ? esc_html($_POST['phoneedit']) : '';
                $frontend_color_value = isset($_POST['frontend_color']) ? esc_html($_POST['frontend_color']) : '';
                $search_color_value = isset($_POST['search_color']) ? esc_html($_POST['search_color']) : '';


                $directory_setting = array(
                    'location' => $location_value,
                    'phone' => $phone_value,
                    'locationtext' => $locationtext_value,
                    'phonetext' => $phonetext_value,
                    'phoneedit' => $phoneedit_value,
                    'frontend_color' => $frontend_color_value,
                    'search_color' => $search_color_value,
                    'search_text' => $search_text_value,

                );
                update_option('directory_setting', $directory_setting);
                echo '<script>window.location.reload();</script>';
            }

            ?>

<body>
    <form method="post" name="form">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <h2 style="color: #66813c;"><?php echo __('Settings'); ?></h2>
        <div class="cantainer123">
            <div class="section_div">
                <label> <?php echo __('Location'); ?></label>
                <label class="switch">
                    <input type="checkbox" name="location"
                        <?php if ($location_value == 'on') echo "checked='checked'"; ?>>
                    <span class="slider"></span>
                </label>

            </div>

            <div class="section_div">
                <label><?php echo __('Location Text'); ?></label>
                <input type="text" id="locationtext" name="locationtext" value="<?php echo $locationtext; ?>">
            </div>

            <hr />
            <div class="section_div">
                <label><?php echo __('Buttons Background Color'); ?></label>
                <input type="color" id="frontend_color" name="frontend_color"
                    value="<?php echo esc_attr($frontend_color); ?>">
            </div>
            <hr />
            <div class="section_div">
                <label> <?php echo __('Phone Number '); ?> </label>
                <label class="switch">
                    <input type="checkbox" name="phone" <?php if ($phone_value == 'on') echo "checked='checked'"; ?>>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="section_div">
                <label><?php echo __('Phone Number Text'); ?></label>
                <input type="text" id="phonetext" name="phonetext" value="<?php echo $phonetext; ?>">
            </div>
            <div class="section_div">
                <label><?php echo __('Phone Number Edit'); ?></label>
                <input type="text" id="phoneedit" name="phoneedit" value="<?php echo $phoneedit; ?>">
            </div>
            <hr />
            <div class="section_div">
                <label><?php echo __('Search  Color'); ?></label>
                <input type="color" id="search_color" name="search_color"
                    value="<?php echo esc_attr($search_color); ?>">
            </div>
            <div class="section_div">
                <label><?php echo __('Search  Text'); ?></label>
                <input type="text" id="search_text" name="search_text" value="<?php echo $search_text; ?>">
            </div>

            <hr />
            <div class="section_div">
                <input type="submit" name="submit" class="btn btn-success">
            </div>
        </div>
    </form>
</body>

<?php

        }
        private static function geocode_address($establishment, $address_1, $postal_code)
        {

            $full_address = "{$establishment}, {$address_1}, {$postal_code}, Canada";
            $api_key = 'AIzaSyCUOLjm7aqPBDHVAdkX0Ehmqd9NAoZEp7A';
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($full_address) . "&key=" . $api_key;
            $response = file_get_contents($url);
            $data = json_decode($response);

            if ($data->status === 'OK' && !empty($data->results)) {
                $result = $data->results[0];
                $latitude = $result->geometry->location->lat;
                $longitude = $result->geometry->location->lng;
                $address_components = $result->address_components;
                $state = '';
                $country = '';
                $region = '';


                foreach ($address_components as $component) {
                    if (in_array('administrative_area_level_1', $component->types)) {
                        $state = $component->long_name;
                    } elseif (in_array('country', $component->types)) {
                        $country = $component->long_name;
                    } elseif (in_array('administrative_area_level_2', $component->types)) {
                        $region = $component->long_name;
                    }
                }

                if (!empty($state) && !empty($country) && !empty($region)) {
                    return array(
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'state' => $state,
                        'country' => $country,
                        'region' => $region,

                    );
                }
            }

            return false;
        }
        public static function directory_import_page($post_id)
        {
            set_time_limit(300);
            global $wpdb;


            if (isset($_POST['insert_directory_posts'])) {

                if (isset($_FILES['csv_file'])) {
                    $csv_file = $_FILES['csv_file'];

                    if ($csv_file['error'] === UPLOAD_ERR_OK) {
                        $csv_data = array_map('str_getcsv', file($csv_file['tmp_name']));
                        $is_first_row = true;
                        foreach ($csv_data as $row) {
                            if ($is_first_row) {
                                $is_first_row = false;
                                continue;
                            } else {

                                $licence_no        = isset($row[0]) ? $row[0] : '';
                                $establishment     = isset($row[1]) ? $row[1] : '';
                                $additional_name   = isset($row[2]) ? $row[2] : '';
                                $address_1         = isset($row[3]) ? $row[3] : '';
                                $address_2         = isset($row[4]) ? $row[4] : '';
                                $city              = isset($row[5]) ? $row[5] : '';
                                $postal_code       = isset($row[6]) ? $row[6] : '';
                                $type              = isset($row[7]) ? $row[7] : '';
                                $status            = isset($row[8]) ? $row[8] : '';
                                $phone_number      = isset($row[9]) ? $row[9] : '';
                                $fax_number        = isset($row[10]) ? $row[10] : '';
                                $funeral_home_email = isset($row[11]) ? $row[11] : '';
                                $attachment        = isset($row[12]) ? $row[12] : '';

                                $geocoded_data = self::geocode_address($establishment, $address_1, $postal_code);

                                if ($geocoded_data) {
                                    $latitude = $geocoded_data['latitude'];
                                    $longitude = $geocoded_data['longitude'];
                                    $state = $geocoded_data['state'];
                                    $country = $geocoded_data['country'];
                                    $region = $geocoded_data['region'];
                                }
                                $post_id = wp_insert_post(array(
                                    'post_title'   => $establishment,
                                    'post_type'    => 'directory',
                                    'post_status'  => 'publish'
                                ));
                                if (!is_wp_error($post_id)) {
                                    // Now insert data into post meta
                                    update_post_meta($post_id, 'licence_no', $licence_no);
                                    update_post_meta($post_id, 'establishment', $establishment);
                                    update_post_meta($post_id, 'additional_name', $additional_name);
                                    update_post_meta($post_id, 'address_1', $address_1);
                                    update_post_meta($post_id, 'address_2', $address_2);
                                    update_post_meta($post_id, 'city', $city);
                                    update_post_meta($post_id, 'state', $state);
                                    update_post_meta($post_id, 'region', $region);
                                    update_post_meta($post_id, 'country', $country);
                                    update_post_meta($post_id, 'postal_code', $postal_code);
                                    update_post_meta($post_id, 'type', $type);
                                    update_post_meta($post_id, 'status', $status);
                                    update_post_meta($post_id, 'phone_number', $phone_number);
                                    update_post_meta($post_id, 'fax_number', $fax_number);
                                    update_post_meta($post_id, 'funeral_home_email', $funeral_home_email);
                                    update_post_meta($post_id, 'latitude', $latitude);
                                    update_post_meta($post_id, 'longitude', $longitude);
                                    update_post_meta($post_id, 'directory_post_attachment', $attachment);
                                } else {

                                    error_log('Failed to insert post for establishment: ' . $establishment);
                                }
                                $table_name = $wpdb->prefix . 'fd_directory';
                                $wpdb->insert(
                                    $table_name,
                                    array(
                                        'post_id'                => $post_id,
                                        'licence_no'             => $licence_no,
                                        'establishment'          => $establishment,
                                        'additional_name'        => $additional_name,
                                        'address_1'              => $address_1,
                                        'address_2'              => $address_2,
                                        'city'                   => $city,
                                        'state'                  => $state,
                                        'region'                 => $region,
                                        'country'                => $country,
                                        'postal_code'            => $postal_code,
                                        'type'                   => $type,
                                        'status'                 => $status,
                                        'phone_number'           => $phone_number,
                                        'fax_number'             => $fax_number,
                                        'funeral_home_email'     => $funeral_home_email,
                                        'latitude'               => $latitude,
                                        'longitude'              => $longitude,
                                    )

                                );
                            }
                        }
                    } else {
                        echo 'Error uploading the CSV file.';
                    }
                }
            }
            // HTML for the import form
        ?>
<div class="wrap">
    <h2>Import Directory Posts from CSV</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="csv_file">Upload .CSV file:</label>
        <input type="file" name="csv_file" id="csv_file">
        <input type="submit" name="insert_directory_posts" class="button button-primary" value="Insert Posts">
    </form>
</div>
<?php
        }



        public static function directory_form_metabox()
        {
            add_meta_box('directory_form', 'Directory Form', [__CLASS__, 'directory_form_callback'], 'directory', 'normal', 'high');
        }

        public static function directory_form_callback($post)
        {
            echo '<style>
            /* Add your custom CSS styles here */
            label {
                font-weight: bold;
                display: block;
            }
            .your-form-container input[type="text"], .your-form-container input[type="email"], .your-form-container input[type="number"], .your-form-container select {        
                width: 100%;
                padding: 10px 15px !important;
                margin: 5px 0;
                box-sizing: border-box;
            }
            .your-form-container input[type="submit"] {
                margin-top: 15px !important;
                background-color: #0073e6;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }
            .your-form-container input[type="submit"]:hover {
                background-color: #005bb7;
            } 

            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }
            
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }
            
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }
            
            input:checked+.slider {
                background-color: #2271b1;
            }
            
            input:focus+.slider {
                box-shadow: 0 0 1px #2196F3;
            }
            
            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }
            .toggle_element {
                display: flex;
                align-items: center;
            }
            p.toggle_element > label {
                margin: 0 15px 0 0;
            }

        </style>';
            wp_nonce_field('directory_form_nonce', 'directory_form_nonce');

            $post_id               = get_the_ID();
            $post_display_status   = get_post_meta($post_id, 'post_display_status', true);
            $licence_no            = get_post_meta($post_id, 'licence_no', true);
            $establishment         = get_post_meta($post_id, 'establishment', true);
            $additional_name       = get_post_meta($post_id, 'additional_name', true);
            $address_1             = get_post_meta($post_id, 'address_1', true);
            $address_2             = get_post_meta($post_id, 'address_2', true);
            $city                  = get_post_meta($post_id, 'city', true);
            $region                = get_post_meta($post_id, 'region', true);
            $country               = get_post_meta($post_id, 'country', true);
            $postal_code           = get_post_meta($post_id, 'postal_code', true);
            $latitude              = get_post_meta($post_id, 'latitude', true);
            $longitude             = get_post_meta($post_id, 'longitude', true);
            $type                  = get_post_meta($post_id, 'type', true);
            $eventtype             = get_post_meta($post_id, 'eventtype', true);
            $status                = get_post_meta($post_id, 'status', true);
            $phone_number          = get_post_meta($post_id, 'phone_number', true);
            $fax_number            = get_post_meta($post_id, 'fax_number', true);
            $funeral_home_email    = get_post_meta($post_id, 'funeral_home_email', true);
        ?>
        <!-- Form Start-->


        <form id="address-form" action="" method="post" autocomplete="off">
            <div class="your-form-container">

                <p class="toggle_element">
                    <label for="post_display_status">Hide</label>
                    <label class="switch">
                        <input type="checkbox" name="post_display_status" <?php if ($post_display_status == 'on') echo "checked='checked'"; ?>>
                        <span class="slider"></span>
                    </label>
                    <label for="post_display_status">Show</label>
                </p>
                <p>
                    <label for="Licence No">Licence No:</label>
                    <input type="text" id="Licence No" name="licence_no" placeholder="Enter  Lincence No." value="<?php echo $licence_no; ?>"><br>
                </p>

                <p>
                    <label for="Establishment">Establishment:</label>
                    <input type="text" id="Establishment" name="establishment" placeholder="Enter Establishment" value="<?php echo $establishment; ?>">
                </p>
                <p>
                    <label for="Additional Name">Additional Name:</label>
                    <input type="text" id="Additional Name" name="additional_name" placeholder="Enter  Additional Name" value="<?php echo $additional_name; ?>"> 
                </p>
                <p>
                    <label for="Address 1">Address 1:</label>
                    <input type="text" id="address_1" autocomplete="off" name="address_1" value="<?php echo $address_1; ?>">
                </p>
                <p>
                    <label for="Address 2">Address 2:</label>
                    <input type="text" id="address_2" name="address_2" autocomplete="off" placeholder="Enter Second Location" value="<?php echo $address_2; ?>">
                </p>
                <p>  
                    <label for="City">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo $city; ?>" readonly>
                </p>
                <p>
                    <label for="Region">Region:</label>
                    <input type="text" id="region" name="region" value="<?php echo $region; ?>" readonly>
                </p>
                <p>
                    <label for="Country">Country:</label>
                    <input type="text" id="country" name="country" value="<?php echo $country; ?>" readonly>
                </p>
                <p>
                    <label for="Postal Code">Postal Code:</label>
                    <input type="text" id="postal_code" name="postal_code" value="<?php echo $postal_code; ?>" readonly>
                </p>
                <p>
                    <label for="latitude">latitude:</label>
                    <input type="text" id="latitude" name="latitude" value="<?php echo $latitude; ?>" readonly>
                </p>
                <p>
                    <label for="longitude">longitude:</label>
                    <input type="text" id="longitude" name="longitude" value="<?php echo $longitude; ?>" readonly>
                </p>
                <p>
                <label for="Type">Type:</label>
                <select name="type" id="type">
                    <option value="Public" <?php echo ($type == 'Public') ? 'selected' : ''; ?>>Public</option>
                    <option value="Non Public" <?php echo ($type == 'Non Public') ? 'selected' : ''; ?>>Non Public</option>
                </select>
                </p>
                <p>
                    <label for="eventtype">Event Type:</label>
                    <select name="eventtype" id="eventtype">
                        <option value="funeral_home" <?php echo ($eventtype == 'funeral_home') ? 'selected' : ''; ?>>Funeral
                            Home</option>
                        <option value="crematorium" <?php echo ($eventtype == 'crematorium') ? 'selected' : ''; ?>>Crematorium
                        </option>
                        <option value="transfer_service" <?php echo ($eventtype == 'transfer_service') ? 'selected' : ''; ?>>
                            Transfer Service</option>
                        <option value="others" <?php echo ($eventtype == 'others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                </p>
                <?php /*
                <p>
                    <label for="Status">Status:</label>
                    <select name="status" id="status">
                        <option value="Active" <?php echo ($status == 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="InActive" <?php echo ($status == 'InActive') ? 'selected' : ''; ?>>InActive</option>
                        <option value="Conditions of Licence"
                        <?php echo ($status == 'Conditions of Licence') ? 'selected' : ''; ?>>Conditions of Licence</option>
                    </select>
                </p>
                */?>
                <p>
                    <label for="Phone Number">Phone Number:</label>
                    <input type="text" id="Phone Number" name="phone_number" placeholder="Enter Phone Number" value="<?php echo $phone_number; ?>">
                </p>
                <p>
                    <label for="Fax Number">Fax Number:</label>
                    <input type="text" id="fax_number" name="fax_number" placeholder="Fax Number" value="<?php echo $fax_number; ?>">
                </p>
                <p>
                    <label for="Funeral Home Email">Funeral Home Email:</label>
                    <input type="email" id="Funeral Home Email" name="funeral_home_email" placeholder=" Enter Funeral Home Email" value="<?php echo $funeral_home_email; ?>">
                </p>
            </div>

            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUOLjm7aqPBDHVAdkX0Ehmqd9NAoZEp7A&callback=initAutocomplete&libraries=places"
                defer></script>
            <script>
                let autocomplete;
                let address1Field;
                let address2Field;
                let postalField;
                let longitude;
                let latitude;

                function initAutocomplete() {
                    address1Field = document.querySelector("#address_1");
                    address2Field = document.querySelector("#address_2");
                    postalField = document.querySelector("#postal_code");
                    longitudeField = document.querySelector("#longitude");
                    latitudeField = document.querySelector("#latitude");
                    autocomplete = new google.maps.places.Autocomplete(address1Field, {
                        componentRestrictions: {
                            country: ["IND", "AUS", "CAN"]
                        },
                        fields: ["address_components", "geometry"],
                        types: ["address"],
                    });
                    address1Field.focus();

                    autocomplete.addListener("place_changed", fillInAddress);
                }

                function fillInAddress() {

                    const place = autocomplete.getPlace();
                    let address1 = "";
                    let postcode = "";
                    let longitude = place.geometry.location.lat();
                    let latitude = longitude = place.geometry.location.lng();
                    for (const component of place.address_components) {

                        const componentType = component.types[0];
                        switch (componentType) {
                            case "street_number": {
                                address1 = `${component.long_name} ${address1}`;
                                break;
                            }
                            case "route": {
                                address1 += component.short_name;
                                break;
                            }
                            case "postal_code": {
                                postcode = `${component.long_name}${postcode}`;
                                break;
                            }
                            case "postal_code_suffix": {
                                postcode = `${postcode}-${component.long_name}`;
                                break;
                            }
                            case "locality":
                                document.querySelector("#city").value = component.long_name;
                                break;
                            case "administrative_area_level_1": {
                                document.querySelector("#region").value = component.short_name;
                                break;
                            }
                            case "country":
                                document.querySelector("#country").value = component.long_name;
                                break;
                        }
                    }
                    address1Field.value = address1;
                    postalField.value = postcode;
                    longitudeField.value = longitude;
                    latitudeField.value = latitude;
                    address2Field.focus();
                }
                window.initAutocomplete = initAutocomplete;
            </script>

        </form>

        <?php
        }
        public static function save_directory_form_data($post_id)
        {
            global $wpdb;

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }


            if (!isset($_POST['directory_form_nonce'])) {
                return;
            }


            if (!wp_verify_nonce($_POST['directory_form_nonce'], 'directory_form_nonce')) {
                return;
            }


            if (!current_user_can('edit_post', $post_id)) {
                return;
            }


            if ('directory' !== get_post_type($post_id)) {
                return;
            }
            $post_display_status = isset($_POST['post_display_status']) ? sanitize_text_field($_POST['post_display_status']) : 'off';
            $licence_no = isset($_POST['licence_no']) ? sanitize_text_field($_POST['licence_no']) : '';
            $establishment = isset($_POST['establishment']) ? sanitize_text_field($_POST['establishment']) : '';
            $additional_name = isset($_POST['additional_name']) ? sanitize_text_field($_POST['additional_name']) : '';
            $address_1 = isset($_POST['address_1']) ? sanitize_text_field($_POST['address_1']) : '';
            $address_2 = isset($_POST['address_2']) ? sanitize_text_field($_POST['address_2']) : '';
            $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
            $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : '';
            $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
            $postal_code = isset($_POST['postal_code']) ? sanitize_text_field($_POST['postal_code']) : '';
            $latitude = isset($_POST['latitude']) ? sanitize_text_field($_POST['latitude']) : '';
            $longitude = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : '';
            $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
            $eventtype = isset($_POST['eventtype']) ? sanitize_text_field($_POST['eventtype']) : '';
            $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
            $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
            $fax_number = isset($_POST['fax_number']) ? sanitize_text_field($_POST['fax_number']) : '';
            $funeral_home_email = isset($_POST['funeral_home_email']) ? sanitize_text_field($_POST['funeral_home_email']) : '';

            update_post_meta($post_id, 'post_display_status', $post_display_status);
            update_post_meta($post_id, 'licence_no', $licence_no);
            update_post_meta($post_id, 'establishment', $establishment);
            update_post_meta($post_id, 'additional_name', $additional_name);
            update_post_meta($post_id, 'address_1', $address_1);
            update_post_meta($post_id, 'address_2', $address_2);
            update_post_meta($post_id, 'city', $city);
            update_post_meta($post_id, 'region', $region);
            update_post_meta($post_id, 'country', $country);
            update_post_meta($post_id, 'postal_code', $postal_code);
            update_post_meta($post_id, 'latitude', $latitude);
            update_post_meta($post_id, 'longitude', $longitude);
            update_post_meta($post_id, 'type', $type);
            update_post_meta($post_id, 'eventtype', $eventtype);
            update_post_meta($post_id, 'status', $status);
            update_post_meta($post_id, 'phone_number', $phone_number);
            update_post_meta($post_id, 'fax_number', $fax_number);
            update_post_meta($post_id, 'funeral_home_email', $funeral_home_email);
            global $wpdb;
            $table_name = $wpdb->prefix . 'fd_directory';

            $is_exist = $wpdb->get_row("SELECT post_id FROM $table_name WHERE post_id = '$post_id' ");

            if(empty($is_exist)){

                $wpdb->insert(
                    $table_name,
                    array(
                        'post_id' => $post_id,
                        'post_display_status' => $post_display_status,
                        'licence_no' => $licence_no,
                        'establishment' => $establishment,
                        'additional_name' => $additional_name,
                        'address_1' => $address_1,
                        'address_2' => $address_2,
                        'city' => $city,
                        'region' => $region,
                        'country' => $country,
                        'postal_code' => $postal_code,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'type' => $type,
                        'eventtype' => $eventtype,
                        'status' => $status,
                        'phone_number' => $phone_number,
                        'fax_number' => $fax_number,
                        'funeral_home_email' => $funeral_home_email,
                    )
                );

            }


        }

        public static function update_directory_form_data($post_id)
        {

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }


            if (!isset($_POST['directory_form_nonce'])) {
                return;
            }


            if (!wp_verify_nonce($_POST['directory_form_nonce'], 'directory_form_nonce')) {
                return;
            }


            if (!current_user_can('edit_post', $post_id)) {
                return;
            }


            if ('directory' !== get_post_type($post_id)) {
                return;
            }
            $post_display_status = isset($_POST['post_display_status']) ? sanitize_text_field($_POST['post_display_status']) : 'off';
            $licence_no = isset($_POST['licence_no']) ? sanitize_text_field($_POST['licence_no']) : '';
            $establishment = isset($_POST['establishment']) ? sanitize_text_field($_POST['establishment']) : '';
            $additional_name = isset($_POST['additional_name']) ? sanitize_text_field($_POST['additional_name']) : '';
            $address_1 = isset($_POST['address_1']) ? sanitize_text_field($_POST['address_1']) : '';
            $address_2 = isset($_POST['address_2']) ? sanitize_text_field($_POST['address_2']) : '';
            $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
            $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : '';
            $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
            $postal_code = isset($_POST['postal_code']) ? sanitize_text_field($_POST['postal_code']) : '';
            $latitude = isset($_POST['latitude']) ? sanitize_text_field($_POST['latitude']) : '';
            $longitude = isset($_POST['longitude']) ? sanitize_text_field($_POST['longitude']) : '';
            $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
            $eventtype       = isset($_POST['eventtype']) ? sanitize_text_field($_POST['eventtype']) : '';
            $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
            $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
            $fax_number = isset($_POST['fax_number']) ? sanitize_text_field($_POST['fax_number']) : '';
            $funeral_home_email = isset($_POST['funeral_home_email']) ? sanitize_text_field($_POST['funeral_home_email']) : '';

            update_post_meta($post_id, 'post_display_status', $post_display_status);
            update_post_meta($post_id, 'licence_no', $licence_no);
            update_post_meta($post_id, 'establishment', $establishment);
            update_post_meta($post_id, 'additional_name', $additional_name);
            update_post_meta($post_id, 'address_1', $address_1);
            update_post_meta($post_id, 'address_2', $address_2);
            update_post_meta($post_id, 'city', $city);
            update_post_meta($post_id, 'region', $region);
            update_post_meta($post_id, 'country', $country);
            update_post_meta($post_id, 'postal_code', $postal_code);
            update_post_meta($post_id, 'latitude', $latitude);
            update_post_meta($post_id, 'longitude', $longitude);
            update_post_meta($post_id, 'type', $type);
            update_post_meta($post_id, 'eventtype', $eventtype);
            update_post_meta($post_id, 'status', $status);
            update_post_meta($post_id, 'phone_number', $phone_number);
            update_post_meta($post_id, 'fax_number', $fax_number);
            update_post_meta($post_id, 'funeral_home_email', $funeral_home_email);

            global $wpdb;
            $table_name = $wpdb->prefix . 'fd_directory';
            $data = array(
                'post_display_status' => $post_display_status,
                'licence_no' => $licence_no,
                'establishment' => $establishment,
                'additional_name' => $additional_name,
                'address_1' => $address_1,
                'address_2' => $address_2,
                'city' => $city,
                'region' => $region,
                'country' => $country,
                'postal_code' => $postal_code,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'type' => $type,
                'eventtype' => $eventtype,
                'status' => $status,
                'phone_number' => $phone_number,
                'fax_number' => $fax_number,
                'funeral_home_email' => $funeral_home_email,
            );
            $res = $wpdb->update(
                $table_name,
                $data,
                array('post_id' => $post_id)
            );
            
        }

        public static function delete_custom_data_on_post_trash($post_id)
        {
            global $wpdb;




            $post_type = get_post_type($post_id);

            if ($post_type === 'directory') {
                // Delete data from the post meta
                delete_post_meta($post_id, 'post_display_status');
                delete_post_meta($post_id, 'licence_no');
                delete_post_meta($post_id, 'establishment');
                delete_post_meta($post_id, 'additional_name');
                delete_post_meta($post_id, 'address_1');
                delete_post_meta($post_id, 'address_2');
                delete_post_meta($post_id, 'city');
                delete_post_meta($post_id, 'region');
                delete_post_meta($post_id, 'country');
                delete_post_meta($post_id, 'postal_code');
                delete_post_meta($post_id, 'latitude');
                delete_post_meta($post_id, 'longitude');
                delete_post_meta($post_id, 'type');
                delete_post_meta($post_id, 'eventtype');
                delete_post_meta($post_id, 'status');
                delete_post_meta($post_id, 'phone_number');
                delete_post_meta($post_id, 'fax_number');
                delete_post_meta($post_id, 'funeral_home_email');

                global $wpdb;
                $table_name = $wpdb->prefix . 'fd_directory';
            }
            $wpdb->delete($table_name, array('post_id' => $post_id));


            wp_delete_post($post_id);
        }
    }
    AVCoreBackendEnd::init();
}
        ?>