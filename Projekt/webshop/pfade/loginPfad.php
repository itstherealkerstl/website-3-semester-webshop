<?php

//wenn Post im Form abgesendet wird
$isPost = $dienste->isPost();

//Variablen
$username = "";
$passwort = "";

//Fehermeldungen
$fehlermeldungen = [];
$gibtesFehlermeldungen = false;

//Wenn Post dann prüfe:

if ($isPost) {

    //Mit Filter nimmt man eine Variable von Außen und Filtert sie optional
    //z.B: bei Username keine Sonderzeichen

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $passwort = filter_input(INPUT_POST, 'password');


        if (false === (bool)$username) {
            $fehlermeldungen[] = "Benutzername ist leer";
        }

        if (false === (bool)$passwort) {
        $fehlermeldungen[] = "Passwort ist leer";
        }


        $userDaten = $userclass->getUserDatenvomUsernamen($username);

        if ((bool)$username && 0 === count($userDaten)) {
        $fehlermeldungen[] = "Benutzername exestiert nicht";
        }

        //wenn der User data nicht null ist dann is mein Account noch nicht aktiveriet
        if((bool)$username && isset($userDaten['activationKey']) &&
        false === is_null($userDaten['activationKey'])){
            $fehlermeldungen[]= "Account wurde noch nicht aktiviert";
        }

        if ((bool)$passwort && isset($userDaten['password']) &&
            //verlgeicht ob das Passwort dem Hash entspricht
            false === password_verify($passwort, $userDaten['password'])) {
            $fehlermeldungen[] = "Passwort stimmt nicht";
        }

        //wenn es keine Fehlermeldungen mehr gibt
        if (0 === count($fehlermeldungen)) {

                //UserID mit Session ID
                $_SESSION['userID'] = (int)$userDaten['id'];

                //UserBerechtigung USER oder ADMIN mit userRights
                $_SESSION['userRights'] = $userDaten['userRights'];

                //umleitung auf index.php
                $umleitung = $baseURL . 'index.php';

                if (isset($_SESSION['redirectTarget'])) {
                $umleitung = $_SESSION['redirectTarget'];
                }

        header("Location: " . $umleitung);
        exit();
        }
}

//zählt von oben bis unten durch ob es Fehlermeldungen gibt
$gibtesFehlermeldungen = count($fehlermeldungen) > 0;