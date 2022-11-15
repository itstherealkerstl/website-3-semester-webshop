<?php


//die session starten
session_start();


//Konstanten config und storage
define('CONFIG_DIR', __DIR__.'/config');
define('STORAGE_DIR', __DIR__ . '/storage');


//Datenbank Anmeldedaten
require 'config/config.php';


//einzelne Pfade
require 'routen.php';



