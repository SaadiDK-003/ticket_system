<?php

require_once '../core/database.php';



if (isset($_POST['search_client']) && isset($_POST['ticket_status'])):

    $client = $_POST['search_client'];
    $status = $_POST['ticket_status'];

    $get_t_Q = $db->query("SELECT * FROM `tickets` WHERE `client_id`='$client' AND `status`='$status'");

    if (mysqli_num_rows($get_t_Q) > 0):
        while ($ticket = mysqli_fetch_object($get_t_Q)): ?>
            <tr>
                <td><?= $ticket->ticket_id ?></td>
                <td><?= $ticket->ticket_title ?></td>
                <td><?= $ticket->ticket_desc ?></td>
                <td><?php
                    if ($ticket->attachment_type != 'pdf'):
                        echo '<img src="attachments/' . $ticket->attachment . '" alt="attachment" width="60" class="d-block mx-auto">';
                    else:
                        echo '<a href="attachments/' . $ticket->attachment . '" download class="btn btn-primary">Download</a>';
                    endif;
                    ?></td>
                <td><?= ($ticket->status == 'progress') ? '<span class="btn btn-info">Open</span>' : '<span class="btn btn-secondary">Closed</span>' ?></td>
            </tr>
<?php endwhile;
    else:
        echo '<tr><td colspan="5" class="dt-empty">No record found!</td></tr>';
    endif;

endif;
