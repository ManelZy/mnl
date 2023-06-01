<?php
include 'connect.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
  // User is not logged in, redirect to login page
  header("Location: login.html");
  exit(); // Stop further execution
}
$restaurant_id=$_SESSION['rest_id'];
$order_userid = $_SESSION['user_id'];

// Get cart item data from POST request
$cartItemsData = json_decode(file_get_contents("php://input"), true);

// Insert order data into the orders table
$orderSql = "INSERT INTO orders (user_id, method, total_products, total_price, placed_on, restaurant_id) VALUES (?, ?, ?, ?, ?, ?)";
$orderStmt = $conn->prepare($orderSql);
$order_method = "by web"; // Replace with the actual order method
$order_total_products = 0; // Initialize total products count
$order_total_price = 0;


// Retrieve the restaurant ID from the POST data

// Calculate the total price and total products count of all products in the cart
foreach ($cartItemsData as $cartItem) {
  $order_total_price += ($cartItem["price"] * $cartItem["quantity"]);
  $order_total_products += $cartItem["quantity"];
 
}

$order_placed_on = date("Y-m-d"); // Get the current date

$orderStmt->bind_param("issdsi", $order_userid, $order_method, $order_total_products, $order_total_price, $order_placed_on, $restaurant_id);
if ($orderStmt->execute()) {
  // Retrieve the auto-generated order ID
  $order_id = $orderStmt->insert_id;

  // Insert cart item data into the order_items table
  $orderItemsSql = "INSERT INTO order_items (order_id, dish_id, item_quantity) VALUES (?, ?, ?)";
  $orderItemsStmt = $conn->prepare($orderItemsSql);

  foreach ($cartItemsData as $cartItem) {
    $dish_id = $cartItem["id"];
    $quantity = $cartItem["quantity"];
   
    $orderItemsStmt->bind_param("iii", $order_id, $dish_id, $quantity);
    if ($orderItemsStmt->execute()) {
      echo "Cart item added successfully";
    } else {
      echo "Error: " . $orderItemsSql . "<br>" . $conn->error;
    }
  }

  $orderItemsStmt->close();
} else {
  echo "Error: " . $orderSql . "<br>" . $conn->error;
}

// Close database connection
$orderStmt->close();
$conn->close();
?>