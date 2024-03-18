<?php  $useragent=$_SERVER['HTTP_USER_AGENT'];  
  function checkExternalFile($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $retCode;
  }?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css">
<section class="topslider">
    <div class="container">
        <div class="row sec-1">
            <div class="col-md-12">
                <h1 class="h1favorite">Save by Giving!</h1>
                <h1 class="h1benefits"><span>Give by Saving!</span></h1>
                <p class="headerp mobileshow">Save money & support<br> your favorite nonprofit,<br> by using digital deals<br> donated by businesses!</p>
                <p class="headerp desktopshow">Save money & support your favorite nonprofit, by using digital deals donated by businesses!</p>
            </div>
        </div>  
    </div>
</section>
<section class="topslider">
    <div class="container">
        <div class="row sec-1">
            <div class="row topicons">
                <div class="col-md-4">
                    <div class="boxex setheight">
                        <span class="top_icon"><img src="https://cdn.savingssites.com/Circled1.png"></span>
                        <b>Save by Giving! Give by Saving!</b>
                        <p>Deal Example: Pay business only $30 for $60 value! To access that $30 discount, and support your favorite nonprofit, you only pay a small part of the $30 discount now.</p>
                        <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img vtype="1" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="boxex">
                        <span class="top_icon"><img src="https://cdn.savingssites.com/Circled2.png"></span>
                        <b>Free $5 Extra for 1st Use!</b>
                        <p>Every business has a FREE $5 button for 1st time use of its deal! Click as many businesses Free $5 buttons as you like to save an extra $5 for each!</p>
                        <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="2" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="boxex">
                    <span class="top_icon"><img src="https://cdn.savingssites.com/Circled3.png"></span>
                    <b>Activities, Events, and More!</b>
                    <p>Freely search for fun activities and events. Hosted by municipalities, schools, nonprofits and businesses!</p>
                    <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="3" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="services_new fd" id="servics">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-md-4 left_col_list">
                <ul class="lisit">
                    <li>Huge deals from thousands of local businesses!</li>
                    <li>Timely and Targeted Info and Events!</li>
                    <li>Short Notice Alert Program (SNAP) Emails!</li>
                    <li>Digital Deals on Phone! No Cutting Coupons!</li>
                    <li>Save Favorites for Quick Access to Deals!</li>
                    <img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal">
                </ul>
            </div>
            <div class="col-12 col-lg-4 col-md-4 bv_pixel">
                <img src="https://cdn.savingssites.com/pexels-mati.png">
            </div>
        </div>
    </div>
</section>
<section class="support_new" id="support">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 col-md-4 bv_suupport">
                <img src="https://cdn.savingssites.com/zone_image2.png">
            </div>
            <div class="col-12 col-lg-8 col-md-4 left_col_list">
                <ul class="blue_lisit">
                    <li>You Support Your Favorite Nonprofit!</li>
                    <li>Your Email is protected from Municipal disclosure laws!</li>
                    <li>Free Municipal Phone Alerts by Amazon Alexa!</li>
                    <li>Food Order Phone Line Powered by Amazon Coming Soon!</li>
                    <li>You’re Rewarded to Refer businesses and residents!</li>
                    <img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal">
                </ul>
            </div>
        </div>
    </div>
</section>



<section id="snapsection" class="snapsection">
    <div class="row protect_new slidernewadd2" id="snpheaders">
        <div class="col-md-12 text-center helpCntnt"><h2 style="font-size: 50px;font-weight: bold; background: #000; color: #fff;">Short Notice Alert Program (SNAP)</h2></div>
    </div>
    <div class="container aos-init aos-animate" data-aos="fade-up">
    <div class="row shortfirst1">
        <div class="col-md-12">
            <p class="centershortfirst"><b>SNAP DOLLARS</b></p>
        </div>
    </div>


    <div class="row shortfirst">
        <div class="col-md-6 toppad">       
            <p>Deals can be used at any time, with no expiration!</p>
            <p><strong>Added Benefits:</strong> You get extra SNAP Dollars when you use a deal during slow times of your selected businesses.</p>
            <p>Only if all your SNAP deal requirement filters are met, will we send you businesses SNAP notices. See 4 menu tabs and video.</p>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li><a class="nav-link active" data-bs-toggle="pill" href="#tab1" aria-selected="true" role="tab">SNAP Filters</a></li>
                <li><a class="nav-link" data-bs-toggle="pill" href="#tab2" aria-selected="false" tabindex="-1" role="tab">SNAP Claims</a></li>                   
                <li><a class="nav-link" data-bs-toggle="pill" href="#tab4" aria-selected="false" tabindex="-1" role="tab">SNAP List</a></li>
            </ul>        
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                    <p>Choose which businesses you want Savings Sites to send SNAP time Alerts.</p>
                
                        <div class="snapoff row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3 rightsnap">
                                <img src="https://cdn.savingssites.com/snap-off.png"/><br><span class="snaptext">SNAP OFF</span>
                            </div>
                            <div class="col-md-3">
                                <img src="https://cdn.savingssites.com/snap-on.png"/><br><span class="snaptext">SNAP ON</span>
                            </div>
                            <div class="col-md-3"></div>
                    </div>
                    <p>Set the minimum discount percentage you’ll accept!<br>
                    Set the days of the week and the times of the day you can use the deal!<br>
                    Each business can have different SNAP filters!</p>
                </div>
                <div class="tab-pane fade show" id="tab2" role="tabpanel">
                    <p>Businesses will have a limited number of SNAP time slots. The SNAP notice contains a link to claim the businesses SNAP time slot. You’ll receive feedback on whether or not you were successful in claiming the SNAP time slot.</p>
                    <p>There is no requirement that you already have purchased a deal to get SNAP alerts. However, since SNAP time slots are claimed on a first come first served basis, those who are holding a non-expiring deal can obviously act much faster to claim SNAP time slots. So, if you want the extra SNAP dollars, we suggest you buy a deal ahead of time!</p>
                </div>    
                <div class="tab-pane fade show" id="tab4" role="tabpanel">
                    <p>When we email important government information, we also include a list of deals from 20 businesses.</p>
                    <p>The businesses included are based upon your SNAP list!  </p>
                </div>
            </div>  
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive text-center">
                <table class="table table-striped">
                    <thead style="background: var(--bs-link-color);">
                        <tr class="snapdollarlistcnt">
                            <th scope="col" style="background: #0ea2bd;color: var(--bs-gray-100);">Deal Value</th>
                            <th scope="col" style="background: #0ea2bd;color: var(--bs-gray-100);">Price paid business<br>when deal is used</th>
                            <th scope="col" style="background: #0ea2bd;color: var(--bs-gray-100);">Snap Dollars added to your account</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(count($deal_cert_Arr) > 0){
                                foreach ($deal_cert_Arr as $k => $v) {
                                    echo ' <tr>
                                        <td class="fw-bolder" data-label="Attributes" scope="row">$'.$v->dealRedemption.'</td>
                                        <td class="fw-bolder" data-label="Base Class">$'.$v->discountedPrice.'</td>
                                        <td class="fw-bolder" data-label="Simulated Case">$'.$v->short_notice.'</td>
                                    </tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">  
            <video style='width: 100%;' controls>
                <source src="https://cdn.savingssites.com/business_solo.mp4" type="video/mp4">
            </video>
            <div class="text-center"><h3>SNAP Benefits Residents</h3></div>
         </div>
    </div>

    <div class="row">
        <div class="col-md-6 snaplaunch dasktopview order-md-1 text-center" id="column1">
            <div class="about-img"><img src="https://cdn.savingssites.com/ss-snap-launch.svg"></div>
        </div>
        <div class="col-md-6 order-md-2" id="column2">
            <!-- <video style='width: 100%;' controls>
                <source src="https://cdn.savingssites.com/business_solo.mp4" type="video/mp4">
            </video> -->
            <img style="width: 100%;" src="https://cdn.savingssites.com/snapbusinesscomingsoon.jpg"/>
            <h3 class="text-center">SNAP Benefits Businesses</h3>
            <img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal1">
        </div>
    </div>

</section>



<section id="grocerysection" class="grocerystore snapsection">
    <div class="row protect_new slidernewadd2" id="snpheaders">
        <div class="col-md-12 text-center helpCntnt"><h2 style="font-size: 50px;font-weight: bold; background: #000; color: #fff;">Grocery Store Specials</h2></div>
    </div>
    <div class="container">
        <div class="row">
     <div class="col-md-6"><img src="/assets/home/directory/images/grocery.png"></div>
            <div class="col-md-6">
                <h2 class="text-center">Grocery Specials!</h2>
                <h3>See daily, weekly, monthly specials from local grocery stores:<button type="button" class="btn btn-primary text-capitalize"><a href="groceryStore" id="sinupchecks" style="color: white;" target="_blank">Grocery Stores</a></button> </h3> 
            </div>
        </div>
    </div>
</section>


<section class="slider active" id="ss-slider">
  <div class="outer">
    <div class="sizer">
      <div class="inner">
        <div id="layerslider_502" class="ls-wp-container fitvidsignore" style="width:1500px;height:100vh;margin:0 auto;margin-bottom: 0px;">
          <div class="ls-slide" data-ls="bgsize:cover;bgcolor:ffffff;duration:100;transition2d:2;transitionduration:1000;kenburnsscale:1.2;parallaxaxis:x;parallaxdurationmove:500;">
            <img width="1920" height="1080" src="https://cdn.savingssites.com/sky.png" class="ls-bg" alt="" sizes="100vw" />

            <img width="7680" height="1440" src="<?php echo base_url(); ?>https://cdn.savingssites.com/clouds-back.png" class="ls-l" alt="" sizes="100vw" style="top:70%;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:60000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:5;parallaxaxis:y;">
            
            <img width="7680" height="1440" src="<?php echo base_url(); ?>https://cdn.savingssites.com/clouds-middle.png" class="ls-l" alt="" sizes="100vw" style="top:70&amp;;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:35000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:10;parallaxaxis:y;">
            
            <img width="7680" height="1440" src="https://cdn.savingssites.com/clouds-front.png" class="ls-l" alt="" sizes="100vw" style="top:80&amp;;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:15000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:15;parallaxaxis:y;">
            <p  style="white-space:normal;left:66%;text-align:left;font-weight:600;font-size:42px;color:#fff;font-family:Oswald;top:32%;letter-spacing:0.3px;" class="ls-l home_desc_first" data-ls="offsetyin:top;durationin:1500;delayin:2000;easingin:easeOutExpo;fadein:false;rotatein:-120;scalexin:1.0;scaleyin:1.0;transitionout:false;position:fixed;">Government Alerts!
            </p>
            <p  style="white-space:normal;left:66%;text-align:left;font-weight:600;font-size:28px;color:#fff;font-family:Oswald;top:48%;letter-spacing:0.3px;text-align: center;" class="ls-l home_desc_sec" data-ls="offsetyin:top;durationin:1500;delayin:3000;easingin:easeOutExpo;fadein:false;rotatein:-120;scalexin:1.0;scaleyin:1.0;transitionout:false;position:fixed;">We protect governments from<br>laws that force disclosure<br>of your email address!
            </p>
            
            <img width="279" height="500" src="https://cdn.savingssites.com/police-1.png" class="ls-l" alt="" sizes="100vw" style="top:100%;left:40%;" data-ls="offsetxin:-1180;delayin:1000;position:fixed;">
            
            <img width="214" height="462" src="https://cdn.savingssites.com/police-2.png" class="ls-l" alt="" sizes="100vw" style="top:100%;left:21%;" data-ls="offsetxin:1180;delayin:1000;position:fixed;">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="protect_new text-center slidernewadd1">
    <div class="container" style="max-width: 75%;">
        <div class="row">
            <div class="col-md-2">
                <img class="partner_logo" style="width: 165px;" src="https://cdn.savingssites.com/microsoft-partner-new.png" />
            </div>
            <div class="col-md-8"><h2 style="font-size: 60px;font-weight: bold;">Government & Residents Benefit</h2></div>
            <div class="col-md-2">
                <img  style="width: 165px;" src="https://cdn.savingssites.com/right-logo-alexa.png" />
            </div>
        </div>
    </div>
</section>
<section class="protect_new text-center" id="protect" style="background-image: url(https://cdn.savingssites.com/slider-1.jpg);background-repeat: no-repeat;position: relative;background-size: cover;">
    <div class="container">
        <div class="row" style="width: 46%;background: #fff;padding: 15px;border-radius: 20px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;background: #fff;color: #000;">
                <p>• We protect residents email addresses & cell phone numbers from disclosure laws that force governments to surrender resident’s data!
                </p>
                <p>• Municipal, county, and state government communications are substantially improved! We have already collected opted-in email addresses from over 90% of every home and business and data is never sold!</p>
                <p>• Highly Targeted Info! Example: Recreation Director can email parents of 5th and 6th grade boys, who are interested in soccer.</p>
                <p>• Free for governments and residents! Free because resident’s signup to get government content, which also shows them deals to support nonprofits! Win-Win!</p>
                <p>• Alexa phone alerts coming. At no cost, governments can broadcast a million messages per second, in 18 languages, to residents free Alexa phone apps!</p>
            </div>  
        </div>
      <img src="https://cdn.savingssites.com/slide-img1.png" alt="" style="float: right;position: absolute;bottom: 0;">
        </div>
    </div>
</section>
<section class="protect_new text-center slidernewadd2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 helpCntnt"><h2 style="font-size: 50px;font-weight: bold;">Help Us Help You!</h2></div>
            
        </div>
    </div>
</section>
<section class="text-center" id="protect1" style="background-image: url(https://cdn.savingssites.com/slider-2.jpg);background-repeat: no-repeat;position: relative;background-size: cover;">
    <div class="container-fluid">
        <div class="row toprow" style="padding-top: 300px;">
            <div class="col-md-5" style="margin-top: -35px;">
                <img src="https://cdn.savingssites.com/slide-img2.png" alt="">
            </div>
            <div class="col-md-7">
                <div class="wow fadeInRight" data-wow-duration="2s" data-wow-delay="0s">
                                <h1 class="em-slider-sub-title" style="position: relative; text-align:left;    font-size: 60px;
    font-weight: 700;color:#fff;">Easy Decision!</h1>
                            </div>
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Free! No Taxpayer Money used!</p>
                            </div> 
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Residents Emails & Data Protected!</p>
                            </div> 
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Huge Upgrade in Communications</p>
                            </div> 
                            <div class="row" style="padding: 15px;border-radius: 20px;margin-top: 5px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;color: #000;">
                <h3 style="text-align: center;font-size: 25px;padding: 25px 0px;background: #fff;width: 85%;border-radius: 10px;">Our Letter to Municipal & County Staff:<a  target="_blank" href="<?= base_url(); ?>/gov_email_template"><u>here</u></a>
                </h3>
            </div>  
        </div> <div class="row" style="padding: 15px;border-radius: 20px;margin-top: 5px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;color: #000;">
                <h3 style="text-align: center;font-size: 25px;padding: 25px 0px;background: #fff;width: 85%;border-radius: 10px;">Please see the referral letter <a  target="_blank" href="<?= base_url(); ?>/referral_letter"><u>here</u></a> and share it with friends,<br> so no one misses important government updates!
                </h3>
            </div>  
        </div>
       
            </div>
            
            
        </div>
        </div>
    </div>
</section>
<section class="every-profits">
  <div class="container">
    <div class="row text-center">
    </div>
<div class="row">
  <h1 class="everyoneheading"><span style="color:#000;">Everyone</span> Benefits!</h1>
    <div class="col-md-3"></div>
    <div class="col-md-6 bg-chnage"></div>
    <div class="col-md-3"></div>
</div>
<div class="row">         
 <div class="tab-block" id = "tab-block">
  
  <ul class="tab-mnu">
    <li>Nonprofits</li>
    <li>Businesses</li>
    <li>Municipality</li>
  </ul>
  
  <div class="tab-cont">
    <div class="tab-pane" style="display:none;">
      <h3 class="title">Non profits Benefits</h3>
         <div class="boxes non-profits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/Nonproft-heart.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Easiest Fundraiser:</b> You know trying to fundraise by asking your members to pay, for example $30 for a product that can be bought elsewhere for $15, is difficult. Now you can simply email your members and tell them they will still pay less than what local businesses normally charge, even after their donation!!! </h3>

          <h3><span class="num-val">2</span>
            <b>Businesses & Residents Both Donate:</b> Your nonprofit receives funds from both people who are buying discounted cash certificates, and local businesses that are bidding for ad position ranking in their business category in the savings directory.</h3>
          <h3><span class="num-val">3</span>
            <b>Monthly Reports:</b> At the end of the month your .xlsx report will show you detailed report as to who selected your nonprofit to benefit! If the public does not select a particular nonprofit, the Publisher will share those donation funds. At the end of the month, you can email members and thank the people that bought the most discounted cash certificates. This will politely serve as a notice to all your members that did not buy that you are aware of which members have designated your organization to benefit.  </h3>
          <h3><span class="num-val">4</span>
            <b>Promote Activities & Events at No Cost. </b> We have a very high saturation level as we have already obtained 90% of every home and businesses opted-in email addresses. You’re provided a panel in which you can post announcements of your activities!</h3>
          <h3><span class="num-val">5</span>
            <b>Increased Membership:</b> Having your nonprofit listed with a contact person leads to more members! </h3>
        </div>
      </div>
      </div>

  

    </div>
    <div class="tab-pane">
                 <h3 class="title">Businesses Benefits</h3>
         <div class="boxes businesses-benefits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/grouppng.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Business & Residents Saturation!</b> We own the largest data business in the USA and have already collected 90% of the residents and businesses opted-in email data to promote the business directory. Most marketing services do not promote your business to the business market at all. Additionally, the municipal and nonprofit involvement in the program further saturates the market! </h3>

          <h3><span class="num-val">2</span>
            <b>Enhanced Goodwill:</b> Your participation is helping many local nonprofits raise funds, which we constantly remind residents of.  The number of good deals we ask for per month is nominal, but you’re receiving massive exposure! If we fall short of selling the limited number of deals, that’s our problem not yours! Your business had zero out of pocket costs, and no risk.</h3>
          <h3><span class="num-val">3</span>
            <b>Free Promotion of Limited Number of Deals!</b> Unlike other services we only ask your business to offer a very limited number of good deals to help local nonprofits. </h3>
          <h3 class="no-margin"><span class="num-val">4</span>
            <b>No Time Commitment! </b> Try it out for a month and if you’re not happy, quit!</h3>
          <h3><span class="num-val">5</span>
            <b>We Incentivize New Customers!</b> We provide additional discounts out of our own compensation to try new businesses! You gain new customers! </h3>
            <h3><span class="num-val">6</span>
            <b> Solo Featured Mobile Responsive Website! </b> Of course, we know you’re never going to refer your existing customers to a directory with your competitors! So, we give you your own website address to direct your customers to! Customers can make your business a favorite and opt into your FREE SHORT NOTICE ALERT PROGRAM (SNAP) email list.</h3>
            <h3><span class="num-val">7</span>
            <b>Restaurants Get Free Orders powered by Amazon!</b> If you offer a deal, there’s no charge when we refer new orders to your business. Unlike other food order, services, your business can email customers to thank them for their business and provide a discount to buy again. When users are not redeeming a deal, your cost is only $2 for an order we refer. You have an option to use your own drivers or use a pool of additional drivers. Read www.FoodOrderSavings.com, website for many more benefits.  </h3>
            <h3><span class="num-val">8</span>
            <b>Option: Free Merchant Services! </b> We are a partner of Fiserv and negotiated a tremendous deal.(a) Zero Merchant service fees (b) Automatic acceptance! So there’s no need to provide months of merchant service statements or tax returns! (c) No Monthly statement fees, (d) Free terminal (e)  National account teams for service!</h3>
        </div>
      </div>
    </div>

    </div>
    <div class="tab-pane">
                 <h3 class="title">Municipality Benefits</h3>
         <div class="boxes municipality-benefits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/Flagpng.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Protect Municipality from OPRA/FOIA/ Sunshine Disclosure Laws: </b> As you know if the municipality emailed residents, it exposes the residents’ personal data to disclosure laws where you have to turn over all the residents email addresses. We are a Microsoft and AWS partner that has developed innovative email software solutions that insulate the municipality from being forced to disclose residents’ personal information. The municipal staff still has control of the content and emailing, but the data is insulated.   </h3>

          <h3><span class="num-val">2</span>
            <b>Enhance Saturation Levels:</b> We have already collected over 90% of every home and businesses opted-in email addresses. Most municipalities who do email typically never even get to 10% of residents to join your list.</h3>
          <h3><span class="num-val">3</span>
            <b>Amazon Alexa Emergency Broadcasts:</b> We are an Amazon Alexa certified skills developer. Residents can be asked to download the FREE Amazon Alexa phone app. You can then broadcast messages directly to residents’ phones, at a rate of 1 million messages per second.    </h3>
          <h3><span class="num-val">4</span>
            <b>No Taxpayer Cost:</b> You’re getting Microsoft & AWS services at no taxpayer cost! Ask your residents if they want the municipality to continue wasting taxpayer money on inferior services, when they can get superior services at no cost.</h3>
   
        </div>
      </div>
    </div>

    </div>

  

  </div>

</div>
  <div class="col-12"><button class="btn btn-backup" id="topbar">Top of Benefits List</button></div>
    </div></div>
</section> 
  <div class="header_wraper">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 col-md-4 left_col align_left_side">
          <h1>You Save & Your Favorite</h1>
          <h1 class="blue">Non-Profit Also Benefits!</h1>
          <p style="text-align: center;">Huge Discounted, Non-Expiring, Digital Deals!
            <br/>Redeem when serviced, at Business or Online!
            <br> <span class="hide-on-desk" data-toggle="modal" data-target="#ss-show">Read More</span> </p>
          <div class="bv_deeply_btn">
            <button><a class="busines_search" href="javascript:void(0);">Go to Deals!</a></button>
            <button type="button" class="youtube_btn btn btn-info btn-lg" data-toggle="modal" data-target="#foodModal"><i class="fa fa-youtube-play" aria-hidden="true"></i> YouTube Explainer</button>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-md-4 left_col head_col">
          <h3>Businesses give Great Deals because we cut their costs by many thousands; then we, nonprofits and municipality promote them absolutely free!</h3>
          <h3><b>You</b> claim a deal by paying just a small part of the discount to support your favorite local nonprofit!  </h3>
          <h3><b>You</b> don’t pay business its deeply discounted price until you’re serviced! No expiration!</h3> </div>
      </div>
    </div>
  </div>
<div></div>  
    <section class="comingsoon"> 
        <h3 class="windicitycoming">Coming Soon!<h3><br>
          <h2 class="foododers">Food Order Phone Line</h2> 
        <div class="windicity_img"> 
              <img class="windicityfoodimg" src="https://cdn.savingssites.com/food-order-new.png">
        </div>

         <br>
       <!-- <h2 class="foododers">More ways for you to Save & Support Nonprofits are Coming</h2><br> -->
    </section>
  <section class="slider_food">
    <div class="food_slides_new">
      <div class="carousel-inner owl-carousel owl-theme crouselHeader">
        <div class="item text-center carp1">
            <div class="fill"></div>
                <div class="carousel-caption "> 
                    <img src="https://cdn.savingssites.com/food_gif.gif" / alt="food">
                    <div class="caption_desc1">
                        <div id="mainwrap">
                          <div id="nowPlay"> <span id="npTitle"></span> </div>
                            <div id="audiowrap">
                              <div id="audio0">
                                    <audio id="audio1" preload controls>
                                      <source src="https://cdn.savingssites.com/food_audio_call.mp3" type="audio/mp3"> 
                                    </audio>
                              </div>
                            </div>                                                                      
                        </div>
                    </div>
                     <div class="container fosbullets">
                        <div class="row">
                            <div class="col-md-4">
                                <p>• Saves Money!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• More Accurate!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Much Faster!</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <p>• Safer Payment!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Phone never busy!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Press key for Deal</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pt-4">
                                <p class="presskeysam">See Many More Callers Benefits!  Click thru Read More!</p>
                            </div>
                        </div>
                    </div>  
                   <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
                </div>
        </div>
        
        <div class="item">
            <div class="fill" style="background-image:url('https://cdn.savingssites.com/salads_5.jpg');"></div>
            <div class="carousel-caption carp2">
                <div class="caption_desc">
                    <h2 class="animated fadeInLeft">Get Discounts on Every Call!</h2>
                    <p class="animated fadeInUp left_desc">FOS enables you to redeem savings sites digital cash certificates, and the certificate ID is hashed down to one digit entry. If your favorite restaurant is not offering a deal or has sold out, they still will give you other discounts. Examples:</p>
                    <div class="moretext">
                        <p class="animated fadeInUp left_desc">(1) Simply using the service to automate its orders. </p>
                        <p class="animated fadeInUp left_desc">(2) Discounts for paying by cash, </p>
                        <p class="animated fadeInUp left_desc">(3) If you pick up instead of requiring delivery. </p>
                    </div> 
                </div>
                <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
            </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/chops-pork_3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Prepaying for Dinners to <br/> get Deals! Help your Favorite <br/> Nonprofit Fundraise!
              </h2>
              <p class="animated fadeInUp left_desc">Stop the nonsense of preparing for the entire dinner just to save money with services like Groupon and Local Flavor! You know how many times you end up paying upfront and end up never using it! </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc">Now, you can pay just a small donation claiming fee to claim a digital cash certificate to help your favorite nonprofits fundraiser! The Savings Sites digital cash certificate is reduced to one number to simply say or enter it on FOS line. You get your discount AT THE TIME OF SERVICE!!! </p>
              </div> </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/ribs_2.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">One Sign-Up for all <br/> USA Restaurants!</h2>
              <p class="animated fadeInUp left_desc">Food Order Savings uses the sign-up that is done by residents to get important municipal emergency and general notices and to help local nonprofits raise funds. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/tacos-burritos-3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Your Personal Data is Protected!</h2>
              <p class="animated fadeInUp left_desc">We will not sell your data! Additionally, we help municipal governments communicate with residents in a manner to protects the resident’s data. </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc">Municipalities must adhere to forced disclosure laws like Open Public Records Act and FOIA. These laws normally force the Municipality to disclose all residents email data, etc., just by demanding it! Our unique email software coupled with our partner Microsoft insulates the municipality form being forced to give away your data!</p>
              </div>  </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/chinese_dishes_50.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Typing Into Phone! </h2>
              <p class="animated fadeInUp left_desc">No more thumb typo mistakes into a cell phone. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/stromboli_2.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Delivery Information & Special <br/> Delivery
                    Instructions are Auto <br/> Transferred to Restaurants!
               </h2>
              <p class="animated fadeInUp left_desc">In addition to full contact data transferred to restaurant in writing, callers when signing up specified special delivery information! Come to the side door not the front. Don’t ring the doorbell just text me because the dogs will come running to the door! Callers know their own written delivery instructions save time on every order and have less chance of delivery mistakes. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/soup-chowder-new-england.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Favorite Keys Make Ordering <br/> Fast & Accurate!
              </h2>
              <p class="animated fadeInUp left_desc">When signing-up callers can detail for every restaurant their favorite menu items and if not the norm, callers can detail exactly how they want it made. Callers pick FAVORITE KEYS so when they order they simply say the key number and all content is transferred, exactly as the caller wrote it up! Callers know there is greater chance that their order will not be wrong! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/salads_8.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Giving Your Card Info! Safely Store it!
              </h2>
              <p class="animated fadeInUp left_desc">Callers also obviously prefer paying with a secure payment than spending time on the phone giving all their card information to an order taker! Simply, no more risks and time wasted giving credit card information over the phone! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/burgers_17.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Busy Lines <br/> or Being Put on Hold!

              </h2>
              <p class="animated fadeInUp left_desc">Now callers simply call and they are off the phone in seconds having completed an accurate transfer of information and with a more secure payment! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/soup-chowder-new-england.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">You Get Copy of your <br/> Order for Accuracy!

               </h2>
              <p class="animated fadeInUp left_desc">Restaurants are busy with calls, and they are prone to making mistakes. Having your food delivered that is not prepared as you requested happens all the time. Now you and the restaurant have audio and transcription evidence to eliminate wrong orders. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/veal-milanese_3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Hear Delivery Time then Decide Delivery or Pickup 

              </h2>
              <p class="animated fadeInUp left_desc">Callers really are not always positive whether they will pick up or have it delivered. It all depends upon how long the delivery time is! Now callers hear the delivery time set by the restaurant! Callers then decide if they want it delivered or they’ll just pick it up! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/pasta-with-macaroni-cheese.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Live Entertainment Schedule <br/>& Daily Specials by Text! </h2>
              <p class="animated fadeInUp left_desc">No need to go to the restaurant and have the server read you the daily specials! Who can even remember the whole list and how each is made! It’s much better to have the specials and their ingredients texted to you! Then you will know whether you want to go to the restaurant to get one of the daily specials. </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc"> Also, many Restaurants have live entertainment and Karaoke Nights so you can find out without calling them.</p>
              </div>  </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/bread-bagels.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Callers Substantially Benefit <br/>

                by using Food Order Savings <br/>

                than any other Ordering Service!

                </h2>
              <p class="animated fadeInUp left_desc">Saves Money! Easier! Faster! More Accurate! Less Risky with your card! Helps your favorite nonprofit rasie funds. </p>
              <p class="animated fadeInUp left_desc"> There is simply no reason to use any other service!</p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <style type="text/css">

  #hide-on-desk {
    display: none !important;
  }
  
  @media (max-width: 767px) {
    #hide-on-mob {
      display: none !important;
    }
    #hide-on-desk {
      display: block !important;
    }
  }

.doAnimation .slick-active .carousel__slide__inner .carousel__image {
  -webkit-animation: scale-out 0.875s cubic-bezier(0.7, 0, 0.3, 1) 0.375s both;
          animation: scale-out 0.875s cubic-bezier(0.7, 0, 0.3, 1) 0.375s both;
  transform: scale(1.3);
}
.carousel__slide__overlay {
  background-color: transparent;
  background-size: 100%;
  height: 100%;
  left: 0;
  opacity: 0.5;
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 2;
}
.slick-active .carousel__slide__overlay {
  animation: scale-in-hor-left 1.375s cubic-bezier(0.645, 0.045, 0.355, 1) 0.25s reverse both;
}
.carousel__image {
  height: 100%;
  -o-object-fit: cover;
     object-fit: cover;
  position: relative;
  transform: scale(1);
  width: 100%;
  z-index: 1;
}

@-webkit-keyframes scale-out {
  0% {
    transform: scale(1.3);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes scale-out {
  0% {
    transform: scale(1.3);
  }
  100% {
    transform: scale(1);
  }
}
@-webkit-keyframes scale-in-hor-left {
  0% {
    transform: translateX(-100%) scaleX(0);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  50% {
    transform: translateX(-50%) scaleX(0.5);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  100% {
    transform: translateX(0) scaleX(1);
    transform-origin: 0% 0%;
    opacity: 1;
  }
}
@keyframes scale-in-hor-left {
  0% {
    transform: translateX(-100%) scaleX(0);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  50% {
    transform: translateX(-50%) scaleX(0.5);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  100% {
    transform: translateX(0) scaleX(1);
    transform-origin: 0% 0%;
    opacity: 1;
  }
}
  </style>
<section id="project">
    <div class="header common text-left">
        <center><h3>More Ways to Save & <span>Support Nonprofits are Coming! </span></h3></center> 
    </div>
    <div class="carousel boxxes">
        <div class="carousel__slide">
           <!-- <button type="button" data-role="none" role="button" tabindex="0"></button> -->
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/snapdining.jpg" class="img-responsive" alt="saving-site-logo">
                    </div>

                    <h2>Snap Dining Discounted Reservations!</h2>
                    <p>
                        Restaurants will be able to show the days of the week and hours of the days that you get a percentage discount. If you bought a deal to support your favorite nonprofit that deal will also be redeemable when reservation is made!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>


        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/hugegroupdeals.jpg" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Huge Group Deals</h2>
                    <p>
                        Free to join! Huge group deals on both business and consumer products and services! We get huge deals because we already have group buying power from hundreds of millions opted-in emails nationally!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>


        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/peekabooauctions.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Peekaboo Auctions</h2>
                    <p>
                        You’re going to have so much fun playing Peekaboo. Peekaboo is a unique reverse blind auction. Example: A dinner price starts out at $100 and there is a hidden price that is even less. Say the hidden price is $80. You buy “peeking credits” for 25 cents to support your favorite nonprofit! You use a peeking credit to get 20 seconds to decide if you want to end the auction and buy at that low hidden price.You and everyone else may bypass buying at the hidden price because each bypass causes the hidden price to drop! Eventually the price goes so low, for example to $5, and someone will say LOW ENOUGH, and end auction by buying! But everyone wins because all the “losers” still get to buy the $100 value for $80, and more than cover their peeking credit donation. Bidders, Sellers, Nonprofits Orgs all Win! 
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" id="textshow" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        <div class="header-btn-group bv_read" bis_skin_checked="1">
                            <!-- <button class="readshow toggle boxed-btn  slideUp" tabindex="-1">Read More</button> -->
                        </div>
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/liveeventsfun.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Live Events Fun & Edu Webinars</h2>
                    <p>
                       In partnership with Microsoft we organize by category, with detailed description, the time and date that businesses will host Fun and Educational Webinars! It’s free to attend live or watch a recording! 
                       We also will host group tutoring classes on common classes students have difficulty with. Also classes that are not typically taught in schools, like computer coding. Top teachers will tutor, and group participants will pay as low as $1 per hour! As usual your favorite nonprofit will be supported!
                            </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/savingsdeliveryorder.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Savings Delivery Order Online</h2>
                    <p>
                       When you place your online order you’ll be able to redeem any deal that you bought to support your favorite nonprofit! 
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/savingslinksyours.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Savings Links Yours and Our favorites</h2>
                    <p>
                        We will freely supply you with a detailed synopsis of links to many other websites that will save you money!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/classifiedseasy.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Classifieds Easy to Buy, Easy to Sell</h2>
                    <p>
                        Our classifieds platform is unlike any other classifieds service! It’s so innovative that we won’t explain it until it’s ready for rollout because others will copy! Promise, you’ll never need to use any other classifieds.
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/localblog.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Local Blog</h2>
                    <p>
                        Many blog categories that neighbors can post their comments. All comments are from registered members, so there won’t be any anonymous trolls.
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1"></div>
                </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>
   </div>
</section>
 <section class="container-fluid images_partners ours_partners pt-5">
    <h2 class="partner_name">Our <span class="h1benefits">Partners</span></h2>
      <div class="Inner_wrapper">
        <div class="row text-center" id="div_partner">
           <div class="col-lg-2 col-sm-12 seoimg pt-5">
             <img src="https://cdn.savingssites.com/SEo_new.png">  
           </div>
           <div class="col-lg-2 col-sm-12 pt-5">
             <img class="partner_microsoft" src="https://cdn.savingssites.com/micorsoft.png">  
           </div>
           <div class="col-lg-3 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/amazon_spn.png">  
           </div>
           <div class="col-lg-3 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/FiservLogo.png">  
           </div>
           <div class="col-lg-2 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/QuickBooks-Certified-ProAdvisor.jpg">  
           </div>
        </div> 
     </div>
  </section>
  <div  class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="youTube_explainer">
    <div class="modal-backdrop fade in"></div>

            <div class="modal-dialog" role="document" id="example">

                <div class="modal-content lottery-box-video">

    <div class="modal-header">                     
            <h4 class="modal-title" id="myModalLabel">
                   <i class="fa fa-thumbs-o-up" aria-hidden="true" style="position: relative;
    top: 7px;"></i>
                    <span id="login_type_name" logintype="4">Save By Giving!</span>
                </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
            </div>

                    <div class="modal-body">                                                

                        <div class="embed-responsive embed-responsive-16by9">
                   
                          <iframe id="video1" width="640" height="360" src="https://www.youtube.com/embed/USZAofevitM?autoplay=1&mute=1&enablejsapi=1" frameborder="0" style="border: solid 4px #37474F"></iframe>
                        </div>

                    </div>

                </div>

            </div>

        </div> 
 