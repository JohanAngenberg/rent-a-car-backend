<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json, Origin, X-Requested-With, Content-Type, Accept');
    
    include_once '../../config/db.php';
    include_once '../../models/Booking.php';

    $database = new Database();
    $db = $database->connect();


    $booking = new Booking($db);

    $booking->customer_ssn = isset($_GET['customer_ssn']) ? $_GET ['customer_ssn'] : die();

    $result = $booking->readCustomer();

    $count = $result->rowCount();

    if ($count > 0) {
        $bookings_arr = array();
        $bookings_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $row_item = array(
                'id' => $booking_id,
                'ssn' => $customer_ssn,
                'licenceplate' => $booking_licenceplate,
                'cartype' => $booking_cartype,
                'start' => $booking_start,
                'end' => $booking_end,
                'initial_odo' => $booking_initial_odo,
                'final_odo' => $booking_final_odo,
                'distance' => $booking_distance,
                'duration' => $duration,
                'price' => $booking_price,
                'returned' => $returned,
                'carid' => $cartype_id,
                'kmprice' => $cartype_kmprice,
                'baseDayRental' => $cartype_day_rental,
                'dayMultiplier' => $cartype_day_multiplier,
                'kmMultiplier' => $cartype_km_multiplier

            );

            array_push($bookings_arr['data'],$row_item);

        }
        echo json_encode($bookings_arr);

    } else {
        echo json_encode(array('message' => 'no bookings found'));
    }