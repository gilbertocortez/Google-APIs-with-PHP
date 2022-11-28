<?php
// -------------------------------------------------------------------------------------------------------------------
// Project:     Google Translation API
// Technology:  PHP, cURL, HTML, CSS
// Author:      Gilberto Cortez
// Website:     InteractiveUtopia.com
// -------------------------------------------------------------------------------------------------------------------

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

// Build cURL Request Parameters
$parameters = new stdClass();
// Required - Text to translate. Can be a string or an array with multiple strings
$parameters->q = [
    "This is an example on how to use the Google Translation API with PHP and cURL",
    "My name is Gilberto, the Web Development Guy with Interactive Utopia"
];
// Required - Target language for translation
$parameters->target = "es";
// Optional - Source language of input text
$parameters->source = "en";
// Optional - Format of input text (text or html)
$parameters->format = "text";
// Build JSON from $parameters object
$json_parameters = json_encode($parameters);

// Make cURL POST request and store response on a variable and on SESSION
$response = $_cURL->post_request("https://translation.googleapis.com/language/translate/v2", $json_parameters);
$_SESSION['response'] = $response;

// Debug - Print Out Response
//echo '<pre>'; print_r($_SESSION['response']); echo '</pre>';
?>
<!-- HTML Code -->
<div class="container">
    <h1>Google Translate API Example</h1>
    <h2>Response Results</h2>
    <p>Here are the results from the translation request sent to the Google Translate API</p>
    <?php
    // Loop the results to display the translated text
    foreach ($_SESSION['response']->data as $data_key => $translations) {
        foreach ($translations as $key => $translated_text_object) {
    ?>
            <hr />
            <p class="text_tranlsated"><?= $translated_text_object->translatedText; ?></p>
            <p class="text_original">Original: <?= $parameters->q[$key]; ?></p>
    <?php
        }
    }
    ?>
</div>

<!-- CSS Styles --
        - Basic styles for HTML used to display results
-->
<style>
    .container {
        margin: 0 auto;
        width: 90%;
    }

    h1 {
        text-align: center;
    }

    .text_tranlsated {
        text-align: center;
        font-style: italic;
    }

    .text_original {
        text-align: center;
        font-size: .75rem;
    }
</style>