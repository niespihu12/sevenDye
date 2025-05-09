<?php

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';
require 'config/google.php';
require 'config/square.php';

$db = conectarDB();
ActiveRecord::setDB($db);

