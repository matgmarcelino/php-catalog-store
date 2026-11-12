<?php
    require_once('includes/database.php');
    require_once('includes/functions.php');

    session_start();
    redirectPage();

    if (isset($_SESSION['user'])) {
        header('location: .');
        exit;
    }

    $passwordsDoNotMatch = false;
    $usernameAlreadyExists = false;

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['verifyPassword'])) {
        if ($_POST['password'] !== $_POST['verifyPassword']) {
            $passwordsDoNotMatch = true;
        } elseif (!createAccount($_POST['username'], $_POST['password'])) {
            $usernameAlreadyExists = true;
        } else {
            $_SESSION['user'] = $_POST['username'];
            header('location: .');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="js/create-account.js" defer></script>
</head>
<body>

    <?php createNavBar(); ?>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form method="post" class="card card-body p-4">
                    <h1 class="h4 mb-4">Create Account</h1>

                    <?php if ($usernameAlreadyExists): ?>
                        <div class="alert alert-danger py-2">That username is already taken.</div>
                    <?php endif; ?>

                    <?php if ($passwordsDoNotMatch): ?>
                        <div class="alert alert-danger py-2">Passwords do not match.</div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="verifyPassword" class="form-label">Confirm Password</label>
                        <input type="password" id="verifyPassword" name="verifyPassword" class="form-control" required />
                    </div>

                    <button type="submit" class="btn btn-light w-100">Create Account</button>

                    <p class="small text-center mt-3 mb-0">Already have an account? <a href=".">Log in</a></p>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
