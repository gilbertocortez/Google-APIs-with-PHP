<?php
// -------------------------------------------------------------------------------------------------------------------
// Project:     Google Authenticator (App) as 2-Factor Authorization using a timestamped one time password
// Technology:  PHP, HTML, CSS
// Author:      Gilberto Cortez
// Website:     InteractiveUtopia.com
// -------------------------------------------------------------------------------------------------------------------

// Start Server Session
session_start();

// Display All Errors (For Easier Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include composer packages
require '../vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

// Initiate antonioribeiro/google2fa object
$_g2fa = new Google2FA();

// Retrieve user data
$user = $_SESSION['g2fa_user'];

// Retrieve One Time Password from URL (DO NOT do this in production)
$otp = $_GET['otp'];

// Verify provided OTP (Will return true or false)
$valid = $_g2fa->verifyKey($user->google2fa_secret, $otp);

// Generate and print JSON response to send back results
$response = new stdClass();
$response->provided_otp = $otp;
$response->result = $valid;
$response = json_encode($response);
echo $response;
