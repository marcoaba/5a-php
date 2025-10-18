<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../model/CorrieriModel.php";
require_once __DIR__ . "/../model/FilialiModel.php";
require_once __DIR__ . "/../model/PacchiModel.php";
require_once __DIR__ . "/../model/UtenteModel.php";
require_once __DIR__ . "/../model/LoginModel.php";
$method = $_SERVER["REQUEST_METHOD"];
$action = $_REQUEST["action"] ?? '';

switch($method){
    case 'GET':
        switch ($action){
            case 'corrieri':
                $elencoCorrieri = CorrieriModel::list();
                echo($elencoCorrieri);
                break;
            case 'filiali':
                $codCorriere = $_REQUEST["idCorr"] ?? '1';
                $elencoFiliali = filialiModel::getFiliali($codCorriere);
                echo($elencoFiliali);
                    break;
            case 'pacchi':
                $codPacchi = $_REQUEST["idFil"] ?? '3';
                $elencoPacchi = PacchiModel::getPacchi($codPacchi);
                echo($elencoPacchi);
                    break;
            case'utenteRicerca':
                $codUtente=$_REQUEST["idUtente"]??'5';
                $UtenteSingolo=UtenteModel::getUtente($codUtente);
                echo($UtenteSingolo);
                break;
            case'login':
                $mail = $_REQUEST["mail"] ?? '';
                $password = $_REQUEST["password"] ?? '';
                if($mail != '' && $password != ''){
                    $loginResult = LoginModel::login($mail, $password);
                    echo($loginResult);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Email e password sono obbligatorie']);
                }
                break;
            case 'crea':
                $mail = $_REQUEST["mail"] ?? '';
                $password = $_REQUEST["password"] ?? '';
                $numero = $_REQUEST["numero"] ?? '';
                $cap = $_REQUEST["cap"] ?? '';
                $citta = $_REQUEST["citta"] ?? '';
                $nome = $_REQUEST["nome"] ?? '';
                $cognome = $_REQUEST["cognome"] ?? '';
                $indirizzo = $_REQUEST["indirizzo"] ?? '';
                $dataRegistrazione = $_REQUEST["dataRegistrazione"] ?? '';
                if(!$mail || !$password || !$nome || !$cognome){
                    echo json_encode(['success' => false, 'message' => 'Inserisci tutti i campi obbligatori']);
                    break;
                }
                $creaResult = LoginModel::crea($mail, $password, $numero, $cap, $citta, $nome, $cognome, $indirizzo, $dataRegistrazione);
                echo $creaResult; 
                break;

        }
        break;
    case 'POST':
        switch ($action){
            case 'corrieri':
                $codCorriere = $_REQUEST["codCorriere"] ?? '3';
                if($codCorriere!="")
                    $_SESSION["codCorriere"] = $codCorriere;
                else
                    $codCorriere = $_SESSION["codCorriere"];
                $filiali = CorrieriModel::getCorriere($codCorriere);
                echo($filiali);
                break;
            case 'filiali':
                break;
            case 'pacchi':
                break;
            case'utenteRicerca':
            break;
            case'login':
            break;
            case'crea':
            break;
        }
        break;
    default:
        http_response_code(404);
}
?>