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
$parameters = '{
    "input": {
      "ssml": "<speak>The <say-as interpret-as=\"characters\">SSML</say-as>
      standard <break time=\"1s\"/>is defined by the
      <sub alias=\"World Wide Web Consortium\">W3C</sub>.</speak>"
    },
    "voice": {
      "languageCode": "en-US",
      "name": "en-US-News-N",
      "ssmlGender": "MALE"
    },
    "audioConfig": {
      "audioEncoding": "OGG_OPUS"
    }
  }';

// Make cURL call and store response on variable and on SESSION
//$response = $_cURL->post_request("https://texttospeech.googleapis.com/v1beta1/text:synthesize", $parameters);
//$_SESSION['response'] = $response;

// Alternative Way of Storing Audio to a File
//$content = base64_decode($_SESSION['response']->audioContent);
//file_put_contents('test.mp3', $content);

// Debug
//print_r($_SESSION['response']);
?>

<!-- HTML Code -->
<div class="container">
    <h1>Google Text to Speech API</h1>
    <p>Example by Gilberto Cortez - Interactive Utopia</p>

    <!-- Alternative way to display stored audio file
    <audio id="sample_audio_container" controls>
        <source src="test.mp3" type="audio/mp3">
    </audio>
    -->
    
    <audio id="sample_audio_container" controls>
        <source src="data:audio/ogg;base64,<?=$_SESSION['response']->audioContent?>" type="audio/mp3">
    </audio>

    <p><a href="../">Go Back</a></p>
</div>