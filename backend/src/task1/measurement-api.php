<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
header("Content-Type: application/json");
?>

<?php include_once 'massConvertor.php';?>
<?php include_once 'speedConvertor.php';?>
<?php include_once 'temperatureConvertor.php';?>
<?php

$unitNames = [
    'kg' => 'kilograms',
    'grams' => 'grams',
    'lb' => 'pounds',
    'kelvin' => 'kelvin',
    'celsius' => 'celsius',
    'fahrenheit' => 'fahrenheit',
    'kph' => 'kilometers per hour',
    'mps' => 'meters per second',
    'knots' => 'knots',
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["CONTENT_TYPE"] == 'application/json') {
    $content = file_get_contents("php://input");
    $data = json_decode($content, true);
    $unit1 = htmlspecialchars($data["unit1"]);
    $unit2 = htmlspecialchars($data["unit2"]);
    $quantity = htmlspecialchars($data["quantity"]);

    if (in_array($unit1, ['kg', 'grams', 'lb'])) {
        $equals = (new massConvertor())->convert($unit1, $unit2, $quantity);
    } elseif (in_array($unit1, ['kph', 'mps', 'knots'])) {
        $equals = (new speedConvertor())->convert($unit1, $unit2, $quantity);
    } elseif (in_array($unit1, ['celsius', 'fahrenheit', 'kelvin'])) {
        $equals = (new temperatureConvertor())->convert($unit1, $unit2, $quantity);
    }
    ;
    $formatted_quantity = floor($quantity) == $quantity ? number_format($quantity) : number_format($quantity, 2, '.', ',');
    $formatted_equals = floor($equals) == $equals ? number_format($equals) : number_format($equals, 2, '.', ',');
    http_response_code(200);
    echo json_encode(array("message" => "{$formatted_quantity} {$unitNames[$unit1]} equals to {$formatted_equals} {$unitNames[$unit2]}"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "something is wrong"));
}
