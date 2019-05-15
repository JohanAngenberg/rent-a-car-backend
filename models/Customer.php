<?php
    class Customer {
        private $conn;
        private $table = 'customers';

        public $customer_ssn;
        public $customer_firstname;
        public $customer_lastname;

        public function __construct($db){
            $this->conn = $db;
        }

    public function read(){
        $query = 'SELECT 
            customer_ssn,
            customer_firstname,
            customer_lastname
            FROM 
            customers';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    }