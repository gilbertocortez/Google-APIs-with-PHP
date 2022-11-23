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

// Receive the RAW Audio data
$content = trim(file_get_contents("php://input"));

// Generate parameters for API request
$parameters = '{
    "config": {
        "encoding": "WEBM_OPUS",
        "languageCode": "en-US",
        "sampleRateHertz": 48000,
        "audioChannelCount": 1,
        "alternativeLanguageCodes": [],
        "speechContexts": [],
        "adaptation": {
          "phraseSets": [],
          "phraseSetReferences": [],
          "customClasses": []
        },
        "enableWordTimeOffsets": true,
        "enableWordConfidence": true,
        "model": "default"
      },
      "audio": {
        "content": "' . base64_encode($content) .'"
      }
  }';

$response = $_cURL->post_request("https://speech.googleapis.com/v1p1beta1/speech:recognize", $parameters);

// Debug
//echo '<pre>';
//print_r($response);
//echo '</pre>';

$async_response = new stdClass();
$async_response->response_received_data = 'Audio data was received';
$async_response->response_received_transcript = $response->results[0]->alternatives[0]->transcript;
$async_response = json_encode($async_response);
echo $async_response;
