<?php

// Retrieve
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
	// Access
	$var = $data['test'] ?? 'No data received';
	
	// Response
	echo "Request successful\n";
	echo "Received data: ", json_encode($data, JSON_PRETTY_PRINT);
} else {
	echo "No data received.";
}

/*
<?php
// Retrieve the raw JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // Debugging: Print the received data
    header("Content-Type: application/json");
    echo json_encode(["status" => "success", "received" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => "No JSON data received"]);
}
?>
*/
?>