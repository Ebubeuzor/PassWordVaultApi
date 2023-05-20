<?php

    class DBConnection
    {
        private $dbHost;
        private $dbUser;
        private $dbPass;
        private $dbName;

        public $con;

        public function __construct() 
        {
            
            $this->dbHost = 'localhost';
            $this->dbUser = 'root';
            $this->dbPass = '';
            $this->dbName = 'password_vault';

            $this->con = new mysqli($this->dbHost,$this->dbUser);
            $db_sql = " CREATE DATABASE IF NOT EXISTS {$this->dbName}";
            $this->con->query($db_sql);
            if(!$this->con->error){
                if($this->con->affected_rows >0){
                    $this->con->close();
                    $this->con = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

                    $tbl_sql = "CREATE TABLE IF NOT EXISTS `users` 
                    ( `userID` int(30) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    `firstName` varchar(250) NOT NULL,
                    `lastName` varchar(250) NOT NULL,
                    `email` varchar(250) NOT NULL,
                    `password` varchar(250) NOT NULL,
                    `profileImage` varchar(250) NOT NULL,
                    `registerDate` varchar(250) NOT NULL
                    );";

                    $tbl_sql2 = "CREATE TABLE IF NOT EXISTS `user_social` 
                    (`id` int(30) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    `social_media` varchar(250) NOT NULL,
                    `password` varchar(250) NOT NULL,
                    `user_name` varchar(250) NOT NULL,
                    `userID` int(30) NOT NULL
                    );";

                    $this->con->query($tbl_sql);

                    $this->con->query($tbl_sql2);

                    if($this->con->error){
                        die("Creating DB Table Failed. Error: ". $this->con->error);
                    }
                }else{
                    $this->con->close();
                    
                    $this->con = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
                }
            if ($this->con->connect_error) {
                echo "Fail " . $this->con->connect_error;
            }
        }
    }

        public function __destruct()
        {
            $this->closeConnection();
        }

        public function closeConnection()
        {
            if ($this->con != null) {
                $this->con->close();
                $this->con = null;
            }
        }

    }

?>