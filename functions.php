<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

// Slick Slider のスクリプト--------------------------------------------------------------------------------
function enqueue_slick_assets() {
  // Slick CSS
  wp_enqueue_style( 'slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );

  // Slick Theme CSS (デフォルトのテーマ。必要に応じて追加)
  wp_enqueue_style( 'slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css' );

  // Slick JS
  wp_enqueue_script( 'slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true );

  }
  add_action( 'wp_enqueue_scripts', 'enqueue_slick_assets' );

  function enqueue_custom_scripts() {
    wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery', 'slick-js'), null, true );

    // PHP 変数を JavaScript に渡す
    wp_localize_script('custom-scripts', 'themeVars', array(
      'themeUrl' => get_stylesheet_directory_uri()
  ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts', 20 );


// custom-slider.cssの読み込み--------------------------------------------------------------------------------

function enqueue_custom_slider_assets() {
  wp_enqueue_style( 'custom-slider-css', get_stylesheet_directory_uri() . '/assets/css/custom-slider.css');
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_slider_assets');

// custom-product.cssの読み込み--------------------------------------------------------------------------------
function enqueue_custom_product_assets(){
  wp_enqueue_style( 'custom-product-css', get_stylesheet_directory_uri() . '/assets/css/custom-product.css');
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_product_assets');

// 画像パス--------------------------------------------------------------------------------
function custom_styles() {
  ?>
  <style>
      .recentry_viewed_products .swiper-button-next:after {
          content: "";
          background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/y.svg');
      }
      .recentry_viewed_products .swiper-button-prev:after {
          content: "";
          background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/y.svg');
          transform: scaleX(-1);
      }
  </style>
  <?php
}
add_action('wp_head', 'custom_styles');


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


// jsでテキストの修正--------------------------------------------------------------------------------

function custom_editor_script(){
  wp_enqueue_script(
    'custom-editor',
    get_stylesheet_directory_uri() . '/js/custom-editor.js',
    array('jquery')
  );
}
add_action('admin_enqueue_scripts', 'custom_editor_script');


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
      'name'               => _x('commerce Pages', 'post type general name'),
      'singular_name'      => _x('commerce Page', 'post type singular name'),
      'add_new'            => _x('新規追加', 'book'),
      'add_new_item'       => __('Add New commerce Page'),
      'edit_item'          => __('Edit commerce Page'),
      'new_item'           => __('New commerce Page'),
      'all_items'          => __('固定ページ一覧'),
      'view_item'          => __('View commerce Page'),
      'search_items'       => __('Search commerce Pages'),
      'not_found'          => __('No commerce pages found'),
      'not_found_in_trash' => __('No commerce pages found in the Trash'),
      'menu_name'          => 'commerce Pages'
  );
  $args = array(
      'labels'        => $labels,
      'description'   => 'Holds our commerce custom pages',
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


// ダッシュボードの名前変更-10/18
function change_tcd_menu_label() {
  global $menu;
  foreach ($menu as $key => $val) {
      if ('TCDテーマ' == $val[0]) {
          $menu[$key][0] = 'テーマ';
    }elseif('WooCommerce' == $val[0]){
      $menu[$key][0] = 'commerce';
    }
  }
}
add_action('admin_menu', 'change_tcd_menu_label', 999);

// TCDマニュアル-メニューの削除-10/18
function remove_menus() {
  remove_submenu_page( 'index.php', 'index.php?page=theme_manual'  ); // ダッシュボード / ホーム

}
add_action( 'admin_menu', 'remove_menus', 999 );


function hide_theme_update_menu() {
  echo '<style>
      #menu-dashboard .wp-submenu li a[href="index.php?page=theme_manual"] {
          display: none !important;
      }
  </style>';
}
add_action('admin_head', 'hide_theme_update_menu');

// ファイル追加--------------------------------------------------------------------------------

$file_path = get_stylesheet_directory() . '/js/custom-editor.js';
if ( ! file_exists( $file_path ) ) {
    touch( $file_path );
}




// AJAXリクエスト--------------------------------------------------------------------------------
// add_action( 'wp_ajax_my_ajax_action', 'my_ajax_action_function' ); // ログインユーザーのため
// add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_action_function' ); // ログインしていないユーザーのため

// function my_ajax_action_function() {


//   // リクエストから必要な情報を取得
//   $post_type = $_POST['post_type'] ?? 'post'; // デフォルトは 'post'
//   $get_post_num = intval($_POST['get_post_num'] ?? 0);
//   $now_post_num = intval($_POST['now_post_num'] ?? 0);

//   // WP_Queryを使用して投稿を取得
//   $args = array(
//       'post_type' => $post_type,
//       'posts_per_page' => $get_post_num,
//       'offset' => $now_post_num
//   );
//   $query = new WP_Query($args);

//   $posts_data = array();

//   if ($query->have_posts()) {
//     while ($query->have_posts()) {
//         $query->the_post();
//         $post_id = get_the_ID(); // 現在の投稿IDを取得

//         // WooCommerceの価格情報を取得
//         $price = get_post_meta($post_id, '_price', true);
//         $formatted_price = wc_price($price);  // WooCommerceの関数を使って価格を整形

//         // ここで各投稿のデータを取得・整形
//         $posts_data[] = array(
//             'title' => get_the_title(),
//             'content' => get_the_content(),
//             'permalink' => get_permalink(),
//             'price' => $formatted_price,  // 価格を追加
//             'post_id' => $post_id, // 投稿IDを追加
//             // 必要に応じて他のデータを追加
//         );
//     }
//     wp_reset_postdata();
//   }

//   // JSON形式でデータを返す
//   // echo json_encode($posts_data);
//   wp_send_json($posts_data);
//   // 忘れずに終了
//   wp_die();
// }



// function enqueue_my_scripts() {
//   // スクリプトを登録 & エンキュー
//   wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery'), null, true);

//   $args = array(
//       'post_type' => 'product',
//       'post_status' => 'publish',
//       'posts_per_page' => -1
//   );
//   $query = new WP_Query($args);
//   $total_posts = $query->found_posts;

//   // localize script
//   wp_localize_script('custom-scripts', 'myLocalizedData', array(
//       'total_posts' => $total_posts
//   ));

//   wp_reset_postdata();  // Reset the query
// }
// add_action('wp_enqueue_scripts', 'enqueue_my_scripts');
