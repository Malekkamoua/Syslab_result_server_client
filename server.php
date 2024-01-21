<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $directory = "./data";

    //Accepte les paramètres de la request
    $userIDToSearch = $_POST['login'];
    $passwordToSearch = $_POST['recu'].$_POST['password'];

    $filenames = scandir($directory);
    $filenames = array_diff($filenames, array('.', '..'));

    $userData = array();
    $codeLabosArray = array();

    $userGroups = [];

    $medical_disciplines = array(
        27 => "Biochimie",
        28 => "Bactériologie",
        29 => "Parasitologie",
        30 => "Hématologie",
        31 => "Immunologie",
        82 => "Virologie"
    );

    //Parcourt la liste des fichiers existants
    //Crée la liste des triplet (userID,password,index) existants
    
    foreach ($filenames as $filename) {
        list($demande, $timestamp, $codeLabo, $userID, $password, $index) = explode('-', $filename);

        if (!isset($userGroups[$userID])) {
            $userGroups[$userID] = [];
        }

        if (!isset($userGroups[$userID]['index']) || $timestamp > $userGroups[$userID]['timestamp']) {
            $userGroups[$userID] = [
                'userID' => $userID,
                'password' => $demande.$password,
                'timestamp' => $timestamp,
            ];
        }

        $user = array(
            'login' => $userID,
            'password' => $password,
            'timestamp' => $timestamp,
            'codeLabo' => $codeLabo,
            'filename' => $filename
        );

        array_push($userData, $user);
        array_push($codeLabosArray, $codeLabo);
    }

    //Vérifie les accès de l'utilisateur
    //S'il existe, crée la liste de ses fichiers
    $userFound = false;
    foreach ($userGroups as $user) {
        if ($user['userID'] === $userIDToSearch && $user['password'] === $passwordToSearch) {
            $userFound = true;
            $cookieName = "user_found";
            $cookieValue = $user['userID'];
            $cookieExpiration = time() + 3600; // Cookie expires in 1 hour
            setcookie($cookieName, $cookieValue, $cookieExpiration, "/");

            usort($userData, function($a, $b) {
                return strtotime($a['timestamp']) - strtotime($b['timestamp']);
            });

            $files = array();

            foreach ($userData as $user) {
                if ($user['login'] === $userIDToSearch ) {
                    $doc = [ $user['filename'], $user['codeLabo'], $medical_disciplines[$user['codeLabo']]];
                    array_push($files, $doc);
                }
            }
        }
    }

    if (!$userFound) {
        $_SESSION['message'] = "Mot de passe ou login incorrect";
        header('Location: login.php');
    } else {
        $codeLabosArray = json_encode($codeLabosArray);
        $_SESSION['files'] = $files;
        $_SESSION['codeLabosArray'] = $codeLabosArray;
        $_SESSION['message'] = "";
        header('Location: index.php');
        exit();
    }
}
?>