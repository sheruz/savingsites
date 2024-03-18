<table width="85%" class="pretty" style="margin-bottom:0;">

    <thead>

    <tr>

	<!--<div style="margin:18px 0 0; background:#333333; color:#fff; padding:10px; font-weight:bold;">Click checkbox next to sub-categories you want visible.<br/>

    After selecting sub-categories click <strong>'Make These Sub-categories Checkmarked Above Visible'</div>-->

    <div class="container_tab_header header-default-message"><p>To select all sub-categories within a main category, it is necessary to click the link of EACH main category which will bring up the corresponding sub-categories. Click on the "Select / Deselect All" check box. To save your selection, click on the button labeled "Make These Sub-categories Checkmarked Above Visible." <br />Repeat this process for each main category.</p></div>

    </tr>

    

     <tr><div class="container_tab_header form-group" >
        <button onclick="main_category();">Back to Main Category Names </button></div></tr>

    

	<?php /*?><tr><div style="margin:18px 0 0; background:#333333; color:#fff; padding:10px; font-weight:bold;"><button onclick="main_category();">Back to Main Category Names </button></div></tr><?php */?>

    

    <tr>

        <th style="width:900px;">Sub-categories of <?php /*?><a href="javascript:void();" style="color:white;" onclick="edit_category(<?php echo $zoneid;?>);"><?php */?><span style="text-decoration:underline;"><?php echo $category_name[0]['name'];?></span><p><input type="checkbox" onclick="return select_all_category(this);" name="select_all_category" id="select_all_category" value="all"  /> Select/Deselect all</p></th>

        <!--<th>Show</th>-->

    </tr>

   <!-- <tr>

        <th style="width:900px;">Show</th

    </tr>-->

    </thead>

    <tbody>

 		<?php

		

		//var_dump($all_subcategories);

		$count = 0;

		foreach ($subcategories as $type) {

			$count+= count($type);

		}

		$tot=$count-1; 

		//echo $tot;

		//$tot=count($all_subcategories);

		//$tot=76;

		$cnt_no=$tot/2;

		$cnt_mod=$tot%2;

		$cnt=0;

		if($cnt_mod==0)

			$cnt=floor($cnt_no);

		else

			$cnt=floor($cnt_no)+1;

		//echo  $cnt;

		$i=1;

		?> 

    	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0; margin-top:0;">

  			<tr>

            	<td>

                	<!-- for left column start -->

                    <table width="50%" align="left" class="pretty" style="width:49.6% !important; margin-top:0;">

                    <?php /*?><?php for($i=0;$i<$cnt;$i=$i+1){?><?php */?>

                    <?php foreach($subcategories as $key=>$val){?>

                    <?php if($key=='-100'){ ?>

                    <?php foreach($val as $item_name=>$item_details){?>

                    <?php if($item_name=='name'){?>

                    <?php } else { ?>                   

						

                    	<tr>

                        	<td>

                            	<?php /*?><input type="checkbox" name="check" class="display_checkbox" disabled="disabled"/><?php echo $item_details['name'];?><?php */?>

                                <input type="checkbox" name="check" class="display_checkbox" 

                                value="<?php echo $item_name;?>"<? if(strpos(','.$display_subcategories.',',','.$item_name.',')!==false) echo 'checked="checked"'?> onclick="individual_checkbox();"

                                /><?php echo $item_details['name'];?>

                        	</td>

                            

                        </tr>

                        <?php if($i % $cnt == 0){

						?>

                        </table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">

						<?php

						}						

						?>

                        <?php $i++;?>

                        <?php } ?>

                        <?php } ?>

                        <?php } else { ?>

                        <?php foreach($val as $item_name=>$item_details){ ?>

                        <?php if($item_name=='name'){?>

                        

                        <tr>

                        	<td>

                            	<strong><strong><?php echo $item_details;?></strong></strong>

                        	</td>

                            

                        </tr>

                         <?php if($i % $cnt == 0){

						?>

                        </table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">

						<?php

						}						

						?>

                        <?php $i++;?>

                       <?php /*?> <?php $i++;?><?php */?>

                    	<?php } else { ?>                   

						

                    	<tr>

                        	<td>

                            	<?php /*?><input type="checkbox" name="check" class="display_checkbox" disabled="disabled"/><?php echo $item_details['name'];?><?php */?>

                                <input type="checkbox" name="check" class="display_checkbox"  value="<?php echo $item_name;?>"<? if(strpos(','.$display_subcategories.',',','.$item_name.',')!==false) echo 'checked="checked"'?> onclick="individual_checkbox();"/><?php echo $item_details['name'];?>   

                        	</td>

                            

                        </tr>

                        <?php if($i % $cnt == 0){

						?>

                        </table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">

						<?php

						}						

						?>

                        <?php $i++;?>

                        <?php } ?>

                        <?php } ?>

                        <?php } ?>

                        <?php } ?>

                       <?php /*?> <?php } ?><?php */?>

                    </table>

                    <!-- for left column end -->

                    <!-- for right column start -->

                    <!--<table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">

                    	<?php for($j=$cnt;$j<$tot;$j=$j+1){?>

                        <tr>

                        	<td>

                            	<input type="checkbox" name="check" class="display_checkbox" disabled="disabled"/>aaaaaaaaaa

                        	</td>

                            

                        </tr>

                        <?php } ?>

                    </table>-->

                     <!-- for right column end -->

                </td>

            </tr>

        </table>



		<tr><td colspan="2"><button onclick="save_display_sub_category(<?php echo $catid;?>,<?php echo $zoneid;?>);" style="margin-left:235px;">Make Selected Visible</button>

       </td></tr>

	

    </tbody>



</table>

<!--<script type="text/javascript">

//function individual_checkbox(){ 

	var total_checkbox=$("input[name=check]").length ;

	var total_checked_checkbox=$("input[name=check]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox);

	if(total_checkbox!=total_checked_checkbox){ 

		 $('#select_all_category').attr('checked', false);		

	}else if(total_checkbox==total_checked_checkbox){

		 $('#select_all_category').attr('checked', true);		

	}	

//}

</script>-->

