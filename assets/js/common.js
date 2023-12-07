$(function () {
  $(".l-BurgerButton").on("click", function () {
    if ($(this).hasClass("open")) {
      $(this).removeClass("open");
      $(".l-HeaderNav").removeClass("open");
      $(".l-NavOverlay").removeClass("open");
    } else {
      $(this).addClass("open");
      $(".l-HeaderNav").addClass("open");
      $(".l-NavOverlay").addClass("open");
    }
  });

  $(".l-NavOverlay").on("click", function () {
    if ($(this).hasClass("open")) {
      $(this).removeClass("open");
      $(".l-BurgerButton").removeClass("open");
      $(".l-HeaderNav").removeClass("open");
    }
  });

  $(".l-HeaderNav__list a[href]").on("click", function (event) {
    $(".l-BurgerButton").trigger("click");
  });

  //フェードイン（表示領域に入ったら クラス追加）
  $(window).on("load scroll", function () {
    $(".js-view").each(function () {
      var imgPos = $(this).offset().top;
      var scroll = $(window).scrollTop();
      var windowH = $(window).height();
      if (scroll > imgPos - windowH + windowH / 5) {
        $(this).addClass("is-viewin");
      }
    });
  });
});
