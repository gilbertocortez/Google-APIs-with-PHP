<?php
// Start Server Session
session_start();

// Display All Errors (For Easier Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include cURL object file
require '../includes/curl.class.php';
// Initiate cURL Server bject
$_cURL = new CurlServer($_SESSION['google_access_tokens']['access_token']);

// Generate Call Parameters
// Required = q, target
// Optional = source, format
$parameters = '{
    "q": ["This is an example on how to use the Google Translation API with PHP", "My name is Gilberto, the Web Development Guy with Interactive Utopia"],
    "source": "en",
    "target": "es",
    "format": "text"
  }';



// Make cURL call and store response on variable and on SESSION
$response = $_cURL->post_request("https://translation.googleapis.com/language/translate/v2", $parameters);
$_SESSION['response'] = $response;

// Print Out Response
echo '<pre>';
print_r($_SESSION['response']);
echo '</pre>';
