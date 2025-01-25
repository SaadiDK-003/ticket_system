<?php
require_once 'core/database.php';
if (!isLoggedin() || $userRole != 'admin') {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Filter By Client</title>
    <?php include_once 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body>
    <?php include_once 'includes/header.php'; ?>
    <main>
        <div class="container mx-auto my-4">
            <div class="row">
                <div class="col-12 col-md-7 d-flex align-items-center">
                    <h2>Tickets Status</h2>
                    <span class="show-error-msg mb-0 ms-2 text-center w-50"></span>
                </div>
                <div class="col-12 col-md-5">
                    <form id="search-filter">
                        <div class="row">
                            <div class="col-12 col-md-5 mb-3 mb-md-0">
                                <div class="form-group">
                                    <label for="search-client" class="form-label">Client Name</label>
                                    <select name="search_client" id="search-client" class="form-select" required>
                                        <option value="" selected hidden>Select Client</option>
                                        <?= get_client(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 mb-3 mb-md-0">
                                <div class="form-group">
                                    <label for="ticket-status" class="form-label">Status</label>
                                    <select name="ticket_status" id="ticket-status" class="form-select" required>
                                        <option value="" selected hidden>Select Status</option>
                                        <option value="progress">Open</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="submit" name="submit-filter" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- TABLE -->
            <div class="row mt-5">
                <div class="col-12">
                    <table id="filter-table" class="table table-bordered table-striped table-responsive text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>title</th>
                                <th>desc</th>
                                <th>attachment</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody id="fetch_result">
                            <tr>
                                <td colspan="5" class="dt-empty">No record found!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once 'includes/footer.php'; ?>


    <?php include_once 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            $("#search-filter").on("submit", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "ajax/filter-search.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        if (response.length > 0) {
                            $(".show-error-msg").html('').removeClass('alert alert-danger');
                            $("#fetch_result").html(response);
                            new DataTable("#filter-table");
                        } else {
                            $(".show-error-msg").html('No record found!').addClass('alert alert-danger');
                            setTimeout(() => {
                                $(".show-error-msg").html('').removeClass('alert alert-danger');
                            }, 1000);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>