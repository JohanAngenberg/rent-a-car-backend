<?php

 class Database {
        private $host = 'ec2-54-247-70-127.eu-west-1.compute.amazonaws.com';
        private $user = 'exnozjijrqrojk';
        private $password = 'f1080537020ff9d13fd4c2a59133d88455557faa709e97083511aadb9dd79166';
        private $dbname = 'ddbedddmaf82l1';
        private $port = '5432';
        private $conn;

        public function connect() {
            $this->conn = null;

            try{
                $this->conn = new PDO('pgsql:host=' . $this->host .';port=' . $this->port . ';dbname=' . $this->dbname, 
                $this->user, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $err) {
                echo 'Connection failed:' . $err->getMessage();
            }
            return $this->conn;
        }
    }
 
