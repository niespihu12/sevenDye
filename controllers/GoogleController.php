<?php

namespace Controllers;

use Google_Service_Oauth2;
use Model\Usuario;

class GoogleController
{

    public static function login()
    {
        $client = googleClient();
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }

    public static function callback()
    {
        $client = googleClient();

        if (!isset($_GET['code'])) {
            header('Location: /login');
            exit;
        }

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        $oauth = new Google_Service_Oauth2($client);
        $google_user = $oauth->userinfo->get();

        $usuario = Usuario::where('email', $google_user->email);

        session_start();

        if (!$usuario) {
            $usuario = new Usuario([
                'referencia' => uniqid(),
                'nombre' => $google_user->name,
                'email' => $google_user->email,
                'contraseña' => bin2hex(random_bytes(10)),
                'confirmado' => 1,
                'rolId' => 1
            ]);
            $usuario->hashPassword();
            $usuario->guardar();
        }
        
        $usuario = Usuario::where('email', $google_user->email);

        $_SESSION['id'] = $usuario->id;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['login'] = true;

        if ($usuario->rolId === "2") {
            $_SESSION['rolId'] = $usuario->rolId ?? null;
            header('Location: /admin');
        } else {
            header('Location: /');
        }
    }
}
