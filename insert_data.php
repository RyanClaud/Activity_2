<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ryandb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["name"]) && !empty($data["age"]) && !empty($data["gender"]) && !empty($data["nationality"])) {
    $name = $conn->real_escape_string($data["name"]);
    $age = $conn->real_escape_string($data["age"]);
    $gender = $conn->real_escape_string($data["gender"]);
    $nationality = $conn->real_escape_string($data["nationality"]); 

    $sql = "INSERT INTO personal (name, age, gender, nationality) VALUES ('$name', '$age', '$gender', '$nationality')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
}

$conn->close();
?>
