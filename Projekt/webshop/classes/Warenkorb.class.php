<?php

class Warenkorb {

    function __construct() {

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PW);
        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen";
            die();
        }
    }

    //Anzahl der Produkte im Warenkorb die zu der UserID gehören
    public function anzahlderProdukteimWarenkorb (?int $userID) {

        if(null === $userID) {
            return 0;
        }

        $stmt = "Select count(id) from cart where user_id =".$userID;

        $warenkorbgesamt = $this->db->query($stmt);
        $warenkorbprodukte = $warenkorbgesamt->fetchColumn();

        return $warenkorbprodukte;
    }

    //Produkt zum Warenkorb hinzufügen
    public function addProduktzumWarenkorb (int $userID, int $productID, int $quantity = 1) {

        $stmt = "INSERT INTO cart set quantity=:quantity,user_id = :userID,product_Id = :productID
        ON duplicate key update quantity =  quantity+1";

        $prestmt = $this->db->prepare($stmt);

        $prestmt->execute([
            ':userID'=>$userID,
            ':productID'=> $productID,
            ':quantity'=>$quantity
        ]);
    }

    //holt die Warenkorb Prdoukte aus der Datenbank zur user ID
    public function getWarenkorbprodukteforUserID (?int $userID) :array{

        if(null === $userID) {
            return [];
        }

        $stmt = "select product_id,titel,description, price,slug,quantity from cart
        join products on(cart.product_id = products.id) where user_id = :userID";

        $prestmt =$this->db->prepare($stmt);

        if($prestmt === false) {
            return [];
        }

        $prestmt->execute([
            ':userID'=>$userID
        ]);

        $found = [];

        while($row = $prestmt->fetch()) {
            $found[] = $row;
        }

        return $found;

    }

    //holt die summe der Produkte zur UserID aus der Datenbank
    public function getSumfromUserID (?int $userID): int {

        if(null === $userID) {
            return 0;
        }

        $stmt ="select sum(price * quantity) from cart join products on(cart.product_id = products.id)
        where user_id = ".$userID;

        $result = $this->db->query($stmt);

        if($result === false) {
            return 0;
        }
        return (int)$result->fetchColumn();
    }
/*
    public function warenkorbproduktezumUserzuordnen(int $sourceUserID, int $targetUserID) {

        $alteWarenkorbProdukte = getWarenkorbprodukteforUserID($sourceUserID);

        if(count($alteWarenkorbProdukte) === 0) {
            return 0;
        }

        $bewegteProdukte = 0;

        foreach ($alteWarenkorbProdukte as $altesWarenkorbProdukt) {
            //alte produkte an einen neuen User übertragen
            addProducttoWarenkorb($targetUserID,(int)$altesWarenkorbProdukt['product_id'],(int)$altesWarenkorbProdukt['quantity']);
            //und dann gelöscht
            $bewegteProdukte += deleteProduktinWarenkorb($sourceUserID,(int)$altesWarenkorbProdukt['product_id']);

        }
        return $bewegteProdukte;

    }

    //entfernt ein Produkt aus dem Warenkorb
    public function deleteProduktinWarenkorb(int $userID,int $productID) :int{
        $stmt = "Delete from cart where user_id = :userID and product_id = : productID";

        $prestmt = $this->db->prepare($stmt);
        if(false === $prestmt) {
            return 0;
        }

        return $prestmt->execute([
            ':userID'=>$userID,
            ':productID'=>$productID
        ]);
    }
*/
    //Warenkorb für den User löschen
   public function clearWarenkorbvomUser (int $userID) {

        $stmt ="Delete from cart where user_id = :userID";

        $prestmt = $this->db->prepare($stmt);

        return $prestmt->execute([':userID'=>$userID]);
    }
}