<?php
require_once 'core/database.php';
$activate_user_by_mail_check = $_GET['mail'] ?? '';

if (isLoggedin() || $activate_user_by_mail_check == '') {
    header('Location: index.php');
}

$upd_user = false;

if (checkEmail($activate_user_by_mail_check)) {
    $upd_user = $db->query("UPDATE `users` SET `status`='1' WHERE `email`='$activate_user_by_mail_check'");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> - Activate Account</title>
    <?php include_once 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body>
    <?php include_once 'includes/header.php'; ?>
    <main class="d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto">
                    <?php if ($upd_user): ?>
                        <div class="row">
                            <div class="col-12 text-center my-3">
                                <h3 class="alert alert-success">Your Account has been activated.</h3>
                            </div>
                            <div class="col-12 text-center">
                                <h4 class="btn btn-success">Redirecting to Login Page...</h4>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-12 text-center my-3">
                                <h3 class="alert alert-danger">Sorry, This Email is not exists in our database.</h3>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include_once 'includes/footer.php'; ?>
    <?php include_once 'includes/external_js.php'; ?>
    <?php if ($upd_user): ?>
        <script>
            $(document).ready(function() {
                setTimeout(() => {
                    window.location.href = './login.php';
                }, 2000);
            });
        </script>
    <?php endif; ?>
</body>

</html>