<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<style>

  td{
    width: 100px;
  }

</style>
<input type="hidden" id="restype" value="<?= $restype; ?>"/>
<section class="section section-sm bg-default text-md-left">
    <div class="container-fluid">
      <div class="row justify-content-center align-items-xl-center">             
        <div class="col-lg-12 col-md-12 col-sm-12">
          <h3 class="white">Please map the following fields to import</h3> 
          <h3 class="white"></h3>
          <form id="csvForm" name="login-form" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="20%"><label for="name">Zone Id</label></td>
                <td width="65%"><span id="zoneidmap" zone="<?= $zone_id; ?>"><?= $zone_id; ?></span></td>
                <td width="20%" colspan="2"><label for="name">Delete Old Selected Zone Data</label></td>
                <td width="65%"><input type="checkbox" class="medium" name="oldcheck" id="oldcheck" value=""  /></td>
                <td width="20%"><label for="name">CSV Name</label></td>
                <td width="65%"><?= $_SESSION['csvfilename'] ?></td>
              </tr>
              <tr>
                <?php foreach ($arrtablecolmuns as $k=> $v) {
                  echo '<td class="tablecolindex"  index="'.$k.'" index="'.$v.'" width="200"><span style="border: 1px solid #f6f6f6;padding:2px;">'.$v.'</span></td>';
                  } 
                ?>
              </tr>
              <tr>
                <?php 



                foreach ($arrtablecolmuns as $v) {
                    echo '<td width="200"><select class="csvcolindex">
                        <option>Select</option>';
                        for ($i=0; $i<count($arrfilecolumns) ; $i++) { 
                          $arrfilecolumns[$i] = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $arrfilecolumns[$i]);
                          $selected = "";
                          if(strtolower($v)=="firstname" and in_array(strtolower($arrfilecolumns[$i]),['first name','first_name','fname','f_name'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="lastname" and in_array(strtolower($arrfilecolumns[$i]),['last name','last_name','lname','l_name'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="contactfullname" and in_array(strtolower($arrfilecolumns[$i]),['contactname','contact name','contact_name','cname','c_name'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="companyname" and in_array(strtolower($arrfilecolumns[$i]),['company name','company_name','businessname','bus_name','bname','business'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="zip" and in_array(strtolower($arrfilecolumns[$i]),['zip','zip_code','zipcode','zip code'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="zipcode" and in_array(strtolower($arrfilecolumns[$i]),['zip','zip_code','zipcode','zip code'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="image" and in_array(strtolower($arrfilecolumns[$i]),['image url','imageurl','image_url'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="category" and in_array(strtolower($arrfilecolumns[$i]),['main category','main_category','category'])){
                            $selected = "selected=\"selected\"" ;
                          }if(strtolower($v)=="category" and in_array(strtolower($arrfilecolumns[$i]),['main category','main_category','category'])){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($v)=="dealid" and strtolower($arrfilecolumns[$i])=="deal id") || (strtolower($v)=="dealid" and strtolower($arrfilecolumns[$i])=="dealid")|| (strtolower($v)=="dealid" and strtolower($arrfilecolumns[$i])=="deal_id")){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($v)=="dealtitle" and strtolower($arrfilecolumns[$i])=="deal title") || (strtolower($v)=="dealtitle" and strtolower($arrfilecolumns[$i])=="dealtitle")|| (strtolower($v)=="dealtitle" and strtolower($arrfilecolumns[$i])=="deal_title")){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($v)=="logourl" and strtolower($arrfilecolumns[$i])=="logo url") || (strtolower($v)=="logourl" and strtolower($arrfilecolumns[$i])=="logo_url")|| (strtolower($v)=="logourl" and strtolower($arrfilecolumns[$i])=="logourl")|| (strtolower($v)=="logourl" and strtolower($arrfilecolumns[$i])=="logo")){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($v)=="hours_of_operation" and strtolower($arrfilecolumns[$i])=="hours of operation") || (strtolower($v)=="hours_of_operation" and strtolower($arrfilecolumns[$i])=="hours_of_operation")|| (strtolower($v)=="hours_of_operation" and strtolower($arrfilecolumns[$i])=="hoursofoperation")){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($arrfilecolumns[$i])==strtolower($v))){
                            $selected = "selected=\"selected\"" ;
                          }
                          if((strtolower($v)==str_replace("_","",strtolower($arrfilecolumns[$i])))){
                            $selected = "selected=\"selected\"" ;
                          }
                          
                          
                          if($v=="postcode" and (($arrfilecolumns[$i]==$v) || in_array($arrfilecolumns[$i],array('zip_code','zipcode','zip','post_code','postcode','post')))){
                            $selected = "selected=\"selected\"" ;
                          }
                          if($v=="website" and $arrfilecolumns[$i]=="company_website"){
                            $selected = "selected=\"selected\"" ;
                          }
                          echo '<option index="'.$i.'" '.$selected.' value="'.$arrfilecolumns[$i].'">'.$arrfilecolumns[$i].'</option>';
                        }
                    echo '</select></td>';
                  } 
                ?>
              </tr>
              <tr>
                <td id="actiontext" class="hide">Uploading Business...</td>
                <td valign="top" colspan="6">
                  <div class="w3-light-grey hide">
                    <div class="w3-green" style="background: green;height:24px;width:0%;text-align: center;"><span id="percount">0%</span></div>
                  </div>
                  <br>
                </td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>  
              <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="button" name="button" id="mapUpload" value="Continue" class="btn btn-primary login loginBusinessform" />
                </td>
              </tr>
            </table>
          </form>
        </div>
    </div>  
  </div>
</section>

<?=$this->endSection()?>