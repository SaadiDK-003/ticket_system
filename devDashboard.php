<?php
require_once 'core/database.php';
if ($userRole != 'dev') {
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

<body id="clientDashboard">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="tabs-section">
            <div class="container mt-5 mx-auto">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center mb-5"><?= $userName ?></h2>
                    </div>
                    <div class="col-12">
                        <table id="devTable" class="table table-stripped table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Ticket Title</th>
                                    <th>Ticket Description</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th>Chat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $dev_t_Q = $db->query("CALL `get_dev_tickets`($userID)");
                                while ($dev_t = mysqli_fetch_object($dev_t_Q)):
                                    $status = $dev_t->status;
                                    $attachment_type = $dev_t->attachment_type;
                                ?>
                                    <tr>
                                        <td><?= $dev_t->ticket_title ?></td>
                                        <td><?= $dev_t->ticket_desc ?></td>
                                        <td>
                                            <?php if ($status == 'pending'): ?>
                                                <span class="btn btn-warning">Pending</span>
                                            <?php elseif ($status == 'progress'): ?>
                                                <span class="btn btn-info">Open</span>
                                            <?php else: ?>
                                                <span class="btn btn-success">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($attachment_type != 'pdf'): ?>
                                                <img src="attachments/<?= $dev_t->attachment ?>" alt="attachment" width="60" class="d-block mx-auto">
                                            <?php else: ?>
                                                <a href="attachments/<?= $dev_t->attachment ?>" download class="btn btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($status == 'progress'): ?>
                                                <a href="./conversation-form.php?t_id=<?= $dev_t->ticket_id ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-message"></i> chat
                                                </a>
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="#!" data-id="<?= $dev_t->ticket_id ?>" class="btn btn-primary btn-sm btn-change-status" data-bs-toggle="modal" data-bs-target="#setStatus"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="setStatus" tabindex="-1" aria-labelledby="setStatusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <form id="dev-status-form" class="w-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="setStatusLabel">Change the status.</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="showDevMsg"></span>
                        <div class="form-group">
                            <label for="dev-status" class="form-label">Select Status</label>
                            <select name="dev_status" id="dev-status" class="form-select" required>
                                <option value="" selected hidden>Select Status...</option>
                                <option value="pending">Pending</option>
                                <option value="progress">Open</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ticket_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>
    <script>
        $(document).ready(function() {
            new DataTable("#devTable");
            $(document).on("click", ".btn-change-status", function(e) {
                e.preventDefault();
                let ticket_id = $(this).data('id');
                $("input[name='ticket_id']").val(ticket_id);
            });

            $(document).on("submit", "#dev-status-form", function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "ajax/dev.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status == 'success') {
                            $("#showDevMsg").html(res.msg);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1200);
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>