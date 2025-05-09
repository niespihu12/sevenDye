<?php



function googleClient() {
    $client = new Google_Client();
    $client->setClientId($_ENV['GOOGLE_ID']);
    $client->setClientSecret($_ENV['GOOGLE_SECRET']);
    $client->setRedirectUri($_ENV['PROJECT_URL']."/google/callback");
    $client->addScope("email");
    $client->addScope("profile");
    return $client;
}