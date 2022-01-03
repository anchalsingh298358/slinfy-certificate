///////floating-label-js

$(function () {
  $(".form-control").on('blur', function () {
    if ($(this).val() == '') {
      $(this).nextAll('label').eq(0).removeClass('active');
    } else {
      $(this).nextAll('label').eq(0).addClass('active');
    }
  });
  $(".form-control").on('click', function () {
      $(this).nextAll('label').eq(0).addClass('active');
  });
  populate_material();
  $(".form-control").on("change", function () {
    populate_material();
  });
});

function populate_material() {
  $.each($(".form-control"), function (i, v) {
    if ($(v).val() == '') {
      $(v).nextAll('label').eq(0).removeClass('active');
    } else {
      $(v).nextAll('label').eq(0).addClass('active');
    }
  });
};

//toggle-side-bar

$(document).on('click','.toggle-menu',function(){
  $('.left-side-bar').toggleClass('toggle-left-bar');
  $('.right-panel').toggleClass('toggle-right-bar');
  $('header').toggleClass('toggle-header-bar');
})

$(document).on('click', '.hamburger-icon', function () {
  $(this).toggleClass('collased-menu');
  $('.left-side-bar').toggleClass('show-menu-bar');
});


/////nice-scroll-js
// $(function () {
//   $(".menu-list").niceScroll({
//     cursorwidth: "6px",
//     bouncescroll: false
//   });
//   $("body").niceScroll({
//     cursorwidth: "6px",
//     bouncescroll: false
//   });
// });



  