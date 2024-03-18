
<div class="main_content_outer"> 

  

<div class="content_container">
	<div class="refer_code_note">2 Free Discounted Cash Certificates<br>for Every New Sign-Up You Refer!,Both you the Referrer and your new referred sign-up each get one free one!<br>We will even apply the free ones towards the most expensive cash certs!</div>
<div class="refer_code_note">Your refer Code is:- <strong><span class="refertext"></span></strong></div>

<div class="refer_invite_col">

	<div class="bv_referal_left">
		
<img src="https://i.postimg.cc/tgy1Xb9q/tied-working.png"/>

	</div>

	<div class="bv_referal_right">
<div class="container_tab_header">Invite Your Friends by Email</div>

<div class="bv_pbg_col">
	<input type="email"  id="referlinkmail" placeholder="Enter Email Address"/> <button class="btn btn-info" type="button" id="mailsend">Send Mail</button>
</div>
</div>
</div>


<div class="bv_share_link">

	<div class="bv_sharelink_left">
		
		<img src="https://i.postimg.cc/Bbk9J2Pr/based-learning.jpg">

	</div>

<div class="bv_sharelink_right">
<div class="container_tab_header">Share Your Invite Link</div>

<div class="bv_pbg_col">
	<input type="text"  id="referlinktext" style="width:300px;" readonly /> 
	<div class="bv_referal_btn">
	<button class="btn btn-info" type="button" onclick="copyToClipboard('referlinktext')">copy</button>
	<a class="btn btn-info" id="fb" href="" target="_blank">Share on facebook</a> 
	<a class="btn btn-info" id="twitter" href="" target="_blank">Share on Twitter</a> 
	</div>
</div>

</div>
</div>

<div></div>



<script type="text/javascript">

$(document).ready(function () { 
	get_refer_code();
	$('#zone_data_accordian').click();

	$('#zone_data_accordian').next().slideDown();

	$('#referLinkGen').addClass('active');

	$( "#tabs" ).tabs({ selected: 1});


	$(document).on('click', '#mailsend', function(){
		var email = $('#referlinkmail').val();
		var type = 'link_refer_mail';
		var code = $('.refertext').text();
		if(email != ''){
			$.ajax({
				'url' :'<?=base_url('Zonedashboard/refer_generate')?>',
				'type':'POST',
				'data':{'email':email,'type':type,'code':code},
				success:function(r){
					alert("Email send Successfully");
				}
			});
		}
	});
});
function get_refer_code(){
	var baseurl = '<?=base_url()?>';
	$.ajax({
		'url' :'<?=base_url('Zonedashboard/get_refer_link')?>',
		'type':'GET',
		'dataType':'json',
		success:function(r){
			if(r.status == 'success'){
				var code = r.data;
				var link = baseurl+ 'zone/refer/'+code; 
				$('#referlinktext').val(link);
				$('.refertext').text(code);
				$('#fb').attr('href', 'https://www.facebook.com/sharer.php?u='+link);
				$('#twitter').attr('href', 'http://www.twitter.com/share?url='+link);
			}
		}
	});
}
function copyToClipboard(elementId) {
	var textBox = document.getElementById(elementId);
    textBox.select();
    document.execCommand("copy");
	alert("Copy To ClipBoard");
}

</script>