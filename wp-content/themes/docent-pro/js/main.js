/* --------------------------------------
  _____ _                                         
 |_   _| |__   ___ _ __ ___   ___ _   _ _ __ ___  
   | | | '_ \ / _ \ '_ ` _ \ / _ \ | | | '_ ` _ \ 
   | | | | | |  __/ | | | | |  __/ |_| | | | | | |
   |_| |_| |_|\___|_| |_| |_|\___|\__,_|_| |_| |_|

*  --------------------------------------
*         Table of Content
*  --------------------------------------
*  1. FAQ onScroll Animation
*  2. Sticky Nav
*  3. Social Share
*  4. Coming Soon
*  5. Pagination JS
*  6. Image Popup
*  -------------------------------------- 
*  -------------------------------------- */

jQuery(document).ready(function($){'use strict';

    /* --------------------------------------
    *       1. FAQ onScroll Animation
    *  -------------------------------------- */
    var offset = 100;
    $('.faq-index a').on('click', function(event) {
        if (typeof $( '#'+$(this).attr('href').slice(1) ).offset().top !== 'undefined') {
            event.preventDefault();
            $('html, body').animate({scrollTop: $( '#'+$(this).attr('href').slice(1) ).offset().top - offset }, 'slow');
        }
    });
 
    /* --------------------------------------
    *       2. related course
    *  -------------------------------------- */
    $('.docent-related-course-items').slick({
        dots: false,
        infinite: true,
        speed: 400,
        slidesToShow: 5,
        slidesToScroll: 5,
        prevArrow: '<div class="docent-arrow prev"><i class="fas fa-arrow-left"></i></div>',
        nextArrow: '<div class="docent-arrow right"><i class="fas fa-arrow-right"></i></div>',
        responsive: [
            {
            breakpoint: 1900,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                    dots: false
                }
            },
           {
            breakpoint: 1400,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
                }
            },
           {
            breakpoint: 900,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              dots: false
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
    });
          
    /* --------------------------------------
    *       3. Sticky Nav
    *  -------------------------------------- */
    const winWidth = jQuery(window).width();
    if(winWidth > 992){
        jQuery(window).on('scroll', function(){'use strict';
            if ( jQuery(window).scrollTop() > 0 ) {
                jQuery('#masthead.enable-sticky').addClass('sticky');
            } else {
                jQuery('#masthead.enable-sticky').removeClass('sticky');
            }
        });
    }

    //Jquery Nice select
    $(document).ready(function() {
        $('select:not(.ignore-nice-select):not(.tutor-form-control):not(.tutor-form-select)').niceSelect();
    });


    /* --------------------------------------
    *       4. Social Share
    *  -------------------------------------- */
    $('.prettySocial').prettySocial();


    /* --------------------------------------
    *       5. Coming Soon Page
    *  -------------------------------------- */
    if (typeof loopcounter !== 'undefined') {
        loopcounter('counter-class');
    }


    /*----------------------------------
    *       6. Pagination JS           
    ------------------------------------ */
    if( $('.docent-pagination').length > 0 ){
        if( !$(".docent-pagination ul li:first-child a").hasClass('prev') ){ 
            $(".docent-pagination ul").prepend('<li class="p-2 first"><span class="'+ $(".docent-pagination").data("preview") +'"></span></li>');
        }
        if( !$(".docent-pagination ul li:last-child a").hasClass('next') ){ 
            $(".docent-pagination ul").append('<li class="p-2 first"><span class="'+$(".docent-pagination").data("nextview")+'"></span></li>');
        }
        $(".docent-pagination ul li:last-child").addClass("ml-auto");
        $(".docent-pagination ul").addClass("justify-content-start").find('li').addClass('p-2').addClass('ml-auto');
    }


    /*----------------------------------
    *       7. Image Popup           
    ------------------------------------ */
    $('.cloud-zoom').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function (openerElement) {
                return openerElement.next('img') ? openerElement : openerElement.find('img');
            }
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        }
    }); //  MagnifiPopup.

    /*-------------------------------------
    *       8. Search 
    --------------------------------------- */
    $(".search-open-icon").on('click',function(e){
        e.preventDefault();

        $(".header-search-input-wrap, .header-search-overlay").fadeIn(200);
        $(this).hide();
        $('.search-close-icon').show().css('display','inline-block');
    });
    $(".search-close-icon, .header-search-overlay").on('click',function(e){
        e.preventDefault();
        
        $(".header-search-input-wrap, .header-search-overlay").fadeOut(200);
        $('.search-close-icon').hide();
        $('.search-open-icon').show();
    }); // Search end. 


    /*---------------------------------------
    *       9. Modal popup
    ----------------------------------------- */
    $('.docent-course-custom-tab').each(function () {
        var $that = $(this);
        $(this).find('button').on('click', function () {
            $that.find('button').removeClass('active');
            $(this).addClass('active');
            $that.find("[data-tab-content]").hide();
            $that.find('[data-tab-content="'+ $(this).data('tab-toggle') +'"]').fadeIn(400);
        });
    });

    $('.docent-login-tab-toggle').on('click', function (e) {
        e.preventDefault();
        var $tab_item = $(this).attr('href');
        $("[data-docent-login-tab]").hide(0);
        $("[data-docent-login-tab='"+ $tab_item.replace('#', '') +"']").fadeIn();
    });

    $('.docent-modal-overlay, .docent-login-modal-close').on('click',function () {
        $(".docent-signin-modal-popup").fadeOut();
    });

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $(".docent-signin-modal-popup").fadeOut();
        }
    });

    $('.login-popup').on('click', function (e) {
        e.preventDefault();
        $(".docent-signin-modal-popup").fadeToggle();
    });

    /* --------------------------------------
    *      10. ajax login register
    *  -------------------------------------- */
    $('form#login').on('submit', function(e){
        'use strict';
        e.preventDefault();

        $('form#login p.status').show().text(ajax_object.loadingmessage);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username2').val(),
                'password': $('form#login #password2').val(),
                'rememberme': $('form#login #rememberme').val(),
                'security': $('form#login #security2').val() },
            success: function(data){
                if (data.loggedin == true){
                    $('form#login p.status').removeClass('text-danger').addClass('text-success');
                    $('form#login p.status').text(data.message);
                    document.location.href = ajax_object.redirecturl;
                }else{
                    $('form#login p.status').removeClass('text-success').addClass('text-danger');
                    $('form#login p.status').text(data.message);
                }
                if($('form#login p.status').text() == ''){
                    $('form#login p.status').hide();
                }else{
                    $('form#login p.status').show();
                }
            }
        });
    });

    if($('form#login .login-error').text() == ''){
        $('form#login  p.status').hide();
    }else{
        $('form#login  p.status').show();
    }

    // Register New User
    $('.register_button').click(function(e){
        e.preventDefault();
        var form_data = $(this).closest('form').serialize()+'&action=ajaxregister';
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_object.ajaxurl,
            data: form_data,
            success: function(data){
                //var jdata = json.parse(data);
                $('#registerform  p.status').show();
                if (data.loggedin){
                    $('#registerform  p.status').removeClass('text-danger').addClass('text-success');
                    $('#registerform  p.status').text(data.message);
                    $('#registerform')[0].reset();
                }else{
                    $('#registerform  p.status').removeClass('text-success').addClass('text-danger');
                    $('#registerform  p.status').text(data.message);
                }

            }
        });
    });
    if($('form#registerform  p.status').text() == ''){
        $('form#registerform  p.status').hide();
    }else{
        $('form#registerform  p.status').show();
    }


    /*------------------------------------------
    *         11. Scrolling Progress Bar 
    -------------------------------------------- */ 
    var getMax = function() {
        return $(document).height() - $(window).height();
    }
    var getValue = function() {
        return $(window).scrollTop();
    }
    if ('max' in document.createElement('progress')) {
        var progressBar = $('progress');
        progressBar.attr({
            max: getMax()
        });
        $(document).on('scroll', function() {
            progressBar.attr({
                value: getValue()
            });
        });
        $(window).resize(function() {  
            progressBar.attr({
                max: getMax(),
                value: getValue()
            });
        });
    } else {
        var progressBar = $('.progress-bar'),
            max = getMax(),
            value, width;
        var getWidth = function() {
            value = getValue();
            width = (value / max) * 100;
            width = width + '%';
            return width;
        }
        var setWidth = function() {
            progressBar.css({
                width: getWidth()
            });
        }
        $(document).on('scroll', setWidth);
        $(window).on('resize', function() { 
            max = getMax();
            setWidth();
        });
    }
    // End 

    //Menu Close Button
    if ($('#hamburger-menu').length > 0) {
        var button = document.getElementById('hamburger-menu');
        var span = button.getElementsByTagName('span')[0];

        button.onclick =  function() {
            span.classList.toggle('hamburger-menu-button-close');
        };

        $('#hamburger-menu').on('click', toggleOnClass);
        function toggleOnClass(event) {
            var toggleElementId = '#' + $(this).data('toggle'),
            element = $(toggleElementId);
            element.toggleClass('on');
        }

        // close hamburger menu after click a
        $( '.menu li a' ).on("click", function(){
            $('#hamburger-menu').click();
        });

        // Menu Toggler Rotate
        $('#mobile-menu ul li span.menu-toggler').click(function(){
            $(this).toggleClass('toggler-rotate');
        })
    }

    // Login Menu
    $(".docent_header_profile_photo").on('click', function () {
        $('.user-submenu').slideToggle(300);
    });
    // End.

    $('.header-cat-menu ul li:has(ul)').addClass('hassub');
    $('.hassub > a').addClass('has-parent');
    if(winWidth < 992){
        var hasChild = $('.header-cat-menu ul li.hassub');
        hasChild.append("<i class='fas fa-plus-circle'></i>");
        $(document).on('click', '.header-cat-menu ul li.hassub i', function(){
            $(this).toggleClass('toggler-rotate');
            $(this).siblings('ul').slideToggle(200);
        })
    }



    /* --------------------------------------------
    ------------ Docent Search On Change -------------
    ----------------------------------------------- */
    $('#searchword').on('keyup ', function (e) {
        var $that = $(this);
        var raw_data = $that.val(), // Item Container
            ajaxUrl = $that.data('url'),
            category = $("#searchtype").val();
            
        $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    raw_data: raw_data
                },
                beforeSend: function () {
                    if (!$('.form-inlines .docent-search-wrapper.search .fa-spinner').length) {
                        $('.form-inlines .docent-search-wrapper.search').addClass('spinner');
                        $('<i class="fa fa-spinner fa-spin"></i>').appendTo(".form-inlines .docent-search-wrapper.search .docent-course-search-icons").fadeIn(100);
                    }
                },
                complete: function () {
                    $('.form-inlines .docent-search-wrapper.search .fa-spinner ').remove();
                    $('.form-inlines .docent-search-wrapper.search').removeClass('spinner');
                }
            })
            .done(function (data) {
                if (e.type == 'blur') {
                    $(".docent-course-search-results").html('');
                } else {
                    $(".docent-course-search-results").html(data);
                }
            })
            .fail(function () {
                console.log("error");
            });
    });
    $('select#searchtype').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $('#post-type-name').val(valueSelected);
    });
    // End Search.







});




