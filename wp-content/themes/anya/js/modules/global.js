import Rellax from 'rellax'

class Global {
  constructor() {
    this.events();
  }

  events() {

    $(".plan__btn").on('click', function() {
      $(".plan__hidden").slideToggle();
    });

    //main page
    $('#allCourses').click( function(){
      $('.big-menu').toggle();
    });

    let online_height = null

    $(".online__btn").click(function() {
      if (!online_height) online_height = $("#online__html").height()
      if ($("#online__html").height() == online_height) {
        $("#online__html").css({height:$("#online__html")[0].scrollHeight});
      } else {
        $("#online__html").removeAttr('style');
      }
    });

    //scroll
    $(document).on('click', 'a[href^="#"]', function (event) {
      event.preventDefault();

      $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
      }, 1000);
    });

    //policy page
    $('.page__item .page__item-header').on('click', function() {
      $(".page__item-btn-plus", this).toggleClass('page__item-btn-plus--rotated');
      $(this).siblings(".page__item-body").slideToggle();
    });

    try {
      if ($('.rellax')[0]) {
        var rellax = new Rellax('.rellax');
      }
    } catch (e) {
      console.log('rellax error', e)
    }


  }


}

export default Global;
