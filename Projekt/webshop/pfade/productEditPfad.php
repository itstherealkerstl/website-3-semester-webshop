<?php

//Admin oder nicht?
if (false === $userclass->isAdmin()) {
    echo "Ungültiger Zugriff";
    exit();
}

//mit dem pfad filtern
$part = explode('/',$pfadTeil);
//zahl im string array welche der  slug ist


//Produkt laden mit Slug


if(count($part)!== 4) {
    echo "ungültige URL";
    die();
}

$slug = $part[3];
$product = $productclass->getProductslug($slug);

if(null === $product) {
    echo "Produkt " .$slug. " nicht gefunden.";
    die();
}

//produkt inhalte zu den variablen zuweisen damit man sie bearbeiten kann
$productName = $product['titel'];
$slug = $product['slug'];

//damit das bearbeiten funktioniert
//muss der slug einmal zwischen gespeichert werden

$originalSlug = $slug;

$description = $product['description'];
$price = $product['price'];
$id = $product['id'];

$fehlermeldungen = [];
$esgibtFehlermeldungen = false;
$benachrichtigungen = $dienste->nachricht();
$gibtesBenachrichtifungen = count($benachrichtigungen) > 0;


if ($dienste->isPost()) {

    //Variaben Filtern
    $productName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $price = (int)filter_input(INPUT_POST, 'price');

    $bilder = $_FILES['picture']; //Bilder Dateien speichern
    $bilder = $dienste->Dateipruefen($bilder);

    if (false === (bool)$productName) {
        $fehlermeldungen[] = "Bitte Produkt Namen angeben";
    }
    if (true === (bool)$productName && false === (bool)$slug) {
        $slug = str_replace([' ', '/'], ['-', '-'], $productName);
    }


    //wenn es mehr als 0 Bilder gibt dann:
    $gibtesBilder = count($bilder) > 0;


    if($gibtesBilder) {
        //erlaubte mime types - wegen sicherheit

        $allowedTypes = ['image/jpeg','image/png'];

        //mit foreach jedes bild durchgehen
        foreach ($bilder as $bild) {

            $type = $bild['type'];
            if(!in_array($type,$allowedTypes)) {
                //wenn kein richter type erkannt wurde fehlermeldung
                $fehlermeldungen[] = "Bitte entweder .jpg oder .png Bilddateiformate hochladen.";
            }
        }
    }


    if (false === (bool)$description) {
        $fehlermeldungen[] = "Bitte Beschreibung angeben";
    }
    if ($price === 0) {
        $fehlermeldungen[] = "Bitte preis angeben";
    }
    $esgibtFehlermeldungen = count($fehlermeldungen) > 0;

    //gibt keine Fehlermeldungen mehr
    if (false === $esgibtFehlermeldungen) {

        $bearbeitet = $productclass->editProdukt($id,$productName, $slug, $description, $price);
        $imageuploadSucessful = false;

        if($gibtesBilder) {
            //upload
            $imageuploadSucessful = $productclass->uploadProductPictures($slug,$bilder);
        }

        if (false === $bearbeitet) {
            $fehlermeldungen[] = "Produkt konnte nicht bearbeitet werden";
            $esgibtFehlermeldungen = true;
        }
        if (true === $bearbeitet  || ($gibtesBilder && $imageuploadSucessful)) {
            $dienste->nachricht('Produkt wurde bearbeitet.');

            header("Location: " . BASE_URL . "index.php/product/edit/".$slug);
        }
    }
}