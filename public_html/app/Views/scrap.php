<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<div class="scrap_login">
   	<div class="wrapper">
    	<h2>Log In</h2>
       	<div class="form-group">
        	<p style="color: red"><?php echo @$invalid_error; ?></p>
            <label>Username<span style="color: red;">*</span></label>
            <input type="text" id="scrapusername" name="username" class="form-control">
        </div>    
        <div class="form-group">
           	<label>Password<span style="color: red;">*</span></label>
            <input type="password" id="scrappassword" name="password" class="form-control">
        </div>           
        <div class="form-group">
            <input type="button" id="checkuserpassscrap" class="btn btn-primary" value="Submit">    
        </div>
    </div> 
</div>   

<?=$this->endSection()?>