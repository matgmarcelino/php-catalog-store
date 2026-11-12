<?php

    function createNavBar() {
        echo '<nav class="navbar navbar-expand-sm border-bottom"><div class="container">';
        echo '<a class="navbar-brand fw-bold" href=".">Catalog</a>';
        echo '
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        ';
        echo '<div class="collapse navbar-collapse" id="mainNav">';
        echo '<form method="post" class="navbar-nav ms-auto">';
        echo '<button name="products" class="btn nav-link px-3">Products</button>';

        if (isset($_SESSION['user'])) {
            echo '<button name="cart" class="btn nav-link px-3">Cart</button>';
            echo '<button name="log-out" class="btn nav-link px-3 text-danger">Log Out</button>';
        } else {
            echo '<button name="log-in" class="btn nav-link px-3">Log In</button>';
            echo '<button name="create-account" class="btn nav-link px-3">Create Account</button>';
        }

        echo '</form></div></div></nav>';
    }

    function redirectPage() {
        $routes = [
            'products' => './catalog.php',
            'cart' => './cart.php',
            'log-out' => './logout.php',
            'log-in' => '.',
            'create-account' => './create-account.php'
        ];

        foreach ($routes as $button => $page) {
            if (isset($_POST[$button])) {
                header("location: $page");
                exit;
            }
        }
    }

    function formatPrice($price) {
        return '$' . number_format((float) $price, 2, '.', '');
    }

    function createProductsTable() {
        $products = fetchProducts();

        echo '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">';

        while ($row = $products->fetch_assoc()) {
            createProductListing($row['id'], $row['name'], $row['image'], $row['price']);
        }

        echo '</div>';
    }

    function createProductListing($id, $name, $image, $price) {
        $name = htmlspecialchars($name);
        $image = htmlspecialchars($image);
        $price = formatPrice($price);

        echo <<<HTML
            <div class="col">
                <div class="card product-card h-100">
                    <img src="img/$image" class="card-img-top product-img" alt="$name" />
                    <div class="card-body">
                        <h2 class="h6"><a href="product.php?id=$id" class="stretched-link text-decoration-none">$name</a></h2>
                        <p class="fw-semibold mb-0">$price</p>
                    </div>
                </div>
            </div>
        HTML;
    }

    function createCartItems(array $cart) {
        echo '<h1 class="h3 mb-4">Cart</h1>';

        if (empty($cart)) {
            echo '<p>Your cart is empty.</p>';
            echo '<a href="catalog.php" class="btn btn-light">View products</a>';
            return;
        }

        echo '<div class="row g-5">';
        echo '<div class="col-lg-8"><ul class="list-unstyled border-top">';

        foreach ($cart as $product) {
            createCartItem($product);
        }

        echo '</ul></div>';
        echo '<div class="col-lg-4"><div class="card card-body">';
        echo '<h2 class="h5 mb-3">Order Summary</h2>';

        createCartTotals($cart);

        echo <<<HTML
                <form method="post" action="cart.php" class="d-grid gap-2 mt-4">
                    <button type="submit" name="checkout" class="btn btn-light">Checkout</button>
                    <button type="submit" name="clear-cart" class="btn btn-outline-secondary">Clear cart</button>
                </form>
            </div></div></div>
        HTML;
    }

    function createCartItem(stdClass $product) {
        $id = $product->id;
        $name = htmlspecialchars($product->name);
        $image = htmlspecialchars($product->image);
        $price = $product->price;
        $quantity = $product->quantity;
        $priceText = formatPrice($price);
        $total = formatPrice($price * $quantity);

        echo <<<HTML
            <li class="cart-item d-flex gap-3 py-3 border-bottom" data-id="$id" data-price="$price">
                <a href="product.php?id=$id">
                    <img src="img/$image" class="product-img cart-img rounded" alt="$name" />
                </a>
                <div class="flex-grow-1">
                    <a href="product.php?id=$id" class="fw-semibold text-decoration-none">$name</a>
                    <p class="text-body-secondary small mb-2">$priceText each</p>
                    <form method="post" action="cart.php" class="d-flex align-items-center gap-2">
                        <input type="hidden" name="product-id" value="$id" />
                        <input type="number" name="quantity" class="form-control form-control-sm quantity-input" value="$quantity" max="99" />
                        <button type="submit" name="remove-item" class="btn btn-link btn-sm text-danger">Remove</button>
                    </form>
                </div>
                <p class="cart-line-total fw-semibold mb-0">$total</p>
            </li>
        HTML;
    }

    function createCartTotals(array $cart) {
        $subtotal = 0;
        foreach ($cart as $product) {
            $subtotal += $product->price * $product->quantity;
        }

        $tax = formatPrice($subtotal / 10);
        $total = formatPrice($subtotal * 1.1);
        $subtotal = formatPrice($subtotal);

        echo <<<HTML
            <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <span id="cart-subtotal">$subtotal</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tax</span>
                <span id="cart-tax">$tax</span>
            </div>
            <div class="d-flex justify-content-between fw-semibold border-top pt-2 mt-2">
                <span>Total</span>
                <span id="cart-total">$total</span>
            </div>
        HTML;
    }

    function createThankYouMessage(array $cart) {
        echo '<div class="row justify-content-center"><div class="col-md-8 col-lg-6">';
        echo '<h1 class="h3 mb-4">Thank you for your order!</h1>';
        echo '<div class="card card-body">';
        echo '<ul class="list-unstyled border-bottom pb-2 mb-3">';

        foreach ($cart as $product) {
            $name = htmlspecialchars($product->name);
            $quantity = $product->quantity;
            $total = formatPrice($product->price * $quantity);

            echo "<li class=\"d-flex justify-content-between py-1\"><span>$name x $quantity</span><span>$total</span></li>";
        }

        echo '</ul>';

        createCartTotals($cart);

        echo '</div>';
        echo '<a href="catalog.php" class="btn btn-light mt-4">Continue shopping</a>';
        echo '</div></div>';
    }

?>
