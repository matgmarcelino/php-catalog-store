<?php
    require_once('includes/database.php');
    require_once('includes/functions.php');

    session_start();

    if (!isset($_SESSION['user'])) {
        header('location: .');
        exit;
    }

    $cart = json_decode($_SESSION['cart'] ?? '[]');

    if (isset($_POST['cart-quantities'])) {
        $quantities = json_decode($_POST['cart-quantities'], true);

        foreach ($cart as $item) {
            if (isset($quantities[$item->id])) {
                $item->quantity = (int) $quantities[$item->id];
            }
        }

        $cart = array_values(array_filter($cart, fn($item) => $item->quantity > 0));

        $_SESSION['cart'] = json_encode($cart);
    }

    redirectPage();

    if (isset($_POST['clear-cart'])) {
        $cart = [];
    } elseif (isset($_POST['remove-item'])) {
        $id = (int) $_POST['product-id'];
        $cart = array_values(array_filter($cart, fn($item) => $item->id !== $id));
    } elseif (isset($_POST['add-to-cart'])) {
        $product = fetchProduct((int) $_POST['product-id']);
        $quantity = (int) $_POST['quantity'];

        if (!$product || $quantity < 1) {
            header('location: catalog.php');
            exit;
        }

        $found = false;
        foreach ($cart as $item) {
            if ($item->id === $product['id']) {
                $item->quantity += $quantity;
                $found = true;
            }
        }

        if (!$found) {
            $cart[] = (object) [
                'id' => $product['id'],
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => (float) $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    $_SESSION['cart'] = isset($_POST['checkout']) ? '[]' : json_encode($cart);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="js/cart.js" defer></script>
</head>
<body>

    <?php createNavBar(); ?>

    <main class="container py-5">
        <?php
            if (isset($_POST['checkout']) && !empty($cart)) {
                createThankYouMessage($cart);
            } else {
                createCartItems($cart);
            }
        ?>
    </main>

</body>
</html>
