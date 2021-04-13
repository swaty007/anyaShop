function setTimer( elementID, date ){
  // Set the date we're counting down to
  var countDownDate = new Date(date).getTime();

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById(elementID).innerHTML = '<ul class="d-flex justify-content-center"><li class="d-flex flex-column"><span class="date">'+days+'</span><div class="d-inline title">Дней</div></li><li class="d-flex flex-column"><span class="date">'+hours+'</span><div class="d-inline title">Часов</div></li><li class="d-flex flex-column"><span class="date">'+minutes+'</span><div class="d-inline title">Минут</div><li class="d-flex flex-column"><span class="date">'+seconds+'</span><div class="d-inline title">Секунд</div></li></ul>';

    // If the count down is finished, write some text 
    if (distance < 0) {
      clearInterval(x);
      document.getElementById(elementID).innerHTML = "Закончилось";
    }
  }, 1000);
}