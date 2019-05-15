<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/db.php';
    include_once '../../models/Booking.php';

    $database = new Database();
    $db = $database->connect();


    $car = new Booking($db);

    $result = $car->read();

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
                'price' => $booking_price,
                'returned' => $booking_returned

            );

            array_push($bookings_arr['data'],$row_item);

        }
        echo json_encode($bookings_arr);

    } else {
        echo json_encode(array('message' => 'no bookings found'));
    }