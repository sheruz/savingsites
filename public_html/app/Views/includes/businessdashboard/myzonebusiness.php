<div class="page-wrapper main-area toggled myzonebusinesses">
	<div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2> My Zone Businesses </h2>
        <hr class="center-diamond">
      </div>
      <div class="container_filter bv_trial_biz" id="trial_biz">
        <div align="" class="bus_search_tbntc_active">
          <select class="selectoption" id="catoption">
            <option value="name">Name</option>
            <option value="category">Category</option>
            <option value="subcategory">SubCategories</option>
          </select>
          <input type="text" id="text_bus_search" name="text_bus_search" placeholder="Search Name ..." style="width: 260px; display: none;">
          <select class="categorylist" style="display: inline-block;" id="selectcatsubcat">
            <option value="0">Select Category</option>
            <option value="2">Auto Buy/Srvc</option>
            <option value="3">B 2 B</option>
            <option value="4">Clothing</option>
            <option value="6">Contractors</option>
            <option value="7">Education</option>
            <option value="8">Events</option>
            <option value="11">Financial</option>
            <option value="9">Health</option>
            <option value="10">Home &amp; You</option>
            <option value="12">Medical</option>
            <option value="1">Restaurants</option>
            <option value="13">Travel &amp; Lodging</option>
          </select>

          <button class="btn-sm  btn_bus_search_by_names" type="button" id="searcatsubcats">Search</button>

          <select name="bus_search_results" id="bus_search_results" style="width: 100px;">
            <option value="contains">Contains</option>
            <option value="startwith">Starts With </option>             
          </select>
          
          <select name="bus_search_by_alphabet" id="bus_search_by_alphabet">
            <option value="-1">By Alphabetical Order</option>
            <option value="all">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option> 
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="R">R</option>
            <option value="S">S</option>
            <option value="T">T</option>
            <option value="U">U</option> 
            <option value="V">V</option>
            <option value="W">W</option>
            <option value="X">X</option>
            <option value="Y">Y</option>
            <option value="Z">Z</option>               
          </select>
          <button class="btn-sm businesscheck" id="search_business" type="button" style="">Search</button>
        </div>
        
        <div class="bus_search_tbntc_deactive" style="display:none;">
          <input type="text" id="text_bus_search_tbntc_deactive" name="text_bus_search_tbntc_deactive" placeholder="Direct search by business name, phone " style="width:260px;">
          <button class="btn-sm" id="btn_bus_search_by_name_tbntc_deactive" type="button">Search</button>
          <strong>Search Your Businesses </strong>
          <select name="select_bus_search_tbntc_deactive" id="select_bus_search_tbntc_deactive">
            <option value="-1">By Alphabetical Order</option>
            <option value="all">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option> 
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="R">R</option>
            <option value="S">S</option>
            <option value="T">T</option>
            <option value="U">U</option> 
            <option value="V">V</option>
            <option value="W">W</option>
            <option value="X">X</option>
            <option value="Y">Y</option>
            <option value="Z">Z</option>               
          </select>
          <button class="btn-sm" id="btn_bus_search_by_alphabet_tbntc_deactive" type="button">Search</button>
        </div>
      </div>
    </div>
		
    <div class="row" style="position: relative;">
      <!-- <button class="down_data">Download Data</button> -->
      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="myzonebusinesstable">
        <thead>
          <tr>
            <th scope="col">Business Id</th>
            <th scope="col">Business Name</th>
            <th scope="col">Contact Name</th>
            <th scope="col">Telephone</th>
            <th scope="col" style="width: 15%;">Zip Code</th>
            <th scope="col" style="width: 20%;">Action</th>
            <!-- <th scope="col">Select/Deselect All <input type="checkbox"></th> -->
          </tr>
        </thead>
        <tbody id="myzonebusinesdata">
          <?php foreach ($businessArr as $bk => $bv) { ?>
            <tr>
            <th><?= $bv->id; ?></th>
            <td><?= $bv->name; ?></td>
            <td><?= $bv->contactfirstname.' '.$bv->contactlastname; ?></td>
            <td><?= $bv->phone; ?></td>
            <td><?= $bv->zip_code; ?></td>
            <td><a href="javascript:void(0)" class="tab_icon green" target="_blank"><b> AD</b></a>
                <a href="javascript:void(0)" class="tab_icon" ><i class="fa fa-id-card" aria-hidden="true"></i></a> 
                <a href="javascript:void(0)" class="tab_icon red"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
            <!-- <td><input type="checkbox"></td> -->
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
 
// setTimeout(function(){
 
// var table = $('#myzonebusinesstable').DataTable({ 
//         select: false,
//         "columnDefs": [{
//             className: "Name", 
//             "targets":[0],
//             "visible": false,
//             "searchable":false
//         }]
//     });}, 200);
 
// });

</script>