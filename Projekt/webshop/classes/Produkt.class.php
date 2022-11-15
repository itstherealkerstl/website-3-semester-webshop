<?php

class Produkt
{
    function __construct() {

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PW);
        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen";
            die();
        }
    }

    //Produkte aus Datenbank holen
    public function getAllProdukts () {

        //Alle Produkte aus der Datenbank geholt
        $stmt ="select id,titel,description,price,slug from products";

        $prestmt = $this->db->query($stmt);

        //wenn es keine gibt oder ein Fehler auftritt
        if(!$prestmt) {
            return [];
        }

        $produkte= [];
        //dann gehe ich durch alle durch und geb sie aus
        while ($row = $prestmt->fetch()){
            $produkte[] = $row;
        }
        return $produkte;

    }

    //Produkt Daten aus Datenabnk holen mit Slug Parameter
    public function getProductslug (string $slug) :?array {

        $stmt ="select id,titel,description,price,slug from products where slug=:slug limit 1";

        $prestmt = $this->db->prepare($stmt);

        if(false === $prestmt) {
            return null;
        }
        $prestmt->execute([
            ':slug'=>$slug
        ]);

        if($prestmt->rowCount() === 0) {
            return null;
        }

        return $prestmt->fetch();
    }

    //Produkt erstellen mit den jeweiligen Übergabeparemtern
    public function createProduct(string $productName, string $slug, string $description, int $price): bool {

        $stmt = "INSERT INTO products SET titel = :productName,
        slug = :slug,description = :description,price = :price";

        $prestmt = $this->db->prepare($stmt);

        if (false === $prestmt) {
            return false;
        }

        $prestmt->execute(
            [
                ':productName' => $productName,
                ':slug' => $slug,
                ':description' => $description,
                ':price' => $price,
            ]
        );

        $lastId = $this->db->lastInsertId();
        return $lastId > 0;
    }

    //Produkt bearbeiten - also updaten
    public function editProdukt (int $id, string $productName,
                                 string $slug, string $description, int $price): bool {

        $stmt = "UPDATE products SET titel = :productName,slug = :slug,
                    description = :description,price = :price Where id=:id";

        $prestmt = $this->db->prepare($stmt);

        if (false === $prestmt) {
            return false;
        }

        $prestmt->execute(
            [
                ':id' => $id,
                ':productName' => $productName,
                ':slug' => $slug,
                ':description' => $description,
                ':price' => $price,
            ]
        );

        $rows = $prestmt->rowCount();

        return $rows >= 0;
    }

    //ProduktBilder hochladen
    public function uploadProductPictures (string $slug, array $bilder):bool
    {

        //Pfad Bildergalaerie
        $picutrePath = STORAGE_DIR . '/productPictures/' . $slug . '/';

        //wenns den ordner nicht gibt dann einen alegen
        if (!is_dir($picutrePath)) {
            mkdir($picutrePath, 0777, true);
            //0777 ist die berechtigung zum anlegen
        }
        //statt eins die letzt höchste Zahl herrausfinden
        //php funktion glob


        $fileNames = glob($picutrePath . '*');
        $fileName = count($fileNames) + 1;

        $filesToCheck = [];

        foreach ($bilder as $bild) {


            $filesToCheck  [] = $picutrePath . $fileName . '.' . $bild['extension'];
            //kopieren der tmp Datei und gleich umbenenen der Datei in 1. extension
            copy($bild['tmp_name'], $picutrePath . $fileName . '.' . $bild['extension']);

            //anschließend löschen der temporären datei
            unlink($bild['tmp_name']);
        }

        $result = true;
        foreach ($filesToCheck as $file) {
            //exisitiert die Datei?
            //wenn nicht
            if (false === is_file($file)) {
                //abbrechen und ergebnis zurückgeben
                $result = false;
                break;
            }
        }
        return $result;
    }
}