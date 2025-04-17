<?php



function googleClient() {
    $client = new Google_Client();
    $client->setClientId('679346245457-93f6a55pghfep8g7j99hnofgn59um1r2.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:3000/google/callback');
    $client->addScope("email");
    $client->addScope("profile");
    return $client;
}