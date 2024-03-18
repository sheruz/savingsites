var link_path ; 
var base_url ;
var zoneId ;
var user_id ;
var user_type ;
$(document).ready(function(){
	/* set global variables @anish*/
	link_path = $('input[name=link_path]').val(); 
	base_url = $('input[name=base_url]').val();
	zoneId = $('input[name=zoneid]').val();
	user_id = $('input[name=user_id]').val();
	user_type = $('input[name=user_type]').val();
    

    /* Close button*/
    $(document).on('click','.bannerClose',function(){
         var $target = jQuery(this).parent("#" + jQuery(this).data("parent")); //console.log($target); return false;
         $target.removeClass('active');

    });

    $(document).on('click','.announceWrapperOrg a.title',function(){
    //jQuery('.announceWrapperOrg a.title').click(function(event){  
        jQuery(this).animate({
            fontSize: "14px"
        }, {queue:true,duration:300}, function() {
            jQuery(this).animate({
                fontSize: "14px"
            }, {queue:true,duration:200});
        }); 
        jQuery('.announceWrapperOrg a').removeClass('announceActive');
        jQuery('.announceWrapperOrg a').attr('style', '');
        var announce = jQuery("#" + jQuery(this).parent().parent().data('parent'));
        jQuery(this).addClass('announceActive');    
        announce.find('.orgbannermainorg').hide('slow') ;
        jQuery('.orgbannermain1org').addClass('withbg') ;
        jQuery('.orgbannermain1org').html('<h3 class="text-center"></h3><p>You can also receive EmailNotices from this Organization sent by SavingsSites,<br>therefore your email address will not be provided to the Organization! <a class="contactemail" href="javascript:void(0)">HERE</a></p>') ;
        jQuery('.orgbannermain1org > h3').text(jQuery(this).text()) ;
        jQuery(this).animate({
            fontSize: "1.2em",
            opacity:0.5
        }, 200, function() {
            jQuery(this).animate({
                opacity: 1.0
            }, 200);
        });     
        return false;
    });

    $(document).on('click','.announceWrapperHSSport a.title',function(){
    //jQuery('.announceWrapperHSSport a.title').click(function(event){  
        jQuery(this).animate({
            fontSize: "14px"
        }, {queue:true,duration:300}, function() {
            jQuery(this).animate({
                fontSize: "14px"
            }, {queue:true,duration:200});
        }); 
        jQuery('.announceWrapperHSSport a').removeClass('announceActive');
        jQuery('.announceWrapperHSSport a').attr('style', '');
        var announce = jQuery("#" + jQuery(this).parent().parent().data('parent'));
        jQuery(this).addClass('announceActive');    
        announce.find('.orgbannermainHSSport').hide('slow') ;
        jQuery('.orgbannermain1HSSport').addClass('withbg') ;
        jQuery('.orgbannermain1HSSport').html('<h3 class="text-center"></h3><p>You can also receive EmailNotices from this Organization sent by SavingsSites,<br>therefore your email address will not be provided to the Organization! <a class="contactemail" href="javascript:void(0)">HERE</a></p>') ;
        jQuery('.orgbannermain1HSSport > h3').text(jQuery(this).text()) ;
        jQuery(this).animate({
            fontSize: "1.2em",
            opacity:0.5
        }, 200, function() {
            jQuery(this).animate({
                opacity: 1.0
            }, 200);
        });     
        return false;
    });
});

