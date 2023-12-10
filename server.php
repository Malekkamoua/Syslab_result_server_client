<?php
session_start();
$SERVER_URL = "C:/xampp/htdocs/result_server_data/data/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $directory = "./data";
    
    $userLogin = $_POST['login'];
    $userPassword = $_POST['password'];

    $filenames = scandir($directory);
    $filenames = array_diff($filenames, array('.', '..'));

    $userData = array();
    $codeLabosArray = array();

    foreach ($filenames as $filename) {
        $dataArray = explode("-", $filename);
        $timestamp = $dataArray[0];
        $codeLabo = $dataArray[1];
        $numDemande = $dataArray[2];
        $login = $dataArray[3];
        $password = $dataArray[4];

        $user = array(
            'login' => $login,
            'password' => $password,
            'timestamp' => $timestamp,
            'codeLabo' => $codeLabo,
            'numDemande' => $numDemande,
            'filename' => $filename
        );

        array_push($userData, $user);
        array_push($codeLabosArray, $codeLabo);
    }

    usort($userData, function($a, $b) {
        return strtotime($a['timestamp']) - strtotime($b['timestamp']);
    });

    $files = array();
    $userFound = false;
    foreach ($userData as $user) {
        if ($user['login'] === $userLogin ) {

            $doc = [ $user['filename'], $user['codeLabo']];
            array_push($files, $doc);

            if ($user['password'] === $userPassword) {
                $userFound = true; 
                $cookieName = "user_found";
                $cookieValue = $user['login'];
                $cookieExpiration = time() + 3600; // Cookie expires in 1 hour
                setcookie($cookieName, $cookieValue, $cookieExpiration, "/");
            }
        }
    }

    if($userFound) {
        $codeLabosArray = json_encode($codeLabosArray);
        $_SESSION['files'] = $files;
        $_SESSION['codeLabosArray'] = $codeLabosArray;
        header('Location: index.php');
        exit();
    }
 
    if (!$userFound) {
        echo "Invalid login or password.";
        header('Location: login.php');
    }
}
?>