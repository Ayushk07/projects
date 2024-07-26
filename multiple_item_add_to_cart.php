add_action( 'woocommerce_cart_contents', 'customize_cart_item_display' );
function customize_cart_item_display() {
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
    $total_price = 0;
    $total_items = 0;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
            $item_price = $cart_item['quantity'] * $_product->get_price();
            $total_price += $item_price;
            $total_items += $cart_item['quantity'];
            echo '
            <style>
                .custom-cart-item {
                    display: flex;
                    margin-bottom: 20px;
                    padding-bottom: 20px;
                }
                .item_title {
                    margin-right: 20px;
                }
                .product-title {
                    margin: 0;
                    font-size: 18px;
                }
                .wrap-image {
                    display: flex;
                    align-items: center;
                }
                .product-thumbnail {
                    flex: 0 0 auto;
                    margin-right: 20px;
                    width: 100px; 
                    height: 100px; 
                }
                .product-thumbnail img {
                    width: 100%;
                    height: auto;
                }
                .product-quantity-price {
                    display: flex;
                    align-items: center;
                    margin-top: 10px;
                }
                .counter {
                    width: 100px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }
                .counter input {
                    width: 40px;
                    text-align: center;
                    font-size: 16px;
                    padding: 5px;
                    border: 1px solid #ccc;
                    border-radius: 3px;
                }
                .counter span {
                    cursor: pointer;
                    padding: 5px;
                    background-color: #f0f0f0;
                    border: 1px solid #ccc;
                    border-radius: 3px;
                }
                .price_per_unit {
                    margin-left: 20px;
                }
                .overall_totals {
                    margin-top: 20px;
                    // padding: 20px;
                    // background-color: #f9f9f9;
                    // border: 1px solid #eee;
                }
                .overall_totals p {
                    margin: 0;
                    font-size: 16px;
                }
                .total_price_description {
                    font-style: italic;
                    font-size: 14px;
                    margin-top: 5px;
                    display: block;
                }
                
                table.shop_table.shop_table_responsive.cart.woocommerce-cart-form__contents {
                    display: none;
                }
                .coupon {
                    margin-top: 20px;
                }
                .coupon .apply_coupon {
                    display: flex;
                    align-items: center;
                }
                .coupon .input-text {
                    width: 200px;
                    padding: 5px;
                    margin-right: 10px;
                    border: 1px solid #ccc;
                    border-radius: 3px;
                }
                .coupon button {
                    padding: 5px 10px;
                    background-color: #007cba;
                    color: #fff;
                    border: none;
                    border-radius: 3px;
                    cursor: pointer;
                }
                .coupon button:hover {
                    background-color: #005f79;
                }
                button[name="update_cart"] {
                    margin-top: 10px;
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 3px;
                    cursor: pointer;
                }
                button[name="update_cart"]:hover {
                    background-color: #45a049;
                }
                p.Subtotal {
                    border-bottom: 1px solid #eee;
                }
                p.terms-and-conditions {
                    padding-top: 40px;
                }
            </style>';
            echo '
            <script>
            jQuery(function($) {
                $(".counter .up").click(function() {
                    var input = $(this).prev("input");
                    var value = parseInt(input.val(), 10);
                    value = isNaN(value) ? 0 : value;
                    input.val(value + 1);
                    updateCartItem(input);
                });

                $(".counter .down").click(function() {
                    var input = $(this).next("input");
                    var value = parseInt(input.val(), 10);
                    if (value > 1) {
                        value = isNaN(value) ? 0 : value;
                        input.val(value - 1);
                        updateCartItem(input);
                    }
                });

                function updateCartItem(input) {
                    var cart_item_key = input.attr("name").replace(/cart\[(.*?)\]\[qty\]/g, "$1");
                    var new_quantity = parseInt(input.val());
                    $.ajax({
                        type: "POST",
                        url: "' . admin_url( 'admin-ajax.php' ) . '",
                        data: {
                            action: "unwynd_update_cart_item_qty",
                            cart_item_key: cart_item_key,
                            quantity: new_quantity,
                        },
                        success: function(response) {
                            if (response.success) {
                                $(".Subtotal").html("Subtotal: $" + response.data.total_price);
                                $(".TotalPrice").html("Total price: $" + response.data.total_price);
                                $(".total_price_description").html("*Including package & shipping, as well as value added tax.");
                                $(".terms-and-conditions").html("Any order request implies acceptance of our <a href=\"#\" target=\"_blank\">Terms &amp; Conditions</a>. Find out more about our processing of your data in our <a href=\"#\" target=\"_blank\">Privacy Policy</a>.");
                            } else {
                                console.log("Error updating cart item quantity");
                            }
                        }
                    });
                }
            });
            </script>';
            echo '<div class="product-remove">';
            echo '<a href="' . esc_url( wc_get_cart_remove_url( $cart_item_key ) ) . '" class="remove" aria-label="' . esc_attr__( 'Remove this item', 'woocommerce' ) . '" data-product_id="' . esc_attr( $cart_item['product_id'] ) . '" data-product_sku="' . esc_attr( $_product->get_sku() ) . '">';
            echo '<span class="remove_icon ahfb-svg-iconset ast-inline-flex"><svg class="remove-icon-extra ast-mobile-svg ast-close-svg" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path></svg></span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="custom-cart-item">';
            echo '<div class="item_title_quantity"><div class="item_title"><h3 class="item">Item</h3><h2 class="product-title">' . $_product->get_name() . '</h2></div>';
            echo '<div class="wrap-image"><div class="product-quantity-price">';
            echo '<div class="counter">
                    <span class="down">-</span>
                    <input type="text" name="cart[' . $cart_item_key . '][qty]" value="' . $cart_item['quantity'] . '" min="1">
                    <span class="up">+</span>
                  </div>';
            echo '<div class="price_per_unit"><p class="product-price">Price per unit: ' . wc_price( $_product->get_price() ) . '</p></div>';
            echo '</div></div>';
            echo '</div>'; 
            echo '<div class="product-thumbnail">';
            echo $_product->get_image(); 
            echo '</div>';
            echo '</div>'; 
        }
    }

    // Display overall coupon form 
    echo '<div class="coupon">';
    echo '<label for="coupon_code" class="screen-reader-text">Coupon:</label>';
    echo '<div class="apply_coupon">';
    echo '<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Coupon code">';
    echo '<button type="submit" class="button" name="apply_coupon" value="Apply coupon">Apply coupon</button>';
    echo '</div></div>';

    // Display overall totals and update cart button
    echo '<div class="overall_totals">';
    echo '<p class="Subtotal">Subtotal: '. wc_price( $total_price ) .'</p>';
    echo '<p class="TotalPrice">Total price: ' . wc_price( $total_price ) . '</p>';
    echo '<span class="total_price_description">*Including package & shipping, as well as value added tax.</span>';
    echo '</div>';
    echo '<p class="terms-and-conditions">Any order request implies acceptance of our <a href="#" target="_blank">Terms &amp; Conditions</a>. Find out more about our processing of your data in our <a href="#" target="_blank">Privacy Policy</a>.</p>';
    echo '<button type="submit" class="button" name="update_cart" value="Update cart">Proceed</button>';
   
    // Nonce and referer
    echo '<input type="hidden" id="woocommerce-cart-nonce" name="woocommerce-cart-nonce" value="' . wp_create_nonce( 'woocommerce-cart' ) . '">';
    echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wc_get_cart_url() ) . '">';
}

// AJAX handler function
add_action('wp_ajax_unwynd_update_cart_item_qty', 'unwynd_update_cart_item_qty');
add_action('wp_ajax_nopriv_unwynd_update_cart_item_qty', 'unwynd_update_cart_item_qty');

function unwynd_update_cart_item_qty() {
    $cart_item_key = sanitize_key($_POST['cart_item_key']);
    $quantity = (int)$_POST['quantity'];
    WC()->cart->set_quantity($cart_item_key, $quantity);

    // Get updated cart totals and item details
    $cart_totals = WC()->cart->get_totals();
    $total_price = $cart_totals['total'];
    $total_items = WC()->cart->get_cart_contents_count();
    $item = WC()->cart->get_cart_item($cart_item_key);
    $item_price = $item['line_total'];

    // Return JSON response
    wp_send_json_success(array(
        'total_price' => $total_price,
        'total_items' => $total_items,
        'item_price' => $item_price,
    ));
}

