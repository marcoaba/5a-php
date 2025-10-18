<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'DBModel.php';

class UtenteModel{
    public static function list(){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from utenti");
            $stmt->execute();
            $utente=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'Utenti'=>$utente]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante La ricerca utente']);
        }
    }
    public static function getUtente($codUtente){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from utenti WHERE idUtente=?" );
            $stmt->execute([$codUtente]);
            $utente=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'Utente'=>$utente]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante la ricerca utente']);
        }
    }
    
}
