<?php

$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

 // users
 $users = array();
$products_sql = "SELECT user_type, count(*) as count FROM `users` GROUP by user_type";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($users, $row);
    }
}
$student = 0;
$business_owner = 0;
$school_admin = 0;
$super_admin = 0;
  foreach ($users as $user) {
    if($user['user_type']==1) {
        $super_admin = $user['count'];
    }
     if($user['user_type']==2) {
        $school_admin = $user['count'];
    }
     if($user['user_type']==3) {
        $business_owner = $user['count'];
    }
     if($user['user_type']==4) {
        $student = $user['count'];
    }

 }
$dataPoints = array( 
	array("label"=>"students", "y"=>$student),
	array("label"=>"businessowners", "y"=> $business_owner),
	array("label"=>"school admins", "y"=>$school_admin),
	array("label"=>"super admins", "y"=> $super_admin)
);
 
$products = array();
$products_sql = "SELECT p.name,p.id,o.quantity FROM products p, orders o ";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($products, $row);
    }
}

$tea = 0;
$coffee = 0;
$frappucino = 0;
  foreach ($products as $product) {
     if($product["name"]=="coffee") {
        $coffee = $product['quantity']+$coffee;
    }
     if($product["name"]=="frappucino") {
        $frappucino = $product['quantity']+$frappucino;
    }

 }
$dataPoints1 = array( 
	array("label"=>"tea", "y"=>$tea),
	array("label"=>"coffee", "y"=> $coffee),
	array("label"=>"frappucino", "y"=>$frappucino)
)

?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Types of users chart"
	},
	data: [{
		type: "pie",
		indexLabel: "{y}",
		yValueFormatString: "#,##0.00\"\"",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "#36454F",
		indexLabelFontSize: 18,
		indexLabelFontWeight: "bolder",
		showInLegend: true,
		legendText: "{label}",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();


var chart1 = new CanvasJS.Chart("chartContainer2", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Types of products sold in quantity"
	},
	data: [{
		type: "pie",
		indexLabel: "{y}",
		yValueFormatString: "#,##0.00\"\"",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "#36454F",
		indexLabelFontSize: 18,
		indexLabelFontWeight: "bolder",
		showInLegend: true,
		legendText: "{label}",
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>   