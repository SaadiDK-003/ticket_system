<?php
require_once 'core/database.php';
if (isLoggedin()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Login</title>
    <?php include_once 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="login">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 mx-auto">
                <?php
                if (isset($_POST['email']) && isset($_POST['password'])):
                    echo login($_POST['email'], $_POST['password']);
                endif;
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center">Login</h2>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <a class="nav-link" href="register.php">REGISTER</a>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                    LOGIN
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include 'includes/external_js.php'; ?>
</body>

</html>