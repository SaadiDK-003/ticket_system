<?php
require_once '../core/database.php';

if (isset($_POST['dev']) && isset($_POST['ticket_id'])):
    $dev = $_POST['dev'];
    $t_id = $_POST['ticket_id'];

    $upd_t_Q = $db->query("UPDATE `tickets` SET `dev_id`='$dev', `status`='pending' WHERE `id`='$t_id'");
    if ($upd_t_Q) {
        echo json_encode(["status" => "success", "msg" => "<h6 class='alert alert-success'>Dev Assigned Successfully.</h6>"]);
    } else {
        echo json_encode(["status" => "error", "" => "<h6 class='alert alert-danger'>Something went wrong.</h6>"]);
    }
endif;
