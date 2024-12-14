<?php
require_once 'core/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="home">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="hero">
            <div class="container mx-auto">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                        <div class="content">
                            <h1 class="text-white fw-bold"><?= TITLE ?></h1>
                            <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, nisi illo quam repellendus quo incidunt. At eligendi rem delectus doloremque repellendus porro, totam quam labore alias omnis fuga, repellat quo.</p>
                            <div class="d-flex align-items-center gap-3 buttons">
                                <a class="btn btn-primary" href="#!">Button 1</a>
                                <a class="btn btn-secondary" href="#!">Button 2</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="meal-plan-img">
                            <img src="https://dummyimage.com/636x300/ddd/000" alt="meal-plan">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
</body>

</html>