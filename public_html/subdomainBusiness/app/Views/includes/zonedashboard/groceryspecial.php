<div class="page-wrapper main-area toggled myzonebusinesses">
  <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2>Grocery Special</h2>
        		<p>Grocery Special link defined this page</p>
        		<hr class="center-diamond">
      </div>
     
    </div>
    <div class="row" style="position: relative;">
      <!-- <button class="down_data">Download Data</button> -->
      <!-- <i class="fa fa-trash deleteurlgrocerylink"></i> -->
      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="myzonebusinesstable">
        <thead>
          <tr>
          	<th scope="col">Store</th>
            <th scope="col">Address</th>
            <th scope="col">Phone</th>
            <th scope="col">Grocery Special</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody> 
        <?php 
           	if(count($businessArr) > 0){
            	foreach ($businessArr as $k => $v1) {
            		if($ret = parse_url($v1['website']) ) {
            			if(!isset($ret["scheme"])){ 
            				$url = "http://{$v1['website']}";
            			}else{
            				$url = $v1['website'];
            			}
          			}
            		echo '<tr><td><input type="hidden" value="'.$v1['id'].'" class="storeid"/>'.$v1['company_name'].'</td><td>'.$v1['address'].','.$v1['city'].','.$v1['zip'].'</td><td>'.$v1['phone'].'</td><td><input type="text" value="'.$url.'" class="updatedlink hide"/><span class="editurlshow">'.$url.'</span></td><td><i class="fa fa-edit gotoediturl"></i><button class="btn btn-info editurlgrocerylink hide">Update</button></td></tr>';
            	}
            }
        ?> 
    	</tbody>
      </table>
    </div>
   

    </div>
  </div>