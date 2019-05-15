<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/db.php';
    include_once '../../models/Booking.php';

    $database = new Database();
    $db = $database->connect();


    $booking = new Booking($db);

    $data = json_decode(file_get_contents('php://input'));

    $booking->customer_ssn = $data->customer_ssn;
    $booking->booking_licenceplate = $data->booking_licenceplate;
    $booking->booking_cartype = $data->booking_cartype;
    $booking->booking_start = $data->booking_start;
    $booking->booking_initial_odo = $data->booking_initial_odo;
    $booking->returned = $data->returned;

    if($booking->create()) {
        echo json_encode(array('message:' => 'Post Created'));
    } else {
        echo json_encode(array('message:' => 'Post Not Created'));
    }