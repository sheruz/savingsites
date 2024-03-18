/**
    * @preserve for Menu maker From Directory 
    * @created on 11/15/2018
    * @created by Athena Esolutions
*/
$(document).on('click','.show_food_menu',function(){
       
    var businessId = $(this).attr('data-businessId');
    var adId       = $(this).attr('data-id');   
    var baseurl = $('input[name=base_url]').val();
    var theme = "theme1";
    var url = baseurl+"restaurantMenuMaker/preview.php?theme="+theme+"&bsid="+businessId;   
    var fragmentId = "#tabs"+"-5-"+adId; 
    var $dynamicIframe = $(document).find(fragmentId);
    $dynamicIframe.find('iframe').attr('src',url);
});