<?php
    session_start();
    
    if(isset($_POST['send'])){
        $message = htmlentities($_POST['message']);
        if(!isset($message)){
            $_SESSION['error'] = "Enter Message";
            header('Location: chat.php');
            return;
        }else{
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new PDO("mysql:host=$servername; dbname=marketplace", $username, $password);

            $stmt = $conn->prepare('INSERT INTO message(message, sender_id, receiver_id, email) VALUES (:msg, :sid, :rid, :em)');
            $stmt->execute(array(
                ':msg' => $message,
                ':sid' => $_SESSION['id'],
                ':rid' => $_SESSION['rid'],
                ':em' => $_SESSION['email']
            ));
            header('Location: chat.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="layout.css"> -->
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            background: #aaaaaa;
        }
        #header{
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 17.5px;
            width: 100%;
            background: #b9b9b9;
        }

        header a{
            color: antiquewhite;
            margin-left: 20px;
            font-size: 18px;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .container{
            height: 100%;
            width: 100%;
            background: #aaaaaa;
            display: grid;
            grid-gap: 20px;
            padding: 35px 20px;
            color: #fff;
            grid-template-columns: 1fr 3.5fr;
            grid-template-rows: 3fr .5fr;
            grid-template-areas: 
            'chatlist chat-content'
            'chatlist chatbox';
        }

        .chatlist{
            grid-area: chatlist;
            background: #fff;
            width: 100%;
            color: #0e58c7;
            border-radius: 5px;

        }

        .chat-content{
            grid-area: chat-content;
            background: #fff;
            color: #0e58c7;
            border-radius: 5px;
            height: 100%;
        }

        .chatbox{
            grid-area: chatbox;
            background: #fff;
            color: #0e58c7;
            border-radius: 5px;

        }

        form{
            width: 100%;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 20px;
        }

        form input, .chatname{
            padding: 15px;
            width: 100%;
            border-radius: 5px;
            border: none;
            outline: none;
            background: #f0f0f0;
        }
        form input::placeholder{font-style: italic; letter-spacing: 3px;}
        form input[type=submit]{
            width: 10%;
            margin-right: 10px;
        }

        .chatname{
            width: 100% !important;
            margin-right: 0 !important;
            font-size: 20px;
            letter-spacing: 2px;
        }
        .sendmes{
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin: 10px;
        }

        .sendmes p{
            width: auto;
            padding: 15px;
            background: #dfdfdf;
            border-radius: 20px;
        }

        .replymes{
            display: flex;
            align-items: center;
            margin: 10px;
        }

        .replymes p{
            width: auto;
            padding: 15px;
            background: #f09d9d;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <section class="container">
        <div class="chatlist">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new PDO("mysql:host=$servername; dbname=marketplace", $username, $password);
            $sid = $_SESSION['id'];
            $sn = 4;
            $bn = 3;

            if ($_SESSION['user_type'] == 4){ 

                $stmt = $conn->query("SELECT * FROM users WHERE user_type != '$sn'");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<form action="" method="post">';
                        echo ('<input type="hidden" value="' .htmlentities($row['id']). '" name="chatId">');
                        echo ('<input class="chatname" type="submit" value="' .htmlentities($row['name']). '" name="chatnameBtn">');
                    echo '</form>';
                }
            }else if ($_SESSION['user_type'] == 3){ 

                $stmt = $conn->query("SELECT * FROM users WHERE user_type != '$bn'");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<form action="" method="post">';
                        echo ('<input type="hidden" value="' .htmlentities($row['id']). '" name="chatId">');
                        echo ('<input class="chatname" type="submit" value="' .htmlentities($row['name']). '" name="chatnameBtn">');
                    echo '</form>';
                }
            }else if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1){ 

                $stmt = $conn->query("SELECT * FROM users");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<form action="" method="post">';
                        echo ('<input type="hidden" value="' .htmlentities($row['id']). '" name="chatId">');
                        echo ('<input class="chatname" type="submit" value="' .htmlentities($row['name']). '" name="chatnameBtn">');
                    echo '</form>';
                }
            }
        ?>  
        </div>
        <div class="chat-content">
            <?php
                if(isset($_POST['chatnameBtn'])){
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $conn = new PDO("mysql:host=$servername; dbname=marketplace", $username, $password);

                    $_SESSION['rid'] = $_POST['chatId'];
                    $sid = $_SESSION['id'];
                    $rid = $_SESSION['rid'];
                    $em = $_SESSION['email'];
                    $stmt = $conn->query("SELECT * FROM message WHERE (sender_id = '$rid' && receiver_id = '$sid' || receiver_id = '$rid' && sender_id = '$sid') ORDER BY message_id");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        if($row['email'] == $em){
                            echo '<div class="sendmes">';
                                echo ('<p>' .htmlentities($row['message']). '</p>');
                            echo '</div>';
                        }else{
                            echo '<div class="replymes">';
                                echo ('<p>' .htmlentities($row['message']). '</p>');
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>
        <div class="chatbox">
            <form action="" method="post">
                <input type="submit" value="Send" name="send">
                <input type="text" name="message" placeholder="reply...">
            </form>
        </div>        
    </section>
</body>
</html>