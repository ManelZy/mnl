<?php
require_once 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit(); // Stop further execution
}

if (isset($_GET['restid'])) {
    $restaurant_id = $_GET['restid'];
    $sql = "SELECT * FROM products WHERE restaurant = $restaurant_id";
    $all_product = $conn->query($sql);
}

$sql_categories = "SELECT DISTINCT dish_categ FROM products WHERE restaurant = $restaurant_id";
$categories_result = $conn->query($sql_categories);
$categories = array();

while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row['dish_categ'];
}

$_SESSION['rest_id'] = $restaurant_id;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>FOODZ©</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style6.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"  />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css">
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/account.js"></script>
    <style>.btn{
    color:rgb(255, 17, 0);
    border-radius: 10px;
    border-color: black;
    padding: auto;
}
.btn:hover {
    background-color: black;
    color: white;
  }</style>
</head>

<body class="main-layout blog_page">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/pizza.gif" alt="" /></div>
    </div>

    <div class="wrapper">
        <!-- end loader -->
        <div class="sidebar">
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="fa fa-arrow-right"></i>
                </div>
                <br>
                <div class="cart">
                    <h2 class="cart-title">Your Cart</h2>
                    <div class="cart-content">
                        <div id="cart-items"> <!-- Cart items container -->
                            <!-- Cart items will be added dynamically here -->
                        </div>
                        <div class="total">
                            <div class="total-title">Total</div>
                            <div class="total-price">$0</div>
                        </div>
                        <button type="button" class="btn-buy" id="buyNowButton" onclick="buyNow()">Buy Now</button>
                    </div>
                </div>
            </nav>
        </div>

        <div id="content">
            <!-- header -->
            <header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="full">
                                <a class="logo" href=""><h1> FOODZ.</h1></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="full">
                                <div class="right_header_info">
                                    <ul>
                                        <li>
                                            <form action="" class="searchBar">
                                                <input id="searchInput" type="text" placeholder="Food, drinks, etc" name="q">
                                                <button id="searchButton" type="button"><img src="images/search.png" alt="#"></button>
                                            </form>
                                        </li>
                                        <li class="dinone">
                                            <div class="dropdown">
                                                <a href=""><img src="images/log.png" width="30" height="30"/></a>
                                                <div class="dropdown-content">
                                                    <a href="settingsCustomer.php">Settings</a>
                                                    <a href="logout.php">Sign Out</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="cartis"><a href="myOrders.php" ><img src="images/order.png" alt="#" ></a> </li>
                                        <li>
                                            <button type="button" id="sidebarCollapse">
                                                <i class="cartis"><img src="images/add-cart.png" alt="#"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- end header -->
            <!-- blog -->
            <div class="blog">
                <div class="container">
                    <button type="button" id="backButton"><a href="restaurants.php" class="btn">See Restaurants</a></button>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="title">
                                <i><img src="images/shopping-cart.gif" width="100" height="100" alt="#"/></i>
                                <span>Add some delicious food to your cart!</span>
                            </div>
                        </div>
                    </div>
                    <section class="restaurants" id="restaurants">
                        <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
                            <a class="navbar-brand" href="#">menu</a>
                            <ul class="nav nav-pills">
                                <?php
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link" href="#" onclick="showCategory(\'all\')">All</a>'; // Add 'All' category
                                echo '</li>';

                                foreach ($categories as $category) {
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link" href="#" onclick="showCategory(\'' . $category . '\')">' . $category . '</a>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </nav>
                        <div class="box-container">
                            <?php
                            while ($row = mysqli_fetch_assoc($all_product)) {
                                echo '<div class="box" id="' . $row['dish_categ'] . '" data-category="' . $row['dish_categ'] . '">';
                                echo '<img src="' . $row['dish_img'] . '">';
                                echo '<h3 class="dish_name">' . $row['dish_name'] . '</h3>';
                                echo '<h4 class="dish_desc">' . $row['dish_desc'] . '</h4>';
                                echo '<h3 style="font-weight: 700;" class="dish_price">' . $row['dish_price'] . '<span>dzd</span></h3>';
                                echo '<div class="stars">';
                                echo '<span class="fa fa-star checked"></span>';
                                echo '<span class="fa fa-star checked"></span>';
                                echo '<span class="fa fa-star checked"></span>';
                                echo '<span class="fa fa-star checked"></span>';
                                echo '<span class="fa fa-star"></span>';
                                echo '</div>';
                                echo '<a href="#" class="btn" onclick="addToCart(\'' . $row['dish_id'] . '\', \'' . $row['dish_name'] . '\', ' . $row['dish_price'] . ', \'' . $row['dish_img'] . '\')">Add to cart</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="copyright">
            <div class="container">
                <p><a href="home.html"><img src="images/FOODZ-2.png" width="100" height="100" alt="#"/></a>FOODZ© 2023 All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
  


</body>

</html>
