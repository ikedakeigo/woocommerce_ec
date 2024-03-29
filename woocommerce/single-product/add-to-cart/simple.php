<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

// global $product;
global $dp_options, $product, $post;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) :

do_action( 'woocommerce_before_add_to_cart_form' );

?>
<form class="cart product-type-simple" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
<?php

	do_action( 'woocommerce_before_add_to_cart_button' );
	do_action( 'woocommerce_before_add_to_cart_quantity' );

?>
	<div class="quantity single_product_quantity">
		<span class="single_product_quantity_label"><?php _e( 'Quantity', 'woocommerce' ); ?></span>
		<div class="single_product_quantity_button">
			<span class="single_product_quantity_decrease js-single-quantity-decrease"></span>
<?php

	woocommerce_quantity_input( array(
		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	) );

?>
			<span class="single_product_quantity_increase js-single-quantity-increase"></span>
		</div>
	</div>
<?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>
	<div class="woocommerce__button-flex">
		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_product_cart_button single_add_to_cart_button">
		<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>
		<button id="js-single-product-like-button" class="single_product_like js-product-toggle-like<?php if ( is_liked( $post->ID ) ) echo ' is-liked'; ?>" data-post-id="<?php echo $post->ID; ?>">
					<span class="single_product_like_add"><?php echo esc_html($dp_options['product_single_wishlist_label']); ?></span>
					<span class="single_product_like_delete"><?php echo esc_html($dp_options['product_single_wishlist_label_add']); ?></span>
				</button>
	</div>
<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

</form>

<?php

do_action( 'woocommerce_after_add_to_cart_form' );

endif;
