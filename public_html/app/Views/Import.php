<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<input type="hidden" id="csvcheck" value="<?= $csv; ?>">
<input type="hidden" id="unrestype" value="<?= $restype; ?>">
<section class="section section-sm bg-default text-md-left">
    <div class="container">
      <div class="row justify-content-center align-items-xl-center">             
        <div class="col-lg-4 col-md-4 col-sm-12">
          
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
          <h2 class="white">CSV Import</h2> 
          <h3 class="white"></h3>
          <form id="csvForm" name="login-form" method="post">
           
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="20%"><label for="name">Type</label></td>
                <td width="65%"><select class="form-control restype">
                  <option value="1">Restaurant</option>
                  <option value="2">Non Restaurant</option>
                  <option value="3">Non-profit Organization</option>
                  </select></td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>
              <tr id="zonediv">
                <td width="20%"><label for="name">Zone Id</label></td>
                <td width="65%">
                  <select class="form-control" id="zoneidcsv">
                    <option>Select Zone</option>
                    <?php
                      foreach ($zoneIddata as $v) {
                        echo '<option value="'.$v['id'].'">'.$v['id'].'</option>'; 
                      }
                     ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="20%"><label for="name">Select File</label></td>
                <td width="65%"><input type="file" class="medium form-control" name="file" id="file" value=""  /></td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>
              
              <!-- <tr>
                <td width="20%"><label for="name">Delete Old Selected Zone Data</label></td>
                <td width="65%"><input type="checkbox" class="medium" name="oldcheck" id="oldcheck" value=""  /></td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr> -->
              <!-- <tr id="deleterow" class="hide">
                <td valign="top">&nbsp;</td>
                <td valign="top">
                  <div class="w3-light-grey">
                    <span>Deleting Business</span>
                    <div class="w3-green" style="background: green;height:24px;width:0%;text-align: center;"><span id="percount">0%</span></div>
                  </div>
                  <br>
                </td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>  -->
              <!-- <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">
                  <div class="w3-light-grey hide">
                    <div class="w3-green" style="background: green;height:24px;width:0%;text-align: center;"><span id="percount">0%</span></div>
                  </div>
                  <br>
                </td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>  --> 
              
            
              <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="submit" name="button" id="Upload" value="Upload" class="btn btn-primary login loginBusinessform" />
                </td>
              </tr>
            </table>
          </form>
          <br/>
      </div>
    </div>  
  </div>
</section>
<script type="text/javascript">
  // var pass1 = 'hello123';
  // password=prompt('Please enter password to view page')    
  // if(password==pass1){
  //   alert('password correct! Press ok to continue.')
  // }else{
  //   window.location.href = "/zone/213";
  // }
</script>
<?=$this->endSection()?>