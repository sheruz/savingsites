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
$routes->get('/', 'Home::index');
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
$routes->post('businessdashboard_update', 'Auth::businessdashboard_update');
$routes->get('fetchMyAccountData', 'Ads::fetchMyAccountData');
$routes->post('myaccount_update', 'Ads::profile_update');
$routes->post('zone/(:any)', 'Zone::profile_update');
$routes->get('home/organization_registration/(:any)', 'Home::organization_registration/$1');
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
$routes->get('zone/my_account/(:any)', 'Zone::my_account/$1');
$routes->get('claimdeals/(:any)', 'Ads::getpeekaboodeals/$1');
$routes->get('get_certificate', 'Ads::get_certificate');
$routes->get('get_certificate_verify', 'Ads::get_certificate_verify');
$routes->get('zone/(:any)', 'Zone::load/$1/$2/$3');
$routes->get('get_forgot_password/(:any)', 'Welcome::get_forgot_password/$1');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('Zonedashboard/zonedetail/(:any)', 'Zonedashboard::zonedetail/$1');
$routes->get('businessdashboard/businessdetail/(:any)', 'Businessdashboard::businessdetail/$1');
$routes->get('organizationdashboard/organizationdetail/(:any)', 'Organizationdashboard::organizationdetail/$1');
$routes->get('admin', 'Home::admin');
$routes->post('emailnoticeinsertdata', 'Emailnotice::emailnoticeinsertdata');
$routes->get('businessSearch/search/(:any)', 'BusinessSearch::searchnew/$1');
$routes->get('deals/(:any)', 'BusinessSearch::search/$1');
$routes->get('temp_ads', 'Ads::temp_ads');
$routes->get('businessSearch/cart/(:any)', 'BusinessSearch::cart/$1');
$routes->post('addCart', 'BusinessSearch::addCart/$1');
$routes->post('change_status_type', 'BusinessSearch::change_status_type');
$routes->post('check_ig_display', 'Emailnotice::check_ig_display');
$routes->post('getfavres', 'BusinessSearch::getfavres');
$routes->post('checkEmail', 'BusinessSearch::checkEmail');
$routes->post('save_notes', 'Online_delivery::save_notes');
$routes->post('sendEmail', 'BusinessSearch::sendEmail');
$routes->post('user_ig_insert', 'Emailnotice::user_ig_insert');
$routes->post('removeProductCart', 'BusinessSearch::removeProductCart');
$routes->get('thankyou/(:any)', 'Zone::thankyou/$1');
$routes->get('check_authentication', 'Auth::check_authentication');
$routes->post('Zonedashboard/update_profile', 'Zonedashboard::update_profile');
$routes->post('organizationdashboard/update_profile', 'Organizationdashboard::update_profile');
$routes->post('Zonedashboard/update_password', 'Zonedashboard::update_password');
$routes->post('banner_controller/save_zonelogo', 'Banner_controller::save_zonelogo');
$routes->post('banner_controller/save_buisnesslogo', 'Banner_controller::save_buisnesslogo');
$routes->post('Zonedashboard/change_theme', 'Zonedashboard::change_theme');
$routes->post('Zonedashboard/addDiscount', 'Zonedashboard::addDiscount');
$routes->get('Zonedashboard/create_generate_password_org', 'Zonedashboard::create_generate_password_org');
$routes->get('Zonedashboard/category_for_create_business', 'Zonedashboard::category_for_create_business');
$routes->get('Zonedashboard/subcat_for_create_businessnew', 'Zonedashboard::subcat_for_create_businessnew');
$routes->post('Zonedashboard/upload_business_greetings', 'Zonedashboard::upload_business_greetings');
$routes->post('Zonedashboard/create_business', 'Zonedashboard::create_business');
$routes->post('Zonedashboard/all_business_by_filtering', 'Zonedashboard::all_business_by_filtering');
$routes->get('Zonedashboard/listofcategory', 'Zonedashboard::listofcategory');
$routes->get('Zonedashboard/listofsubcategory', 'Zonedashboard::listofsubcategory');
$routes->get('Zonedashboard/getMyZoneBusiness', 'Zonedashboard::getMyZoneBusiness');
$routes->post('Zonedashboard/deal_reschedule', 'Zonedashboard::deal_reschedule');
$routes->post('Zonedashboard/alldeal_reschedule', 'Zonedashboard::alldeal_reschedule');
$routes->post('Businessdashboard/insert_deals', 'Businessdashboard::insert_deals');
$routes->post('Businessdashboard/upload_deal_list', 'Businessdashboard::upload_deal_list');
$routes->post('Businessdashboard/publisher_fee', 'Businessdashboard::publisher_fee');
$routes->get('Businessdashboard/editdealdata', 'Businessdashboard::editdealdata');
$routes->get('Businessdashboard/showdealdata', 'Businessdashboard::showdealdata');
$routes->post('Zonedashboard/saveawskeys', 'Zonedashboard::saveawskeys');
$routes->post('Zonedashboard/addemailformat', 'Zonedashboard::addemailformat');
$routes->post('Zonedashboard/searchBusinessads', 'Zonedashboard::searchBusinessads');
$routes->post('Zonedashboard/sendEmailSnapONUSer', 'Zonedashboard::sendEmailSnapONUSer');
$routes->post('Zonedashboard/edit_sub_category_display', 'Zonedashboard::edit_sub_category_display');
$routes->post('Zonedashboard/sponser_business_reorder', 'Zonedashboard::sponser_business_reorder');
$routes->post('Zonedashboard/sponser_business_reorder_cat', 'Zonedashboard::sponser_business_reorder_cat');
$routes->post('Zonedashboard/save_zone_sub_cat_display', 'Zonedashboard::save_zone_sub_cat_display');
$routes->post('Zonedashboard/get_ordered_sponsored_business_data', 'Zonedashboard::get_ordered_sponsored_business_data');
$routes->post('refer_generate', 'Zone::refer_generate_mail');
$routes->post('Zonedashboard/save_zone_cat_display', 'Zonedashboard::save_zone_cat_display');
$routes->get('Zonedashboard/get_refer_link', 'Zonedashboard::get_refer_link');
$routes->post('UploadImage/(:any)', 'CommonController::Uploadimage/$1/$2');
$routes->post('changetheme', 'BusinessSearch::changetheme');
$routes->get('Businessdashboard/check_title', 'Businessdashboard::check_title');
$routes->post('Businessdashboard/savead', 'Businessdashboard::savead');
$routes->post('deleteAd', 'Businessdashboard::deleteAd');
$routes->get('editad/(:any)', 'Businessdashboard::editad/$1/$2/$3/$4');
$routes->get('business/businessdetail/(:any)', 'Business::businessdetail/$1/$2');
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
$routes->get('scrap', 'ScrapController::scrap');
$routes->post('checkuserpassscrap', 'ScrapController::checkuserpass');
$routes->get('welcome', 'ScrapController::welcome');
$routes->get('scrap/macrononfoodcsv', 'ScrapController::macrononfoodcsv');
$routes->get('scrap/macrofoodcsv', 'ScrapController::macrofoodcsv');
$routes->get('scrap/users', 'ScrapController::users');
$routes->get('scrap/incomingemail', 'ScrapController::incomingemail');
$routes->post('logintozone', 'ScrapController::logintozone');
$routes->get('scrap/create_zone', 'ScrapController::create_zone');
$routes->get('scrap/scrapchat', 'ScrapController::scrapchat');
$routes->post('create_zone_users', 'ScrapController::create_zone_users');
$routes->post('reassignzip', 'ScrapController::reassignzip');
$routes->get('scrap/deals', 'ScrapController::deals');
$routes->get('scrap/projects', 'ScrapController::projects');
$routes->get('scrap/uploadImage', 'ScrapController::uploadImage');
$routes->get('scrap/uploadtoAWS', 'ScrapController::uploadtoAWS');
$routes->get('scrap/emailhistory', 'ScrapController::emailhistory');
$routes->get('uploadimagefunction', 'ScrapController::uploadimagefunction');
$routes->post('scrapupdateimage', 'ScrapController::scrapupdateimage');
$routes->post('scrapcategory', 'ScrapController::scrapcategory');
$routes->post('scrapImageUpdate', 'ScrapController::scrapImageUpdate');
$routes->post('scrapdelimage', 'ScrapController::scrapdelimage');
$routes->get('scrap/imagecategory', 'ScrapController::imagecategory');
$routes->get('fetchcategory', 'ScrapController::fetchcategory');
$routes->post('insertupdatecategory', 'ScrapController::insertupdatecategory');
$routes->post('insertscrapimage', 'ScrapController::insertscrapimage');
$routes->post('insertscrapawsimage', 'ScrapController::insertscrapawsimage');
$routes->post('insertscrapawsimageinsert', 'ScrapController::insertscrapawsimageinsert');
$routes->post('insertscrapmacrocsv', 'ScrapController::insertscrapmacrocsv');
$routes->post('insertscrapmacrofoodcsv', 'ScrapController::insertscrapmacrofoodcsv');
$routes->get('setdatatogencsvnonfood', 'ScrapController::setdatatogencsvnonfood');
$routes->get('setdatatogencsvfood', 'ScrapController::setdatatogencsvfood');
$routes->get('scrap/CatSubCategoryImage', 'ScrapController::CatSubCategoryImage');
$routes->get('getscrapsubcategory', 'ScrapController::getscrapsubcategory');
$routes->post('insertscrapimagecatsubcat', 'ScrapController::insertscrapimagecatsubcat');
$routes->get('fetchscrapcatsubimage', 'ScrapController::fetchscrapcatsubimage');
$routes->get('cron/dealsnotification', 'CronController::dealsnotification');

/*automate calls */
$routes->get('makecalls', 'TwilioController::makecalls');
$routes->get('IVR', 'TwilioController::IVR');
$routes->get('makemessage', 'TwilioController::makemessage');
$routes->post('approvedealoncall', 'TwilioController::approvedealoncall');
$routes->post('rejectdealoncall', 'TwilioController::rejectdealoncall');
$routes->get('generatePDF', 'TwilioController::generatePDF');
$routes->post('checktwilioaccount', 'TwilioController::checktwilioaccount');
$routes->get('commonimage', 'Images::index');
$routes->get('getimage', 'Images::getimage');
$routes->get('loadCat', 'Images::loadCat');
$routes->get('resize', 'ScrapController::resize'); //testing
$routes->post('setemailhistory', 'ScrapController::setemailhistory');
$routes->get('getemailhistory', 'ScrapController::getemailhistory');
$routes->post('delemail', 'ScrapController::delemail');
$routes->post('getchatresponse', 'ScrapController::getchatresponse');
$routes->get('testcron', 'ScrapController::testcron');
$routes->get('testservertimedate', 'ScrapController::testservertimedate');
$routes->get('webnotification', 'Home::webnotification');
$routes->get('getnotificationdata', 'Home::getnotificationdata');
$routes->get('blog', 'Home::blog');
$routes->get('blogdetail', 'Home::blogdetail');
$routes->get('getemaildata', 'Home::getemaildata');
$routes->get('createawsfolder', 'ScrapController::createawsfolder');
$routes->get('recoverpassword', 'ScrapController::recoverpassword');
$routes->post('recover_pass_set', 'ScrapController::recover_pass_set');
$routes->get('Free5', 'Home::free5');
$routes->get('uploadorganization', 'CsvController::uploadorganization');
$routes->get('residents_email_template', 'Home::residents_email_template');
$routes->get('groceryStore', 'Home::groceryStore');
$routes->get('gov_email_template', 'Home::gov_email_template');
$routes->get('resident_email', 'Home::resident_email');
$routes->get('resident_info', 'Home::resident_info');
$routes->get('business_fraternal_orgs', 'Home::business_fraternal_orgs');
$routes->get('referral_letter', 'Home::referral_letter');
$routes->get('delete_zone', 'CommonController::delete_zone');

/*automate calls */

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
