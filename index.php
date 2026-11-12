<?php
    require_once('includes/database.php');
    require_once('includes/functions.php');

    session_start();
    redirectPage();

    $loginFailed = false;

    if (!isset($_SESSION['user']) && isset($_POST['username']) && isset($_POST['password'])) {
        if (fetchAccount($_POST['username'], $_POST['password'])) {
            $_SESSION['user'] = $_POST['username'];
        } else {
            $loginFailed = true;
        }
    }

    $loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $loggedIn ? 'Catalog' : 'Log In'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body>

    <?php createNavBar(); ?>

    <main class="container py-5">

        <?php if ($loggedIn): ?>

            <h1 class="mb-3">Hello, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
            <a href="catalog.php" class="btn btn-light">Browse products</a>
            <a href="cart.php" class="btn btn-outline-secondary">View cart</a>

        <?php else: ?>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <form method="post" class="card card-body p-4">
                        <h1 class="h4 mb-4">Log In</h1>

                        <?php if ($loginFailed): ?>
                            <div class="alert alert-danger py-2">Incorrect username or password.</div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>

                        <button type="submit" class="btn btn-light w-100">Log In</button>

                        <p class="small text-center mt-3 mb-0">Don't have an account? <a href="create-account.php">Create one</a></p>
                    </form>
                </div>
            </div>

        <?php endif; ?>

    </main>

</body>
</html>
