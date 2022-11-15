<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Klassen einbinden
require_once 'classes/Warenkorb.class.php';
require_once 'classes/User.class.php';
require_once 'classes/Produkt.class.php';
require_once 'classes/Lieferungen.class.php';
require_once 'classes/Dienste.class.php';
require_once 'classes/Bestellung.class.php';

//Klassen mit new erzeugen
$warenkorb = new Warenkorb();
$userclass = new User();
$productclass = new Produkt();
$lieferungenclass = new Lieferungen();
$dienste = new Dienste();
$bestellungclass = new Bestellung();






//Der URI, der angegeben wurde, um auf die aktuelle Seite zuzugreifen index.php
$urlParts = parse_url($_SERVER['REQUEST_URI']);
$url = $urlParts['path'];

//variable mit dem index.php Part
$indexPHPposition = strpos($url, 'index.php');

//was vor der Index.php steht
$baseURL = $url;

//wenn Index.php Position falsch ist dann wir diese neu zusammengesetzt
if(false !== $indexPHPposition) {
    $baseURL = substr($url,0,$indexPHPposition);
}

//Wenn kein / dann einen hinzufügen
if(substr($baseURL,-1) !== '/') {
    $baseURL .='/';
}

//Konstante für die URL
define('BASE_URL',$baseURL);

//Projekt Teil der URL
$projektURL = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. $baseURL;

//URL Pfad Teil als Variable deklarieren
$pfadTeil = null;

//Wenn die index.php Position nicht korrekt
// ist wir diese neu zusammengesetzt
if(false !== $indexPHPposition) {
    $pfadTeil = substr($url, $indexPHPposition);
    $pfadTeil = str_replace('index.php', '',$pfadTeil);
}

//UserID Funktion
$userID = $userclass->getCurretUserID();

//Funktion die Warenkorb Produkte vom User anzeigen (UserID)
$countcartItems = $warenkorb->anzahlderProdukteimWarenkorb($userID);






//wenn der URL Teil nicht mehr null ist
if(!$pfadTeil) {

    //ist Admin true
    $isAdmin = $userclass->isAdmin();

    //werden die Produkte geladen
    $produkte = $productclass->getAllProdukts();

    //Variable für die Nachrichten erstellt
    $benachrichtigungen = $dienste->nachricht();

    //Nachirchten zählen
    $esgibtBenachrichtigungen = count($benachrichtigungen) > 0;

    //Das Main Template wird geladen
    require  __DIR__. '/templates/main.php';
    exit();
}






//Wenn ein Produkt im Warenkorb hinzugefügt wird
if(strpos($pfadTeil,'/cart/add/') !== false) {

    //Ich teile mir die URL Teile auf und hol mir die produkt ID

    $produktIDPfad = explode('/',$pfadTeil);
    $productID = (int)$produktIDPfad[3]; //produkt ID im PfadTeil 3

    //während der Session wird dann das Produkt mit der ProduktID in der URl index.php/cart/add hinzugefügt
    $_SESSION['redirectTarget'] = $baseURL . "index.php/cart/add/" . $productID;

    //Wenn man nicht eingeloggt ist und ein Produkt kaufen will
    //wird man zum Login weitergeleitet
    $dienste->umleitungwennnichteingelogged('/login');

    //dann wird der Warenkorb angezeigt
    $warenkorb->addProduktzumWarenkorb($userID,$productID);

    header("Location: ".$baseURL."index.php");
    exit();
}






//Warenkorb mit Produkten
if(strpos($pfadTeil,'/cart') !== false) {

    //Warenkorb Produkte
    $warenkorbProdukte = $warenkorb->getWarenkorbprodukteforUserID($userID);

    //Summe Warenkorb (wird gezählt aber nicht angezeigt)
    $warenkorbSumme = $warenkorb->getSumfromUserID($userID);

    require __DIR__ . '/templates/warenkorb.php';
    exit();

}






//Login
if(strpos($pfadTeil,'/login') !== false) {

        //Pfad variablen und Methoden in externer Datei weil sonst zu grosse Datei
        require_once '../webshop/pfade/loginPfad.php';

        //Login Design
        require __DIR__ . '/templates/login.php';

        exit();

}






//Produkte Bestellen im Warenkorb
if(strpos($pfadTeil,'/checkout') !== false) {

    //umleitung wenn nicht eingeloggt
    $dienste->umleitungwennnichteingelogged('/checkout');

    //Variablen deklarieren und true setzen
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

    $fehlermeldungen = [];
    $gibtesFehlermeldungen = count($fehlermeldungen)>0;

    //Lieferadressen vom User ausgeben wenn es welche gibt natürlich
    $lieferadressen = $lieferungenclass->getlieferadressenvomUser($userID);

    //Design von der Lieferadressen Form
    require __DIR__.'/templates/lieferadresse.php';
    exit();

}





//Ausloggen
if(strpos($pfadTeil,'/logout') !== false) {

    //weiterleitung auf Index.php
    $umleitung = $baseURL.'index.php';

    //wenn es eine umleitung gibt dann wird die diese in der session gesetzt
    if(isset($_SESSION['redirectTarget'])) {
        $umleitung = $_SESSION['redirectTarget'];
    }

    //Session id die generiert wurde entfernen
    session_regenerate_id(true);

    //Meine Session zerstören
    session_destroy();

    header("Location: ".$umleitung);
    exit();

}




//Lieferadresse wenn vorhanden auswählen
if(strpos($pfadTeil,'/selectDeliveryAdress') !== false) {

    //wenn ich nicht eingelogt bin dann umelitung
    $dienste->umleitungwennnichteingelogged('/checkout');

    //URL Pfad Teil 1 - dort ist meine lieferadressen ID
    $produktIDPfad = explode('/',$pfadTeil);
    $lieferadressenID = (int)$produktIDPfad[1];

    //wenn ich die lieferadresse habe dann gehts weiter zur bestellung abschicken
    if($lieferungenclass->lieferadressediezumUsergehoert($lieferadressenID,$userID)) {

        //Lieferadressen ID in Session
        $_SESSION['lieferadressenID'] = $lieferadressenID;

        //weiterleitung auf complete Bestellung
        header("Location: ".$baseURL."index.php/completeOrder");
        exit();
    }

    //Wenn keine Lieferadresse vorhanden oder gewählt
    // dann auf checkout bleiben
    header("Location: ".$baseURL."index.php/checkout");
    exit();
}




//Lieferadresse hinzufügen
if(strpos($pfadTeil,'/lieferadresse/add') !== false) {

    //Variablen und Funktionen in eigener Datei
    require_once '../webshop/pfade/lieferadresseAddPfad.php';

    //Design Datei
    require __DIR__.'/templates/lieferadresse.php';
    exit();
}



//Bestellübersicht abschließen
if(strpos($pfadTeil,'/completeOrder') !== false) {

    //wenn ich nicht eingeloggt bin umleitung
    $dienste->umleitungwennnichteingelogged('/checkout');

    //warenkorb Produkte nocheinletztes mal anzeigen lassen
    $warenkorbProdukte = $warenkorb->getWarenkorbprodukteforUserID($userID);

    //warenkorb Produkt Summe anzeigen lassen
    $warenkorbSumme = $warenkorb->getSumfromUserID($userID);

    //Bestellübersicht Design
    require __DIR__ . '/templates/bestelluebersichtseite.php';
    exit();
}



//Bestellübersicht abschließen
if(strpos($pfadTeil,'/CompleteOrder') !== false) {

    $dienste->umleitungwennnichteingelogged('/checkout');

    $userID = $userclass->getCurretUserID();
    $warenkorbProdukte = $warenkorb->getWarenkorbprodukteforUserID($userID);

    $bestellungclass->bestellungErstellen($userID,$warenkorbProdukte);
    $warenkorb->clearWarenkorbvomUser($userID);

    //E-Mail vom User - UserID holen
    $email ="";
    $emailExists = $userclass->getEMail($userID);
    //var_dump($emailExists);

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure="tls";
    $mail->Username = "kerstin.hobart@gmail.com";
    $mail->Password = "fsdfnhmtsfvohghu";

    $mail->setFrom("kerstin.hobart@gmail.com", "Dein Shop Team");
    $mail->addAddress($emailExists, $userID);

    $mail->isHTML(true);
    $mail->Subject = "Hallo, ";
    $mail->Body = "Danke für deine Bestellung.";
    $mail->addAttachment('storage/bestellungen/'.$userID.'.txt');

    if($mail->send()){
        $dienste->nachricht('Deine Email wurde erfolgreich verschickt.');

    } else {
        echo "Es gab einen Fehler ".$mail->ErrorInfo;
    }

    //Design Danke Seite
    require __DIR__ . '/templates/dankeseite.php';
    exit();
}



//Probe Pfad um BestellungsID zu holen - aber nur mit Log-In
//und auch eine Bestellüberischt zu speichern
//das multidimensionale Array gibt aber nicht den String so zurück wie ich will

if(strpos($pfadTeil,'/bestellung') !== false) {

    //Bestellungs ID Pfad mit Part 2
    $aktivierungsCodeKey = explode('/',$pfadTeil);
    $bestellungID = null;

    if(isset($aktivierungsCodeKey[2])) {
        $bestellungID = (int)$aktivierungsCodeKey[2]; //zahl statt string damit bestellung 1 / bestellung 2 ect.
    }

    $userID = $userclass->getCurretUserID();

    //bestellungsID und user ID übergeben
    $order = $bestellungclass->getBestellungvomUser($bestellungID, $userID);

    //$produkt = serialize($order['products']);

    $daten = (json_encode($order['products']));
    //var_dump($daten);



    //foreach ($order as $od=> $order['products']) {
     //   echo $od;
     //   foreach ($order['products'] as $odp => $wert ) {
     //       echo $odp . $wert;
     //   }
    //}
   // if(in_array("userId",$order)) {
   //     echo "Produkt";
   // }
    //echo implode(',', array_keys($order));

    //var_dump($order['products'] []);
    //print_r($order);
    //print_r($order[0]);
    //var_dump($order['products']);


    //$status = $order[0];
    //$userid = $order[1];
    //$bestellid = $order[2];

   // var_dump(implode($order['products'])); // Array
    //file_put_contents("storage/bestellungen/".$userID.".txt", "Bestellung: " . $status . " " . $userid . " ". $bestellid);

    //Text File erzeugen mit bestellungs Daten und diese dann per E-Mail senden

    //Funktioniert noch nicht es wird immer nur die grafik gesendet?

    file_put_contents("storage/bestellungen/".$userID.".txt", "Bestellung: " . $daten);

    //wenn es keine Bestellung gibt
    if(!$order) {
        echo "Daten wurden nicht gefunden";
        exit();
    }

    //Bestellungs Daten - nur als Text ausgabe
    require __DIR__.'/templates/bestellung.php';

    exit();
}



//Regestrierung
if(strpos($pfadTeil,'/register') !== false) {

    //Variablen und Funktionen in eigener Datei
    //require_once '../webshop/pfade/registerPfad.php';


    //Variablen definieren und mit leer deklarieren
    $username = "";
    $email ="";
    $emailwiederholung ="";
    $passwort ="";
    $passwortwiederholung ="";

    //für die Errors ein Array
    $fehlermeldungen = [];

    //Wenn is Post erfüllt ist wird etwas gemacht
    if ($dienste->isPost()) {

        //Variablen aus dem Formular sammeln
        //Nicht nur ein String sondern aus dem Post daten auslesen
        //verschiedene Filter für die Eingaben (Keine Sonderzeichen usw.)

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $passwort = filter_input(INPUT_POST, 'password');
        $passwortwiederholung = filter_input(INPUT_POST, 'passwordRepeat');

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $emailwiederholung = filter_input(INPUT_POST, 'emailRepeat', FILTER_SANITIZE_EMAIL);

        //Variablen aus dem Formular Prüfen

        if (false === (bool)$username) {
            $fehlermeldungen[] = "Benutzername ist leer";
        }

        if (false === (bool)$passwort) {
            $fehlermeldungen[] = "Passwort ist leer";
        }

        if(true === (bool)$username) {
            if(mb_strlen($username) < 4) { //mb - Multibyte alle standardzeichen (umlaute und andere zeichen als ein buchstaben)
                $fehlermeldungen[] = "Benutzername ist zu kurz, maximal 10 Zeichen.";
            }
        }

        //Ob der User existiert
        //Wird anch der eingabe ins Formularfeld überprüft sonst machst keinen sinn

        $usernameExists = $userclass->usernameExists($username);

        if (true === $usernameExists) {
            $fehlermeldungen[] = "Benutzername exestiert bereits.";
        }

        if(true === (bool)$passwort) {
            if(mb_strlen($passwort) < 6) { //Multibyte alle standardzeichen
                $fehlermeldungen[] = "Passwort muss mindestens 6 Zeichen haben.";
            }
        }

        if (false === (bool)$email) {
            $fehlermeldungen[] = "E-Mail ist leer";
        }

        if (true === (bool)$email) {

            //mit der Filter konstante wird die email nochmal überprüft ob sie auch tatsächlich eine ist
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $fehlermeldungen[] = "E-Mail ist nicht gültig";
            }

            //exisitiert die e-mail schon überprüfen
            $emailExists = $userclass->emailExists($email);

            if (true === $emailExists) {
                $fehlermeldungen[] = "E-Mail exestiert bereits.";
            }
        }


        if ($passwort!== $passwortwiederholung) {
            $fehlermeldungen[] = "Passwörter stimmen nicht überein.";
        }

        if ($email!== $emailwiederholung) {
            $fehlermeldungen[] = "E-Mails stimmen nicht überein.";
        }

        //Wenn ich Errors habe
        $esgibtFehlermeldungen = count($fehlermeldungen)>0;


        //Wenn es keine Fehlermledungen gibt dann:
        if(false === $esgibtFehlermeldungen) {

            //wenn alles passst User erstellen mit create Account
            $erstellt = $userclass->Accounterstellen($username,$passwort,$email);

            //wenn der Account nicht erstellt werden konnte - Fehlermeldung
            if(!$erstellt) {
                $fehlermeldungen[] = "Account konnte nicht angelegt werden.";

            }

            //Wenn der Account erstellt wurde dann:
            if($erstellt) {

                //AktivierungsLink erstellen mit Username
                $activationLinkEMAIL = $projektURL.'index.php/account/activate/'.$username;

                //E-Mail senden
                $mail = new PHPMailer();

                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure="tls";
                $mail->Username = "kerstin.hobart@gmail.com";
                $mail->Password = "fsdfnhmtsfvohghu";

                $mail->setFrom("kerstin.hobart@gmail.com", "Dein Shop Team");
                $mail->addAddress($email, $username);

                $mail->isHTML(true);
                $mail->Subject = "Hallo " .$username.",";
                $mail->Body = "Danke für deine Registrierung.";


                if($mail->send()){
                    echo "Deine Email wurde erfolgreich verschickt.";
                } else {
                    echo "Es gab einen Fehler ".$mail->ErrorInfo;
                }

                //Nachricht an den Benutzer das der Account erstellt wurde.
                $dienste->nachricht("Account erstellt");

                //und Weiterleitung auf Index.php
                header("Location: ".$baseURL."index.php");

            }
        }

    }

    $esgibtFehlermeldungen = count($fehlermeldungen)>0;


    //is auch im Login Design die Registirerung
    require __DIR__.'/templates/register.php';
    exit();

}



//Produkt Bild auslesen
if(strpos($pfadTeil,'/product/image') !== false) {

    //zum Produkt slug wird das Bild gesucht

    $pfadTeil = explode('/',$pfadTeil);    //mit dem pfad filtern
    //zahl im string array welche der  slug ist

    if(count($pfadTeil)!== 5) {    //Produkt laden mit Slug
        echo "ungültige URL";
        die();
    }

    $slug = $pfadTeil[3];
    $Dateiname = $pfadTeil[4];

    //Bild Pfad mit slug vom Bild und mit Dateiname
    $BildPfad = STORAGE_DIR . '/productPictures/' . $slug . '/'. $Dateiname;    //Pfad zum Bild

    if(false === is_file($BildPfad)) {

        //404 datei nicht gefunden
        http_response_code(404);
        exit();

    }

    //Kontent type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo,$BildPfad);

    header('Content-Type: ' .$mimetype);
    //readfile lest eine Datei aus und gibt sie an den Browser weiter

    readfile($BildPfad); //Readfile gibt die Bilddatei aus
    exit();
}



//Produkt bearbeiten
if(strpos($pfadTeil,'/product/edit') !== false) {

    //Variablen und Funktionen in eigener Datei
    require_once '../webshop/pfade/productEditPfad.php';

    //Design fürs Bearbeiten
    require_once __DIR__ . '/templates/produktbearbeiten.php';
    exit();
}



//neues Produkt anlegen
if(strpos($pfadTeil,'/product/new') !== false) {

    //Variablen und Funktionen in eigener Datei
    require_once '../webshop/pfade/productPfad.php';

    require_once __DIR__ . '/templates/neuesprodukt.php';
    exit();

}



//Produktdetailseite
if(strpos($pfadTeil,'/product') !== false) {

    //zuerst den Pfad mit dem Slug holen
    $produktIDPfad = explode('/',$pfadTeil);

    if(count($produktIDPfad) !== 3) {
        echo "ungültige URl";
        exit();
    }

    $slug = $produktIDPfad[2]; //slug bei URL TEIL 2

    //wenn man einen generellen slug in die url schreibt der nicht exestiert
    if(0 === strlen($slug)) {
    echo "ungültiges Produkt";
        exit();
    }

    //ProduktSlug holen
    $produktslug = $productclass->getProductslug($slug);

    //wenn man einen produktslug in die url schreibt das nicht exestiert
    if(null === $produktslug) {
        echo "ungültiges Produkt";
        exit();
    }

    //Design von der Detailseite
    require_once __DIR__ . '/templates/produktdetails.php';
    exit();

}



//Aktivierungs Code Probieren
//Account aktivierung
if(strpos($pfadTeil,'/account/activate') !== false) {

    //prüfen ob der Key in der url ist
    //und dnacher kann ich diese per E-Mail versenden

    $aktivierungsCodeKey = explode('/',$pfadTeil);

    //wenn die url mehr als 5 parts hat dann wird eine nachircht ausgeben

    if(count($aktivierungsCodeKey) !== 5) {

        echo "Key existiert nicht";
        exit();
    }

    //zufallszahl muss mit username verknüft werden (einfach zum lesen)
    //sonst könnten user zwei gleiche keys haben
    $username = (int)$aktivierungsCodeKey[3]; // bei 3 is der username

    $aktivierungsCode = $aktivierungsCodeKey[4]; //bei 4 der Code

    $aktiv = $userclass->Useraktiv($username,$aktivierungsCode);

    //fehlermeldung wenn die aktivierung nicht funktioniert hat
    if(false === $aktiv) {
        echo "ungültiger account";
        exit();
    }

    $dienste->nachricht("Account erfolgreich erstellt und aktiviert");

    //zurück zu index
    header("Location: ".$baseURL."index.php");
    exit();
}



//Aktivierungs Mail darstellung aber nicht sendung
if(strpos($pfadTeil,'/activationMail') !== false) {


    $aktivierungsCodeKey = explode('/', $pfadTeil);

    if(count($aktivierungsCodeKey) !==3) {
        echo "ungültige URL";
        exit();
    }

    $username = $aktivierungsCodeKey[2];
    $aktivierungsCode = $userclass->getaktivierungscodevonUsername($username);

    if(null === $aktivierungsCode) {
        echo "Account ist aktiviert";
    }

    $activationLink = $projektURL.'index.php/account/activate/'.$username.$aktivierungsCode;
    require_once __DIR__ . '/templates/activationMail.php';
    //var_dump($activationKey);
    exit();
}