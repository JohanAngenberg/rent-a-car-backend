<?php
    class Car {
        private $conn;
        private $table = 'cartypes';

        public $cartype_id;
        public $cartype_name;
        public $cartype_kmprice;
        public $cartype_day_rental;
        public $cartype_day_multiplier;
        public $cartype_km_multiplier;
        public $cartype_img;

        public function __construct($db){
            $this->conn = $db;
        }

    public function read(){
        $query = 'SELECT 
            cartype_id,
            cartype_name,
            cartype_kmprice,
            cartype_day_rental,
            cartype_day_multiplier,
            cartype_km_multiplier,
            cartype_img' .
            'FROM 
            cartypes';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    }