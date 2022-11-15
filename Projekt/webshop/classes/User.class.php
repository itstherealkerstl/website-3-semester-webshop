<?php

class User
{
    function __construct() {

        try {
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PW);
        } catch (PDOException $e) {
            echo "Verbindung fehlgeschlagen";
            die();
        }
    }

    //holt die aktuelle User id aus der Datenbank
    public function getCurretUserID () :?int{

        $userID = null;

        //vorher cookie sonst wird die ID überschrieben

        if(isset($_COOKIE['userID'])) {
            $userID = (int) $_COOKIE['userID'];
        }

        if(isset($_SESSION['userID'])) {
            $userID = (int) $_SESSION['userID'];
        }

        return $userID;
    }

    // holt die User Daten vom usernamen
    public function getUserDatenvomUsernamen (string $username) :array{

        //SQL Array vorbereiten und an die Datenbank senden
        $stmt ="SELECT id,password AS userRights,activationKey FROM user WHERE username=:username";

        //prepared statement - ich sage der datenbank was die variablen sind
        $prestmt = $this->db->prepare($stmt);

        if(false === $prestmt){
            return [];
        }
        //wenn alles funktioniert hat variablen übergeben
        $prestmt -> execute([':username'=>$username]);

        //wenn ich keine Werte bekomme dann bekomm ich ein leeres Array
        if(0 === $prestmt->rowCount()){
            return [];
        }

        //ansonsten returne ich das array das ich in der datenbank gefunden habe
        $row = $prestmt->fetch();
        return $row;
    }

    //Bin ich eingeloggt?? ture false
    public function isLogin ( ):bool{
        return isset ($_SESSION['userID']);

    }

    //wieviele User gibt es insgesamt
    public function getAccountsTotal(): ?int {

        $stmt = "SELECT COUNT(id) FROM user";
        $prestmt = $this->db->query($stmt);

        if (false === $prestmt) {
            return null;
        }

        return (int)$prestmt->fetchColumn();
    }

    //Einen User Account erstellen
    public function  Accounterstellen(string $username, string $password, string $email) :bool{        //bool weil Antwort soll true oder false sein

        //Passwort was angegeben wird mit Hash vershen damits nicht als Text gespeichert wird
        $password = password_hash($password,PASSWORD_DEFAULT);

        //Admin abfrage geht nicht

        $userRights = 'USER';

        if ($this->getAccountsTotal() === 0) {
            $userRights = 'ADMIN';
        }

        $stmt = "Insert Into user Set username=:username,password=:password,email=:email,
            activationKey=:activationKey,userRights=:userRights";

        //Prepared Statement
        $prestmt = $this->db->prepare($stmt);

        //Wenn statement falsch dann return false
        if(false === $prestmt) {
            return false;
        }


        //aktiverungs Code erstellen beim Account erstellen
        $aktivierung = new Dienste();

        $aktivierungsCode = $aktivierung->getrandomAktiviertungsKey(8);

        //Statement ausführen mit execute
        $rows = $prestmt->execute([
            ':username'=>$username,
            ':password'=>$password,
            ':email'=>$email,
            ':activationKey'=>$aktivierungsCode,
            ':userRights'=>$userRights
        ]);

        //wenn kein user angelegt wurde dann false returnen
        if($rows === 0) {
            return false;
        }

        //Wenn die Anzahl der Datnsätze größer null ist dann werden die Datensätze mit true returned
        return  $rows  > 0;

    }

    //Exestiert der Username bereits? ture oder false
    public function usernameExists(string $username): bool
    {
        //Die 1 im sql statement wird als true erkannt

        $sql = "SELECT 1 FROM user WHERE username=:username";

        $statement = $this->db->prepare($sql);

        //Wenn das statement falsch ist dann return false
        if (false === $statement) {
            return false;
        }

        //statement ausführen
        $statement->execute([
            ':username' => $username
        ]);

        //1 fetchcolumn und in boolean umwandeln 1 = true 0 = false

        return (bool)$statement->fetchColumn();
    }


    //Exestiert die E-Mail bereits? true oder false
    //gleich wie username nur E-Mail
    public function emailExists(string $email): bool
    {
        $sql = "SELECT 1 FROM user WHERE email=:email";
        $statement = $this->db->prepare($sql);
        if (false === $statement) {
            return false;
        }
        $statement->execute([
            ':email' => $email
        ]);

        return (bool)$statement->fetchColumn();
    }

    //ADMIN der mit Session nicht funktoniert
    //return isset($_SESSION['userRights']) && $_SESSION['userRights'] === 'ADMIN';
    public function isAdmin(): bool
    {
        return true;
    }

    //ist der User aktivert worden? oder der key auf null
    public function Useraktiv (string $username, string $activationKey):bool {

        $stmt = "UPDATE user set activationKey = NULL Where username=:username 
        and activationKey =:activationKey";

        $prestmt =$this->db->prepare($stmt);
        if(false == $prestmt) {
            return false;
        }

        //anzahl der felder bekommt man zurück mit rows
        $prestmt->execute([
            ':username'=>$username,
            ':activationKey'=>$activationKey
        ]);

        $row = $prestmt->rowCount();
        return $row > 0;
    }

    //holt mir den aktivierungscode aus der datenbank vom usernamen
    public function getaktivierungscodevonUsername(string $username): ?string {

        $stmt = "SELECT activationKey FROM user WHERE username=:username LIMIT 1";

        $prestmt = $this->db->prepare($stmt);

        if (false === $prestmt) {
            return null;
        }

        $prestmt->execute([
            ':username' => $username
        ]);

        if ($prestmt->rowCount() === 0) {
            return null;
        }

        //mitfetchcolum eine spalte ausgeben oder halt hier eben die erste spalte
        return $prestmt->fetchColumn();
    }

    //holt die Email der ID aus  der Datenbank
    public function getEMail(int $id):string {

        $stmt = "SELECT email FROM user WHERE id=:id";

        $prestmt = $this->db->prepare($stmt);

        $prestmt->execute([
            ':id' => $id
        ]);

        return $prestmt->fetchColumn();
    }

    //holt den Usernamen mit der ID aus der Datenbank
    public function getUsername(int $id):string {

        $stmt = "SELECT username FROM user WHERE id=:id";

        $prestmt = $this->db->prepare($stmt);

        $prestmt->execute([
            ':id' => $id
        ]);

        return $prestmt->fetchColumn();
    }
}