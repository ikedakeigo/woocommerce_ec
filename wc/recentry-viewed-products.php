<?php

	global $dp_options, $post;

	// 商品ループに名称をセット
	wc_set_loop_prop('name', 'recentry-viewed-products');

	// 表示する商品数
	$product_num = (!is_mobile()) ? $dp_options['product_single_recentry_viewed_products_num'] : $dp_options['product_single_recentry_viewed_products_num_sp'];

	// チェックした商品のIDを格納
	$item_ids = null;
	if ( is_woocommerce_active() && isset( $_COOKIE['woocommerce_recently_viewed'] ) ) {

		$item_ids = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
		$item_ids = array_reverse( array_filter( array_map( 'absint', $item_ids ) ) );

		// チェックした商品のIDと現在の商品ページのIDが同一であれば、その商品のIDを削除
		$key = array_search( $post->ID, $item_ids );
		if ( false !== $key ) unset( $item_ids[$key] );

	};


	if($item_ids && $dp_options['show_product_single_recentry_viewed_products']){

?>
<section class="recentry_viewed_products">
	<div class="recentry_viewed_products_inner">
<?php

	$headline = $dp_options['product_single_recentry_viewed_products_headline'];
	if($headline){

?>
		<h2 class="recentry_viewed_products_heading rich_font"><span><?php echo esc_html($headline); ?></span></h2>
		<div class="slider_wrap">


			<!-- <div id="js-recentry-viewed-products" class="swiper"> -->

			<div class="products-slider">
<?php

	}

	// woocommerce_product_loop_start();

	$cnt = 0;
	foreach ( $item_ids as $item_id ) :
		$post = get_post( $item_id );
		if ( ! $post ) continue;

		setup_postdata( $post );
		echo '<div class="product-slide">';
		wc_get_template_part( 'content', 'product' );
		echo '</div>';
		$cnt++;
		if ( $cnt >= $product_num ) break;
	endforeach;

	// woocommerce_product_loop_end();

	unset( $item_id );
	wp_reset_postdata();

?>
			</div>
			<div class="swiper-button-prev swiper_arrow"></div>
			<div class="swiper-button-next swiper_arrow"></div>
		</div>
	</div>
</section>
<?php

	}else{
		echo '<div class="hide_recentry_viewed_products"></div>';
	}
	unset( $item_ids );
