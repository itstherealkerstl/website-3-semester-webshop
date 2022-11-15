<?php

class Bestellung
{

    function __construct()
    {

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PW);
        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen";
            die();
        }
    }

    public function bestellungErstellen(int $userID, array $cartItems, string $status = 'neu'): bool {

        $stmt = "INSERT INTO bestellungen SET status = :status, userId = :userId";
        $prestmt = $this->db->prepare($stmt);

        $daten = [
            ':status' => $status,
            ':userId' => $userID
        ];

        $prestmt->execute($daten);

        $orderId = $this->db->lastInsertId();

        $stmt = "INSERT INTO order_products SET title=:title,quantity = :quantity,
        price = :price,orderId = :orderId";

        $prestmt = $this->db->prepare($stmt);

        foreach ($cartItems as $cartItem) {

            $daten = [
                ':title' => $cartItem['titel'],
                ':quantity' => $cartItem['quantity'],
                ':price' => $cartItem['price'],
                ':orderId' => $orderId
            ];

            $prestmt->execute($daten);

        }
        return true;
    }


    public function getBestellungvomUser(int $orderID, int $userID): ?array {

        $stmt = "SELECT status,userId,id FROM bestellungen WHERE id=:orderId and userId=:userId LIMIT 1";

        $prestmt = $this->db->prepare($stmt);

        if (false === $prestmt) {
            echo "falsch";
            return null;
        }

        $prestmt->execute([
            ':orderId' => $orderID,
            ':userId' => $userID
        ]);

        //wenn es garkeine order geben würde hier abbrechen mit if
        if(0 === $prestmt->rowCount())  {
            return null;
        }

        $bestellung = $prestmt->fetch();
        $bestellung['products'] = [];

        $stmt= "SELECT id,title,quantity,price FROM order_products WHERE orderId = :orderId";

        $prestmt = $this->db->prepare($stmt);

        if (false === $prestmt) {
            echo "falsch";
            return null;
        }

        $prestmt->execute([
            ':orderId' => $orderID
        ]);

        if(0 === $prestmt->rowCount())  {
            return null;
        }

        while ($row = $prestmt->fetch()) {
            //erweitern von produkts mit dem datensatz
            $bestellung['products'] []=$row;
        }

        return $bestellung;

    }

}