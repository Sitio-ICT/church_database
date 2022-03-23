<?php
$reference = $_GET['reference'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/:$reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_96566ed87155b51c96a1dc6f13f7cb4639b20130",
        "Cache-Control: no-cache",
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response['data']['status'];
}
