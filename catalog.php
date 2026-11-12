<?php
    require_once('includes/database.php');
    require_once('includes/functions.php');

    session_start();
    redirectPage();

    if (!isset($_SESSION['user'])) {
        header('location: .');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <?php createNavBar(); ?>

    <main class="container py-5">
        <h1 class="h3 mb-4">Products</h1>
        <?php createProductsTable(); ?>
    </main>

</body>
</html>
