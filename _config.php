<?php
error_reporting(1);
$session_id = session_id();
if (empty($session_id)) {
    session_start();
}
//Redirecting WWW TO NON WWW
ob_start();
if (substr($_SERVER['SERVER_NAME'], 0, 4) === 'www.') {
    header('Location: https://' . substr($_SERVER['SERVER_NAME'], 4));
    exit();
    exit();
}
date_default_timezone_set('EST');
ini_set('display_errors', 0);
define("DB_TYPE", "mysqli");
define("DB_HOST", "localhost:3600");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "fireon_brandon");
define('TABLE_PREFIX', "sh_");
define('URL_PATH', 'https://localhost/shortguy/');
define('SITE_URL', 'https://localhost/shortguy');
define('SITE_AJAX_URL', 'https://localhost/shortguy/operations/process-Ajax.php');
define("SITE_RUNNING", "yes");
define('URL_PATH_ADMIN', 'https://localhost/shortguy/admin-panel/');
// Define a few commonly used constants
define('PUN_UNVERIFIED', 0);
define('PUN_ADMIN', 1);
define('PUN_MOD', 2);
define('PUN_GUEST', 3);
define('PUN_MEMBER', 4);

if (!defined('FB_APP_ID')) {
    define('FB_APP_ID', '1615187732099069');
}
if (!defined('PAYPAL_ENV')) {
    define('PAYPAL_ENV', 'PRODUCTION');
    if (PAYPAL_ENV == 'TESTING') {
        $paypal_endpoint = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $paypal_merchant_email_address = 'sandbox@ateyelevel.co';
    }
    if (PAYPAL_ENV == 'PRODUCTION') {
        $paypal_endpoint = 'https://www.paypal.com/cgi-bin/webscr';
        $paypal_merchant_email_address = 'evertonrecords@hotmail.com';
    }
}
if (!defined('ADMIN_EMAIL')) {
    define('ADMIN_EMAIL', 'evertonrecords@hotmail.com');
}
//Set Global Variable For Connection
$GLOBALS["DB_HOST"] = DB_HOST;
$GLOBALS["DB_USER"] = DB_USER;
$GLOBALS["DB_PASS"] = DB_PASS;
$GLOBALS["DB_NAME"] = DB_NAME;
$conn = mysqli_connect($GLOBALS["DB_HOST"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASS"]);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!mysqli_select_db($conn, $GLOBALS["DB_NAME"])) {
    die("Database selection failed: " . mysqli_error($conn));
}
