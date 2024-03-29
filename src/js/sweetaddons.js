jQuery(function () {
  // on scroll top
  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
      if (
        jQuery(".scroll-active").hasClass("scroll-active") &&
        jQuery(".scroll-active").hasClass("right")
      ) {
        jQuery(".scroll-active").css("margin-right", "45px");
      }
      jQuery(".scroll-to-top").fadeIn();
    } else {
      if (
        jQuery(".scroll-active").hasClass("scroll-active") &&
        jQuery(".scroll-active").hasClass("right")
      ) {
        jQuery(".scroll-active").css("margin-right", "0px");
      }
      jQuery(".scroll-to-top").fadeOut();
    }
  });
  // on click scroll to top
  jQuery(".scroll-to-top").click(function () {
    jQuery("html, body").animate(
      {
        scrollTop: 0,
      },
      400
    );
    return false;
  });

});
