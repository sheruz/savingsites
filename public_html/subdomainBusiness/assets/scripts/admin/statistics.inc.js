// JavaScript Document
function get_business(zone_id,page)
{
	if(zone_id!=0){
		$.post("statistics/get_zone_business/"+zone_id, {"page":page},
				function(data) {
					$('#statistics').css('display','block');
					$("#businesslist").html(data);
					$( "#to_date_populer,#from_date_populer,#from_date_business,#to_date_business,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
		    });
		
	}else{
		$('#statistics').css('display','none');
	}
}



function get_display_state_date(div_id,zone)
{
	
	if(div_id=='category_populer')
	{
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		
		$.post("statistics/get_display_state_date/category_populer/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#category_populer").html(data);
					
					$( "#to_date_populer,#from_date_populer,#from_date_business,#to_date_business,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}else if(div_id=='ads_populer')
	{
		var from_date = $("#from_date_populer").val();
		var to_date = $("#to_date_populer").val();
		
		$.post("statistics/get_display_state_date/ads_populer/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#ads_populer").html(data);
					
					$( "#to_date_populer,#from_date_populer,#from_date_business,#to_date_business,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}else if(div_id=='business_favourite')
	{
		var from_date = $("#from_date_business").val();
		var to_date = $("#to_date_business").val();
		
		$.post("statistics/get_display_state_date/business_favourite/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#business_favourite").html(data);
					
					$( "#to_date_populer,#from_date_populer,#from_date_business,#to_date_business,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}
}