// In this example the ACF custom field is "packsize"
// Display 'packsize' after product title on archive pages (shop, categories and tags pages)
function display_packsize_after_title() {
    global $product;
    
    // Get ACF field for packsize
    $packsize = get_field('packsize', $product->get_id()); 
    
    if ($packsize) {
		echo '<p class="pack-size one"><span>Pack Size:</span> ' . esc_html($packsize) . '</p>';
    }
}


/**************  Display 'packsize' after product title on the cart page ****************/

add_filter('woocommerce_cart_item_name', 'add_packsize_after_title_cart', 10, 3);
function add_packsize_after_title_cart($product_name, $cart_item, $cart_item_key) {
    if (is_cart()) { // Ensure this only affects the cart page
        $product_id = $cart_item['product_id'];
        $packsize = get_field('packsize', $product_id); // Get the ACF field

        if ($packsize) {
            $product_name .= '<p class="pack-size three"><span>Pack Size:</span> ' . esc_html($packsize) . '</p>';
        }
    }

    return $product_name;
}


/**************  Display 'packsize' after product title on the checkout page ****************/

add_filter('woocommerce_checkout_cart_item_quantity', 'add_packsize_to_checkout', 10, 3);
function add_packsize_to_checkout($item_name, $cart_item, $cart_item_key) {
    $product_id = $cart_item['product_id'];
    $packsize = get_field('packsize', $product_id); // Get ACF field
    
    if ($packsize) {
        $item_name .= '<p class="pack-size three"><span>Pack Size:</span> ' . esc_html($packsize) . '</p>';
    }
    return $item_name;
}

/**************  Display 'packsize' after product Quantity on the order received page ****************/

addd_filter('woocommerce_order_item_quantity_html', 'add_packsize_after_quantity', 10, 2);
function add_packsize_after_quantity($quantity_html, $item) {
    $product_id = $item->get_product_id();
    $packsize = get_field('packsize', $product_id); // Get the ACF field

    if ($packsize) {
        $quantity_html .= '<p class="pack-size three"><span>Pack Size:</span> ' . esc_html($packsize) . '</p>';
    }

    return $quantity_html;
}


/**************  Add 'packsize' to the completed order email (when user will get the order will be complete email notification) ****************/
function add_packsize_to_order_email($order, $sent_to_admin, $plain_text, $email) {
    if ($email->id === 'customer_completed_order') { // Only for completed order emails
        foreach ($order->get_items() as $item_id => $item) {
            $product_id = $item->get_product_id();
            $packsize = get_field('packsize', $product_id); // Get ACF field
            
            if ($packsize) {
                echo '<p><strong>Pack Size:</strong> ' . esc_html($packsize) . '</p>';
            }
        }
    }
}
add_action('woocommerce_email_order_details', 'add_packsize_to_order_email', 20, 4);
