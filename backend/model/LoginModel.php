<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'DBModel.php';

class LoginModel
{

    public static function login($mail, $password)
    {
        try {
            $pdo = DB::connect();
            $stmt = $pdo->prepare("SELECT * FROM utenti WHERE mail = ? AND pwd = ?");
            $stmt->execute([$mail, $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return json_encode(['success' => true, 'utente' => $user]);
            } else {
                return json_encode(['success' => false, 'message' => 'Credenziali errate']);
            }
        } catch (Exception $e) {
            return json_encode(['success' => false, 'message' => 'Errore durante il login: ' . $e->getMessage()]);
        }
    }
    public static function crea($mail, $password, $numero, $cap, $citta, $nome, $cognome, $indirizzo, $dataRegistrazione)
    {
        try {
            $pdo = DB::connect();

          
            $stmt = $pdo->prepare("SELECT * FROM utenti WHERE mail = ?");
            $stmt->execute([$mail]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return json_encode(['success' => false, 'message' => 'Email già registrata']);
            }

           
            $stmt = $pdo->prepare("
            INSERT INTO utenti (mail, pwd, telefono, cap, citta, nome, cognome, indirizzo, dataRegistrazione)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $result = $stmt->execute([$mail, $password, $numero, $cap, $citta, $nome, $cognome, $indirizzo, $dataRegistrazione]);

            if ($result) {
                return json_encode(['success' => true, 'message' => 'Utente creato con successo']);
            } else {
                return json_encode(['success' => false, 'message' => 'Errore durante l\'inserimento']);
            }

        } catch (Exception $e) {
            return json_encode(['success' => false, 'message' => 'Errore server: ' . $e->getMessage()]);
        }
    }

}
