<?php

include('functions/methods.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $range = $_GET['length'];
    $draw = $_GET['draw'];
    $row = $_GET['start'];

    $searchValue = mysqli_real_escape_string($connection, $_GET['search']['value']); // Search value
    if ($searchValue != "") {
        $searchConditions =  [
            // 'product_type' => $view,
            'status' => "ACTIVE"
        ];
        $conditions2 = [
            'fullname' => $searchValue,
            'username' => $searchValue,
            'email' => $searchValue,
        ];
        $findusers = selectAllLikeOr('users', $searchConditions, $conditions2, $row, $range);
        $findFiltered = selectAllLikeNoRange('users', $searchConditions, $conditions2);
    } else {
        $searchConditions =  [
            // 'product_type' => $view,
            'status' => "ACTIVE"
        ];
        $findusers = selectAllRandLimit('users', $searchConditions, $row, $range);
        $findFiltered = selectAllRand('users', $searchConditions);
    }


    foreach ($findusers as $user) {
        $userId = $user['id'];
        $profile = findProfile($user['profile_id']);
        $action = "<a href='client_view.php?view=$userId' class='btn btn-primary'>View</a>";
        $fullname = $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile ['last_name'];
        
        
        $output[] = array(
            'id'    => $user['id'],
            'fullname'  => $fullname,
            'username'   => $user['username'],
            'email'    => $profile['email'],
            'action' => $action
        );
    }

    ## Total number of records without filtering
    $findusers2 = selectAllRand('users', $searchConditions);
    $totalRecords = count($findusers2);
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
