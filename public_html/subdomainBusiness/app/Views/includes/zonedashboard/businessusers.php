<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Business Username/Password</h2>
            <hr class="center-diamond">
            <p>The username created by all business are listed below:</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Business Id</th>
                  <th scope="col">Business  Name</th>
                  <th scope="col">User Id</th>
                  <th scope="col">Username</th>
                  <th scope="col">Password</th>
               </tr>
            </thead>
            <tbody>
              <?php foreach ($userpassArr as $k => $v) {
                echo '<tr><td>'.$v['id'].'</td>
                        <td>'.$v['name'].'</td>
                        <td>'.$v['userid'].'</td>
                        <td>'.$v['username'].'</td>
                        <td>'.$v['uploaded_business_password'].'</td>
                    </tr>'; 
                } 
              ?>
            </tbody>
         </table>
      </div>
    </div>



<script type="text/javascript">
   // $(document).ready(function(){
   
   
   // setTimeout(function(){
    
   // var table = $('#example2').DataTable({ 
   //         select: false,
   //         "columnDefs": [{
   //             className: "Name", 
   //             "targets":[0],
   //             "visible": true,
   //             "searchable":false
   //         }]
   //     });}, 200);
    
   // });



</script>