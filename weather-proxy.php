<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$validCities = ['austin', 'irving', 'fort worth'];
$city = strtolower($_GET['city'] ?? '');

if (!in_array($city, $validCities)) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid city']));
}

$apiKey = '161a8198e9ce488490662508250204';
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city,Texas&units=imperial&appid=$apiKey";

$response = file_get_contents($apiUrl);
if ($response === FALSE) {
    http_response_code(502);
    die(json_encode(['error' => 'Weather service unavailable']));
}

echo $response;
?>
