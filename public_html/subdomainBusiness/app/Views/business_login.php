<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Business Login | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>
<section class="section section-sm bg-default text-md-left">
    <div class="container">
      <div class="row justify-content-center align-items-xl-center">             
        <div class="col-lg-4 col-md-4 col-sm-12">
          <div class="text-center"><img src="https://cdn.savingssites.com/login.png" class="max75" /></div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
          <h2 class="white"><?php echo $formtitle ?> Account Login</h2> 
          <h3 class="white"></h3>
          <form id="login-form" name="login-form" method="post">
            <div id="process_login" style="display:none"></div>
            <div id="error_login" style="display:none"></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <input type="hidden" name="logintype" id="business_logintype" value="<?php echo $logintype;?>">
              <tr>
                <td width="20%"><label for="name">Username</label></td>
                <td width="65%"><input type="text" class="validate[required] medium" name="username" id="business_username" value=""  /></td>
                <td width="15%" id="errOffset">&nbsp;</td>
              </tr>
              <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" class="validate[required] medium" name="password" id="business_password" value="" /></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <div class="g-recaptcha" data-sitekey="6Lfo36MUAAAAAIjnLcAq99gxiz0wl9_e4aUPq2m2" data-callback="verifyCaptcha"></div>
                  <div style="color:#a94442;display:none;font-size:12px;" id="g-recaptcha-error">Select rechapta </div>
                </td>
              </tr>
              <tr>
                <td valign="top"><label for="log">Keep me Logged in</label></td>  
                <td><input type="checkbox" name="log" /></td>
                <td valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><input type="button" name="button" id="loginBusinessform" value="Login" class="btn btn-primary login" />
                  <input type="reset" name="button2" id="button2" value="Reset" class="btn btn-secondary" />
                </td>
              </tr>
            </table>
          </form>
          <br/>
        <div align="left" style=""><a href="<?=base_url('home/get_forgot_password')?>/<?php echo $logintype;?>" class="whiteLink">Forgot your password?</a>&nbsp;&nbsp;</div>
      </div>
    </div>  
  </div>
</section>
<?=$this->endSection()?>