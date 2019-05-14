<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/db.php';
    include_once '../../models/Car.php';

    $database = new Database();
    $db = $database->connect();


    $car = new Car($db);

    $result = $car->read();

    $count = $result->rowCount();

    if ($count > 0) {
        $cars_arr = array();
        $cars_arr['data'] = array();
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $row_item = array(
                'id' => $cartype_id,
                'name' => $cartype_name,
                'kmPrice' => $cartype_kmprice,
                'baseDayRental' => $cartype_day_rental,
                'dayMultiplier' => $cartype_day_multiplier,
                'kmMultiplier' => $cartype_km_multiplier,
                'img' => $cartype_img
            );

            array_push($cars_arr['data'],$row_item);

            echo json_encode($cars_arr);
        }

    } else {
        echo json_encode(array('message' => 'no cars found'));
    }
