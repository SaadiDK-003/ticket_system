<?php
require_once 'core/database.php';
$token_Q = $db->query("SELECT `reg_token` FROM `token`");
$token = mysqli_fetch_object($token_Q);
if (isLoggedin()) {
    header('Location: index.php');
}
if ($_GET['token'] != $token->reg_token) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Register</title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="register">

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <?php
                if (isset($_POST['email']) && isset($_POST['password'])):
                    echo register($_POST);
                endif;
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center">Register</h2>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" name="fullName" id="fullName" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="username">username</label>
                                <input type="username" name="username" id="username" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" name="phone" id="phone" required class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="role">Speciality</label>
                                <select type="role" name="role" id="role" required class="form-select">
                                    <option value="" selected hidden>Select Speciality</option>
                                    <?php get_categories(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <a class="nav-link" href="login.php">LOGIN</a>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary d-block ms-auto">
                                    REGISTER
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