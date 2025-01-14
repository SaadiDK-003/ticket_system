<?php
require_once 'core/database.php';

if ($userRole != 'admin'):
    header('Location: index.php');
endif;
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

<body id="adminTickets">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="mt-5">
            <div class="container">
                <!-- Pending Tickets -->
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center mb-4">All Pending Tickets</h1>
                    </div>
                    <div class="col-12">
                        <table id="tickets" class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Ticket Title</th>
                                    <th>Ticket Description</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th>Assign To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tickets_Q = $db->query("CALL `get_all_tickets_pending`()");
                                while ($tickets = mysqli_fetch_object($tickets_Q)):
                                    $status = $tickets->status;
                                    $attachment_type = $tickets->attachment_type;
                                ?>
                                    <tr>
                                        <td><?= $tickets->ticket_title ?></td>
                                        <td><?= $tickets->ticket_desc ?></td>
                                        <td>
                                            <?php if ($status == 'pending'): ?>
                                                <span class="btn btn-warning">Pending</span>
                                            <?php elseif ($status == 'progress'): ?>
                                                <span class="btn btn-info">Progress</span>
                                            <?php else: ?>
                                                <span class="btn btn-secondary">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($attachment_type != 'pdf'): ?>
                                                <img src="attachments/<?= $tickets->attachment ?>" alt="attachment" width="50" height="50" class="d-block mx-auto">
                                            <?php else: ?>
                                                <a href="attachments/<?= $tickets->attachment ?>" download class="btn btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="#!" data-id="<?= $tickets->ticket_id ?>" class="btn btn-primary btn-sm btn-dev" data-bs-toggle="modal" data-bs-target="#assignTicket"><i class="fas fa-user-gear"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile;
                                $tickets_Q->close();
                                $db->next_result();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Progress Tickets -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h1 class="text-center mb-4">All Progress Tickets</h1>
                    </div>
                    <div class="col-12">
                        <table id="tickets-1" class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Ticket Title</th>
                                    <th>Ticket Description</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th>Assign To</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tickets_Q = $db->query("CALL `get_all_tickets_not_pending`()");
                                while ($tickets = mysqli_fetch_object($tickets_Q)):
                                    $status = $tickets->status;
                                    $attachment_type = $tickets->attachment_type;
                                ?>
                                    <tr>
                                        <td><?= $tickets->ticket_title ?></td>
                                        <td><?= $tickets->ticket_desc ?></td>
                                        <td>
                                            <?php if ($status == 'pending'): ?>
                                                <span class="btn btn-warning">Pending</span>
                                            <?php elseif ($status == 'progress'): ?>
                                                <span class="btn btn-info">Progress</span>
                                            <?php else: ?>
                                                <span class="btn btn-secondary">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($attachment_type != 'pdf'): ?>
                                                <img src="attachments/<?= $tickets->attachment ?>" alt="attachment" width="50" height="50" class="d-block mx-auto">
                                            <?php else: ?>
                                                <a href="attachments/<?= $tickets->attachment ?>" download class="btn btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="btn btn-primary"><?= $tickets->fullname ?></span>
                                        </td>
                                    </tr>
                                <?php endwhile;
                                $tickets_Q->close();
                                $db->next_result();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="assignTicket" tabindex="-1" aria-labelledby="assignTicketLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <form id="assign-dev-form" class="w-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="assignTicketLabel">Assign to Developer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="showDevMsg"></span>
                        <div class="form-group">
                            <label for="developer">Developer</label>
                            <select name="dev" id="dev" class="form-select" required>
                                <option value="" selected hidden>Select Dev</option>
                                <?= get_devs(); ?>
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
            new DataTable('#tickets, #tickets-1', {
                ordering: false,
            });

            $(document).on("click", ".btn-dev", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("input[name='ticket_id']").val(id);
            });

            $("#assign-dev-form").on("submit", function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "ajax/admin.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#showDevMsg").html(res.msg);
                        if (res.status == 'success') {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1200);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>