<table width="85%" class="pretty" style="margin-bottom:0;">

    <thead>

    <tr><div class="container_tab_header form-group" style="  color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;"><button onclick="main_category();">Back to Main Category Names </button></div></tr>

	

   <?php /*?> <tr><div style="margin:18px 0 0; background:#333333; color:#fff; padding:10px; font-weight:bold;"><button onclick="main_category();">Back to Main Category Names </button></div></tr><?php */?>

    

    <tr>

        <th style="width:900px;">Sub-categories of <?php /*?><a href="javascript:void();" style="color:white;" onclick="edit_category(<?php echo $zoneid;?>);"><?php */?><span style="text-decoration:underline;"><?php echo $category_name[0]['name'];?></span></th>

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

		foreach ($all_subcategories as $type) {

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

                    <?php /*?><?php for($i=0;$i<$cnt;$i=$i+1){?><?php */ ?>

                    <?php foreach($all_subcategories as $key=>$val){?>

                    <?php if($key=='-100'){ ?>

                    <?php foreach($val as $item_name=>$item_details){?>

                    <?php if($item_name=='name'){?>

                    <?php } else { ?>                   

						

                    	<tr>

                        	<td>

                            	<input type="checkbox" name="check" class="display_checkbox" disabled="disabled"/><?php echo $item_details['name'];?>

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

                        <?php if($item_name=='name'){ ?>

                        

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

                    	<?php } else { ?> 

                    	<tr>
                        	<td>
                            	<input type="checkbox" name="check" class="display_checkbox" disabled="disabled"/><?php echo $item_details['name'];?>
                        	</td> 
                        </tr>

                        <?php if($i % $cnt == 0){

						?>

                        </table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">

						<?php

						}						

						?>

                        <?php $i++; ?>

                        <?php } ?>

                        <?php } ?>

                        <?php } ?>

                        <?php } ?>

                       

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



		<tr><td colspan="2"><button onclick="save_display_sub_category(<?php echo $catid;?>,<?php echo $zoneid;?>);" style="margin-left:235px;" disabled="disabled">Make Selected Visible</button>

		

       </td></tr>

	

    </tbody>



</table>

