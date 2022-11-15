<?php

//Wenn nicht eingeloggt dann auf lieferadresse add umleiten
$dienste->umleitungwennnichteingelogged('/lieferadresse/add');

//Variablen erzeugen
$empfaenger = "";
$stadt = "";
$plz = "";
$strasse = "";
$hausnummer = "";

$empfaengeristrue = true;
$stadtistrue = true;
$plzistrue = true;
$strasseistrue = true;
$hausnummeristrue = true;

$isPost = $dienste->isPost();
$fehlermeldungen = [];

//Lieferadresse holen wenns eine gibt
$lieferadressen = $lieferungenclass->getlieferadressenvomUser($userID);

if($isPost) {

    //Form variablen nochmal mit Filtern filtern
    $empfaenger = filter_input(INPUT_POST,'empfaenger',FILTER_SANITIZE_SPECIAL_CHARS);
    $empfaenger = trim($empfaenger);
    $stadt = filter_input(INPUT_POST,'stadt',FILTER_SANITIZE_SPECIAL_CHARS);
    $stadt = trim($stadt);
    $plz = filter_input(INPUT_POST,'plz',FILTER_SANITIZE_SPECIAL_CHARS);
    $plz = trim($plz);
    $strasse = filter_input(INPUT_POST,'strasse',FILTER_SANITIZE_SPECIAL_CHARS);
    $strasse = trim($strasse);
    $hausnummer = filter_input(INPUT_POST,'hausnummer',FILTER_SANITIZE_SPECIAL_CHARS);
    $hausnummer = trim($hausnummer);


    //Felder überprüfen alles aufgefüllt ect.
    if(!$empfaenger) {
        $fehlermeldungen[] ="Bitte Empfänger eintragen";
        $empfaengeristrue = false;
    }

    if(!$stadt) {
        $fehlermeldungen[] ="Bitte Stadt eintragen";
        $stadtistrue = false;
    }

    if(!$plz) {
        $fehlermeldungen[] ="Bitte PLZ eintragen";
        $plzistrue = false;
    }

    if(!$strasse) {
        $fehlermeldungen[] ="Bitte Straße eintragen";
        $strasseistrue = false;
    }

    if(!$hausnummer) {
        $fehlermeldungen[] ="Bitte Hausnummer eintragen";
        $hausnummeristrue = false;
    }

    //Wenn es keine Fehlermeldungen gibt dann:
    if(count($fehlermeldungen) === 0) {

        //Funktion speichert die Lieferadresse vom user
        $lieferadressenID = $lieferungenclass->saveLieferadressevomUser($userID,$empfaenger,$stadt,$strasse,$hausnummer,$plz);


        //Wenn es eine Lieferadresse gibt dann
        if($lieferadressenID > 0) {

            //Die ID der Lieferadresse wird in der session abgespeichert.
            $_SESSION['lieferadressenID'] = $lieferadressenID;

            //weiter zu Bestellung abschließen (übersicht)
            header("Location: ".$baseURL."index.php/completeOrder");
            exit();
        }

        $fehlermeldungen []="Fehler beim Speichern der Lieferadresse.";
    }

}
$gibtesFehlermeldungen = count($fehlermeldungen)>0;