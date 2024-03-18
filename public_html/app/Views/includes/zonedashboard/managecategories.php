<div class="page-wrapper main-area toggled managecategories">
   <div class="container">
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> Manage Categories</h2>
            <hr class="center-diamond">
         <button class="dt-button cus-btn makeselected" type="button"  data-zoneid="<?php echo $zoneid;?>"  ><span>Make Selected Visible</span></button>
         </div>
         <table class="display responsive-table" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col" width="5%"><input type="checkbox" name="check" class="allcheckbox" value=""  ></th>
                  <th scope="col" width="45%">Category Names</th>
                  <th scope="col" width="25%">Status</th>
                  <th scope="col"  width="25%">Action</th>
               </tr>
            </thead>
            <tbody>



              <?php   


              $tot=count($display_categories); 

              $cnt_no=$tot/2;

              $cnt_mod=$tot%2;

              $cnt=0;
 
 
               for($i=0;$i<$tot;$i=$i+1){  


                    if(@$display_categories[$i]==false) continue;?>

                    <?php if($display_categories[$i]['id']!=-1){ 
                                   
                      ?>


                       <tr>
                    <td width="5%">
                      <input type="checkbox" name="check" class="display_checkbox"   data-cat="<?php echo $display_categories[$i]['id'];?>" value="<?php echo $display_categories[$i]['id'];?>">
                    </td>
                  <td width="45%">
                   
                      <a style="color:black;" href="javascript:void();" ><b><?php echo $display_categories[$i]['catname'];?></b></a></td>

                    <td width="15%">
                     <label class="switch">
                       <input type="checkbox"  data-cat="<?php echo $display_categories[$i]['id'];?>"  data-zoneid="<?php echo $zoneid;?>" <? if(strpos(','.$selected_display_categories.',',','.$display_categories[$i]['id'].',')!==false) echo 'checked="checked"'?> >
                       <span class="slider round"></span>
                     </label>
                    </td>

                    <td width="35%">
                     <span class="cus-solid-blue manage catSubID "   data-cat="<?php echo $display_categories[$i]['id'];?>"  data-zoneid="<?php echo $zoneid;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Manage Sub-categories</span>
                  </td>
               </tr>



                   
  

                    <? } ?>

                    <?php /*?><? }?><?php */?>

               

                  <? } ?>



               
              
              



       
            </tbody>

         </table>

         <div class="subcategories_data" >

          <div class="head">
              <a href="#" class="makeallselected cus-solid-blue" >Select All</a>
            <a href="" class="subcatclose cus-solid-prpl">Close</a>
            <input type="hidden" value="" class="categoryID" name="">
          
          </div>
          <div class="subcat_content"></div>
           
         </div>
      </div>
      </div>
</div>
<style type="text/css">
  .subcategories_data{
    display: none;
     position: absolute;
    top: 90px;
    width: 78%;
    background: #fff;
    height: 110vh;}
</style>

 
