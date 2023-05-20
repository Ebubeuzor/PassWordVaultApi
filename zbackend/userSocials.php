<?php
session_start();

    
header('Access-Control-Allow-Origin: http://localhost:5501');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST,PATCH,DELETE");

include("DBConnection.php");
include("helper.php");


$db = new DBConnection();
$conn = $db->con;

if (!isset($_SESSION['userID'])) {
    sendReply(400,json_encode(["error"=>"You are not logged in"]));
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['user_password'])) {
    $_SESSION['user_social_password'] = $_POST['user_actual_password'];
    sendReply(200,"");
}

else{
    $result2 = $conn->query("SELECT * FROM user_social WHERE userID = '" . $_SESSION['userID'] ."';");
    if ($result2) {
        $getResult = array();
        
        while($item = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $decryption_iv = "1234567891011121";
            $decryption_key = "W3docs";
            $decryption = openssl_decrypt($item['password'],$ciphering,$decryption_key,$options,$decryption_iv);
            $item['password'] = $decryption;
            $getResult[] = $item;
        }
        
        sendReply(200,json_encode(["values" => $getResult]));
        // sendReply(200, json_encode(["social_media" => $row2['social_media'],"password" => $decryption,"user_name" => $row2['user_name']]));
        
    }

    sendReply(400, json_encode(["error" => 'something went wrong']));
}
?>