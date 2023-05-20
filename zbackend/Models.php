<?php

    session_start();
    header("Access-Control-Allow-Origin: http://localhost:5501");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: POST,PATCH,DELETE");

    require("DBConnection.php");
    require("helper.php");
    $db = new DBConnection();
    $conn = $db->con;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST["crud_req"])) {
        logout($conn);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['crud_req'] == "signup") {
        signUp($conn);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['crud_req'] == "login") {
        login($conn);
    }


    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['crud_req'] == "update") {
        update($conn);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['crud_req'] == "userSocials") {
        userSocials($conn);
    }


    function signUp($conn)
    {
        
        $image = $_FILES['profileUpload'];
        $firstname = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_pwd = $_POST["confirm_pwd"];

        if (empty(trim($firstname)) || empty(trim($lastName)) || empty(trim($email)) || empty(trim($password)) || empty(trim($confirm_pwd))) {
            sendReply(400,"All fields must be filled");
        }

        if (! filter_var($email,FILTER_VALIDATE_EMAIL)) {
            sendReply(400,"Invalid Email Address!!");
        }

        if ($password != $confirm_pwd) {
            sendReply(400,"Passwords doesn't match");
        }
        $result = mysqli_query($conn,"SELECT * FROM users");
                
        $resultArray = [];

        while($item = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }
        
        foreach ($resultArray as $row) {
            if ($row['email'] == $email) {
                sendReply(400,"Email already exists");
            }
        }

        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        $profilePicture = profileImage("profile/",$image);
        
        
        $query = "INSERT INTO users (firstName,lastName,email,password,profileImage,registerDate) VALUES (?,?,?,?,?,NOW());";
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($query)){
            sendReply(400,"Something went wrong. Try again later!!");
        }
        $stmt->bind_param('sssss',$firstname,$lastName,$email,$password_hash,$profilePicture);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['userImageDetails'] = $image['name'];
            $_SESSION['userID'] = mysqli_insert_id($conn);
            sendReply(200,"");
        }else {
            sendReply(400,"Connection Error try again later");
        }
    }

    function profileImage($path,$image)
    {
        $targetDir = $path;
        $default = 'luser.png';
        $filename = basename($image['name']);
        $pathTargetDir = $targetDir . $filename;
        $pathinfo = pathinfo($filename,PATHINFO_EXTENSION);
        if (!empty($image)) {
            $allowedExtension = ['gif','png','jpg','jpeg', 'svg' ,'eps'];
            if (in_array($pathinfo,$allowedExtension)) {
                if (move_uploaded_file($image['tmp_name'],$pathTargetDir)) {
                    return $pathTargetDir;
                }else {
                    sendReply(400,"An error occured try again later");
                }
            }
        }
        if (empty($image) && isset($_SESSION['userImageDetails'])) {
            return $targetDir . $_SESSION['userImageDetails'];
        }else{
            return $targetDir . $default;
        }

    }

    function login($conn)
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty(trim($email)) || empty(trim($password))) {
            sendReply(400,"Please fill all fields");
        }
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->stmt_init();
        $stmt->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            if ($email == $row['email']) {
                if (password_verify($password,$row['password'])) {
                    if (!isset($_SESSION['userID'])) {
                        $_SESSION['userID'] = $row['userID'];
                        sendReply(200,"");
                    }else{
                        sendReply(200,"");
                    }
                }else{
                    sendReply(400,"Incorrect Password");
                }
            }else{
                sendReply(400,"Invalid User");
            }
        }

    }

    
    function update($conn)
    {
        if (!isset($_SESSION['userID'])) {
            sendReply(400,"You are not logged in");
        }

        // parse_str(file_get_contents("php://input"),$_PATCH);
        
        $image = $_FILES['imageFile'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        
        if (empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($email)))
        {
            sendReply(400,"All fields are mandatory!!!");
        }
        
        if (! filter_var($email,FILTER_VALIDATE_EMAIL)) {
            sendReply(400,"Invalid Email Address!!");
        }

        $_SESSION['userImageDetails'] = $image['name'];
        if (!empty($_SESSION['userImageDetails'])) {
            $profilePicture = profileImage("profile/",$image);
            $sql = "update users set firstname=?,lastname=?,email=?,profileImage=? where userID=?;";
            
            $stmt = $conn->stmt_init();

            if(!$stmt->prepare($sql)){
                sendReply(400,"Something went wrong. Try again later!!1");
            }

            $stmt->bind_param('ssssi',$firstname,$lastname,$email,$profilePicture,$_SESSION['userID']);
            $stmt->execute();
            
            if ($stmt->affected_rows == 1) {
                sendReply(200,"");
            }else {
                sendReply(400,"not ok");
            }
        }else{
            $sql = "update users set firstname=?,lastname=?,email=? where userID=?;";
            try {
                $con2 = $conn;
                $connect = mysqli_stmt_init($con2);
                mysqli_stmt_prepare($connect,$sql);
                mysqli_stmt_bind_param($connect,'sssi', $firstname,$lastname,$email,$_SESSION['userID']);
                mysqli_stmt_execute($connect);
                sendReply(200,"");
            } catch (Exception $th) {
                sendReply(400,$th);
            }
            
        }
        
        
    }

    function userSocials($conn)
    {
        
        $social_name = $_POST['social_name'];
        $username = $_POST['user_name'];
        $password = $_POST['password'];

        if (empty(trim($social_name)) || empty(trim($username)) || empty(trim($password))) {
            sendReply(400,"All fields must be filled");
        }

        $query = "INSERT INTO user_social (social_media,password,user_name,userID) VALUES (?,?,?,?);";
        $ciphering = "AES-128-CTR";
        $options = 0;
        $encryption_iv = "1234567891011121";
        $encryption_key = "W3docs";
        $encryption = openssl_encrypt($password,$ciphering,$encryption_key,$options,$encryption_iv);
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($query)){
            sendReply(400,"Something went wrong. Try again later!!1");
        }
        $stmt->bind_param("sssi",$social_name,$encryption,$username,$_SESSION['userID']);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
            sendReply(200,"");
        }else {
            sendReply(400,"Something went wrong. Try again later!!2");
        }
    }

    
    function logOut($conn)
    {
        if (isset($_SESSION['userID'])) {
            unset($_SESSION['userID']);
            session_destroy();
            sendReply(200,"");
        }
        if (!isset($_SESSION['userID'])) {
            sendReply(400,"You are not logged in");
        }
    }

?>