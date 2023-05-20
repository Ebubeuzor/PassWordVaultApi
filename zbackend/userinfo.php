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
$result2 = $conn->query("SELECT * FROM users WHERE userID = '" . $_SESSION['userID'] ."';");
if ($result2) {
    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    if (isset($_SESSION['user_social_password'])) {
        sendReply(200, json_encode(["image" => $row2['profileImage'],"firstname" => $row2['firstName'],"lastname" => $row2['lastName'],"email" => $row2['email'],"user_social_password" => $_SESSION['user_social_password']]));
    }
    if (isset($_SESSION['userImageDetails'])) {
        sendReply(200, json_encode(["image" => $row2['profileImage'],"imageData" => $_SESSION['userImageDetails'],"firstname" => $row2['firstName'],"lastname" => $row2['lastName'],"email" => $row2['email']]));
    }
    if (isset($_SESSION['userImageDetails']) && isset($_SESSION['user_social_password'])) {
        sendReply(200, json_encode(["image" => $row2['profileImage'],"imageData" => $_SESSION['userImageDetails'],"firstname" => $row2['firstName'],"lastname" => $row2['lastName'],"email" => $row2['email'],"user_social_password" => $_SESSION['user_social_password']]));
    }
    else{
        sendReply(200, json_encode(["image" => $row2['profileImage'],"firstname" => $row2['firstName'],"lastname" => $row2['lastName'],"email" => $row2['email']]));
    }
}

sendReply(400, json_encode(["name" => 'user_name']));


?>