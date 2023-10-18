jQuery(function($){

/**
 *  ソートフィルターやajax処理等をここにまとめる
 */


var $body = $('body');


// New ajax
var productArchive = $('#js-product-archive');
if (productArchive.length) {


  // ソート・フィルターのドロップダウン表示
  $('.p-archive03__sort-filter__item .p-archive03__sort-filter__item-title').on('click', function() {

    var $cl = $(this).closest('.p-archive03__sort-filter__item');
    if ($cl.hasClass('is-active')) {
      $cl.removeClass('is-active');
      $body.off('click.hide-sort-filter-dropdown');
    } else {
      $cl.siblings('.is-active').removeClass('is-active');
      $cl.addClass('is-active');
      $body.on('click.hide-sort-filter-dropdown', function(){
        $cl.removeClass('is-active');
      });
    }

    return false;
  });


  // ソート・フィルター変更時のページ遷移
  $('.js-product-archive__sort li, .js-product-archive__stock li').on('click', function() {

    var baseUrl = productArchive.attr('data-base-url');
    var parent = $(this).parent();
    var sortValue;
    var stockValue;

    if(parent.hasClass('js-product-archive__sort')) {
      sortValue = $(this).attr('data-value') || null;
      stockValue = $('.js-product-archive__stock .is-active').attr('data-value') || null;
    }else if(parent.hasClass('js-product-archive__stock')){
      sortValue = $('.js-product-archive__sort .is-active').attr('data-value') || null;
      stockValue = $(this).attr('data-value') || null;
    }

    if (sortValue) {
      baseUrl += (baseUrl.indexOf('?') > -1) ? '&' : '?';
      baseUrl += 'orderby=' + sortValue;
    }

    if (stockValue) {
      baseUrl += (baseUrl.indexOf('?') > -1) ? '&' : '?';
      baseUrl += 'stock=' + stockValue;
    }

    window.location.href = baseUrl;
    return false;

  });



  var $itemArchive = $('#js-product-archive');
  $('#js-ajax-loading-button').on('click', function() {

    var $this = $(this);
    var $cl = $this.parent();
    var maxNum = parseInt($this.attr('data-max-page-num'));
    var currentNum = parseInt( $this.attr('data-current-page-num') ) + 1;
    var loadUrl = PAGE_LINKS[currentNum]; // php配列

    $this.css('display', 'none');
    $cl.addClass('is_loading');

    // undefinedで読み込み終了
    if(loadUrl != undefined) {

      $.ajax({
        url: loadUrl,
        type: 'GET',
        data: {},
        success: function(data, textStatus, XMLHttpRequest) {

          if(!$this.hasClass('clicked')) $this.addClass('clicked');

          var $data = $($.parseHTML(data));
          var articles = $data.find('#js-product-archive .product_item');
          for (let i = 0; i < articles.length; i++) {
            var article = $(articles[i]);
            article.addClass('animate').css('animation-delay', i * 150 + 'ms');
            $itemArchive.find('.product_loop').append(article);
          }

          $cl.removeClass('is_loading');
          $this.css('display', 'block');

          $this.attr('data-current-page-num', currentNum);
          if(maxNum <= currentNum) $cl.addClass('is_loaded');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert(TCD_FUNCTIONS.ajax_error_message);
          $cl.removeClass('is_loading');
          $this.css('display', 'block');
        }
      });

    }


  });

}







  // ajax

  // let now_post_num = 3; // 現在表示されている件数
  // let get_post_num = 2;  // もっと読み込むボタンで取得する件数

  // //archive側で設定したdata属性の値を取得
  // let load = $('#product_archive');
  // let all_count = load.data("count"); //カスタム投稿の全件数

  // //admin_ajaxにadmin-ajax.phpの絶対パス指定（相対パスは失敗する）
  // let host_url = location.protocol + "//" + location.host;
  // let admin_ajax = host_url + '/wp-admin/admin-ajax.php';

  // $(document).on("click", ".ajax_loading_button", function () {
  //     //読み込み中はボタン非表示
  //     $('.ajax_loading_button').hide();

  //     //ajax処理。data{}のactionに指定した関数を実行、完了後はdoneに入る
  //     $.ajax({
  //         type: 'POST',
  //         url: admin_ajax,
  //         data: {
  //             'action' : 'my_ajax_action', //functions.phpで設定する関数名
  //             'now_post_num': now_post_num,
  //             'get_post_num': get_post_num,
  //             'post_type': 'product',
  //         },
  //     })
  //     .done(function(data){ //my_ajax_action関数で取得したデータがdataに入る
  //         //.loadにデータを追加
  //         $('.product_loop').append(data);
  //         //表示件数を増やす
  //         now_post_num = now_post_num + get_post_num;
  //         //まだ全件表示されていない場合、ボタンを再度表示
  //         if(all_count > now_post_num) {
  //             $('.ajax_loading_button').show();
  //         }
  //     })
  //     .fail(function(){
  //         alert('エラーが発生しました');
  //     })
  // });






});
