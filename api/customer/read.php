<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/db.php';
    include_once '../../models/Customer.php';

    $database = new Database();
    $db = $database->connect();


    $customer = new Customer($db);

    $result = $customer->read();

    $count = $result->rowCount();

    if ($count > 0) {
        $customers_arr = array();
        $customers_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $row_item = array(
                'ssn' => $cartype_ssn,
                'firstname' => $customer_firstname,
                'lastname' => $customer_lastname
            );

            array_push($customers_arr['data'],$row_item);

        }
        echo json_encode($customers_arr);

    } else {
        echo json_encode(array('message' => 'no cars found'));
    }
