<style>
   .bithide{
  width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    background: #fff;
}
</style>
<div class="page-wrapper main-area toggled">
	<div class="container desktopshow">
    	<div class="row" style=" margin-bottom: 80px;">
     		<div class="container">
        		<div class="viewads">
                    <div class="row">
                        <div class="bold700">
                            <div class="noofusersection1">Active Snap Users: <b><?= $nonofusersnapfilteron; ?></b>
                            </div> 
                            <div class="noofusersection1">Deal meets snap filters for this # of people: <b class="snapemailusers"></b>
                            </div>
                        </div>
                    </div>
   					<div class="row justify-content-center mt-0">
    					<div class="col-sm-6 col-md-12 text-center">
        					<div class="card">
            					<h2 style="padding: 20px;"><strong>SNAP Settings</strong> <span class="readsnapbusinessmodal"><u class="readmore">read more</u></span><button class="btn btn-info fright w_200 cus-btn businesssnapbutton" busid="<?= $businessid; ?>" zoneid="<?= $zoneid; ?>">Send Email Now</button></h2>
            					<div class="row">
               						<div class="col-md-12 mx-0">
                  						<div id="msform">
                  							<fieldset>
                           						<div class="form-card" style="color:#000 !important;">
    <!------card row start -------->                       							
    <div class="row">
    	<div class="col-md-8">
            <select class="form-control bold700" id="deallistsnapbusiness" style="width: 50%;margin: 10px 0px;">
                <option value="">Select Deal</option>
                <?php foreach ($snapdealsArr as $k => $v) {
                    $dealtitle = $v['deal_title'];
                    if($v['deal_title'] == ''){
                        $dealtitle = $v['deal_description'];
                        if($v['deal_description'] == ''){
                            $dealtitle = $v['deal_description_link'];
                            if($v['deal_description_link'] == ''){
                                $dealtitle = $v['product_name'];
                            }
                        }
                    }
                    echo '<option value="'.$v['deal_id'].'">'.$dealtitle.'</option>';
                }?>
                
               

            </select>
        	<h4 class="boltext">Prefered time periods to use deals:</h4>
        </div>
        <div class="col-md-4">
            <h4 class="boltext center dasktop-view">Max Number of Customers Claiming SNAP within Time Period</h4>
        </div>
    </div>
    <br>
    
    <div class="row breakbottom">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                        <div class="col-md-2"><h4>Start</h4></div>
                        <div class="col-md-2">
                            <select class="form-control bussnapstarttime bold700">
                                <?php foreach ($snaptimeArr as $starttime) {
                                    echo '<option value="'.$starttime['id'].'">'.$starttime['time'].'</option>';
                                }?>
                            </select>
                        </div>
                        <div class="col-md-2"><h4>End</h4></div>
                        <div class="col-md-2">
                            <select class="form-control bussnapendtime bold700">
                                <?php foreach ($snaptimeArr as $endtime) {
                                    echo '<option value="'.$endtime['id'].'">'.$endtime['time'].'</option>';
                                }?>
                            </select>
                        </div>   
                    </div>
                </div>  
            <h4 class="boltext center mobile-view">Max Number of Customers Claiming SNAP within Time Period</h4> 
            <div class="col-md-4">
                <input type="number" class="form-control bold700" id="noofpeoplesnaptime" placeholder="Enter Number" />
            </div>   
        </div>
    </div>
    <hr>

    <div class="row">
    	<div class="col-md-4"><h4>All Days <input type="checkbox" id="alldays" class="addsnaptype" value="1"/></h4></div>
        <div class="col-md-4"><h4>Weekdays <input type="checkbox" id="weekdays" class="addsnaptype" value="2"/></h4></div>
        <div class="col-md-4"><h4>Weekend <input type="checkbox"  id="weekends" class="addsnaptype" value="3"/></h4></div>
    </div>
    <br>

    <div class="row">
    	<div class="col-md-12">
    		<h4>
    			<div class="weekdayscolumn">M</div>
    			<div class="weekdayscolumn">T</div>
    			<div class="weekdayscolumn">W</div>
    			<div class="weekdayscolumn">T</div>
    			<div class="weekdayscolumn">F</div>
    			<div class="weekdayscolumn">S</div>
    			<div class="weekdayscolumn">S</div>
    		</h4><br>

    		<h4>
                <?php if($snapday != ''){
                    $dayArrword = [1=>'M',1=>'T',1=>'W',1=>'Th',1=>'F',1=>'Sa',1=>'Su'];
                     echo '<div class="weekdayscolumn"><input checked type="checkbox" class="perdayselect" day="'.$snapday.'" dayword="'.$dayArrword[$snapday].'"/></div>'; 
                }else{
                    echo '<div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="1" dayword="M"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="2" dayword="T"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="3" dayword="W"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="4" dayword="Th"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="5" dayword="F"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="6" dayword="Sa"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="7" dayword="Su"/></div>';    
                } ?>
    			
    		</h4>
    	</div>
    </div>
    <br>

    <div class="row">
    	<div class="col-md-12">
    		<button class="font btn btn-info fright w_200 cus-btn businesssnapaddtolist">Add</button>
    	</div>
    </div>
    <br><br>

    <div class="row">
        <div class="col-md-12">
            <div id="snaptimelist">
                <?php 
                if(count($htmladdsnapArr) > 0){
                    foreach ($htmladdsnapArr as $k => $v) {
                        echo $v;
                    }
                }

                ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <button class="font btn btn-info fright w_200 cus-btn savesnapforbusiness <?= $snapupdatebutton; ?>">UPDATE</button>
            <?php 
                if($editsnap == 1){
                    echo '<button class="btn btn-info fright w_200 cus-btn savesnapforbusiness <?= '.$snapupdatebutton.'"><a href="/businessdashboard/'.$businessid.'/show_business_snap"">Cancel</a></button>';
                }
            ?>
        </div>
    </div>
	<!--------card row end------------>                          						
                           						</div>
                         					</fieldset>   
                         				</div>
               						</div>
            					</div>
         					</div>
      					</div>
    				</div>
  				</div>
			</div>
		</div>
	</div>

    <div class="container mobileshow">
        <div class="row" style=" margin-bottom: 80px;">
            <div class="container">
                <div class="viewads">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-md-12 text-center">
                            <div class="card">
                                <h2 class="mobilesnapbusinessheading"><strong>SNAP Settings</strong> <span class="readsnapbusinessmodal"><u class="readmore">read more</u></span><button class="btn btn-info fright w_200 cus-btn businesssnapbutton mbottom" busid="<?= $businessid; ?>" zoneid="<?= $zoneid; ?>">Send Email Now</button>
                                <select class="form-control bold700" id="deallistsnapbusiness" style="width: 50%;">
                <option value="">Select Deal</option>
                <?php foreach ($snapdealsArr as $k => $v) {
                    $dealtitle = $v['deal_title'];
                    if($v['deal_title'] == ''){
                        $dealtitle = $v['deal_description'];
                        if($v['deal_description'] == ''){
                            $dealtitle = $v['deal_description_link'];
                            if($v['deal_description_link'] == ''){
                                $dealtitle = $v['product_name'];
                            }
                        }
                    }
                    echo '<option value="'.$v['deal_id'].'">'.$dealtitle.'</option>';
                }?>
                
               

            </select>
        </h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="msform">
                                            <fieldset>
                                                <div class="form-card" style="color:#000 !important;">
    <!------card row start -------->                                                
    <div class="row">
        <div class="col-md-8">
            
            <h4 class="boltext mobiletextview">Prefered time periods to use deals:</h4>
        </div>
        <div class="col-md-4">
            <h4 class="boltext center dasktop-view">Max Number of Customers Claiming SNAP within Time Period</h4>
        </div>
    </div>
    <br>
    
    <div class="row breakbottom">
        <div class="col-md-6">
            <span>Start</span><br> 
            <select class="form-control bussnapstarttime bold700">
            <?php foreach ($snaptimeArr as $starttime) {
                echo '<option value="'.$starttime['id'].'">'.$starttime['time'].'</option>';
            }?>
            </select>
        </div>
        <div class="col-md-6">
            <span>End</span><br>
                <select class="form-control bussnapendtime bold700">
                <?php foreach ($snaptimeArr as $endtime) {
                    echo '<option value="'.$endtime['id'].'">'.$endtime['time'].'</option>';
                }?>
            </select>
        </div>
    </div>

    <div class="row breakbottom maxnodiv">
        <div class="col-md-6">
            <span class="readsnapbusinessmodal">Max Customers<br><u class="readmore">read more</u></span>
        </div>
        <div class="col-md-6">
            <input type="number" class="form-control bold700" id="noofpeoplesnaptime" placeholder="Enter Number" />
        </div>
    </div>

    <div class="row weekdaydiv">
        <div class="col-md-4"><h4>Weekdays <input type="checkbox" id="weekdays" class="addsnaptype" value="2"/></h4></div>
        <div class="col-md-4"><h4>Weekend <input type="checkbox"  id="weekends" class="addsnaptype" value="3"/></h4></div>
        <div class="col-md-4"><h4>All <input type="checkbox" id="alldays" class="addsnaptype" value="1"/></h4></div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <h4>
                <div class="weekdayscolumn">M</div>
                <div class="weekdayscolumn">T</div>
                <div class="weekdayscolumn">W</div>
                <div class="weekdayscolumn">T</div>
                <div class="weekdayscolumn">F</div>
                <div class="weekdayscolumn">S</div>
                <div class="weekdayscolumn">S</div>
            </h4><br>

            <h4>
                <?php if($snapday != ''){
                    $dayArrword = [1=>'M',1=>'T',1=>'W',1=>'Th',1=>'F',1=>'Sa',1=>'Su'];
                     echo '<div class="weekdayscolumn"><input checked type="checkbox" class="perdayselect" day="'.$snapday.'" dayword="'.$dayArrword[$snapday].'"/></div>'; 
                }else{
                    echo '<div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="1" dayword="M"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="2" dayword="T"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="3" dayword="W"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="4" dayword="Th"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="5" dayword="F"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="6" dayword="Sa"/></div>
                        <div class="weekdayscolumn"><input type="checkbox" class="perdayselect" day="7" dayword="Su"/></div>';    
                } ?>
                
            </h4>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12 mobileaddbotton">
            <button class="font btn btn-info fright w_200 cus-btn businesssnapaddtolist">Add</button>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <div id="snaptimelist">
                <?php 
                if(count($htmladdsnapArr) > 0){
                    foreach ($htmladdsnapArr as $k => $v) {
                        echo $v;
                    }
                }

                ?>
            </div>
        </div>
    </div>
     <div class="row <?= $snapupdatebutton; ?> lastupdatemobilediv">
        <div class="col-md-12 mobileaddbotton">
            <button class="font btn btn-info fright w_200 cus-btn savesnapforbusiness">UPDATE</button>
            <?php 
                if($editsnap == 1){
                    echo '<button class="btn btn-info fright w_200 cus-btn savesnapforbusiness <?= $snapupdatebutton; ?>"><a href="/businessdashboard/'.$businessid.'/show_business_snap"">Cancel</a></button>';
                }
            ?>
        </div>
    </div>
    <div class="row weekdaydiv lastmobdiv">
        <h4 class="mobileviewlastsection mobiletextview"><strong>SNAP List Searches</strong><br><u>read more</u></h4>
        <div class="col-md-6">
            <button class="btn btn-info">Active Snap Users</button>1
            <!-- <h4>Active Snap Users: <b><?//= $nonofusersnapfilteron; ?></b></h4> -->
        </div>
        <div class="col-md-6">
            <button class="btn btn-info">Filters Met</button> 0
            <!-- <h4>Filters Met: <b class="snapemailusers"></b></h4> -->
        </div>
    </div>
    <!--------card row end------------>                                                 
                                                </div>
                                            </fieldset>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="modal fade dfsdfs" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapbusinessmodal"> 
            <div class="modal-dialog" style="max-width: 850px !important;">
                <div class="modal-content">                 
                    <div class="modal-header">                      
                        <h4 class="modal-title pull-left change_title" id="myModalLabel"></h4>
                            <button type="button" class="snapbusinessmodalclose">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body" style="font-size: 18px;background: #fff;">
                <p><strong>1. FREE BENEFITS!</strong>  Savings Sites incentivizes customers to use deals during your slower times! You notify customers of time periods where we will reward customers with SNAP DOLLARS, The SNAP Dollars are used to obtain your next deal, generating repeat business.</p>  
                        
                        <p><strong>2. FAST & EASY:</strong> There are default settings for days of the week, and times of the day, and the number of deals you can handle in the business admin dashboard, for you to further customize. When you use your default snap filter settings you only have to click the button to send. If you prefer to use a different time period, day of week, and max number of deals claimed, then use the second different setting option. Your default settings will stay the same unless you change settings the admin dashboard.</p>
                        
                        <p><strong>3. NO DEALS, NO SNAP:</strong> No SNAP Notices will not be emailed/text if your deals are sold out. You’ll need to authorize an additional batch of deals to enable snap notices.</p>
                        
                        <p><strong>4. MAX NUMBER OF DEALS:</strong> Is the maximum number of deals within your slower time periods, that users can claim a deal, and we reward customers additional snap dollars.</p>
                        
                        <p><strong>5. SNAP CLAIMING LINK:</strong> Each snap notice contains a link for customers to claim one of the deals within your slow time periods. When the user claims a deal to be rewarded additional snap dollars, it also terminates use of that deal. You’ll see the user who claimed the deal in your admin dashboard.</p>
                        
                        <p><strong>6. MANY SNAP PERIODS:</strong> You may have multiple snap time periods within a day. Simply add all the time periods and then update. </p> 
                        
                        <p><strong>7. END IS THE BEGINNING:</strong> When setting your time periods, the end time of your slower time period is when your service starts, not when you expect your customer to be done. So, if your time period is 2:30pm to 4:00pm. A user can ask for service to starts at 4:00pm.</p>  
                    </div>
            </div>
          </div>
        </div>
<script> 
    if (window.matchMedia("(max-width: 767px)").matches){ 
        $('.desktopshow').remove();
    }else{ 
        $('.mobileshow').remove();
    } 
</script> 




