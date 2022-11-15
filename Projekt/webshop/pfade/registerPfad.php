<?php
//versuch eine E-Mail zusenden mit Aktivierungs Code
use PHPMailer\PHPMailer\PHPMailer;

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


















