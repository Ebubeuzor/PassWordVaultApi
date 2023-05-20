<?php

    function sendReply($status,$message){
        http_response_code($status);
        echo $message;
        exit();
    }

?>