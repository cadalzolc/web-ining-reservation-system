<?

session_start();

$data = '{
    success: true,
    message: ""
}';

header("Content-Type: application/json; charset=UTF-8");

$json = json_encode($data);

echo $json;

