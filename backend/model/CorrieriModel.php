<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'DBModel.php';

class CorrieriModel{
    public static function list(){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from corrieri");
            $stmt->execute();
            $corr=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'corrieri'=>$corr]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero della lista dei Corrieri']);
        }
    }
    public static function getCorriere($codCorriere){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from corrieri WHERE idCorr=?" );
            $stmt->execute($codCorriere);
            $corr=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'corriere'=>$corr]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero del Corriere']);
        }
    }
    
}
