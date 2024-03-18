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

<script src="<?= base_url(); ?>/assets/js/jquery.js"></script>
<script src="<?= base_url(); ?>/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url(); ?>/assets/SavingsJs/scrap.js?v=<?= time();?>"></script>
</body>
</html>

