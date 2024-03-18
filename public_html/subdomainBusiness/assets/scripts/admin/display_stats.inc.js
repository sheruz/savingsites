function get_display_state(zone)
{
	$.post("display_stats/get_display_state/"+zone, '',
			function(data) {
				$('#statistics').css('display','block');
				$("#businesslist").html(data);
				
				$( "#from_date_sent,#to_date_sent,#to_date_Ads_times,#from_date_Ads_times,#from_date, #to_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat:'yy-mm-dd'
				});
				
			}
	);
}

function get_display_state_date(div_id,zone)
{
	if(div_id=='time_category_loaded')
	{
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		
		$.post("display_stats/get_display_state_date/time_category_loaded/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#time_category_loaded").html(data);
					
					$( "#from_date_sent,#to_date_sent,#to_date_Ads_times,#from_date_Ads_times,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}else if(div_id=='time_ads_loaded')
	{
		var from_date = $("#from_date_Ads_times").val();
		var to_date = $("#to_date_Ads_times").val();
		
		$.post("display_stats/get_display_state_date/time_ads_loaded/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#time_ads_loaded").html(data);
					
					$( "#from_date_sent,#to_date_sent,#to_date_Ads_times,#from_date_Ads_times,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}else if(div_id=='time_ads_sent')
	{
		var from_date = $("#from_date_sent").val();
		var to_date = $("#to_date_sent").val();
		
		$.post("display_stats/get_display_state_date/time_ads_sent/"+zone, {'from_date':from_date,'to_date':to_date},
				function(data) {
					$("#time_ads_sent").html(data);
					
					$( "#from_date_sent,#to_date_sent,#to_date_Ads_times,#from_date_Ads_times,#from_date, #to_date" ).datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat:'yy-mm-dd'
					});
					
				}
		);
	}
}

