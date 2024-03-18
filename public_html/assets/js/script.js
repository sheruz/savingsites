 // text offer functionality 
                setTimeout(function(){  
                 
                     $(document).find(".textmeoffer a").click(function(e){
                        e.preventDefault();
                       $("#textoffer").modal('show');
                     });

                     $(document).on('click','.text_me_offer',function(e){  
                            e.preventDefault();
                            var form_data = $("#form2").serialize();
                            var adId = $('.addid').val();
                            sendText(adId);      
                 
                    });


                }, 3000);

function sendText(adId){

    if($("#phone_textmeoffer").val() == "") { 
         toastr.error('Please enter the Mobile Number.');
        return;
    }    
     if($("#phone_textmeoffer").val() == "") { 
         toastr.error('Please enter the Mobile Number.');
        return;
    }    
    if($('#carrier').val() == 0){
 toastr.error('Please Select your Carrie!'); return;
} 
    $.cookie("phoneNumber", $("#phone_textmeoffer").val(), { expires: 90 });        
    $.cookie("carrier", $("#carrier").val(), { expires: 90 });        
    sendIt(adId, $("#phone_textmeoffer").val() + "@" + $("#carrier").val(),$('#name_textmeoffer').val());            
}
function sendIt(adId, emailAddress, nametext){   
    var dataToUse = {
        "adId": adId,
        "emailAddress":emailAddress,
        "text":nametext
    };
       $.ajax({
        'type': "POST",
        'url': base_url+"ads/mailad/",
        'cache': false,
        'data':dataToUse,
        success : function(data){ 

          data = JSON.parse(data);
            if(data.status){
                  toastr.success('There can create a delay in text message delivery, Please wait!', data.message);
                  $('#textoffer').modal('hide');
            }
            else{
                 toastr.error('',data.message);
            }

          
        }
    });


}


$(document).on('change', '#tab_selector', function(e) {
	var myval= $(this).val();
	var className = $(this).children("option:selected").attr('class');
if(className.indexOf("clicksnapsignup") != -1){
$(this).parent().parent().parent().parent().find('.tabs-vertical.tabs-line .nav-tabs li a').eq(myval).click();
}
else{
 $(this).parent().parent().parent().parent().find('.tabs-vertical.tabs-line .nav-tabs li a').eq(myval).tab('show');
}
});

$(document).ready(function(){
	
	$(".owl-carousel").owlCarousel({
		autoplay: true,
		dots: false,
		nav:true,
		items:1,
		navText:[""]
	});
	
});

"use strict";
// @anish
var link_path ; 
var base_url ;
var zoneId ;
(function () {
	// Global variables
	var userAgent = navigator.userAgent.toLowerCase(),
			initialDate = new Date(),

			$document = $(document),
			$window = $(window),
			$html = $("html"),
			$body = $("body"),
			livedemo = false,

			isDesktop = $html.hasClass("desktop"),
			isIE = userAgent.indexOf("msie") !== -1 ? parseInt(userAgent.split("msie")[1], 10) : userAgent.indexOf("trident") !== -1 ? 11 : userAgent.indexOf("edge") !== -1 ? 12 : false,
			isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
			windowReady = false,
			isNoviBuilder = false,
			loaderTimeoutId,

			plugins = {
				bootstrapTooltip: $("[data-toggle='tooltip']"),
				bootstrapModalDialog: $('.modal'),
				bootstrapTabs: $(".tabs-custom"),
				rdNavbar: $(".rd-navbar"),
				wow: $(".wow"),
				owl: $(".owl-carousel"),
				//swiper: $(".swiper-slider"),
				slick: $('.slick-slider'),
				statefulButton: $('.btn-stateful'),
				popover: $('[data-toggle="popover"]'),
				viewAnimate: $('.view-animate'),
				radio: $("input[type='radio']"),
				checkbox: $("input[type='checkbox']"),
				customToggle: $("[data-custom-toggle]"),
				scroller: $(".scroll-wrap"),
				copyrightYear: $(".copyright-year"),
				layoutToggle: $(".layout-toggle"),
				radioPanel: $('.radio-panel .radio-inline'),
				multitoggle: document.querySelectorAll('[data-multitoggle]'),
				hoverEls: document.querySelectorAll('[data-hover-group]'),
			};

	// Initialize scripts that require a finished document
	$(function () {
        isNoviBuilder = false;
		/**
		 * @desc Calculate the height of swiper slider basing on data attr
		 * @param {object} object - slider jQuery object
		 * @param {string} attr - attribute name
		 * @return {number} slider height
		 */
		function getSwiperHeight(object, attr) {
			var val = object.attr("data-" + attr),
					dim;

			if (!val) {
				return undefined;
			}

			dim = val.match(/(px)|(%)|(vh)|(vw)$/i);

			if (dim.length) {
				switch (dim[0]) {
					case "px":
						return parseFloat(val);
					case "vh":
						return $window.height() * (parseFloat(val) / 100);
					case "vw":
						return $window.width() * (parseFloat(val) / 100);
					case "%":
						return object.width() * (parseFloat(val) / 100);
				}
			} else {
				return undefined;
			}
		}

		/**
		 * @desc Toggle swiper videos on active slides
		 * @param {object} swiper - swiper slider
		 */
		function toggleSwiperInnerVideos(swiper) {
			var prevSlide = $(swiper.slides[swiper.previousIndex]),
					nextSlide = $(swiper.slides[swiper.activeIndex]),
					videos,
					videoItems = prevSlide.find("video");

			for (var i = 0; i < videoItems.length; i++) {
				videoItems[i].pause();
			}

			videos = nextSlide.find("video");
			if (videos.length) {
				videos.get(0).play();
			}
		}

		/**
		 * @desc Toggle swiper animations on active slides
		 * @param {object} swiper - swiper slider
		 */
		function toggleSwiperCaptionAnimation(swiper) { alert(1); 
			var prevSlide = $(swiper.container).find("[data-caption-animate]"),
					nextSlide = $(swiper.slides[swiper.activeIndex]).find("[data-caption-animate]"),
					delay,
					duration,
					nextSlideItem,
					prevSlideItem;

			for (var i = 0; i < prevSlide.length; i++) {
				prevSlideItem = $(prevSlide[i]);

				prevSlideItem.removeClass("animated")
				.removeClass(prevSlideItem.attr("data-caption-animate"))
				.addClass("not-animated");
			}


			var tempFunction = function (nextSlideItem, duration) {
				return function () {
					nextSlideItem
					.removeClass("not-animated")
					.addClass(nextSlideItem.attr("data-caption-animate"))
					.addClass("animated");
					if (duration) {
						nextSlideItem.css('animation-duration', duration + 'ms');
					}
				};
			};

			for (var i = 0; i < nextSlide.length; i++) {
				nextSlideItem = $(nextSlide[i]);
				delay = nextSlideItem.attr("data-caption-delay");
				duration = nextSlideItem.attr('data-caption-duration');
				if (!isNoviBuilder) {
					if (delay) {
						setTimeout(tempFunction(nextSlideItem, duration), parseInt(delay, 10));
					} else {
						tempFunction(nextSlideItem, duration);
					}

				} else {
					nextSlideItem.removeClass("not-animated")
				}
			}
		}

		/**
		 * @desc Check the element was been scrolled into the view
		 * @param {object} elem - jQuery object
		 * @return {boolean}
		 */
		function isScrolledIntoView(elem) {
			if (isNoviBuilder) return true;
			return elem.offset().top + elem.outerHeight() >= $window.scrollTop() && elem.offset().top <= $window.scrollTop() + $window.height();
		}

		/**
		 * @desc Calls a function when element has been scrolled into the view
		 * @param {object} element - jQuery object
		 * @param {function} func - init function
		 */
		function lazyInit(element, func) {
			var scrollHandler = function () {
				if (( !element.hasClass('lazy-loaded') && ( isScrolledIntoView(element) ) )) {
					func.call();
					element.addClass('lazy-loaded');
				}
			};

			scrollHandler();
			$window.on('scroll', scrollHandler);
		}

		/**
		 * @desc Initialize owl carousel plugin
		 * @param {object} c - carousel jQuery object
		 */
		function initOwlCarousel(c) {
			var aliaces = ["-", "-sm-", "-md-", "-lg-", "-xl-", "-xxl-"],
					values = [0, 576, 768, 992, 1200, 1600],
					responsive = {};

			for (var j = 0; j < values.length; j++) {
				responsive[values[j]] = {};
				for (var k = j; k >= -1; k--) {
					if (!responsive[values[j]]["items"] && c.attr("data" + aliaces[k] + "items")) {
						responsive[values[j]]["items"] = k < 0 ? 1 : parseInt(c.attr("data" + aliaces[k] + "items"), 10);
					}
					if (!responsive[values[j]]["stagePadding"] && responsive[values[j]]["stagePadding"] !== 0 && c.attr("data" + aliaces[k] + "stage-padding")) {
						responsive[values[j]]["stagePadding"] = k < 0 ? 0 : parseInt(c.attr("data" + aliaces[k] + "stage-padding"), 10);
					}
					if (!responsive[values[j]]["margin"] && responsive[values[j]]["margin"] !== 0 && c.attr("data" + aliaces[k] + "margin")) {
						responsive[values[j]]["margin"] = k < 0 ? 30 : parseInt(c.attr("data" + aliaces[k] + "margin"), 10);
					}
				}
			}

			// Enable custom pagination
			if (c.attr('data-dots-custom')) {
				c.on("initialized.owl.carousel", function (event) {
					var carousel = $(event.currentTarget),
							customPag = $(carousel.attr("data-dots-custom")),
							active = 0;

					if (carousel.attr('data-active')) {
						active = parseInt(carousel.attr('data-active'), 10);
					}

					carousel.trigger('to.owl.carousel', [active, 300, true]);
					customPag.find("[data-owl-item='" + active + "']").addClass("active");

					customPag.find("[data-owl-item]").on('click', function (e) {
						e.preventDefault();
						carousel.trigger('to.owl.carousel', [parseInt(this.getAttribute("data-owl-item"), 10), 300, true]);
					});

					carousel.on("translate.owl.carousel", function (event) {
						customPag.find(".active").removeClass("active");
						customPag.find("[data-owl-item='" + event.item.index + "']").addClass("active")
					});
				});
			}

			c.on("initialized.owl.carousel", function () {
				//initLightGalleryItem(c.find('[data-lightgallery="item"]'), 'lightGallery-in-carousel');
			});

			c.owlCarousel({
				autoplay: isNoviBuilder ? false : c.attr("data-autoplay") === "true",
				loop: isNoviBuilder ? false : c.attr("data-loop") !== "false",
				items: 1,
				center: c.attr("data-center") === "true",
				dotsContainer: c.attr("data-pagination-class") || false,
				navContainer: c.attr("data-navigation-class") || false,
				mouseDrag: isNoviBuilder ? false : c.attr("data-mouse-drag") !== "false",
				nav: c.attr("data-nav") === "true",
				dots: c.attr("data-dots") === "true",
				dotsEach: c.attr("data-dots-each") ? parseInt(c.attr("data-dots-each"), 10) : false,
				animateIn: c.attr('data-animation-in') ? c.attr('data-animation-in') : false,
				animateOut: c.attr('data-animation-out') ? c.attr('data-animation-out') : false,
				responsive: responsive,
				navText: function () {
					try {
						return JSON.parse(c.attr("data-nav-text"));
					} catch (e) {
						return [];
					}
				}(),
				navClass: function () {
					try {
						return JSON.parse(c.attr("data-nav-class"));
					} catch (e) {
						return ['owl-prev', 'owl-next'];
					}
				}()
			});
		}

		/**
		 * @desc Check the element whas been scrolled into the view
		 * @param {object} elem - jQuery object
		 * @return {boolean}
		 */
		function isScrolledIntoView(elem) {
			if (!isNoviBuilder) {
				return elem.offset().top + elem.outerHeight() >= $window.scrollTop() && elem.offset().top <= $window.scrollTop() + $window.height();
			}
			else {
				return true;
			}
		}

		/**
		 * @desc Calls a function when element has been scrolled into the view
		 * @param {object} element - jQuery object
		 * @param {function} func - callback function
		 */
		function lazyInit(element, func) {
			$document.on('scroll', function () {
				if ((!element.hasClass('lazy-loaded') && (isScrolledIntoView(element)))) {
					func.call();
					element.addClass('lazy-loaded');
				}
			}).trigger("scroll");
		}


		/**
		 * @desc Initialize Bootstrap tooltip with required placement
		 * @param {string} tooltipPlacement
		 */
		function initBootstrapTooltip(tooltipPlacement) {
			plugins.bootstrapTooltip.tooltip('dispose');

			if (window.innerWidth < 576) {
				plugins.bootstrapTooltip.tooltip({placement: 'bottom'});
			} else {
				plugins.bootstrapTooltip.tooltip({placement: tooltipPlacement});
			}
		}

		// Additional class on html if mac os.
		if (navigator.platform.match(/(Mac)/i)) {
			$html.addClass("mac-os");
		}

		// Adds some loosing functionality to IE browsers (IE Polyfills)
		if (isIE) {
			if (isIE < 10) {
				$html.addClass("lt-ie-10");
			}

			if (isIE < 11) {
				$.getScript('js/pointer-events.min.js')
				.done(function () {
					$html.addClass("ie-10");
					PointerEventsPolyfill.initialize({});
				});
			}

			if (isIE === 11) {
				$html.addClass("ie-11");
			}

			if (isIE === 12) {
				$html.addClass("ie-edge");
			}
		}

		// Bootstrap Tooltips
		if (plugins.bootstrapTooltip.length) {
			var tooltipPlacement = plugins.bootstrapTooltip.attr('data-placement');
			initBootstrapTooltip(tooltipPlacement);

			$window.on('resize orientationchange', function () {
				initBootstrapTooltip(tooltipPlacement);
			})
		}

		// Stop vioeo in bootstrapModalDialog
		if (plugins.bootstrapModalDialog.length) {
			for (var i = 0; i < plugins.bootstrapModalDialog.length; i++) {
				var modalItem = $(plugins.bootstrapModalDialog[i]);

				modalItem.on('hidden.bs.modal', $.proxy(function () {
					var activeModal = $(this),
							rdVideoInside = activeModal.find('video'),
							youTubeVideoInside = activeModal.find('iframe');

					if (rdVideoInside.length) {
						rdVideoInside[0].pause();
					}

					if (youTubeVideoInside.length) {
						var videoUrl = youTubeVideoInside.attr('src');

						youTubeVideoInside
						.attr('src', '')
						.attr('src', videoUrl);
					}
				}, modalItem))
			}
		}

		// Popovers
		if (plugins.popover.length) {
			if (window.innerWidth < 767) {
				plugins.popover.attr('data-placement', 'bottom');
				plugins.popover.popover();
			}
			else {
				plugins.popover.popover();
			}
		}

		// Bootstrap Buttons
		if (plugins.statefulButton.length) {
			$(plugins.statefulButton).on('click', function () {
				var statefulButtonLoading = $(this).button('loading');

				setTimeout(function () {
					statefulButtonLoading.button('reset')
				}, 2000);
			})
		}

		// Bootstrap tabs
		if (plugins.bootstrapTabs.length) {
			for (var i = 0; i < plugins.bootstrapTabs.length; i++) {
				var bootstrapTabsItem = $(plugins.bootstrapTabs[i]);

				//If have slick carousel inside tab - resize slick carousel on click
				if (bootstrapTabsItem.find('.slick-slider').length) {
					bootstrapTabsItem.find('.tabs-custom-list > li > a').on('click', $.proxy(function () {
						var $this = $(this);
						var setTimeOutTime = isNoviBuilder ? 1500 : 300;

						setTimeout(function () {
							$this.find('.tab-content .tab-pane.active .slick-slider').slick('setPosition');
						}, setTimeOutTime);
					}, bootstrapTabsItem));
				}
			}
		}

		// Copyright Year (Evaluates correct copyright year)
		if (plugins.copyrightYear.length) {
			plugins.copyrightYear.text(initialDate.getFullYear());
		}

		// Add custom styling options for input[type="radio"]
		if (plugins.radio.length) {
			for (var i = 0; i < plugins.radio.length; i++) {
				$(plugins.radio[i]).addClass("radio-custom").after("<span class='radio-custom-dummy'></span>")
			}
		}

		// Add custom styling options for input[type="checkbox"]
		if (plugins.checkbox.length) {
			for (var i = 0; i < plugins.checkbox.length; i++) {
				$(plugins.checkbox[i]).addClass("checkbox-custom").after("<span class='checkbox-custom-dummy'></span>")
			}
		}

		// UI To Top
		if (isDesktop && !isNoviBuilder) {
			$().UItoTop({
				easingType: 'easeOutQuad',
				containerClass: 'ui-to-top fa fa-angle-up'
			});
		}

		// Owl carousel
		if (plugins.owl.length) {
			for (var i = 0; i < plugins.owl.length; i++) {
				var c = $(plugins.owl[i]);
				plugins.owl[i].owl = c;

				initOwlCarousel(c);
			}
		}

		// RD Navbar
		if (plugins.rdNavbar.length) {
			var aliaces, i, j, len, value, values, responsiveNavbar;

			aliaces = ["-", "-sm-", "-md-", "-lg-", "-xl-", "-xxl-"];
			values = [0, 576, 768, 992, 1200, 1600];
			responsiveNavbar = {};

			for (i = j = 0, len = values.length; j < len; i = ++j) {
				value = values[i];
				if (!responsiveNavbar[values[i]]) {
					responsiveNavbar[values[i]] = {};
				}
				if (plugins.rdNavbar.attr('data' + aliaces[i] + 'layout')) {
					responsiveNavbar[values[i]].layout = plugins.rdNavbar.attr('data' + aliaces[i] + 'layout');
				}
				if (plugins.rdNavbar.attr('data' + aliaces[i] + 'device-layout')) {
					responsiveNavbar[values[i]]['deviceLayout'] = plugins.rdNavbar.attr('data' + aliaces[i] + 'device-layout');
				}
				if (plugins.rdNavbar.attr('data' + aliaces[i] + 'hover-on')) {
					responsiveNavbar[values[i]]['focusOnHover'] = plugins.rdNavbar.attr('data' + aliaces[i] + 'hover-on') === 'true';
				}
				if (plugins.rdNavbar.attr('data' + aliaces[i] + 'auto-height')) {
					responsiveNavbar[values[i]]['autoHeight'] = plugins.rdNavbar.attr('data' + aliaces[i] + 'auto-height') === 'true';
				}

				if (isNoviBuilder) {
					responsiveNavbar[values[i]]['stickUp'] = false;
				} else if (plugins.rdNavbar.attr('data' + aliaces[i] + 'stick-up')) {
					responsiveNavbar[values[i]]['stickUp'] = plugins.rdNavbar.attr('data' + aliaces[i] + 'stick-up') === 'true';
				}

				if (plugins.rdNavbar.attr('data' + aliaces[i] + 'stick-up-offset')) {
					responsiveNavbar[values[i]]['stickUpOffset'] = plugins.rdNavbar.attr('data' + aliaces[i] + 'stick-up-offset');
				}
			}


			plugins.rdNavbar.RDNavbar({
				anchorNav: !isNoviBuilder,
				stickUpClone: (plugins.rdNavbar.attr("data-stick-up-clone") && !isNoviBuilder) ? plugins.rdNavbar.attr("data-stick-up-clone") === 'true' : false,
				responsive: responsiveNavbar,
				callbacks: {
					onStuck: function () {
						var navbarSearch = this.$element.find('.rd-search input');

						if (navbarSearch) {
							navbarSearch.val('').trigger('propertychange');
						}
					},
					onDropdownOver: function () {
						return !isNoviBuilder;
					},
					onUnstuck: function () {
						if (this.$clone === null)
							return;

						var navbarSearch = this.$clone.find('.rd-search input');

						if (navbarSearch) {
							navbarSearch.val('').trigger('propertychange');
							navbarSearch.trigger('blur');
						}

					}
				}
			});


			if (plugins.rdNavbar.attr("data-body-class")) {
				document.body.className += ' ' + plugins.rdNavbar.attr("data-body-class");
			}
		}

		// Add class in viewport
		if (plugins.viewAnimate.length) {
			for (var i = 0; i < plugins.viewAnimate.length; i++) {
				var $view = $(plugins.viewAnimate[i]).not('.active');
				$document.on("scroll", $.proxy(function () {
					if (isScrolledIntoView(this)) {
						this.addClass("active");
					}
				}, $view))
				.trigger("scroll");
			}
		}

		// Swiper
		/*if (plugins.swiper.length) { 
			for (var i = 0; i < plugins.swiper.length; i++) { 
				var s = $(plugins.swiper[i]);
				var pag = s.find(".swiper-pagination"),
						next = s.find(".swiper-button-next"),
						prev = s.find(".swiper-button-prev"),
						bar = s.find(".swiper-scrollbar"),
						swiperSlide = s.find(".swiper-slide"),
						autoplay = false;

				for (var j = 0; j < swiperSlide.length; j++) {
					var $this = $(swiperSlide[j]),
							url;

					if (url = $this.attr("data-slide-bg")) {
						$this.css({
							"background-image": "url(" + url + ")",
							"background-size": "cover"
						})
					}
				}

				swiperSlide.end()
				.find("[data-caption-animate]")
				.addClass("not-animated")
				.end();

				 s.swiper({
					autoplay: s.attr('data-autoplay') ? s.attr('data-autoplay') === "false" ? undefined : s.attr('data-autoplay') : 5000,
					direction: s.attr('data-direction') && isDesktop ? s.attr('data-direction') : "horizontal",
					effect: s.attr('data-slide-effect') ? s.attr('data-slide-effect') : "slide",
					speed: s.attr('data-slide-speed') ? s.attr('data-slide-speed') : 600,
					disableOnInteraction: true,
					keyboardControl: s.attr('data-keyboard') === "true",
					mousewheelControl: s.attr('data-mousewheel') === "true",
					mousewheelReleaseOnEdges: s.attr('data-mousewheel-release') === "true",
					nextButton: next.length ? next.get(0) : null,
					prevButton: prev.length ? prev.get(0) : null,
					pagination: pag.length ? pag.get(0) : null,
					paginationClickable: pag.length ? pag.attr("data-clickable") !== "false" : false,					
					paginationBulletRender: function (swiper, index, className) {
						if (pag.attr("data-index-bullet") === "true") {
							return '<span class="' + className + '">' + (index + 1) + '</span>';
						} else if (pag.attr("data-bullet-custom") === "true") {
							return '<span class="' + className + '"><span></span></span>';
						} else {
							return '<span class="' + className + '"></span>';
						}
					},
					scrollbar: bar.length ? bar.get(0) : null,
					scrollbarDraggable: bar.length ? bar.attr("data-draggable") !== "false" : true,
					scrollbarHide: bar.length ? bar.attr("data-draggable") === "false" : false,
					loop: isNoviBuilder ? false : s.attr('data-loop') !== "false",
					simulateTouch: s.attr('data-simulate-touch') && !isNoviBuilder ? s.attr('data-simulate-touch') === "true" : false,
					onTransitionStart: function (swiper) {
						toggleSwiperInnerVideos(swiper);
					},
					onTransitionEnd: function (swiper) {
						toggleSwiperCaptionAnimation(swiper);
					},
					onInit: (function (s) {
						return function (swiper) {
							toggleSwiperInnerVideos(swiper);
							toggleSwiperCaptionAnimation(swiper);

							var $swiper = $(s);

							var swiperCustomIndex = $swiper.find('.swiper-pagination__fraction-index').get(0),
									swiperCustomCount = $swiper.find('.swiper-pagination__fraction-count').get(0);

							if (swiperCustomIndex && swiperCustomCount) {
								swiperCustomIndex.innerHTML = formatIndex(swiper.realIndex + 1);
								if (swiperCustomCount) {
									if (isNoviBuilder ? false : s.attr('data-loop') !== "false") {
										swiperCustomCount.innerHTML = formatIndex(swiper.slides.length - 2);
									} else {
										swiperCustomCount.innerHTML = formatIndex(swiper.slides.length);
									}
								}
							}
						}
					}(s)),
					onSlideChangeStart: (function (s) {
						return function (swiper) {
							var swiperCustomIndex = $(s).find('.swiper-pagination__fraction-index').get(0);

							if (swiperCustomIndex) {
								swiperCustomIndex.innerHTML = formatIndex(swiper.realIndex + 1);
							}
						}
					}(s))
				});

				$window.on("resize", (function (s) {
					return function () {
						var mh = getSwiperHeight(s, "min-height"),
								h = getSwiperHeight(s, "height");
						if (h) {
							s.css("height", mh ? mh > h ? mh : h : h);
						}
					}
				})(s)).trigger("resize");
			}
		}*/

		function formatIndex(index) {
			return index < 10 ? '0' + index : index;
		}

		// WOW
		if ($html.hasClass("wow-animation") && plugins.wow.length && !isNoviBuilder && isDesktop) {
			new WOW().init();
		}

		// Custom Toggles
		if (plugins.customToggle.length) {
			for (var i = 0; i < plugins.customToggle.length; i++) {
				var $this = $(plugins.customToggle[i]);

				$this.on('click', $.proxy(function (event) {
					event.preventDefault();

					var $ctx = $(this);
					$($ctx.attr('data-custom-toggle')).add(this).toggleClass('active');
				}, $this));

				if ($this.attr("data-custom-toggle-hide-on-blur") === "true") {
					$body.on("click", $this, function (e) {
						if (e.target !== e.data[0]
								&& $(e.data.attr('data-custom-toggle')).find($(e.target)).length
								&& e.data.find($(e.target)).length === 0) {
							$(e.data.attr('data-custom-toggle')).add(e.data[0]).removeClass('active');
						}
					})
				}

				if ($this.attr("data-custom-toggle-disable-on-blur") === "true") {
					$body.on("click", $this, function (e) {
						if (e.target !== e.data[0] && $(e.data.attr('data-custom-toggle')).find($(e.target)).length === 0 && e.data.find($(e.target)).length === 0) {
							$(e.data.attr('data-custom-toggle')).add(e.data[0]).removeClass('active');
						}
					})
				}
			}
		}

		// Wide/Boxed Layout Toggle
		if (plugins.layoutToggle.length) {
			for (var i = 0; i < plugins.layoutToggle.length; i++) {
				var $layoutToggleElement = $(plugins.layoutToggle[i]);

				$layoutToggleElement.on('click', function () {
					sessionStorage.setItem('pageLayoutBoxed', !(sessionStorage.getItem('pageLayoutBoxed') === "true"));
					$html.toggleClass('boxed');
					$window.trigger('resize');
				});
			}

			if (sessionStorage.getItem('pageLayoutBoxed') === "true") {
				plugins.layoutToggle.attr('checked', true);
				$html.addClass('boxed');
				$window.trigger('resize');
			}

			var themeResetButton = document.querySelectorAll('[data-theme-reset]');
			if (themeResetButton) {
				for (var z = 0; z < themeResetButton.length; z++) {
					themeResetButton[z].addEventListener('click', function () {
						sessionStorage.setItem('pageLayoutBoxed', false);
						plugins.layoutToggle.attr('checked', false);
						$html.removeClass('boxed');
						$window.trigger('resize');
					});
				}
			}
		}


		// Slick carousel
		if (plugins.slick.length) {
			for (var i = 0; i < plugins.slick.length; i++) {
				var $slickItem = $(plugins.slick[i]);

				$slickItem.on('init', function (slick) {
					initLightGallery($('[data-lightgallery="group-slick"]'), 'lightGallery-in-carousel');
					initLightGallery($('[data-lightgallery="item-slick"]'), 'lightGallery-in-carousel');
				});

				$slickItem.slick({
					slidesToScroll: parseInt($slickItem.attr('data-slide-to-scroll'), 10) || 1,
					asNavFor: $slickItem.attr('data-for') || false,
					dots: $slickItem.attr("data-dots") === "true",
					infinite: isNoviBuilder ? false : $slickItem.attr("data-loop") === "true",
					focusOnSelect: true,
					arrows: $slickItem.attr("data-arrows") === "true",
					swipe: $slickItem.attr("data-swipe") === "true",
					autoplay: $slickItem.attr("data-autoplay") === "true",
					centerMode: $slickItem.attr("data-center-mode") === "true",
					centerPadding: $slickItem.attr("data-center-padding") ? $slickItem.attr("data-center-padding") : '0.50',
					mobileFirst: true,
					nextArrow: '<button type="button" class="slick-next"></button>',
					prevArrow: '<button type="button" class="slick-prev"></button>',
					responsive: [
						{
							breakpoint: 0,
							settings: {
								slidesToShow: parseInt($slickItem.attr('data-items'), 10) || 1,
								vertical: $slickItem.attr('data-vertical') === 'true' || false
							}
						},
						{
							breakpoint: 575,
							settings: {
								slidesToShow: parseInt($slickItem.attr('data-sm-items'), 10) || 1,
								vertical: $slickItem.attr('data-sm-vertical') === 'true' || false
							}
						},
						{
							breakpoint: 767,
							settings: {
								slidesToShow: parseInt($slickItem.attr('data-md-items'), 10) || 1,
								vertical: $slickItem.attr('data-md-vertical') === 'true' || false
							}
						},
						{
							breakpoint: 991,
							settings: {
								slidesToShow: parseInt($slickItem.attr('data-lg-items'), 10) || 1,
								vertical: $slickItem.attr('data-lg-vertical') === 'true' || false
							}
						},
						{
							breakpoint: 1199,
							settings: {
								slidesToShow: parseInt($slickItem.attr('data-xl-items'), 10) || 1,
								vertical: $slickItem.attr('data-xl-vertical') === 'true' || false
							}
						}
					]
				})
				.on('afterChange', function (event, slick, currentSlide, nextSlide) {
					var $this = $(this),
							childCarousel = $this.attr('data-child');

					if (childCarousel) {
						$(childCarousel + ' .slick-slide').removeClass('slick-current');
						$(childCarousel + ' .slick-slide').eq(currentSlide).addClass('slick-current');
					}
				});

			}
		}

		// Radio Panel
		if (plugins.radioPanel) {
			for (var i = 0; i < plugins.radioPanel.length; i++) {
				var $element = $(plugins.radioPanel[i]);
				$element.on('click', function () {
					plugins.radioPanel.removeClass('active');
					$(this).addClass('active');
				})
			}
		}

		// Multitoggles
		if (plugins.multitoggle.length) {
			multitoggles();
		}

		// Hover groups
		for (var i = 0; i < plugins.hoverEls.length; i++) {
			var hel = plugins.hoverEls[i];

			hel.addEventListener('mouseenter', function (event) {
				var hoverGroupName = event.target.getAttribute('data-hover-group'),
						hoverGroup = document.querySelectorAll('[data-hover-group="' + hoverGroupName + '"]');

				for (var e = 0; e < hoverGroup.length; e++) hoverGroup[e].classList.add('active');
			});

			hel.addEventListener('mouseleave', function (event) {
				var hoverGroupName = event.target.getAttribute('data-hover-group'),
						hoverGroup = document.querySelectorAll('[data-hover-group="' + hoverGroupName + '"]');

				for (var e = 0; e < hoverGroup.length; e++) hoverGroup[e].classList.remove('active');
			});
		}

	});
}());

jQuery(document).ready(function($){
	
	jQuery('.toggle-menubar').on('click', function(e1) {
		e1.preventDefault();
		var $toggler = jQuery('#ss-logos');
		if ($toggler.hasClass('active')) {
			$toggler.removeClass('active');
			jQuery(this).html('Open Menu');
		} else {
			$toggler.addClass('active');
			jQuery(this).html('Close Menu');
		}
	});
	
	jQuery('.toggle-videos').on('click', function(e1) {
		e1.preventDefault();
		var $toggler = jQuery('#videotoggler');
		if ($toggler.hasClass('active')) {
			$toggler.removeClass('active');
			jQuery('.toggle-videos').find('span').html('Watch');
		} else {
			$toggler.addClass('active');
			jQuery('.toggle-videos').find('span').html('Close');
			jQuery('html, body').stop().animate({
				'scrollTop': $toggler.offset().top-100
				}, 900, 'swing', function () {
		
				});
		}
	});
	
    /* set global variables @anish*/
	link_path = $('input[name=link_path]').val(); 
	base_url = $('input[name=base_url]').val();
	zoneId = $('input[name=zoneid]').val();
	$('input[name=lowerlimit]').val(0); 
    /* set global variables @anish*/
    jQuery('#slider_desk').skdslider({delay:30000, animationSpeed: 3000,showNextPrev:true,showPlayButton:false,autoSlide:false,animationType:'fading',showNav:false,pauseOnHover:true});	
            			
            jQuery('.desktop_view .infoblock1 .dining-parent a.dinings-about, .desktop_view .infoblock1 .dining-parent img, .mobile_view .infoblock1 .dining-parent a.dinings-about, .mobile_view .infoblock1 .dining-parent img').click(function(e){
                e.preventDefault();
                if(jQuery('.infoblock1').hasClass('open')){
                    jQuery('.infoblock1').removeClass('open');
                }else{
                    jQuery('.infoblock1').addClass('open');
                }
            });
            
   jQuery(".toggle-on-off-img").on('click', function(e){
        e.preventDefault();
        var $src = jQuery(this).find('img').prop('src');
        if(jQuery(this).hasClass('on')){
            jQuery(this).find('img').prop('src', jQuery(this).find('img').data('off'));
            jQuery(this).removeClass('on').addClass('off');   
        }else{
            jQuery(this).removeClass('off').addClass('on');
            jQuery(this).find('img').prop('src', jQuery(this).find('img').data('on'));
        }
   }); 
   
   jQuery("#bookmark").click(function(e){
        e.preventDefault();
        var title= jQuery(this).data('url');
        var addurl=jQuery(this).data('title');;
        if(window.sidebar&&window.sidebar.addPanel){
            window.sidebar.addPanel(title,window.location.href+addurl,'');
        }else if(window.external&&('AddFavorite'in window.external)){
            window.external.AddFavorite(location.href+addurl,title);
        }else if(window.opera&&window.print){
            this.title=title;return true;
        }else{
            alert('Press '+(navigator.userAgent.toLowerCase().indexOf('mac')!=-1?'Command/Cmd':'CTRL')+' + D to bookmark this page.');
        }
    }); 
    
    /*jQuery(".bannerClose").click(function(e) { 
        var $target = jQuery("#" + jQuery(this).data("parent"));
        if($target) $target.removeClass('active');
    });*/
    
    $(".toggle-btn-pop").click(function(e) {
		var target = $(jQuery(this).data("target"));
		if(target != '')
		{
			$('#logos_search').modal('hide');
			target.modal('show');
		}
    });
    
    jQuery(".ls-close-slider").click(function(e) {
		e.preventDefault();
		var $target = jQuery("#" + jQuery(this).data("target"));
		console.log($target);
		if ($target) {
			if ($target.hasClass('active')) {
				$target.removeClass('active');
				jQuery(".toggle-banner-btn").html('Show Banner');
			} else {
				$target.addClass('active');
				jQuery(".toggle-banner-btn").html('Hide Banner');
			}
		}
	});

	jQuery(".toggle-banner-btn").click(function(e) {
		e.preventDefault();
		var $target = jQuery("#" + jQuery(this).data("target"));
		console.log($target);
		if ($target) {
			if ($target.hasClass('active')) {
				jQuery(this).html('Show Banner');
				$target.removeClass('active');
			} else {
				jQuery(this).html('Hide Banner');
				$target.addClass('active');
			}
		}
	});
    
    jQuery(".toggle-btn").click(function(e) {
        e.preventDefault();
        var $target = jQuery("#" + jQuery(this).data("target"));
        jQuery('#logos_search').modal('hide');
        if($target){
            // if(jQuery(this).hasClass('active')){
            //     jQuery(this).removeClass('active'); 
            //     $target.removeClass('active'); 

            //     jQuery('html, body').stop().animate({
            //      'scrollTop': jQuery("#searchPanels1").offset().top+650
            //        }, 900, 'swing', function () {
                    
            //     });               
            // }else{
            //     jQuery(this).addClass('active');
            //     $target.addClass('active');   
            //     jQuery('html, body').stop().animate({
            //       'scrollTop': jQuery("#searchPanels1").offset().top-40
            //         }, 900, 'swing', function () {
                    
            //     });
            //     jQuery('html, body').stop().animate({
            //       'scrollTop': $target.offset().top+300
            //         }, 900, 'swing', function () {
                    
            //     });
			// }
			jQuery(this).addClass('active'); 
			$target.addClass('active');   
			if(jQuery('#'+jQuery(this).data("target")+':visible').length == 0)
			{
				jQuery('html, body').stop().animate({
				'scrollTop': $target.offset().top+650
				}, 900, 'swing', function () {
		
				});
			}
			else
			{
				jQuery('html, body').stop().animate({
				'scrollTop': $target.offset().top-100
				}, 900, 'swing', function () {
		
				});
			}
        }
    });
	
	jQuery(document).on("click",".bannerClose",function(e) {
		// var $target = jQuery("#" + jQuery(this).data("parent"));
		var $target = jQuery("a[data-target='"+jQuery(this).data("parent")+"']");
		console.log($target);
    	jQuery(".toggle-btn").removeClass("active");
    	jQuery("#area-highschoolsports").removeClass("active");
    });

    jQuery(".close_button").click(function(e) {
		e.preventDefault();
        $("html").animate({ scrollTop: 0 }, "slow");
        });

    jQuery('#calendar').fullCalendar({
      themeSystem: 'bootstrap4',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
      },
      weekNumbers: true,
      eventLimit: true, // allow "more" link when too many events
      events: 'https://fullcalendar.io/demo-events.json'
    });
    
    /*jQuery('.announceWrapper a.title').click(function(event){  
		jQuery(this).animate({
			fontSize: "14px"
		}, {queue:true,duration:300}, function() {
			jQuery(this).animate({
				fontSize: "14px"
			}, {queue:true,duration:200});
		});	
		jQuery('.announceWrapper a').removeClass('announceActive');
		jQuery('.announceWrapper a').attr('style', '');
		var announce = jQuery("#" + jQuery(this).parent().parent().data('parent'));
		jQuery(this).addClass('announceActive');	
		announce.find('.orgbannermain').hide('slow') ;
		jQuery('.orgbannermain1').addClass('withbg') ;
		jQuery('.orgbannermain1').html('<h3 class="text-center"></h3><p>You can also receive EmailNotices from this Organization sent by SavingsSites,<br>therefore your email address will not be provided to the Organization! <a class="contactemail" href="javascript:void(0)">HERE</a></p>') ;
		jQuery('.orgbannermain1 > h3').text(jQuery(this).text()) ;
		jQuery(this).animate({
			fontSize: "1.2em",
			opacity:0.5
		}, 200, function() {
			jQuery(this).animate({
				opacity: 1.0
			}, 200);
		});		
		return false;
	});*/

	jQuery(".normal_user_profile").click(function(e) {
        e.preventDefault();
        var $target = jQuery("#" + jQuery(this).data("target"));
        jQuery('#logos_search').modal('hide');
        if($target){
            if(jQuery(this).hasClass('active')){
                jQuery(this).removeClass('active'); 
                $target.removeClass('active'); 

                jQuery('html, body').stop().animate({
                  'scrollTop': jQuery("#outerofferdiv").offset().top+1500
                    }, 900, 'swing', function () {
                    
                });              
            }else{
                jQuery(this).addClass('active');
                $target.addClass('active');   
                jQuery('html, body').stop().animate({
                  'scrollTop': jQuery("#outerofferdiv").offset().top-40
                    }, 900, 'swing', function () {
                    
                });
                jQuery('html, body').stop().animate({
                  'scrollTop': $target.offset().top+1500
                    }, 900, 'swing', function () {
                    
                });
            }
        }

    });
    
    
    //changeTheme(jQuery("#themeswitcher").attr('data-theme'), $("#themeswitcher").text(), $("#themeswitcher").data('version'));
    //changeTheme(jQuery("#themeswitcher1").attr('data-theme'), $("#themeswitcher1").text(), $("#themeswitcher1").data('version'));
    jQuery(".themeswitcher .dropdown-menu a").on('click', function(e) {
        e.preventDefault();
        var parent = $('#themeswitcher');
        // parent.dropdown('toggle');
        parent.attr('data-theme', $(this).data('theme'));
        parent.text($(this).text());
        changeTheme($(this).data('theme'), $(this).text(), parent.data('version'));	    	
		return false;
	});
    
    jQuery("#gridbtn").click(function() {
					jQuery.cookie("list", "gridview");
					jQuery("#product_list li").removeClass('listview');
					jQuery("#product_list li").addClass('gridview');
					jQuery("#listbtn").removeClass('active');
					jQuery("#gridbtn").addClass('active');
				});

				jQuery("#listbtn").click(function() {
					jQuery.cookie("list", "listview");
					jQuery("#product_list li").addClass('listview');
					jQuery("#product_list li").removeClass('gridview');
					jQuery("#gridbtn").removeClass('active');
					jQuery("#listbtn").addClass('active');

				});
/* @anish */

	//$.fn.showOffer() ;
	/* Close button*/
	/*$(document).on('click','.bannerClose',function(){
		 var $target = jQuery(this).parent("#" + jQuery(this).data("parent")); //console.log($target); return false;
         $target.removeClass('active');

	});*/

	/*$(document).on('click','.announceWrapper a.title',function(){
		jQuery(this).animate({
			fontSize: "14px"
		}, {queue:true,duration:300}, function() {
			jQuery(this).animate({
				fontSize: "14px"
			}, {queue:true,duration:200});
		});	
		jQuery('.announceWrapper a').removeClass('announceActive');
		jQuery('.announceWrapper a').attr('style', '');
		var announce = jQuery("#" + jQuery(this).parent().parent().data('parent'));
		jQuery(this).addClass('announceActive');	
		announce.find('.orgbannermain').hide('slow') ;
		jQuery('.orgbannermain1').addClass('withbg') ;
		jQuery('.orgbannermain1').html('<h3 class="text-center"></h3><p>You can also receive EmailNotices from this Organization sent by SavingsSites,<br>therefore your email address will not be provided to the Organization! <a class="contactemail" href="javascript:void(0)">HERE</a></p>') ;
		jQuery('.orgbannermain1 > h3').text(jQuery(this).text()) ;
		jQuery(this).animate({
			fontSize: "1.2em",
			opacity:0.5
		}, 200, function() {
			jQuery(this).animate({
				opacity: 1.0
			}, 200);
		});		
		return false;
	});*/

	
	/* @anish */
	
});

jQuery( window ).resize(function() {
	var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if (width > 1050) {
		jQuery('#ss-logos').addClass('active');
	}
});

function changeTheme(sel, title, version){ //alert(title); 
    $("#selTheme").attr('href', link_path+"assets/directory/css/theme-"+sel+".css");
    $(".rd-navbar-brand img").attr('src', link_path+"assets/directory/images/logo-"+sel+".png");
    var data_to_use={
        'theme': sel,
        'title': title
    };
    $.ajax({
        type : 'POST',
        url : base_url+"Zone/changetheme",
        data: data_to_use,
        success : function(data){},
        error : function(XMLHttpRequest, textStatus, errorThrown){}
    });
}

/*$(".homelink").click(function(e) {
	location.reload();		
});
$(".benefitslink").click(function(e) {
	//e.preventDefault(); alert(base_url);
	$('.about-view').show();
	$('.slider-view').hide();
	$.ajax({
        url : base_url+"zone/about",
        type : 'POST',
        'async': false,
        'beforeSend': function(){
        	$('.about-view').show();
            },
        success : function(data){ console.log(data);
        	$('.about-view').html(data);
        	
        }
    });		
});
$(".aboutlink").click(function(e) {
	//e.preventDefault(); alert(base_url);
	$('.benefits-view').show();
	$('.slider-view').hide();
	$('.about-view').hide();
	$('.sub-banner').hide();
	$('.sponsor-header').hide();
	$.ajax({
        url : base_url+"zone/benefits",
        type : 'POST',
        'async': false,
        'beforeSend': function(){
        	$('.benefits-view').show();
            },
        success : function(data){ //console.log(data);
        	$('.benefits-view').html(data);
        	
        }
    });			
});

$(".organization").click(function(e) { 	
	$('.benefits-view').show();
	$('.slider-view').hide();
	$('.about-view').hide();
	$('.sub-banner').hide();
	$('.sponsor-header').hide();
	$.ajax({
        url : base_url+"zone/organization",
        type : 'POST',
        'async': false,
        'beforeSend': function(){
        	//$('.organization-view').show();
            },
        success : function(data){ //console.log(data);
        	$('.organization-view').html(data);
        	
        }
    });			
});

$(".high-school").click(function(e) { 	
	$('.benefits-view').show();
	$('.slider-view').hide();
	$('.about-view').hide();
	$('.sub-banner').hide();
	$('.sponsor-header').hide();
	$.ajax({
        url : base_url+"zone/hs_sports",
        type : 'POST',
        'async': false,
        'beforeSend': function(){
        	//$('.highschoolsports-view').show();
            },
        success : function(data){ //console.log(data);
        	$('.highschoolsports-view').html(data);
        	
        }
    });			
});*/


/*$.fn.showOffer = function(){ 
    var lowerlimit = 0;    
    var upperlimit =1;
    var data_to_use={
        'user_id': 1,
        'zone_id': zoneId,
        'lowerlimit': lowerlimit,
         'upperlimit': upperlimit,
        'barter_button': '',
        'job_button': '',
        'home_url':link_path,
        //'from_where':"home_page_ads"
        'from_where':"sponsor_businesses_home_page",
        'link_path':link_path
    };
    $.ajax({
        'type': "POST",
         'url': base_url+"ads/temp_ads/",
         'cache': false,
         'data':data_to_use,
        beforeSend: function(){},   
        success : function(data){ 
        	$('.outerofferdiv').html(data);
        	lowerlimit=parseInt(lowerlimit) + parseInt(upperlimit);
        	$('input[name=lowerlimit]').val("");
            $('input[name=lowerlimit]').val(lowerlimit);
                   	
        }
    });
}

$.fn.showOffer_mouseover = function(){ 
    var lowerlimit = $('input[name=lowerlimit]').val(); 
    var upperlimit =1;
    var data_to_use={
        'user_id': 1,
        'zone_id': zoneId,
        'lowerlimit': lowerlimit,
         'upperlimit': upperlimit,
        'barter_button': '',
        'job_button': '',
        'home_url':link_path,
        //'from_where':"home_page_ads"
        'from_where':"sponsor_businesses_home_page",
        'link_path':link_path
    };
    $.ajax({
        'type': "POST",
         'url': base_url+"ads/temp_ads/",
         'cache': false,
         'data':data_to_use,
        beforeSend: function(){},   
        success : function(data){ console.log(data);
        	$('.outerofferdiv').append(data);
        	lowerlimit=parseInt(lowerlimit) + parseInt(upperlimit);
        	$('input[name=lowerlimit]').val("");
            $('input[name=lowerlimit]').val(lowerlimit);
                   	
        }
    });
}

var counter =0;
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       counter = counter + 1;
       if(counter>1){
       	//alert("bottom!"); alert(lowerlimit); alert(upperlimit);
       	$.fn.showOffer_mouseover() ;
       }
       	
   }
});*/

/*var mySwiper = new Swiper('.swiper-container',{
    //pagination: '.pagination',
    //loop:true,
    autoplay: true,
    //paginationClickable: true
    disableOnInteraction: true
  })*/
/*$('.swiper-container').on('mouseenter', function(e){ //alert(1);
	console.log(s);
    console.log('stop autoplay');
    //mySwiper.stopAutoplay();
    mySwiper.autoplay = false;
  })
  $('.swiper-container').on('mouseleave', function(e){ //alert(2);
    console.log('start autoplay');
    console.log(mySwipper);
    //mySwiper.startAutoplay();
    mySwiper.autoplay = true;
  })*/
/*new Swiper('.swiper-container', {
    speed: 400000,ss
    //spaceBetween: 100,
    //autoplay: true,
    //disableOnInteraction: true,
    centeredSlides: true,
  });
  var mySwiper = document.querySelector('.swiper-container').swiper

  $(".swiper-container").mouseenter(function() {
    mySwiper.autoplay.stop();
    console.log('slider stopped');
  });

  $(".swiper-container").mouseleave(function() {
    mySwiper.autoplay.start();
    console.log('slider started again');
  });*/
  /*var mySwiper = document.querySelector('.swiper-container').swiper

  $(".swiper-container").mouseenter(function() {
    mySwiper.autoplay.stop();
    console.log('slider stopped');
  });

  $(".swiper-container").mouseleave(function() {
    mySwiper.autoplay.start();
    console.log('slider started again');
  });*/
;
(function($, window, document, undefined) {
        'use strict';
        // undefined is used here as the undefined global variable in ECMAScript 3 is
        // mutable (ie. it can be hasMoved by someone else). undefined isn't really being
        // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
        // can no longer be modified.

        // window and document are passed through as local variable rather than global
        // as this (slightly) quickens the resolution process and can be more efficiently
        // minified (especially when both are regularly referenced in your plugin).

        // Create the defaults once
        var pluginName = 'newsTicker',
                defaults = {
                        row_height: 20,
                        max_rows: 3,
                        speed: 400,
                        direction: 'up',
                        time: 2500,
                        autostart: 1,
                        stopOnHover: 1,
                        nextButton: null,
                        prevButton: null,
                        startButton: null,
                        stopButton: null,
                        hasMoved: function() {},
                        movingUp: function() {},
                        movingDown: function() {},
                        start: function() {},
                        stop: function() {},
                        pause: function() {},
                        unpause: function() {}
                };

        // The actual plugin constructor
        function Plugin(element, options) {
                this.element = element;
                this.$el = $(element);
                this.options = $.extend({}, defaults, options);
                this._defaults = defaults;
                this._name = pluginName;
                this.moveInterval;
                this.state = 0;
                this.paused = 0;
                this.moving = 0;
                if (this.$el.is('ul')) {
                        this.init();
                }
        }

        Plugin.prototype = {
                init: function() {
                        this.$el.height(this.options.row_height * this.options.max_rows)
                                .css({overflow : 'hidden'});

                        this.checkSpeed();

                        if(this.options.nextButton && typeof(this.options.nextButton[0]) !== 'undefined')
                                this.options.nextButton.click(function(e) {
                                        this.moveNext();
                                        this.resetInterval();
                                }.bind(this));
                        if(this.options.prevButton && typeof(this.options.prevButton[0]) !== 'undefined')
                                this.options.prevButton.click(function(e) {
                                        this.movePrev();
                                        this.resetInterval();
                                }.bind(this));
                        if(this.options.stopButton && typeof(this.options.stopButton[0]) !== 'undefined')
                                this.options.stopButton.click(function(e) {
                                        this.stop()
                                }.bind(this));
                        if(this.options.startButton && typeof(this.options.startButton[0]) !== 'undefined')
                                this.options.startButton.click(function(e) {
                                        this.start()
                                }.bind(this));
                        
                        if(this.options.stopOnHover) {
                                this.$el.hover(function() {
                                        if (this.state)
                                                this.pause();
                                }.bind(this), function() {
                                        if (this.state)
                                                this.unpause();
                                }.bind(this));
                        }

                        if(this.options.autostart)
                                this.start();
                },

                start: function() {
                        if (!this.state) {
                                this.state = 1;
                                this.resetInterval();
                                this.options.start();
                        }
                },

                stop: function() {
                        if (this.state) {
                                clearInterval(this.moveInterval);
                                this.state = 0;
                                this.options.stop();
                        }
                },

                resetInterval: function() {
                        if (this.state) {
                                clearInterval(this.moveInterval);
                                this.moveInterval = setInterval(function() {this.move()}.bind(this), this.options.time);
                        }
                },

                move: function() {
                         if (!this.paused) this.moveNext();
                },

                moveNext: function() {
                        if (this.options.direction === 'down')
                                this.moveDown();
                        else if (this.options.direction === 'up')
                                this.moveUp();
                },

                movePrev: function() {
                        if (this.options.direction === 'down')
                                this.moveUp();
                        else if (this.options.direction === 'up')
                                this.moveDown();
                },

                pause: function() {
                        if (!this.paused) this.paused = 1;
                        this.options.pause();
                },

                unpause: function() {
                        if (this.paused) this.paused = 0;
                        this.options.unpause();
                },

                moveDown: function() {
                        if (!this.moving) {
                                this.moving = 1;
                                this.options.movingDown();
                                this.$el.children('li:last').detach().prependTo(this.$el).css('marginTop', '-' + this.options.row_height + 'px')
                                        .animate({marginTop: '0px'}, this.options.speed, function(){
                                                this.moving = 0;
                                                this.options.hasMoved();
                                        }.bind(this));
                        }
                },

                moveUp: function() {
                        if (!this.moving) {
                                this.moving = 1;
                                this.options.movingUp();
                                var element = this.$el.children('li:first');
                                element.animate({marginTop: '-' + this.options.row_height + 'px'}, this.options.speed,
                                        function(){
                                                element.detach().css('marginTop', '0').appendTo(this.$el);
                                                this.moving = 0;
                                                this.options.hasMoved();
                                        }.bind(this));
                        }
                },

                updateOption: function(option, value) {
                        if (typeof(this.options[option]) !== 'undefined')
                                this.options[option] = value;
                        //TODO: checkSpeed if speed/time
                },

                getState: function() {
                        if (paused) return 2
                        else return this.state;//0 = stopped, 1 = started
                },

                checkSpeed: function() {
                        if (this.options.time < (this.options.speed + 25))
                                this.options.speed = this.options.time - 25;
                },

                destroy: function() {
                        this._destroy(); //or this.delete; depends on jQuery version
                }
        };

        // A really lightweight plugin wrapper around the constructor,
        // preventing against multiple instantiations
        $.fn[pluginName] = function(option) {
                var args = arguments;
                
                return this.each(function() {
                        var $this = $(this),
                                data = $.data(this, 'plugin_' + pluginName),
                                options = typeof option === 'object' && option;
                        if (!data) {
                                $this.data('plugin_' + pluginName, (data = new Plugin(this, options)));
                        }
                        // if first argument is a string, call silimarly named function
                        // this gives flexibility to call functions of the plugin e.g.
                        //   - $('.dial').plugin('destroy');
                        //   - $('.dial').plugin('render', $('.new-child'));
                        if (typeof option === 'string') {
                                data[option].apply(data, Array.prototype.slice.call(args, 1));
                        }
                });
        };
})(jQuery, window, document);
jQuery(document).ready(function($){
var multilines = $('#multilines .newsticker').newsTicker({
                row_height: 78,
                speed: 800,
                prevButton: $('#multilines .prev-button'),
                nextButton: $('#multilines .next-button'),
                stopButton: $('#multilines .stop-button'),
                startButton: $('#multilines .start-button'),
            });

            var oneliner = $('#oneliner .newsticker').newsTicker({
                row_height: 44,
                max_rows: 1,
                time: 5000,
                nextButton: $('#oneliner .header')
            });

            // Pause newsTicker on .header hover
            $('#oneliner .header').hover(function() {
                oneliner.newsTicker('pause');
            }, function() {
                oneliner.newsTicker('unpause');
            });	


jQuery(".contactformpage #contact-submit").click(function(e){

   if($('.contactformpage input[name="name"]').val() == ''){
        alert("Please Enter the Name");
   }

   if($('.contactformpage input[name="email"]').val() == ''){
        alert("Please Enter the Email");
   }
});

jQuery(".contactformpage").submit(function(e){
	e.preventDefault();

 

	  const ans = captcha.valid($('.contactformpage input[name="code"]').val());
 
	if(ans == true){
 

	var str = $( ".contactformpage" ).serialize();	
	var zoneid = $('#get_zoneid').val();
    $.ajax({
        'type': "POST",
         'url': base_url+"welcome/contactformsubmit",
         'cache': false,
          'data':{ 'data' : str , 'zoneid': zoneid},         
        beforeSend: function(){},   
        success : function(data){ 

        $('.contactformpage .messageresponse').text("Thankyou for contacting Us");
 
                   	
        }
    });
 $('.contactformpage')[0].reset();
	}else{
		alert("Please fill the form Correctly.");
		return false;
	}


});
const captcha = new Captcha($('#canvas'),{
      length: 6,
      width: 200,
      height: 80,
      font: 'bold 35px Arial',
      resourceType: 'aA0', // a-lowercase letters, A-uppercase letter, 0-numbers
      resourceExtra: [],
      clickRefresh: true,
});


   

 


});


$( document ).ajaxComplete(function() {
  setTimeout(function(){ 


  $("#snapGlobalAnyChange").click(function(){
 

  	       if ($(this).is(":checked")) {
                         $(".snaptimecolumn input").prop("checked", true);
                    } else {
                         $(".snaptimecolumn input").prop("checked", false);
                    }

       
      
    });

$(function(){
      $('.snaptimecolumn input[type=checkbox]').click(function(){
     
        // $(':checkbox:checked').each(function(i){
      
if ($('.snaptimecolumn input[type=checkbox]:checked').length === $('.snaptimecolumn input[type="checkbox"]').length) {
    $("#snapGlobalAnyChange").prop("checked", true);
} else {
     $("#snapGlobalAnyChange").prop("checked", false);
}
        // });
      });
    });



 }, 3000);
});



