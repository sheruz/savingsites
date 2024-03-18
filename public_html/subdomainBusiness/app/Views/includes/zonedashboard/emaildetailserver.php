<div class="page-wrapper main-area toggled create_deal">
  <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2> Blogging Emails </h2>
        <hr class="center-diamond">
      </div>
      <div style="padding: 20px 22px 22px 22px; font-size: 14px;"><p>To streamline your blog posting process and make it more convenient, we implemented an automated system that allows you to create blog posts by simply sending an email. To get started, please follow the instructions below to input your email inbox login information:</p>
        <p>Once you have entered all the required information, click on the “Test Connection” button to validate your settings. Our system will securely store your login details and establish a connection to your email inbox when you click the “Save” button.</p>
        <p>With this automated setup, you can now compose and send blog entries directly from your email account. Simply write your blog post as you would in an email, and our system will convert it into a blog entry, including any attachments or formatting you include.</p>
        <p>Thank you for utilizing our automated blog entry system. We hope this streamlined process enhances your blogging experience and saves you valuable time and effort.</p>
        <p>1.<b> SMTP Server:</b> Specify the Simple Mail Transfer Protocol (SMTP) server of your email provider. This information is necessary for the system to establish a connection and send your blog posts. i.e. smtp.youremailservername.com</p>
        <p>2.<b> Email Address:</b> Enter the email address associated with your blog account. This is where you will send your blog entries to. I.e. mailto:blogpost@youremailservername.com</p>
        <p>3.<b> Password:</b> Provide the password associated with your email inbox login for authentication purposes. Rest assured, your login information will be securely encrypted.</p>
        <p>4.<b> SMTP Port:</b> Enter the port number associated with your email provider's SMTP server. This information helps ensure the proper delivery of your blog entries.<br>For Example- 992, 993</p>
      </div>
    </div>
    
    <form id='formId_change' action=''>
      <div class="row duplicatediv">
        <div class="col-md-6" >
          <label for="lang">Select Activities</label>
          <select name="Select Activities[]" id="lang" class="form-control selAvtivity">
           <option value="Select" name="">Select</option>
           <option value="activities"  name="activities">Activities</option>
           <option value="police"  name="police">Police</option>
           <option value="planning"  name="planning">Planning</option>
           <option value="entertainment"  name="entertainment">Entertainment</option>
          </select>
        </div>

        <div class="col-md-6">
          <label for="lang">Select Orgnization</label>
          <select name="Select Orgnization" id="lang" class="form-control selOrgnization">
            <option value="Select">Select Organizations</option>
             <?php foreach($show_all_org as $k1 => $v1){ 
              if($v1['name']!= ''){ ?>
            <option value="<?php echo $v1['name']; ?>"><?php echo($v1['name']); ?></option>
             <?php }else{  echo "here";?>
             <option value="Organization not Found" name="not Found">Organization not Found</option>
             <?php }
            } ?>
         </select>
         <span>Email: <span class="activity_span">activity</span>.<span class="madfod_span">madfod_span</span>@<span><?php print_r($zonename);?></span>.com</span>
        </div>
      </div><br>
    </form><br>

    <form id='formId' action=''>
      <div class="row duplicatediv">
        <input type="hidden" name="zoneemail" id="zoneemail" value=""/>
        <div class="col-md-2"><input class="form-control" name="hostname[]" type="text" id="hostname" placeholder="Enter Hostname/Mail Server" /></div>
        <div class="col-md-2"><input class="form-control" name="username[]" type="text" id="username" placeholder="Enter Username" /></div>
        <div class="col-md-2"><input class="form-control" name="password[]" type="password" id="password" placeholder="Enter Password" /></div>
        <div class="col-md-2"><input class="form-control" name="port[]" type="number" id="port" placeholder="Enter Port"/></div>
        <div class="col-md-2"><button class="btn btn-info chekmailconnection">Test Connection </button></div>
        <div class="col-md-1"><button class="btn btn-info addnewrow showAftest" style="display: none;">Add Row</button></div>
        <div class="col-md-1"><input class="form-control btn btn-success showAftest" style="display:none" type="submit" id="emailserversave" value="Save" /></div>
      </div><br>
    </form>

      <div class="top-title">
        <h2> Show in Table</h2>
      </div>
      <div class="row">
         <div class="col-md-12">
           <table class="table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Host</th>
                  <th scope="col">User</th>
                  <th scope="col">Passward</th>
                  <th scope="col">Port</th>
                  <!-- <th scope="col">Zone</th> // <td>'.$v['zone'].'</td>-->
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($purchasedealArr as $k => $v) { 
              echo '<tr>
                <td>'.$v['id'].'</td>
                <td>'.$v['host'].'</td>
                <td>'.$v['user'].'</td>
                <td>'.$v['pass'].'</td>
                <td>'.$v['port'].'</td>
                <td>
                  <i host="'.$v['host'].'" user="'.$v['user'].'" pass="'.$v['pass'].'" port="'.$v['port'].'" zone="'.$v['zone'].'" ids="'.$v['id'].'" class="fas fa-edit" id="updatemailblog" style="font-size: 30px;"></i>
                  <i delid="'.$v['id'].'" class="fa fa-trash" id="deleteconf" style="font-size: 33px;" aria-hidden="true" ></i>
                </td>
              </tr>';
             } ?>
              </tbody>
          </table>
        </div>
   </div>
  </div>
</div>

