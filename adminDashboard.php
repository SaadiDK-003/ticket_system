<?php
require_once 'core/database.php';
if ($userRole != 'admin') {
    header('Location: index.php');
}
$token_Q = $db->query("SELECT `reg_token` FROM `token`");
$token = mysqli_fetch_object($token_Q);
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

<body id="adminDashboard">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="tabs-container">
            <div class="container mt-5 mx-auto">
                <div class="row">
                    <div id="tabs-buttons" class="col-12 d-flex align-items-center justify-content-center gap-5">
                        <a href="#!" class="btn btn-success w-15">Add Client</a>
                        <a href="#!" class="btn btn-primary w-15">Add Categories</a>
                        <a href="<?= SITE_URL ?>/register.php?token=<?= $token->reg_token ?>" class="btn btn-secondary"><i class="fas fa-user-plus"></i></a>
                    </div>
                </div>
            </div>
            <div id="tabs-content" class="container">
                <!-- Add Client -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="text-center">Add Client</h2>
                    </div>
                </div>
                <!-- Add Categories -->
                <div class="row mt-5 d-none">
                    <div class="col-12">
                        <h2 class="text-center">Add Category</h2>
                    </div>
                    <div class="col-3 mx-auto">
                        <form id="category_form">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="category-name">Category Name</label>
                                        <input type="text" name="category_name" id="category-name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3 d-flex justify-content-end">
                                    <button type="submit" name="cat_submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 mx-auto">
                                <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $get_Cat = $db->query("CALL `get_all_categories`()");
                                        while ($cat = mysqli_fetch_object($get_Cat)):
                                        ?>
                                            <tr>
                                                <td><?= $cat->id ?></td>
                                                <td><?= $cat->category_name ?></td>
                                                <td><?= $cat->status ?></td>
                                                <td><a href="#!" class="btn btn-sm btn-danger btn-cat-del" data-id="<?= $cat->id ?>" data-table="categories"><i class="fas fa-trash"></i></a></td>
                                            </tr>
                                        <?php endwhile;
                                        $get_Cat->close();
                                        $db->next_result(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <!-- Toast Success -->
        <div id="ToastSuccess" class="toast toast-success align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Category has been Added Successfully.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <!-- Toast Danger -->
        <div id="ToastDanger" class="toast toast-danger align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Category has been Added Successfully.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            new DataTable('#example', {
                ordering: false,
            });

            // Tabs Selection
            $(document).on('click', '#tabs-buttons a:not(:last-child)', function(e) {
                e.preventDefault();
                let index = $(this).index() + 1;
                $(this).addClass('active').siblings().removeClass('active');
                $(`#tabs-content > div:nth-child(${index})`).removeClass('d-none').siblings().addClass('d-none');
            });

            // Add Category
            $("#category_form").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/category.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#ToastSuccess .toast-body").html(res.msg);
                        toastSuccess.show();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                });
            });

            // Del Category
            $(document).on("click", ".btn-cat-del", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let table = $(this).data('table');

                $.ajax({
                    url: "ajax/delete.php",
                    method: "post",
                    data: {
                        del_id: id,
                        del_table: table
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#ToastDanger .toast-body").html(res.msg);
                        toastDanger.show();
                    }
                });
            });

            // Copy Reg link
            $(document).on('click', '#tabs-buttons a:last-child', function(e) {
                e.preventDefault();
                let href = $(this).attr('href');
                // Copy href to clipboard
                navigator.clipboard.writeText(href).then(
                    () => {
                        $("#ToastSuccess .toast-body").html('Registration link copied.');
                        toastSuccess.show();
                    },
                    (err) => {
                        console.error('Could not copy text: ', err);
                    }
                );
            });
        });
    </script>
</body>

</html>