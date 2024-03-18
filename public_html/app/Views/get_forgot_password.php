<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Get Forgot Password
<?=$this->endSection()?>
<?=$this->section("content")?>
<section class="section section-sm bg-default text-md-left">
  <div class="container">
    <div class="row justify-content-center align-items-xl-center">  
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="text-center"><img src="<?= base_url();?>/assets/home/directory/images/login.png" class="max75" /></div> 
      </div>
      <div class="col-lg-8 col-md-8 col-sm-12">
        <h2 class="white">Forgot Password</h2>
        <h3 class="white">Password will be mailed to your email id</h3>
        <div class="response_mssg"></div>
        <input type="hidden" name="usertype" id="usertype_forgot" value="<?php echo $typeid;?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="20%"><label for="name">Username</label></td>
                <td width="65%"><input type="text" class="validate[required]" name="username" id="username_forgot" value="" /></td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="button" id="forgot-password-form" class="forgotpassword btn btn-primary" name="button" value="Retrieve" />
                </td>
              </tr>
            </table>
          <br/>
        </div>
      </div>  
    </div>
  </section>
<?=$this->endSection()?>