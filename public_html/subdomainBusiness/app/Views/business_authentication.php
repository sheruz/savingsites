<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Business Authentication | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>
    <div id="about_content1" class="main_body">
        <input type="hidden" name="zone_id" id="zone_id" value="<?= $zone_id ?>">
        <h1 style="text-align: center;">Business Authentication</h1>
        <p style="text-align: center;">We already have almost 90% of local business data records in our database.</p>
        <p style="text-align: center;">If we already have your business contact information, you will not need to complete the business registration page.</p>
        <p style="text-align: center;"><strong>Let's Check!</strong></p>
        <div class="col-lg-12 col-md-12 col-sm-12 col-sm-offset-3">
            <form id="business-auth-form" name="business-form" method="post" >
                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="business_reg_table">
                    <tr>
                        <td width="100%" style="text-align: center;"><label for="name">ENTER your 10-digit phone number:</label></td>              
                    </tr>
                    <tr>
                        <td width="75%" style="text-align: center;">
                            <input type="hidden" id="passfrom" name="passfrom" value="<?= $passfrom ?>">
                            <input type="hidden" name="businessid" id="businessid" value="<?= $businessid ?>">
                            <input type="text" class="validate[required]" name="userid" id="userid" value="" />
                            <input type="button" name="button2" id="business-auth" value="Go" class="btn submit"/>
                        </td>
                        <td><span id="message" style="color: red;"></span></td>              
                    </tr>
                    <tr>
                        <td valign="top">&nbsp;</td>
                        <td colspan="2" class="business_reg_btns">
                    </tr>
                </table>
            </form>
        </div>
        <div align="center" style="color:#fff;" id="invalidBusinessAuthenmticateUser" style="display: none;"></div>
    </div>
<?=$this->endSection()?>