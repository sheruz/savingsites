<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keith
 * Date: 10/9/12
 * Time: 9:42 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<table class="pretty" id="statTable">
    <thead>
        <tr>
            <th colspan="3">Select Date Range</th>
            <th>Select Statistic</th>
        </tr>
        <tr>
            <th><input type="text" name="from_date" id="from_date"/> </th>
            <th>To</th>
            <th><input type="text" name="to_date" id="to_date" /></th>
            <th><select id="statistic">
                <option selected="selected" disabled="true">Select Statistic</option>
                <option value="1">Most Popular Category (Top 5)</option>
                <option value="2">Most Popular Ads (Top 5)</option>
                <option value="3">Raw Hits</option>
                <option value="4">Category Loads</option>
                <option value="5">Ad Loads</option>
                <option value="6">Ad Sends (email/text)</option>
                <optgroup label="No Date Range Needed Below Here">
                    <option value="7">Favorited Businesses</option>
                    <option value="8">SNAP Subscriber Count (by Business)</option>
                </optgroup>
            </select><input type="image" src="<?=base_url('assets/images/get_stats.png')?>" onclick="fetchStats();return false;" title="Get Stats" value="Get Stats" class="img16"/></th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="4"><br/></td>
    </tr>
    </tbody>
</table>
<div id="statTableResult">
    
</div>
<script type="text/javascript">

         $( "#from_date" ).datepicker({
            changeMonth: true,
            numberOfMonths: 3,
            altFormat: "yy-mm-dd",
            onSelect: function( selectedDate ) {
                $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to_date" ).datepicker({
            changeMonth: true,
            numberOfMonths: 3,
            altFormat: "yy-mm-dd",
            onSelect: function( selectedDate ) {
                $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
            }
        });

    function fetchStats(){
        var data = {
            start_date : $.datepicker.formatDate('yy/mm/dd', $("#from_date").datepicker("getDate")),
            end_date : $.datepicker.formatDate('yy/mm/dd', $("#to_date").datepicker("getDate")),
            stat : $("#statistic").val(),
            zone_id : <?=$zone_id?>
                };
        PageMethod("<?=base_url('dashboards/fetch_stats')?>", "Fetching Statistics<br/>This may take a minute.", data, fetchStatSuccessful, null);

    }
    function fetchStatSuccessful(result){
        $.unblockUI();
        $('#statTableResult').html(result.Tag);
    }
</script>