<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}


// JavaScriptを追加して「テキスト」モードでsplitボタンを表示--------------------------------------------------------------------------------

function custom_quicktags_script() {
  if (wp_script_is('quicktags')) {
      wp_enqueue_script(
          'custom-quicktags',
          get_stylesheet_directory_uri() . '/js/custom-quicktags.js',
          array('quicktags')
      );
  }
}
add_action('admin_enqueue_scripts', 'custom_quicktags_script');




// クラシックエディタのボタンとプラグインを追加--------------------------------------------------------------------------------
function custom_mce_buttons_2($buttons) {
  array_push($buttons, 'split_tag_button');
  return $buttons;
}
add_filter('mce_buttons_2', 'custom_mce_buttons_2');

// JavaScriptを追加して「ビジュアル」モードで画像のsplitボタンを表示--------------------------------------------------------------------------------
function custom_mce_script($plugin_array) {
  $plugin_array['split_tag_script'] = get_stylesheet_directory_uri() . '/js/mce-button.js';
  return $plugin_array;
}
add_filter('mce_external_plugins', 'custom_mce_script');


// ショートコードを追加--------------------------------------------------------------------------------
function capture_test_text_shortcode($atts, $content = null) {
  return '<div class="test-text">' . do_shortcode($content) . '</div>';
}
add_shortcode('test-text', 'capture_test_text_shortcode');

function capture_test_bottom_shortcode($atts, $content = null) {
  return '<div class="test-bottom">' . do_shortcode($content) . '</div>';
}
add_shortcode('test-bottom', 'capture_test_bottom_shortcode');


// カスタム投稿の作成 --------------------------------------------------------------------------------
function custom_woocommerce_pages_post_type() {
  $labels = array(
      'name'               => _x('WooCommerce Pages', 'post type general name'),
      'singular_name'      => _x('WooCommerce Page', 'post type singular name'),
      'add_new'            => _x('新規追加', 'book'),
      'add_new_item'       => __('Add New WooCommerce Page'),
      'edit_item'          => __('Edit WooCommerce Page'),
      'new_item'           => __('New WooCommerce Page'),
      'all_items'          => __('固定ページ一覧'),
      'view_item'          => __('View WooCommerce Page'),
      'search_items'       => __('Search WooCommerce Pages'),
      'not_found'          => __('No WooCommerce pages found'),
      'not_found_in_trash' => __('No WooCommerce pages found in the Trash'),
      'menu_name'          => 'WooCommerce Pages'
  );
  $args = array(
      'labels'        => $labels,
      'description'   => 'Holds our WooCommerce custom pages',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
      'has_archive'   => true,
  );
  register_post_type('woocommerce_page', $args);
}
add_action('init', 'custom_woocommerce_pages_post_type');


// テキスト投稿の固定ページの生成 （起動後以下コメントアウト＆削除）--------------------------------------------------------------------------------
function create_woocommerce_pages(){
  if (!get_page_by_title('ダッシュボード（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => 'ダッシュボード（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

  if (!get_page_by_title('注文（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => '注文（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

  if (!get_page_by_title('決済方法（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => '決済方法（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

  if (!get_page_by_title('住所（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => '住所（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

  if (!get_page_by_title('アカウント詳細（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => 'アカウント詳細（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

  if (!get_page_by_title('ログアウト（テキスト）', OBJECT, 'woocommerce_page')){
    wp_insert_post([
      'post_title' => 'ログアウト（テキスト）',
      'post_status' => 'publish',
      'post_type' => 'woocommerce_page',
    ]);
  }

}
add_action('after_setup_theme', 'create_woocommerce_pages');




// 以下必要がなければ削除してください--------------------------------------------------------------------------------

// メニューバーに表示
add_filter( 'woocommerce_account_menu_items', 'custom_woocommerce_account_menu_items' );

function custom_woocommerce_account_menu_items( $items ) {
    // 新しい順序でメニューアイテムを再配置
    $new_order = array(
        'dashboard'       => $items['dashboard'],       // ダッシュボード
        'orders'          => $items['orders'],          // 注文
        'edit-address'    => $items['edit-address'],    // 住所
        'payment-methods' => $items['payment-methods'], // 決済方法
        'edit-account'    => $items['edit-account'],    // アカウント詳細
        'customer-logout' => $items['customer-logout'], // ログアウト
    );

    return $new_order;
}

// 決済方法のラベルを追加
add_filter( 'woocommerce_account_menu_items', 'custom_woocommerce_account_menu_items_label' );

function custom_woocommerce_account_menu_items_label( $items ) {
    // 決済方法のラベルを設定
    $items['payment-methods'] = __('決済方法', 'woocommerce');

    return $items;
}
