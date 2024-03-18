<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  About
<?=$this->endSection()?>
<?=$this->section("content")?>
<?=$this->include("includes/about_slider")?>
<div id="benefits-ss" class="benefits">
  <div class="benefits-body">
    <div class="text-center"><img src="<?= base_url();?>/assets/about/benefits/SS-LOGO-3-TONY.png"/></div>
    <div class="otext list_style_inherit">
      <div class="text-center">
        <ul class="nav nav-tabs font-17">
          <li>
            <a data-toggle="tab" href="#tab-110"><div class="adtab_text_small"><span class="adtab_text_bold">Municipality</span></div></a>
          </li>
          <li class="residents active">
            <a data-toggle="tab" href="#tab-111"><div class="adtab_text_small"><span class="adtab_text_bold">Residents</span></div></a>
          </li>
          <li>
            <a data-toggle="tab" href="#tab-112"><div class="adtab_text_small"><span class="adtab_text_bold">Schools/Organizations</span></div></a>
          </li>
          <li>
            <a data-toggle="tab" href="#tab-113"><div class="adtab_text_small"><span class="adtab_text_bold">Local Businesses</span></div></a>
          </li>
        </ul>
      </div>
      <div class="tab-content">
        <div id="tab-110" class="tab-pane fade ">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="text-center">FREELY:<br />Reduce Municipal Costs, Improve Communications,<br />Protect Residents Data, Promote Local Orgs/Businesses!</h4>
            </div>
            <div class="panel-body">
              <h5 class="text-center">We protect the municipality from being forced to disclose <br />residents Emails & Cell Text Data due to OPRA/FOIA Laws!</h5>
              <img class="text-center" src="<?= base_url();?>/assets/benefits/infoact.png" />
              <ul>
                <li>We have notified the municipality that all departments can login and freely use our service 24/7, to enhance resident communications and safety and protect the municipality from forced disclosure of resident's email addresses and cell phone text data.</li>
                <li>By law the municipality is subjected to residential data disclosure laws (OPRA, FOIA, Sunshine) if the municipality gathered resident's data. Savings Sites has already collected <strong>about 90%</strong> of every home, opted-in email address/text-which is <strong>not sold</strong>! Because the municipality freely uses our data and our servers, but does <strong>not take possession</strong> of the data, this insulates the municipality from forced disclosure of resident's data. </li>
                <li>The municipality (police, fire, recycling, recreation, etc.) can target information based upon the interest profiles of residents. Example: Recreation can email parents of 5th and 6th grade, Boys, that are interested in Soccer.</li>
                <li>FREE online class/event registration. No transcription time and errors. All residents get equitable chance of registering with time date stamps as opposed to mailed in registrations. </li>
                <li>Accept online payments over secure server, from residents for categories such as: (real estate taxes, municipal fines, tickets, recreation classes, construction permits, water/sewer, etc.). Capture all information for each category for easy export to .csv file for accounting purposes. Complete details of the transaction can be captured by the municipality, including all identifier information (Lot, Block, account numbers, names, phones, emails, texts, postal address, etc., that only the municipality controls). The municipality will save all the time data entering information and eliminate transcription errors. Also, all payments will be time and date stamped to address any failures to meet deadlines. The total municipal cost is 1/2 of 1% on only the first $50,000 a month, then $0 cost above $50,000 revenue received--so max fee is $250 month. No monthly statement or any other fees.</li>
                <li>Calendar system enables municipal events to be posted and residents only see events that meet their "interests profile." Because local orgs and schools can also use the same events calendar, all parties' events are more apt to get seen. The filtered calendar events flow right to the resident's phones! </li>
              </ul>
            </div>
          </div>
        </div>
        <!--tab-111-->
        <div id="tab-111" class="tab-pane fade active in">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="text-center">Quick and Easy Local Business Savings<br />&<br />Timely, Targeted Local Events</h4>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-3">
                  <script type="text/javascript" src="<?= base_url();?>/wthvideo/jquery.wthvideo.js"></script>
                  <script>
                  $(document).ready(function(e) {
                    $('#wthvideo3').wthVideo();
                    $('#wthvideo_jqm').show();
                  });
                  </script>
                  <div id="wthvideo3" style="display: block;height:390px; margin-left: -128px; left: 50%; position: relative;" class="benefit-video-style">
                  </div>    
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-sm-9">
                  <h3 style="text-align: center;font-weigt:bold">Short Notice Alert Program (SNAP)&nbsp;<img src="<?= base_url();?>/assets/benefits/snap.png" style="width:50px;vertical-align: middle;" /></h3>
                  <p><img src="<?= base_url();?>/assets/images/filter.png" class="align-left" />Save money without cutting, collecting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area.</p>
                  <p>Simply click the SNAP graphic in the header of each business Ad and set SNAP savings filters to meet your availability and discount required! You choose which businesses you want offers from.</p>  
                  <p>You decide if you wish to filter your offers by days of the week and times of the day you are available to use the offers; and you decide the minimum discount that you require to get through your SNAP savings filters!</p>
                </div>
              </div>
              <div class="text-center"><a class="snappop on" href="#snapPop9" data-toggle="modal" data-target="#snapPop9"><img src="<?= base_url();?>assets/benefits/img-1.jpg" style="max-height: 300px;" /></a></div>
                <p>Businesses must meet all your "savings filters" for Savings Sites to email you their short notice offers, and you can even set different savings filters for each business! Example: You love Mike's restaurant, so you set it for 7 days, seated as late as 8:00pm, 20% minimum discount required.  You like Joe's restaurant, too, but it's further away so you set it only for Saturdays, seated by 6:00pm, 35% minimum. Not just restaurants! Carpets need cleaning? Open your Short Notice Alert Program filters for carpet cleaners, and get huge discounts to fill their schedules. After your carpet gets cleaned, just turn off all emails from carpet cleaners! 
                </p>
                <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                <h3 class="text-center" style="margin:0px 0 10px;"><strong>Searching for Offers is Fast & Easy</strong></h3>
                <div class="reverse-list">
                  <div class="row">
                    <div class="col-sm-6">
                      <ol class="reverse-list">
                        <li>Search for all restaurants for Reservations</li>
                        <li>By Saved Favorites </li>
                        <li>Search Alpha A-Z</li>
                        <li>By Business Category</li>
                        <li>Directly by business name</li>
                      </ol>
                    </div>
                    <div class="col-sm-6"><img src="<?= base_url();?>assets/benefits/img-3.jpg" style="max-height: 350px;" /></div>
                  </div>
                  <p class="text-center"><strong>Just click "Add Favorite" to make Business a favorite.</strong></p>
                  <img class="text-center" src="<?= base_url();?>assets/benefits/img-2.jpg" />
                  <p class="text-center"><strong>and when you come back just hit <img src="<?= base_url();?>assets/benefits/wishlist_icon2.png" style="vertical-align: middle;display: inline-block;idth:auto;" /> <span style="color: #e52600;">My Favorite Businesses</span> and see only your favorite.</strong></p>
                </div>
                                 
                                 <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                                 <img class="text-center" src="<?= base_url();?>assets/benefits/img-2-1.jpg" style="max-height: 300px;" />
                                 <p>SNAP Dining-It's like OPEN TABLE but so much better. Simultaneously search for all restaurants for reservations. Every hour of operation has a different discount percentage. You have the <strong>option</strong> of using your SNAP SAVINGS FILTERS to modify search results!</p>
                                 <img class="text-center" src="<?= base_url();?>assets/benefits/img-2-2.jpg" style="max-height: 200px;" />
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <div class="row">
                                    <div class="col-sm-3"><img class="text-center" src="<?= base_url();?>assets/benefits/img-4.jpg" style="width: 100%;max-width: 300px;" /></div>
                                    <div class="col-sm-9">
                                        <img class="text-center" src="<?= base_url();?>assets/benefits/img-3-1.jpg" />
                                        <h3 class="text-center">Peekaboo "Deeply Discounted & Non-Expiring" Cash Certificates!</h3>                                        
                                        <ol>
                                            <li>Peekaboo is unique "reverse blind automated auction" where everyone saves, and everyone can decide to become the big winner! </li>
                                            <li>Example: The cash certificate redemption value is <strong>$100</strong>. You can pay the auction starting price <strong>$70</strong>, but the current hidden price is even lower <strong>$30</strong> and <strong>keeps going down</strong> until someone decides to stop the auction and declares themselves the winner! <strong>All consolation winners have the option of paying $70 for the $100</strong>.</li>
                                            <li>The current hidden price <strong>keeps going down</strong> when anyone bypasses! To see the current hidden price, just click the panda bear and you have 10 seconds to buy at $30 or bypass. People bypass in hopes of getting the cash certificate for even less! </li>
                                            <li>As the current hidden price keeps going down to $0.00, obviously someone will decide to stop the reverse auction declare themselves the big winner! Everyone else pays $70 for $100! </li>
                                            <li><img class="alignright" src="<?= base_url();?>assets/benefits/img-5.jpg" />Bidding and buying is automated. No need to manually bid. Either have fun trying to become the huge winner, or simply auto qualify to buy the non-expiring, $100 cash certificate for $70! </li>
                                            <li>You get to give by saving. Every time you buy a cash certificate the business pays us an ad fee. You choose your favorite organization to share the AD fee. </li>
                                            <li>You peek at the current hidden price using peeking credits. In the menu tabs dropdown see the <strong>many ways to get free peeking credits</strong>. You can also buy peeking credits from your favorite organizations in the Organization panel and we will <strong>refund the minimum credits</strong> needed to buy the cash certificate, so there really isn't any net cost. </li>
                                            
                                        </ol>
                                        <p><strong>Watch the explainer video how it works.</strong> <a href="https://tipscloud.egnyte.com/dl/muBmk09rED" target="_blank">https://tipscloud.egnyte.com/dl/muBmk09rED</a></p>
                                    </div>
                                 </div>
                                 <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                                 <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-6.jpg" style="max-height: 300px;"/></div>
                                 <ol>
                                    <li>Freely and anonymously sit back and watch live Question & Answer Webinars from Local Professionals and Contractors! If you can't make the live webinar watch recently recorded webinars.
                                        <div class="colored-box">
                                            <h4>Group Tutoring as low as 25 Cents Per Hour!</h4>
                                         </div>
                                         <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-7.jpg" style="max-height: 300px;"/></div>
                                    </li>
                                    <li>Classes are live and taught by professionals and recorded. Having your child go online and learn "for free" on their own is not the same as a live teacher. </li>
                                    <li>At this price tutoring doesn't only have to be for students having problems. Have your child take "next years" math class "this year" so it's a breeze.    </li>
                                    <li>Essential classes like coding are not available in most elementary and high schools. </li>
                                    <li>Your Parent Teachers Association may subsidize or even cover the cost.  </li>
                                 </ol>   
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-8.jpg" style="max-height: 300px;"/></div>
                                 <ol>
                                    <li>Full of robust features LOCAL BLOG system.  Enjoy talking with neighbors! </li>
                                    <li>Home Decorating, Politics, Food, Health & Nutrition, Fashion, Sports Talk, Financial Advice, etc. </li>
                                    <li>Are you an expert in your industry and want to reach local market? Contact Us!</li>
                                 </ol>    
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-9.jpg" style="max-height: 300px;"/></div>
                                 <ol>
                                    <li>Free Resident Membership & Free for Businesses to Post Huge Group Deal. </li>
                                    <li>Members buy at the special member price. </li>
                                    <li>Members can also get a free no obligations quote to lease at the member price, as our extensive network of leasing companies competes for members business. </li>
                                    <li>If members don't qualify for lease the HGD service enables buyers to qualify by simultaneously reducing the member price balance and enhancing the members credit score. </li>
                                    <li>Anyone can use our leasing network on their own personal deal.</li>
                                    <li>Currently the lessors will handle leasing from $500 to $5 million. </li>
                                    <li>Read the <a href="http://synergize.hol.es/groupsavings/index.php?page=about" target="_blank">About Page</a> for full details. </li>
                                 </ol>  
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-10.jpg" style="max-height: 300px;"/></div>
                                 <ol>
                                    <li>Classifieds service, filled with great features, that is so much better than Craig's List.</li>
                                    <li>All the typical categories you find in the town newspaper you will find here, and more. Also, more Ad content is allowed and for a longer time!  </li>
                                 </ol> 
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <h3 class="text-center"><strong>Manufacturers Coupons!</strong></h3>
                                 <div class="text-center"><img src="<?= base_url();?>assets/benefits/img-11.jpg" style="max-height: 300px;"/></div>
                                 <ol>
                                    <li>Choose from hundreds of favorites and since they are manufacturers coupons they are good at any store. </li>
                                 </ol>   
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <h3 class="text-center"><strong>Savings Circulars</strong></h3>    
                                 <ol>
                                    <li>"Savings Circulars" is a drop down for quick and easy 1 click access to all the online weekly and monthly current savings offers for local Grocery Stores, Big Box, Department Stores, Malls, etc.</li>
                                 </ol>
                                 <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                 <h3 class="text-center"><strong>Local Targeted Information Consolidated, All in One Place</strong></h3>   
                                 <ol>
                                    <li>Your email/ text data is protected from Municipal forced disclosure laws, plus Businesses and Local Organizations do not receive your data, nor is it sold.   </li>
                                    <li>Your "interests profile" filters information from the municipality, schools and local organizations.  You only see only calendar events posted by (municipality, schools, and orgs), that meet your "interests profile"! The consolidated filtered events can then flow right to your phone. Our website site "adapts" to any viewing device, from small phone to large monitor, and looks like a phone app without downloading an app! </li>
                                 </ol>  
                                 <img src="<?= base_url();?>assets/benefits/img-13.jpg" class="text-center"/>               
                            </div>
            </div>
          </div>
                    <!--tab-112-->
          <div id="tab-112" class="tab-pane fade">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="text-center">Promote Events, Easy Fundraiser, Gain Members!</h4>
              </div>
              <div class="panel-body">
                                <img class="alignleft" src="<?= base_url();?>assets/benefits/img-21.png"/>
                <ol>
                                    <li><strong>Easy Fundraiser:</strong> Simply email your members and tell them to go buy local businesses deeply discounted, non-expiring, cash certificates! Members save money and your org gets a generous share of the businesses pay for results advertising fee! The Org Director has a spreadsheet showing which members directed the money to your Org! Go save money!  Easiest fundraiser ever! </li>
                                    <li>Your org also has the option of selling ---right on our sites organization panel----Peekaboo Auction peeking credits, with up to a <strong>70% margin</strong>, and we then rebate your members the minimum credits needed for each cash certificate purchase!  </li>
                                    <li><strong>Gain New Members!</strong> When potential members go to the Organization section, it shows all local orgs, so now people have quick access to learn about your org and become a member. </li>
                                    <li><strong>Freely Email/Text:</strong>  Freely promote your events/activities by email and texts with unlimited "interest group" categories. </li>
                                    <li><strong>Freely use Calendar:</strong> Create unlimited calendar categories to promote events/activities. </li>
                                    <li><strong>No costs! No Commitments! All Benefits!</strong> </li>
                                </ol>
              </div>
            </div>
          </div>
                    <!--tab-1130-->
          <div id="tab-113" class="tab-pane fade">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="text-center">
                  Pay for Results Advertising<br />Loaded with Free Valuable Benefits
                </h4>
              </div>
              <div class="panel-body">
                <ol>
                                    <li><img class="alignleft" src="<?= base_url();?>assets/benefits/img-22.jpg" /><strong>Free Unlimited Emailing/Texting:</strong> 
                                        <ol>
                                            <li>Our servers will send your Short Notice Alert Program (SNAP) Offers.</li>
                                            <li>You know the number of recipients based upon residents opted in SNAP Filters.</li>
                                            <li>Prior to your offer being emailed/texted you can modify your offer to increase or decrease number of recipients. You may reduce the discount offered if you believe there are more than adequate number of recipients to fill the tables. You can always email later to fill the balance of tables if your first email did not fill the tables--It's free!!!</li>
                                        </ol>
                                    </li>
                                </ol>
                                <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                                <img src="<?= base_url();?>assets/benefits/logo_ss.png" class="text-center" />
                                <ol>
                                    <li><strong>No Money Out of Pocket</strong> -"<strong>Pay for Results Advertising</strong>"
                                        <a href="#adsAbout" class="alignleft" style="position: relative;z-index: 10;"  data-target="#adsAbout" data-toggle="modal"><p style="font-size:12px; text-align:center;">Click on Table to Open and see other Benefits!</p><img src="<?=  base_url(); ?>assets/benefits/img-29.jpg"  style="width: 100%;max-width:400px;" /></a>
                                        <ol>
                                            <li>at about 70% less than what Groupon charges, using Peekaboo Auctions. All the issues that businesses have with Groupon have been eliminated.</li>
                                            <li>You decide how many cash certificates you want to sell and set all the conditions.</li>
                                            <li>No time or volume commitments.</li>
                                            <li>You also help local orgs raise money and pay for municipal and org updates.</li>
                                            <li>Your pay for results Ad fee will be <strong><em>substantially less</em></strong> than any other way to promote your business.</li>
                                            <li>The real discount you provide, is much less than the total discount offered. Non-redemptions, plus purchases made above the redemption value, and other factors substantially reduce the real discount provided. Click the table on right &gt;&gt;&gt;</li>
                                            
                                            <li><strong>UPSELL:</strong> If you are offering a $100 redemption value the customer will need to buy $100 to take advantage of the offer. If your normal average is $75, your average revenue now improves.</li>
                                            <li><strong>Interest Free Loan:</strong> You are paid upfront, but the cash certificate may not be used for many months. You have use of the money with no interest for many months.</li>
                                        <li>Peekaboo Auctions Overview: <a href="https://tipscloud.egnyte.com/dl/ad6R3g4kAD" target="_blank">https://tipscloud.egnyte.com/dl/ad6R3g4kAD</a></li>
                                </ol>
                                <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                <ol>
                                    <li><img class="alignleft" src="<?= base_url();?>assets/benefits/img-23.png"  style="width: 100%;max-width:400px;"/><strong>Free Online Reservations/Scheduling:</strong> (SNAP Dining for Restaurants) and Online Appointment calendar system for Non-Restaurants. 
                                        <p><strong>Restaurants:</strong></p>
                                        <ul>
                                            <li>SNAP Dining reservations FREELY enables you to consolidate reservations from phone calls, walk-ins, and all 3rd reservation services (Open Table, YELP, etc.), into one consolidated view! </li>
                                            <li>Download our free windows software into as many tablets/PC's as you like. </li>
                                            <li>From your tablet/PC you can simultaneously update "consolidated central reservations" on our server, and on your tablet/PC.</li>
                                            <li>Waiting list functionality</li>
                                            <li>Notes Section e.g. (Have 1-year old need high chair)</li>
                                            <li>No Hardware or Software to Buy</li>
                                            <li>If you don't have a tablet/PC we can provide a 3G Wi-Fi 7-inch tablet for one time $95 with our free software installed.</li>
                                            <li>Tablets can also be used to add residents email addresses to your free SNAP emailing service.</li>
                                            <li>No commitment--Month to Month</li>
                                            <li>You select discount percentages, for each hour of operation, and you can easily and instantly modify at any time. The minimum discount is only 5%! There is a percentage for each hour already in there by default--- you modify it as you wish before you go live to the public.   </li>
                                        </ul>
                                    </li>
                                </ol>
                                <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                                <ol>
                                    <li><img class="alignleft" src="<?= base_url();?>assets/benefits/img-28.jpg" /><strong>Accept Payments Securely Online ---or in store/office tablet ---at 1/2 of 1%. (.005) and 0% above $50,000.</strong>
                                        <ul>
                                            <li>No set up fee ---No monthly fee--No minimums--No term commitments--No hardware to buy.</li>
                                            <li>Use your own Wi-Fi Tablet or PC or we will give you one for $95.</li>
                                            <li>Complete accounting of the transactions; with .csv files to upload into QuickBooks, Google Sheets, Fresh Books etc.</li>
                                            <li>You can keep your current Merchant Service Provider-just use less of them when possible. Less Chargebacks and fighting with credit card companies.</li>
                                            <li>We even provide much better incentive for your customers to use this option, instead of their "rewards points credit cards." You would pay 3%-4%, if your customer paid by credit card. So, give your customers 2% of the sale in peekaboo auction peeking credits to <strong>increase future sales</strong>. You use the $6 to buy the credits at wholesale cost of only $0.15 per credit as opposed to people paying up to $0.50 per credit. </li>
                                            <li>Example: Customer pays you $300. The customer automatically receives 40 credits. (2% of $300= $6 your cost). $6/15 cents = 40 credits. That buyer would normally pay up to $20 retail for 40 credits. The buyer spent $300 and got <strong>$20</strong> value. Many rewards points credit cards would make you spend several thousands to get $20 value. You get an increase in future sales all being paid for with money that would have went to 3%-4% credit card fees.</li>
                                            <li>Funds go into <a href="http://www.dwolla.com/" target="_blank">www.Dwolla.com</a> account that is linked to your business account and enables you to transfer funds back and forth. </li>
                                            <li>Savings Sites has integrated the ability within businesses dashboard to quickly pull a Jot Form to securely capture the transaction data right within the Savings Sites display AD. Learn more about: <a href="https://www.jotform.com">https://www.jotform.com</a></li>
                                            <li>Savings Sites integration now makes acceptance of inexpensive secure online ACH payments quick and easy, with complete transactional information that will impress your accountant!</li>
                                            <!--<li><strong>Merchant Services:</strong> No monthly fee and 1/2 % instead of 3%-4%. VISA/MC/AMEX </li>-->
                                        </ul>
                                    </li>
                                </ol>
                                <div class="separator"><img src="<?= base_url();?>assets/images/separator.png" /></div>
                                <ol>                                    
                                    <li><strong>HUGE Group Deals! Free Advertising!  Free to Make Offers on HUGE Group Deals!:</strong> Free to post a HUGE Group Deal! We help you sell your deal and help members get a competitive lease with our huge leasing company network. We help customers that can't qualify for a lease by improving their credit score. You get paid upfront non-recourse. See the About Page of HUGE Group Deals for details. </li>
                                </ol>
                                <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>
                                <ol>    
                                    <li><img class="alignright" src="<?= base_url();?>assets/benefits/img-27.jpg" style="width: 100%;max-width:400px;"/> <strong>Educational Webinars:</strong> Conduct live Question & Answer Webinars, and we list recent recordings! </li>
                                    <li>Pay per participant and the cost is much less expensive, with much better-quality participants, than renting hotels to do seminars. </li>
                                    <li>Eliminate people seeking free coffee, desserts, dinners, etc.</li>
                                    <li>Eliminate people asking dumb questions wasting everyone's time.</li>
                                    <li>Smart people don't disclose, in open seminars, their personal information, but they will be happy to have their good questions answered via chat. You receive the registration of every participant, so you can personally talk with them.  </li>
                                    <li>See the about page of <a href="http://synergize.hol.es/webinar/" target="_blank">Educational Webinars</a> for many more benefits! <img src="<?= base_url();?>assets/benefits/img-12.jpg" style="width: 100%;max-width:980px;" class="text-center"/></li>
                                </ol>        
                                <div class="separator"><img src="<?= base_url();?>assets/benefits/separator.png" /></div>                        
                                <h3 class="text-center"><strong>Feature Rich Display Ads</strong></h3>  
                                <img class="alignright" src="<?= base_url();?>assets/benefits/img-24.png"/> 
                                <ul class="list-tick-green">
                                    <li>Display ad is the entire width of the monitor.</li>
                                    <li>Unique website address that directly accesses your display ad, with no other businesses displayed. </li>
                                    <li>Unlimited photos, videos, menus, MapQuest directions, and more.  </li>
                                    <li>We use viewing responsive design, so it "adapts" to all visitors viewing devices, from small phones to tablets to laptops to huge monitors. It looks like a phone app without needing to download an app! </li>
                                </ul>   
                                <img class="text-center" src="<?= base_url();?>assets/benefits/img-26.jpg"/>
              </div>
            </div>
          </div>
                </div>
                <!--
                <div class="text-center">
            <ul class="nav nav-tabs font-17">
              <li class="active">
                <a data-toggle="tab" href="#tab-110"><div class="adtab_text_small"><span class="adtab_text_bold">Municipality</span></div></a>
              </li>
              <li>
                <a data-toggle="tab" href="#tab-111"><div class="adtab_text_small"><span class="adtab_text_bold">Residents</span></div></a>
              </li>
              <li>
                <a data-toggle="tab" href="#tab-112"><div class="adtab_text_small"><span class="adtab_text_bold">Schools/Organizations</span></div></a>
              </li>
              <li>
                <a data-toggle="tab" href="#tab-113"><div class="adtab_text_small"><span class="adtab_text_bold">Local Businesses</span></div></a>
              </li>
            </ul>
                </div>
                -->
        </div>          
    </div>
</div>
<div class="modal fade snap-dropdown-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="adsAbout">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">
                        &times;
                      </span>
                    </button>
                                        <h3>Discount Offered vs Real Discount Provided</h3>
                                    </div>
                                    <div class="modal-body" style="max-height: 500px;overflow-y: auto;">                                        
                                        <h3 class="text-center">Discount Offered</h3>
                                        <p>$100 Redemption Value, and our Ad Fee that's shared with Orgs for each cash certificate sold, is 9% of redemption value ($9). The buyers offered $100 for $81, so (19% discount). <strong>Total Discount Offered is: 28% = (9% + 19%).</strong></p>
                                        <h3 class="text-center">Real Discount Provided</h3>
                                        <p>You are paid upfront even when the cash certificate is not redeemed. Also, the discount offered is only on the $100 not on the amount above $100. </p>
                                        <p>Therefore, if 8% do not redeem and the average spent is $175, the real discount you are really providing is only <strong>12.42%</strong>  NOT <strong>28%</strong>. </p>
                                        <img src="<?= base_url();?>assets/benefits/img-29.jpg" class="aligncenter" style="width: 100%;margin:0 auto;display: block;" />
                                    </div>
                                </div>
                            </div>
</div>

<?=$this->endSection()?>