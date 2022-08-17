<?php

header('Content-Type: application/json');

define('BASE_DIR', __DIR__ . '/');
include(BASE_DIR . 'bootstrap.php');

if (
    !isset($_GET['api-name']) ||
    !is_string($_GET['api-name'])
) {
    echo json_encode(
        ['status' => false, 'message' => 'api-name not specified'],
        JSON_PRETTY_PRINT
    );
    exit;
}

use Helpers\ApiHelper;

$api = new ApiHelper();

switch ($_GET['api-name']) {
    case 'add-todo':
        $api->add()->output();
        break;
    case 'get-todos':
        $api->getAll()->output();
        break;
    case 'delete-todo':
        $api->delete()->output();
        break;
    case 'get-todo-from-db':
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "materials_project_managment";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM todo_list";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Task: " . $row["task"]. " status:" . $row["status"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();

        break;
}