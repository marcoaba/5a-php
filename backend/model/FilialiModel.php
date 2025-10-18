<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'DBModel.php';

class filialiModel{
    public static function list(){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from filiali");
            $stmt->execute();
            $fil=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'filiali'=>$fil]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero della lista delle filiali ']);
        }
    }
    public static function getFiliali($codFiliali){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from filiali WHERE idCorr=?" );
            $stmt->execute([$codFiliali]);
            $fil=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'filiali'=>$fil]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero delle filiali']);
        }
    }
    
}
