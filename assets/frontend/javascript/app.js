/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
"use strict";

// vendor
import $ from 'jquery';
import jQuery from 'jquery';
window.$ = jQuery;
var jQueryBridget = require('jquery-bridget');

import counterUp from 'counterup2'

import 'magnific-popup';
require('bootstrap-select');
require('bootstrap-select/dist/css/bootstrap-select.min.css');
import AOS from 'aos';
var imagesLoaded = require('imagesloaded');

// import Swiper JS
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/swiper-bundle.css'

import GLightbox from 'glightbox';


import lightGallery from 'lightgallery';
var Isotope = require('isotope-layout');
// add cellsByRow layout mode
require('isotope-cells-by-row')
import 'masonry-layout';
import PerfectScrollbar from 'perfect-scrollbar';

import 'bootstrap';
import 'bootstrap-select';
import '@fortawesome/fontawesome-free/js/all.js';
require('pdfjs-dist');


// any CSS you import will output into a single css file (app.css in this case)
// import '../icons/dz-icons/icons.css';
// import '../css/style.css';
import '../scss/main.scss';


/**
 Core script to handle the entire theme and core functions

 **/
const Mazo = (() => {
  /* Search Bar ============ */
  let screenWidth = $(window).width();

  const homeSearch = () => {
    /* top search in header on click function */
    const quikSearch = jQuery("#quik-search-btn");
    const quikSearchRemove = jQuery("#quik-search-remove");

    quikSearch.on('click', () => {
      jQuery('.dz-quik-search').fadeIn(500);
      jQuery('.dz-quik-search').addClass('On');
    });

    quikSearchRemove.on('click', () => {
      jQuery('.dz-quik-search').fadeOut(500);
      jQuery('.dz-quik-search').removeClass('On');
    });
    /* top search in header on click function End*/
  };

  /* One Page Layout ============ */
  const onePageLayout = () => {
    const headerHeight = parseInt($('.onepage').css('height'), 10);

    $(".scroll").unbind().on('click', function (event) {
      event.preventDefault();

      if (this.hash !== "") {
        const hash = this.hash;
        const seactionPosition = $(hash).offset().top;

        const headerHeight = parseInt($('.onepage').css('height'), 10);

        $('body').scrollspy({target: ".navbar", offset: headerHeight + 2});

        const scrollTopPosition = seactionPosition - (headerHeight);

        $('html, body').animate({
          scrollTop: scrollTopPosition
        }, 100, () => {

        });
      }
    });

    /* One Page Setup */
    if (jQuery('.navbar-nav-scroll').length > 0) {

      jQuery(document).on("scroll", pageOnScroll);

      const headerFullHeight = parseInt($('.main-bar-wraper').css('height'), 10);

      //smoothscroll
      jQuery('.navbar-nav-scroll a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        jQuery(document).off("scroll");

        jQuery('.navbar-nav-scroll a').each(function () {

          jQuery(this).removeClass('active');
        })
        jQuery(this).addClass('active');

        const target = this.hash;
        const menu = target;


        const $target = $(target);

        if ($target.length > 0) {
          jQuery('html, body').stop().animate({
              'scrollTop': $target.offset().top - headerFullHeight
            }, 500, 'swing', () => {

              //window.location.hash = target;
              jQuery(document).on("scroll", pageOnScroll);
            }
          );
        }
      });

    }

  };

  var pageOnScroll = event => {
    const scrollPos = jQuery(document).scrollTop();
    jQuery('.navbar-nav-scroll a:first').each(function () {
      const elementLink = jQuery(this);

      const headerHeight = jQuery('header .main-bar').height();

      if (jQuery(elementLink.attr("href")).length > 0) {

        const refElement = jQuery(elementLink.attr("href"));
        if (refElement.offset().top - (headerHeight + 10) <= scrollPos && refElement.offset().top + refElement.height() > scrollPos) {

          jQuery('.navbar-nav-scroll a').removeClass("active");
          elementLink.addClass("active");
        } else {
          elementLink.removeClass("active");
        }
      }
    });
  }

  /* Load File ============ */
  const dzTheme = () => {
    if (screenWidth <= 991) {
      jQuery('.navbar-nav > li > a, .sub-menu > li > a').unbind().on('click', function (e) {
        if (jQuery(this).parent().hasClass('open')) {
          jQuery(this).parent().removeClass('open');
        } else {
          jQuery(this).parent().parent().find('li').removeClass('open');
          jQuery(this).parent().addClass('open');
        }
      });
    }

    jQuery('.menu-btn, .openbtn').unbind().on('click', () => {
      jQuery('.contact-sidebar').addClass('active');
    });
    jQuery('.menu-close').unbind().on('click', () => {
      jQuery('.contact-sidebar').removeClass('active');
      jQuery('.menu-btn').removeClass('open');
    });

    // Full sidebar
    jQuery('.full-sidenav .navbar-nav > li > a').next('.sub-menu').slideUp();
    jQuery('.full-sidenav .sub-menu > li > a').next('.sub-menu').slideUp();

    jQuery('.full-sidenav .navbar-nav > li > a, .full-sidenav .sub-menu > li > a').unbind().on('click', function (e) {
      if (jQuery(this).hasClass('dz-open')) {

        jQuery(this).removeClass('dz-open');
        jQuery(this).parent('li').children('.sub-menu').slideUp();
      } else {
        jQuery(this).addClass('dz-open');

        if (jQuery(this).parent('li').children('.sub-menu').length > 0) {
          e.preventDefault();
          jQuery(this).next('.sub-menu').slideDown();
          jQuery(this).parent('li').siblings('li').children('.sub-menu').slideUp();
        } else {
          jQuery(this).next('.sub-menu').slideUp();
        }
      }
    });

    jQuery('.header-full .navbar-toggler').unbind().on('click', () => {
      if (jQuery('.header-full .navbar-toggler').hasClass('open')) {
        jQuery('.header-full .navbar-toggler').addClass('open');
      } else {
        jQuery('.header-full .navbar-toggler').removeClass('open');
      }

      jQuery('.full-sidenav').toggleClass('active');
    });
    jQuery('.menu-close').unbind().on('click', () => {
      jQuery('.menu-close,.full-sidenav').removeClass('active');
      jQuery('.header-full .navbar-toggler').removeClass('open');
    });
  };

  /* Magnific Popup ============ */
  const MagnificPopup = () => {
    if (jQuery('.mfp-gallery').length > 0) {
      /* magnificPopup function */
      jQuery('.mfp-gallery').magnificPopup({
        delegate: '.mfp-link',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
          titleSrc({el}) {
            return `${el.attr('title')}<small></small>`;
          }
        }
      });
      /* magnificPopup function end */
    }

    if (jQuery('.mfp-video').length > 0) {
      /* magnificPopup for Play video function */
      jQuery('.mfp-video').magnificPopup({
        type: 'iframe',
        iframe: {
          markup: '<div class="mfp-iframe-scaler">' +
            '<div class="mfp-close"></div>' +
            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
            '<div class="mfp-title">Some caption</div>' +
            '</div>'
        },
        callbacks: {
          markupParse(template, values, {el}) {
            values.title = el.attr('title');
          }
        }
      });

    }

    if (jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').length > 0) {
      /* magnificPopup for Play video function end */
      $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,

        fixedContentPos: false
      });
    }
  };

  /* Scroll To Top ============ */
  const scrollTop = () => {
    const scrollTop = jQuery("button.scroltop");
    /* page scroll top on click function */
    scrollTop.on('click', () => {
      jQuery("html, body").animate({
        scrollTop: 0
      }, 1000);
      return false;
    })

    jQuery(window).on('scroll', () => {
      const scroll = jQuery(window).scrollTop();
      if (scroll > 900) {
        jQuery("button.scroltop").fadeIn(1000);
      } else {
        jQuery("button.scroltop").fadeOut(1000);
      }
    });
    /* page scroll top on click function end*/
  };

  /* Header Fixed ============ */
  const headerFix = () => {
    /* Main navigation fixed on top  when scroll down function custom */
    jQuery(window).on('scroll', () => {
      if (jQuery('.sticky-header').length > 0) {
        const menu = jQuery('.sticky-header');
        if ($(window).scrollTop() > menu.offset().top) {
          menu.addClass('is-fixed');
          $('.site-header .container > .logo-header .logo').attr('src', 'images/logo.png');
          $('.site-header .container > .logo-header .logo-2').attr('src', 'images/logo-2.png');
          $('.site-header .container > .logo-header .logo-3').attr('src', 'images/logo-3.png');
        } else {
          menu.removeClass('is-fixed');
          $('.site-header .container > .logo-header .logo, .site-header .container > .logo-header .logo-2, .site-header .container > .logo-header .logo-3').attr('src', 'images/logo-white.png')
        }
      }
    });
    /* Main navigation fixed on top  when scroll down function custom end*/
  };

  /* Masonry Box ============ */
  const masonryBox = () => {
    /* masonry by  = bootstrap-select.min.js */
    if (jQuery('#masonry, .masonry').length > 0) {
      var self = jQuery("#masonry, .masonry");

      if (jQuery('.card-container').length > 0) {
        const gutterEnable = self.data('gutter');

        let gutter = (self.data('gutter') === undefined) ? 0 : self.data('gutter');
        gutter = parseInt(gutter, 10);


        let columnWidthValue = (self.attr('data-column-width') === undefined) ? '' : self.attr('data-column-width');
        if (columnWidthValue != '') {
          columnWidthValue = parseInt(columnWidthValue, 10);
        }

        self.imagesLoaded(() => {
          self.masonry({
            //gutter: gutter,
            //columnWidth:columnWidthValue,
            gutterWidth: 15,
            isAnimated: true,
            itemSelector: ".card-container",
            //percentPosition: true
          });

        });
      }
    }
    if (jQuery('.filters').length) {
      jQuery(".filters li:first").addClass('active');

      jQuery(".filters").on("click", "li", function () {
        jQuery('.filters li').removeClass('active');
        jQuery(this).addClass('active');

        const filterValue = $(this).attr("data-filter");
        self.isotope({filter: filterValue});
      });
    }
    /* masonry by  = bootstrap-select.min.js end */
  };

  /* Counter Number ============ */
  const counter = () => {
    const el = document.querySelector( '.counter' )
    if (jQuery('.counter').length) {
      console.log('freeee');
      counterUp( el, {
        duration: 2500,
        delay: 16,
      } )
    }

  };

  /* Video Popup ============ */
  const handleVideo = () => {
    /* Video responsive function */
    jQuery('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    jQuery('iframe[src*="vimeo.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    /* Video responsive function end */
  };

  /* Gallery Filter ============ */
  const handleFilterMasonary = () => {
    /* gallery filter activation = jquery.mixitup.min.js */
    if (jQuery('#image-gallery-mix').length) {
      jQuery('.gallery-filter').find('li').each(function () {
        $(this).addClass('filter');
      });
      jQuery('#image-gallery-mix').mixItUp();
    }
    ;
    if (jQuery('.gallery-filter.masonary').length) {
      jQuery('.gallery-filter.masonary').on('click', 'span', function () {
        const selector = $(this).parent().attr('data-filter');
        jQuery('.gallery-filter.masonary span').parent().removeClass('active');
        jQuery(this).parent().addClass('active');
        jQuery('#image-gallery-isotope').isotope({filter: selector});
        return false;
      });
    }
    /* gallery filter activation = jquery.mixitup.min.js */
  };

  /* Resizebanner ============ */
  const handleBannerResize = () => {
    $(".full-height").css("height", $(window).height());
  };

  /* BGEFFECT ============ */
  const reposition = function () {
    const modal = jQuery(this);
    const dialog = modal.find('.modal-dialog');
    modal.css('display', 'block');

    /* Dividing by two centers the modal exactly, but dividing by three
     or four works better for larger screens.  */
    dialog.css("margin-top", Math.max(0, (jQuery(window).height() - dialog.height()) / 2));
  };

  const handelResize = () => {

    /* Reposition when the window is resized */
    jQuery(window).on('resize', () => {
      jQuery('.modal:visible').each(reposition);
    });
  };

  /* Light Gallery ============ */
  const lightGallery = () => {
    if (($('#lightgallery, .lightgallery').length > 0)) {
      $('#lightgallery, .lightgallery').lightGallery({
        selector: '.lightimg',
        loop: true,
        thumbnail: true,
        exThumbImage: 'data-exthumbimage',
        download: false,
        share: false,
      });
    }
  };

  const boxHover = () => {
    jQuery('.box-hover').on('mouseenter', function () {
      const selector = jQuery(this).parent().parent();
      selector.find('.box-hover').removeClass('active');
      jQuery(this).addClass('active');
    });
  };

  /* Header Height ============ */
  const setResizeMargin = () => {
    if (($('.setResizeMargin').length > 0) && screenWidth >= 1280) {
      const containerSize = $('.container').width();
      const getMargin = (screenWidth - containerSize) / 2;
      $('.setResizeMargin').css('margin-left', getMargin);
    }
  };

  const handleRadialProgress = () => {
    if (($('svg.radial-progress').length > 0)) {

      // Remove svg.radial-progress .complete inline styling
      $('svg.radial-progress').each(function (index, value) {
        $(this).find($('circle.complete')).removeAttr('style');
      });
      // Activate progress animation on scroll
      $(window).on('scroll', () => {
        $('svg.radial-progress').each(function (index, value) {
          // If svg.radial-progress is approximately 25% vertically into the window when scrolling from the top or the bottom
          if (
            $(window).scrollTop() > $(this).offset().top - ($(window).height() * 0.75) &&
            $(window).scrollTop() < $(this).offset().top + $(this).height() - ($(window).height() * 0.25)
          ) {
            // Get percentage of progress
            const percent = $(value).data('percentage');
            //  Get radius of the svg's circle.complete
            const radius = $(this).find($('circle.complete')).attr('r');
            // Get circumference (2πr)
            const circumference = 2 * Math.PI * radius;
            // Get stroke-dashoffset value based on the percentage of the circumference
            const strokeDashOffset = circumference - ((percent * circumference) / 100);
            // Transition progress for 1.25 seconds
            $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 1250);
          }
        });
      }).trigger('scroll');
    }
  };

  const handleheartBlast = () => {
    $(".heart").on("click", function () {
      $(this).toggleClass("heart-blast");
    });
  };

  const bsSelect = () => {
    if (jQuery.isFunction($.fn.selectpicker)) {
      $('select').selectpicker();
    }
  };

  const kenburnSlider = () => {
    if ($("#kenburn").length > 0) {
      $("#kenburn").slippry({
        transition: 'kenburns',
        useCSS: true,
        speed: 8000,
        pause: 2500,
        auto: true,
        preload: 'visible',
        autoHover: false
      });
    }
  };

  /* Website Launch Date */
  let WebsiteLaunchDate = new Date();
  const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  WebsiteLaunchDate.setMonth(WebsiteLaunchDate.getMonth() + 1);
  WebsiteLaunchDate = `${WebsiteLaunchDate.getDate()} ${monthNames[WebsiteLaunchDate.getMonth()]} ${WebsiteLaunchDate.getFullYear()}`;
  /* Website Launch Date END */

  /* Countdown Style 1
  - Put your launching date here and uncomment this line*/
  //var WebsiteLaunchDate = '2 February 2020 10:00';

  const handleCountDown = WebsiteLaunchDate => {
    /* Time Countr Down Js */
    if ($(".countdown").length) {
      $('.countdown').countdown({date: WebsiteLaunchDate}, () => {
        $('.countdown').text('we are live');
      });
    }
    /* Time Countr Down Js End */
  };

  /* Countdown Timer ============ */
  const handleFinalCountDown = () => {
    const launchDate = jQuery('.countdown-timer').data('date');

    if (launchDate != undefined && launchDate != '') {
      WebsiteLaunchDate = launchDate;
    }

    if (jQuery('.countdown-timer').length > 0) {
      let startTime = new Date(); // Put your website start time here
      startTime = startTime.getTime();

      let currentTime = new Date();
      currentTime = currentTime.getTime();

      let endTime = new Date(WebsiteLaunchDate); // Put your website end time here
      endTime = endTime.getTime();

      $('.countdown-timer').final_countdown({

        'start': (startTime / 1000),
        'end': (endTime / 1000),
        'now': (currentTime / 1000),
        selectors: {
          value_seconds: '.clock-seconds .val',
          canvas_seconds: 'canvas-seconds',
          value_minutes: '.clock-minutes .val',
          canvas_minutes: 'canvas-minutes',
          value_hours: '.clock-hours .val',
          canvas_hours: 'canvas-hours',
          value_days: '.clock-days .val',
          canvas_days: 'canvas-days'
        },
        seconds: {
          borderColor: $('.type-seconds').attr('data-border-color'),
          borderWidth: '5',
        },
        minutes: {
          borderColor: $('.type-minutes').attr('data-border-color'),
          borderWidth: '5'
        },
        hours: {
          borderColor: $('.type-hours').attr('data-border-color'),
          borderWidth: '5'
        },
        days: {
          borderColor: $('.type-days').attr('data-border-color'),
          borderWidth: '5'
        }
      }, () => {
        jQuery.ajax({
          type: 'POST',
          url: akcel_js_data.admin_ajax_url,
          data: `action=change_theme_status_ajax&security=${akcel_js_data.ajax_security_nonce}`,
          success(data) {
            location.reload();
          }
        });
      });
    }
  };

  const handlePlaceholderAnimation = () => {
    if (jQuery('.dezPlaceAni').length) {
      $('.dezPlaceAni input, .dezPlaceAni textarea').on('focus', function () {
        $(this).parents('.input-group').addClass('focused');
      });

      $('.dezPlaceAni input, .dezPlaceAni textarea').on('blur', function () {
        const inputValue = $(this).val();
        if (inputValue == "") {
          $(this).removeClass('filled');
          $(this).parents('.input-group').removeClass('focused');
        } else {
          $(this).addClass('filled');
        }
      })
    }
  };

  const handleDznavScroll = () => {
    if (jQuery('.deznav-scroll').length > 0) {
      const qs = new PerfectScrollbar('.deznav-scroll');
      qs.isRtl = false;
    }
  };

  /* Function ============ */
  return {
    init() {
      boxHover();
      onePageLayout();
      homeSearch();
      MagnificPopup();
      scrollTop();
      headerFix();
      handleVideo();
      handleFilterMasonary();
      handleCountDown(WebsiteLaunchDate);
      handleFinalCountDown();
      handleBannerResize();
      handelResize();
      lightGallery();
      setResizeMargin();
      kenburnSlider();
      bsSelect();
      jQuery('.modal').on('show.bs.modal', reposition);
      handleheartBlast();
      handlePlaceholderAnimation();
      handleDznavScroll();


    },

    load() {
      dzTheme();
      counter();
      masonryBox();
      handleRadialProgress();
    },

    resize() {
      handleFinalCountDown();
      screenWidth = $(window).width();
      dzTheme();
    }
  };
})();

/* Document.ready Start */
jQuery(document).ready(() => {

  Mazo.init();
  $('a[data-toggle="tab"]').on('click', function () {
    // todo remove snippet on bootstrap v4
    $($(this).attr('href')).show().addClass('show active').siblings().hide();
  });

  jQuery('.navicon').on('click', function () {
    $(this).toggleClass('open');
  });

});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load', () => {

  Mazo.load();
  setTimeout(() => {
    AOS.init();
    jQuery('#loading-area').remove();
  }, 1000);

});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on('resize', () => {
  Mazo.resize();
});
/*  Window Resize END */


function homeSlider() {

  // main-slider-swiper
  if (jQuery('.main-slider-swiper').length > 0) {
    var swiper = new Swiper('.main-slider-swiper', {
      modules: [Navigation, Pagination, Autoplay],
      speed: 1500,
      parallax: true,
      slidesPerView: 1,
      direction: 'horizontal',
      loop: false,
      autoplay: false,
      navigation: {
        nextEl: '.swiper-button-next1',
        prevEl: '.swiper-button-prev1',
      },
    });
  }
}


/* JavaScript Document */
jQuery(document).ready(function () {
  'use strict';

  setTimeout(function () {
    homeSlider();
  }, 300);


  /* All Testimonial Swiper Start ==========
  ==================================*/

  // Testimonial Swiper 1
  if (jQuery('.testimonial-swiper1').length > 0) {
    var testswiper1 = new Swiper('.testimonial-swiper1', {
      speed: 1500,
      slidesPerView: 1,
      spaceBetween: 30,
      autoplay: {
        delay: 2500,
      },
    });
  }

  // Testimonial Swiper 2
  if (jQuery('.testimonial-swiper2').length > 0) {
    var testswiper2 = new Swiper('.testimonial-swiper2', {
      speed: 1500,
      slidesPerView: 2,
      spaceBetween: 0,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1024: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      },
      pagination: {
        el: ".swiper-pagination",
      },
    });
  }

  // Testimonial Swiper 3
  if (jQuery('.testimonial-swiper3').length > 0) {
    var testimonialswiper1 = new Swiper('.testimonial-swiper3', {
      speed: 1500,
      slidesPerView: 3,
      spaceBetween: 30,
      autoplay: {
        delay: 2500,
      },
      pagination: {
        el: '.swiper-pagination1',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
      },
      breakpoints: {
        1024: {
          slidesPerView: 3,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Testimonial Swiper 4
  if (jQuery('.testimonial-swiper4').length > 0) {
    var swiper3 = new Swiper('.testimonial-swiper4', {
      speed: 1500,
      parallax: true,
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next3',
        prevEl: '.swiper-button-prev3',
      },
      breakpoints: {
        1191: {
          slidesPerView: 2,
        },
        691: {
          slidesPerView: 1,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Testimonial Swiper 5
  if (jQuery('.testimonial-swiper5').length > 0) {
    var swiper3 = new Swiper('.testimonial-swiper5', {
      speed: 1500,
      parallax: true,
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      pagination: {
        el: '.swiper-pagination5',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + 0 + (index + 1) + '</span>';
        },
      },
      navigation: {
        nextEl: '.swiper-button-next3',
        prevEl: '.swiper-button-prev3',
      },
      breakpoints: {
        1191: {
          slidesPerView: 2,
        },
        691: {
          slidesPerView: 1,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Testimonial Swiper 6
  if (jQuery('.testimonial-swiper6').length > 0) {
    var testswiper2 = new Swiper('.testimonial-swiper6', {
      speed: 1500,
      slidesPerView: 2,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1024: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      },
      //pagination:{
      //	el: ".swiper-pagination",
      //},
    });
  }

  // Testimonial Swiper 7
  if (jQuery('.testimonial-swiper7').length > 0) {
    var testimonialswiper1 = new Swiper('.testimonial-swiper7', {
      speed: 1500,
      slidesPerView: 3,
      spaceBetween: 30,
      autoplay: {
        delay: 2500,
      },
      pagination: {
        el: '.swiper-pagination1',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
      },
      breakpoints: {
        1024: {
          slidesPerView: 3,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Testimonial Swiper 8
  if (jQuery('.testimonial-swiper8').length > 0) {
    var testswiper1 = new Swiper('.testimonial-swiper8', {
      speed: 1500,
      slidesPerView: 1,
      spaceBetween: 30,
      autoplay: {
        delay: 2500,
      },
      navigation: {
        nextEl: '.testimonial-prev8',
        prevEl: '.testimonial-next8',
      },
    });
  }

  /* All Testimonial Swiper End ==========
  ==================================*/


  /* All Team Swiper Start ==========
  ==================================*/

  // Team Swiper 1
  if (jQuery('.team-swiper1').length > 0) {
    var teamswiper1 = new Swiper('.team-swiper1', {
      speed: 1500,
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      navigation: {
        nextEl: '.swiper-button-next2',
        prevEl: '.swiper-button-prev2',
      },
      breakpoints: {
        1191: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 3,
        },
        591: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Team Swiper 2
  if (jQuery('.team-swiper2').length > 0) {
    var teamswiper2 = new Swiper('.team-swiper2', {
      speed: 1500,
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      pagination: {
        el: '.swiper-pagination-team-2',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + 0 + (index + 1) + '</span>';
        },
      },
      navigation: {
        nextEl: '.swiper-button-next2',
        prevEl: '.swiper-button-prev2',
      },
      breakpoints: {
        1191: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 3,
        },
        591: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Team Swiper
  if (jQuery('.team-swiper3').length > 0) {
    var teamswiper3 = new Swiper('.team-swiper3', {
      speed: 1500,
      parallax: true,
      slidesPerView: 4,
      spaceBetween: 30,
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next4',
        prevEl: '.swiper-button-prev4',
      },
      breakpoints: {
        1191: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 3,
        },
        591: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Team Swiper 4
  if (jQuery('.team-swiper4').length > 0) {
    var teamswiper4 = new Swiper('.team-swiper4', {
      speed: 1500,
      slidesPerView: 4,
      spaceBetween: 30,
      loop: true,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
      },
      navigation: {
        nextEl: '.team-next',
        prevEl: '.team-prev',
      },
      breakpoints: {
        1191: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 3,
        },
        591: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Team Swiper 5
  if (jQuery('.team-swiper5').length > 0) {
    var teamswiper5 = new Swiper('.team-swiper5', {
      speed: 1500,
      spaceBetween: 30,
      slidesPerView: 4,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        1191: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 3,
        },
        591: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  /* All Team Swiper End ==========
  ==================================*/


  // Services Swiper
  if (jQuery('.services-swiper').length > 0) {
    var swiper3 = new Swiper('.services-swiper', {
      speed: 1500,
      parallax: true,
      slidesPerView: 4,
      spaceBetween: 30,
      //loop:true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        1191: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 3,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Services Swiper
  if (jQuery('.portfolio-swiper').length > 0) {
    var swiper3 = new Swiper('.portfolio-swiper', {
      speed: 1500,
      parallax: true,
      slidesPerView: 4,
      spaceBetween: 30,
      //loop:true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        1191: {
          slidesPerView: 4,
        },
        691: {
          slidesPerView: 1,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // main-slider-swiper
  if (jQuery('.main-slider-swiper-04').length > 0) {
    var swiper = new Swiper('.main-slider-swiper-04', {
      speed: 1500,
      parallax: true,
      loop: true,
      autoplay: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  }

  // Swiper Portfolio
  if (jQuery('.swiper-portfolio1').length > 0) {
    var portfolioswiper1 = new Swiper('.swiper-portfolio1', {
      slidesPerView: 1,
      spaceBetween: 30,
      speed: 1500,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1280: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 3,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Blog Swiper
  if (jQuery('.blog-swiper').length > 0) {
    var blogswiper = new Swiper('.blog-swiper', {
      slidesPerView: 3,
      spaceBetween: 0,
      speed: 1500,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1191: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 2,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Blog Swiper
  if (jQuery('.post-swiper').length > 0) {
    var swiper2 = new Swiper('.post-swiper', {
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 1500,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      navigation: {
        nextEl: '.prev-post-swiper-btn',
        prevEl: '.next-post-swiper-btn',
      },
    });
  }


  // Blog Swiper
  if (jQuery('.blog-swiper-2').length > 0) {
    var blogswiper = new Swiper('.blog-swiper-2', {
      slidesPerView: 3,
      spaceBetween: 20,
      speed: 1500,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1600: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 2,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  // Clients Swiper
  if (jQuery('.clients-swiper').length > 0) {
    var swiper5 = new Swiper('.clients-swiper', {
      speed: 1500,
      parallax: true,
      slidesPerView: 4,
      spaceBetween: 30,
      autoplay: {
        delay: 2500,
      },
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next5',
        prevEl: '.swiper-button-prev5',
      },
      breakpoints: {
        1191: {
          slidesPerView: 6,
        },
        991: {
          slidesPerView: 5,
        },
        691: {
          slidesPerView: 4,
        },
        591: {
          slidesPerView: 3,
        },
        320: {
          slidesPerView: 2,
        },
      }
    });
  }


  // client swiper-2
  if (jQuery('.client-swiper-2').length > 0) {
    var blogswiper = new Swiper('.client-swiper-2', {
      slidesPerView: 4,
      spaceBetween: 20,
      speed: 1500,
      loop: true,
      autoplay: {
        delay: 2500,
      },
      breakpoints: {
        1280: {
          slidesPerView: 5,
        },
        991: {
          slidesPerView: 4,
        },
        767: {
          slidesPerView: 3,
        },
        320: {
          slidesPerView: 2,
        },
      }
    });
  }


  // Testimonial Swiper 5
  if (jQuery('.project-carousel').length > 0) {
    var swiper3 = new Swiper('.project-carousel', {
      speed: 1500,
      parallax: true,
      slidesPerView: 3,
      spaceBetween: 0,
      loop: true,
      navigation: {
        nextEl: '.project-prev',
        prevEl: '.project-next',
      },
      breakpoints: {
        1191: {
          slidesPerView: 3,
        },
        691: {
          slidesPerView: 2,
        },
        320: {
          slidesPerView: 1,
        },
      }
    });
  }

  if (jQuery('.testimonial-swiper9').length > 0) {
    var swiper = new Swiper(".testimonial-swiper9-thumb", {
      spaceBetween: 5,
      slidesPerView: 7,
      freeMode: true,
      watchSlidesProgress: true,
      breakpoints: {
        1366: {
          slidesPerView: 7,
        },
        1191: {
          slidesPerView: 6,
        },
        991: {
          slidesPerView: 5,
        },
        767: {
          slidesPerView: 4,
        },
        591: {
          slidesPerView: 3,
        },
        320: {
          slidesPerView: 2,
        },
      }
    });
    var swiper2 = new Swiper(".testimonial-swiper9", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".testimonial-next9",
        prevEl: ".testimonial-prev9",
      },
      thumbs: {
        swiper: swiper,
      },

    });
  }

});
jQuery(window).on('resize', function () {
  homeSlider();
});
/* Document .ready END */


const lightbox = GLightbox({
  selector: '*[data-glightbox]',
  touchNavigation: true,
  loop: false,
  zoomable: false,
  autoplayVideos: false,
  moreLength: 0,
  slideExtraAttributes: {
    poster: ''
  },
});


var grids = document.querySelectorAll('.grid');
if(grids != null) {
  grids.forEach(g => {
    var grid = g.querySelector('.isotope');
    var filtersElem = g.querySelector('.isotope-filter');
    var buttonGroups = g.querySelectorAll('.isotope-filter');
    var iso = new Isotope(grid, {
      itemSelector: '.item',
      layoutMode: 'masonry',
      masonry: {
        columnWidth: grid.offsetWidth / 12
      },
      percentPosition: true,
      transitionDuration: '0.7s'
    });
    imagesLoaded(grid).on("progress", function() {
      iso.layout({
        masonry: {
          columnWidth: grid.offsetWidth / 12
        }
      })
    }),
      window.addEventListener("resize", function() {
        iso.arrange({
          masonry: {
            columnWidth: grid.offsetWidth / 12
          }
        });
      }, true);
    if(filtersElem != null) {
      filtersElem.addEventListener('click', function(event) {
        if(!matchesSelector(event.target, '.filter-item')) {
          return;
        }
        var filterValue = event.target.getAttribute('data-filter');
        iso.arrange({
          filter: filterValue
        });
      });
      for(var i = 0, len = buttonGroups.length; i < len; i++) {
        var buttonGroup = buttonGroups[i];
        buttonGroup.addEventListener('click', function(event) {
          if(!matchesSelector(event.target, '.filter-item')) {
            return;
          }
          buttonGroup.querySelector('.active').classList.remove('active');
          event.target.classList.add('active');
        });
      }
    }
  });
}

var overlay = document.querySelectorAll('.overlay > a, .overlay > span');
for(var i = 0; i < overlay.length; i++) {
  var overlay_bg = document.createElement('span');
  overlay_bg.className = "bg";
  overlay[i].appendChild(overlay_bg);
}
