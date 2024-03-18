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
<div class="copyright-wthree">
    <section class="copy_right">
        <div class="container" bis_skin_checked="1" >
            <div class="row justify-content-center align-items-xl-center" bis_skin_checked="1">
                <div class="col-sm-12" bis_skin_checked="1">
                    <div class="col-12 col-lg-4 col-md-12 left_col_wraper" bis_skin_checked="1">
                        <div class="address website_link">
                            <a class="website_col" target='_blank' href="https://<?php echo @$busdata[0]['website'] ?>"><i class="fa fa-share-square-o"></i> Visit Our Website</a>
                            <a  target='_blank' class="bookmark" href="<?php echo base_url()  ?>short_url/index.php?deal_title=<?= $adsdatatitle; ?>" ><i class="fa fa-bookmark"></i> Bookmark Our Ad</a>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-4 col-md-12 left_col_wraper" bis_skin_checked="1">
                        <p>© <?php echo date("Y") ?> Savingssites.com. All Rights Reserved.</p>
                    </div>
                    
                    <div class="col-12 col-lg-4 col-md-12 left_col_wraper footer_social_right" bis_skin_checked="1">
                        <span class="follow_ff">Follow us </span>
                        <ul class="list-inline list-inline-sm footer-social-list-2" style="    margin-bottom: 0 !important;">
                            <li><a class="icon fa fa-instagram" href="#"></a></li>
                            <li><a class="icon fa fa-facebook" href="#"></a></li>
                            <li><a class="icon fa fa-twitter" href="#"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
     <script type="text/javascript" src="<?= base_url();?>/assets/js/jquery.js"></script>
     <script type="text/javascript" src="<?= base_url();?>/assets/js/bootstrap.js"></script>
    <script src="js/html5shiv.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>/assets/businessSearch/js/core.min.js" ></script>
    <script type="text/javascript" src="<?= base_url();?>/assets/businessSearch/js/custom.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.6.8/plyr.min.js"></script>

    <script src="<?= base_url();?>/assets/businessSearch/js/script.js?v=<?= microtime(true); ?>"></script> 
    <script src="<?= base_url();?>/assets/businessSearch/js/site/common.js?v=<?= microtime(true); ?>"></script>
   <!--  <script src="<?= base_url();?>/assets/businessSearch/js/site/offer.js?v=<?= microtime(true); ?>"></script> 
    <script src="<?= base_url();?>/assets/businessSearch/js/site/search.js?v=<?= microtime(true); ?>"></script>
    <script src="<?= base_url();?>assets/businessSearch/js/site/favorite.js?v=<?= microtime(true); ?>"></script> -->
    <script type="text/javascript" src="<?=base_url('assets/pagination/paginate-frontend.js')?>"></script>
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f4e93cfce690c19&async=1"></script>
    <script src="<?= base_url();?>/assets/home/customjs/maskedinput.js?v=<?= microtime(true); ?>"></script>
    <script src="<?= base_url();?>/assets/SavingsJs/BusinessSearchCommon.js?v=<?= microtime(true); ?>"></script>
    <script src="<?= base_url();?>/assets/SavingsJs/homecommon.js?v=<?= microtime(true); ?>"></script>
    <script src="https://use.fontawesome.com/2557f322e0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script> 
    <script type="text/javascript" src="<?= base_url();?>/assets/SavingsJs/audioplay.js"></script>
  </body>

</html>