<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET');

// Validate input
$validCities = ['austin', 'irving', 'fort worth'];
$city = strtolower(trim($_GET['city'] ?? ''));

if (!in_array($city, $validCities)) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid city specified']));
}

// Securely fetch weather data
$apiKey = '161a8198e9ce488490662508250204'; // Your OpenWeatherMap key
$apiUrl = sprintf(
    'https://api.openweathermap.org/data/2.5/weather?q=%s,Texas&units=imperial&appid=%s',
    urlencode($city),
    $apiKey
);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FAILONERROR => true,
    CURLOPT_TIMEOUT => 5
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    http_response_code(502);
    die(json_encode(['error' => 'Weather service unavailable']));
}

curl_close($ch);
echo $response;
?>
