<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

global $dp_options;
if ( ! $dp_options ) $dp_options = get_design_plus_options();

$queried_object = get_queried_object();

get_header( 'shop' );
?>
<main id="product_archive" class="l-main">
	<div class="l-inner inner">
<?php

if ( is_shop() || is_post_type_archive( 'product' ) || is_product_taxonomy() ) {
	get_template_part( 'template-parts/archive-header' );
};

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

if ( woocommerce_product_loop() ) :

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked tcd_woocommerce_archive_category_sort_filter - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
?>
			<div id="js-product-archive" data-base-url="<?php echo esc_attr( is_product_taxonomy() ? get_term_link( $queried_object ) : get_post_type_archive_link( 'product' ) ); ?>">
<?php
	// load template woocommerce/loop/loop-start.php
	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) :
		while ( have_posts() ) :
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		endwhile;
	endif;

	// load template woocommerce/loop/loop-end.php
	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );

?>
			</div>
<?php
else :
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
endif;

/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	// do_action( 'woocommerce_sidebar' );

?>
	</div>
</main>
<?php
get_footer( 'shop' );
