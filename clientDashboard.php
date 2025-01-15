<?php
require_once 'core/database.php';
if ($userRole != 'client') {
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
                        <h1 class="text-center">Submitted Ticket</h1>
                    </div>
                    <div class="col-12">
                        <table id="tickets" class="table table-striped table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Ticket Title</th>
                                    <th>Ticket Description</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $client_t_Q = $db->query("CALL `get_client_tickets`($userID)");
                                while ($client_t = mysqli_fetch_object($client_t_Q)):
                                    $status = $client_t->status;
                                    $attachment_type = $client_t->attachment_type;
                                ?>
                                    <tr>
                                        <td><?= $client_t->ticket_title ?></td>
                                        <td><?= $client_t->ticket_desc ?></td>
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
                                                <img src="attachments/<?= $client_t->attachment ?>" alt="attachment" width="60" class="d-block mx-auto">
                                            <?php else: ?>
                                                <a href="attachments/<?= $client_t->attachment ?>" download class="btn btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($status == 'pending'): ?>
                                                <a href="#!" data-id="<?= $client_t->ticket_id ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <?php else: ?>
                                                <a href="./conversation-form.php?t_id=<?= $client_t->ticket_id ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-message"></i> chat
                                                </a>
                                            <?php endif; ?>
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

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            new DataTable('#tickets', {
                ordering: false
            });
        });
    </script>
</body>

</html>