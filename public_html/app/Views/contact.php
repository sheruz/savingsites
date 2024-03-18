<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Contact
<?=$this->endSection()?>
<?=$this->section("content")?>
<style type="text/css">
  #loading{
    display: none !important;
  }
</style>
  <section class="section section-sm bg-default text-md-left contactpage">
    <div class="container">
      <div class="row justify-content-center align-items-xl-center">
        <div class="col-lg-5 col-md-5 col-sm-5">
          <div style="font-size:14px;font-weight:normal;text-align:center;margin-top:10px;"><b style="font-size:24px;">Savings Sites</b><br/>9736189906</div> 
          <div class="text-center"><img src="<?= base_url(); ?>/assets/home/directory/images/contactus1.png" class="max75" /></div>
        </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
        <h2>Contact Savings Sites!</h2>
        <h3>Drop us a line and we will get back to you</h3>
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="20%"><label for="name">Name <span style="color: red;">*</span></label></td>
              <td width="65%">
                <input type="text" class="validate[required,custom[onlyLetter]]" name="name" id="name" value="" />
              </td>
              <td width="15%" id="errOffset">&nbsp;</td>
            </tr>
            <tr>
              <td><label for="email">Email <span style="color: red;">*</span></label></td>
              <td><input type="text" class="validate[required,custom[email]]" name="email" id="email" value="" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="phone">Phone</label></td>
              <td><input type="text" class="" name="phone" id="phone" value="" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label for="subject">Subject</label></td>
              <td>
                <select name="subject" id="subject">
                  <option value="" selected="selected"> - Choose -</option>
                  <option value="Interested in Owning a Savings Sites Zone">Interested in Owning a Savings Sites Zone</option>
                  <option value="My Businesses Interested in Advertising">My Businesses Interested in Advertising</option>
                  <option value="I have a Suggestion to Improve Savings Sites">I have a Suggestion to Improve Savings Sites</option>
                  <option value="I Want to Propose a Joint Venture">I Want to Propose a Joint Venture</option>
                  <option value="I wish to Report Technical Issue(s)">I wish to Report Technical Issue(s)</option>
                  <option value="Other">Other</option>
                </select>
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign="top"><label for="message">Message</label></td>
              <td><textarea name="message" id="message" class="validate[required]" cols="35" rows="5"></textarea></td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
              <td colspan="2"><input type="button" name="button" class="btn btn-primary" id="contactpost" value="Submit" />
                
                <img id="loading" src="<?= base_url(); ?>/assets/home/gif/loading.gif" width="16" height="16" alt="loading" />
              </td>
            </tr>
          </table>
        </div>                      
    </div>  
  </div>
</section>
<?=$this->endSection()?>