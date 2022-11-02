<?php
session_start();
// This is a development app to access the Youtube API
// https://youtubeanalytics.googleapis.com/v2

require '../includes/curl.class.php';

$_cURL = new CurlServer($_SESSION['google_access_tokens']['access_token']);

$parameters = array(
    'ids' => 'channel==MINE',
    'startDate' => '2022-10-01',
    'endDate' => '2022-10-31',
    'metrics' => 'views,likes,dislikes,subscribersGained'
);
$http_parameters = http_build_query($parameters);

$response = $_cURL->get_request("https://youtubeanalytics.googleapis.com/v2/reports?$http_parameters");

echo '<pre>';
print_r($response);
echo '</pre>';

