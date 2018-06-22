<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//google api AIzaSyDgfXeqTWhM1bpTV7dk0G6VU5TH3Fy5Wxk AIzaSyBEkQm60PH4j5zb15AgbHx9ulJcEiQDzWo
define('GOOGLE_API_KEY', 'AIzaSyB6FQ49u11K2IKDN3bt_KhdvGWQJuFVioI');

// stripe api key automatically-assigned error code
define('STRIPE_KEY', 'sk_test_W1yoGObSKSM98ZPSvnB6WhAx');//sk_live_n8j2scWI3zJpirHDEpeTreKK
//From email address
define('FROM_EMAIL', 'kumarireshma@glowtouch.com');
define('ADMIN_EMAIL', 'shreekumark1@gmail.com');
define('PRICE_INCREMENT', '0.5');
define('PRICE_INCREMENT_DAILY', '2');
//in cents
define('APPLICATION_FEE', 123);
//in dolar
define('APPLICATION_FEE_DOLAR', 1.23);


define('START_REMINDER_BEFORE', '60');
// one hour
define('END_REMINDER_BEFORE', '60');
define('TOTAL_BOOKING_DAYS', '30');
define('DRIVEWAY_DISTANCE', '1000');
define('MINUTES_TO_ADD', '6');

define('UTC', 'UTC');
define('DATE_TIME', 'Y-m-d H:i:s');
define('DATE_FORMAT', 'Y-m-d');
define('TIME_FORMAT', 'H:i:s');
define('TIME_FORMAT_AM_PM', 'Y-m-d h:i:s A');
define('DATE_FORMAT_MDY', 'm/d/Y');
define('DATE_FORMAT_MMDDYY', 'm/d/Y H:i:s');


define('STRIPE_PATH', 'libraries/Stripe/init.php');
define('STRIPE_LIB_PATH', 'libraries/Stripe/lib/Stripe.php');

define('US', 'US');
define('REGARDS', 'Thanks<br>LouiePark');
define('BEGIN_REMINDER_SUBJECT', 'LouiePark Driveway Begin Reminder');
define('RELEASE_REMINDER_SUBJECT', 'LouiePark Driveway End Reminder');
//  in percentage
define('STRIPE_FEE', 2.9);
define('STRIPE_FEE_PROCESS', 0.3);
define('INVALID_CONFIRM_CODE', 'Invalid confirm code.');
define('INVALID_RESET_CODE', 'Invalid reset code.');
define('SELECTED', 'selected');
define('NO_TIME', '00:00:00');

define('LOGGED_IN', 'logged_in');
define('LOGGED_FB', 'logged_fb');
define('LOGGED_IN_ADMIN', 'logged_in_admin');

define('DRIVEWAY_SEARCH', 'driveway_search');

define('TBL_USERS', 'tbl_users');
define('TBL_DRIVEWAY', 'tbl_driveway');
define('TBL_VEHICLE_TYPE', 'tbl_vehicle_type');
define('TBL_BOOKING', 'tbl_booking');

define('PARKER', 'parker');
define('RENTER_SIGNUP', 'renter/signup');
define('DRIVEWAYID', 'drivewayID');
define('DRIVEWAY_ID', 'drivewayId');
define('DRV_ID', 'driveway_id');

define('USERID', 'userID');
define('USRID', 'userId');

define('BOOKINGID', 'bookingID');
define('LOGIN', 'login');
define('DASHBOARD', 'dashboard');
define('END_DIV','</div>');
define('VERIFICATION_STATUS','verificationStatus');
define('STATUS','status');
define('FROM_DATE','fromDate');
define('TO_DATE','toDate');
define('FROM_TIME','fromTime');
define('TO_TIME','toTime');

define('FROMDATE','fromdate');
define('TODATE','todate');


define('FEEDBACK_COUNT','feedbackcount');
define('USERNAME','userName');
define('USER_NAME','username');

define('EMAIL','email');
define('BUILDING','building');
define('STREET_ADDRESS','streetAddress');
define('STREET','street');
define('ROUTE','route');
define('STATE','state');
define('COUNTRY','country');

define('MESSAGE','message');
define('DAILYPRICE','dailyprice');
define('DPRICE','dPrice');
define('PRICE','price');
define('SEARCH_TYPE','searchtype');
define('LATITUDE','latitude');
define('LONGITUDE','longitude');
define('VEHICLE','vehicle');
define('CARDS','cards');
define('H_I_S_A','h:i:s A');
define('VISITED_DRIVEWAY','visitedDriveway');
define('USER_ID','user_id');
define('UPLOAD','upload');
define('SIGNUP_TYPE','signupType');
define('FB_PROFILE','fbProfile');
define('REGEXP_NUMBER','/[^A-Za-z0-9]/');
define('FIRST_NAME','firstName');
define('LAST_NAME','lastName');
define('MODEL','model');
define('PHONE','phone');
define('BMONTH','bmonth');
define('BYEAR','byear');
define('SUCCESS','success');
define('ACCOUNTHOLDER_TYPE','accHolderType');
define('CURRENCY','currency');
define('ACCHOLDER_NAME','accHolderName');
define('SECRET_KEY','secretKey');
define('PUB_KEY','pubKey');
define('PROF_IMAGE','profImage');
define('LOCATION_IMAGE_PATH','location_image_path');
define('UPLOAD_PATH','upload_path');
define('FILE_NAME','file_name');
define('DRIVEWAY_PHOTOS','drivewayphotos');
define('USER_FILE','userFile');
define('ERROR','error');
define('ROUTING_NUMBER','routing_number');
define('ACCOUNT_NUMBER','account_number');
define('SSN_LAST_4','ssn_last_4');
define('DATE_SETTING','dateSetting');
define('TIME_SETTING','timeSetting');
define('DRIVEWAY_SETTINGS','Driveway_settings');
define('DRIVEWAY_VERIFY','drivewayverify');
define('RESET','reset');
define('RESULTS','results');
define('RESULT','result');
define('DAY_OPTION','day_option');
define('CUSTOMERID','customerId');
define('EXPIRATION_DATE','expiration_date');
define('NAMEON_CARD','nameon_card');
define('BILLING_STREET','billing_street');
define('BILLING_CITY','billing_city');
define('BILLING_STATE','billing_state');
define('BILLING_ZIP','billing_zip');
define('CHARGEID','chargeId');
define('TOKEN','token');
define('PROFILE','profile');
define('COLOR','color');
define('VEHICLE_NUMBER','vehicleNumber');
define('RATINGS','ratings');
define('REVIEWS','reviews');
define('DESCRIPTION','description');
define('INSTRUCTIONS','instructions');

define('EMAILID','emailId');
define('EMAIL_ID','emailID');

define('TBL_DRIVEWAY_DAY_SETTINGS','tbl_driveway_day_settings');
define('TBL_DRIVEWAY_DATE_SETTINGS','tbl_driveway_date_settings');
define('FB_TOKEN','fb_token');

define('DRIVEWAYSETTING','drivewaysetting');
define('TBL_DRIVEWAY_AS_DRV','tbl_driveway as drv');
define('TBL_USERS_AS_USER','tbl_users as user');
define('DATA_B','data_b');
define('PROFILE_IMAGE','profileImage');

define('BOOKING_STATUS','bookingStatus');
define('ASSETS_UPLOADS_DRIVEWAY','assets/uploads/driveway/');
define('KEY','", key: "');
define('URL','", url: "');
define('CAPTION','{caption: "');
define('USERMANAGEMENT_API_DELETE_FILE','usermanagement/api/delete_file/');

define('ENCRYPTION_KEY_256BIT', 'KIKw042wteQgSPhKi1qIQSWVvXfzMgeCB3CSbEynsuk=');



