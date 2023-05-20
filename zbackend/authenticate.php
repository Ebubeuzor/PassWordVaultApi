<?php


header("Access-Control-Allow-Origin: http://localhost:5501");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST,PATCH,DELETE");

session_start();

require("DBConnection.php");
require("helper.php");
$db = new DBConnection();
$conn = $db->con;

if (!isset($_SESSION['userID'])) {
    sendReply(400,json_encode(["location"=>"SignIn.html"]));
}
sendReply(200,json_encode(["location"=>"PasswordVault.html"]));

?>