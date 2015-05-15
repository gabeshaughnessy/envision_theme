//SMOOTH SCROLLING FOR ALL ON-PAGE LINKS
jQuery(document).ready(function($){
    var scrollSpeed = 800;
    jQuery('a[href*=#]:not([href=#])').on('click', function(){
        if(jQuery(this).attr('href').indexOf("tab-") != -1){
            //tab-links
            if(jQuery('.tab-controls-wrapper').length){
                var scrollTo = parseInt(jQuery('.tab-controls-wrapper').offset().top, 10) - 85;
            }
            if(typeof scrollTo !== 'undefined'){
                $('html,body').animate({
                  scrollTop: scrollTo
                }, scrollSpeed);
            }
        }
        else{//non-tab on-page links
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: parseInt(target.offset().top - 85, 10)
                }, scrollSpeed);

                return false;
              }

        }
    });

});