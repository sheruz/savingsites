<style>
  .ui-widget.success-dialog {
    font-family: Verdana,Arial,sans-serif;
    font-size: .8em;  
  }
  a.page {
    display: none;
  }
  .ui-widget-content.success-dialog {
    background: #F9F9F9;
    border: 2px solid #ACB2A5;;
    color: #222222;
  }
  .ui-dialog.success-dialog {
    left: 0;
    outline: 0 none;
    padding: 0 !important;
    position: absolute;
    top: 0;
  }
  .ui-dialog.success-dialog .ui-dialog-content {
    background: none repeat scroll 0 0 transparent;
    border: 0 none;
    overflow: auto;
    position: relative;
    padding: 0 !important;
    margin: 0;  
  }
  .ui-dialog.success-dialog .ui-widget-header {
    background: lightgrey;
    border: 0;
    color: #000;
    font-weight: normal;
  }
  .ui-dialog.success-dialog .ui-dialog-titlebar {
    position: relative;
    font-size: 19px;
    height: 25px; 
  }
  .btn_bus_search_by_names{
    border-radius: 3px;
    padding: 10px;
    background: #fff;
    color: #333!important;
    margin-right: 19px;
  }
  .listyle{
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
    cursor: pointer;
  }
  .active{
    background-color: #337ab7;
    border-color: #337ab7;
    color: #fff;
  }
</style>

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header" style="position:relative;">
      <div class="bv_filter_querry" style="padding:12px 0;">
        <span class="container_tab_header">My Zone Business Credits</span>
        <input type="hidden" id="exportpattern" value="" />
      </div>
    </div>
    <div id="container_tab_content" class="container_tab_content ui-tabs ui-widget ui-widget-content ui-corner-all">
      <table class="pretty all_business_show_table">
        <thead id="showhead" class="headerclass">
          <tr>
            <th>Business Id</th>
            <th>Business Name</th>
            <th>Total Credits</th>
            <th>Assign Credits</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="creditbodydata"></tbody>
      </table>
    </div>
    <div id="container_tab_footer" class="container_tab_content ui-tabs ui-widget ui-widget-content ui-corner-all">
      <div style="width: 50%;margin: auto;text-align: center;">
        <ul class="pagination paginate paginate-0 paginatecustom">
          <li class="listyle active"  no="1">1</li>
          <li class="listyle" no="2">2</li>
          <li class="listyle" no="3">3</li>
          <li class="listyle" no="4">4</li>
          <li class="listyle" no="5">5</li>
          <li class="listyle" no="6">6</li>
          <li class="listyle" no="7">7</li>
          <li class="listyle" no="8">8</li>
          <li class="listyle" no="9">9</li>
          <li class="listyle" no="10">10</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div style=" position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0, 0, 0, .5);z-index: 1099;" id="loading" class="hide">
  <img style="position: absolute;left: 50%;top: 50%;margin-left: -16px;margin-top: -16px;" src="<?= base_url(); ?>/assets/images/loading.gif">
</div>
<script type="text/javascript">
  $(document).ready(function () { 
    getdata(0,10);
    
    $(document).on('click','.assign_credits', function(){
      var resid = $(this).closest('tr').attr('resid');
      var credit_qty = $(this).closest('tr').find('.assign_credit').val();
      var $this = $(this);
      if(credit_qty != ''){
        $.ajax({
          url: "<?=base_url('Zonedashboard/set_business_credits')?>", 
          type: 'post',
          data:{'resid':resid,'credit_qty' :credit_qty},
          dataType: "json",
          beforeSend: function() {
            $("#loading").removeClass('hide');
          },
          complete: function() {
            $("#loading").addClass('hide');
          },
          success: function (r) {
            $this.closest('tr').find('.creditsno').html(r.data);
          }
        });
      }
    });

    $(document).on('click','.listyle', function(){
      $('.listyle').removeClass('active');
      $(this).addClass('active');
      var $div = $('.paginatecustom>li').last();
      var $div1 = $('.paginatecustom>li').first();
      var lastdigit = $div.attr('no'); // for id
      var firstdigit = $div1.attr('no'); // for id
      var startno = $(this).attr('no');
      var limit = 10;
      var start = (startno-1)*10;
      if(parseInt(lastdigit) == parseInt(startno)){
        var plusno = parseInt(startno)+1;
        $(this).after('<li class="listyle" no="'+plusno+'">'+plusno+'</li>');
        $('.paginatecustom>li').first().remove();
      }
      if(parseInt(firstdigit) == parseInt(startno)){
        var plusno = parseInt(startno)-1;
        if(plusno <= 0){}else{
          $('.paginatecustom>li').last().remove();
        }
        if(plusno != 0){
          $(this).before('<li class="listyle" no="'+plusno+'">'+plusno+'</li>');
        }
      }
      getdata(start, limit);
    });

  });

  function getdata(start = 0, limit = 10) {
    var html = '';
    $.ajax({
      url: "<?=base_url('Zonedashboard/get_business_credits')?>", 
      type: 'get',
      data:{'start':start,'limit' :limit},
      dataType: "json",
      beforeSend: function() {
        $("#loading").removeClass('hide');
      },
      complete: function() {
        $("#loading").addClass('hide');
      },
      success: function (r) {
        $.each(r, function(k,v){  
          html += '<tr resid="'+v.id+'">';
          html += '<td><center>'+v.id+'</center></td>';
          html += '<td><center>'+v.name+'</center></td>';
          html += '<td><center class="creditsno">'+v.credits+'</center></td>';
          html += '<td><center><input type="number" class="assign_credit"/></center></td>';
          html += '<td><center><button class="btn btn-info assign_credits">Assign</button></center></td>';
          html += '<tr>'; 
        })
        $('#creditbodydata').html(html);
      }
    });
  }
  


	

</script>