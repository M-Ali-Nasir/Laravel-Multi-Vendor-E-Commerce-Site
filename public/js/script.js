
var totalSlides1 = 0;
var totalSlides2 = 0;
if(categories === 3){
  totalSlides1 = categories;
  totalSlides2 = 2;
}else if(categories == 2){
  totalSlides1= categories;
  totalSlides2 = 2;
}else if(categories == 1){
  totalSlides1= categories;
  totalSlides2 = 1;
}else{
  totalSlides1 = 3;
  totalSlides2 = 2;
}
console.log(totalSlides1);
var swiper = new Swiper(".slide-content", {
    slidesPerView: totalSlides1,
    spaceBetween: 25,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints:{
        0: {
            slidesPerView: 1,
        },
        520: {
            slidesPerView: totalSlides2,
        },
        950: {
            slidesPerView: totalSlides1,
        },
    },
  });