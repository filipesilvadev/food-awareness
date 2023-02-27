/*global $:false
  _____ _
 |_   _| |__   ___ _ __ ___   ___ _   _ _ __ ___
   | | | '_ \ / _ \ '_ ` _ \ / _ \ | | | '_ ` _ \
   | | | | | |  __/ | | | | |  __/ |_| | | | | | |
   |_| |_| |_|\___|_| |_| |_|\___|\__,_|_| |_| |_|

*  --------------------------------------
*         Table of Content
*  --------------------------------------
*  1. Image Popup
*  2. Portfolio Items Filter
*  --------------------------------------
*  -------------------------------------- */

jQuery(document).ready(function($){'use strict';
  /* --------------------------------------
   *       1. Image Popup
   *  -------------------------------------- */
  $(".portfolio-thumb").magnificPopup({
        delegate: 'a',
        type: "image",
        gallery:{
            enabled:true
        }
    });

   /* --------------------------------------
   *       2. Portfolio Items Filter
   *  -------------------------------------- */
   $(window).load(function(){
       var $container = $('.portfolioContainer');
       $('.portfolioFilter a').click(function(){
           $('.portfolioFilter .current').removeClass('current');
           $(this).addClass('current');

           var selector = $(this).attr('data-filter');
           $container.isotope({
               filter: selector,
               animationOptions: {
                   duration: 750,
                   easing: 'linear',
                   queue: false
               }
            });
            return false;
       });
   });

});
