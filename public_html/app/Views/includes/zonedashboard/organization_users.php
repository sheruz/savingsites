<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Organization Username/Password</h2>
            <hr class="center-diamond">
            <p>The username created by all Organization are listed below:</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Organization Id</th>
                  <th scope="col">Organization  Name</th>
                  <th scope="col">User Id</th>
                  <th scope="col">Username</th>
                  <th scope="col">User Email</th>
                  <th scope="col">Password</th>
               </tr>
            </thead>
            <tbody>
              <?php foreach ($savedorganization as $k => $v) {
               if($v->uploaded_organization_password == ''){
                  continue;
               }
                echo '<tr><td>'.$v->orgid.'</td>
                        <td>'.$v->orgname.'</td>
                        <td>'.$v->userid.'</td>
                        <td>'.$v->username.'</td>
                        <td>'.$v->email.'</td>
                        <td>'.$v->uploaded_organization_password.'</td>
                    </tr>'; 
                } 
              ?>
            </tbody>
         </table>
      </div>
    </div>