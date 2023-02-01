<?php
include_once './cors.php';
ob_start();
session_start();
require __DIR__.'\PHPMailer\Exception.php';
require __DIR__.'\PHPMailer\PHPMailer.php';
require __DIR__.'\PHPMailer\SMTP.php';
  use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $department= $_POST['department'];
    $password = $_POST['password'];
    $type = $_POST['user_type'];
    $business_name = "none";

    if(isset($name) && isset($email) && isset($phone) && isset($address) && isset($department) && isset($password) && isset($type)){
    
        if(strpos($email, '@') == false) {
            $_SESSION["error"] = "Input Valid Email";
            header("Location: http://localhost:3000/register");
            return;
        }else if(!filter_var($phone, FILTER_SANITIZE_NUMBER_INT)) {
            $_SESSION["error"] = "Phone number must start with '+' and country code";
            header("Location: http://localhost:3000/register");
            return;
        }else if(strlen($password) < 6){
            $_SESSION['error'] = "Password must not be less than 6 characters";
            header('Location: http://localhost:3000/register');
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);; // database connection
        if (mysqli_error($conn) != ""){
            echo mysqli_error($conn);
            $_SESSION["error"] = "user registration failed";
            header("Location: http://localhost:3000/register");
            return;
        } else {
            $sql = "INSERT INTO users (email, password, name, user_type,address, business_name, phone, department) VALUES (?,?,?,?,?,?,?,?) ";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssssssss', $email, $hashed_password, $name, $type, $address, $business_name, $phone, $department);
            $statement->execute();
            $result = $statement->get_result();

            if (!$statement){
                $_SESSION["error"] = "user registration failed";
                header("Location: http://localhost:3000/register");
                return;
            }

            // Send email notification

            $message='Congratulations! You have successfully registered with Mercado Escolar. Your username is: '.$name.' '.'and your password is: '.$password;
        
	    $mail = new PHPMailer;
 	    $mail->isSMTP(); 
	    $mail->SMTPDebug = 0; 
	    $mail->Host = 'smtp.gmail.com'; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
	    $mail->Port = 587; // TLS only
	    $mail->SMTPSecure = 'tls'; // ssl is depracated
	    $mail->SMTPAuth = true;
	    $mail->Username = 'noreplyatmercadoescolar@gmail.com';
	    $mail->Password = 'tvctpypslrrlycyk';
	    $mail->setFrom('noreplyatmercadoescolar@gmail.com', $name);
	    $mail->addAddress($email, $name);
 	    $mail->Subject = 'Mercado Registration Notification';
	    $mail->msgHTML($message); 
        $mail->AltBody = 'HTML messaging not supported';
	   //$mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

	    if(!$mail->send()){
   	    echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
  		//   echo '<script>alert("A mail has been sent to your registered email id")</script>';
		}
            header("location: http://localhost:3000/login");
        }

        header("location: http://localhost:3000/login");
    }
    }