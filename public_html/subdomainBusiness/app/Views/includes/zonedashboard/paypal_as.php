<div class="page-wrapper main-area toggled paypalaccsetting">
	<div class="container">
    <div class="row">
      <div class="col-md-12" style="padding-bottom: 20px;">
        <h2>Paypal Account Setting</h2>
          <hr class="center-diamond">
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-12 col-lg-8 box-paypal">
        <div class="row">
          <div class="col-md-6">
            <img src="https://cdn.savingssites.com/paypal.jpg">
          </div>
          <div class="col-md-6">
            <form class="form-horizontal1 cus-paypal">
              <div class="form-group center-block-table text_area_to_save_code">
                <p class="form-group-row">
                  <label for="comment" class="fleft w_200">Paypal Account:<?//=$zone_id?></label>
                  <input type="text" id="paypal_url" name="paypal_url" class="w_536" value="<?=(!empty($get_paypal_info['paypal_url']) ? $get_paypal_info['paypal_url'] : '')?>" placeholder="Please Provide your PayPal Acount Email Address">
                </p>
              </div>
              
              <div class="form-group center-block-table  ">
                <p class="form-group-row">
                  <label for="comment" class="fleft w_200">Braintree Merchant ID:</label>
                  <input type="text" id="braintree_merchantid" name="braintree_merchantid" class="w_536" value="<?=(!empty($get_paypal_info['paypal_url']) ? $get_paypal_info['braintree_merchantid'] : '')?>" placeholder="Please Provide your Braintree Acount Merchant ID">
                </p>
              </div>

              <div class="form-group center-block-table  ">
                <p class="form-group-row">
                  <label for="comment" class="fleft w_200">Braintree Public Key:</label>
                  <input type="text" id="braintree_public_key" name="braintree_public_key" class="w_536" value="<?=(!empty($get_paypal_info['braintree_public_key']) ? $get_paypal_info['braintree_public_key'] : '')?>" placeholder="Please Provide your Braintree Acount Public Key">
                </p>
              </div>

              <div class="form-group center-block-table  ">
                <p class="form-group-row">
                  <label for="comment" class="fleft w_200">Braintree Private Key:</label>
                  <input type="text" id="braintree_private_key" name="braintree_private_key" class="w_536" value="<?=(!empty($get_paypal_info['braintree_private_key']) ? $get_paypal_info['braintree_private_key'] : '')?>" placeholder="Please Provide your Braintree Acount Private Key">
                </p>
              </div>

              <div class=" col-md-12">
                <button id="submit_code_button" class="">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>