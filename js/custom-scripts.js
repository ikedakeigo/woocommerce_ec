jQuery(document).ready(function () {
  jQuery(".products-slider").slick({
    dots: false,               // ドットのナビゲーションを表示
    autoplay: true,           // 自動再生
    autoplaySpeed: 335000,      // 自動再生のスピード (1秒)
    infinite: true,           // 無限スクロール
    slidesToShow: 5,        // 1ページに表示するスライド数
    slidesToScroll: 1,        // 1回のスクロールで移動するスライド数
    centerMode: false,         // センターモードを有効化
    focusOnSelect: true,      // クリックしたスライドを中央に持ってくる
    accessibility: false,     // アクセシビリティを無効化
    arrows: true,          // 矢印ボタンを表示
    prevArrow: ' <button class="arrow-common arrow-prev"><img src="' + themeVars.themeUrl + '/assets/img/y.svg" class="slide-arrow prev-arrow"></button>',
    nextArrow: ' <button class="arrow-common arrow-next"><img src="' + themeVars.themeUrl + '/assets/img/y.svg" class="slide-arrow next-arrow"></button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  });
});
