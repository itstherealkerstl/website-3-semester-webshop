<?php

class Dienste {

    //Sonstige Funktionen

    public function isPost ():bool {
        return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    }

    //Umleitung wenn nicht eingeloggt
    public function umleitungwennnichteingelogged(string $sourceTarget){

       require_once 'classes/User.class.php';
       $userclass = new User();

       if($userclass->isLogin()) {
            return;
        }
        $_SESSION['redirectTarget'] = BASE_URL.'index.php'. $sourceTarget;
        header("Location: ".BASE_URL."index.php/login");
        exit();
    }

    //Nachichten Funktion
    public function nachricht (?string $message = null) {

    //Wenn die Session message nicht gesetzt ist dann setzte einfach ein leeres Array
        //dann steht was drinnen auch wenn nix drinnen steht

        if(!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        if(!$message) {
            //Hole mir die Nachichten
            $messages = $_SESSION['messages'];
            $_SESSION['messages']=[];
            //und gebe diese im Array zurück
            return $messages;
        }

        $_SESSION['messages'][] = $message;
    }

    //Bilddateien upload obs auch jpgs und pngs sind und nix anderes

    public function Dateipruefen(array $files):array {


        $result = [];

        foreach ($files as $keyName => $values) {
            foreach ($values as $index => $value) {
                $result[$index][$keyName] = $value;
            }
        }

        $typeToExtensionMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach ($result as $index => $file) {
            $tempPath = $file['tmp_name'];
            if(!$tempPath){
                unset($result[$index]);
                continue;
            }
            $type = finfo_file($finfo, $tempPath);
            $result[$index]['type'] = $type;
            $result[$index]['size'] = filesize($tempPath);
            if (isset($typeToExtensionMap[$type])) {
                $result[$index]['extension'] = $typeToExtensionMap[$type];
            }
        }

        return $result;
    }


    //Aktivierungs Code Probieren
    //Aktivierungs Code
    public function getrandomAktiviertungsKey(int $laenge): string
    {
        $zufallszahl = random_int(0, time());
        $hash = md5($zufallszahl);

        //zufälliger startwert von 0 - 28
        $zahlbeginn = random_int(0, strlen($hash) - $laenge);

        $Code = substr($hash, $zahlbeginn, $laenge);

        return $Code;
    }

}