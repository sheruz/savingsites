<?foreach($adlist as $ad){
extract($ad);
?>
<div class="clear" align="center">
					<h5><?=$biz_name?></h5>
					<p><?=$street_address_1?> <?=$city?>, <?=$state?> <?=$zip_code?><br />
					</p>
					(P) <?=$phone?>&nbsp;&nbsp;(E) <a href="mailto://<?=$email?>"><?=$email?></a>
                    <br/><?if(!empty($website)) { echo("<a href='http://$website'>Website</a>");}?>
					</p>
				</div>
				<div id="offer-input">
					<h4>Discount Special Offer:</h4>
					<div class="otext"><?=$adtext?></div>
				</div>
				<div style="padding-left: 220px;">
					<div class="button2x"><a href="#" onclick='sendText(<?=$ad_id?>);return false;'>Text Me Your Discount Special Now</a> </div>
					<div class="button2x"><a href="#" onclick='sendEmail(<?=$ad_id?>);return false;'>Email Me Your Discount Special Now</a> </div>
				</div>
<?}?>        
<script type="text/javascript">
$(document).ready(function () {
    var email = $.cookie("email");
    var phoneNum = $.cookie("phoneNumber");
    var carrier= $.cookie("carrier");

    if(email != null){ $("#email").val(email);}
    if(phoneNum != null){ $("#phone").val(phoneNum);}
    if(carrier != null){ $("#carrier").val(carrier);}
});

function sendText(adId){
    $.cookie("phoneNumber", $("#phone").val(), { expires: 90 });
    $.cookie("carrier", $("#carrier").val(), { expires: 90 });
    sendIt(adId, stripAlphaChars($("#phone").val()) + "@" + $("#carrier").val());
}

function sendEmail(adId){
    $.cookie("email", $("#email").val(), { expires: 90 });
    sendIt(adId, $("#email").val());
}

function sendIt(adId, emailAddress){
     var dataToUse = {
        "adId": adId,
        "emailAddress":emailAddress
    };

    PageMethod("<?=base_url('ads/mailad')?>", "Sending Mail<br/>This may take a minute.", dataToUse, null, null);
}
function stripAlphaChars(pstrSource) 
{ 
    var m_strOut = new String(pstrSource); 
    m_strOut = m_strOut.replace(/[^0-9]/g, ''); 

    return m_strOut; 
}
</script>