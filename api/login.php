<?php
include_once './cors.php';
ob_start();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $email = $data->email;
    $password = $data->password;

    if (empty($email) || empty($password)){
        $err = array();
        $err['error'] = "All fields are required";
        echo json_encode($err);
        exit;
    }

    $isSuccess = 0;
$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);  // database connection
    $sql = "SELECT * FROM users WHERE email= ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('s', $email);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_assoc()) {
        if (! empty($row)) {
            $hashedPassword = $row["password"]; 
            if (password_verify($password, $hashedPassword)) {
                $isSuccess = 1;
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_type'] = $row['user_type'];
            }
        }
    }
    if ($isSuccess == 0) {
        echo mysqli_error($conn);
        // login user failed
        $err = array();
        $err['error'] = "invalid username or password";
        echo json_encode($err);
        exit;
    } else {
        // switch ($_SESSION['user_type']) {
        //     case 1:
        //         header('location: /super');
        //         break;
        //     case 2:
        //         header('location: /school');
        //         break;
        //     case 3:
        //         header('location: /business');
        //         break;
        //     case 4:
        //         header('location: /student');
        //         break;
        // }

        $result = array();
        $result['id'] =    $_SESSION['id'];
        $result['user_type'] = $_SESSION['user_type'];
        echo json_encode($result);
    }
}
