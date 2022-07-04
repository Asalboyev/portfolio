 $(document).ready(function(){

    $('#menu').click(function(){
        $(this).toggleClass('fa-times');
        $('header').toggleClass('toggle');
    });

    $(window).on('scroll load',function() {

        $('#menu').removeClass('fa-times');
        $('header').removeClass('toggle');
    
    } )
 }); 



 
//  dayNightBtn.addEventListener("click", function () {
//     document.querySelector("body").classList.toggle("body-tun");
//     document
//       .querySelector(".header__content__photos__before")
//       .classList.toggle("active");
//     almashtir(bgKun, "bg-kun-toq", "bg-tun-toq");
//     almashtir(bgKunOch, "bg-kun-och", "bg-tun-och");
//     almashtir(colorTunOch, "color-tun-och", "color-kun-och");
//     almashtir(professionText, "active");
//   });