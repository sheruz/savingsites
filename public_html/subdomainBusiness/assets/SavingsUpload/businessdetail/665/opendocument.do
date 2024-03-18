




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8, requiresActiveX=true" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<script>

    var COLLECTION_CONFIRM_LOCK_UNLOCK='Are you sure of locking/unlocking collection';
    var COLLECTION_UNLOCK='Unlock';
    var COLLECTION_LOCK='Lock';
    var COLLECTION_SHARE_BOLD='Share';
    var COLLECTION_SHARE='Share';
    var COLLECTION_CONFIRM_DELETE='Are you sure you want to delete the collection?';
    var CONTACT_MESSAGE_DUPLICATE_NAME='is already your contact';
    var CONTACT_MESSAGE_DELETE_CONFIRM='This contact is a part of Group(s)';
    var CONTACT_MESSAGE_DELETE_CONFIRM2='Are you sure you want to delete this contact?';
    var GROUP_MESSAGE_DUPLICATE_NAME='Group already exists.';
    var GROUP_MESSAGE_DELETE_CONFIRM='Are you sure you want to delete the group?';
    var TAG_MESSAGE_DUPLICATE_NAME='Duplicate value, Tag with same name already exists.';
    var TAG_RENAME='Rename';
    var TAG_TO='To ...';
    var TAG_RENAME_TO='Renamed to';
    var TAG_EDIT='Edit';
    var TAG_ITEMS_TAGGED_WITH='items are tagged with';
    var TAG_CONFIRM_DELETE='';
    var SETUP_SOURCE_FOLDER_INCLUDE='Include';
    var PASSWORD_CONFIRM_PASSWORD_ERROR = 'Password and Confirm Password should be same.';
    var PASSWORD_SAME_ERROR = 'The new password cannot be the same as your old password.';
    var EMAIL_CONFIRM_EMAIL_ERROR = 'Email and Confirm Email should be same.';
    var NULL_USER_PROFILE_ERROR = 'frmUserProfile is NULL.';
    var BLANK_FOLDERNAME_PATH_ERROR = 'folderPath cannot be blank';
    var SOURCE_COMPULSORY_FIELDS_ERROR = 'Username/Password/SourceName cannot be blank.';
	var WORKGRP_DET_COMPULSORY_FIELDS_ERROR = 'Company Name/Custom Site Address/Phone Number cannot be blank.';
	var BILLING_DET_COMPULSORY_FIELDS_ERROR = 'Billing Information cannot be blank.';

	var INVALID_CREDITCARD_NUMBER = 'Invalid credit card number.';
	var INVALID_CVV_NUMBER = 'Invalid CVV number.';
	var CREDITCARD_EXPIRED = 'Credit card has expired.';

    var NEW_USER_COMPULSORY_FIELDS_ERROR = 'Username/FirstName/LastName/Email for the new power user cannot be blank.';
    var NEW_WG_USER_COMPULSORY_FIELDS_ERROR = 'Password, Confirm Password, Email for the new Workgroup user cannot be empty.';
    var ADD_GUEST_COMPULSORY_FIELDS_ERROR = 'Email, Subject, Message for the new guest user cannot be blank.';
    var SOURCENAME_COMPULSORY_FIELD_ERROR = 'SourceName cannot be blank.';
    var GLOBAL_YES = 'Yes';
    var GLOBAL_NO = 'No';
    var GLOBAL_ON = 'On';
    var GLOBAL_OFF = 'Off';
    var PORT_NUMERIC_ERROR = 'Incoming Port/Outgoing Port should be numeric.';
    var NO_RECORD_FOUND= 'no&nbsp;results&nbsp;found';
    var RECORD_PREVIOUS= 'Previous';
    var RECORD_NEXT= 'Next';
    var MSOUTLOOK= 'MS Outlook';
    var NEW_INDIVIDUAL_COMPULSORY_FIELDS_ERROR = 'Email for the new Individual cannot be blank.';
    var YOUR_SEARCH= 'Your&nbsp;Search';
    var YOUR_NO_RESULTS_SEARCH= 'No&nbsp;results&nbsp;found&nbsp;for&nbsp;Your&nbsp;Search';

    var NO_SHARED_COLL_FROM= 'No&nbsp;shared&nbsp;views&nbsp;from&nbsp;';
    var NO_SHARED_COLL_FROM_ANY_USER_IN= 'No&nbsp;shared&nbsp;views&nbsp;from&nbsp;any&nbsp;user&nbsp;in&nbsp;';

    var FIRSTNAME_FIELD_ERROR= 'FirstName cannot be blank.';
    var LASTNAME_FIELD_ERROR= 'LastName cannot be blank.';
    var EMAIL_FIELD_ERROR= 'Email cannot be blank.';
    var PASSWORD_FIELD_ERROR= 'Password cannot be blank.';
    var PHONENUMBER_FIELD_ERROR= 'Phone Number cannot be blank.';
    var USERNAME_FIELD_ERROR= 'Username cannot be blank.';
    var CONFIRMPASSWORD_FIELD_ERROR= 'Confirm Password cannot be blank.';
    var CUSTOMSITE_FIELD_ERROR= 'Custom Site Address cannot be blank.';
    var CONFIRMCUSTOMSITE_FIELD_ERROR= 'Confirm Custom Site Address cannot be blank.';

    var COMPANYNAME_FIELD_ERROR='Company Name cannot be blank.';
    var PHONENUMBER_FIELD_ERROR='Phone Number cannot be blank.';

   	var SUBDOMAIN_CONFIRM_SUBDOMAIN_ERROR='Custom Site Address and Confirm Custom Site Address should be same.';
	var SUBDOMAIN_SUBDOMAIN_SPACE_ERROR='Spaces cannot be used in the custom site address. Please enter one without spaces.';

   	var CARDNUMBER_FIELD_ERROR= 'Credit Card Number cannot be blank.';
    var CARDTYPE_FIELD_ERROR= 'Credit Card Type cannot be blank.';
    var ZIPCODE_FIELD_ERROR= 'Zip Code cannot be blank.';
    var BILLINGNAME_FIELD_ERROR= 'Billing Name cannot be blank.';
    var CVVNUMBER_FIELD_ERROR= 'CVV Number cannot be blank.';
    var CARDEXPIRATIONMONTH_FIELD_ERROR= 'Card Expiration Month cannot be blank.';
   	var STREETADDRESS_FIELD_ERROR='Street Address cannot be blank.';

    var USERNAME= 'Username';
    var INVALID_DATE_ERROR = 'You must enter a valid date.';
    var DATE_COMPARISON_ERROR = 'From date is greater than to date';
    var SESSION_TIMED_OUT_ERROR = 'Your session is timed out/You are not logged in. Please login again.';
    var PASSWORD_EMAIL_CHANGED = 'Password and Email has been changed.';
    var PASSWORD_CHANGED = 'Password has been changed.';
    var EMAIL_CHANGED = 'Email has been changed.';
    var USER_AS_CONTACT_ERROR = 'You cannot create yourself as a contact.';
    var FEEDBACK_BLANK_ERROR = 'Feedback subject/message cannot be blank.';
    var NO_COLLECTIONS_MANAGE = 'No&nbsp;Collections&nbsp;to&nbsp;manage.';
    var TAGS_TITLE = 'Tag(s)';
    var ALREADY_EXISTS = 'already exists.';
    var INVITE_MESSAGE= 'Invite a Contact';
    var INVITE_BLANK_ERROR = 'to/subject/message cannot be blank.';
    var INVITE_HEADING = 'Invite a Contact';
    var FEEDBACK_HEADING = 'Send Feedback';
    var INVITE_CONFIRMATION= 'Invitation sent successfully.';
    var FEEDBACK_CONFIRMATION = 'Feedback sent successfully.';
    var PASSWORD_LENGTH_MESSAGE = 'Password should be at least {0} characters.';
    var INVALID_EMAIL_ADDRESS = 'Invalid email address.';
    var INVALID_EMAIL_ADDRESS_AS_USER_NAME = 'User Name should be a valid email address.';
    var DEFAULT_EMAIL_MESSAGE = 'Sign up for Egnyte.';
    var ALL = 'all';
    var SELECTED = 'selected';
    var DOCUMENT_SOURCE_MESSAGE1 = 'Setup your document sources using the Create document Sources link above. (A document source is a file system on a laptop or desktop).';
    var DOCUMENT_SOURCE_MESSAGE2 = 'Once you define a document source,download the "Egnyte Uploader" onto that source computer by clicking link below.';
    var DOCUMENT_SOURCE_MESSAGE3 = 'You must also indicate the folders within the source computer from which Egnyte should upload data. If you know your full folder path, define it using the &quot;Add Folder&quot; link above. Alternately, you can also indicate the folder by marking it in Windows Explorer. This requires that you download the "Egnyte Uploader". Then select a folder within Windows explorer, right click & choose the &quot;Upload to Egnyte&quot; menu entry.';
    var EMAIL_SOURCE_MESSAGE1 = 'Setup your Email sources using the Create Email Sources link above. An email source must be a computer running Outlook or any POP enabled email.';
    var EMAIL_SOURCE_MESSAGE2 = 'If you define an Outlook Email source,download the "Egnyte Uploader" onto that source computer by clicking link below. If Outlook is running on a computer that you will define as a document source, then only one download is necessary.';
    var EMAIL_SOURCE_MESSAGE3 = 'No download is needed for POP enabled email sources.';
    var EMAIL_SOURCE_MESSAGE4 = 'You must also indicate the folders within the email system from which Egnyte should upload data. If you know your full folder path, define it using the &quot;Add Folder&quot; link above. Alternately, you can also indicate the folder by marking it in Outlook. This requires that you first download the "Egnyte Uploader"; then select a folder within Outlook, right click & choose the &quot;Upload to Egnyte&quot; menu entry.';
    var EMAIL_CLIENT_ERROR = 'Select Email type.';
    var SELECT_EMAIL_CLIENT = 'Select Email Client';
    var WELCOME_MESSAGE = 'Welcome to Egnyte. To start using the application, please follow instructions on this page.';
    var AUTHENTICATION_ERROR = 'Invalid Username/password. Try again.';
    var LOGIN_COMPULSORY_FIELDS_ERROR = 'Username/Password cannot be blank.';
    var USER_NAME = 'User&nbsp;Name';
    var USERNAME_BLANK_MESSAGE = 'Username cannot be blank.';
    var ACTIVATE_TITLE = 'Turn on Upload from this Location';
    var DEACTIVATE_TITLE = 'Turn off Upload from this Location';
    var POP_COMPLETE_MESSAGE1 = 'Thank you, your email account has now been configured.';
    var POP_COMPLETE_MESSAGE2 = 'Since this is the first time Egnyte will upload data from this account, this may take a while. <img src="images/icons/exclamation.GIF"/><b><font color="#FF0000">You will be notified via email when your data is uploaded and ready for use.</font></b>';
    var INVALID_NOTIFICATION_FREQUENCY_ERROR = 'Choose a frequency between 5 mins and 24 hrs';
    var INVALID_REVESION_COUNT_ERROR = 'should be a number and greater than zero';
    var INVALID_REVESION_EXPIRY_ERROR = 'Version validity days should be a number and greater than zero';

    var USER_MARKED_AS_DELETED = 'User is marked to be deleted';
    var WORKGROUP_NAME_INVALID_ERROR = 'Workgroup Name can not be blank.';
    var WORKGROUP_DESC_INVALID_ERROR = 'Workgroup Description can not be blank.';
    var WORKGROUP_MEMBER_NUMBER_INVALID_ERROR = 'Select max members for workgroup.';
    var WORKGROUP_CANNOT_DELETE_YOURSELF = 'You can not remove yourself.';
    var WORKGROUP_ALREADY_A_PERMANENT_MEMBER = 'is already a permanent workgoup member';
    var WORKGROUP_EGNYTE_MEMBER_ADD_AS_GUEST = 'is already an egnyte member. Do you want to add him as a user?';
    var WORKGROUP_ALREADY_A_GUEST = 'is already a workgroup guest';
    var WORKGROUP_INVITATION_PENDING_ADD_AS_MEMBER = 'is already  Invitation pending guest in this workgroup. Do you want to add him as Workgroup Member?';
    var WORKGROUP_WORKGROUP_MEMBER_ADD_AS_GUEST = 'is already a permanent member of some other workgroup. Do you want to add him as a user?';

    var SHARED_SPACE_SAVED = 'Shared view has been saved.';
    var SHARED_SPACE_DELETE_MESSAGE_CONFIRM = 'Are you sure you want to delete the shared view?';
    var DELETING_SHARED_SPACE = 'Deleting shared view';
    var SHARED_SPACE_DELETED = 'Shared view deleted.';
    var SHARED_SPACE_NAME_BLANK_ERROR = 'Please enter shared view name';
    var CRITERIA_BLANK_ERROR = 'Select at least one criteria for creating the shared view.';
    var GROUP_SPACE_ASSOCIATION_MSG = 'This group is associated with shared view(s).';
    var CONTACT_GROUP_SPACE_ASSOCIATION_MSG = 'This contact is associated with group(s) and shared view(s).';
    var CONTACT_GROUP_ASSOCIATION_MSG = 'This contact is associated with group(s).';
    var CONTACT_SPACE_ASSOCIATION_MSG = 'This contact is associated with shared view(s).';
    var NO_SPACE_TO_APPEND_MSG = 'No shared view to append';
    var DUPLICATE_SHARED_SPACE_MSG = 'Duplicate shared view name not allowed';
    var LOCATION_NAME = 'My Uploads';
    var FILE_UPLOADED_SUCCESS_MSG = 'File Uploaded to &quot;<font color="#FF6600">My Uploads</font>&quot; folder.';
    var FILES_UPLOADED_SUCCESS_MSG = 'Files Uploaded to &quot;<font color="#FF6600">My Uploads</font>&quot; folder.';
    var ERROR_UPLOADMSG_ALREADY_UPLOAD = '&nbsp;is already uploading... please wait..';
    var ERROR_UPLOADMSG_EMPTY_FILE = 'Please select a file first.';
    var ERROR_UPLOADMSG_DUPLY_FILE = 'Cannot upload the same file twice.';
    var ERROR_UPLOADMSG_FILE_MAX_LIMIT = 'File size is more than the maximum upload size allowed&nbsp;';
    var ERROR_UPLOADMSG_FILE_SIZE_ZERO = 'Can not upload the empty file.';
    var ERROR_UPLOADMSG_FAILURE_RESPONSE = 'Server could not process this file upload.';
	var ERROR_UPLOADMSG_NOTALLOWED_RESPONSE = 'Only .gif, .jpg and .jpeg formats are allowed.';
    var ERROR_UPLOADMSG_FILE_NOT_FOUND = 'Unable to locate file.';
    var ERROR_EMPTY_UPLOAD_CLICK = 'Nothing to Upload. Add Files before trying to Upload.';
	var ERROR_EMPTY_UPLOAD_CLICK_AGAIN = 'Please <font color="#CC0000">Add Files</font> before Uploading.';

    var DELETE_FOLDER_MESSAGE1 = 'This will delete folder';
    var DELETE_FOLDER_MESSAGE2 = 'from Egnyte. Delete anyway?';
    var DELETED_FOLDER_MESSAGE = 'Delete will occur within the next 24 hours.';

    var TAG_ALREADY_EXISTS_MESSAGE = 'This tag already exists in the shared view.';
    var FOLDER_ALREADY_EXISTS_MESSAGE = 'This folder already exists in the shared view.';
    var FILE_ALREADY_EXISTS_MESSAGE = 'These files already exists in the shared view -';
    var KEYWORD_ALREADY_EXISTS_MESSAGE = 'These keywords already exists in the shared view -';
    var RESTORE_STARTED_MSG = 'You will be notified by email when your zip file is ready for download.';
    var RESTORE_DEL_CONFIRM_MSG = 'You will not be able to download the file if this message disappears. Continue?';
    var COLLECTION_RETORE_CONFIRM_MSG = 'This will create a zip file containing all information from shared view';
    var FOLDER_RETORE_CONFIRM_MSG = 'This will create a zip file with all the information from the following folders:';
    var UNSHARING_READ_MESSAGE = 'Sharing will be removed for this group/contact. Remove anyway?';
    var UNSHARING_WRITE_MESSAGE = 'Any information from this group/contact in the Shared View will be removed. Remove anyway?';
    var WEBMAIL_ADDED_HOME_PAGE = 'You will be redirected to setup page.';
    var COMPUTER_ADDED_HOME_PAGE = 'Computer added.';
    var AFTER_UPLOAD_SEARCH_SHARE_MESSAGE = 'You have successfully uploaded data. You may now - <br/><br/><b>Search</b> your data using the search field above <br/>Create <b>Tags</b> below to classify your data <br/>Create a <b>Shared view</b> below to start sharing your data with your contacts.';
    var INCOMPLETE_SETUP_MESSAGE = 'To access this drive from Windows,  <a href="download.do"> install </a> the Egnyte Uploader.  <br/><br/><b><u>Note:</u></b> This will also let you backup personal computer folders into Egnyte.';

    var INCOMPLETE_COMPUTER_MESSAGE = 'There is already a computer that is not setup. Please set this up before creating another one.';
    var INCOMPLETE_POP_MESSAGE = 'pop account that is not setup. Please set this up before creating another one.';
    var NO_CHANGES_TO_SAVE_IN_COLLECTION_CRITERIA = 'No changes to save.';
    var NOTIFICATION_FREQUENCY_SET_TO = 'Notification frequency set to';
    var PASSWORD_AND_NOTIFICATION_FREQUENCY_CHANGED = 'Password has been changed and notification frequency set to';
    var RENAME_COMPUTER_POP_ACOUNT_ERROR = 'New name should not be blank.';
    var SEARCH_DESCRIPTION = 'Type your search term here';
    var ADD_CONTACT_MESSAGE='already uses Egnyte. An invitation will be sent to this user and you will be notified as soon as its accepted';
    var NO_HISTORY_MESSAGE='This file has not been accessed by anyone.';
    var SELREVISION_POLICY_CHANGED='Versioning rule updated.';
    var REQUSET_COMPANY_COMPULSORY_FIELDS_ERROR = 'First name/Last name/Email/Company name/Expected no. of power users cannot be blank.';
    var NO_ALPHA_USER_MESSAGE = 'You dont have to use this anymore. Please register for your personal egnyte account.';
    var CONTACT_US_CONFIRMATION = 'Egnyte Support has been notified and will contact you shortly.';
    var CONTACT_US_ERROR_MSG = 'First name/Last name/Email cannot be blank.';
    var ACK_CONTACTREQUEST_MSG = 'Please first acknowledge the invitation request of the contact.';
    var SMTP_TIMEOUT_MSG= 'Operation Timed out,Verify Mail Server and Mail Server Port.';
    var SMTP_CHECKPORT_MSG= 'Verify Mail Server Port.';
	var SMTP_ADDRESSVERIFY_MSG = 'Address Verification Error,Username and Sender Email must match.';
	var SMTP_TEMPORARILYUNAVAILABLE_MSG = 'Server temporarily unavailable, Please try again later.';
	var SMTP_UNABLETOCONNECT_MSG = 'Unable to connect to SMTP Server.';
	var SMTP_INVALID_HOST_MSG = 'Invalid SMTP host information.';
	var SMTP_INVALID_LOGIN_MSG = 'Invalid login information.';
	var SMTP_SUCCESS_MSG = 'SMTP settings verified successfully.';
	var SMTP_ERROR_MSG = 'Error sending email.';
	var GENERIC_ERROR_MSG = 'An error has occurred. Please contact customer support.';
	var DISABLE_POPUP_BLOCKER_MSG = 'Please disable popup blockers on your browser for egnyte.com and try again.';

    //	Account Management Messages
    var REQUIRED_GROUP_MEMBER_MESSAGE='Please add at least one member to the group.';
	var INTERNAL_LDAP_SET_MESSAGE = 'All users will now be authenticated against credentials setup within Egnyte. Note that users without password in Egnyte cannot login. You may setup password for users in <span class="object">Users & Groups</span>.';
	var EXTERNAL_LDAP_SET_MESSAGE = 'All users setup to be externally authenticated will now be authenticated against the specified directory server. You may specify users to be authenticated externally in <span class="object">Users & Groups</span>.';
	var ENTER_USNM_AND_PSWD_MESSAGE = 'Please enter both username and password to test the Active Directory settings.';
	var ENTER_ALL_AD_FIELDS_MESSAGE = 'Required fields to test the external directory service connection are missing.';
	var AD_TEST_AUTH_SUCCESS_MESSAGE = 'Test settings for external authentication verified successfully.';
	var AD_TEST_AUTH_FAILURE_MESSAGE = 'Test settings for external authentication failed.';
	var CONTACT_ADMINISTRATOR = 'Please contact your administrator';
	var MSG_RESETTING_GOOGLE_APP_ACCT='Resetting google apps account...';
	var MSG_RESET_GOOGLE_APP_ACCT_SUCCESS='Google apps account reset successfully.';
	var MSG_AD_NOT_SUPPORTED_IN_PLAN='Note that external directory service is not supported in the selected plan. You need to disable external authentication before changing plan.';
	var USER_SETTINGS_UPDATED_SUCCESSFULLY='User settings updated...';
	var MSG_TESTING_AD_SETTINGS='Testing settings...';
	var INVALID_BIND_DN = 'Please enter a valid BindDN.';
	var CONTACT_ACCT_ADMINISTRATOR = 'An email has been sent with your login instructions.Check your spam folder if you don&quot;t see the new email in your inbox.';
	var EXTERNAL_SAML_SETTINGS_UPDATED = 'All users setup to be Web SSO authenticated will now be authenticated against the specified Identity Provider. You may specify users to be Web SSO authenticated by Uploading the Mapping file or in <span class="object">Users & Groups</span>.';
	var EXTERNAL_SAML_SETTINGS_DISABLED = 'All users enabled for SAML SSO will not be authenticated against Identity Provider. You may setup password for users in <span class="object">Users & Groups</span>.';
	var MSG_SSO_NOT_SUPPORTED_IN_PLAN='Note that external authentication is not supported in the selected plan. You need to disable SSO before changing plan.';

</script>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="no-cache">
<link rel="icon" href="https://egnyte-www-static.egnyte.com/assets/images/favicon/favicon-32x32.png" sizes="32x32">


        <title>Egnyte Login</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge, requiresActiveX=true, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<meta name="robots" content="noindex,nofollow">

    <meta name="insight-app-sec-validation" content="0ef5e764-82c2-48d0-8645-b3729d1306bb">

    <link rel="icon" href="https://egnyte-www-static.egnyte.com/assets/images/favicon/favicon-32x32.png" sizes="32x32">

	

	<link href="/css/fonts/fonts.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
	<!-- _@aggregate_css_brn_@ -->
	<link rel="stylesheet" type="text/css" href="/css/login.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/colorbox.css" />
	<!-- _@aggregate_css_brn_@ -->
	<link rel="stylesheet" type="text/css" href="/css/simpleui-jq-theme/jquery-ui-1.8.16.custom.css" />
	<link rel="stylesheet" href="/css/plan_details_acctSettings.css" media="all"/>
	<link rel="stylesheet" type="text/css" href="/css/plan_details_change_plan_grid.css" />
	<link rel="stylesheet" type="text/css" href="/css/typofix.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/js/external/tooltipster/css/tooltipster-egnyte.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/newlogin.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/popupNotifier.css" media="all" />

	<!--[if IE 8.0]><link href="/css/ie8.css" type="text/css" media="screen" rel="stylesheet" /><![endif]-->

	<script>

    var COLLECTION_CONFIRM_LOCK_UNLOCK='Are you sure of locking/unlocking collection';
    var COLLECTION_UNLOCK='Unlock';
    var COLLECTION_LOCK='Lock';
    var COLLECTION_SHARE_BOLD='Share';
    var COLLECTION_SHARE='Share';
    var COLLECTION_CONFIRM_DELETE='Are you sure you want to delete the collection?';
    var CONTACT_MESSAGE_DUPLICATE_NAME='is already your contact';
    var CONTACT_MESSAGE_DELETE_CONFIRM='This contact is a part of Group(s)';
    var CONTACT_MESSAGE_DELETE_CONFIRM2='Are you sure you want to delete this contact?';
    var GROUP_MESSAGE_DUPLICATE_NAME='Group already exists.';
    var GROUP_MESSAGE_DELETE_CONFIRM='Are you sure you want to delete the group?';
    var TAG_MESSAGE_DUPLICATE_NAME='Duplicate value, Tag with same name already exists.';
    var TAG_RENAME='Rename';
    var TAG_TO='To ...';
    var TAG_RENAME_TO='Renamed to';
    var TAG_EDIT='Edit';
    var TAG_ITEMS_TAGGED_WITH='items are tagged with';
    var TAG_CONFIRM_DELETE='';
    var SETUP_SOURCE_FOLDER_INCLUDE='Include';
    var PASSWORD_CONFIRM_PASSWORD_ERROR = 'Password and Confirm Password should be same.';
    var PASSWORD_SAME_ERROR = 'The new password cannot be the same as your old password.';
    var EMAIL_CONFIRM_EMAIL_ERROR = 'Email and Confirm Email should be same.';
    var NULL_USER_PROFILE_ERROR = 'frmUserProfile is NULL.';
    var BLANK_FOLDERNAME_PATH_ERROR = 'folderPath cannot be blank';
    var SOURCE_COMPULSORY_FIELDS_ERROR = 'Username/Password/SourceName cannot be blank.';
	var WORKGRP_DET_COMPULSORY_FIELDS_ERROR = 'Company Name/Custom Site Address/Phone Number cannot be blank.';
	var BILLING_DET_COMPULSORY_FIELDS_ERROR = 'Billing Information cannot be blank.';

	var INVALID_CREDITCARD_NUMBER = 'Invalid credit card number.';
	var INVALID_CVV_NUMBER = 'Invalid CVV number.';
	var CREDITCARD_EXPIRED = 'Credit card has expired.';

    var NEW_USER_COMPULSORY_FIELDS_ERROR = 'Username/FirstName/LastName/Email for the new power user cannot be blank.';
    var NEW_WG_USER_COMPULSORY_FIELDS_ERROR = 'Password, Confirm Password, Email for the new Workgroup user cannot be empty.';
    var ADD_GUEST_COMPULSORY_FIELDS_ERROR = 'Email, Subject, Message for the new guest user cannot be blank.';
    var SOURCENAME_COMPULSORY_FIELD_ERROR = 'SourceName cannot be blank.';
    var GLOBAL_YES = 'Yes';
    var GLOBAL_NO = 'No';
    var GLOBAL_ON = 'On';
    var GLOBAL_OFF = 'Off';
    var PORT_NUMERIC_ERROR = 'Incoming Port/Outgoing Port should be numeric.';
    var NO_RECORD_FOUND= 'no&nbsp;results&nbsp;found';
    var RECORD_PREVIOUS= 'Previous';
    var RECORD_NEXT= 'Next';
    var MSOUTLOOK= 'MS Outlook';
    var NEW_INDIVIDUAL_COMPULSORY_FIELDS_ERROR = 'Email for the new Individual cannot be blank.';
    var YOUR_SEARCH= 'Your&nbsp;Search';
    var YOUR_NO_RESULTS_SEARCH= 'No&nbsp;results&nbsp;found&nbsp;for&nbsp;Your&nbsp;Search';

    var NO_SHARED_COLL_FROM= 'No&nbsp;shared&nbsp;views&nbsp;from&nbsp;';
    var NO_SHARED_COLL_FROM_ANY_USER_IN= 'No&nbsp;shared&nbsp;views&nbsp;from&nbsp;any&nbsp;user&nbsp;in&nbsp;';

    var FIRSTNAME_FIELD_ERROR= 'FirstName cannot be blank.';
    var LASTNAME_FIELD_ERROR= 'LastName cannot be blank.';
    var EMAIL_FIELD_ERROR= 'Email cannot be blank.';
    var PASSWORD_FIELD_ERROR= 'Password cannot be blank.';
    var PHONENUMBER_FIELD_ERROR= 'Phone Number cannot be blank.';
    var USERNAME_FIELD_ERROR= 'Username cannot be blank.';
    var CONFIRMPASSWORD_FIELD_ERROR= 'Confirm Password cannot be blank.';
    var CUSTOMSITE_FIELD_ERROR= 'Custom Site Address cannot be blank.';
    var CONFIRMCUSTOMSITE_FIELD_ERROR= 'Confirm Custom Site Address cannot be blank.';

    var COMPANYNAME_FIELD_ERROR='Company Name cannot be blank.';
    var PHONENUMBER_FIELD_ERROR='Phone Number cannot be blank.';

   	var SUBDOMAIN_CONFIRM_SUBDOMAIN_ERROR='Custom Site Address and Confirm Custom Site Address should be same.';
	var SUBDOMAIN_SUBDOMAIN_SPACE_ERROR='Spaces cannot be used in the custom site address. Please enter one without spaces.';

   	var CARDNUMBER_FIELD_ERROR= 'Credit Card Number cannot be blank.';
    var CARDTYPE_FIELD_ERROR= 'Credit Card Type cannot be blank.';
    var ZIPCODE_FIELD_ERROR= 'Zip Code cannot be blank.';
    var BILLINGNAME_FIELD_ERROR= 'Billing Name cannot be blank.';
    var CVVNUMBER_FIELD_ERROR= 'CVV Number cannot be blank.';
    var CARDEXPIRATIONMONTH_FIELD_ERROR= 'Card Expiration Month cannot be blank.';
   	var STREETADDRESS_FIELD_ERROR='Street Address cannot be blank.';

    var USERNAME= 'Username';
    var INVALID_DATE_ERROR = 'You must enter a valid date.';
    var DATE_COMPARISON_ERROR = 'From date is greater than to date';
    var SESSION_TIMED_OUT_ERROR = 'Your session is timed out/You are not logged in. Please login again.';
    var PASSWORD_EMAIL_CHANGED = 'Password and Email has been changed.';
    var PASSWORD_CHANGED = 'Password has been changed.';
    var EMAIL_CHANGED = 'Email has been changed.';
    var USER_AS_CONTACT_ERROR = 'You cannot create yourself as a contact.';
    var FEEDBACK_BLANK_ERROR = 'Feedback subject/message cannot be blank.';
    var NO_COLLECTIONS_MANAGE = 'No&nbsp;Collections&nbsp;to&nbsp;manage.';
    var TAGS_TITLE = 'Tag(s)';
    var ALREADY_EXISTS = 'already exists.';
    var INVITE_MESSAGE= 'Invite a Contact';
    var INVITE_BLANK_ERROR = 'to/subject/message cannot be blank.';
    var INVITE_HEADING = 'Invite a Contact';
    var FEEDBACK_HEADING = 'Send Feedback';
    var INVITE_CONFIRMATION= 'Invitation sent successfully.';
    var FEEDBACK_CONFIRMATION = 'Feedback sent successfully.';
    var PASSWORD_LENGTH_MESSAGE = 'Password should be at least {0} characters.';
    var INVALID_EMAIL_ADDRESS = 'Invalid email address.';
    var INVALID_EMAIL_ADDRESS_AS_USER_NAME = 'User Name should be a valid email address.';
    var DEFAULT_EMAIL_MESSAGE = 'Sign up for Egnyte.';
    var ALL = 'all';
    var SELECTED = 'selected';
    var DOCUMENT_SOURCE_MESSAGE1 = 'Setup your document sources using the Create document Sources link above. (A document source is a file system on a laptop or desktop).';
    var DOCUMENT_SOURCE_MESSAGE2 = 'Once you define a document source,download the "Egnyte Uploader" onto that source computer by clicking link below.';
    var DOCUMENT_SOURCE_MESSAGE3 = 'You must also indicate the folders within the source computer from which Egnyte should upload data. If you know your full folder path, define it using the &quot;Add Folder&quot; link above. Alternately, you can also indicate the folder by marking it in Windows Explorer. This requires that you download the "Egnyte Uploader". Then select a folder within Windows explorer, right click & choose the &quot;Upload to Egnyte&quot; menu entry.';
    var EMAIL_SOURCE_MESSAGE1 = 'Setup your Email sources using the Create Email Sources link above. An email source must be a computer running Outlook or any POP enabled email.';
    var EMAIL_SOURCE_MESSAGE2 = 'If you define an Outlook Email source,download the "Egnyte Uploader" onto that source computer by clicking link below. If Outlook is running on a computer that you will define as a document source, then only one download is necessary.';
    var EMAIL_SOURCE_MESSAGE3 = 'No download is needed for POP enabled email sources.';
    var EMAIL_SOURCE_MESSAGE4 = 'You must also indicate the folders within the email system from which Egnyte should upload data. If you know your full folder path, define it using the &quot;Add Folder&quot; link above. Alternately, you can also indicate the folder by marking it in Outlook. This requires that you first download the "Egnyte Uploader"; then select a folder within Outlook, right click & choose the &quot;Upload to Egnyte&quot; menu entry.';
    var EMAIL_CLIENT_ERROR = 'Select Email type.';
    var SELECT_EMAIL_CLIENT = 'Select Email Client';
    var WELCOME_MESSAGE = 'Welcome to Egnyte. To start using the application, please follow instructions on this page.';
    var AUTHENTICATION_ERROR = 'Invalid Username/password. Try again.';
    var LOGIN_COMPULSORY_FIELDS_ERROR = 'Username/Password cannot be blank.';
    var USER_NAME = 'User&nbsp;Name';
    var USERNAME_BLANK_MESSAGE = 'Username cannot be blank.';
    var ACTIVATE_TITLE = 'Turn on Upload from this Location';
    var DEACTIVATE_TITLE = 'Turn off Upload from this Location';
    var POP_COMPLETE_MESSAGE1 = 'Thank you, your email account has now been configured.';
    var POP_COMPLETE_MESSAGE2 = 'Since this is the first time Egnyte will upload data from this account, this may take a while. <img src="images/icons/exclamation.GIF"/><b><font color="#FF0000">You will be notified via email when your data is uploaded and ready for use.</font></b>';
    var INVALID_NOTIFICATION_FREQUENCY_ERROR = 'Choose a frequency between 5 mins and 24 hrs';
    var INVALID_REVESION_COUNT_ERROR = 'should be a number and greater than zero';
    var INVALID_REVESION_EXPIRY_ERROR = 'Version validity days should be a number and greater than zero';

    var USER_MARKED_AS_DELETED = 'User is marked to be deleted';
    var WORKGROUP_NAME_INVALID_ERROR = 'Workgroup Name can not be blank.';
    var WORKGROUP_DESC_INVALID_ERROR = 'Workgroup Description can not be blank.';
    var WORKGROUP_MEMBER_NUMBER_INVALID_ERROR = 'Select max members for workgroup.';
    var WORKGROUP_CANNOT_DELETE_YOURSELF = 'You can not remove yourself.';
    var WORKGROUP_ALREADY_A_PERMANENT_MEMBER = 'is already a permanent workgoup member';
    var WORKGROUP_EGNYTE_MEMBER_ADD_AS_GUEST = 'is already an egnyte member. Do you want to add him as a user?';
    var WORKGROUP_ALREADY_A_GUEST = 'is already a workgroup guest';
    var WORKGROUP_INVITATION_PENDING_ADD_AS_MEMBER = 'is already  Invitation pending guest in this workgroup. Do you want to add him as Workgroup Member?';
    var WORKGROUP_WORKGROUP_MEMBER_ADD_AS_GUEST = 'is already a permanent member of some other workgroup. Do you want to add him as a user?';

    var SHARED_SPACE_SAVED = 'Shared view has been saved.';
    var SHARED_SPACE_DELETE_MESSAGE_CONFIRM = 'Are you sure you want to delete the shared view?';
    var DELETING_SHARED_SPACE = 'Deleting shared view';
    var SHARED_SPACE_DELETED = 'Shared view deleted.';
    var SHARED_SPACE_NAME_BLANK_ERROR = 'Please enter shared view name';
    var CRITERIA_BLANK_ERROR = 'Select at least one criteria for creating the shared view.';
    var GROUP_SPACE_ASSOCIATION_MSG = 'This group is associated with shared view(s).';
    var CONTACT_GROUP_SPACE_ASSOCIATION_MSG = 'This contact is associated with group(s) and shared view(s).';
    var CONTACT_GROUP_ASSOCIATION_MSG = 'This contact is associated with group(s).';
    var CONTACT_SPACE_ASSOCIATION_MSG = 'This contact is associated with shared view(s).';
    var NO_SPACE_TO_APPEND_MSG = 'No shared view to append';
    var DUPLICATE_SHARED_SPACE_MSG = 'Duplicate shared view name not allowed';
    var LOCATION_NAME = 'My Uploads';
    var FILE_UPLOADED_SUCCESS_MSG = 'File Uploaded to &quot;<font color="#FF6600">My Uploads</font>&quot; folder.';
    var FILES_UPLOADED_SUCCESS_MSG = 'Files Uploaded to &quot;<font color="#FF6600">My Uploads</font>&quot; folder.';
    var ERROR_UPLOADMSG_ALREADY_UPLOAD = '&nbsp;is already uploading... please wait..';
    var ERROR_UPLOADMSG_EMPTY_FILE = 'Please select a file first.';
    var ERROR_UPLOADMSG_DUPLY_FILE = 'Cannot upload the same file twice.';
    var ERROR_UPLOADMSG_FILE_MAX_LIMIT = 'File size is more than the maximum upload size allowed&nbsp;';
    var ERROR_UPLOADMSG_FILE_SIZE_ZERO = 'Can not upload the empty file.';
    var ERROR_UPLOADMSG_FAILURE_RESPONSE = 'Server could not process this file upload.';
	var ERROR_UPLOADMSG_NOTALLOWED_RESPONSE = 'Only .gif, .jpg and .jpeg formats are allowed.';
    var ERROR_UPLOADMSG_FILE_NOT_FOUND = 'Unable to locate file.';
    var ERROR_EMPTY_UPLOAD_CLICK = 'Nothing to Upload. Add Files before trying to Upload.';
	var ERROR_EMPTY_UPLOAD_CLICK_AGAIN = 'Please <font color="#CC0000">Add Files</font> before Uploading.';

    var DELETE_FOLDER_MESSAGE1 = 'This will delete folder';
    var DELETE_FOLDER_MESSAGE2 = 'from Egnyte. Delete anyway?';
    var DELETED_FOLDER_MESSAGE = 'Delete will occur within the next 24 hours.';

    var TAG_ALREADY_EXISTS_MESSAGE = 'This tag already exists in the shared view.';
    var FOLDER_ALREADY_EXISTS_MESSAGE = 'This folder already exists in the shared view.';
    var FILE_ALREADY_EXISTS_MESSAGE = 'These files already exists in the shared view -';
    var KEYWORD_ALREADY_EXISTS_MESSAGE = 'These keywords already exists in the shared view -';
    var RESTORE_STARTED_MSG = 'You will be notified by email when your zip file is ready for download.';
    var RESTORE_DEL_CONFIRM_MSG = 'You will not be able to download the file if this message disappears. Continue?';
    var COLLECTION_RETORE_CONFIRM_MSG = 'This will create a zip file containing all information from shared view';
    var FOLDER_RETORE_CONFIRM_MSG = 'This will create a zip file with all the information from the following folders:';
    var UNSHARING_READ_MESSAGE = 'Sharing will be removed for this group/contact. Remove anyway?';
    var UNSHARING_WRITE_MESSAGE = 'Any information from this group/contact in the Shared View will be removed. Remove anyway?';
    var WEBMAIL_ADDED_HOME_PAGE = 'You will be redirected to setup page.';
    var COMPUTER_ADDED_HOME_PAGE = 'Computer added.';
    var AFTER_UPLOAD_SEARCH_SHARE_MESSAGE = 'You have successfully uploaded data. You may now - <br/><br/><b>Search</b> your data using the search field above <br/>Create <b>Tags</b> below to classify your data <br/>Create a <b>Shared view</b> below to start sharing your data with your contacts.';
    var INCOMPLETE_SETUP_MESSAGE = 'To access this drive from Windows,  <a href="download.do"> install </a> the Egnyte Uploader.  <br/><br/><b><u>Note:</u></b> This will also let you backup personal computer folders into Egnyte.';

    var INCOMPLETE_COMPUTER_MESSAGE = 'There is already a computer that is not setup. Please set this up before creating another one.';
    var INCOMPLETE_POP_MESSAGE = 'pop account that is not setup. Please set this up before creating another one.';
    var NO_CHANGES_TO_SAVE_IN_COLLECTION_CRITERIA = 'No changes to save.';
    var NOTIFICATION_FREQUENCY_SET_TO = 'Notification frequency set to';
    var PASSWORD_AND_NOTIFICATION_FREQUENCY_CHANGED = 'Password has been changed and notification frequency set to';
    var RENAME_COMPUTER_POP_ACOUNT_ERROR = 'New name should not be blank.';
    var SEARCH_DESCRIPTION = 'Type your search term here';
    var ADD_CONTACT_MESSAGE='already uses Egnyte. An invitation will be sent to this user and you will be notified as soon as its accepted';
    var NO_HISTORY_MESSAGE='This file has not been accessed by anyone.';
    var SELREVISION_POLICY_CHANGED='Versioning rule updated.';
    var REQUSET_COMPANY_COMPULSORY_FIELDS_ERROR = 'First name/Last name/Email/Company name/Expected no. of power users cannot be blank.';
    var NO_ALPHA_USER_MESSAGE = 'You dont have to use this anymore. Please register for your personal egnyte account.';
    var CONTACT_US_CONFIRMATION = 'Egnyte Support has been notified and will contact you shortly.';
    var CONTACT_US_ERROR_MSG = 'First name/Last name/Email cannot be blank.';
    var ACK_CONTACTREQUEST_MSG = 'Please first acknowledge the invitation request of the contact.';
    var SMTP_TIMEOUT_MSG= 'Operation Timed out,Verify Mail Server and Mail Server Port.';
    var SMTP_CHECKPORT_MSG= 'Verify Mail Server Port.';
	var SMTP_ADDRESSVERIFY_MSG = 'Address Verification Error,Username and Sender Email must match.';
	var SMTP_TEMPORARILYUNAVAILABLE_MSG = 'Server temporarily unavailable, Please try again later.';
	var SMTP_UNABLETOCONNECT_MSG = 'Unable to connect to SMTP Server.';
	var SMTP_INVALID_HOST_MSG = 'Invalid SMTP host information.';
	var SMTP_INVALID_LOGIN_MSG = 'Invalid login information.';
	var SMTP_SUCCESS_MSG = 'SMTP settings verified successfully.';
	var SMTP_ERROR_MSG = 'Error sending email.';
	var GENERIC_ERROR_MSG = 'An error has occurred. Please contact customer support.';
	var DISABLE_POPUP_BLOCKER_MSG = 'Please disable popup blockers on your browser for egnyte.com and try again.';

    //	Account Management Messages
    var REQUIRED_GROUP_MEMBER_MESSAGE='Please add at least one member to the group.';
	var INTERNAL_LDAP_SET_MESSAGE = 'All users will now be authenticated against credentials setup within Egnyte. Note that users without password in Egnyte cannot login. You may setup password for users in <span class="object">Users & Groups</span>.';
	var EXTERNAL_LDAP_SET_MESSAGE = 'All users setup to be externally authenticated will now be authenticated against the specified directory server. You may specify users to be authenticated externally in <span class="object">Users & Groups</span>.';
	var ENTER_USNM_AND_PSWD_MESSAGE = 'Please enter both username and password to test the Active Directory settings.';
	var ENTER_ALL_AD_FIELDS_MESSAGE = 'Required fields to test the external directory service connection are missing.';
	var AD_TEST_AUTH_SUCCESS_MESSAGE = 'Test settings for external authentication verified successfully.';
	var AD_TEST_AUTH_FAILURE_MESSAGE = 'Test settings for external authentication failed.';
	var CONTACT_ADMINISTRATOR = 'Please contact your administrator';
	var MSG_RESETTING_GOOGLE_APP_ACCT='Resetting google apps account...';
	var MSG_RESET_GOOGLE_APP_ACCT_SUCCESS='Google apps account reset successfully.';
	var MSG_AD_NOT_SUPPORTED_IN_PLAN='Note that external directory service is not supported in the selected plan. You need to disable external authentication before changing plan.';
	var USER_SETTINGS_UPDATED_SUCCESSFULLY='User settings updated...';
	var MSG_TESTING_AD_SETTINGS='Testing settings...';
	var INVALID_BIND_DN = 'Please enter a valid BindDN.';
	var CONTACT_ACCT_ADMINISTRATOR = 'An email has been sent with your login instructions.Check your spam folder if you don&quot;t see the new email in your inbox.';
	var EXTERNAL_SAML_SETTINGS_UPDATED = 'All users setup to be Web SSO authenticated will now be authenticated against the specified Identity Provider. You may specify users to be Web SSO authenticated by Uploading the Mapping file or in <span class="object">Users & Groups</span>.';
	var EXTERNAL_SAML_SETTINGS_DISABLED = 'All users enabled for SAML SSO will not be authenticated against Identity Provider. You may setup password for users in <span class="object">Users & Groups</span>.';
	var MSG_SSO_NOT_SUPPORTED_IN_PLAN='Note that external authentication is not supported in the selected plan. You need to disable SSO before changing plan.';

</script>


	<script type="text/javascript">
		var brandFileServerLabel="Tipscloud File Server";
		var isBrandEnabled ="true";
		var PVI_AUTO_UPGRADED = false;
	</script>

	<script type="text/javascript">
		var enableGA = "true";
		var isDevMode = 'false';
		var PAYMENT_MODE = "";
		var samlRequestUrl = 'https://saml-auth.egnyte.com';
		var workGroupName = 'tipscloud';
		var extAuthEnabled = (('' == 'true'));
		var idpName = "";

		var isDomainEnabled= (('' == '') || ('' == 'true'));
		var currentUserName = "";
		var ccExpired = "";
		var SCHEME_TYPE = "";
		var tempPos = currentUserName.indexOf('@');
		var currentUserNameNew = currentUserName && /@.*?\..*$/.test(currentUserName) ? currentUserName : currentUserName.substring(0, tempPos);
		var workGroupMessageType = "";
		var disabledMessage = "";
		var isAdminUser = "false";
		if(isAdminUser == "")
			isAdminUser = "";
		var planPrice = "";
		var subdomainName = "";
        var email = "";

		var rememberMeEnabled = "true".toLowerCase() == "true";

		var pricingJson = null;
		var latestPricingJson = null;
		var oldPricingJson = null;

		var pricingInfo = null, LATEST_PRICING_DETAILS = null, OLD_PRICING_DETAILS = null;
		if(pricingJson && latestPricingJson && oldPricingJson){
			pricingInfo = pricingJson.priceDetails;
			LATEST_PRICING_DETAILS = latestPricingJson.priceDetails;
			OLD_PRICING_DETAILS = oldPricingJson.priceDetails;

			var comparePlan = function(a, b){
				return parseFloat(a.userCost) - parseFloat(b.userCost);
			};
			var sortPlans = function (pricingObj){
				pricingObj && pricingObj.plans && pricingObj.plans.sort(comparePlan);
			}

			sortPlans(pricingInfo);

			sortPlans(OLD_PRICING_DETAILS);

			sortPlans(LATEST_PRICING_DETAILS);
		}
	</script>

	<!-- _@aggregate_js_ext_@ -->
	<script type="text/javascript" src="/js/external/jquery-3.6.0.js"></script>
	<script type="text/javascript" src="/js/external/routie.js"></script>
	<script type="text/javascript" src="/js/external/store.js"></script>
	<script type="text/javascript" src="/js/external/jquery-ui-1.12.1.min.js"></script>
	<script type="text/javascript" src="/js/external/jquery.tmpl.min.js"></script>
	<!-- _@aggregate_js_ext_@ -->

	






















<script type="text/javascript">
    var Egnyte = Egnyte || {};
	var LOW_VALUE_PLAN_PRO = {
		plan: 'Pro',
		price: '$10',
		costBasis: '/ user/ month',
		thresholdPU: 5,
		minPU: 1,
		maxPU: 3
	};
	var LOW_VALUE_PLAN_TEAM = {
		plan: 'Team',
		price: '$10',
		costBasis: '/ user/ month',
		minPU: 1,
		maxPU: 3,
		allowedToAll: true
	};

    Egnyte.Settings = Egnyte.Settings || {};
    Egnyte.Settings.workgroup =  Egnyte.Settings.workgroup || {};
    Egnyte.Settings.global =  Egnyte.Settings.global || {};
    Egnyte.Settings.global.Screens = {
		HOME: 'home',
		SETTINGS: 'settings',
		LOGIN: 'login',
		REGISTRATION: 'registration',
		CC_PAYMENT: 'cc_payment'
	};
    Egnyte.Settings.workgroup.brandSettings = {
			accessURL:'',
			helpAndFaqURL:'',
            logoLocation: '/images/default/logo/egnyte_logo_public_link.png?rand=3739641072493602377',
            showFooter:  ('false' === 'true'),
            showFooterYN:   'false',
			isBrandEnabled : "true",
			brandFileServerLabel : "Tipscloud File Server",
			brandHomeBgColor : "" || "#00968F",
			brandHomeFrColor : ""
	};
	Egnyte.Settings.workgroup.emailVerificationRequired = ('false' === 'true');
	
	if(!Egnyte.Settings.system) {
		Egnyte.Settings.system = {
			dcName:"AVL",
			lowValuePlanConfigs: [
				{
					pvi: '1031',
					plans: [LOW_VALUE_PLAN_PRO]
				},
				{
					pvi: '1038',
					plans: [LOW_VALUE_PLAN_PRO]
				},
				{
					pvi: '1039',
					plans: [LOW_VALUE_PLAN_PRO]
				},
				{
					pvi: '1043',
					plans: [LOW_VALUE_PLAN_TEAM]
				}
			]
		};
	}

	Egnyte.Settings.mixpanel = {
		enabled: true,
		keyAPI: "abe3945ad0ddaadc3d987393d8d7c2ce"
	};

	Egnyte.Settings.pendo = {
		enabled: "true",
		keyAPI: "92676276-3fac-4873-6e27-2abacf94eee3"
	};
</script>

<!--	Fields required only for disabled domain flow	-->

	<script language="javascript">
		Egnyte.Settings.user = {
			userName: currentUserName,
			isAdminUser: isAdminUser,
			isPowerUser: ('false' === 'true'),
			isStandardUser: ('false' === 'true'),
			firstSignedIn: 'false',
			lastLoginTimeStamp: ''
		};
        Egnyte.Settings.showLoginCaptcha = ('false' === 'true');
	</script>
	<script type="text/javascript" src="/js/customdwr/engine.js?v=1"></script>
	<script type="text/javascript" src="/dwr/interface/AjaxFacadeWorkgroupManager.js"></script>
	<script type="text/javascript" src="/dwr/interface/AjaxFacadeUserManager.js"></script>

	<!-- _@aggregate_js_@ -->

	<script type="text/javascript" src="/js/external/underscore.js"></script>
	<script type="text/javascript" src="/js/external/backbone-min.js"></script>
	<script type="text/javascript" src="/js/external/rivets.min.js"></script>

	<script type="text/javascript" src="/js/pricing.js"></script>
	<script type="text/javascript" src="/js/discountingHelper.js"></script>
	<script type="text/javascript" src="/js/cjTracking.js"></script>
	<script type="text/javascript" src="/js/ezui/connector/trackingHelper.js"></script>
	<script type="text/javascript" src="/js/Egnyte.Utils.js"></script>
	<script type="text/javascript" src="/js/controllers/toolbarController.js"></script>
	<script type="text/javascript" src="/js/ezui/passwordStrength.js"></script>
	<script type="text/javascript" src="/js/controllers/validationController.js"></script>
	<script type="text/javascript" src="/js/global.js"></script>
	<script type="text/javascript" src="/js/controllers/commonsController.js"></script>
	<script type="text/javascript" src="/js/controllers/acctMgmt/planController.js"></script>
	<script type="text/javascript" src="/js/messages.js"></script>
	<script type="text/javascript" src="/js/gawrapper.js"></script>

	<script type="text/javascript" src="/js/ezui/core.js"></script>
	<script type="text/javascript" src="/js/ezui/Utilities.js"></script>
	<script type="text/javascript" src="/js/ezui/Utilities/BaseUtilities.js"></script>


	<script type="text/javascript" src="/js/ezui/i18n.js"></script>
	<script type="text/javascript" src="/js/external/bootstrap/bootstrap.js"></script>
	<script type="text/javascript" src="/js/ezui/core_shared_widgets.js"></script>


	<script type="text/javascript" src="/js/plan.js"></script>
	<script type="text/javascript" src="/js/ezui/connector/planDetailsController.js"></script>
	<script type="text/javascript" src="/js/ezui/views/changePlanGridView.js"></script>
	<script type="text/javascript" src="/js/ezui/changePlanGridHelper.js"></script>
	<script type="text/javascript" src="/js/ezui/mpmanager.js"></script>
	<script type="text/javascript" src="/js/external/ba-debug.min.js"></script>
	<script type="text/javascript" src="/js/external/cc-type-detector.js"></script>


	<script type="text/javascript" src="/js/external/registration-countries.js"></script>
	<script type="text/javascript" src="/js/ezui/login.js"></script>
	<script type="text/javascript" src="/js/ezui/constants.js"></script>

    <script type="text/javascript" src="/js/ezui/planDetailsApp.js"></script>
    <script type="text/javascript" src="/js/ezui/model/planDetailsModel.js"></script>
    <script type="text/javascript" src="/js/ezui/views/planOptionsView.js"></script>
    <script type="text/javascript" src="/js/external/tooltipster/js/jquery.tooltipster.js"></script>
    <script type="text/javascript" src="/js/external/jquery.checkable2.js"></script>
    <script type="text/javascript" src="/js/ezui/mobileDeepLinkHelper.js"></script>
    <script type="text/javascript" src="/js/ezui/popupNotifier.js"></script>
    <script type="text/javascript" src="/js/ezui/connector/subscriptionController.js"></script>

	<!-- _@aggregate_js_@ -->
	</head>
    <body >

		<div id="homePageHeader">
			























<script language="javascript">
function gotoHome()
{
	pushEventToGoogleAnalytics('HP - Home', 'WEBUI');
  if(Egnyte.Settings.user.lastLoginClassicUI) {
    location.href = '/home.do';
  }
  else {
    location.href = '/SimpleUI/home.do'; 
  }
}

function gotoHelp(helpUrl)
{
	pushEventToGoogleAnalytics('HP - Help & FAQ', 'WEBUI');
	//location.href = helpUrl;
}
function gotoSettings(settingsUrl)
{
	pushEventToGoogleAnalytics('HP - Settings', 'WEBUI');
	location.href = settingsUrl;
}
var useSimpleUI = ('' === 'NEWLOOK');

</script>
<input id="ftpAccessible" type="hidden" name="ftpAccessibleField">


<!-- Popup related DIVS -->

<div id="feedbackDialog" class="feedbackDialog" style="display: none;">
<h1 style="margin-top: 0px" id="feedbackDialogHeading">Send Feedback</h1>
<p id="inviteDlg_To_Label" style="display: none"><span class="radioLabel"
  style="align: left">To:</span></p>
<input type="text" name="inviteEmailAddress"
  class="txtInput txt11 input100percent" id="inviteEmailAddress"
  style="display: none" />
<div id="commaText" style="display: none"><span class="timestamp">Separate&nbsp;with&nbsp;commas</span><br>
<br>
</div>
<p><span class="radioLabel" style="align: left">Subject:</span></p>
<input type="text" name="feedbackSubject" class="txtInput txt11 input100percent"
  id="feedbackSubject" />
<p><span class="radioLabel">Message&nbsp;:</span><br />
<textarea id="feedbackMessageText" rows="3" style="width: 96%"
  class="emailTextArea txt11"></textarea><br />
</p>
<div class="defaultBtn" onmouseover="this.className='hoverBtn'"
  onmousedown="this.className='activeBtn'"
  onmouseout="this.className='defaultBtn'" onmouseup="this.className='hoverBtn'"
  onclick="javascript:showPopDisplay('feedbackDialog');" style="float: right">Cancel</div>
<div class="defaultBtn" onmouseover="this.className='hoverBtn'"
  onmousedown="this.className='activeBtn'"
  onmouseout="this.className='defaultBtn'" onmouseup="this.className='hoverBtn'"
  onclick="javascript:sendFeedbackMail();" style="float: right">Send</div>
</div>


<div id="sentFeedback"
  style="left: 275px; top: 281px; width: 500px; z-index: 6; display: none">
<center>
<h4 id="feedbackDialogConfirmation">Feedback sent successfully.</h4>
<br>
<div class="defaultBtn" onmouseover="this.className='hoverBtn'"
  onmousedown="this.className='activeBtn'"
  onmouseout="this.className='defaultBtn'" onmouseup="this.className='hoverBtn'"
  onclick="javascript:showPopDisplay('sentFeedback');">Ok</div>
</center>
</div>

<div id="stringWidth" style="position: absolute; visibility: hidden;"></div>
<!-- div to display general messages without any buttons in it -->
<!-- <div style="left:322px; top:100px; width:600px; z-index:1006; visibility: hidden" id="globalMessageWithNoButtonPop"> -->


<div style="left: 322px; top: 100px; width: 600px; z-index: 1006; display: none"
  id="globalMessageWithNoButtonPop">
<center>
<h4 id="globalMessageWithNoButtonPopText"></h4>
</center>
</div>
<!-- Hidden Fields - Start	-->
	<input type="hidden" id="hidDaysLeft" name="hidDaysLeft" value="" />
<!-- Hidden Fields - End	-->
<!--	Generic message box div	-->

	
		<div id='genericConfPopupContainer'>
			<div id="genericConfPopup">	
			<span id="genMessage"></span><br /><br />
			</div>
		</div>	
		
		<div id="statusContainer">
		 <div id="statusMessageContainer"><img src="../images/progressbar_animated.gif" width="29" height="18">
		 	<span id="statusMessageText"></span>
		 </div>
		</div>
			
	
	




		</div>


	        <div class="brand-color-strip" style="background:#41b9b3"></div>
	<div class="logo-container">
		<img src="/images/default/logo/logo.png?rand=3223369847177219931" border="0" />
	</div>
	<h1 class="domainNameLbl"></h1>
	<div class="login_wrapper">
		<div class="loginBox">
			<div class="content">
				<div class="login_panes formEl_a">
                    <div class="main-spinner">
                    	<img src="/images/spinner32.gif">
                    	<div class="spinner-msg"></div>
                    </div>
                    <div class="tabContent content-username" id="usernameEntry">
                    	<div class="login-contents-small">
					        <div class="error-msg-container"></div>
					        <form action="#" id="usernameForm">
					            <input type="text" id="loginUsername" class="login-input" placeholder="Enter your e-mail or username" spellcheck="false" autocomplete="username">
					            <button class="btn btn-primary set-username-btn">
					                Continue
					                <i class="fa fa-spin fa-circle-o-notch spinner-hidden spinner"></i>
					            </button>
					        </form>
							<div class="login-links">
								<a class="resendVerificationEmailLink" href="#resendVerificationEmail">Resend account verification email</a>
							</div>
					    </div>
                        










                    </div>
                   	<div class="tabContent content-login" id="loginContainer">
                   			<div class="login-contents-small">
						        <div class="error-msg-container"></div>
						        <form method="post" class="form" id="frmLogin" name="frmLogin">
						    			<div id="username-label"></div>
						    				<input type="text" class="inpt_a" id="j_username" autocomplete="username" name='user.userName' spellcheck="false" />
						    				<input type="password" id="j_password" name='user.password' class="login-input" autocomplete="current-password" maxlength="72" placeholder="Enter password" />
						    			<input type="hidden" value="subdomainUserLogin" name="subdomainUserLogin" id="subdomainUserLogin">
						    					

						                
						            		<label class="remember-me-container">
						                        <i class="remember-me-tooltip fa fa-info-circle" title="If you check this, you will not be asked for your password on this browser"></i>
						                        <input type="checkbox" class="inpt_c" name="rememberMe" id="remember" />
						                        Keep me logged in
						                    </label>
						        		

                                    

						    		<button id="loginBtn" class="btn btn-primary" type="button">
						                Log in
						                <i class="fa fa-spin fa-circle-o-notch spinner-hidden spinner"></i>
						            </button>

                                    <!-- Google ReCaptcha for payment forms -->
                                    <script src="https://www.recaptcha.net/recaptcha/api.js?onload=onGoogleReCaptchaLoadCallback&render=explicit" async defer></script>

                                    <!--	Hidden Fields	-->
						            <input type="hidden" id=subDomain name="com.egnyte.subdomain" value="tipscloud">
						            <input type="hidden" id=activationCode name="com.egnyte.activationCode" value="
">
						            
						            <input type="hidden" id="ref" name="ref" value="">
						            <input type="hidden" id="redirectUrl" name="redirectUrl" value="">
						    		<input type="hidden" id="oauth" name="oauth" value="">
						    		<input type="hidden" id="oauthSource" name="oauthSource" value="">
						    		<input type="hidden" id="sfEgnyteIntegLoginInfo" name="sfEgnyteIntegLoginInfo" value="">
						            <input type="hidden" id="reportName" name="reportName" value='null'>
						            <input type="hidden" id="requestId" name="requestId" value='null'>
						            <input type="hidden" id="hidErrElement" />
						            <input  type="hidden" id="timeZoneOffset" name="timeZoneOffset">
						            <input type="hidden" id="linkId" name="linkId" value=''>

						            <input type="hidden" id="hidDomainEnabled" />
						    		<!-- Hidden field added for page identification-->
						    		<input type="hidden" id="pageType" name="pageType" value="login" />
						            <input type="hidden" id="hidPlanType" name="hidPlanType" value='' />
						            <input type="hidden" id="subscribers" name="subscribers" value=''/>
						            <input type="hidden" id="totalStandardUsers" name="totalStandardUsers" value=''/>
						            <input type="hidden" id="hidPaymentType" name="hidPaymentType" value='' />
						            <input type="hidden" id="hidElcEnabled" name="hidElcEnabled" value=''/>
						            <input type="hidden" id="storage" name="storage" value=''/>
						            <input type="hidden" id="hidVersionId" name="hidVersionId" value=''/>
						            <input type="hidden" id="hidNASInstances" name="hidNASInstances" value=''/>
						            <input type="hidden" id="hidPromoCode" name="hidPromoCode" value=""/>
						            <input type="hidden" id="hidResellerCode" name="hidResellerCode" value=""/>

						            <input type="hidden" id="hidSubDomainName" name="hidSubDomainName"  value="tipscloud" />
						    		<input type="hidden" id="hidShowOldGrid" name="hidShowOldGrid"  value="false" />
						    		<!-- Additional hidden fields added to match the functionality -->
						    		<input type="hidden" id="domainName" value="" />
						    	<input type="hidden" id="hidPlanNum" name="hidPlanNum" value="1" />
						    	<input type="hidden" id="loadType" name="loadType" value="init" />
						    	<input type="hidden" id="schemeType" name="schemeType" />
						    	<input type="hidden" id="hidSchemeType" name="hidSchemeType" value=""/>
						    	<input  type="hidden"id="hidSchemeTypeVal" name="hidSchemeTypeVal" value="" />
						    	<input type="hidden" id="plan" name="plan" />
						    	<input type="hidden" id="monthlyPricing" name="monthlyPricing" />
						    	<input type="hidden" id="yearlyPricing" name="yearlyPricing" />
						    	<input type="hidden" id="hidTotalCost" name="hidTotalCost" value='' />
						    	
						    	<input type="hidden" id="hidHasPlanChanges" name="hidHasPlanChanges" value='false'/>
						    	<input type="hidden" id="hidLinkUrlToProceed" name="hidLinkUrlToProceed" />
						    	<input type="hidden" id="hidTabId" name="hidTabId" />
						    	<input type="hidden" id="hidTabBodyId" name="hidTabBodyId" />
						    	<input type="hidden" id="userCount" name="userCount" value=''/>
						    	<input type="hidden" id="normalPrice" name="normalPrice"/>
						    	<input type="hidden" id="specialType" name="specialType" />
						    	<input type="hidden" id="standardUsers" name="standardUsers" value=''/>
						    	<input type="hidden" id="standardAccounts" name="standardAccounts" value="4" />
						    	<input type="hidden" name="totalLicenseMemebers" id="totalLicenseMemebers" value=""/>
						    	<input type="hidden" id="hidLocalCloudCost" name="hidLocalCloudCost"/>
						    	<input type="hidden" id="hidPlanVersionId" name="hidPlanVersionId" value='' />
						    	<input type="hidden" id="hidCurrPlanVersionId" name="hidCurrPlanVersionId" />
						    	<input type="hidden" id="txtExtraPUCount" name="txtExtraPUCount" value="0" />
						    	<input type="hidden" id="hidOlcEnabled" name="hidOlcEnabled" value=''/>
						    	<input type="hidden" id="hidOlcCost" name="hidOlcCost" value=''/>
						    	<input type="hidden" id="hidTrialEndDate" name="hidTrialEndDate" value=''/>
						    	<input type="hidden" id="hidNextPaymentDate" name="hidNextPaymentDate" value=''/>
						    	<input type="hidden" id="hidHasPackageBands" name="hidHasPackageBands" value="false" />
						    	<input type="hidden" id="hidCurrPackBandIndex" name="hidCurrPackBandIndex" value="-1" />

						    	<input type="hidden" id="hidPaymentType" name="hidPaymentType" value='' />
						    	<input type="hidden" id="hidActualCost" name="hidActualCost" value='' />
						    	<input type="hidden" id="hidNASDevices" name="hidNASDevices" value='' />

						    	<input type="hidden" id="hidOrgPlanType" name="hidOrgPlanType" value='' />
						    	<input type="hidden" id="org_subscribers" name="org_subscribers" value=''/>
						    	<input type="hidden" id="org_userCount" name="org_userCount" value=''/>
						    	<input type="hidden" id="org_storage" name="org_storage" value=''/>
						    	<input type="hidden" id="hidOrgElcEnabled" name="hidOrgElcEnabled" value=''/>
						    	<input type="hidden" id="hidSharedFolderSize" name="hidSharedFolderSize" value='0.0'/>
						        <input type="hidden" id="hidPrivateFolderSize" name="hidPrivateFolderSize" value='0.0'/>
						    	<input type="hidden" id="hidOrgPaymentType" name="hidOrgPaymentType" value='' />
						    	<input type="hidden" id="hidSubscriptionType" name="hidSubscriptionType" value='' />
						    	<input type="hidden" id="hidActionExecuted" name="hidActionExecuted" />
						    	</form>
						        <div class="login-links">
						            <a href="#changeUser">Log in with a different account</a><br>
						            <a href="#forgotPassword">Forgot password?</a><br>
						            <a class="resendVerificationEmailLink" href="#resendVerificationEmail">Resend account verification email</a>
						        </div>
						    </div>
                            










                   	</div>
					<div class="tabContent content-forgot-password" id="forgotPasswordContainer"></div>
					<div class="tabContent content-email-verification" id="emailVerificationContainer"></div>
					<div class="tabContent content-error" id="error">
						<div class="login-contents-small login-contents-left">
							<h3 class="error-tab-title">Login Error</h3>
							<div class="error-tab-contents">There was an error logging into your account</div>
							<div class="login-links">
								<a href="#username">Back to Login</a>
							</div>
						</div>
					</div>
					<div class="tabContent content-email-confirmation" id="emailConfirmationContainer">
						<div class="login-contents-small login-contents-left">
					        <h3>Password Reset Sent</h3>
					        <p>Check your email address for instructions on resetting your password.</p>
					        <p>If you do not see the email in your inbox, check your spam folder. If you do not receive the email, please contact your administrator.</p>
					        <div class="login-links">
					        	<a href="#username">Back to login</a>
					        </div>
					    </div>
					</div>
					<div class="tabContent content-verification-email-confirmation" id="emailVerificationConfirmationContainer">
						<div class="login-contents-small login-contents-left">
					        <h3>Account Verification Email Sent</h3>
					        <p>Check your email inbox for instructions on verifying your account.</p>
					        <p>If you do not see the email in your inbox, check your spam folder.</p>
					        <div class="login-links">
					            <a href="#username">Back to login</a>
					        </div>
					    </div>
					</div>
                	<div class="tabContent content-subscribe">
                    	<div id="domainDisabledModeContainer" class="locked-screens">
                    		<div class="login-contents-small">
								<p>Your subscription has expired. Please contact the administrator of your Egnyte account to start your subscription.</p>
								
                    		</div>
                    	</div>
                    	<div id="migrationFailedContainer" class="migrationFailedContainer">
                    		<div class="login-contents-small">
								<p>The pricing you received when you created your Egnyte account is no longer available. Please contact sales to maintain your legacy pricing. Reach us at 1-877-734-6983 or <a id="contactSales" href="mailto:CustomerSuccess@egnyte.com">CustomerSuccess@egnyte.com</a></p>

								<button class="contactSalesButton btn btn-primary" type="button">Contact Sales</button>
	                    	</div>
                    	</div>
                    	<div id="currentPlanContainer" class="locked-screens"></div>
                    	<div id="ccDetailsContainer" class="locked-screens"></div>
                    	<div id="successMsgContainer" class="locked-screens"></div>

                    	<div class="PLAN_DETAILS">
                    		<div id="changePlanGridTmpl" style="display:none;">
								<div class="changePlanGridPanel changePlanGridBox grid-panel">
									<div class="changePlanControl">
										<div class="set-left planNames"><span class="changeMode">Change</span> from <span class="activePlanName"></span> &nbsp;to <span class="newPlanName">-none selected-</span></div>
										<div class="set-right changePlanActionsContainer button-container">
										<input type='button' class='save-changed-plan-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-priority-primary set-right actionDisabled actionButtonDisabled' value='Proceed with changes' disabled/>
										<span class="cancel-plan-link cancel-changed-plan-button cancel-link set-right">Cancel</span>
										</div>
										<div class="clearBoth"></div>
									</div>
									<div id="page-wrap" class='grid-box plan-grid'>
										<!-- 	Plan info injected from Backbone views 	-->
									</div>
									<div class="note">* with prepaid annual subscription</div>
									<div class="note">Click individual features above to see description</div>
									<div class="note"><img src="../images/icon_plangrid_checkmark.png" width="8" height="8" alt="included"/> = included | <img src="../images/icon_plangrid_dollarsign.png" width="5" height="8" alt="included"> = optional</div>
								</div>
								<div id="downgradeMsgScreenContainer" style="display:none" title="" >
									<div class="proceedActivated">
										<div class="set-left planNames">Confirm Downgrade</div>
										<div class="set-right changePlanActionsContainer button-container">
											<input type='button' class='save-downgraded-plan-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-priority-primary set-right' value='Downgrade' />
											<span class="cancel-plan-link cancel-downgraded-plan-button cancel-link set-right">Cancel</span>
										</div>
										<div class="clearBoth"></div>
									</div>
									<div class="downgradeMsgColContainer grid-box"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="tabContent content-msp-reseller"></div>
					





<!-- Javascript specific only to this pricing grid -->
<script type="text/javascript">
var current_plan = "";
var original_annual_value = 0;
var clicked_plan = 0;
var previous_plan = 0;
function setoriginal()
{
	if(show_old_grid_boolean){
	jq('#selectPlanPopOld').find('.tabsBlock').children('.tab').each(function(){
												var plan_number = jq(this).attr("plannumber");
												//EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE
												var current_iterated_plan = jq(this).find('div.tabsBlockTop').text().toLowerCase().trim();
												current_plan = jq('input[name="hidPlanType"]').val().toLowerCase().trim();
												
												if(current_iterated_plan == current_plan)
												{
													original_annual_value = plan_number;
												}
});
	}
	else{
		jq('#selectPlanPop').find('.tabsBlock').children('.tab').each(function(){
												var plan_number = jq(this).attr("plannumber");
												//EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE
												var current_iterated_plan = jq(this).find('div.tabsBlockTop').text().toLowerCase().trim();
												current_plan = jq('input[name="hidPlanType"]').val().toLowerCase().trim();
												
												if(current_iterated_plan == current_plan)
												{
													original_annual_value = plan_number;
												}
});
	}
}
/*Added functionality of accepting plan number incase you wish to customize this to highlight specific plan*/
function identify_current_plan(selectplanmode)
{
	/*Caching the selector for better performance*/
	var selector = jq('#selectPlanPopOld').find('.tabsBlock').children('.tab');
	var selectornew = jq('#selectPlanPop').find('.tabsBlock').children('.tab');
	if(show_old_grid_boolean){
	selector.each(function()
							{
								jq(this).removeClass('choosen');
								var target_removal = "radNewPlan_plan"+jq(this).attr("plannumber")+"_old";
								document.getElementById(target_removal).removeAttribute('checked','checked');
							});
	selector.each(function(){
						var plan_number = jq(this).attr("plannumber");
						//EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE
						var current_iterated_plan = jq(this).find('div.tabsBlockTop').text().toLowerCase().trim();
						current_plan = jq('input[name="hidPlanType"]').val().toLowerCase().trim();
																		
						if(current_iterated_plan == current_plan)
															{
															var matched_id = "#"+jq(this).attr('id');
															jq("#selectPlanPopOld").find(matched_id).addClass('choosen');
															EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE = plan_number;
															if(is_show_price_annual)
																	{
																		jq(".choosen .value_annual").show();
																		jq(".choosen .value_monthly").hide();
																	}
															var target_radio = "radNewPlan_plan"+jq(this).attr("plannumber")+"_old";
															document.getElementById(target_radio).setAttribute('checked','checked');
															plan_value_being_selected = parseFloat(jq(this).find(".value_annual").text());
															plan_value_currently_selected = plan_value_being_selected;
															previous_plan = plan_number;
															}
									});
						if(selectplanmode){
						var total_tabs = selector.length;
						selector.eq(total_tabs - 1).click();	
						}
						
	}
	else
	{
		selectornew.each(function()
								{
									jq(this).removeClass('choosen');
									var target_removal = "radNewPlan_plan"+jq(this).attr("plannumber");
									document.getElementById(target_removal).removeAttribute('checked','checked');
								});
		selectornew.each(function(){
							var plan_number = jq(this).attr("plannumber");
							var current_iterated_plan = jq(this).find('div.tabsBlockTop').text().toLowerCase().trim();
							current_plan = jq('input[name="hidPlanType"]').val().toLowerCase().trim();
							if(current_iterated_plan == current_plan)
																{
																var matched_id = "#"+jq(this).attr('id');
																jq("#selectPlanPop").find(matched_id).addClass('choosen');
																EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE = plan_number;
																if(is_show_price_annual)
																		{
																			jq(".choosen .value_annual").show();
																			jq(".choosen .value_monthly").hide();
																		}
																var target_radio = "radNewPlan_plan"+jq(this).attr("plannumber");
																document.getElementById(target_radio).setAttribute('checked','checked');
																plan_value_being_selected = parseFloat(jq(this).find(".value_annual").text());
																plan_value_currently_selected = plan_value_being_selected;
																previous_plan = plan_number;
																}
										});
							if(selectplanmode){
							var total_tabs = selectornew.length;
							selectornew.eq(total_tabs - 1).click();	
							}
	}
}
jq(function(){
				jq('#selectPlanPopOld').find('.tab').each(function(i){
													jq(this).click(function(e){
														
													jq('#selectPlanPopOld').find('.tabsBlock').children('.tab').each(function()
														{
															jq(this).removeClass('choosen');
															var target_removal = "radNewPlan_plan"+jq(this).attr("plannumber")+"_old";
															document.getElementById(target_removal).removeAttribute('checked','checked');
														});
														
													jq(this).addClass('choosen');
														
														
														EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE = jq(this).attr("plannumber");
														clicked_plan = EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE;
														var target_radio = "radNewPlan_plan"+jq(this).attr("plannumber")+"_old";
														
														plan_value_currently_selected = parseFloat(jq(this).find(".value_annual").text());
														document.getElementById(target_radio).click();
													
													});
													});
				jq('#selectPlanPop').find('.tabsBlock').children('.tab').each(function(i){
													jq(this).click(function(e){
														
														jq('#selectPlanPop').find('.tabsBlock').children('.tab').each(function()
														{
															jq(this).removeClass('choosen');
															var target_removal = "radNewPlan_plan"+jq(this).attr("plannumber");
															document.getElementById(target_removal).removeAttribute('checked','checked');
														});
														jq(this).addClass('choosen');
														
														
														EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE = jq(this).attr("plannumber");
														clicked_plan = EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE;
														var target_radio = "radNewPlan_plan"+jq(this).attr("plannumber");
														
														plan_value_currently_selected = parseFloat(jq(this).find(".value_annual").text());
														document.getElementById(target_radio).click();																
													});
													});
				identify_current_plan();
				setoriginal();
			})
</script>
<!--	Scaled down configurator - Start	-->
<div id="selectPlanPop" class="collectionPop planpop" style="display:none">
	<h4 class="top" align="left">Select a new plan</h4>
	<form id="frmConfigurator" name="frmConfigurator">
	<div class="tabParent  name-second">
									
										<div class="tabPriceHead"></div>											
										<div class="tableFeatures">
											<div class="tableFeaturesRow row1">	<p><strong>Price</strong></p></div>
											<div class="tableFeaturesRow row2"><p><strong>Users</strong></p></div>
											<div class="tableFeaturesRow row3"><p><strong>Online Storage</strong><span class="note"> (Additional storage available)</span></p></div>
											<div class="tableFeaturesRow row4">
                                            <p><strong>Maximum File Size&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Maximum file size limit for a single file.', 225)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row5"><p><strong>Desktop Sync&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Files on your desktop are automatically synced and backed up online, accessible from any other computer or mobile device.', 500)" onMouseout="hideddrivetip()"></strong><span class="note"> (Offline access to files)</span></p></div>
											<div class="tableFeaturesRow row6"><p><strong>FTP Access&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Securely transfer large files and folders using your favorite FTP client.', 400)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row7"><p><strong>Outlook Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Send files and folders as links or attachments from Outlook, without worrying about file size limits.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row8"><p><strong>Storage Sync (Office/Enterprise Cloud)&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Transform your existing server or storage system into a central collaboration hub, providing file sharing beyond the firewall.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row9"><p><strong>Audit Reports&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Maintain complete control and compliance. Monitor all user login activity, file actions, and permission changes.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row10"><p><strong>Custom Branding&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Brand your domain with your company logo, themes and customized notifications.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row11"><p><strong>Salesforce.com Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Share, access and store files directly within Salesforce.com.', 350)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row12"><p><strong>Active Directory &amp; LDAP Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Authenticate users against your existing AD/LDAP, with centralized user management behind the firewall.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row13"><p><strong>Advanced Authentication&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Protect your account with enhanced password policies, mobile app security, and two-step login verification.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row14"><p><strong>NetApp Storage Sync&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Files on your NetApp storage can be synced online, accessible by any authorized remote computer or mobile device.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row15"><p><strong>Professional Services<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Speed up your deployment and increase user adoption with Egnyte Professional Services.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row16"><p><strong>Support</strong></p></div>
										</div>
										<div class="MarkerTabState TabState-tab1" id="selectedTab">									
										<div class="tabsBlock">

											<div class="tab tab0" plannumber="1" id="tab0">
												<div class="tabsBlockTop">
                    <h2 id="chng_band1_nm"></h2></div>
                    <div class="topHidden"></div>
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band1_ann_cost" class="value_annual"></span><span id="band1_mnt_cost" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2">
                    <p id="band1_PU_count"></p>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band1_Storage"></p>
                  </div>
                 
                  <div class="tabsBlockContent row4">
					<p id="band1_MaxFileSizeLimit"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band1_desktopsyncenabled"></div>
                  </div>
                  <div class="tabsBlockContent row6">
					<div class="yes" id="band1_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="no" id="band1_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band1_olc_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row9">
					<div class="no" id="band1_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10 gr">
					<div class="no" id="band1_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11 gr">
				   <div class="no" id="band1_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12 gr">
					<div class="no" id="band1_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band1_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band1_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band1_professionalservices"></div>
                  </div>                  
                  <div class="tabsBlockContent row16">
                    <p id="band1_support">Standard</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
													
													
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
                                                    
                                                    
												</div>
												<input type="radio" name="radNewPlan" class="radPlanSel" id="radNewPlan_plan1" value="1" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=1;"/>
											</div>
										
											
											<div class="tab tab1" plannumber="2" id="tab1">
												<div class="tabsBlockTop"><h2 id="chng_band2_nm" style="z-index:1000">Office</h2></div>
				<div class="topHidden"></div>
                    
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band2_ann_cost" class="value_annual"></span><span id="band2_mnt_cost" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2">
                    <p id="band2_PU_count"></p>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band2_Storage"></p>
                  </div>
                  <div class="tabsBlockContent row4">
					<p id="band2_MaxFileSizeLimit"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band2_desktopsyncenabled"></div>
                  </div>
                  <div class="tabsBlockContent row6">
					<div class="yes" id="band2_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="no" id="band2_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band2_olc_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row9">
					<div class="no" id="band2_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10 gr">
					<div class="no" id="band2_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11 gr">
					<div class="no" id="band2_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12 gr">
					<div class="no" id="band2_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band2_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band2_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band2_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                   <p id="band2_support">Standard</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
												
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
												</div>
												<input type="radio" name="radNewPlan" class="radPlanSel" id="radNewPlan_plan2" value="2" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=2;"/>
											</div>
								
										            
                <div class="tab tab2" plannumber="3" id="tab2"><div class="tabsBlockTop"><h2 id="chng_band3_nm"></h2>
                    </div>
                    <div class="topHidden"></div>
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band3_ann_cost" class="value_annual"></span><span id="band3_mnt_cost" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2" id="band3_PU_count" style="clear:both;">
                    <div id="puEntCell">
						<input type="text" id="txtCorpUserCount" name="txtCorpUserCount" class="txtCorpUserCount" readonly="readonly" maxlength="3" size="2">
						<div id="imgMoveUp" class="spinner-btn" action="I" ref="txtCorpUserCount" title="Increase Power Users"></div>
						<div id="imgMoveDown" class="spinner-btn" action="D" ref="txtCorpUserCount" title="Decrease Power Users"></div>
					</div>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band3_Storage"></p>
                  </div>
                  <div class="tabsBlockContent row4">
					<p id="band3_MaxFileSizeLimit"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band3_desktopsyncenabled"></div>
                  </div>
                  <div class="tabsBlockContent row6">
					<div class="yes" id="band3_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="yes" id="band3_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band3_olc_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row9">
					<div class="no" id="band3_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10">
					<div class="yes" id="band3_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11">
					<div class="yes" id="band3_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12">
					<div class="no" id="band3_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band3_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band3_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band3_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                    <p id="band3_support">Standard</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
													
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
												</div>
												<input type="radio" name="radNewPlan" class="radPlanSel" id="radNewPlan_plan3" value="3" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=3;"/>
											</div>
											
											<div class="tab tab4" plannumber="4" id="tab4"><div class="tabsBlockTop"><h2 id="chng_band4_nm"></h2>
                    </div>
                    <div class="topHidden"></div>
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band4_ann_cost" class="value_annual"></span><span id="band4_mnt_cost" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2" id="band4_PU_count" style="clear:both;">
                    <div id="puEntCell">
						<input type="text" id="txtCorpUserCount" name="txtCorpUserCount" class="txtCorpUserCount" readonly="readonly" maxlength="3" size="2">
						<div id="imgMoveUp" class="spinner-btn" action="I" ref="txtCorpUserCount" title="Increase Power Users"></div>
						<div id="imgMoveDown" class="spinner-btn" action="D" ref="txtCorpUserCount" title="Decrease Power Users"></div>
					</div>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band4_Storage"></p>
                  </div>
                  <div class="tabsBlockContent row4">
					<p id="band4_MaxFileSizeLimit"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band4_desktopsyncenabled"></div>
                  </div>
                  <div class="tabsBlockContent row6">
					<div class="yes" id="band4_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="yes" id="band4_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band4_olc_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row9">
					<div class="yes" id="band4_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10">
					<div class="yes" id="band4_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11">
					<div class="yes" id="band4_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12">
					<div class="no" id="band4_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band4_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band4_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band4_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                    <p id="band4_support">Premium</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
													
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
												</div>
												<input type="radio" name="radNewPlan" class="radPlanSel" id="radNewPlan_plan4" value="4" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=4;"/>
											</div>
											
											
										</div>
									</div>
									<div class="grid_notice_nmonth">**Indicated price is for price for first 3 months. Regular monthly price is $<span id="grid_price1_nm">29.99</span> for <span id="grid_pname1">Group</span>, $<span id="grid_price2_nm">49.99</span> for <span id="grid_pname2">Office</span><span class="activateForNonEnterprise">,</span><span class="customEnterpriseSeperator"> and</span> $<span id="grid_price3_nm">199.99</span> for <span id="grid_pname3">Company</span> <span class="activateForNonEnterprise">and $<span id="grid_price4">8</span><span id="for_configurable_plan4">/user/month</span> for <span id="grid_pname4">Corporate</span> plans</span></div>
									
									<div class="grid_notice">*Indicated price is for annual payment only. Regular monthly price is $<span id="grid_price1">29.99</span> for <span id="grid_pname1">Group</span>, $<span id="grid_price2">49.99</span> for <span id="grid_pname2">Office</span><span class="activateForNonEnterprise">,</span><span class="customEnterpriseSeperator"> and</span> $<span id="grid_price3">199.99</span> for <span id="grid_pname3">Company</span> <span class="activateForNonEnterprise">and $<span id="grid_price4">8</span><span id="for_configurable_plan4">/user/month</span> for <span id="grid_pname4">Corporate</span> plans</span></div>
									
									</div>
	
	 </form>
</div>

<!--	for old domains	- start	-->
<div id="selectPlanPopOld" class="collectionPop planpop" style="display:none;">
	<h4 class="top" align="left">Select a new plan</h4>
	
	<form id="frmConfiguratorOld" name="frmConfiguratorOld">
	<div class="tabParent  name-second">
										<div class="tabPriceHead"></div>											
										<div class="tableFeatures">
											<div class="tableFeaturesRow row1">	<p><strong>Price</strong></p></div>
											<div class="tableFeaturesRow row2"><p><strong>Users</strong></p></div>
											<div class="tableFeaturesRow row3"><p><strong>Online Storage</strong><span class="note"> (Additional storage available)</span></p></div>
											<div class="tableFeaturesRow row4"><p><strong>Maximum File Size&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Maximum file size limit for a single file.', 225)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row5"><p><strong>Desktop Sync&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Files on your desktop are automatically synced and backed up online, accessible from any other computer or mobile device.', 500)" onMouseout="hideddrivetip()"></strong><span class="note"> (Offline access to files)</span></p></div>
											<div class="tableFeaturesRow row6"><p><strong>FTP Access&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Securely transfer large files and folders using your favorite FTP client.', 400)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row7"><p><strong>Outlook Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Send files and folders as links or attachments from Outlook, without worrying about file size limits.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row8"><p><strong>Storage Sync (Office/Enterprise Cloud)&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Transform your existing server or storage system into a central collaboration hub, providing file sharing beyond the firewall.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row9"><p><strong>Audit Reports&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Maintain complete control and compliance. Monitor all user login activity, file actions, and permission changes.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row10"><p><strong>Custom Branding&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Brand your domain with your company logo, themes and customized notifications.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row11"><p><strong>Salesforce.com Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Share, access and store files directly within Salesforce.com.', 700)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row12"><p><strong>Active Directory &amp; LDAP Integration&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Authenticate users against your existing AD/LDAP, with centralized user management behind the firewall.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row13"><p><strong>Advanced Authentication&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Protect your account with enhanced password policies, mobile app security, and two-step login verification.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row14"><p><strong>NetApp Storage Sync&nbsp;<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Files on your NetApp storage can be synced online, accessible by any authorized remote computer or mobile device.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row15"><p><strong>Professional Services<img src="../images/i.gif" class="userTypeIcon" onMouseover="ddrivetip('Speed up your deployment and increase user adoption with Egnyte Professional Services.', 500)" onMouseout="hideddrivetip()"></strong></p></div>
											<div class="tableFeaturesRow row16"><p><strong>Support</strong></p></div>
										</div>
										<div class="MarkerTabState TabState-tab1" id="selectedTab">
										<div class="tabsBlock">
											
											<div class="tab tab0" plannumber="1" id="tab0">
												<div class="tabsBlockTop">
                    <h2 id="plan1">Group</h2></div>
                    <div class="topHidden"></div>
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band1_ann_cost_old" class="value_annual"></span><span id="band1_mnt_cost_old" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2">
                    <p id="band1_PU_count_old"></p>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band1_Storage_old"></p>
                  </div>
                 
                  <div class="tabsBlockContent row4">
					<p id="band1_MaxFileSizeLimit_old"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band1_desktopsyncenabled"></div>
                  </div>
				  <div class="tabsBlockContent row6">
					<div class="yes" id="band1_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="no" id="band1_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band1_olc_enabled"></div>
                  </div>
				  <div class="tabsBlockContent row9">
					<div class="no" id="band1_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10 gr">
					<div class="no" id="band1_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11 gr">
				   <div class="no" id="band1_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12 gr">
					<div class="no" id="band1_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band1_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band1_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band1_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                    <p id="band1_support">Standard</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
													
													
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
                                                    
                                                    
												</div>
												<input type="radio" name="radNewPlanOld" class="radPlanSel" id="radNewPlan_plan1_old" value="1" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=1;"/>
											</div>
										
											
											<div class="tab tab1" plannumber="2" id="tab1">
												<div class="tabsBlockTop"><h2 id="plan2" style="z-index:1000">Office</h2></div>
				<div class="topHidden"></div>
                    
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band2_ann_cost_old" class="value_annual"></span><span id="band2_mnt_cost_old" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2">
                    <p id="band2_PU_count_old"></p>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band2_Storage_old"></p>
                  </div>
                  <div class="tabsBlockContent row4">
					<p id="band2_MaxFileSizeLimit_old"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band2_desktopsyncenabled"></div>
                  </div>
				  <div class="tabsBlockContent row6">
					<div class="yes" id="band2_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="no" id="band2_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band2_olc_enabled"></div>
                  </div>
				  <div class="tabsBlockContent row9">
					<div class="no" id="band2_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10 gr">
					<div class="no" id="band2_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11 gr">
					<div class="no" id="band2_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12 gr">
					<div class="no" id="band2_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band2_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band2_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band2_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                   <p id="band2_support">Standard</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
												
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
												</div>
												<input type="radio" name="radNewPlanOld" class="radPlanSel" id="radNewPlan_plan2_old" value="2" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=2;"/>
											</div>
								
										            
                <div class="tab tab2" plannumber="3" id="tab2"><div class="tabsBlockTop"><h2 id="plan3">Enterprise</h2>
                    </div>
                    <div class="topHidden"></div>
                  <div class="tabsBlockContent row1">
                    <span class="dollar_spn">$</span><span id="band3_ann_cost_old" class="value_annual"></span><span id="band3_mnt_cost_old" class="value_monthly"></span>
                  </div>
                  <div class="tabsBlockContent row2" id="band3_PU_count_old" style="clear:both;">
                    <div id="puEntCell">
						<input type="text" id="txtCorpUserCount" name="txtCorpUserCount" class="txtCorpUserCount" readonly="readonly" maxlength="3" size="2">
						<div id="imgMoveUp" class="spinner-btn" action="I" ref="txtCorpUserCount" title="Increase Power Users"></div>
						<div id="imgMoveDown" class="spinner-btn" action="D" ref="txtCorpUserCount" title="Decrease Power Users"></div>
					</div>
                  </div>
                  <div class="tabsBlockContent row3">
                    <p id="band3_Storage_old"></p>
                  </div>
                  <div class="tabsBlockContent row4">
					<p id="band3_MaxFileSizeLimit_old"></p>
                  </div>
                  <div class="tabsBlockContent row5">
					<div class="yes" id="band3_desktopsyncenabled"></div>
                  </div>
				  <div class="tabsBlockContent row6">
					<div class="yes" id="band3_ftpenabled"></div>
                  </div>
                  <div class="tabsBlockContent row7">
					<div class="yes" id="band3_outlook_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row8">
					<div class="yes" id="band3_olc_enabled"></div>
                  </div>
				  <div class="tabsBlockContent row9">
					<div class="yes" id="band3_audit_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row10">
					<div class="yes" id="band3_adv_branding_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row11">
					<div class="yes" id="band3_sf_enabled"></div>
                  </div>
                  <div class="tabsBlockContent row12">
					<div class="no" id="band3_adldapintegration"></div>
                  </div>
                  <div class="tabsBlockContent row13 gr">
					<div class="no" id="band3_advancedauthentication"></div>
                  </div>
                  <div class="tabsBlockContent row14 gr">
					<div class="no" id="band3_netappstoragesync"></div>
                  </div>
                  <div class="tabsBlockContent row15 gr">
					<div class="no" id="band3_professionalservices"></div>
                  </div>
                  <div class="tabsBlockContent row16">
                    <p id="band3_support">Premium</p>
                  </div>
												<div class="tabsBlockbottom"></div>
												<div class="tabsBlockbottomActive">
													
													<div group="try-btns" class="free"><a href="#">Free trial</a></div>
													<div group="buy-btns" class="buy"><a href="#">Buy now</a></div>
												</div>
												<input type="radio" name="radNewPlanOld" class="radPlanSel" id="radNewPlan_plan3_old" value="3" onClick="if(this.checked)EGNYTE_RADIO_BUTTON_FOR_CHANGE_PLAN_VALUE=3;"/>
											</div>
											
											
										</div>
									</div>
									<div class="grid_notice_nmonth">**Indicated price is for price for first 3 months. Regular monthly price is $<span id="grid_price1_nm">29.99</span> for <span id="grid_pname1">Group</span><span class="activateForNonEnterprise">,</span><span class="customEnterpriseSeperator"> and</span> $<span id="grid_price2_nm">49.99</span> for <span id="grid_pname2">Office</span> <span class="activateForNonEnterprise">and $<span id="grid_price3_nm">14.99</span><span id="for_configurable_plan3"></span>/user/month for <span id="grid_pname3">Enterprise</span> plans.</span></div>
									
									<div class="grid_notice">*Indicated price is for annual payment only. Regular monthly price is $<span id="grid_price1">29.99</span> for <span id="grid_pname1">Group</span><span class="activateForNonEnterprise">,</span><span class="customEnterpriseSeperator"> and</span> $<span id="grid_price2">49.99</span> for <span id="grid_pname2">Office</span> <span class="activateForNonEnterprise">and $<span id="grid_price3">14.99</span><span id="for_configurable_plan3">/user/month</span> for <span id="grid_pname3">Enterprise</span> plans.</span></div>
									
									</div>
	
<!--	for old domains - end	-->
</form>
<!--	Scaled down configurator - End		-->
</div>
<!--	Converting size in KBs to GBs		-->




				</div>
			</div>
		</div>


	</div>

	<div id="main_footer" class="simpleui-box main_footer clsElementOn">
		<div class="pull-left">
			<a href="https://www.egnyte.com" target="_blank">
				<img src="/images/default/logo/logo.png" class="footer-logo">
			</a>
			<div>
				<a target="_blank" href="https://www.egnyte.com/corp/privacy_policy.html">Privacy Policy</a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<a target="_blank" href="https://www.egnyte.com/corp/terms_of_service.html">Terms of Service</a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<a id="lnkContactUs" href="https://helpdesk.egnyte.com/anonymous_requests/new" target="_blank">Contact Us</a>
			</div>
		</div>

		<div class="copyright">&copy; 2022 Egnyte, Inc. All rights reserved.</div>
	</div>

	<!--	***		Login page template sections - Start	***		-->
	










<input type="hidden" id="hidBoolFromLoginPage" name="hidBoolFromLoginPage" value="true"/>

<script id="mobileDeepLinkBannerTmpl" type="text/x-jquery-tmpl">
    <div class="mobile-deep-link-banner">
        <div class="inner">
            <i class="fa fa-mobile"></i>
            <span class="banner-msg">Use the mobile app</span>
        </div>
    </div>
</script>

<script id="mobileDeepLinkDialogTmpl" type="text/x-jquery-tmpl">
    <div class="mobile-deep-link-dialog">
        <div class="inner">
            <div class="mobile-dialog-msg">
                Access files using the<br>Egnyte Mobile App!
            </div>
            <div class="mobile-dialog-button-bar">
                <a class="download-mobile-app-btn">Download the App</a>
                <a class="open-mobile-app-btn">Use the App</a>
                <a class="dismiss">No, thanks</a>
            </div>
            <img class="mobile-img" src="/images/phone_lander/login_mobile_app_promo.png">
        </div>       
    </div>
</script>


<!--	Forgot password - Start		-->
<script id="forgotPswdTemplate" type="text/x-jquery-tmpl">
	<div class="login-contents-small">
        <h3>Reset your Password</h3>
    	<div class="error-msg-container"></div>
        <form action="" method="post" class="form" id="form_forgotPassword">
    		<p>We'll send you an email with a link to reset your password.</p>
            <input type="hidden" id="txtForgotUsername" name="txtForgotUsername" autocomplete="off" />
    		<button id="forgotPasswordBtn" class="btn btn-primary" type="button">Continue</button>
            <div class="login-links">
                <a href="#login">Cancel</a>
            </div>
    		
    	</form>
    </div>
</script>
<!--	Forgot password - End		-->

<!--    Email verification - Start     -->
<script id="emailVerificationTemplate" type="text/x-jquery-tmpl">
    <div class="login-contents-small">
        <h3>Resend account verification email</h3>
        <div class="error-msg-container"></div>
        <p>We'll send you an email with instructions to verify your account.</p>
        <button id="resendVerificationEmailBtn" class="btn btn-primary" type="button">Continue</button>
        <div class="login-links">
            <a href="#login">Cancel</a>
        </div>
    </div>
</script>
<!--    Email verification - End       -->

<!--	Single Sign-on - Start		-->
<script id="singleSignOnTemplate" type="text/x-jquery-tmpl">
	<div class="clear"></div>
    <div class="right_block">
        <div class="sepH_b">
        <p class="sepH_b">Single Sign-On users please click below.</p>
        </div>
        <div class="singlesignon_logo">
			
		</div>
        <button id="singleSignOnButton" class="btn_a btn" type="button">Login</button>
    </div>
</script>
<!--	Single Sign-on - End		-->


<!--	Contact Us message - Start		-->
<script id="contactUsMessage" type="text/x-jquery-tmpl">
	<p>Egnyte Support has been notified and will contact you shortly.</p>
	<div class="divider"></div>
    <div class="content_btm"></div>
    <div class="sepH_button">
		<button id="btnOk" class="btn_a btn" type="button">Ok</button>
    </div>    
</script>
<!--	Contact Us message - End		-->

<!--	Email Confirmation Message template - End		-->
<!-- Contact egnyte support -->
<div id="contact_ignite_support" style="display:none;">
    <p>Please Contact Egnyte support.</p>
</div>
<div id="downgrade_message" style="display:none;">
    <p>The change you have requested requires reduction in the available service resources.<br> <b>Please contact customer support at 1.650.265.4058 to avoid potential loss of information.</b></p>
</div>

	






<!--	Standard Users	-->

				
	
		
	
	

<!--	Storage		-->
	
				
	
	
		
	


<!--	ELC / OLC Status		-->
				
	
	
		
		
	


<!--	Current plan details mode - Start		-->
<script id="currentPlanParamsTemplate" type="text/x-jquery-tmpl">
	<div class="subscribe-panel">
		<div class="cc-form sub-panel">
			<div class="validationMsg validationMsg-error" id="hsErrorMessageContainer"><p><strong id="strValidationMsg"></strong></p></div>
			<form method="post" class="form" id="frmLoginCCProfile" name="frmLoginCCProfile">
			 	<div class="topheader">
					<label for="lusername" class="lbl_a">Secure Payment Info:</label>
				</div>
				<div class="top-line"></div>
				<div class="block_container">
					<div class="left_block">
						<div class="sepH_a">
							<label for="name" class="lbl_a">Name:</label>
							<input type="text" id="nameAsOnCard" name="nameAsOnCard" class="login-input" />
						</div>
						<div class="sepH_a">
							<label for="streetaddress" class="lbl_a">Street Address:</label>
							<input type="text" id="streetAddress" name="streetAddress" class="login-input" />
						</div>
						<div class="sepH_a">
							<label for="zipcode" class="lbl_a">Zip Code:</label>
							<input type="text" id="zipCode" name="zipCode" class="login-input" maxlength="12" />
						</div>
						<div class="sepH_a">
							<label for="countryCode" class="lbl_a">Country:</label>
							<select id="countryCode" name="countryCode" class="inpt_a input_a_big">
								<option value=""> Select Country </option>
								{{each regCountries}}
									<option value="{{= $value.id }}">{{= $value.text }}</option>
								{{/each}}
							</select>
						</div>
					</div>
					<div class="right_block">
						<div class="sepH_b ccTypesRow">
						<label for="lcardtype" class="lbl_a">Accepted Card Types:</label>
								<div class='ccTypes' id="credit_card_icons">
								</div>
						</div>
						<div class="sepH_b">
							<label for="lcardnumber" class="lbl_a">Card Number:</label>
							<input type="text" id="cardNumber" name="cardNumber" class="login-input" maxlength="19" />
						</div>
						<div class="sepH_b">
							<div class="cardExpiryBox">
								<label for="lcardnumber" class="lbl_a">Card Expiration:</label>
								<select id="cardExpirationMonth" name="cardExpirationMonth" class="user_role inpt_a">
									<option selected value="">Month</option>
									<option value="Jan">Jan</option>
									<option value="Feb">Feb</option>
									<option value="Mar">Mar</option>
									<option value="Apr">Apr</option>
									<option value="May">May</option>
									<option value="Jun">Jun</option>
									<option value="Jul">Jul</option>
									<option value="Aug">Aug</option>
									<option value="Sep">Sep</option>
									<option value="Oct">Oct</option>
									<option value="Nov">Nov</option>
									<option value="Dec">Dec</option>
								</select>
								<select id="cardExpirationYear" name="cardExpirationYear" class="user_role inpt_a">
									
<option selected value="">Year</option>

<option value="2022">2022</option>

<option value="2023">2023</option>

<option value="2024">2024</option>

<option value="2025">2025</option>

<option value="2026">2026</option>

<option value="2027">2027</option>

<option value="2028">2028</option>

<option value="2029">2029</option>

<option value="2030">2030</option>

<option value="2031">2031</option>

<option value="2032">2032</option>

<option value="2033">2033</option>

<option value="2034">2034</option>

<option value="2035">2035</option>

<option value="2036">2036</option>

<option value="2037">2037</option>

<option value="2038">2038</option>

<option value="2039">2039</option>

<option value="2040">2040</option>

<option value="2041">2041</option>

<option value="2042">2042</option>

<option value="2043">2043</option>

<option value="2044">2044</option>

<option value="2045">2045</option>

<option value="2046">2046</option>

<option value="2047">2047</option>

<option value="2048">2048</option>

<option value="2049">2049</option>

<option value="2050">2050</option>

<option value="2051">2051</option>

<option value="2052">2052</option>

<option value="2053">2053</option>

<option value="2054">2054</option>

<option value="2055">2055</option>

<option value="2056">2056</option>

<option value="2057">2057</option>

<option value="2058">2058</option>

<option value="2059">2059</option>

<option value="2060">2060</option>

<option value="2061">2061</option>

<option value="2062">2062</option>

<option value="2063">2063</option>

<option value="2064">2064</option>

<option value="2065">2065</option>

<option value="2066">2066</option>

<option value="2067">2067</option>

<option value="2068">2068</option>

<option value="2069">2069</option>

<option value="2070">2070</option>

<option value="2071">2071</option>

<option value="2072">2072</option>


								</select>
							</div>
							<div class="cvvBox">
								<label for="lcvv" class="lbl_a">CVV:</label>
								<input type="text" id="cvvNumber" name="cvvNumber" class="login-input" maxlength="4" />
							</div>
							<input type="hidden" class="txtInputFormReg" name="txtcardTypeHidden" id="txtcardTypeHidden" />
							<input type="hidden" class="txtInputFormReg" name="txtcardExpirationMonthHidden" id="txtcardExpirationMonthHidden" />
							<input type="hidden" class="txtInputFormReg" name="txtcardExpirationYearHidden" id="txtcardExpirationYearHidden" />
							<input type="hidden" class="txtInputFormReg" name="schemeTypeHidden" id="schemeTypeHidden" />
							<span id="chargingfee" name="chargingfee" style="display:none;"></span>
							<span id="subdomainName" name="subdomainName" style="display:none;"></span>
							<span id="userEmail" name="userEmail" style="display:none;"></span>
							<input type="hidden" id="ccResponseCustNum" name="ccResponseCustNum"/>
							<input type="hidden" id="hidBoolFromLoginPage" name="hidBoolFromLoginPage" value="true"/>
							<input type="hidden" id="hidSubDomainName" name="hidSubDomainName" />
						</div>	        
					</div>
				</div>
			</form>
			<div class="captchaContainer"></div>
			<div class="pricingBox">
				<div class="pricingText">
					Plans can be modifed after you subscribe.
				</div>
				<div class="customEnterprisePricingOptionsMonthly">You Pay $<span id="customEnterpriseTotalCost"></span> Every Month</div>
				<div class="customEnterprisePricingOptionsAnnually">You Pay $<span id="customEnterpriseAnnualCost"></span> Every 12 Months</div>
				<div class="NMonthPrice">You Pay $<span class='NMonthCost'></span> Every <span class="customMonth">X</span> Months</div>
				<div class="pricingOptions">
					<div id="monthly_price" class="pricing_options">
						<input type="radio"  value="1"  id="radDetPaymentMode_month" name="radDetPaymentMode"> Pay Monthly $<span id="pricingBrkTotalCost_det"></span> <span id="pricingDiscTotalCost_det" style="display:none;"></span>
						<input type="hidden" id="hidPricingBrkTotalCost_det" value='' />
					</div>		
					<div id="yearly_price" class="pricing_options">
						<input type="radio"  value="12" id="radDetPaymentMode_year" name="radDetPaymentMode"> Pay Annually $<span id="pricingBrkAnnCost_det"></span> * <span id="pricingDiscAnnualCost_det" style="display:none;"></span><b id="lblSaveOnAnnual">(save $<span id='spnAnnDiscVal4'>0</span>)</b><br /><span style="font-size: 10px;">* with prepaid annual subscription</span><br />
					</div>
				</div>
				<div class="purchase-guidelines">
					For your convenience, your subscription will be automatically renewed at the end of the term to prevent any disruption in service. The credit card we have on record will be charged the same amount at the same (monthly or annual) term unless you provide 30 days advanced notice to cancel your subscription. Please note that our prices may change in the future, but we will provide you 30 days advanced notice of any changes.
				</div>
				<div class="salesTaxMsg">
			  		Please note that any applicable sales tax will also be charged.
			  		<br> Contact us at <a href="mailto:salestax@egnyte.com">salestax@egnyte.com</a> if your organization is tax exempt.
		  		</div>
				<div class="tos-box"></div>
			</div>
			<div class="sepH_button">
				<button id="subsButton" class="btn btn-primary" type="button">Subscribe</button>
			</div>
		</div>
		<div class="plan-summary sub-panel">
			<div class="plan_info_container">
				<div class="plan_params">
					<div class="topheader">
						<label class="curr_plan lbl_a">Your Current Plan: <span id="planName"></span></label>
					</div>
					<div class="sepH_a">
						<div class="plan-label"><span id="planName_inner"></span> plan includes:</div>
						<ul class="plan-features">
							<li><span id="powerUsers"></span> Power Users</li>
							<li><span id="stdUsers"></span> Standard Users</li>
							<li><span id="storageAmt">GB</span> Online Storage</li>
							<li id="olcisenabled"></li>
						</ul>
					</div>
					<div class="plan_additionals">
						Additional items:
						<ul class="plan-features" id="addnlPlanItems"></ul>
					</div>
				</div>
				<div class="change_plan">
					<button id="changePlanButton" class="btn_a btn" type="button">Change Plan</button>
				</div>
			</div>
			<div class="price_summary">
				<span class="price_label"></span>
				<br/>
				<span class="price_addnl_msg"></span>
			</div>
		</div>
	</div>
</script>
<!--	Current plans mode - End		-->

<!--	Credit Card details mode - Start		-->
<script id="ccDetailsTemplate" type="text/x-jquery-tmpl">
	<div class="validationMsg validationMsg-error" id="hsErrorMessageContainer"><p><strong id="strValidationMsg"></strong></p></div>
	<form method="post" class="form" id="frmLoginCCProfile" name="frmLoginCCProfile">
	 	<div class="topheader">
			<label for="lusername" class="lbl_a">Secure Payment Info:</label>
		</div>
		<div class="block_container">
			<div class="left_block">
				<div class="sepH_a">
					<label for="name" class="lbl_a">Name:</label>
					<input type="text" id="nameAsOnCard" name="nameAsOnCard" class="inpt_a" />
				</div>
				<div class="sepH_b">
					<label for="streetaddress" class="lbl_a">Street Address:</label>
					<input type="text" id="streetAddress" name="streetAddress" class="inpt_a" />
				</div>
				<div class="sepH_a">
					<label for="zipcode" class="lbl_a">Zip Code:</label>
					<input type="text" id="zipCode" name="zipCode" class="inpt_a" />
				</div>
			</div>
			<div class="right_block">
				<div class="sepH_b">
					<label for="lcardtype" class="lbl_a">Card Type:<a href="#" class="hintanchor"><img src="images/icons/icon_bot.gif" border="0"></a></label>
					<select id="cardType" name="cardType" class="user_role inpt_a">
						<option value="VISA">Visa</option>
						<option value="MASTERCARD">Mastercard</option>
						<option value="AMEX">American Express</option>
						<option value="DISCOVER">Discover</option>
					</select>
				</div>
				<div class="sepH_b">
					<label for="lcardnumber" class="lbl_a">Card Number:</label>
					<input type="text" id="cardNumber" name="cardNumber" class="inpt_a" />
				</div>
				<div class="sepH_b">
					<label for="lcardnumber" class="lbl_a">Card Expiration:</label>
					<select id="cardExpirationMonth" name="cardExpirationMonth" class="user_role inpt_a">
						<option selected value="">Month</option>
						<option value="Jan">Jan</option>
						<option value="Feb">Feb</option>
						<option value="Mar">Mar</option>
						<option value="Apr">Apr</option>
						<option value="May">May</option>
						<option value="Jun">Jun</option>
						<option value="Jul">Jul</option>
						<option value="Aug">Aug</option>
						<option value="Sep">Sep</option>
						<option value="Oct">Oct</option>
						<option value="Nov">Nov</option>
						<option value="Dec">Dec</option>
					</select>
					<select id="cardExpirationYear" name="cardExpirationYear" class="user_role inpt_a">
						
<option selected value="">Year</option>

<option value="2022">2022</option>

<option value="2023">2023</option>

<option value="2024">2024</option>

<option value="2025">2025</option>

<option value="2026">2026</option>

<option value="2027">2027</option>

<option value="2028">2028</option>

<option value="2029">2029</option>

<option value="2030">2030</option>

<option value="2031">2031</option>

<option value="2032">2032</option>

<option value="2033">2033</option>

<option value="2034">2034</option>

<option value="2035">2035</option>

<option value="2036">2036</option>

<option value="2037">2037</option>

<option value="2038">2038</option>

<option value="2039">2039</option>

<option value="2040">2040</option>

<option value="2041">2041</option>

<option value="2042">2042</option>

<option value="2043">2043</option>

<option value="2044">2044</option>

<option value="2045">2045</option>

<option value="2046">2046</option>

<option value="2047">2047</option>

<option value="2048">2048</option>

<option value="2049">2049</option>

<option value="2050">2050</option>

<option value="2051">2051</option>

<option value="2052">2052</option>

<option value="2053">2053</option>

<option value="2054">2054</option>

<option value="2055">2055</option>

<option value="2056">2056</option>

<option value="2057">2057</option>

<option value="2058">2058</option>

<option value="2059">2059</option>

<option value="2060">2060</option>

<option value="2061">2061</option>

<option value="2062">2062</option>

<option value="2063">2063</option>

<option value="2064">2064</option>

<option value="2065">2065</option>

<option value="2066">2066</option>

<option value="2067">2067</option>

<option value="2068">2068</option>

<option value="2069">2069</option>

<option value="2070">2070</option>

<option value="2071">2071</option>

<option value="2072">2072</option>


					</select>
					<input type="hidden" class="txtInputFormReg" name="txtcardTypeHidden" id="txtcardTypeHidden" />
					<input type="hidden" class="txtInputFormReg" name="txtcardExpirationMonthHidden" id="txtcardExpirationMonthHidden" />
					<input type="hidden" class="txtInputFormReg" name="txtcardExpirationYearHidden" id="txtcardExpirationYearHidden" />
					<input type="hidden" class="txtInputFormReg" name="schemeTypeHidden" id="schemeTypeHidden" />
				</div>
				<div class="sepH_b">
					<label for="lcvv" class="lbl_a">CVV Number:</label>
					<input type="text" id="cvvNumber" name="cvvNumber" class="inpt_a" />
					<span id="chargingfee" name="chargingfee" style="display:none;"></span>
					<span id="subdomainName" name="subdomainName" style="display:none;"></span>
					<span id="userEmail" name="userEmail" style="display:none;"></span>
					<input type="hidden" id="ccResponseCustNum" name="ccResponseCustNum"/>
					<input type="hidden" id="hidBoolFromLoginPage" name="hidBoolFromLoginPage" value="true"/>
					<input type="hidden" id="hidSubDomainName" name="hidSubDomainName" />
				</div>
			</div>
		</div>
	    <div class="content_btm active"></div>
		<div class="sepH_button">
			<button id="submitButton" class="btn_a btn" type="button">Submit</button>
	    </div>
	</form>
</script>
<!--	Credit Card details mode - End		-->

<!--	CC Auth Success template - Start		-->
<script id="ccAuthSuccessTemplate" type="text/x-jquery-tmpl">
	<div class="validationMsg validationMsg-error" id="hsErrorMessageContainer"><p><strong id="strValidationMsg"></strong></p></div>
	<div class="clear"></div>
    <p>Thank you. You will receive an email confirmation for the charge to your card.</p>
    <div class="sepH_button">
		<button id="okButton" class="btn_a btn" type="button">Ok</button>
    </div>
</script>
<!--	CC Auth Success template - End		-->

<script id="tos_privacy_policy_tmpl" type="text/x-jQuery-tmpl">
	<div class="tosErrorContainer">Please acknowledge the Egnyte Terms of Service and Privacy Policy</div>
	<input id="chkTosPolicy" name="chkTosPolicy" type="checkbox" class="tos-check"/>
	<span class="tos-note policy">By clicking this box, you are confirming that you have read and agree to Egnyte's
	<a
		{{if isEnterprisePlan}}
			href="https://www.egnyte.com/enterprise-tos/services-agreement.html"
		{{else}}
			href="https://www.egnyte.com/corp/terms_of_service.html"
		{{/if}}
		target="_blank">Terms of Service</a>
	 and <a href="https://www.egnyte.com/corp/privacy_policy.html" target="_blank">Privacy Policy</a></span>
</script>


	<!--	Legacy Settings	- Start		-->


	<img id="cjTrackingPixel" height="1" width="20">


	<!-- 	Underscore templates for Locked Domain screen 	-->

	<!-- 	Template for Change Plan Grid	-->
	<script type="text/template" id="cp-feature-template">
		<div class="info-col" plan="{{=plan.escape('name')}}">
    		<h2><span class='planName'>{{=_(plan.escape('name')).capitalize()}}</span>&nbsp;Plan</h2>
    		<div class="planSummary">
    			<div class="summaryCost">
    				{{ if(plan.get('lowValuePlan')) { }}
    					<strong>{{= plan.get('lowValuePlan').price }}</strong>
    					<span class="costBasis">{{= plan.get('lowValuePlan').costBasis }}</span>
    				{{ } else { }}
    					<strong>{{= _(plan.escape('cost')).formatPrice('changePlan') }}</strong>
    					<span class="costBasis">{{= plan.escape('costBasis') }}</span>
    				{{ } }}
    			</div>
    			<div class="userStorageSummary">
    				{{ if(plan.get('lowValuePlan')) { }}
    					<span class="summaryUserCount">
    						{{= plan.get('lowValuePlan').minPU }} - {{= plan.get('lowValuePlan').maxPU }} Users
    					</span>
    				{{ } else { }}
    					<span class="summaryUserCount">{{= plan.escape('users') }} Users</span>
    				{{ } }}
    				<span class="seperator">/</span>
    				<span class="summaryStorage">{{= plan.escape('storage') }} Storage</span>
    			</div>
    			<input type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-priority-secondary gridButton select-plan-button" value="Select" plan="{{=plan.escape('name')}}">
    		</div>
    		<dl>
				<dt><span class='feature maxFileSize bundled'><div class="indicator"></div><span class='featureHeader'>Max File Size&nbsp;<span class='maxFileSizeLimit'>{{=plan.escape('maxFileSize')}}</span></span></span></dt>
				<dd>Maximum file size limit for a single file.</dd>
			</dl>
			<dl>
				{{ _.each(plan.get('features'), function(feature){ }}
					<dt class="{{=feature.name}}_row {{= feature.lastGridClass }}"><span class='feature {{=feature.name}} {{=feature.featureClass}}'><div class="indicator"></div><span class='featureHeader'>{{=feature.title}}</span></span></dt>
					<dd>{{= feature.description }}
					{{	if(feature.helpUrl){	}}
							<br>[<a href="{{= feature.helpUrl }}" target="_blank">Learn More</a>]
					{{	} }}
					</dd>
				{{ }); }}
			</dl>
		</div>
		{{ if(plan.get('lowValuePlan')) { }}
			<span class="foot-note">Annual subscription required</span>
		{{ } }}
	</script>

	<script id="msp-domain-template" type="text/x-jQuery-tmpl">
		<div class="planInfoContainer msp-domain-container">
			<div class="main-area">
				<div class="icon-column">
					<i class="fa fa-credit-card icon-card"></i>
					<i class="fa fa-external-link-square icon-arrow"></i>
				</div>
				<div class="info-column">
					{{if isCenturyLinkDomain }}
						<div class="info-heading">Your billing is managed as part of your subscription with CenturyLink.</div>
						<div class="info-desc">Please visit your management console in CenturyLink to make changes to your Egnyte account.</div>
					{{else}}
						<div class="info-heading">Your billing is being managed by an external provider.</div>
						<div class="info-desc">Please contact your service provider to make changes to the account.</div>
					{{/if}}
				</div>
			</div>
		</div>
	</script>

	
        
        
            <!-- Check for user validation, enabling & access control - Start   -->
    </body>
</html>
