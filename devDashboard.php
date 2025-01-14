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
                        <table id="devTable" class="table table-stripped table-bordered text-center align-middle">
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
                                                <span class="btn btn-info">Progress</span>
                                            <?php else: ?>
                                                <span class="btn btn-secondary">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($attachment_type != 'pdf'): ?>
                                                <img src="attachments/<?= $dev_t->attachment ?>" alt="attachment" width="100" class="d-block mx-auto">
                                            <?php else: ?>
                                                <a href="attachments/<?= $dev_t->attachment ?>" download class="btn btn-primary">Download</a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($status == 'pending'): ?>
                                                <a href="#!" data-id="<?= $dev_t->ticket_id ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <?php else: ?>
                                                <a href="./conversation-form.php?t_id=<?= $dev_t->ticket_id ?>" class="btn btn-primary btn-sm">
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
        new DataTable("#devTable");
    </script>
</body>

</html>