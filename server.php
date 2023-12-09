<?php
$SERVER_PATH =  "file:///C:/xampp/htdocs/result_server_data/data";
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
            'filename' => $SERVER_PATH.'/'.$filename
        );

        array_push($userData, $user);
        array_push($codeLabosArray, $codeLabo);
    }


    $files = array();
    $userFound = false;
    foreach ($userData as $user) {
        if ($user['login'] === $userLogin ) {
            //get ALL user's files
            $files[]= $user['filename'];
            //connect user with the correct password
            if ($user['password'] === $userPassword) {
                $userFound = true; 
            }
        }
    }
    foreach ($files as $document) {
        echo $document . "<br>";
    }
    foreach ($codeLabosArray as $document) {
        echo $document . "<br>";
    }
    // Display result for invalid login or password
    if (!$userFound) {
        echo "Invalid login or password.";
    }
}
?>