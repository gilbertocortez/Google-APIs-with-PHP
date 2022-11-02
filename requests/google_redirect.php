<?php
require '../vendor/autoload.php';
// This file will handle Google API Redirect Requests
// Log In Redirect
$url = 'https://interactiveutopia.com/';

// Initiate Google Client API Class
$client = new Google_Client();
// Provide authentication token
$client->setAuthConfig('../_private/client_secret.json');
// Request required API scope
$client->addScope('https://www.googleapis.com/auth/yt-analytics.readonly');
$client->addScope('https://www.googleapis.com/auth/yt-analytics-monetary.readonly');
$client->addScope('https://www.googleapis.com/auth/youtube');
$client->addScope('https://www.googleapis.com/auth/youtubepartner');
$client->addScope('https://www.googleapis.com/auth/cloud-platform');
// Provide return redirect url
$client->setRedirectUri($url . '_dev/youtube/google_api/handlers/log_in_scope_request.php');
// offline access will give you both an access and refresh token so that
// your app can refresh the access token without user interaction.
$client->setAccessType('offline');
// Using "consent" ensures that your application always receives a refresh token.
// If you are not using offline access, you can omit this.
//$client->setApprovalPrompt("force");
$client->setIncludeGrantedScopes(true);   // incremental auth

// Create Google log in url
$auth_url = $client->createAuthUrl();

// Redirect user to Google OAuth log in page
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));