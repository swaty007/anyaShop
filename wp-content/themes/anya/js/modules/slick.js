class Slick {
  constructor() {
    this.events()
  }
  events () {

    //single courses
    try {
      $(".regular-three").slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        adaptiveHeight: true,
        responsive: [
          {
            breakpoint: 769,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true
      });

      $(".lazy").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true,
        adaptiveHeight: true
      });
    } catch (e) {
      console.log('single course error', e)
    }

    //about page
    try {
      //sliders for about and schedule page and professions + webinars
      if ($(".regular")[0]) {
        $(".regular").slick({
          dots: false,
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3
        });
      }
      if ($(".lazy")[0]) {
        $(".lazy").slick({
          lazyLoad: 'ondemand', // ondemand progressive anticipated
          infinite: true
        });
      }

    } catch (e) {
      console.log('about page error', e)
    }

    //main page
    try {



      if ($('.feeds-wrap')[0]) {
        $(".feeds-wrap").slick({
          dots: true,
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          adaptiveHeight: true,
          // responsive: [
          //     {
          //         breakpoint: 768,
          //         settings: {
          //             slidesToShow: 1,
          //             slidesToScroll: 1
          //         }
          //     }
          // ]
        });
      }


    } catch (e) {
      console.log('main page error', e)
    }
  }
}
export default Slick;