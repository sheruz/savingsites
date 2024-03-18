<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Export Businesses</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="tabs-1">
        <div class="form-group">
        <div class="text-dafault container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">The businesses residing in the system are downloaded from here based upon the business status selection.</div>
          <input type="hidden" id="zoneid" name="zoneid" value="<?=$zoneid?>"/>
          <div id="export_business">
            <!--<table width="85%" class="pretty">-->
            <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
              <tbody>
                <tr>
                  <th width="33%">Businesses Type</th>
                  <th width="34%">Businesses Status</th>
                  <th width="33%">Action</th>
                </tr>
                <tr>
                  <td width="33%"><div >
                      <label for="auto_approve_paid_business_myzone" style="float: left;">All Businesses With All Categories</label>
                    </div></td>
                  <td width="34%" align="left"><input type="hidden" id="buss_kind_1" name="buss_kind_1" value="2"/></td>
                  <td width="33%"><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=2&type=00")?>" id="id_1">
                    <button style="margin-bottom:10px;">Export all businesses with a phone number</button>
                    </a><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=2&type=01")?>" id="id_1_1">
                    <button>Export all businesses without a phone number</button>
                    </a></td>
                </tr>
                <tr>
                  <td width="33%"><div style="float: left;">
                      <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Businesses With Temp Categories<br />
                      </label>
                    </div></td>
                  <td align="left" width="34%"><input type="hidden" id="buss_kind_5" name="buss_kind_5" value="3"/>
                    <select name="bus_type_5" id="bus_type_5" onchange="export_5(<?=$zoneid?>)">
                      <option value="0">All Businesses</option>
                      <option value="3">Active Businesses</option>
                      <option value="-3">Deactive Businesses</option>
                    </select></td>
                  <td width="33%"><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=3&type=3")?>" id="id_5">
                    <button style="margin-bottom:10px;">Export all businesses with a phone number</button>
                    </a><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=31&type=3")?>" id="id_5_1">
                    <button>Export all businesses without a phone number</button>
                    </a></td>
                </tr>
                <tr style="display:none;">
                  <td width="33%"><div style="float: left;">
                      <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Businesses in my zone and located in my zone<br />
                      </label>
                    </div></td>
                  <td align="left" width="34%"><input type="hidden" id="buss_kind_2" name="buss_kind_2" value="1"/>
                    <select name="bus_type_2" id="bus_type_2" onchange="export_2(<?=$zoneid?>);">
                      <option value="0">New Business - Not Yet Approved</option>
                      <option value="1">Paid Business - Ad is viewable</option>
                      <option value="-1">Paid Business - Ad is not viewable</option>
                      <option value="2">Free Trial Business - Ad is viewable</option>
                      <option value="-2">Free Trial Business - Ad is not viewable</option>
                    </select></td>
                  <td width="33%"><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=1&type=0")?>" id="id_2">
                    <button style="margin-bottom:10px;">Export all businesses with a phone number</button>
                    </a>
                    <div class="spacer"></div>
                    <a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=11&type=0")?>" id="id_2_1">
                    <button>Export all businesses without a phone number</button>
                    </a></td>
                </tr>
                <tr>
                  <td width="33%"><div style="float: left;">
                      <!--<label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Businesses advertising in my zone but located outside my zone<br />
                      </label>-->
                      <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Businesses With Non Temp Categories<br />
                      </label>
                    </div></td>
                  <td align="left" width="34%"><input type="hidden" id="buss_kind_3" name="buss_kind_3" value="0"/>
                    <select name="bus_type_3" id="bus_type_3" onchange="export_3(<?=$zoneid?>);">
                      <option value="0">New Business - Not Yet Approved</option>
                      <option value="1">Paid Business - Ad is viewable</option>
                      <option value="-1">Paid Business - Ad is not viewable</option>
                      <option value="2">Free Trial Business - Ad is viewable</option>
                      <option value="-2">Free Trial Business - Ad is not viewable</option>
                    </select></td>
                  <td width="33%"><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=0&type=0")?>" id="id_3">
                    <button style="margin-bottom:10px;">Export all businesses with a phone number</button>
                    </a><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=00&type=0")?>" id="id_3_1">
                    <button>Export all businesses without a phone number</button>
                    </a></td>
                </tr>
                <tr style="display:none;">
                  <td width="33%"><div style="float: left;">
                      <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">All businesses which are not assigned to any zone<br />
                      </label>
                    </div></td>
                  <td align="left" width="34%"><input type="hidden" id="buss_kind_4" name="buss_kind_4" value="5"/>
                    <select name="bus_type_4" id="bus_type_4" onchange="export_4(<?=$zoneid?>);">
                      <option value="0">New Business - Not Yet Approved</option>
                      <option value="1">Paid Business - Ad is viewable</option>
                      <option value="-1">Paid Business - Ad is not viewable</option>
                      <option value="2">Free Trial Business - Ad is viewable</option>
                      <option value="-2">Free Trial Business - Ad is not viewable</option>
                    </select></td>
                  <td width="33%"><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=5&type=0")?>" id="id_4">
                    <button style="margin-bottom:10px;">Export all businesses with a phone number</button>
                    </a><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=51&type=0")?>" id="id_4_1">
                    <button>Export all businesses without a phone number</button>
                    </a></td>
                </tr>
                
                
                <!--Added for the download of the Dupplicate businesses on 6/6/14-->
                <tr style="display:none;">
                  <td width="33%"><div style="float: left;">
                      <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Duplicated Businesses in my Zone<br />
                      </label>
                    </div></td>
                  <td width="33%"><input type="hidden" id="id_business_type_1" name="id_business_type_1" value="6"/></td>
                  <td><a href="<?=base_url("csvuploader/export_controller.php?zone=".$zoneid."&kind=6&type=00")?>" id="id_6_1">
                    <button style="width:100%;">Export all Duplicate businesses</button>
                    </a></td>
                </tr>
                <!--Added for the download of the Dupplicate businessesm on 6/6/14-->
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_business_accordian').click();
	$('#zone_business_accordian').next().slideDown();
	$('#zone_export_business').addClass('active');
});
</script> 
<script>
function export_2(zoneid){ 
	var buss_type_2=$('#bus_type_2').val();
	$('#id_2').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=1&type="+buss_type_2);
	$('#id_2_1').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=11&type="+buss_type_2);
}
function export_3(zoneid){ 
	var buss_type_3=$('#bus_type_3').val();
	$('#id_3').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=0&type="+buss_type_3);
	$('#id_3_1').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=00&type="+buss_type_3);
}
function export_4(zoneid){ 
	var buss_type_4=$('#bus_type_4').val();
	$('#id_4').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=5&type="+buss_type_4);
	$('#id_4_1').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=51&type="+buss_type_4);
}
function export_5(zoneid){ 
	var buss_type_5=$('#bus_type_5').val();
	$('#id_5').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=3&type="+buss_type_5);
	$('#id_5_1').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=31&type="+buss_type_5);
}
</script> 
