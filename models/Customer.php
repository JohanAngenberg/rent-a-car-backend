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

    public function create() {

        $query = 'INSERT INTO customers(
            customer_ssn,
            customer_firstname,
            customer_lastname
            )
            values (
            :customer_ssn,
            :customer_firstname,
            :customer_lastname
            )';

        $stmt = $this->conn->prepare($query);
        
        $this->customer_ssn = htmlspecialchars(strip_tags($this->customer_ssn));
        $this->customer_firstname = htmlspecialchars(strip_tags($this->customer_firstname));
        $this->customer_lastname = htmlspecialchars(strip_tags($this->customer_lastname));

        $stmt->bindParam(':customer_ssn', $this->customer_ssn);
        $stmt->bindParam(':customer_firstname', $this->customer_firstname);
        $stmt->bindParam(':customer_lastname', $this->customer_lastname);

        if($stmt->execute()) {
            return true;
        } else {
            
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
    }
    }