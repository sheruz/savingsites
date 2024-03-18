<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Savings Sites Zone
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Savings Sites Images</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">  
    <link rel="stylesheet" href="<?= base_url();?>/assets/CommonImages/Font-Awesome-4.7/css/font-awesome.min.css">                
    <link rel="stylesheet" href="<?= base_url();?>/assets/CommonImages/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url();?>/assets/CommonImages/css/hero-slider-style.css">
    <link rel="stylesheet" href="<?= base_url();?>/assets/CommonImages/css/magnific-popup.css?time=<?= time(); ?>">
    <link rel="stylesheet" href="<?= base_url();?>/assets/CommonImages/css/templatemo-style.css?time=<?= time(); ?>">
    <script src="<?= base_url();?>/assets/CommonImages/js/jquery-1.11.3.min.js"></script>
    <script>
        var tm_gray_site = false;
        if(tm_gray_site) {
            $('html').addClass('gray');
        }else {
            $('html').removeClass('gray');   
        }
    </script>
    <style>
        ::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}
                    .category{
            padding: 10px 15px;
            background: #fff;
            margin: 15px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
        }
        .selected{
            background: blue;
            color: #fff;
        }
        .appendimages{
            height: 100% !important;
            overflow-x: auto;
        }
        .loadered {
     border: 5px solid #f3f3f3;
    position: absolute;
    border-radius: 50%;
    border-top: 5px solid #3498db;
    width: 50px;
    height: 50px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    top: 50%;
    left: 50%;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.loader-wrapperdiv{
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.7;
    z-index: 99999;
}
.hide{
    display: none;
}
body{
    position: relative;
}

</style>
</head>
    <body>
        <div class="container-fluid">
        <div class="row">
        <div class="cd-hero col-md-12">
            <div class="cd-slider-nav">
                <nav class="navbar">
                    <div class="tm-navbar-bg">
                        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                            &#9776;
                        </button>
                        <h1>Images</h1>
                        <div class="collapse navbar-toggleable-md text-xs-center text-uppercase tm-navbar" id="tmNavbar">
                            <ul class="nav navbar-nav" id="catul">
                                
                            </ul>
                        </div>                        
                    </div>
                </nav>
            </div> 
            <ul class="cd-hero-slider">
                <li class="selected">                    
                    <div class="cd-full-width">
                        <div class="container-fluid js-tm-page-content" data-page-no="1" data-page-type="gallery">
                            <div class="tm-img-gallery-container">
                                <div class="tm-img-gallery gallery-one appendimages"></div>
                            </div>
                        </div>                                                    
                    </div>                    
                </li>
            </ul> 
        
        </div>
        </div>
    </div>

           

        <div class="loader-wrapperdiv hide">
            <div class="loadered"></div>
        </div>
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <script src="<?= base_url();?>/assets/CommonImages/js/tether.min.js"></script>
        <script src="<?= base_url();?>/assets/CommonImages/js/bootstrap.min.js"></script>        
        <script src="<?= base_url();?>/assets/CommonImages/js/hero-slider-main.js"></script>  
        <script src="<?= base_url();?>/assets/CommonImages/js/jquery.magnific-popup.min.js?time=<?= time(); ?>"></script> 
        <script>
        $(document).ready(function(){
            $('body').addClass('loaded');
            loadData('all');
            loadCat();
        });
        $(document).on('click','.category', function(){
            var catid = $(this).attr('categoryid');
            $('.category').removeClass('selected');
            $(this).addClass('selected');
            var html = '';
            if(catid){
                loadData(catid);
            }
        });

    function loadData(catid = 'all'){
        var html = '';
        $.ajax({ 
            type :'GET',
            url :"/getimage",
            data:  {'catid': catid},
            dataType:'json',
            beforeSend: function() {
                $('.loader-wrapperdiv').removeClass('hide');
            },
            complete: function() {
                $('.loader-wrapperdiv').addClass('hide');
            },
            success: function(i){
                $.each(i, function (k,v) {
                   html += ' <div class="grid-item"><figure class="effect-sadie"><img  src="<?= base_url();?>/assets/CommonImages/'+v.image+'" alt="Image" class="img-fluid tm-img"><span onclick="copyToClipboard('+v.id+')" class="copyID" ><input class="copyinpuid" type="hidden" value="'+v.id+'"/><i title="Copy Image Id '+v.id+'" class="fa fa-clipboard" aria-hidden="true"></i></span><figcaption><a data-var1="X" href="<?= base_url();?>/assets/CommonImages/'+v.image+'?'+v.id+'">View more</a></figcaption></figure></div>'; 
                });
                // $('.appendimages').animate({
                //     width: 'toggle',
                // },500);
                $('.cd-hero-slider').find('li').addClass('selected');
                $('.appendimages').html(html);
            }
        })  
    }

    function loadCat(){
        var html = '';
        $.ajax({ 
            type :'GET',
            url :"/loadCat",
            dataType:'json',
            beforeSend: function() {
                $('.loader-wrapperdiv').removeClass('hide');
            },
            complete: function() {
                $('.loader-wrapperdiv').addClass('hide');
            },
            success: function(i){
                html += '<li class="nav-item category selected" categoryID="all">All</li>';
                $.each(i, function (k,v) {
                    html+='<li class="nav-item category" categoryID="'+v.id+'">'+v.foodCategoryName+'</li>';
                });
                $('#catul').html(html);
            }
        })  
    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        alert("Copy To Clipboard");
        $temp.val(element).select();
        document.execCommand("copy");
        $temp.remove();
    }

    function copyToClipboard1(element) {
        var src = element.closest('.mfp-figure').find('.mfp-img').attr('src');
        var result = src.split('?');
        var data =result[1];
        var element = parseInt(data);
        var $temp = $("<input>");
        $("body").append($temp);
        alert("Copy To Clipboard");
        $temp.val(element).select();
        $temp.focus();
        console.log($temp.val());
        document.execCommand("copy");
        $temp.remove();
    }

   


    
    
    $(window).load(function(){
        $('.gallery-one').magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    midClick: true,
                    gallery:{enabled:true} ,               
                });
        
        $('#tmNavbar a').click(function(){
            $('#tmNavbar').collapse('hide');
        });
        $('body').addClass('loaded');
        $(".tm-copyright-year").text(new Date().getFullYear());
    });
</script>  

<?=$this->endSection()?>