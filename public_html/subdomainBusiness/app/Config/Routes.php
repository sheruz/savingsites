<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}



/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
ini_set('display_errors', '1');
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$url = $_SERVER['SERVER_NAME'];
$REQUEST_URI = $_SERVER['REQUEST_URI'];
$requesturl = str_replace('/', '', $REQUEST_URI);

$parsedUrl = parse_url($url);
$host = explode('.', $parsedUrl['path']);

$subdomain = $host[0];  
// initialize database class
$db = \Config\Database::connect();

$builder=$db->table('sales_zone');
$builder->select('subdomain,subdomainZone');
$builder->where('subdomain !=','');
$builder->where('subdomainZone !=','');
$query=$builder->get();
$data=$query->getResult();
foreach ($data as $k1 => $v1) {
    $dealsArr[]=$v1->subdomain;
    $zoneArr[]=$v1->subdomainZone;
}


if (in_array($subdomain, $dealsArr)){
    if($requesturl == 'groceryStore'){
        $routes->get('/(:any)', 'BusinessSearch::search/$1');
    }else{
       $routes->get('/', 'BusinessSearch::search');  
    }
   
    
}
if (in_array($subdomain, $zoneArr)){
    $routes->get('/', 'Zone::load');
}
// $routes->get('/', 'Home::index');
$routes->get('home/contact_us', 'Home::contact_us');
$routes->get('home/publisherTOS', 'Home::publisherTOS');
$routes->post('contact', 'Home::contact');
$routes->get('home/about_us', 'Home::about_us');
$routes->get('home/advertise', 'Home::advertise');
$routes->get('home/business_registration/(:any)', 'Home::business_registration/$1');
$routes->get('add_business_check_username', 'Dashboards::add_business_check_username');
$routes->get('add_business_check_username_phone', 'Dashboards::add_business_check_username_phone');
$routes->get('check_email', 'Dashboards::check_email');
$routes->get('getZip', 'Home::getZip');
$routes->get('getZone', 'Home::getZone');
$routes->get('getCity', 'Home::getCity');
$routes->post('profile_update', 'Auth::profile_update');
$routes->post('sponsor_profile_update', 'Auth::sponsor_profile_update');
$routes->post('businessdashboard_update', 'Auth::businessdashboard_update');
$routes->get('fetchMyAccountData', 'Ads::fetchMyAccountData');
$routes->get('fetchMyAccountDataedit', 'Ads::fetchMyAccountDataedit');
$routes->post('myaccount_update', 'Ads::profile_update');
$routes->post('zone/(:any)', 'Zone::profile_update');
$routes->get('home/organization_registration/(:any)', 'Home::organization_registration/$1');
$routes->get('sponsor_registration/(:any)', 'Home::sponsor_registration/$1');
$routes->post('organization_registration', 'Zonedashboard::organization_registration');
$routes->get('get_organization', 'Zonedashboard::get_organization');
$routes->post('update_organization', 'Zonedashboard::update_organization');
$routes->get('home/business_login', 'Home::business_login');
$routes->post('check_login_type', 'Auth::check_login_type');
$routes->post('login_from_zone_page', 'Auth::login_from_zone_page');
$routes->get('home/organization_login', 'Home::organization_login');
$routes->get('home/zone_login', 'Home::zone_login');
$routes->get('home/superadmin_login', 'Home::superadmin_login');
$routes->get('home/business_registration_authentication/(:any)', 'Home::business_registration_authentication/$1');
$routes->get('home/get_forgot_password/(:any)', 'Home::get_forgot_password/$1');
$routes->post('forgot_password', 'Home::forgot_password');
$routes->get('zip_to_zone/(:any)', 'Home::zip_to_zone/$1');
$routes->get('my_account', 'Zone::my_account');
$routes->get('claimdeals/(:any)', 'Ads::getpeekaboodeals/$1');
$routes->post('updateresidentshareurl', 'Ads::updateresidentshareurl');
$routes->get('get_certificate', 'Ads::get_certificate');
$routes->get('get_certificate_verify', 'Ads::get_certificate_verify');
$routes->get('get_forgot_password/(:any)', 'Welcome::get_forgot_password/$1');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('Zonedashboard/(:any)', 'Zonedashboard::zonedetail/$1');
$routes->get('Sponsor/(:any)', 'SponsorController::sponsordetail/$1');
$routes->get('Zonedashboard/zoneinfo/(:any)', 'Zonedashboard::zoneinfo/$1');
$routes->get('businessdashboard/(:any)', 'Businessdashboard::businessdetail/$1/$2');
$routes->get('explore_snap_business_data', 'Businessdashboard::explore_snap_business_data');
$routes->get('organizationdashboard/(:any)', 'Organizationdashboard::organizationdetail/$1/$2');
$routes->get('admin', 'Home::admin');
$routes->post('emailnoticeinsertdata', 'Emailnotice::emailnoticeinsertdata');
$routes->post('employeenoticeinsertdata', 'Emailnotice::employeenoticeinsertdata');
$routes->post('visitornoticeinsertdata', 'Emailnotice::visitornoticeinsertdata');
$routes->get('businessSearch/search/(:any)', 'BusinessSearch::searchnew/$1');
$routes->get('deals/(:any)', 'BusinessSearch::search/$1');
$routes->get('temp_ads', 'Ads::temp_ads');
$routes->get('stokalertmail','Ads::stokalertmail');
$routes->get('cart', 'BusinessSearch::cart');
$routes->post('addCart', 'BusinessSearch::addCart/$1');
$routes->post('change_status_type', 'BusinessSearch::change_status_type');
$routes->post('check_ig_display', 'Emailnotice::check_ig_display');
$routes->post('getfavres', 'BusinessSearch::getfavres');
$routes->post('checkEmail', 'BusinessSearch::checkEmail');
$routes->get('deal/(:any)', 'BusinessSearch::deal/$1');
$routes->post('save_notes', 'Online_delivery::save_notes');
$routes->post('sendEmail', 'BusinessSearch::sendEmail');
$routes->post('user_ig_insert', 'Emailnotice::user_ig_insert');
$routes->post('removeProductCart', 'BusinessSearch::removeProductCart');
$routes->get('thankyou', 'Zone::thankyou');
$routes->get('check_authentication', 'Auth::check_authentication');
$routes->post('Zonedashboard/update_profile', 'Zonedashboard::update_profile');
$routes->post('organizationdashboard/update_profile', 'Organizationdashboard::update_profile');
$routes->post('Zonedashboard/update_password', 'Zonedashboard::update_password');
$routes->post('banner_controller/save_zonelogo', 'Banner_controller::save_zonelogo');
$routes->post('banner_controller/save_buisnesslogo', 'Banner_controller::save_buisnesslogo');
$routes->post('Zonedashboard/change_theme', 'Zonedashboard::change_theme');
$routes->post('Zonedashboard/addDiscount', 'Zonedashboard::addDiscount');
$routes->get('Zonedashboard/create_generate_password_org', 'Zonedashboard::create_generate_password_org');
$routes->post('Zonedashboard/category_for_create_business', 'Zonedashboard::category_for_create_business');
$routes->post('Zonedashboard/subcat_for_create_businessnew', 'Zonedashboard::subcat_for_create_businessnew');
$routes->post('Zonedashboard/upload_business_greetings', 'Zonedashboard::upload_business_greetings');
$routes->post('Zonedashboard/create_business', 'Zonedashboard::create_business');
$routes->post('Zonedashboard/all_business_by_filtering', 'Zonedashboard::all_business_by_filtering');
$routes->get('Zonedashboard/listofcategory', 'Zonedashboard::listofcategory');
$routes->get('Zonedashboard/listofsubcategory', 'Zonedashboard::listofsubcategory');
// $routes->post('getMyZoneBusiness', 'Zonedashboard::getMyZoneBusiness');
$routes->post('getMyZoneBusiness', 'Businessdashboard::getMyZoneBusiness');
$routes->post('Zonedashboard/deal_reschedule', 'Zonedashboard::deal_reschedule');
$routes->post('Zonedashboard/alldeal_reschedule', 'Zonedashboard::alldeal_reschedule');
$routes->post('Businessdashboard/insert_deals', 'Businessdashboard::insert_deals');
$routes->post('Businessdashboard/upload_deal_list', 'Businessdashboard::upload_deal_list');
$routes->post('Businessdashboard/publisher_fee', 'Businessdashboard::publisher_fee');
$routes->get('Businessdashboard/editdealdata', 'Businessdashboard::editdealdata');
$routes->get('Businessdashboard/showdealdata', 'Businessdashboard::showdealdata');
$routes->post('Zonedashboard/saveawskeys', 'Zonedashboard::saveawskeys');
$routes->post('Zonedashboard/saveawssponser', 'Zonedashboard::saveawssponser');
$routes->post('saveSponser', 'Zonedashboard::saveSponser');
$routes->post('savebusinesssponserbanner', 'SponsorController::savebusinesssponserbanner');
$routes->post('editSponser', 'Zonedashboard::editSponser');
$routes->post('Zonedashboard/addemailformat', 'Zonedashboard::addemailformat');
$routes->post('Zonedashboard/searchBusinessads', 'Zonedashboard::searchBusinessads');
$routes->post('Zonedashboard/sendEmailSnapONUSer', 'Zonedashboard::sendEmailSnapONUSer');
$routes->post('Zonedashboard/edit_sub_category_display', 'Zonedashboard::edit_sub_category_display');
$routes->post('Zonedashboard/sponser_business_reorder', 'Zonedashboard::sponser_business_reorder');
$routes->post('Zonedashboard/sponser_business_reorder_cat', 'Zonedashboard::sponser_business_reorder_cat');
$routes->post('Zonedashboard/save_zone_sub_cat_display', 'Zonedashboard::save_zone_sub_cat_display');
$routes->post('Zonedashboard/get_ordered_sponsored_business_data', 'Zonedashboard::get_ordered_sponsored_business_data');
$routes->post('refer_generate', 'Zone::refer_generate_mail');
$routes->post('qr_generate_email', 'Zone::qr_generate_email');
$routes->post('Zonedashboard/save_zone_cat_display', 'Zonedashboard::save_zone_cat_display');
$routes->post('Zonedashboard/get_refer_link', 'Zonedashboard::get_refer_link');
$routes->post('UploadImage/(:any)', 'CommonController::Uploadimage/$1/$2');
$routes->post('changetheme', 'BusinessSearch::changetheme');
$routes->get('Businessdashboard/check_title', 'Businessdashboard::check_title');
$routes->post('Businessdashboard/savead', 'Businessdashboard::savead');
$routes->post('deleteAd', 'Businessdashboard::deleteAd');
$routes->get('editad/(:any)', 'Businessdashboard::editad/$1/$2/$3/$4');
$routes->get('businessdetail/(:any)', 'Business::businessdetail/$1');
$routes->post('Zonedashboard/update_paypal_accounting_setting', 'Zonedashboard::update_paypal_accounting_setting');
$routes->post('update_businessprofile', 'Businessdashboard::update_businessprofile');
$routes->post('UpdateBusinessPassword', 'Businessdashboard::UpdateBusinessPassword');
$routes->get('import', 'CsvController::Import');
$routes->post('csvimportcount', 'CsvController::csvimportcount');
$routes->post('csvimport', 'CsvController::csvimport');
$routes->post('csvimportorganization', 'CsvController::csvimportorganization');
$routes->get('csvsample', 'CsvController::csvsample');
$routes->post('getbusinesscount', 'CsvController::getbusinesscount');
$routes->post('delbusinessdata', 'CsvController::delbusinessdata');
$routes->post('csvimportmap', 'CsvController::csvimportmap');
$routes->get('import/map', 'CsvController::map');
$routes->get('downloadcsv', 'CommonController::downloadcsv');
$routes->get('downloaddonationclaimcsv', 'CommonController::downloaddonationclaimcsv');
$routes->get('csvdownload', 'CsvController::download_error_csv');
$routes->get('checkexistsbid', 'Zonedashboard::checkexistsbid');
$routes->get('categorysort', 'Zonedashboard::get_ordered_sponsored_business_data_category_sort');
$routes->get('getclaimfeereport', 'Zonedashboard::getclaimfeereport');
$routes->get('show_allcategoryorg', 'Announcements::show_allcategory');
$routes->post('save_org_photo', 'Organizationdashboard::save_org_photo');
$routes->post('updateperdetail', 'Organizationdashboard::updateorgperdetail');
$routes->get('short_url/(:any)', 'Zone::my_deal/$1/$2/$3/$4');
$routes->get('offer', 'Zone::offfernewpage');
$routes->get('saveNonFavPer', 'Zonedashboard::saveNonFavPer');
$routes->get('downloadorgcsv', 'CommonController::downloadorgcsv');
$routes->get('rankbusiness/(:any)', 'CronController::rankbusiness/$1');
$routes->get('rankSubCatbusiness/(:any)', 'CronController::rankSubCatbusiness/$1');
$routes->get('view_org_photo', 'Organizationdashboard::org_photo_by_catid');
$routes->post('update_org_photo', 'Organizationdashboard::update_org_photo');
$routes->post('delete_org_photo', 'Organizationdashboard::delete_org_photo');
$routes->post('save_webinar_link', 'Organizationdashboard::save_webinar_link');
$routes->get('viewmorewebinar', 'Organizationdashboard::viewmorewebinar');
$routes->post('update_webinar_link', 'Organizationdashboard::update_webinar_link');
$routes->post('delete_webinar', 'Organizationdashboard::delete_webinar');
$routes->post('save_group', 'Emailnotice::save_group');
$routes->get('display_ig', 'Emailnotice::display_ig');
$routes->post('delete_group', 'Emailnotice::delete_group');
$routes->post('save_category', 'Announcements::save_category');
$routes->get('getallcategory', 'Announcements::getallcategory1');
$routes->post('edit_category', 'Announcements::edit_category');
$routes->post('delete_category', 'Announcements::delete_category');
$routes->post('save_org', 'Announcements::save_org');
$routes->get('viewmoreannouncement', 'Organizationdashboard::viewmoreannouncement');
$routes->post('delete_org', 'Announcements::delete_org');
$routes->post('save_broadcast', 'Announcements::save_broadcast');
$routes->post('delete_broadcast', 'Announcements::delete_broadcast');
$routes->post('updatejotformcodes', 'Zonedashboard::updatejotformcodes');
$routes->post('pboo_account_details', 'Organizationdashboard::pboo_account_details');
$routes->get('speradsheet_list_data/(:any)', 'Organizationdashboard::speradsheet_list_data/$1/$2');
$routes->post('getOrder', 'Api::getOrder');
$routes->get('allorderApprovals', 'Businessdashboard::allorderApprovals');
$routes->post('setorderApprovals', 'Businessdashboard::setorderApprovals');
$routes->post('setorderreject', 'Businessdashboard::setorderreject');
$routes->post('save_record_audio', 'Businessdashboard::save_record_audio');
$routes->post('save_twilio_audio', 'Businessdashboard::save_twilio_audio');
$routes->get('get_audio_day', 'Businessdashboard::get_audio_day');
$routes->post('delete_audio_day', 'Businessdashboard::delete_audio_day');
$routes->get('get_all_audio', 'Businessdashboard::get_all_audio');
$routes->get('approvalstatus', 'BusinessSearch::approvalstatus');
$routes->post('Zonedashboard/refer_generate', 'Zonedashboard::refer_generate');
$routes->get('approvalcheck', 'Zone::approvalcheck');
$routes->post('dontshowmodalfree5', 'Zone::dontshowmodalfree5');
$routes->get('zonebusid_updt', 'Zonedashboard::zonebusid_updt');
// $routes->post('save_uploadaudio_businessdashboard', 'Businessdashboard::save_uploadaudio_day');


$routes->post('saveaudiomultiple', 'Businessdashboard::saveaudiomultiple');
$routes->get('savesubcatbusiness', 'Ads::savesubcatbusiness');
$routes->post('changesnapstatus', 'Ads::changesnapstatus');
$routes->get('singleloginmultiuser', 'CommonController::singleloginmultiuser');
$routes->post('save_sub_zoneuser', 'Zonedashboard::save_sub_zoneuser');
$routes->get('getcontactdetail', 'Welcome::getcontactdetail');
$routes->post('logintozone', 'Welcome::logintozone');
$routes->post('checktwilioaccount', 'TwilioController::checktwilioaccount');
$routes->post('addtwilioaccount', 'TwilioController::addtwilioaccount');
$routes->post('save_commumethod', 'Zonedashboard::save_commumethod');
$routes->post('save_blogumethod', 'Zonedashboard::save_blogumethod');
$routes->post('chnage_approvaldpa', 'Zonedashboard::chnage_approvaldpa');
$routes->get('downloadcsvdpa', 'Zonedashboard::downloadcsvdpa');
$routes->post('del_business', 'Zonedashboard::deletebuisness');
$routes->post('bidpendingaction', 'Zonedashboard::bidpendingaction');
$routes->post('rescheduleapprovedbus', 'Zonedashboard::rescheduleapprovedbus');
$routes->get('GETSUBCATEGORY', 'Zonedashboard::GETSUBCATEGORY');
$routes->post('genQR', 'QRController::add_data');
$routes->get('qrscan', 'Home::qrscan');
$routes->post('validateqrbusiness', 'Home::validateqrbusiness');
$routes->post('set1dealreferdata', 'CommonController::get1dealreferdata');
$routes->post('emailserversave', 'Zonedashboard::emailserversave');
$routes->post('checktestconnection', 'Zonedashboard::checktestconnection');
$routes->get('deltemailblgid', 'Zonedashboard::deltemailblgid');
$routes->get('newsevent', 'Zonedashboard::event_emailblog');
$routes->get('getemaildata', 'Home::getemaildata');

// $routes->post('sendEmail', 'BusinessSearch::sendEmail');
$routes->get('groceryStore', 'BusinessSearch::grocery_Store');
$routes->get('getgrocerydata', 'BusinessSearch::getgrocerydata');
$routes->get('showoffers', 'BusinessSearch::showoffers');
$routes->get('blogdetail', 'Home::blogdetail');
$routes->get('recoverpassword', 'Zone::recoverpassword');
$routes->post('recover_pass_set', 'Zone::recover_pass_set');
$routes->get('getzipcodes', 'Businessdashboard::getzipcodes');
$routes->post('updateshorturl', 'Businessdashboard::updateshorturl');
$routes->get('getorgcategoryimage', 'Organizationdashboard::getorgcatimage');
$routes->post('Zonedashboard/business_set', 'Zonedashboard::business_set');
$routes->post('editurlgrocerylink', 'Zonedashboard::editurlgrocerylink');
$routes->post('deleteurlgrocerylinkk', 'Zonedashboard::editurlgrocerylink');
$routes->get('Free5', 'Home::free5');
$routes->get('residents_email_template', 'Home::residents_email_template');
$routes->get('groceryStore', 'Home::groceryStore');
$routes->get('gov_email_template', 'Home::gov_email_template');
$routes->get('resident_email', 'Home::resident_email');
$routes->get('resident_info', 'Home::resident_info');
$routes->get('business_fraternal_orgs', 'Home::business_fraternal_orgs');
$routes->get('referral_letter', 'Home::referral_letter');
$routes->post('save_business_snap_filter', 'Businessdashboard::save_business_snap_filter');
$routes->get('getcountsnapuseremaillist', 'Businessdashboard::getcountsnapuseremaillist');
$routes->post('confirm_business_snap_filter', 'Businessdashboard::confirm_business_snap_filter');
$routes->post('sendsnapemailuser', 'Businessdashboard::sendsnapemailuser');
$routes->post('delete_business_snap_filter', 'Businessdashboard::delete_business_snap_filter');
$routes->post('save_user_snap_filter', 'Ads::save_user_snap_filter');
$routes->post('delete_user_snap_filter', 'Ads::delete_user_snap_filter');
$routes->get('get_saved_snap_customdata', 'Ads::get_saved_snap_customdata');
$routes->post('save_user_business_snap_filter', 'Emailnotice::save_user_business_snap_filter');
$routes->post('set_business_snap_status', 'BusinessSearch::set_business_snap_status');
$routes->post('set_business_user_snap_status', 'BusinessSearch::set_business_user_snap_status');
$routes->get('snapdealclaim', 'BusinessSearch::snapdealclaim');
$routes->post('getlocationdeal', 'BusinessSearch::getlocationdeal');
$routes->get('getzonebusiness', 'CommonController::getzonebusiness');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
