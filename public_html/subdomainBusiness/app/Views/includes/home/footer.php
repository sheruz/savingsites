<script type="text/javascript" src="<?php echo base_url("/assets/js/jquery.js"); ?>"></script>

<style type="text/css">
    html {
    scroll-behavior: smooth;
}
</style>
<?php if(@$_GET['promo'] && @$_GET['exxpiresat']){ ?>

<script type="text/javascript">
    setTimeout(function myStopFunction() {
        $('#mycoupon').modal({
            show: true
        }); 
    }, 5000);
</script>
<?php } ?>
<div class="snackbars" id="form-output-global"></div>
    <script src="<?= base_url(); ?>/assets/js/script.js?v=<?php echo rand() ?>"></script>
    <?= $this->include("includes/home/".$footer.""); ?>
</div>
<!---error div-->
<div id="alert_msg">
</div>
<!---error div-->
<!---loader div-->
<div id="loading" style="position: absolute;width: 100%;top: 25%;">
<div class="lds-roller">
   
        <img style="width: 100%;" src="https://cdn.savingssites.com/loaderss.gif" />
   
</div>
</div>
<!---loader div-->
<a href="#" id="ui-to-top" class="ui-to-top fa fa-angle-up"></a>



<script type="text/javascript" src="<?php echo base_url("/assets/js/bootstrap.js"); ?>"></script>
<script src="<?= base_url();?>/assets/home/customjs/core.min.js?v=<?php echo rand() ?>"></script>
<script src="<?= base_url();?>/assets/home/customjs/maskedinput.js?v=<?php echo rand() ?>"></script>
<script type="text/javascript" src="<?= base_url();?>/assets/scripts/new/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?= base_url();?>/assets/scripts/new/jquery.jqtransform.js?v=1"></script>
<script type="text/javascript" src="<?= base_url();?>/assets/SavingsJs/jquery.nivo.slider.pack.js"></script>
<script src="<?= base_url();?>/assets/SavingsJs/csvcommon.js?v=<?php echo rand(); ?>"></script>
<script src="<?= base_url();?>/assets/SavingsJs/homecommon.js?v=<?php echo rand(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type='text/javascript' src='<?= base_url();?>/assets/js/greensock-text.js'></script>
<script type='text/javascript' src='<?= base_url();?>/assets/js/greensock.js'></script>
<script type='text/javascript' src='<?= base_url();?>/assets/js/layerslider.kreaturamedia.jquery.js'></script>
<script type='text/javascript' src='<?= base_url();?>/assetsjs/layerslider.transitions.js'></script>
<script src="<?= base_url();?>/assets/js/paginate.js?v=<?php echo rand() ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script href="<?=base_url('EventCalendarD/core/libs/pjQ/pjQuery.tooltipster.js')?>" type="text/css" rel="stylesheet"  ></script>
<script href="<?=base_url('EventCalendarD/app/web/js/pjPHPEventCalendar.js')?>" type="text/css" rel="stylesheet"  ></script>
<script type="text/javascript" src="<?=base_url('EventCalendarD/index.php?controller=pjFront&action=pjActionLoad&theme=1&view=calendar&icons=F&cats=F')?>">
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    function toggleSwiperCaptionAnimation(swiper) { 
        var prevSlide = $(swiper.container).find("[data-caption-animate]"),
            nextSlide = $(swiper.slides[swiper.activeIndex]).find("[data-caption-animate]"),
            delay,
            duration,
            nextSlideItem,
            prevSlideItem;
            for (var i = 0; i < prevSlide.length; i++) {
                prevSlideItem = $(prevSlide[i]);
                prevSlideItem.removeClass("animated").removeClass(prevSlideItem.attr("data-caption-animate")).addClass("not-animated");
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
    
    var lsjQuery=jQuery;started = false;
    lsjQuery(document).ready(function() {
        var lsSlide1 = lsjQuery("#layerslider_501").layerSlider({
            autoStart:true,
            skin:'lightskin',
            globalBGColor:'#ffffff',
            globalBGAttachment:'fixed',
            globalBGSize:'cover',
            navPrevNext:true,
            hoverPrevNext:false,
            navStartStop:false,
            showCircleTimer:true,
            pauseOnHover: 'disabled',
            thumbnailNavigation:'disabled',
            skinsPath:'https://layerslider.kreaturamedia.com/wp-content/plugins/LayerSlider/static/layerslider/skins/',
                eight:600
            });
        var lsSlide1 = lsjQuery("#layerslider_502").layerSlider({
            autoStart:true,
            skin:'lightskin',
            globalBGColor:'#ffffff',
            globalBGAttachment:'fixed',
            globalBGSize:'cover',
            navPrevNext:true,
            hoverPrevNext:false,
            navStartStop:false,
            showCircleTimer:true,
            pauseOnHover: 'disabled',
            thumbnailNavigation:'disabled',
            skinsPath:'https://layerslider.kreaturamedia.com/wp-content/plugins/LayerSlider/static/layerslider/skins/',
            height:600
        });
    
    if (typeof lsjQuery.fn.layerSlider=="undefined") {
        if (window._layerSlider&&window._layerSlider.showNotice) {
            window._layerSlider.showNotice('layerslider_50','jquery');
        }
    } else {
        var lsSlide = lsjQuery("#layerslider_50").layerSlider({
        autoStart:true,
        skin:'lightskin',
        globalBGColor:'#ffffff',
        globalBGAttachment:'fixed',
        globalBGSize:'cover',
        navPrevNext:false,
        hoverPrevNext:false,
        navStartStop:false,
        showCircleTimer:true,
        cycles: 1,
        pauseOnHover: 'disabled',
        thumbnailNavigation:'disabled',
        skinsPath:'https://layerslider.kreaturamedia.com/wp-content/plugins/LayerSlider/static/layerslider/skins/',
        height:600
    });
    
    jQuery("#lsSlideStop").off().on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: '/home/callslider',
            success: function(html) {
                $('#layerslider_50').layerSlider('destroy', true);
                $("#ss-slider").empty().append(html);
                var popupswiper = new Swiper('.swiper-slider', {
                        slidesPerView: 1,
                        lazyLoading: true,
                        keyboardControl: true,
                        autoplay:20000,
                        loop: true,
                        effect: 'slide',
                        direction: 'horizontal',
                        mousewheelControl: false,
                        nextButton: $(".swiper-button-next").length ? $(".swiper-button-next").get(0) : null,
                        prevButton: $(".swiper-button-prev").length ? $(".swiper-button-prev").get(0) : null,
                        pagination: $('.swiper-pagination').length ? $('.swiper-pagination').get(0) : null,
                        paginationClickable: true,
                    paginationBulletRender: function (swiper, index, className) {
                        if ($('.swiper-pagination').attr("data-index-bullet") === "true") {
                            return '<span class="' + className + '">' + (index + 1) + '</span>';
                        } else if ($('.swiper-pagination').attr("data-bullet-custom") === "true") {
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
    });
    
        jQuery("#ssStart").on('click', function(e) {
            e.preventDefault();
            started = true;
            lsSlide.layerSlider('start');
            return false;
        });
    }
    
        jQuery(".fancyBtn").off().on('click', function(e) {
            e.preventDefault();
            jQuery.fancybox.open( jQuery('.fancybox'));
        });
    });
    
    jQuery('.owl-carousel').owlCarousel({
        loop:true,
       margin:20,
      responsiveClass:true,
      responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:1,
            nav:true
        },
        1000:{
            items:1,
            nav:true,
            dots:false,
            loop:true
        }
    }
});
    
jQuery('.carp2').css('display','inline-block');
    $('#videotoggler .item:odd').addClass('odd');
    $('#videotoggler .item:even').addClass('even');
    $( ".read_save" ).click(function() {
        $('.head_col').toggleClass( "show" );
    });

    $(document).ready(function() {



        // $( "#toTop.ui-to-top" ).addClass( "active" );
        //     $( "#toTop.fa-arrow-circle-o-up" ).remove();
        //         });
        $(".snapDining").click(function(e){  
            e.preventDefault();
            $('.page-loader').show();  
            var snapDinignUrl = "<?php echo base_url() ?>/snapDining/dining/<?php echo $zoneid ?>";
            window.open(snapDinignUrl,'_self');
        });
        
        $(".peekaboo").click(function(e){  
            e.preventDefault(); 
            $('.page-loader').show(); 
            var peekabooUrl = "http://www.peekabooauctions.com/index.php?zoneid=<?php echo $zoneid ?>";
            window.open(peekabooUrl,'_self');
        });
        
        $(".webinar").click(function(e){   
            e.preventDefault();
            $('.page-loader').show(); 
            var educationalWebinarUrl = "<?php echo base_url() ?>/educational_webinar/webinar/<?php echo $zoneid ?>";
            window.open(educationalWebinarUrl,'_self');
        });
        
        $(".busines_search").click(function(e){ 
            var subdomain = $('#homesubdomain').val();
            e.preventDefault();
            $('.page-loader').show();  
            var businessSearchUrl = 'https://'+subdomain+'.savingssites.com';
            // alert(businessSearchUrl);return false;
            window.open(businessSearchUrl,'_self');
        });
        
        $(".newsevent").click(function(e){ 
            e.preventDefault();
            $('.page-loader').show();  
            var businessSearchUrl = "<?php echo base_url() ?>/newsevent";
            window.open(businessSearchUrl,'_self');
        });

        $(".aboutlink").click(function(e){ 
            e.preventDefault();
            $('.page-loader').show();  
            var businessSearchUrl = "<?php echo base_url() ?>/zone/about_us/<?php echo $zoneid ?>";
            window.open(businessSearchUrl,'_self');
        });
        
        $(window).load(function(){
            $('.page-loader').hide();
        });
        $('.ff-copyright').clone().appendTo( ".ff-copyright_clone" );
    });

    $(function(){
        $(window).scroll(function(){
            if($(this).scrollTop()>=200){
               $('#ui-to-top').addClass('active');
            }if($(this).scrollTop()<200){
               $('#ui-to-top').removeClass('active');
            }
        });
    });

    
    $('.classifiedsBtn, .groceryBtn').on( "click", function(e) {
        e.preventDefault();
        $('#create-links1').modal('show');
    });
    
    var base_url = "<?=base_url()?>";
    $(document).on('click','.normal_user_profile1',function() {
        window.location = base_url+"/my_account/";
    });
    
    var base_url = "<?=base_url()?>";
    $(document).on('click','.home_business_registration',function(){      
        window.location = base_url+"/home/business_registration/";
    });
    
    $(document).on('click','.home_organization_registration',function(e){   
        e.preventDefault();
        window.location = base_url+"/home/organization_registration/";
    });
    
    $(document).on('click','.business_login',function(e){   
        e.preventDefault();
        window.location = base_url+"/home/business_login/";
    });
    
    $(document).on('click','.organization_login',function(e){   
        e.preventDefault();
        window.location = base_url+"/home/organization_login/";
    });
    
    $(document).on('click','.zone_login',function(e){   
        e.preventDefault();
        window.location = base_url+"/home/zone_login/";
    });

    $(".save_hide_banner").click(function(){
        $("#ss-slider").toggleClass("hide_banner");
        var $el = $(this);
        $el.text($el.text() == "Close Banner" ? "Show Banner": "Close Banner");
        $(this).toggleClass('UnRead');
    });
    
 
    
    $(document).ready(function(){
  $(".div_read_more").click(function(){
    $(".protct_sec").slideToggle("slow");
  });
});

    $('.home_desc_first').parent().addClass('home_desc_firstcol');
    $('.home_desc_sec').parent().addClass('home_desc_seccol');
    zoneId = $('input[name=zoneid]').val();
    base_url = $('input[name=base_url]').val();
    user_id = $('input[name=user_id]').val();
    user_type = $('input[name=user_type]').val();
    
    $(document).on('click','.sign_out_directory',function(){
        if(user_id!='' && user_id!='undefined'){
            if(user_type == 4){
                var x = base_url + "/Zonedashboard/zonedetail/"+ zoneId ; 
            }else if(user_type == 8){
                var x = base_url + "/organizationdashboard/organizationdetail/"+ user_type ;
            }else if(user_type == 10){
                var x = base_url + "/my_account/";
            }else {
                var x = base_url + "/businessdashboard/businessdetail/"+ user_type ;
            }
        }else{            
            var x = base_url +"/zone/load/" + zone_id ;
        }
        $.ajax({
            url: base_url +"/auth/check_session",
            cache: false,
            success: function(result){
                if(result == 1){
                    window.location = x;
                }else{
                    alert('You are currently logged out. Please log in to continue.');
                    window.location.reload();
                }
            }
        });
    });
</script>
</body>
</html>

