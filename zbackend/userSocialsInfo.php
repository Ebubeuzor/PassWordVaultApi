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


if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['crud_req'] == "userSocialsUpate") {
    
    if (!isset($_SESSION['userID'])) {
        sendReply(400,"You are not logged in");
    }

    $social_name = $_POST['social_name'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $id = (int) $_POST['userID'];

    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = "1234567891011121";
    $encryption_key = "W3docs";
    $encryption = openssl_encrypt($password,$ciphering,$encryption_key,$options,$encryption_iv);
    
    if (empty(trim($social_name)) || empty(trim($username)) || empty(trim($password))) {
        sendReply(400,"All fields must be filled");
    }
    
    $sql = "UPDATE user_social SET social_media=?,password=?,user_name=? WHERE id=?; ";
    
    try {
        $con2 = $conn;
        $connect = mysqli_stmt_init($con2);
        mysqli_stmt_prepare($connect,$sql);
        mysqli_stmt_bind_param($connect,'sssi',$social_name,$encryption,$username,$id);;
        mysqli_stmt_execute($connect);
        sendReply(200,"");
    } catch (Exception $th) {
        sendReply(400,$th);
    }
    

}
else{
    $result2 = $conn->query("SELECT * FROM user_social WHERE id = '" . $_GET['userSoicalID'] ."' AND userID = '" . $_SESSION['userID'] ."';");
    if ($result2) {
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = "1234567891011121";
        $decryption_key = "W3docs";
        $decryption = openssl_decrypt($row2['password'],$ciphering,$decryption_key,$options,$decryption_iv);
        $row2['password'] = $decryption;
        if (isset($_SESSION['user_social_password'])) {
            sendReply(200, json_encode(["id" => $row2['id'],"social_media" => $row2['social_media'],"password" => $row2['password'],"username" => $row2['user_name']]));
        }
        else{
            sendReply(200, json_encode(["id" => $row2['id'],"social_media" => $row2['social_media'],"password" => $row2['password'],"username" => $row2['user_name']]));
        }
    }
    else{
        sendReply(400, json_encode(["name" => 'user_name']));
    }
}



?>