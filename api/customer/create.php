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
    include_once '../../models/Customer.php';

    $database = new Database();
    $db = $database->connect();


    $customer = new Customer($db);

    $data = json_decode(file_get_contents('php://input'));

    $customer->customer_ssn = $data->customer_ssn;
    $customer->customer_firstname = $data->customer_firstname;
    $customer->customer_lastname = $data->customer_lastname;

    if($customer->create()) {
        echo json_encode(array('message:' => 'Post Created'));
    } else {
        echo json_encode(array('message:' => 'Post Not Created'));
    }