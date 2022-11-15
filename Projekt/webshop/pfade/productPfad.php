<?php

//Wenn Admin true dann kann man bearbeiten wenn nicht
//dann exit()
if (false === $userclass->isAdmin()) {
    echo "unerlaubter Zugriff";
    exit();
}

$produktName = "";
$slug = "";
$description = "";
$price = 0;

$fehlermeldungen = [];
$esgibtFehlermeldungen = false;
$benachrichtigungen = $dienste->nachricht();
$esgibtBenachrichtigungen = count($benachrichtigungen) > 0;

//Wenn das Form mit Post abgesendet worden ist dann prüfen:
if ($dienste->isPost()) {

    //Variablen Filtern
    $produktName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $price = (int)filter_input(INPUT_POST, 'price');

        if (false === (bool)$produktName) {
            $fehlermeldungen[] = "Bitte Produkt Namen angeben";
        }

        if (true === (bool)$produktName && false === (bool)$slug) {
            $slug = str_replace([' ', '/'], ['-', '-'], $produktName);
        }

        if (true === (bool)$slug) {
            $product = $productclass->getProductslug($slug);

            if (null !== $product) {
                $fehlermeldungen[] = "Slug ist bereits vorhanden";
            }
        }

        if (false === (bool)$description) {
            $fehlermeldungen[] = "Bitte Beschreibung angeben";
        }

        if ($price === 0) {
            $fehlermeldungen[] = "Bitte preis angeben";
        }

        $esgibtFehlermeldungen = count($fehlermeldungen) > 0;

        //Wenn es keine Fehlermeldungen mehr gibt dann:
        if (false === $esgibtFehlermeldungen) {

            //Produkt erstellt
            $erstellt = $productclass->createProduct($produktName, $slug, $description, $price);

                //Wenn das erstellen nicht geklappt hat dann Fehler
                if (false === $erstellt) {
                    $fehlermeldungen[] = "Produkt konnte nicht angelegt werden";
                    $esgibtFehlermeldungen = true;
                }

                //Wenn erstellt dann zurück zu new produkt
                if (true === $erstellt) {
                    $dienste->nachricht('Produkt wurde erstellt');
                    header("Location: " . BASE_URL . "index.php/product/new");
                }
        }
}