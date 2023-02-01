<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;
$clubs = array();
$myclubs = array();
$products = array();

$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);// database connection
// products
$products_sql = "SELECT products.id, products.name, products.product_image, products.price, users.name AS seller, users.department FROM products INNER JOIN users ON users.id = products.owner and users.id!=$id";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'name'=>$row['name'],'price'=>$row['price'],
        'seller'=>$row['seller'],'image'=>base64_encode($row['product_image']),'department'=>$row['department']);
        array_push($products, $push);
    }
}

//myproducts
$myproducts =array();
// products
$products_sql = "SELECT products.id, products.name, products.product_image, products.price, users.name AS seller, users.department FROM products INNER JOIN users ON users.id = products.owner and users.id=$id";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'name'=>$row['name'],'price'=>$row['price'],
        'seller'=>$row['seller'],'image'=>base64_encode($row['product_image']),'department'=>$row['department']);
        array_push($myproducts, $push);
    }
}

//display orders
$orders = array();

// orders
$orders_sql = "SELECT orders.id, products.id, products.name, products.price, orders.quantity AS quantity, orders.id AS orderID FROM products JOIN users JOIN orders ON users.id = orders.user_id AND products.id = orders.product_id WHERE orders.canceled = 0"; 
$statement = $conn->prepare($orders_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($orders, $row);
    }
}

//return/canceled orders
$returns = array();

$returns_sql = "SELECT products.id, products.name, products.price, orders.quantity AS quantity, orders.id AS orderID FROM products JOIN users JOIN orders ON users.id = orders.user_id AND products.id = orders.product_id WHERE orders.canceled = 1"; 
$statement = $conn->prepare($returns_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($returns, $row);
    }
}

// All clubs
$groups_sql = "SELECT clubs.id, clubs.name, users.name AS creator, users.department FROM clubs LEFT JOIN users ON clubs.creator=users.id";
$statement = $conn->prepare($groups_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($clubs, $row);
    }
}
//myclubs
$my_club = array();

$myclub_sql = "SELECT users.name,c.cname,c.clubid from users, (SELECT clubs.creator as creator,club_member.id, users.id AS uid, users.name AS uname, clubs.name AS cname,clubs.id as clubid FROM users JOIN clubs JOIN club_member ON users.id = club_member.user_id AND clubs.id = club_member.club_id WHERE users.id = $id)  c where c.creator=users.id";
$statement = $conn->prepare($myclub_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($my_club, $row);
    }
}
//myorders
$myorders = array();
    $orderssql = "SELECT o.id,p.name,o.quantity,p.price FROM orders o,products p where user_id = $id and p.id =o.product_id";
    $statement = $conn->prepare($orderssql);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($myorders, $row);
    }
}

$advertisements = array();
// All advertisements
$groups_sql = "SELECT title,content,name FROM `advertisements`,users where users.id = advertisements.author";
$statement = $conn->prepare($groups_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($advertisements, $row);
    }
}

$posts =array();
// posts
$products_sql = "select user_posts.id,content,image,name from user_posts, users where users.id = user_posts.author";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'content'=>$row['content'],'image'=>base64_encode($row['image']),'name'=>$row['name']);
        array_push($posts, $push);
    }
}
// //Deleting Club

// if(isset($_GET['deleteclub'])){
//     $deleteClub = "DELETE FROM clubs WHERE id='".$_GET['clubId']."'";
//     $st = $conn->prepare($deleteClub);
//     $st->execute();
//     $res = $st->get_result();
//     header('location:student-panel.php?#my-club');
// }

// if(isset($_POST['order'])){
        
//     $prodict_id = $_POST['product_id'];
//     $quantity = $_POST['quantity'];
//     $user_id = $_SESSION['id'];

//     $dbName = "marketplace";
        
//     $conn = mysqli_connect("localhost", "root", "", $dbName); // database connection

//     $sql = "INSERT INTO cart (product_id, user_id, quantity) VALUES (?,?,?) ";
//     $statement = $conn->prepare($sql);
//     $statement->bind_param('sss', $prodict_id, $user_id, $quantity);
//     $statement->execute();
//     $result = $statement->get_result();
//     $_SESSION['success'] = 'Order Successful';
//     header("location: student-panel.php");
// }

// $carts = array();

// // cart
// $cart_sql = "SELECT products.id, products.name, products.price, cart.quantity AS quantity, cart.id AS cartID FROM products JOIN users JOIN cart ON users.id = cart.user_id AND products.id = cart.product_id";
// $statement = $conn->prepare($cart_sql);
// $statement->execute();
// $result = $statement->get_result();
// while ($row = $result->fetch_assoc()) {
//     if (!empty($row)) {
//         array_push($carts, $row);
//     }
// }

// //delete cart item
// if (isset ($_POST['deleteCart'])){
//     $dbName = "marketplace";
        
//     $conn = mysqli_connect("localhost", "root", "", $dbName); // database connection

//     $cart_id = $_POST['cartID'];

//     $sql = "DELETE FROM cart WHERE id = ?";
//     $statement = $conn->prepare($sql);
//     $statement->bind_param('s', $cart_id);
//     $statement->execute();
//     $result = $statement->get_result();
//     $_SESSION['success'] = 'Cart Item deleted';
//     header("location: student-panel.php");
// }



// // Deleting products
// if(isset($_GET['delete']) && isset($_GET['productId']))
// {
//     $delete_query = 'DELETE FROM products WHERE id="'.$_GET['productId'].'"';
//     $statement = $conn->prepare($delete_query);
//     $statement->execute();
//     $result = $statement->get_result();
//     header("location: student-panel.php#myproducts");
// }


// //Updating product
// if(isset($_POST['updating'])){

//     $productID = $_POST['productid'];
//     $product_name = $_POST['name'];
//     $product_price = $_POST['price'];
//     $product_image = $_POST['product_image'];

//     $update_query = "UPDATE `products` SET `name` = '$product_name', `price` = '$product_price' WHERE `products`.`id` = '$productID'";
//     $statement = $conn->prepare($update_query);
//     $statement->execute();
//     $result = $statement->get_result();
//     header("location: student-panel.php#myproducts");
// }

// $clubs_members = array();

// // products
// $club_sql = "SELECT club_member.id, users.id AS uid, users.name AS uname, clubs.name AS cname FROM users JOIN clubs JOIN club_member ON users.id = club_member.user_id AND clubs.id = club_member.club_id WHERE users.id != $id";
// $statement = $conn->prepare($club_sql);
// $statement->execute();
// $result = $statement->get_result();
// while ($row = $result->fetch_assoc()) {
//     if (!empty($row)) {
//         array_push($clubs_members, $row);
//     }
// }




// //delete Order
// if (isset($_POST['deleteOrder'])){
//     $dbName = "marketplace";
        
//     $conn = mysqli_connect("localhost", "root", "", $dbName); // database connection

//     $order_id = $_POST['orderID'];

//     $sql = "DELETE FROM orders WHERE id = ?";
//     $statement = $conn->prepare($sql);
//     $statement->bind_param('s', $order_id);
//     $statement->execute();
//     $result = $statement->get_result();
//     $_SESSION['success'] = 'Order deleted';
//     header("location: student-panel.php");

// }

// //return order
// if (isset($_POST['return'])){
//     $dbName = "marketplace";
        
//     $conn = mysqli_connect("localhost", "root", "", $dbName); // database connection

//     $order_id = $_POST['orderID'];
//     $update_query = "UPDATE `orders` SET `canceled` = 1 WHERE `orders`.`id` = '$order_id'";
//     $statement = $conn->prepare($update_query);
//     $statement->execute();
//     $result = $statement->get_result();
//     header("location: student-panel.php#myproducts");
// }




$r = array();

$r['products'] = $products;
$r['myproducts'] = $myproducts;
$r['orders'] = $orders;
$r['myorders'] = $myorders;
$r['returns'] = $returns;
$r['posts'] = $posts;
// //$r['cart'] = $cart;
// $r['clubs_members'] = $clubs_members;
$r['allclubs'] = $clubs;
$r['myclubs'] =$my_club;
$r['advertisements']= $advertisements;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}
?>