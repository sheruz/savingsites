/*add by krishanu start*/
jQuery(document).on('change', '#tab_selector', function(e) {
	var myval= $(this).val();
	var className = $(this).children("option:selected").attr('class');
if(className.indexOf("clicksnapsignup") != -1){
$(this).parent().parent().parent().parent().find('.tabs-vertical.tabs-line .nav-tabs li a').eq(myval).click();
}
else{
 $(this).parent().parent().parent().parent().find('.tabs-vertical.tabs-line .nav-tabs li a').eq(myval).tab('show');
}
});
$(document).on('click', '#gridbtn', function (event) {
/*alert("hello gridbtn");*/
/*$.cookie("list", "gridview");*/
$(".product_list_1818 li").removeClass('listview');
$(".product_list_1818 li").addClass('gridview');
$("#listbtn").removeClass('active');
$("#gridbtn").addClass('active');
});	
$(document).on('click', '#listbtn', function (event) {
/*alert("hello listbtn");*/
/*$.cookie("list", "listview");*/
$(".product_list_1818 li").addClass('listview');
$(".product_list_1818 li").removeClass('gridview');
$("#gridbtn").removeClass('active');
$("#listbtn").addClass('active');			
});
$("#gototop").click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;

  }); // click() scroll top EMD

if (jQuery(window).width() < 550) {
	jQuery( ".foodsearch" ).parent().find(".active-tab-content").removeClass("active-tab-content");
	jQuery( ".foodsearch" ).parent().find(".active-tab").removeClass("active-tab");
	jQuery( ".foodsearch" ).closest(".active").removeClass("active");
}

/*add by krishanu end*/
$(document).ready(function(){
	$("#categories_droopdown_toggle").on("click",function(){
		$("#food_tab").removeClass("active");
		$("#food_tab").removeClass("active-tab");
	})

	$(".owl-carousel").owlCarousel({
		autoplay: true,
		dots: false,
		nav:true,
		items:1,
		navText:[""]
	});
});


"use strict";
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
		function toggleSwiperCaptionAnimation(swiper) {
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

	jQuery('.owl-carousel2').owlCarousel({
    loop:false,
 	dots: true,
 	// center: true,
	navigationText: ['<div class="icon-arrow-left"></div>', 
  '<div class="icon-arrow-right"></div>'],
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:7
        },
        1400:{
            items:10
        }
    }
})


	jQuery('.container_cat .owl-item').click(function(){
      // jQuery('.container_cat li').find('div.container').removeClass('activediv');
    
   $(this).toggleClass('activediv').siblings().removeClass('activediv');

    // if($(this).find('div.container').hasClass("activediv")){
    // 	console.log("dsfs");
    //    $(this).find('div.container').removeClass('activediv');

    // }else{
    // 	console.log("ds454fs");
    //   $(this).find('div.container').addClass('activediv');

    // }


      // console.log($(this).find('div.container').hasClass("activediv"));

})


    //hidebanner();
      jQuery('.dropdown-submenu > a').on("click", function(e){
        jQuery(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
      });
    
    jQuery('#tab_selector').on('change', function (e) {
        jQuery('.tabs-vertical.tabs-line .nav-tabs li a').eq($(this).val()).tab('show');
    });
    
    jQuery(".hoverAnim").hover(
		function () {
			jQuery(this).find("img").attr("src", jQuery(this).find("img").data("hover")).fadeIn("slow");
		}, 
		function () {
            jQuery(this).find("img").attr("src", jQuery(this).find("img").data("orig")).fadeIn("slow");
		}
	);  
    //jQuery('#slider_desk').skdslider({delay:30000, animationSpeed: 3000,showNextPrev:true,showPlayButton:false,autoSlide:false,animationType:'fading',showNav:false,pauseOnHover:true});	
            			
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
    
    jQuery(".bannerClose").click(function(e) {
        var $target = jQuery("#" + jQuery(this).data("parent"));
        if($target) $target.removeClass('active');
    });
    
    // jQuery(".toggle-btn-pop").click(function(e) {
    //     var $target = jQuery("#" + jQuery(this).data("target"));
    //     jQuery('#logos_search').modal('hide');
    //     $target.modal('show');
    // });
     jQuery( ".toggle-banner-btn" ).on( 'click', function(e) {
     /*jQuery(".toggle-banner-btn").click(function(e) {*/
     	e.stopImmediatePropagation();
     	var zone_id = $("input[name=zoneid]").val();       
        var $target = jQuery("#" + jQuery(this).data("target"));
        if($target){
            if(jQuery(this).hasClass('active')){
                jQuery(this).removeClass('active'); 
                jQuery(this).html('<span class="mobile_hide">Show </span>Banner');
                $target.removeClass('active'); 
                $("#ss-slider").empty();              
            }else{
                jQuery(this).addClass('active');
                jQuery(this).html('<span class="mobile_hide">Hide </span>Banner');
                $target.addClass('active');
                jQuery("#ss-slider").html('<div class="text-center ss-loader"><img src="https://development.savingssites.com/assets/businessSearch/images/logo_spinner2.gif" /></div>');
                setTimeout(function(){ 
                    jQuery.ajax({
					      type: 'POST',
					      data: { zone_id: zone_id },
                           url: 'https://savingssites.com/businessSearch/getslider',
                           success: function(html) { 
                              jQuery("#ss-slider").html(html);
                              var swiperSlide = jQuery("#ss-slider").find(".swiper-slide");            
                				for (var j = 0; j < swiperSlide.length; j++) {
                					var $this = $(swiperSlide[j]), url;            
                					if (url = $this.attr("data-slide-bg")) {
                						$this.css({
                							"background-image": "url(" + url + ")",
                							"background-size": "cover"
                						})
                					}
                				}  
                                var popupswiper = new Swiper('.swiper-slider', {
                                    slidesPerView: 1,
                                    lazyLoading: true,
                                    keyboardControl: true,
                                    autoplay:6000,
                                    loop: true,
                                    effect: 'slide',
                                    direction: 'horizontal',
                                    mousewheelControl: false,
                                    nextButton: jQuery(".swiper-button-next").length ? jQuery(".swiper-button-next").get(0) : null,
                            		prevButton: jQuery(".swiper-button-prev").length ? jQuery(".swiper-button-prev").get(0) : null,
                            		pagination: jQuery('.swiper-pagination').length ? jQuery('.swiper-pagination').get(0) : null,
                            		paginationClickable: true,
                            		paginationBulletRender: function (swiper, index, className) {
                            		if (jQuery('.swiper-pagination').attr("data-index-bullet") === "true") {
                            			return '<span class="' + className + '">' + (index + 1) + '</span>';
                            		} else if (jQuery('.swiper-pagination').attr("data-bullet-custom") === "true") {
                            			return '<span class="' + className + '"><span></span></span>';
                            		} else {
                            		  return '<span class="' + className + '"></span>';
                            		}
                            		},
                            		loop: true,
                            		simulateTouch: true,
                            		onTransitionEnd: function (swiper) {
                            			toggleSwiperCaptionAnimation(swiper);
                            		},
                                });
                           }
                        });                    
                }, 5000);
                    
            }
        }
    });
    
    jQuery(".toggle-btn").click(function(e) {
        e.preventDefault();
        var $target = jQuery("#" + jQuery(this).data("target"));
        //jQuery('#logos_search').modal('hide');
        if($target){
            if(jQuery(this).hasClass('active')){
                jQuery(this).removeClass('active'); 
                $target.removeClass('active');
                               
            }else{
                jQuery(this).addClass('active');
                $target.addClass('active');
                
                jQuery('html, body').stop().animate({
                  'scrollTop': $target.offset().top-40
                    }, 900, 'swing', function () {
                    
                });
            }
        }
    });
    jQuery( window ).resize(function() {
  //hidebanner();
});


function toggleSwiperCaptionAnimation(swiper) {
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
				
					if (delay) {
						setTimeout(tempFunction(nextSlideItem, duration), parseInt(delay, 10));
					} else {
						tempFunction(nextSlideItem, duration);
					}

			}
		}
    
});
