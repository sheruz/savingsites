/**
    * @preserve for Email offer From Directory 
    * @created on 11/15/2018
    * @created by Athena Esolutions
*/

 $(document).on('click','.contact_submission',function(){ 
 		//$("#contact_submission_modal").modal('show');
        var adid = $(this).attr('data-adid');
        var busemail = $(this).attr('data-email');
        var useremail = $(this).attr('data-uemail');
        var phone = $(this).attr('data-phone');
        var phone1 = phone.substring(0,3);
        var phone2 = phone.substring(7,4);
        var phone3 = phone.substring(8);
        var firstname = $(this).attr('data-fname');
        var lastname = $(this).attr('data-lname');
        var fullname = firstname + " " +lastname;
        var directaccess = $(this).attr('data-directaccess');
        var busname = $(this).attr('data-busname');
        $('#contact_submission_form #submission_adid').val(adid);
        $('#contact_submission_form #submission_emailid').val(busemail);
        $('#contact_submission_email').val(useremail);
        $('#contact_submission_name').val(fullname);
        $('#contact_submission_phone1').val(phone1);
        $('#contact_submission_phone2').val(phone2);
        $('#contact_submission_phone3').val(phone3);
        $('#contact_submission_form #submission_busname').val(busname);
        $('#contact_submission_form #submission_directaccess').val(directaccess);
        $("#contact_submission_modal").modal('show');
    });

 $(document).on('click','#contact_submit',function(){
 	//alert(555);
    var form_data = $("#contact_submission_form").serialize();
    var adId = $('#submission_adid').val(); 
    var emailId = $('#submission_emailid').val(); 
    var directaccess = "";
    var busname = $('#submission_busname').val(); 
    var data = {'adId':adId, 'form_data':form_data, 'emailId':emailId, 'directaccess':directaccess, 'busname':busname}; 

    $.ajax({
            'url': base_url+"ads/sendcontactform",
            'type': 'POST',
            'data': data,
			'dataType':'json',
            'success': function(response){ 
                if(response!=0 && response!=''){
                    $('#contact_submision_modal_body #contact_submission_message').html("<p style='text-align:center;padding-top: 20px;color:#1c488e'>Your mail has successfully sent</p>");
                   }
            }
        });
 });
 
 $(document).on('click','#contact_reset', function(event) {
        $('#contact_submission_email').val('');
        $('#contact_submission_phone1').val('');
        $('#contact_submission_phone2').val('');
        $('#contact_submission_phone3').val('');
        $('#contact_submission_name').val('');
        $('textarea[name="contact_submission_comments"]').val('');
    });

	 /*var validator_contactsubmit = $("#contact_submission_form").validate({
            rules: {
                email:{
                    required: true,
                    email: true
                },
            },
            submitHandler: function(form) { 
                var form_data = $("#contact_submission_form").serialize();
                var adId = $('#submission_adid').val();
                var emailId = $('#submission_emailid').val();
                var directaccess = $('#submission_directaccess').val();
                var busname = $('#submission_busname').val();
                alert(555);
                //sendcontactform(adId,form_data,emailId,directaccess,busname);            
                
            }
        });
     validator_contactsubmit.resetForm();
*/
	 /*function sendcontactform(adId,form_data,emailId='',directaccess='',busname=''){ 
        alert("hiii"); return false;
        var data = {'adId':adId, 'form_data':form_data, 'emailId':emailId, 'directaccess':directaccess, 'busname':busname};        

        $.ajax({
            'url': '<?=base_url('ads/sendcontactform')?>',
            'type': 'POST',
            'data': data,
            'success': function(response){ 
                if(response!=0 && response!=''){
                   }
            }
        });
    }*/

