<?php

include('functions/connect.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // $data = array(
    //     ':Product'   => "%" . $_GET['Product'] . "%",
    //     ':Country'   => "%" . $_GET['Country'] . "%",
    //     ':Description'     => "%" . $_GET['Description'] . "%",
    //     ':Price'    => "%" . $_GET['Price'] . "%"
    // );
    $range = $_GET['length'];
    $draw = $_GET['draw'];
    $row = $_GET['start'];

    // $view = $_GET['view'];
    // $product_name = $_GET['columns'][0]['search']['value'];
    // $country = $_GET['columns'][1]['search']['value'];
    // $description = $_GET['columns'][2]['search']['value'];
    // $price = $_GET['columns'][3]['search']['value'];
    $searchValue = mysqli_real_escape_string($connection, $_GET['search']['value']); // Search value
    if ($searchValue != "") {
        $searchConditions =  [
            // 'product_type' => $view,
            'status' => 0
        ];
        $conditions2 = [
            'product_name' => $searchValue,
            'country' => $searchValue,
            'description' => $searchValue,
            'price' => $searchValue,
        ];
        $findProducts = selectAllLikeOr('products', $searchConditions, $conditions2, $row, $range);
        $findFiltered = selectAllLikeNoRange('products', $searchConditions, $conditions2);
    } else {
        $searchConditions =  [
            // 'product_type' => $view,
            'status' => 0
        ];
        $findProducts = selectAllRandLimit('products', $searchConditions, $row, $range);
        $findFiltered = selectAllRand('products', $searchConditions);
    }


    foreach ($findProducts as $product) {
        $productId = $product['id'];
        $action = "<a href='functions/business/delete_product.php?delete=$productId' class='btn btn-danger'>Delete</a>";
        if ($product['product_type'] == "account") {
            $productName = $product['product_name'];
        } else {
            $productName = $product['product_type'];
        }
        if($product['meta'] == ''){
            $valuePrint = "";
        }else{
            $values = json_decode($product['meta']);
            foreach($values as $key => $value){
                $valuePrint = "$key = <b>$value</b> <br>";
             }
        }
        
        
        $output[] = array(
            'id'    => $product['id'],
            'Product'  => $productName,
            'Country'   => $product['country'],
            'Price'   => $product['price'],
            'Value' => htmlspecialchars_decode(stripslashes($valuePrint)),
            'Description'    => $product['description'],
            'action' => $action
        );
    }

    ## Total number of records without filtering
    $findProducts2 = selectAllRand('products', $searchConditions);
    $totalRecords = count($findProducts2);
    $totalFiltered = count($findFiltered);
    # response
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $output
    );

    // header("Content-Type: application/json");
    echo json_encode($response);
}
