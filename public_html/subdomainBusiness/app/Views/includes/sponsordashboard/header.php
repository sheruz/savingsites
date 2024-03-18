
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
  <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML, CSS, JavaScript">
  <meta name="author" content="John Doe">
  <meta name="viewport" content="width=device-width, user-scalable=no">
	<title>Local Advertising | $avings $ites</title>
<link href="<?= base_url(); ?>/assets/SavingsCss/ZonedashboardCommon.css?v=<?= time();?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">


    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
</head>


<header>
	<div class="container">
		<div class="row vertical-align">
			<div class="col-lg-4">

			</div>
			<div class="col-lg-4 align-right">
				<div class="center_head_text ss1">
					<?php if(isset($via) && $via == 'businessdashboard'){
						echo '<h2>Welcome <span>'.$business_owner_details['company'].'</span></h2>';
					}elseif(isset($username) && $username !== ''){
						echo '<h2>Welcome <span>'.$username.'</span></h2>';
					}
					else{
						echo '<h2>Welcome <span>'.$zone_owner->username.'</span></h2>';
					} 
					?>
				</div>
			</div>
			<div class="col-lg-4">
				<input type="hidden" value="<?= $zone_id;?>" class="zone_id" id="zone_id"/>  
				<ul class="head_menu">
					<button onclick="sign_out()"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</button>
					<?php if(!isset($via) && $via != 'businessdashboard'){
						echo '<button><i class="fa fa-undo" aria-hidden="true"></i><a href="'.base_url().'/zone/'.$zone_id.'">Go To Zone Directory</a></button>';
					}?>
				</ul>
			</div>
		</div>

	</div>

</header>

</html>
