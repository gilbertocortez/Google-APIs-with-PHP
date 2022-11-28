<?php
session_start();
require '../vendor/autoload.php';

$url = 'https://interactiveutopia.com/';

// Star new Google API Instance
$client = new Google_Client();
// Provide credentials
$client->setAuthConfig('../_private/client_secret.json');

// Set scope required
$client->addScope('https://www.googleapis.com/auth/yt-analytics.readonly');
$client->addScope('https://www.googleapis.com/auth/yt-analytics-monetary.readonly');
$client->addScope('https://www.googleapis.com/auth/youtube');
$client->addScope('https://www.googleapis.com/auth/youtubepartner');
$client->addScope('https://www.googleapis.com/auth/cloud-platform');
$client->addScope('https://www.googleapis.com/auth/cloud-translation');

// Set redirect Url after user log in in Google server
$client->setRedirectUri($url . '_dev/youtube/google_api/handlers/log_in_scope_request.php');
// Set access type
$client->setAccessType('offline');

// Get autorization code from url
$client->authenticate($_GET['code']);

// Store token information into user session
$token = $client->getAccessToken();
$_SESSION['google_access_tokens'] = $token;

header('Location: ../index.php');
