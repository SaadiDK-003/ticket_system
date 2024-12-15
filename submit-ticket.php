<?php
require_once 'core/database.php';
if (!isLoggedin() || $userRole != 'client') {
    header('Location: index.php');
}
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

<body id="submitTickets">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="ticket-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mt-5 mb-3">Submit A Ticket</h1>
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <form id="ticket-submit">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="t_title" class="form-label">Subject</label>
                                        <input type="text" name="t_title" id="t_title" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="t_category" class="form-label">Category</label>
                                        <select name="t_category" id="t_category" class="form-select" required>
                                            <option value="" selected hidden>Select Category</option>
                                            <?php get_categories(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="t_desc" class="form-label">Ticket Description</label>
                                        <textarea name="t_desc" id="t_desc" placeholder="Ticket Description here..." class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3 d-flex justify-content-end">
                                        <input type="hidden" name="client_id" value="<?= $userID ?>">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            $(document).on("submit", "#ticket-submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: "ajax/submit-ticket.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#ToastSuccess .toast-body").html(res.msg);
                        toastSuccess.show();
                    }
                })

            });
        });
    </script>
</body>

</html>