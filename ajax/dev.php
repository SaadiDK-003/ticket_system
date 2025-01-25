<?php
require_once '../core/database.php';

if (isset($_POST['dev_status']) && isset($_POST['ticket_id'])):
    $dev_status = $_POST['dev_status'];
    $t_id = $_POST['ticket_id'];

    $upd_t_Q = $db->query("UPDATE `tickets` SET `status`='$dev_status' WHERE `id`='$t_id'");
    if ($upd_t_Q) {
        echo json_encode(["status" => "success", "msg" => "<h6 class='alert alert-success'>Status Updated Successfully.</h6>"]);
    } else {
        echo json_encode(["status" => "error", "" => "<h6 class='alert alert-danger'>Something went wrong.</h6>"]);
    }
endif;
