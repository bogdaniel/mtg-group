"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[253],{8476:(e,i,s)=>{s(2320),s(5728),s(228),s(24),s(4338),s(6869);var a=s(9755),t=s.n(a),n=s(8566),l=(s(7729),s(2711)),r=s.n(l),o=s(7652),p=s(8678),d=(s(9843),s(8751),s(4772));s(3138),s(9738),s(682);window.$=t();s(8831);s(9738),s(9465);s(7564),s(3391);s(8775),s(8541);var c=function(){var e=t()(window).width(),i=function(e){var i=t()(document).scrollTop();t()(".navbar-nav-scroll a:first").each((function(){var e=t()(this),s=t()("header .main-bar").height();if(t()(e.attr("href")).length>0){var a=t()(e.attr("href"));a.offset().top-(s+10)<=i&&a.offset().top+a.height()>i?(t()(".navbar-nav-scroll a").removeClass("active"),e.addClass("active")):e.removeClass("active")}}))},s=function(){e<=991&&t()(".navbar-nav > li > a, .sub-menu > li > a").unbind().on("click",(function(e){t()(this).parent().hasClass("open")?t()(this).parent().removeClass("open"):(t()(this).parent().parent().find("li").removeClass("open"),t()(this).parent().addClass("open"))})),t()(".menu-btn, .openbtn").unbind().on("click",(function(){t()(".contact-sidebar").addClass("active")})),t()(".menu-close").unbind().on("click",(function(){t()(".contact-sidebar").removeClass("active"),t()(".menu-btn").removeClass("open")})),t()(".full-sidenav .navbar-nav > li > a").next(".sub-menu").slideUp(),t()(".full-sidenav .sub-menu > li > a").next(".sub-menu").slideUp(),t()(".full-sidenav .navbar-nav > li > a, .full-sidenav .sub-menu > li > a").unbind().on("click",(function(e){t()(this).hasClass("dz-open")?(t()(this).removeClass("dz-open"),t()(this).parent("li").children(".sub-menu").slideUp()):(t()(this).addClass("dz-open"),t()(this).parent("li").children(".sub-menu").length>0?(e.preventDefault(),t()(this).next(".sub-menu").slideDown(),t()(this).parent("li").siblings("li").children(".sub-menu").slideUp()):t()(this).next(".sub-menu").slideUp())})),t()(".header-full .navbar-toggler").unbind().on("click",(function(){t()(".header-full .navbar-toggler").hasClass("open")?t()(".header-full .navbar-toggler").addClass("open"):t()(".header-full .navbar-toggler").removeClass("open"),t()(".full-sidenav").toggleClass("active")})),t()(".menu-close").unbind().on("click",(function(){t()(".menu-close,.full-sidenav").removeClass("active"),t()(".header-full .navbar-toggler").removeClass("open")}))},a=function(){var e=t()(this),i=e.find(".modal-dialog");e.css("display","block"),i.css("margin-top",Math.max(0,(t()(window).height()-i.height())/2))},l=new Date;l.setMonth(l.getMonth()+1),l="".concat(l.getDate()," ").concat(["January","February","March","April","May","June","July","August","September","October","November","December"][l.getMonth()]," ").concat(l.getFullYear());var r=function(){var e=t()(".countdown-timer").data("date");if(null!=e&&""!=e&&(l=e),t()(".countdown-timer").length>0){var i=new Date;i=i.getTime();var s=new Date;s=s.getTime();var a=new Date(l);a=a.getTime(),t()(".countdown-timer").final_countdown({start:i/1e3,end:a/1e3,now:s/1e3,selectors:{value_seconds:".clock-seconds .val",canvas_seconds:"canvas-seconds",value_minutes:".clock-minutes .val",canvas_minutes:"canvas-minutes",value_hours:".clock-hours .val",canvas_hours:"canvas-hours",value_days:".clock-days .val",canvas_days:"canvas-days"},seconds:{borderColor:t()(".type-seconds").attr("data-border-color"),borderWidth:"5"},minutes:{borderColor:t()(".type-minutes").attr("data-border-color"),borderWidth:"5"},hours:{borderColor:t()(".type-hours").attr("data-border-color"),borderWidth:"5"},days:{borderColor:t()(".type-days").attr("data-border-color"),borderWidth:"5"}},(function(){t().ajax({type:"POST",url:akcel_js_data.admin_ajax_url,data:"action=change_theme_status_ajax&security=".concat(akcel_js_data.ajax_security_nonce),success:function(e){location.reload()}})}))}};return{init:function(){var s,n;t()(".box-hover").on("mouseenter",(function(){t()(this).parent().parent().find(".box-hover").removeClass("active"),t()(this).addClass("active")})),function(){if(parseInt(t()(".onepage").css("height"),10),t()(".scroll").unbind().on("click",(function(e){if(e.preventDefault(),""!==this.hash){var i=this.hash,s=t()(i).offset().top,a=parseInt(t()(".onepage").css("height"),10);t()("body").scrollspy({target:".navbar",offset:a+2});var n=s-a;t()("html, body").animate({scrollTop:n},100,(function(){}))}})),t()(".navbar-nav-scroll").length>0){t()(document).on("scroll",i);var e=parseInt(t()(".main-bar-wraper").css("height"),10);t()('.navbar-nav-scroll a[href^="#"]').on("click",(function(s){s.preventDefault(),t()(document).off("scroll"),t()(".navbar-nav-scroll a").each((function(){t()(this).removeClass("active")})),t()(this).addClass("active");var a=this.hash,n=t()(a);n.length>0&&t()("html, body").stop().animate({scrollTop:n.offset().top-e},500,"swing",(function(){t()(document).on("scroll",i)}))}))}}(),s=t()("#quik-search-btn"),n=t()("#quik-search-remove"),s.on("click",(function(){t()(".dz-quik-search").fadeIn(500),t()(".dz-quik-search").addClass("On")})),n.on("click",(function(){t()(".dz-quik-search").fadeOut(500),t()(".dz-quik-search").removeClass("On")})),t()(".mfp-gallery").length>0&&t()(".mfp-gallery").magnificPopup({delegate:".mfp-link",type:"image",tLoading:"Loading image #%curr%...",mainClass:"mfp-img-mobile",gallery:{enabled:!0,navigateByImgClick:!0,preload:[0,1]},image:{tError:'<a href="%url%">The image #%curr%</a> could not be loaded.',titleSrc:function(e){var i=e.el;return"".concat(i.attr("title"),"<small></small>")}}}),t()(".mfp-video").length>0&&t()(".mfp-video").magnificPopup({type:"iframe",iframe:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe><div class="mfp-title">Some caption</div></div>'},callbacks:{markupParse:function(e,i,s){var a=s.el;i.title=a.attr("title")}}}),t()(".popup-youtube, .popup-vimeo, .popup-gmaps").length>0&&t()(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({disableOn:700,type:"iframe",mainClass:"mfp-fade",removalDelay:160,preloader:!1,fixedContentPos:!1}),function(){var e=t()("button.scroltop");e.on("click",(function(){return t()("html, body").animate({scrollTop:0},1e3),!1})),t()(window).on("scroll",(function(){t()(window).scrollTop()>900?t()("button.scroltop").fadeIn(1e3):t()("button.scroltop").fadeOut(1e3)}))}(),t()(window).on("scroll",(function(){if(t()(".sticky-header").length>0){var e=t()(".sticky-header");t()(window).scrollTop()>e.offset().top?(e.addClass("is-fixed"),t()(".site-header .container > .logo-header .logo").attr("src","images/logo.png"),t()(".site-header .container > .logo-header .logo-2").attr("src","images/logo-2.png"),t()(".site-header .container > .logo-header .logo-3").attr("src","images/logo-3.png")):(e.removeClass("is-fixed"),t()(".site-header .container > .logo-header .logo, .site-header .container > .logo-header .logo-2, .site-header .container > .logo-header .logo-3").attr("src","images/logo-white.png"))}})),t()('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>'),t()('iframe[src*="vimeo.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"></div>'),t()("#image-gallery-mix").length&&(t()(".gallery-filter").find("li").each((function(){t()(this).addClass("filter")})),t()("#image-gallery-mix").mixItUp()),t()(".gallery-filter.masonary").length&&t()(".gallery-filter.masonary").on("click","span",(function(){var e=t()(this).parent().attr("data-filter");return t()(".gallery-filter.masonary span").parent().removeClass("active"),t()(this).parent().addClass("active"),t()("#image-gallery-isotope").isotope({filter:e}),!1})),function(e){t()(".countdown").length&&t()(".countdown").countdown({date:e},(function(){t()(".countdown").text("we are live")}))}(l),r(),t()(".full-height").css("height",t()(window).height()),t()(window).on("resize",(function(){t()(".modal:visible").each(a)})),t()("#lightgallery, .lightgallery").length>0&&t()("#lightgallery, .lightgallery").lightGallery({selector:".lightimg",loop:!0,thumbnail:!0,exThumbImage:"data-exthumbimage",download:!1,share:!1}),function(){if(t()(".setResizeMargin").length>0&&e>=1280){var i=t()(".container").width(),s=(e-i)/2;t()(".setResizeMargin").css("margin-left",s)}}(),t()("#kenburn").length>0&&t()("#kenburn").slippry({transition:"kenburns",useCSS:!0,speed:8e3,pause:2500,auto:!0,preload:"visible",autoHover:!1}),t().isFunction(t().fn.selectpicker)&&t()("select").selectpicker(),t()(".modal").on("show.bs.modal",a),t()(".heart").on("click",(function(){t()(this).toggleClass("heart-blast")})),t()(".dezPlaceAni").length&&(t()(".dezPlaceAni input, .dezPlaceAni textarea").on("focus",(function(){t()(this).parents(".input-group").addClass("focused")})),t()(".dezPlaceAni input, .dezPlaceAni textarea").on("blur",(function(){""==t()(this).val()?(t()(this).removeClass("filled"),t()(this).parents(".input-group").removeClass("focused")):t()(this).addClass("filled")}))),t()(".deznav-scroll").length>0&&(new d.Z(".deznav-scroll").isRtl=!1)},load:function(){var e;s(),e=document.querySelector(".counter"),t()(".counter").length&&(console.log("freeee"),(0,n.ZP)(e,{duration:2500,delay:16})),function(){if(t()("#masonry, .masonry").length>0){var e=t()("#masonry, .masonry");if(t()(".card-container").length>0){e.data("gutter");var i=void 0===e.data("gutter")?0:e.data("gutter");i=parseInt(i,10);var s=void 0===e.attr("data-column-width")?"":e.attr("data-column-width");""!=s&&(s=parseInt(s,10)),e.imagesLoaded((function(){e.masonry({gutterWidth:15,isAnimated:!0,itemSelector:".card-container"})}))}}t()(".filters").length&&(t()(".filters li:first").addClass("active"),t()(".filters").on("click","li",(function(){t()(".filters li").removeClass("active"),t()(this).addClass("active");var i=t()(this).attr("data-filter");e.isotope({filter:i})})))}(),t()("svg.radial-progress").length>0&&(t()("svg.radial-progress").each((function(e,i){t()(this).find(t()("circle.complete")).removeAttr("style")})),t()(window).on("scroll",(function(){t()("svg.radial-progress").each((function(e,i){if(t()(window).scrollTop()>t()(this).offset().top-.75*t()(window).height()&&t()(window).scrollTop()<t()(this).offset().top+t()(this).height()-.25*t()(window).height()){var s=t()(i).data("percentage"),a=t()(this).find(t()("circle.complete")).attr("r"),n=2*Math.PI*a,l=n-s*n/100;t()(this).find(t()("circle.complete")).animate({"stroke-dashoffset":l},1250)}}))})).trigger("scroll"))},resize:function(){r(),e=t()(window).width(),s()}}}();function w(){if(t()(".main-slider-swiper").length>0)new o.Z(".main-slider-swiper",{modules:[p.W_,p.tl,p.pt],speed:1500,parallax:!0,slidesPerView:1,direction:"horizontal",loop:!1,autoplay:!1,navigation:{nextEl:".swiper-button-next1",prevEl:".swiper-button-prev1"}})}t()(document).ready((function(){c.init(),t()('a[data-toggle="tab"]').on("click",(function(){t()(t()(this).attr("href")).show().addClass("show active").siblings().hide()})),t()(".navicon").on("click",(function(){t()(this).toggleClass("open")}))})),t()(window).on("load",(function(){c.load(),setTimeout((function(){r().init(),t()("#loading-area").remove()}),1e3)})),t()(window).on("resize",(function(){c.resize()})),t()(document).ready((function(){if(setTimeout((function(){w()}),300),t()(".testimonial-swiper1").length>0)new o.Z(".testimonial-swiper1",{speed:1500,slidesPerView:1,spaceBetween:30,autoplay:{delay:2500}});if(t()(".testimonial-swiper2").length>0)new o.Z(".testimonial-swiper2",{speed:1500,slidesPerView:2,spaceBetween:0,loop:!0,autoplay:{delay:2500},breakpoints:{1024:{slidesPerView:2},320:{slidesPerView:1}},pagination:{el:".swiper-pagination"}});if(t()(".testimonial-swiper3").length>0)new o.Z(".testimonial-swiper3",{speed:1500,slidesPerView:3,spaceBetween:30,autoplay:{delay:2500},pagination:{el:".swiper-pagination1",clickable:!0,renderBullet:function(e,i){return'<span class="'+i+'">'+(e+1)+"</span>"}},breakpoints:{1024:{slidesPerView:3},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".testimonial-swiper4").length>0)new o.Z(".testimonial-swiper4",{speed:1500,parallax:!0,slidesPerView:3,spaceBetween:30,loop:!0,pagination:{el:".swiper-pagination",clickable:!0},navigation:{nextEl:".swiper-button-next3",prevEl:".swiper-button-prev3"},breakpoints:{1191:{slidesPerView:2},691:{slidesPerView:1},320:{slidesPerView:1}}});if(t()(".testimonial-swiper5").length>0)new o.Z(".testimonial-swiper5",{speed:1500,parallax:!0,slidesPerView:3,spaceBetween:30,loop:!0,pagination:{el:".swiper-pagination5",clickable:!0,renderBullet:function(e,i){return'<span class="'+i+'">0'+(e+1)+"</span>"}},navigation:{nextEl:".swiper-button-next3",prevEl:".swiper-button-prev3"},breakpoints:{1191:{slidesPerView:2},691:{slidesPerView:1},320:{slidesPerView:1}}});if(t()(".testimonial-swiper6").length>0)new o.Z(".testimonial-swiper6",{speed:1500,slidesPerView:2,spaceBetween:30,loop:!0,autoplay:{delay:2500},breakpoints:{1024:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".testimonial-swiper7").length>0)new o.Z(".testimonial-swiper7",{speed:1500,slidesPerView:3,spaceBetween:30,autoplay:{delay:2500},pagination:{el:".swiper-pagination1",clickable:!0,renderBullet:function(e,i){return'<span class="'+i+'">'+(e+1)+"</span>"}},breakpoints:{1024:{slidesPerView:3},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".testimonial-swiper8").length>0)new o.Z(".testimonial-swiper8",{speed:1500,slidesPerView:1,spaceBetween:30,autoplay:{delay:2500},navigation:{nextEl:".testimonial-prev8",prevEl:".testimonial-next8"}});if(t()(".team-swiper1").length>0)new o.Z(".team-swiper1",{speed:1500,slidesPerView:3,spaceBetween:30,loop:!0,autoplay:{delay:2500},navigation:{nextEl:".swiper-button-next2",prevEl:".swiper-button-prev2"},breakpoints:{1191:{slidesPerView:3},991:{slidesPerView:3},591:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".team-swiper2").length>0)new o.Z(".team-swiper2",{speed:1500,slidesPerView:3,spaceBetween:30,loop:!0,autoplay:{delay:2500},pagination:{el:".swiper-pagination-team-2",clickable:!0,renderBullet:function(e,i){return'<span class="'+i+'">0'+(e+1)+"</span>"}},navigation:{nextEl:".swiper-button-next2",prevEl:".swiper-button-prev2"},breakpoints:{1191:{slidesPerView:3},991:{slidesPerView:3},591:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".team-swiper3").length>0)new o.Z(".team-swiper3",{speed:1500,parallax:!0,slidesPerView:4,spaceBetween:30,loop:!0,navigation:{nextEl:".swiper-button-next4",prevEl:".swiper-button-prev4"},breakpoints:{1191:{slidesPerView:4},991:{slidesPerView:3},591:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".team-swiper4").length>0)new o.Z(".team-swiper4",{speed:1500,slidesPerView:4,spaceBetween:30,loop:!0,centeredSlides:!0,autoplay:{delay:2500},navigation:{nextEl:".team-next",prevEl:".team-prev"},breakpoints:{1191:{slidesPerView:4},991:{slidesPerView:3},591:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".team-swiper5").length>0)new o.Z(".team-swiper5",{speed:1500,spaceBetween:30,slidesPerView:4,loop:!0,autoplay:{delay:2500},pagination:{el:".swiper-pagination"},breakpoints:{1191:{slidesPerView:4},991:{slidesPerView:3},591:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".services-swiper").length>0)new o.Z(".services-swiper",{speed:1500,parallax:!0,slidesPerView:4,spaceBetween:30,pagination:{el:".swiper-pagination",clickable:!0},breakpoints:{1191:{slidesPerView:4},991:{slidesPerView:3},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".portfolio-swiper").length>0)new o.Z(".portfolio-swiper",{speed:1500,parallax:!0,slidesPerView:4,spaceBetween:30,pagination:{el:".swiper-pagination",clickable:!0},breakpoints:{1191:{slidesPerView:4},691:{slidesPerView:1},320:{slidesPerView:1}}});if(t()(".main-slider-swiper-04").length>0)var e=new o.Z(".main-slider-swiper-04",{speed:1500,parallax:!0,loop:!0,autoplay:!0,pagination:{el:".swiper-pagination",clickable:!0}});if(t()(".swiper-portfolio1").length>0)new o.Z(".swiper-portfolio1",{slidesPerView:1,spaceBetween:30,speed:1500,loop:!0,autoplay:{delay:2500},breakpoints:{1280:{slidesPerView:4},991:{slidesPerView:3},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".blog-swiper").length>0)new o.Z(".blog-swiper",{slidesPerView:3,spaceBetween:0,speed:1500,loop:!0,autoplay:{delay:2500},breakpoints:{1191:{slidesPerView:3},991:{slidesPerView:2},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".post-swiper").length>0)new o.Z(".post-swiper",{slidesPerView:1,spaceBetween:0,speed:1500,loop:!0,autoplay:{delay:2500},navigation:{nextEl:".prev-post-swiper-btn",prevEl:".next-post-swiper-btn"}});if(t()(".blog-swiper-2").length>0)new o.Z(".blog-swiper-2",{slidesPerView:3,spaceBetween:20,speed:1500,loop:!0,autoplay:{delay:2500},breakpoints:{1600:{slidesPerView:3},991:{slidesPerView:2},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".clients-swiper").length>0)new o.Z(".clients-swiper",{speed:1500,parallax:!0,slidesPerView:4,spaceBetween:30,autoplay:{delay:2500},loop:!0,navigation:{nextEl:".swiper-button-next5",prevEl:".swiper-button-prev5"},breakpoints:{1191:{slidesPerView:6},991:{slidesPerView:5},691:{slidesPerView:4},591:{slidesPerView:3},320:{slidesPerView:2}}});if(t()(".client-swiper-2").length>0)new o.Z(".client-swiper-2",{slidesPerView:4,spaceBetween:20,speed:1500,loop:!0,autoplay:{delay:2500},breakpoints:{1280:{slidesPerView:5},991:{slidesPerView:4},767:{slidesPerView:3},320:{slidesPerView:2}}});if(t()(".project-carousel").length>0)new o.Z(".project-carousel",{speed:1500,parallax:!0,slidesPerView:3,spaceBetween:0,loop:!0,navigation:{nextEl:".project-prev",prevEl:".project-next"},breakpoints:{1191:{slidesPerView:3},691:{slidesPerView:2},320:{slidesPerView:1}}});if(t()(".testimonial-swiper9").length>0)e=new o.Z(".testimonial-swiper9-thumb",{spaceBetween:5,slidesPerView:7,freeMode:!0,watchSlidesProgress:!0,breakpoints:{1366:{slidesPerView:7},1191:{slidesPerView:6},991:{slidesPerView:5},767:{slidesPerView:4},591:{slidesPerView:3},320:{slidesPerView:2}}}),new o.Z(".testimonial-swiper9",{spaceBetween:10,navigation:{nextEl:".testimonial-next9",prevEl:".testimonial-prev9"},thumbs:{swiper:e}})})),t()(window).on("resize",(function(){w()}))}},e=>{e.O(0,[137],(()=>{return i=8476,e(e.s=i);var i}));e.O()}]);