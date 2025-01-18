<header>
    <div class="container mx-auto">
        <div class="row">
            <div class="col-6 col-md-2 d-flex align-items-center justify-content-start justify-content-md-center">
                <div class="logo">
                    <h3 class="text-white mb-0">LOGO</h3>
                </div>
            </div>
            <div class="col-8 d-none d-md-flex align-items-center justify-content-center">
                <ul class="nav d-flex gap-5">
                    <li>
                        <a class="fs-4" href="index.php">Home</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">About</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-2 d-none d-md-flex align-items-center justify-content-center">
                <div class="nav-buttons d-flex align-items-center gap-3">
                    <?php if (isLoggedin()): ?>
                        <?php if ($userRole == 'admin'): ?>
                            <a href="./adminDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php elseif ($userRole == 'dev'): ?>
                            <a href="./devDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php else: ?>
                            <a href="./clientDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- MOBILE NAV WORK START -->
            <div class="col-6 d-flex justify-content-end d-md-none">
                <a href="#!" id="open-mobile-nav" class="btn btn-primary">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
            <div class="position-fixed d-block d-md-none bg-white top-0 start-0 h-100 mobile-nav-container">
                <a href="#!" id="close-mobile-nav" class="position-absolute text-black fs-2">
                    <i class="fas fa-times"></i>
                </a>
                <ul class="nav mobile d-flex flex-column my-5 px-2 gap-5">
                    <li>
                        <a class="fs-4" href="index.php">Home</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">About</a>
                    </li>
                    <li>
                        <a class="fs-4" href="#!">Contact</a>
                    </li>
                </ul>
                <div class="nav-buttons d-flex align-items-center gap-3">
                    <?php if (isLoggedin()): ?>
                        <?php if ($userRole == 'admin'): ?>
                            <a href="./adminDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php elseif ($userRole == 'dev'): ?>
                            <a href="./devDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php else: ?>
                            <a href="./clientDashboard.php" class="btn btn-primary">Dashboard</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- MOBILE NAV WORK END -->
        </div>
    </div>
</header>