<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $dp_options, $product, $post;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' ); // カートに商品を入れた告知

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

?>


<article id="product-<?php the_ID(); ?>" <?php wc_product_class('single_product'); ?>>

	<div id="product_header" class="single_product_header">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' ); // 商品画像ギャラリー
		?>
		<div class="single_product_info">
			<?php echo wc_get_product_category_list( $product->get_id(), '', '<div class="single_product_meta">', '</div>' ); ?>
			<h1 class="single_product_title rich_font"><?php the_title(); ?></h1>
			<?php

				// rating
				if($dp_options['product_single_display_rating'] == 'display') woocommerce_template_single_rating();

				woocommerce_template_single_price();  // price

				woocommerce_template_single_excerpt(); // short-description

				echo '<div class="p-entry-product__cart single_product_cart">';
				woocommerce_template_single_add_to_cart(); // cart (type)
				echo '</div>';

			?>

			<!-- likeボタンを移動 add-to-cart/simple.php -->
			
		</div>
	</div><!-- END #product_header -->
	<?php

	// 本文
	echo '<div class="post_content single_product_content clearfix">';
	echo '<div class="single_product_content_start"></div>';
	the_content();
	echo '<div class="single_product_content_end"></div>';
	echo '</div>';

	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 */
	do_action( 'woocommerce_after_single_product_summary' );

	?>

</article>
<?php

	/**
	 * Hook: woocommerce_after_single_product.
	 *
	 * @hooked woocommerce_upsell_display - 15
	 */

	// 関連商品
	do_action( 'woocommerce_after_single_product' );

	// 最近チェックした商品
	get_template_part( 'wc/recentry-viewed-products' );
