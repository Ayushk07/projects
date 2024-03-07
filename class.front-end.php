<?php
function scrolling_cards_shortcode($atts)
{
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    //wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '', true);
    global $wpdb;
    $table_name = $wpdb->prefix . 'fd_directory';
    $query = $wpdb->get_results("SELECT * FROM $table_name where post_display_status='on' AND state='Ontario'", ARRAY_A);
    $query2 = $wpdb->get_results("SELECT Distinct city,state FROM $table_name where post_display_status='on' AND state='Ontario'", ARRAY_A);
    $location = array();
    foreach ($query as $row) {
        $location[] = [
            $row['latitude'],
            $row['longitude'],
            $row['postal_code'],
            $row['phone_number'],
            esc_html($row['establishment']),
            esc_html($row['type']),
        ];
    }
    $location = json_encode($location);
    ob_start();
    $establishments = array();
    foreach ($query as $row) {
        $establishment_info = array(
            'establishment' => htmlspecialchars_decode(esc_html($row['establishment'])),
        );
        $establishments[] = $establishment_info;
    }
    $citystate = array();
    foreach ($query2 as $row) {
        $citystate_info = array(
            'city' => htmlspecialchars_decode(esc_html($row['city'])),
            'state' => htmlspecialchars_decode(esc_html($row['state'])),
        );
        $citystate[] = $citystate_info;
    }
?>
<script>
var citystatesArray = <?php echo json_encode($citystate); ?>;
var establishmentsArray = <?php echo json_encode($establishments); ?>;
jQuery(function($) {
    $("#address").autocomplete({

        source: function(request, response) {
            // filterCards()
            var term = request.term.toLowerCase();
            var combinedArray = establishmentsArray.concat(citystatesArray);
            var filteredEstablishments = combinedArray.filter(function(item) {
                return (
                    (item.establishment && item.establishment.toLowerCase().indexOf(
                        term) !== -1) ||
                    (item.city && item.city.toLowerCase().indexOf(term) !== -1) ||
                    (item.state && item.state.toLowerCase().indexOf(term) !== -1)
                );
            });
            response(filteredEstablishments.map(function(item) {
                var establishmentName = item.establishment;
                var cityName = item.city ? item.city : '';
                var stateName = item.state;
                var label = establishmentName;
                var label2 = cityName + ', ' + stateName;
                if (establishmentName && establishmentName.toLowerCase().indexOf(
                        term) !== -1) {
                    label = establishmentName;

                } else if (cityName && cityName.toLowerCase().indexOf(term) !== -1) {
                    label = cityName + ', ' + stateName;

                } else if (stateName && stateName.toLowerCase().indexOf(term) !== -1) {
                    label = cityName + ', ' + stateName;

                }
                return {
                    label: label,
                    value: label,
                    establishment: establishmentName,
                    city: cityName,
                    state: stateName
                };
            }));

        },

        autoFocus: true,
        open: function(event, ui) {
            $(".ui-autocomplete").css({
                'max-height': '200px',
                'overflow-y': 'auto',
                'border': '1px solid #ccc',
                'box-shadow': '0 4px 8px rgba(0, 0, 0, 0.1)',
                'background-color': '#fff',
                'padding': '5px',
                'z-index': '9999',
                'width': '305px',
            });
        },

        select: function(event, ui) {

            jQuery("#address").val(ui.item.label);

            filterCards(ui.item);
        }
    });

});
</script>
<style>
.top_location {
    display: flex;
    margin-left: auto;
    margin-right: auto;
    min-height: 2.25rem;
}

.footer {
    background-color: rgb(79 85 42);
    align-items: center;
    display: flex;
    justify-content: center;
    margin-left: auto;
    margin-right: auto;
    max-width: 1440px;
    min-height: 2.25rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    width: 100%;
}

.input-group mb-3 {
    display: flex;
    gap: 32px;
    flex-direction: column;
}

.map {
    height: 700px;
    position: relative;
    overflow: hidden;
}

.location-inputs {
    display: flex;
    justify-content: left;
    height: auto;
    /*min-height: 48px;
    max-height: 48px;*/
}

.input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
}

.card {
    border-left: none;
    border-right: none;
    border-top: none;
    background-color: #f9f9f9;

}

.card:hover {
    background-color: rgb(221, 227, 202);
}

.card-title,
.card-text {
    font-size: 22px;
    font-weight: 500;
    letter-spacing: -.02em;
    line-height: 28.8px;
    --tw-text-opacity: 1;
    font-family: P22 Mackinac Pro, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: -.02em;
    line-height: 21.6px;
    width: 100%;
}

.lable {
    font-family: P22 Mackinac Pro, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: -.02em;
    line-height: 120%;
    --tw-text-opacity: 1;
    color: rgb(77 73 52/var(--tw-text-opacity));
    font-family: P22 Mackinac Pro, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: -.02em;
    line-height: 120%;
    margin-top: 0.5rem;
}

.search {
    border-radius: 100px !important;
    border-width: 1px;
    display: flex;
    font-family: Helvetica Neue, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
}

#style-1::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
}

#style-1::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #555;
}

.highlighted-card {

    background-color: rgb(221, 227, 202);

}

.popup {

    display: none;
}

.search {
    justify-content: center;
}

button#call {
    font-size: smaller;
}

a.card-link.external-link {
    font-size: smaller;
}

button.call-btn {
    font-size: smaller;
}

.inline {
    padding-top: 30px;
    gap: 30px;
    display: inline-flex;
}

.call-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgb(79 85 42);
    background-color: var(--wp--preset--color--base);
    padding: 8px 16px;
    border: none;
    cursor: pointer;

}

.type {
    padding: 6px 20px;
    background-color: #f9f9f9;
    display: inline-flex;
}



.call-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgb(79 85 42);
    background-color: var(--wp--preset--color--base);
    border: none;
    padding: 8px 16px;
    cursor: pointer;

}

.call-icon {
    width: 20px;
    height: 20px;
    margin-right: 8px;
}

.call-btn1 {
    display: flex;
    align-items: left;
    background-color: var(--wp--preset--color--base);
    background-color: rgb(79 85 42);
    color: white;
    padding: 8px 16px;
    cursor: pointer;
    border: none;

}

/* .type,
.call-btn {
    border: 2px solid #dde3ca;
} */

.highlighted-card .type,
.highlighted-card .call-btn {
    /*border: 2px solid #f9f9f9;*/
}

.call-icon {
    width: 20px;
    height: 20px;
    margin-right: 8px;
}

.arrow {
    margin-left: 8px;
}

.tooltip {
    position: absolute;
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000;
    display: none;
}

p {
    font-family: Helvetica Neue, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;

}

.popup {
    display: none;
    position: absolute;
    top: 30%;
    left: 110px;
    font-family: Helvetica Neue, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    padding-bottom: 0.25rem;
    padding-top: 0.25rem;
    align-items: center;
    border-radius: 5px;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    z-index: 999;
}

#style-3 {
    scrollbar-width: auto;
    scrollbar-color: #c7c7c7 #f9f9f9;
}

#style-3::-webkit-scrollbar {
    width: 7px;
}

#style-3::-webkit-scrollbar-track {
    background: #ffffff;
}

#style-3::-webkit-scrollbar-thumb {
    background-color: #c7c7c7;
    border-radius: 15px;
    border: 3px none #ffffff;
}

p {
    font-size: 14px;
    color: rgb(87 87 87/var(--tw-text-opacity));
    font-weight: 400;
    font-family: Helvetica Neue, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
    cursor: pointer;
}

span.arrow {
    margin-left: 11px;
    gap: 6px;
}

#establishmentList {
    list-style: none;
    padding: 0;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px;
}

#establishmentList li {
    padding: 8px;
    cursor: pointer;
}

#establishmentList li:hover {
    background-color: #f0f0f0;
}

@media (max-width: 1400px) {
    .search {
        max-width: 100%;
        width: auto;
        height: 50px;
        display: flex;
        gap: 74px;
        display: flex;
        justify-content: center;
    }
}

@media (max-width: 992px) {
    .search {
        max-width: 100%;
        width: auto;
        height: 50px;
        display: flex;
        gap: 33px;
        display: flex;
        justify-content: center;
    }

    .card-body.card-title {
        font-size: 22px;
    }

    #map {
        width: 100%;
    }

    .SearchResultCard_results-container__wwjfb {
        gap: 20px;
    }

    .scrollbar.lable1 {
        font-size: 26px;
    }
}

@media (max-width: 767px) {
    .container.search {
        max-width: 100%;
        width: auto;
        height: 50px;
        display: flex;
        gap: 33px;
        display: flex;
        justify-content: center;
    }

    .card-body.card-title {
        font-size: 22px;
    }

    #map {
        width: 100%;
    }

    .SearchResultCard_results-container__wwjfb {
        gap: 20px;
    }

    .SearchBar_buttonBase__xtRfe {
        max-width: 100px;

    }

    .search.form-control {
        max-width: 100px;
        padding: 0.375rem 0.45rem;
    }

    .search.class1 {
        max-height: 45px;
    }

    .card-body.card-text {
        font-size: 14px;
    }

    .card-body.card-title {
        font-size: 20px;
    }

    .scrollbar.lable1 {
        font-size: 22px;
    }
}

img.call {
    max-height: 47px;
}

@media (max-width:767px) {

    .entry-content.wp-block-post-content.has-global-padding.is-layout-constrained.wp-block-post-content-is-layout-constrained {
        padding-left: 20px !IMPORTANT;
        padding-right: 20px !important;
    }

    .aem-GridColumn {
        margin-left: 0 !important;
    }

    .inline {
        padding-top: 10px;
    }

    input#address,
    input#postalCode {
        display: block !important;
        width: 100% !important;
        min-width: 100%;
    }

    .SearchResultCard_results-container__wwjfb {
        flex-direction: column-reverse;
        gap: 30px;

    }

    div#style-3 {
        width: 100% !IMPORTANT;
        max-width: 100%;
    }

    .input-group.mb-3 {
        width: 100%;
        max-width: 100%;
        min-width: 100%;
    }

    .search {
        flex-wrap: wrap;
        height: auto;
        gap: 10px;
    }

    .top_location {
        flex-wrap: wrap;
        height: auto !IMPORTANT;
        justify-content: center !important;
        align-items: center !important;
        padding: 10px 0px;
    }

}

.card.highlight {
    background-color: rgb(221, 227, 202);
}


.gm-style-iw {
    background-color: white;

    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    max-width: 200px;
}

.gm-style-iw h6 {
    margin-bottom: 5px;
    color: #333;
}

.gm-style-iw p {
    margin: 0;
    color: #666;
}

.gm-style-iw hr {
    border-top: 1px solid #ccc;
    margin: 5px 0;
}

.gm-style-iw .call-block1 {
    margin: 5px 0;
    color: #007bff;
    text-decoration: none;
    cursor: pointer;
    display: block;
}

.gm-style-iw .call-block1:hover {
    text-decoration: underline;
}

<?php $frontend_color=$stored_text['frontend_color'];

?>p#demo,
.top_location button {
    border-radius: inherit;
    color: #fff !important;

    padding: 6px 24px !important;
    border-radius: 36px !important;
    border: none;
}

.top_location {
    background: transparent;
    justify-content: end;
    width: 100% !important;
    max-width: 100%;
    min-width: 100%;
    gap: 24px;
}

.wp-block-site-logo img {
    height: auto;
    transform: scale(1.3);
    max-width: 100%;
}
</style>
<script>
var map;
var markers = [];
var infowindow;

function initialise() {
    var locations = JSON.parse('<?php echo $location; ?>');
    console.log(locations);
    var tooltipStyles = document.createElement("style");
    tooltipStyles.innerHTML = '.tooltip { max-width: 200px; }';
    document.getElementById("map").appendChild(tooltipStyles);
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(43.674192, -79.4591134),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    infowindow = new google.maps.InfoWindow();
    for (var i = 0; i < locations.length; i++) {
        createMarker(locations[i], i);
    }
}
document.addEventListener("DOMContentLoaded", function() {
    var cards = document.querySelectorAll('.card');
    console.log("element card", cards);
    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            var cardid = this.id.replace('card-', '');
            var marker = findMarkerByCardId(cardid);
            markers.forEach(function(otherMarker) {
                otherMarker.setIcon(null);
            });
            map.setZoom(15);
            map.panTo(marker.getPosition());
            // infowindow.setContent(marker.customData.contentString);
            // infowindow.open(map, marker);
            cards.forEach(function(otherCard) {
                otherCard.classList.remove('highlighted-card');
            });
            card.classList.add('highlighted-card');

        });
    });
});
var currentInfowindow = null;

function createMarker(locationData, index) {
    var cards = document.querySelectorAll('.card');
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(locationData[0], locationData[1]),
        map: map,
        title: locationData[4],
        customData: {
            cardid: index + 1,
            contentString: '<div class="tooltip">' +
                '<h6>' + locationData[4] + '</h6>' +
                '</div>',
        },
    });
    var tooltip = document.createElement("div");
    tooltip.className = "tooltip";
    tooltip.innerHTML = '<strong>' + locationData[4] + '</strong>';
    var infowindow = new google.maps.InfoWindow({
        content: tooltip.innerHTML,
    });
    marker.addListener('click', function() {
        if (currentInfowindow) {
            currentInfowindow.close();
        }


        infowindow.open(map, marker);
        currentInfowindow = infowindow;

        cards.forEach(function(otherCard) {
            otherCard.classList.remove('highlighted-card');
        });
        var cardid = 'card-' + marker.customData.cardid;
        console.log(cardid);
        var correspondingCard = document.getElementById(cardid);
        console.log(correspondingCard);
        correspondingCard.classList.add('highlighted-card');
        correspondingCard.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'start'
        });
    });

    markers.push(marker);
}

function findMarkerByCardId(cardid) {
    var cards = document.querySelectorAll('.card');
    return markers.find(function(marker) {
        return marker.customData.cardid == cardid;
    });
    google.maps.event.addListener(infowindow, 'closeclick', function() {
        markers.forEach(function(marker) {
            marker.setIcon(null);
        });

        cards.forEach(function(card) {
            card.classList.remove('highlighted-card');
        });
    });
}
</script>
<script>
jQuery(document).ready(function($) {
    (function($) {
        function closePopup($button) {
            var $popup = $button.closest('.card').find(".popup");
            var $arrow = $button.find(".arrow");

            $popup.hide();
            $arrow.text("▼");
        }
        $(".call-btn").click(function() {
            $(".popup").not($(this).closest('.card').find(".popup")).hide();
            var $popup = $(this).closest('.card').find(".popup");
            $popup.toggle();
            var $arrow = $(this).find(".arrow");
            $arrow.text($popup.is(":visible") ? "▲" : "▼");
            event.stopPropagation();
        });
        $(document).click(function(event) {
            if (!$(event.target).closest('.popup').length && !$(event.target).hasClass(
                    'call-btn')) {
                $(".popup").hide();
                $(".call-btn .arrow").text("▼");
            }
        });
    })(jQuery);
});
</script>
<script>
jQuery(document).ready(function($) {
    (function($) {
        $("#call").click(function() {
            window.location.href = 'tel:1-888-700-7766';
        });
    })(jQuery);
});
</script>

<script>
jQuery(document).ready(function($) {
    (function($) {
        $(".call-block").click(function() {
            var phoneNumber = $(this).data("phone");
            phoneNumber = phoneNumber.replace(/[^0-9]/g, '');
            if (phoneNumber.length > 0) {
                window.location.href = 'tel:' + phoneNumber;
            } else {
                console.error('Invalid phone number');
            }
        });
    })(jQuery);
});
</script>
<script>
jQuery(document).ready(function($) {
    (function($) {
        $(".call-block1").click(function() {
            var phoneNumber = $(this).data("phone");
            phoneNumber = phoneNumber.replace(/[^0-9]/g, '');
            if (phoneNumber.length > 0) {
                window.location.href = 'tel:' + phoneNumber;
            } else {
                console.error('Invalid phone number');
            }
        });
    })(jQuery);
});
</script>
<script>
function deleteCookie(name) {

    console.log('Cookie Deleted');
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

function getUserLocationforDirections() {
    // Delete previous cookies
    deleteCookie('userLat');
    deleteCookie('userLng');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Set cookies for user's latitude and longitude
                document.cookie = `userLat=${userLocation.lat}; expires=${new Date(9999, 0).toUTCString()}`;
                document.cookie = `userLng=${userLocation.lng}; expires=${new Date(9999, 0).toUTCString()}`;

                console.log('Location fetched for directions');
            },
            function(error) {
                console.error('Error getting user location for directions:', error);
            }
        );
    } else {
        alert('Geolocation is not supported by your browser');
    }
}

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Set cookies for user's latitude and longitude
                document.cookie = `userLat=${userLocation.lat}; expires=${new Date(9999, 0).toUTCString()}`;
                document.cookie = `userLng=${userLocation.lng}; expires=${new Date(9999, 0).toUTCString()}`;

                // Rest of your code
                map.setCenter(userLocation);
                map.setZoom(12);
                const marker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    // title: userLocation
                });
                getAddressFromCoordinates(userLocation, marker);
            },
            function(error) {
                console.error('Error getting user location:', error);
            }
        );
    } else {
        alert('Geolocation is not supported by your browser');
    }
}

function getAddressFromCoordinates(location, marker) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        location: location
    }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                const address = results[0].formatted_address;
                const tooltipContent = '<strong>Address:</strong> ' + address;
                const infowindow = new google.maps.InfoWindow({
                    content: tooltipContent
                });
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            } else {
                console.error('No results found');
            }
        } else {
            console.error('Geocoder failed due to: ' + status);
        }
    });
}
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCUOLjm7aqPBDHVAdkX0Ehmqd9NAoZEp7A&callback=initialise"
    type="text/javascript" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<div id="div" class="tooltip" style="display: none;"></div>
<div class="container" style="margin-top: 20px; width: 100%; height:auto;  max-width: 1600px;">
    <div class="top_location"
        style="max-width: 100%; width: auto; height: 50px; justify-content: right; align-items: center;gap: 20px;">
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
            $location_color = htmlspecialchars_decode($stored_text['location_color']);

            if ($location_value == 'on') { ?>
        <p onclick="getUserLocation()" id="demo"
            style="color:white; gap: 12px; margin: 0px; background-color: <?php echo $frontend_color; ?> ">
            <i class='fas fa-map-marker-alt' style='font-size:18px'></i>
            <?php echo $locationtext;  ?>
        </p>
        <?php 
            }
            if ($phone_value == 'on') { ?>
        <button class="call-btn1" id="call" data-phone=""
            style="font-size: none;gap:10px; background-color: <?php echo $frontend_color; ?> !important;">
            <i class='fas fa-phone-volume' style='font-size:18px'></i>
            <?php echo $phonetext;  ?><?php echo $phoneedit;  ?>

        </button>
        <?php 
            } ?>
    </div>
    <hr />
    <div class="search">
        <!-- <img class="call" src="/wp-content/plugins/avlabs-custom-make/front-end/classes/Arbor.png"> -->
        <input type="text" class="form-control" id="address" placeholder="Search or Select Establishment"
            style="flex: 1; margin: 5px 5px 5px 0;  border-radius: inherit; border-color: black; justify-content: space-evenly; box-shadow: 0 0 0 0.25rem #f9f9f9; background-color: #f9f9f9;">
        <input type="text" class="form-control" id="postalCode" placeholder="Postal Code / Address"
            style="flex: 1; margin: 5px;border-radius: inherit;border-color: black;justify-content: space-evenly; box-shadow: 0 0 0 0.25rem #f9f9f9;background-color: #f9f9f9;">
        <span id="invalidPostalCodeMessage" style="color: red; display: none;">Invalid postal code.</span>
        <input type="hidden" class="form-control" id="branch" placeholder="Branch"
            style="flex: 1; margin: 5px; border-radius: inherit;border-color: black;justify-content: space-evenly;box-shadow: 0 0 0 0.25rem #f9f9f9;background-color: #f9f9f9;">
        <button class="SearchBar_buttonBase__xtRfe SearchBar_buttonPrimary__6BiHC" id="search-btn"
            style="flex: 1; margin: 5px 0; max-width: 100px; border-radius: inherit; color: rgb(239 233 233);background-color: <?php echo $search_color; ?>">
            <?php echo $search_text;  ?></button>
    </div>
    <hr />
    <div class=" aem-GridColumn aem-GridColumn--default--12" style="margin-left:0px" ;>
        <div class="flex flex-col w-full">
            <div class="LocationFinder_search-bar-Container__gUrPS">
                <div
                    class="flex items-center justify-between w-full h-full space-x-6 lg:justify-start md:space-x-4 lg:space-x-0">
                    <div class="SearchResultCard_results-container__wwjfb" style="display: flex;justify-content: left;">

                        <div class="scrollbar" id="style-3" data-spy="scroll" data-target="#card" data-offset="0"
                            style="position: relative; overflow: auto; width:49%;">
                            <?php
                                global $wpdb;
                                $table_name = $wpdb->prefix . 'fd_directory';
                                $query1 = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
                                
                                ?>
                            <label id="result-count"
                                style="color:rgb(77, 73, 52);font-size: 16px;font-weight: 400;line-height: 166%; opacity: 1px;"
                                class="lable"><?php echo $query1; ?>
                                Results(s)
                            </label>
                            <br />
                            <lable id="result-count" class="lable1"
                                style=" font-family: P22 Mackinac Pro, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;font-size: 26px;color:rgb(77, 73, 52);font-size: 32px;font-weight: 500;">
                                Location(s) </lable>
                            <div class="SearchResultCard_cardContainer__Hgw-P SearchResultCard_selected__KpdAh"
                                style="height: 600px; ">
                                <div class="flex flex-col justify-center w-full h-full">
                                    <?php
                                        $count = 0;
                                        foreach ($query as $row) :
                                            $count++;
                                           
                                        ?>
                                    <div id="card-<?php echo esc_attr($count); ?>" class="card" style=""
                                        data-lat="<?php echo esc_attr($row['latitude']); ?>"
                                        data-lng="<?php echo esc_attr($row['longitude']); ?>">

                                        <div class="card-body">
                                            <h5 class="card-title"
                                                style="font-size: 24px; font-family: P22 Mackinac Pro,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji; color:rgb(87, 87 ,87);">
                                                <?php echo esc_html($row['establishment']); ?>
                                            </h5>
                                            <p class="card-text" class="card-text"
                                                style="font-size: 16px;font-style: normal;font-weight: 400;line-height: 166%;color:rgb(87, 87 ,87);">
                                                <?php echo esc_html($row['address_1']); ?>,
                                                <?php
                                                        echo esc_html($row['city']) . ', ' . esc_html($row['state']);

                                                        ?>,

                                                <?php echo esc_html($row['postal_code']); ?>
                                            </p>
                                            <div class="popup">
                                                <p>General inquiry?</p>
                                                <hr />
                                                <p class="call-block1"
                                                    data-phone="<?php echo esc_html($row['phone_number']); ?>">
                                                    Call Us at: <?php echo esc_html($row['phone_number']); ?></p>
                                                </p>
                                            </div>
                                            <div class="inline">
                                                <button class="call-btn" style="gap: 10px;"
                                                    data-phone="<?php echo esc_attr($row['phone_number']); ?>">
                                                    <i class='fas fa-phone-volume' style='font-size:18px'></i>
                                                    <!-- <img class="call-icon" src="/wp-content/plugins//Directory/front-end/classes/call-outbound-svgrepo-com.svg" alt="Call Icon"> -->
                                                    Call
                                                    <span class="arrow">&#9660;</span>
                                                </button>

                                            </div>
                                            <div class="type">
                                                <?php echo esc_html($row['type']); ?>
                                            </div>
                                            <div class="type">
                                                <a class="url_update"
                                                    style="text-decoration:none; color: rgb(77, 73, 52);"
                                                    href="http://maps.google.com<?php echo '/maps/dir/?api=1&origin=' . $_COOKIE['userLat'] .','. $_COOKIE['userLng'] .'&destination=' . esc_attr($row['latitude']) . ',' . esc_attr($row['longitude']); ?>"
                                                    target="_blank">Directions
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#4f552a" height="16"
                                                        width="16" viewBox="0 0 512 512">
                                                        <path
                                                            d="M502.6 233.3L278.7 9.4c-12.5-12.5-32.8-12.5-45.4 0L9.4 233.3c-12.5 12.5-12.5 32.8 0 45.4l223.9 223.9c12.5 12.5 32.8 12.5 45.4 0l223.9-223.9c12.5-12.5 12.5-32.8 0-45.4zm-101 12.6l-84.2 77.7c-5.1 4.7-13.4 1.1-13.4-5.9V264h-96v64c0 4.4-3.6 8-8 8h-32c-4.4 0-8-3.6-8-8v-80c0-17.7 14.3-32 32-32h112v-53.7c0-7 8.3-10.6 13.4-5.9l84.2 77.7c3.4 3.2 3.4 8.6 0 11.8z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <script>
                                            function delay() {
                                                var Element = document.querySelector(".url_update");
                                                var url = Element.getAttribute("href");
                                                Element.setAttribute("target", "_blank");
                                            }

                                            setTimeout(delay, 3000);
                                            </script>
                                        </div>
                                    </div>
                                    <br />

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div style="width:2%"></div>
                        <div class="input-group mb-3" style="display: flex;  flex-direction: column; width: 49%;">
                            <div class="location-inputs">
                            </div>
                            <div id="map"
                                style="height: 685px; position: relative; overflow: hidden; width: 100%; margin-top: 0px;">
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="footer" style="max-width: 100%; height: 100px; width: auto;"> -->
</div>
<script>
// jQuery(document).ready(function() {
//     var Element = document.querySelector(".url_update");
//     var url = Element.getAttribute("href");
//     if (window.onload) {
//         jQuery("url").setTimeout(3000);
//     }
// });

function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}
</script>
<script>
getUserLocationforDirections();

const postalCodeInput = document.getElementById("postalCode");
const branchInput = document.getElementById("branch");
const addressInput = document.getElementById("address");
const searchButton = document.getElementById("search-btn");
const cardsContainer = document.querySelector(".SearchResultCard_cardContainer__Hgw-P");
const resultCountLabel = document.getElementById("result-count");
// postalCodeInput.addEventListener("input", enableSearchButton);
// branchInput.addEventListener("input", enableSearchButton);
// addressInput.addEventListener("input", enableSearchButton);
const invalidPostalCodeMessage = document.getElementById("invalidPostalCodeMessage");

postalCodeInput.addEventListener("input", againhandleInputChange);
addressInput.addEventListener("input", againhandleInputChange);

function againhandleInputChange() {
    // enableSearchButton();
    filterCards();
}


// function enableSearchButton() {
//     const postalCodeValue = postalCodeInput.value.trim();
//     const branchValue = branchInput.value.trim();
//     const addressValue = addressInput.value.trim();
//     addressInput.disabled = false;
//     postalCodeInput.disabled = false;
//     branchInput.disabled = false;
//     invalidPostalCodeMessage.style.display = "none";
//     if (addressValue !== "") {
//         postalCodeInput.disabled = true;
//         branchInput.disabled = true;
//     } else if (postalCodeValue !== "" || branchValue !== "") {
//         addressInput.disabled = true;
//     }
// }

function extractPostalCodeFromResults(results) {
    const addressComponents = results[0].address_components;
    const postalCodeComponent = addressComponents.find(component => component.types.includes('postal_code'));
    return postalCodeComponent ? postalCodeComponent.long_name : '';
    console.log(addressComponents, postalCodeComponent);
}

function handleSearchInputChange() {
    filterCards();
}
searchButton.disabled = false;
searchButton.addEventListener("click", filterCards);

function updateResultCount(count) {
    resultCountLabel.textContent = count + " result(s) Location(s)";
}
let allCards = [];
let customMarkers = [];

function initializeCardsAndMarkers() {
    allCards = Array.from(document.querySelectorAll(".card"));
}
window.onload = function() {
    initializeCardsAndMarkers();
    handleUrlParameters();
    filterCardsFromUrl();
};
window.addEventListener('popstate', function(event) {
    handleUrlParameters();
    filterCards();
});
window.addEventListener('popstate', function(event) {
    handleUrlParameters();
});
addressInput.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        // handleEnterKey();
    }
});

searchButton.addEventListener('click', function() {
    handleSearchButtonClick();
});

function handleSearchButtonClick() {
    const newAddress = addressInput.value.trim().toLowerCase();
    const newUrl =
        `${window.location.origin}${window.location.pathname}?address=${encodeURIComponent(newAddress).replace(/%20/g, '+')}`;
    console.log('Updating URL with search button click:', newUrl);
    history.pushState({}, null, newUrl);
    filterCards();
}

function handleUrlParameters() {
    const urlParams = new URLSearchParams(window.location.search);
    const addressParam = urlParams.get('address');
    if (addressParam !== null) {
        const decodedAddress = decodeURIComponent(addressParam.replace(/\+/g, '%20'));
        addressInput.value = decodedAddress;
        // postalCodeInput.disabled = true;
        // branchInput.disabled = true;
        filterCards();
    }
}

function filterCardsFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const addressParam = urlParams.get('address');
    if (addressParam !== null) {
        const decodedAddress = decodeURIComponent(addressParam.replace(/\+/g, '%20'));
        addressInput.value = decodedAddress;
        // postalCodeInput.disabled = true;
        // branchInput.disabled = true;
        filterCards();
    }
}

function filterCards() {
    // addressInput.disabled = true;
    // postalCodeInput.disabled = true;
    // branchInput.disabled = true;

    const postalCode = postalCodeInput.value.trim().toLowerCase();
    const branch = branchInput.value.trim().toLowerCase();
    const address = addressInput.value.trim().toLowerCase();
    console.log('Filtering cards with:', postalCode, branch, address);

    const hasSearchCriteria = postalCode || address || branch;
    let count = 0;

    const cardContainer = document.querySelector(".SearchResultCard_cardContainer__Hgw-P");
    cardContainer.innerHTML = "";

    allCards.forEach(card => {
        const cardTitle = card.querySelector(".card-title").textContent.toLowerCase();
        const cardText = card.querySelector(".card-text").textContent.toLowerCase();

        const showCard =
            (!hasSearchCriteria ||
                (branch === "" || cardTitle.includes(branch) || cardText.includes(branch)) &&
                (address === "" || cardTitle.includes(address) || cardText.includes(address)) &&
                (postalCode === "" || cardText.includes(postalCode)));
        if (showCard) {
            card.style.display = "block";
            cardContainer.appendChild(card);
            count++;
        } else {
            card.style.display = "none";
        }
    });
    // if (hasSearchCriteria) {
    //     updateResultCount(count);

    // } else {

    //     updateResultCount(allCards.length);

    // }
    // if (hasSearchCriteria && count > 0) {
    //     updateMap(postalCode, address, branch);
    // } else {
    //     document.getElementById("result-count").innerHTML = "Not Result found";
    //     allCards.forEach(card => {
    //         card.style.display = "block";
    //         cardContainer.appendChild(card);
    //     });
    //     updateMap('', '', '');

    // }

    if (hasSearchCriteria && count > 0) {
        updateResultCount(count);
        updateMap(postalCode, address, branch);
    } else {
        if (count === 0) {
            document.getElementById("result-count").innerHTML = "No Results Found";
        } else {
            updateResultCount(allCards.length);
        }

        allCards.forEach(card => {
            card.style.display = "block";
            cardContainer.appendChild(card);
        });
        updateMap('', '', '');
    }
    // addressInput.disabled = false;
    // postalCodeInput.disabled = false;
    // branchInput.disabled = false;
    // const newUrl =
    //     `${window.location.origin}${window.location.pathname}?address=${encodeURIComponent(address).replace(/%20/g, '+')}`;
    // console.log('Updating URL:', newUrl);
    // history.pushState({
    //     lat: newLat,
    //     lng: newLng
    // }, null, newUrl);   
}

function updateMap(postalCode, address, branch) {
    const geocoder = new google.maps.Geocoder();
    const canadaCenter = {
        lat: 43.674192,
        lng: -79.4591134
    };
    const locationQuery = postalCode + ' ' + address || 'Canada';
    geocoder.geocode({
        address: locationQuery
    }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
            const result = results[0].geometry.location;
            const newLat = result.lat();
            const newLng = result.lng();
            map.setCenter({
                lat: newLat,
                lng: newLng
            });
            map.setZoom(15);
            const newUrl =
                `${window.location.origin}${window.location.pathname}?address=${encodeURIComponent(locationQuery).replace(/%20/g, '+')}`;
            console.log(newUrl);
            history.pushState({
                lat: newLat,
                lng: newLng
            }, null, newUrl);
        } else {
            map.setCenter(canadaCenter);
            map.setZoom(12);
        }
    });
}

function handleInputChange() {
    const newAddress = addressInput.value.trim().toLowerCase();
    const newUrl =
        `${window.location.origin}${window.location.pathname}?address=${encodeURIComponent(newAddress).replace(/%20/g, '+')}`;
    console.log('Updating URL with input change:', newUrl);
    history.pushState({}, null, newUrl);
}
</script>

<?php
    return ob_get_clean();
}
add_shortcode('scrolling_cards', 'scrolling_cards_shortcode');

function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-autocomplete');
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
