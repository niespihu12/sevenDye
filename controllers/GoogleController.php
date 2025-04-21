<?php

namespace Controllers;

use Google_Service_Oauth2;
use Model\Usuario;

class GoogleController {

    public static function login() {
        $client = googleClient();
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }

    public static function callback() {
        $client = googleClient();

        if (!isset($_GET['code'])) {
            header('Location: /login');
            exit;
        }

        // Obtener token y datos
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        $oauth = new Google_Service_Oauth2($client);
        $google_user = $oauth->userinfo->get();

        // Buscar o crear usuario
        $usuario = Usuario::where('email', $google_user->email);

        if (!$usuario) {
            $usuario = new Usuario([
                'nombre' => $google_user->name,
                'email' => $google_user->email,
                'avatar' => $google_user->picture,
                'confirmado' => 1,
                'contraseña' => bin2hex(random_bytes(10)), 
                'referencia' => uniqid(),
                'rolId' => 1
            ]);
            $usuario->hashPassword();
            $usuario->guardar();
        }
        session_start();

        // Iniciar sesión
        $_SESSION['id'] = $usuario->id;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['login'] = true;

        if($usuario->rolId === "2"){
            $_SESSION['rolId'] = $usuario->rolId ?? null;
            header('Location: /admin');

        }else{
            header('Location: /');
        }
    }
}
