<?php
    require_once('includes/database.php');
    require_once('includes/functions.php');

    session_start();
    redirectPage();

    if (!isset($_SESSION['user'])) {
        header('location: .');
        exit;
    }

    $product = fetchProduct((int) ($_GET['id'] ?? 0));
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['name']) : 'Product not found'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <?php createNavBar(); ?>

    <main class="container py-5">

        <?php if ($product): ?>

            <div class="row g-5">
                <div class="col-md-6">
                    <img src="img/<?php echo htmlspecialchars($product['image']); ?>" class="product-img rounded w-100" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                </div>
                <div class="col-md-6">
                    <h1 class="h3"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="fs-4 fw-semibold"><?php echo formatPrice($product['price']); ?></p>
                    <p class="text-body-secondary"><?php echo htmlspecialchars($product['description'] ?? ''); ?></p>

                    <form method="post" action="cart.php" class="d-flex gap-2 mt-4">
                        <input type="hidden" name="product-id" value="<?php echo $product['id']; ?>" />
                        <input type="number" name="quantity" class="form-control quantity-input" value="1" min="1" max="99" />
                        <button type="submit" name="add-to-cart" class="btn btn-light">Add to Cart</button>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <h1 class="h3">Product not found</h1>
            <a href="catalog.php">Back to products</a>

        <?php endif; ?>

    </main>

</body>
</html>
