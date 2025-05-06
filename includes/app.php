<?php

require 'funciones.php';
require 'config/database.php';
require 'config/google.php';
require 'config/square.php';
require __DIR__ . '/../vendor/autoload.php';

$db = conectarDB();
use Model\ActiveRecord;
ActiveRecord::setDB($db);

