

document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("searchInput");
    var searchButton = document.getElementById("searchButton");
    var dishContainer = document.querySelector(".box-container");

    searchButton.addEventListener("click", filterDishes);
    searchInput.addEventListener("input", filterDishes);

    function filterDishes() {
        var searchTerm = searchInput.value.toLowerCase();
        var dishBoxes = dishContainer.getElementsByClassName("box");

        for (var i = 0; i < dishBoxes.length; i++) {
            var dishName = dishBoxes[i].getElementsByClassName("dish_name")[0].textContent.toLowerCase();
            var dishDesc = dishBoxes[i].getElementsByClassName("dish_desc")[0].textContent.toLowerCase();
            if (dishName.includes(searchTerm) || dishDesc.includes(searchTerm)) {
                dishBoxes[i].style.display = "block";
            } else {
                dishBoxes[i].style.display = "none";
            }
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("searchInputt");
    var searchButton = document.getElementById("searchButtonn");
    var dishContainer = document.querySelector(".box-container");

    searchButton.addEventListener("click", filterDishes);
    searchInput.addEventListener("input", filterDishes);

    function filterDishes() {
        var searchTerm = searchInput.value.toLowerCase();
        var dishBoxes = dishContainer.getElementsByClassName("box");

        for (var i = 0; i < dishBoxes.length; i++) {
            var dishName = dishBoxes[i].getElementsByTagName("h3")[0].textContent.toLowerCase();
            if (dishName.includes(searchTerm)) {
                dishBoxes[i].style.display = "block";
            } else {
                dishBoxes[i].style.display = "none";
            }
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
  var searchInput = document.getElementById("searchInputy");
  var searchButton = document.getElementById("searchButtony");
  var dishContainer = document.querySelector(".box-container");

  searchButton.addEventListener("click", filterDishes);
  searchInput.addEventListener("input", filterDishes);

  function filterDishes() {
    var searchTerm = searchInput.value.toLowerCase();
        var dishBoxes = dishContainer.getElementsByClassName("box");
        for (var i = 0; i < dishBoxes.length; i++) {
          var dishName = dishBoxes[i].getElementsByTagName("h3")[0].textContent.toLowerCase();
          if (dishName.includes(searchTerm)) {
              dishBoxes[i].style.display = "block";
          } else {
              dishBoxes[i].style.display = "none";
          }
      }
  }
});





  $(document).ready(function() {
      $("#sidebar").mCustomScrollbar({
          theme: "minimal"
      });

      $('#dismiss, .overlay').on('click', function() {
          $('#sidebar').removeClass('active');
          $('.overlay').removeClass('active');
      });

      $('#sidebarCollapse').on('click', function() {
          $('#sidebar').addClass('active');
          $('.overlay').addClass('active');
          $('.collapse.in').toggleClass('in');
          $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });
  });

  function addToCart(id, name, price, image) {
    // Create cart item data
   
  
    var existingCartItem = findExistingCartItem(name);
  
    if (existingCartItem) {
      var cartQuantity = existingCartItem.getElementsByClassName("cart-quantity")[0];
      var quantity = parseInt(cartQuantity.value);
      quantity++;
      cartQuantity.value = quantity;
    } else {
      // Create cart item element
      var cartItem = document.createElement("div");
      cartItem.classList.add("cart-box");
  
      // Set image
      var cartImg = document.createElement("img");
      cartImg.src = image;
      cartImg.alt = "";
      cartImg.classList.add("cart-img");
      cartItem.appendChild(cartImg);
  
      // Set detail box
      var detailBox = document.createElement("div");
      detailBox.classList.add("detail-box");
  
      // Set product title
      var cartProductTitle = document.createElement("div");
      cartProductTitle.classList.add("cart-product-title");
      cartProductTitle.textContent = name;
      detailBox.appendChild(cartProductTitle);
  
      // Set product price
      var cartPrice = document.createElement("div");
      cartPrice.classList.add("cart-price");
      cartPrice.textContent = price.toFixed(2) + " dzd";
      detailBox.appendChild(cartPrice);
  
      // Set quantity input
      var cartQuantity = document.createElement("input");
      cartQuantity.type = "number";
      cartQuantity.value = 1;
      cartQuantity.min = 1; // Set the minimum value allowed to 1
      cartQuantity.classList.add("cart-quantity");
      cartQuantity.addEventListener("change", updateTotal);
      detailBox.appendChild(cartQuantity);

      // id
      cartItem.dataset.id = id; 
  
      // Set remove button
      var removeBtn = document.createElement("i");
      removeBtn.classList.add("fa", "fa-trash");
      removeBtn.addEventListener("click", removeCartItem);
      detailBox.appendChild(removeBtn);
  
      // Append detail box to cart item
      cartItem.appendChild(detailBox);
  
      // Append cart item to cart items container
      var cartItems = document.getElementById("cart-items");
      cartItems.insertBefore(cartItem, cartItems.firstChild);
    }
  
    // Update total price
    updateTotal();
  
    // Scroll to the top of the cart items container
    cartItems.scrollTop = 0;
  
    // Show "Added successfully" window
    alert("Added successfully");
  }
  
  function findExistingCartItem(name) {
    var cartItems = document.getElementsByClassName("cart-box");
  
    for (var i = 0; i < cartItems.length; i++) {
      var cartProductTitle = cartItems[i].getElementsByClassName("cart-product-title")[0];
      if (cartProductTitle.textContent === name) {
        return cartItems[i];
      }
    }
  
    return null;
  }
  
  function removeCartItem(event) {
    var cartItem = event.target.parentElement.parentElement;
    cartItem.remove();
    updateTotal();
  }
  
  function updateTotal() {
    var cartItems = document.getElementsByClassName("cart-box");
    var totalPrice = 0;
  
    for (var i = 0; i < cartItems.length; i++) {
      var cartItem = cartItems[i];
      var cartPrice = cartItem.getElementsByClassName("cart-price")[0];
      var cartQuantity = cartItem.getElementsByClassName("cart-quantity")[0];
      var price = parseFloat(cartPrice.textContent.replace(" dzd", ""));
      var quantity = parseInt(cartQuantity.value);
      totalPrice += price * quantity;
    }
  
    var totalElement = document.getElementsByClassName("total-price")[0];
    totalElement.textContent = totalPrice.toFixed(2) + " dzd";
  }
  
  function buyNow() {
  

    var cartItems = document.getElementsByClassName("cart-box");
  
    if (cartItems.length === 0) {
      alert("Your cart is empty. Please add items before proceeding.");
      return;
    }
  
    // Create an array to store cart item data
    var cartItemsData = [];
  
    // Iterate over each cart item and collect the data
    for (var i = 0; i < cartItems.length; i++) {
      var cartItem = cartItems[i];
      var cartProductTitle = cartItem.getElementsByClassName("cart-product-title")[0].textContent;
      var cartPrice = parseFloat(cartItem.getElementsByClassName("cart-price")[0].textContent.replace(" dzd", ""));
      var cartQuantity = parseInt(cartItem.getElementsByClassName("cart-quantity")[0].value);
      var cartImg = cartItem.getElementsByClassName("cart-img")[0].src;
      var cartId = parseInt(cartItem.dataset.id); // Get the dish ID from the dataset attribute
  
      var cartItemData = {
        id: cartId, // Use cartId instead of undefined id
        name: cartProductTitle,
        price: cartPrice,
        quantity: cartQuantity,
        image: cartImg
      };
  
      cartItemsData.push(cartItemData);
    }
  
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ordering.php");
    xhr.setRequestHeader("Content-Type", "application/json");
  
    // Send the cart item data as JSON
    xhr.send(JSON.stringify(cartItemsData));
  
    // Continue with the checkout process
    // ...
      // Reset the cart content
  var cartItemsContainer = document.getElementById("cart-items");
  while (cartItemsContainer.firstChild) {
    cartItemsContainer.removeChild(cartItemsContainer.firstChild);
  }

  // Update total price
  updateTotal();

  // Show "Order placed successfully" message
  alert("Order placed successfully");
  }
  

  function showCategory(category) {
    // Get all elements with the class 'box'
    var boxes = document.getElementsByClassName('box');

    // Loop through all boxes and show/hide them based on the category
    for (var i = 0; i < boxes.length; i++) {
      var box = boxes[i];

      // Check if the box belongs to the selected category
      if (box.getAttribute('data-category') === category || category === 'all') {
        box.style.display = 'block'; // Show the box
      } else {
        box.style.display = 'none'; // Hide the box
      }
    }
  }