<?php if($payment_details_insertation){ ?>
			 <div id="stage" class="form-all"><p style="text-align: center;"><img src="https://cdn.jotfor.ms/img/check-icon.png" alt="" width="128" height="128"></p>
			<div style="text-align: center;">
			<h1 style="text-align: center;">Thank You!</h1>
			<p style="text-align: center;">Your payment has been received.</p>
			<p style="text-align: center;"><span style="font-size: 10pt;">Your Submission ID:</span><?php echo $submission_id; ?></p>
			<p style="text-align: center;"><span>Amount :</span><?php echo $amount; ?></p>
			<div id="footer" class="form-footer">
			    <a href="<?= $pageurl; ?>">Go to Dashboard</a>
			    </div>
			</div></div>
		<?php
		 } else { ?>
			<div id="stage" class="form-all"><p style="text-align: center;"><span class="glyphicon glyphicon-warning-sign" style="color: chocolate;font-size: 20px;"></span></p>
			<div style="text-align: center;">
			<h1 style="text-align: center;">Payment Error</h1>
			<p style="text-align: center;">Payment was unsuccessful</p>
			</div>
			<div id="footer" class="form-footer">
			    <a href="<?php echo base_url()?>">Visit Website</a>
			    </div>
			</div>

	<?php
  	}	
  	?>