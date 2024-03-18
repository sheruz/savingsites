<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Business Registration | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>
<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<style>
.ss-logos
{
  display: none;
}
</style>
<?php } ?>
<section class="section section-sm bg-default text-md-left saving_business_reg">
  <div class="container">
    <div class="row ">      
      <div class="col-lg-12 col-md-12 col-sm-12">
        <h2 class="white">Register as a Business Advertiser</h2>
        <p class="form-group-row">
          <span class="required-div" style="color:red"><font size="2">* Required Fields</font></span>
        </p>
        <form id="registration-form" name="registration-form" method="post">
          <input type="hidden" name="zoneId" value="<?php echo $zoneid?>">
          
            <div class="row">

              <div class="col-lg-6">
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                            <tr>
              <td width="100%"><label for="company_name">Business Name <span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="business_name" id="business_name" value="" />
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="motto">Business Type</label>
                <select id="restaurant_type" class="fleft w_315">
                  <option value="1">Restaurant</option>
                  <option value="0">Non Restaurant</option>
                </select>
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="motto">Motto/Slogan</label>
                <input type="text" class="" name="motto" id="motto" value="" />
              </td>
              
            </tr>
             
            <tr>
              <td width="100%">
                <label for="name">10 digit Phone #<span style="color:red">*</span></label><small>This is your Username</small> 
                <input type="text" class="validate[required]" name="name" id="name" value="" onblur="username_verification();"/>
                <div style="clear:both;"></div>
                &nbsp;&nbsp;&nbsp; 
                <span id="name_verify" style="font-weight:bold; color:#fff; display:block; text-align:center; display:none;"></span>
              </td>
           
            </tr>
            <tr>
              <td width="100%">
                <label for="password">Password <span style="color:red">*</span></label><small>Case sensitive, any combination of 5 to 18 letters, numbers and special characters (!, @, #, $, %, &)</small>
                <input type="password" class="validate[required]" name="password" id="password" value="" onblur="checkPassword(this.val)" />
                <div style="clear:both;"></div>
                &nbsp;&nbsp;&nbsp; <span id="passerror"></span>
              </td>
            
            </tr>
            <tr>
              <td width="100%"><label for="cpassword">Confirm Password <span style="color:red">*</span></label>
                <input type="password" class="validate[required,confirm[password]]" name="cpassword" id="cpassword" value="" />
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="email">Your Contact Email<span style="color:red">*</span></label><small>(not shared)</small>
                <input type="text" class="validate[required,custom[email]]" name="uemail" id="uemail" value="" />
               </td>
             
            </tr>
            <tr>
              <td width="100%"><label for="cemail">Confirm Your Email <span style="color:red">*</span></label>
                <input type="text" class="validate[required,custom[email],confirm[uemail]]" name="cemail" id="cemail" value="" />
              </td>
             
            </tr>

             <tr>
              <td width="100%"><label for="cemail">Confirm Your Email <span style="color:red">*</span></label>
                <input type="text" class="validate[required,custom[email],confirm[uemail]]" name="cemail" id="cemail" value="" />
              </td>
            </tr>
          
              </table>
              </div>
             

              <div class="col-lg-6">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="100%"><label for="fname">First Name <span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="fname" id="fname" value="" onchange="put_name();" />
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="lname">Last Name <span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="lname" id="lname" value="" onchange="put_name();"/>
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="email">Gender<span style="color:red">*</span></label> 
                <select class="" name="gender" id="gender">
                  <option value="" disabled selected>Choose Gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                  <option value="3">Other</option>
                </select>
              </td>
            </tr>
            <tr style="display:none;">
              <td width="100%"><label for="fullname">Full Name <span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="fullname" id="fullname" value="" />
              </td>
             
            </tr>
            <tr>
              <td width="100%"><label for="phone">Your Personal Phone# (not shared)<span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="phone" id="phone_user" onblur="checkPhone()" placeholder="e.g.XXX-XXX-XXXX "/>
                <div style="clear:both;"></div>
                &nbsp;&nbsp;&nbsp; <span id="phone_error"></span>
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="phone">Street Address<span style="color:red">*</span></label>
                <input type="text" class="validate[required]" name="user_address" id="user_address" value="" />
              </td>
              
            </tr>
            <tr>
              <td width="100%"><label for="phone">Mailing Address <br><small>(if different)</small></label>
                <input type="text" class="" name="user_address2" id="user_address2" value="" />
              </td>
             
            </tr>
            <tr>
              <td width="100%"><label for="website">Website</label>
                <input type="text" class="" name="website" id="website" value="" />
              </td>
              
            </tr>
            <tr style="display:none">
              <td width="100%"><label for="sic">Sic Code</label>
                <input type="text" class="" name="sic_code" id="sic_code" value="" />
              </td>
            
            </tr>
            <tr>
              <td width="100%"><label for="email">Public Contact Email</label><small>(shows in ads)</small> 
                <input type="text" name="bemail" id="bemail" value="" />
              </td>
            </tr>
            <tr>
              <td width="100%"><label for="email">Postal Code<span style="color:red">*</span></label> 
                <select class="" name="postalcode" id="postalcode" onchange="hide_table();">
                  <option value="-1">--Select Zip Code--</option>
                  <?php if(!empty($all_claimed_zip)){
                    foreach($all_claimed_zip as $val){?>
                      <option value="<?= $val->zip; ?>"><?= $val->zip; ?></option>
                  <?php } }?>
                </select>
              </td>
            </tr>
          </table>
        </div>
      </div>

          

<table width="100%" border="0" cellspacing="0" cellpadding="5">
            <?php if(empty($zoneid)){?>
            <tr>
              <td style="font-weight:bold; font-size:19px;" colspan="2"> INITIAL ADVERTISING DIRECTORY</td>
            </tr>     
            <tr>
              <td width="100%"><label for="selstate">State <span style="color:red">*</span></label>
                 <select class="" name="selstate" id="selstate" style="height: 32px; width: 164px;" onchange="getCity()">
                  <option value="-1">--Select State--</option>
                <?php if(!empty($get_all_states)){
                        foreach($get_all_states as $val){?>
                  <option value="<?php echo $val['state_id']; ?>"><?php echo $val['state_name']; ?></option>
                <?php } }?>
                </select>
              </td>
            
            </tr>
            <tr>
              <td width="100%"><label for="selcity">City <span style="color:red">*</span></label>
                <select class="" name="selcity" id="selcity" style="height: 32px; width: 164px;" onchange="getZone()">
                  <option value="-1">--Select City--</option>
                </select>
              </td>
            </tr>
            <tr>
              <td width="100%"><label for="zone">Directory<span style="color:red">*</span></label>
                <select id="selzone" style="height: 32px; width: 164px;" onchange="getZip()">
                  <option value="-1">--Select Directory--</option>
                </select>
              </td>
         
            </tr>
            <tr style="display:none">
              <td width="100%"><label for="zip"> Zip <span style="color:red">*</span></label>
                 <select id="selzip" style="height: 32px; width: 164px;">
                  <option value="-1">--Select Zip--</option>
                </select>
              </td>
       
            </tr>
            <?php } ?>
            <tr>
              <td valign="top">&nbsp;</td>
              <td colspan="2"><input type="button" name="button" id="save_user" value="Register" class="btn btn-primary" />
                <input type="reset" name="button2" id="button2" value="Reset" class="btn btn-secondary" />
                <!-- <img id="loading" src="img/ajax-load.gif" width="16" height="16" alt="loading" /> -->
              </td>
            </tr>
          </table>
        </form>
      <br/>
      </div>
    </div>  
  </div>
</section>   
<?=$this->endSection()?>