<?php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");
        exit(0);
    }

    include_once '../../config/db.php';
    include_once '../../models/Booking.php';

    $database = new Database();
    $db = $database->connect();


    $booking = new Booking($db);

    $data = json_decode(file_get_contents('php://input'));

    $booking->customer_ssn = $data->customer_ssn;

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