<?php
class DB{
   
    private static $pdo;
   

    public static function connect(){
        if(!self::$pdo){
            $host = "localhost";
            $dbname = "corrieri";
            $user = "root";
            $pass = "";
            try{
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
                http_response_code(500);
                echo json_encode(['success'=>false,'message'=>'Errore di connessione al db MySql']);
                exit;
            }
        }
        return self::$pdo;
    }
}
?>
