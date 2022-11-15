<?php

class Lieferungen
{

    function __construct() {

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PW);
        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen";
            die();
        }
    }

    //Lieferadresse zum User speichern die eingetragen wird
   public  function saveLieferadressevomUser
   (int $userID, string $empfaenger, string $stadt, string $strasse, string $hausnummer,string $plz):int {

        $stmt = "insert into lieferadressen set user_id = :userID,adresse = :empfaenger,
        stadt = :stadt,strasse = :strasse,nummer = :hausnummer,plz = :plz";

        $prestmt = $this->db->prepare($stmt);

        if(false ===$prestmt) {
            return 0;
        }

        $prestmt->execute([
            'userID'=>$userID,
            'empfaenger'=>$empfaenger,
            'stadt'=>$stadt,
            'strasse'=>$strasse,
            'hausnummer'=>$hausnummer,
            'plz'=>$plz,
        ]);
        return (int)$this->db->lastInsertId();
    }

    //ieferadressen vom User holen und anzeigen lassen
   public function getlieferadressenvomUser (int $userID):array {

        $stmt = "select id,adresse,stadt,strasse,nummer,plz from lieferadressen where user_id =:userID";

        $prestmt = $this->db->prepare($stmt);
        if(false === $stmt) {
            return [];
        }

        $adressen = [];

        $prestmt->execute(['userID'=>$userID]);


        while($row = $prestmt ->fetch()) {
            $adressen[]=$row;
        }
        return $adressen;

    }

    //stimmt lieferadresse und user überein
   public function lieferadressediezumUsergehoert( int $lieferadressenID, int $userID):bool{

        $stmt = "select id from lieferadressen where user_id =:userID AND id =:lieferadressenID";

        $prestmt = $this->db->prepare($stmt);

        if(false === $stmt) {
            return false;
        }

        $prestmt->execute([
            'userID'=>$userID,
            'lieferadressenID'=>$lieferadressenID
        ]);

        return (bool) $prestmt->rowCount();

    }
}