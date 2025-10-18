<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'DBModel.php';

class PacchiModel{
    public static function list(){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from pacchi");
            $stmt->execute();
            $pacchi=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'pacchi'=>$pacchi]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero della lista dei pacchi']);
        }
    }
    public static function getPacchi($codFiliali){
        try{
            $pdo = DB::connect();
            $stmt = $pdo->prepare("select * from pacchi WHERE idfiliale=?" );
            $stmt->execute([$codFiliali]);
            $pacchi=$stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success'=>true,'pacchi'=>$pacchi]);
        }catch(Exception $e){
            return json_encode(['success'=>false,'message'=>'Errore durante il recupero della lista dei pacchi']);
        }
    }
    
}
