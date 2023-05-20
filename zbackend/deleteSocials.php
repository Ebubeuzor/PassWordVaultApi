<?php

session_start();
header("Access-Control-Allow-Origin: http://localhost:5501");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST,PATCH,DELETE");

require("DBConnection.php");
require("helper.php");
$db = new DBConnection();
$conn = $db->con;

$social_id = $_POST['social_id'];

$sql = "DELETE FROM user_social where id = " . $social_id . " AND userID = " . $_SESSION['userID'] . ";";

if ($conn->query($sql)) {
    sendReply(200,"");
}else {
    sendReply(400,"Something went wrong");
}

?>