<div class="page-wrapper main-area toggled emailformatpage">
	<div class="container">
		<div class="row">
	    	<div class="top-title">
        		<h2> Email Format</h2>
        		<hr class="center-diamond">
      		</div>
		</div>
		<div class="row">
			<div class="container_tab_header"> AWS SES SMTP Details</div>
			<div id="container_tab_content" class="container_tab_content">     
            	<input type="hidden"  class="zoneid" name="" value="<?php  echo $zoneid; ?>">
    			<div class="keysform">
        			<p class="form-group-row">
                		<label for="username" class="fleft w_100 m_top_0i cus-user">Email : <b> <input type="text" name="email" value="<?php echo @$keyaws['email'] ?>"></b></label>
                	</p>
			    	<p class="form-group-row">
                		<label for="username" class="fleft w_100 m_top_0i cus-user">Username : <b> <input type="text" name="username" value="<?php echo @$keyaws['username'] ?>"></b></label>
                	</p>
			    	<p class="form-group-row">
			    		<label for="username" class="fleft w_100 m_top_0i cus-user">Password : <b> <input type="password" name="passowrd" value="<?php echo @$keyaws['password'] ?>"></b></label>
			     	</p>
			    	<p class="form-group-row">
			    		<label for="username" class="fleft w_100 m_top_0i cus-user">Region : <b> <input type="text" name="region" value="<?php echo @$keyaws['region'] ?>"></b></label>
			    	</p>
               		<input type="button" name="buttonsubmit" class="buttonsubmit btn" value="Submit" class="cus-btn">
               </div>
            </div>

            <div class="container_tab_header"> Deals Emails Format</div>
            <div id="container_tab_content" class="container_tab_content">        
            	<div id="tabs-1">
            		<?php 
            		if(count($EmailformatingSaved) > 0){
            			$EmailformatingSaved = json_decode($EmailformatingSaved['emailformat']); 
            		}
              			function search($items, $id, $key = null) {
				  			foreach( $items as $item ) {
				    			if( $item->value == $id ) {
				      				$key =  $item ;
				      				return $item;
				      				break;
				    			}
				  			}
				  			return null;
				  		}

				  		function searchposition($items, $id, $key = null) {
				  			foreach( $items as $item ) {			 
				    			if($item->position == $id ) {
				      				$key =  $item ;
				      				return $item;
				      				break;
				    			}
				  			}
				  			return null;
						}
						$item = search($EmailformatingSaved, 'Snap', 'value');
					?>
					<br/>
					<div id="container">
				    	<div id="boxA" class="box">
				        	<div id="A1" data-position='1' class="slot1 slot ">
				            	<?php if(@$EmailformatingSaved){
				                  		$first = searchposition(@$EmailformatingSaved, '1', 'position'); 
				                 		if(@$first){
				                    		if(@$first->value !='business'){  ?>
				                    			<div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
				                    		<?php  }else if(@$first->value =='business'){  ?>
				                       			<div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item  activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
				                   			<?php  } 
				                   		}
				                   	} 
				                ?>
				        	</div>
				        	<div id="A2"  data-position='2' class="slot1 slot">
				           		<?php if(@$EmailformatingSaved){
				                 	$first = searchposition(@$EmailformatingSaved, '2', 'position'); 
				               		if(@$first){
				                 		if(@$first->value !='business'){  ?>
				                  			<div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
				                  		<?php  }else if(@$first->value =='business'){  ?>
				                     		<div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
				                 		<?php  }  
				                 	}
				              		} 
				              	?>
				          	</div>
				        	<div id="A3" data-position='3' class="slot1 slot">
				          		<?php if(@$EmailformatingSaved){
				                	$first = searchposition(@$EmailformatingSaved, '3', 'position'); 
				               		if(@$first){
				                  		if(@$first->value !='business'){  ?>
				                  			<div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
				                  		<?php  } else if(@$first->value =='business'){  ?>
				                     		<div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
				                 		<?php  } 
				               		} 
				              	} ?>
				        	</div>
				        	<div id="A4" data-position='4' class="slot1 slot">
				            	<?php if(@$EmailformatingSaved){
				                 	$first = searchposition(@$EmailformatingSaved, '4', 'position'); 
				               		if(@$first){
				                		if(@$first->value !='business'){  ?>
				                  			<div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
				                  		<?php  } else if(@$first->value =='business'){  ?>
				                     		<div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
				                 		<?php  }  }
				              	} ?>
				        	</div>
				        	<div id="A5" data-position='5' class="slot1 slot">
				            	<?php if(@$EmailformatingSaved){
				                  	$first = searchposition(@$EmailformatingSaved, '5', 'position'); 
				               		if(@$first){
				               			if(@$first->value !='business'){  ?>
				                  			<div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
				                  		<?php  } else if(@$first->value =='business'){  ?>
				                     		<div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
				                 		<?php  }  }
				              	} ?>
				        	</div>
				          	<div id="A6" data-position='6' class="slot1 slot ">       
				               <?php $first = searchposition(@$EmailformatingSaved, '6', 'position');   
				 					if(@$first->value =='content'){ 
				 						$val1 = @$first->dataValue;
				                    }     ?>
				                  	<div id="b6"  data-id='content'  class="  activeProp"> 
				                    	<textarea style="width: 100%;font-weight: 100;" placeholder="Enter the Description"><?php echo @$val1; ?></textarea> 
				                  	</div> 
				            </div>
				            <br/>
				        	<input type="button" name="submitformat" value="Submit" class="cus-btn">
				        </div>
				   	<div id="B5" class="slot21 slot"> 
						<div id="container">
				  			<div class="row">  
				      			<input  class="sendemail cus-btn" type="button" name="" value="Send Email"> 
				  			</div>
						</div>
					</div>
					<div id="boxB" class="box">
				        <h3  style="font-weight: 800;margin-bottom: 24px;">FILTERS</h3>
				        <div id="B1" class="slot2 slot" data-text="Enter text here">      
	                 		<?php $Favourit = search(@$EmailformatingSaved, 'Favourities', 'value');  
	                     		if(!@$Favourit){    ?>    
	                  		<div id="b2"  data-id='Favourities'  class="item activeProp">Favourities List</div>       
	                  	<?php } ?>  
	                	</div>             
	                	<div id="B2" class="slot2 slot">
	                   		<?php $Snap = search(@$EmailformatingSaved, 'Snap', 'value');  
	                     		if(!@$Snap){    ?> 
	                  				<div id="b2" data-id='Snap'  class="item activeProp">Snap List</div>
	                   		<?php } ?>  
	              		</div>
	              		<div id="B3" class="slot2 slot">
	                 		<?php $Ranked = search(@$EmailformatingSaved, 'Ranked', 'value');  
	                     		if(!@$Ranked){    ?> 
	                				<div id="b2" data-id='Ranked'  class="item activeProp">Ranked</div><?php } ?>  
	              		</div>
	           			<div id="B5" class="slot2 slot"> 
	             			<input type="text" name="" placeholder ="Search Business Name" class="searchResult">
	            			<div class="searchresult"></div>            
	            		</div>
	            	</div>
				</div> 
	        </div>
	    </div>
	</div>
   </div>
</div>
 