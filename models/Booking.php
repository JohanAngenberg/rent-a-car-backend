<?php
    class Booking {
        private $conn;
        private $table = 'bookings';

        public $booking_id;
        public $customer_ssn;
        public $booking_licenceplate;
        public $booking_cartype;
        public $booking_start;
        public $booking_end;
        public $booking_initial_odo;
        public $booking_final_odo;
        public $booking_distance;
        public $booking_duration;
        public $booking_price;
        public $returned;
        public $cartype_id;
        public $cartype_kmprice;
        public $cartype_day_rental;
        public $cartype_day_multiplier ;
        public $cartype_km_multiplier;
    


        public function __construct($db){
            $this->conn = $db;
        }

    public function read(){
        $query = 'SELECT 
                booking_id,
                customer_ssn,
                booking_licenceplate,
                booking_start,
                booking_end,
                booking_initial_odo,
                booking_final_odo,
                booking_distance,
                duration,
                booking_price,
                returned,
                booking_cartype,
                cartype_kmprice,
                cartype_day_rental,
                cartype_day_multiplier,
                cartype_km_multiplier

            FROM bookings
            LEFT JOIN cartypes
            ON
                bookings.booking_cartype=cartypes.cartype_name  
                '
            ;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function readCustomer(){
        $query = 'SELECT 
                booking_id,
                customer_ssn,
                booking_licenceplate,
                booking_start,
                booking_end,
                booking_initial_odo,
                booking_final_odo,
                booking_distance,
                duration,
                booking_price,
                returned,
                booking_cartype,
                cartype_kmprice,
                cartype_day_rental,
                cartype_day_multiplier,
                cartype_km_multiplier

            FROM bookings
            LEFT JOIN cartypes
            ON
                bookings.booking_cartype=cartypes.cartype_name  

            WHERE customer_ssn = ?'
            ;

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->customer_ssn);

        $stmt->execute();

        return $stmt;
    }

    public function create() {

        $query = 'INSERT INTO bookings(
            customer_ssn,
            booking_licenceplate,
            booking_cartype,
            booking_start,
            booking_initial_odo
            )
            values (
                :customer_ssn,
                :booking_licenceplate,
                :booking_cartype,
                :booking_start,
                :booking_initial_odo
            )';

        $stmt = $this->conn->prepare($query);
        
        $this->customer_ssn = htmlspecialchars(strip_tags($this->customer_ssn));
        $this->booking_licenceplate = htmlspecialchars(strip_tags($this->booking_licenceplate));
        $this->booking_cartype = htmlspecialchars(strip_tags($this->booking_cartype));
        $this->booking_start = htmlspecialchars(strip_tags($this->booking_start));
        $this->booking_initial_odo = $this->booking_initial_odo;

        $stmt->bindParam(':customer_ssn', $this->customer_ssn);
        $stmt->bindParam(':booking_licenceplate', $this->booking_licenceplate);
        $stmt->bindParam(':booking_cartype', $this->booking_cartype);
        $stmt->bindParam(':booking_start', $this->booking_start);
        $stmt->bindParam(':booking_initial_odo', $this->booking_initial_odo);

        if($stmt->execute()) {
            return true;
        } else {
            
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
    }
    
    public function update() {

        $query = 'UPDATE bookings 
            SET
            booking_end = :booking_end,
            booking_final_odo = :booking_final_odo,
            booking_distance = :booking_distance,
            booking_price = :booking_price,
            duration = :duration,
            returned = :returned
            WHERE
            booking_id = :booking_id';

        $stmt = $this->conn->prepare($query);

        $this->booking_id = $this->booking_id;
        $this->booking_end = htmlspecialchars(strip_tags($this->booking_end));
        $this->booking_final_odo = $this->booking_final_odo;
        $this->booking_distance = $this->booking_distance;
        $this->booking_price = $this->booking_price;
        $this->duration = $this->duration;
        $this->returned = $this->returned;

        $stmt->bindParam(':booking_id', $this->booking_id);
        $stmt->bindParam(':booking_end', $this->booking_end);
        $stmt->bindParam(':booking_final_odo', $this->booking_final_odo);
        $stmt->bindParam(':booking_distance', $this->booking_distance);
        $stmt->bindParam(':booking_price', $this->booking_price);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':returned', $this->returned);

        if($stmt->execute()) {
            return true;
        } else {
            
            printf("Error: %s.\n ", $stmt->error);
            return false;
        }
    }
    }