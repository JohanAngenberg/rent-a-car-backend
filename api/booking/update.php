<?php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: PUT, OPTIONS");         
            header("Access-Control-Allow-Methods: PUT, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            header("Access-Control-Allow-Methods: PUT, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");
        exit(0);
    }


    include_once '../../config/db.php';
    include_once '../../models/Booking.php';

    $database = new Database();
    $db = $database->connect();


    $booking = new Booking($db);

    $data = json_decode(file_get_contents('php://input'));

    $booking->booking_id = $data->booking_id;
    $booking->booking_end = $data->booking_end;
    $booking->booking_final_odo = $data->booking_final_odo;
    $booking->booking_distance = $data->booking_distance;
    $booking->booking_price = $data->booking_price;
    $booking->booking_returned = $data->booking_returned;

    if($booking->create()) {
        echo json_encode(array('message:' => 'Post Created'));
    } else {
        echo json_encode(array('message:' => 'Post Not Created'));
    }