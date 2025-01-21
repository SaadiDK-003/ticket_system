<?php
require_once '../core/database.php';

if (isset($_POST['message']) && isset($_POST['ticket_id']) && isset($_POST['sender_id'])):
    $msg = mysqli_real_escape_string($db, $_POST['message']);
    $t_id = $_POST['ticket_id'];
    $s_id = $_POST['sender_id'];
    $s_role = $_POST['sender_role'];

    $ins_Q = $db->query("INSERT INTO `ticket_conversation` (messages,ticket_id,sender_id,sender_status) VALUES('$msg','$t_id','$s_id','$s_role')");
    if ($ins_Q) {
        echo json_encode(["status" => "success", "msg" => "Message sent successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }

endif;


if (isset($_POST['close_ticket'])):
    $ctID = $_POST['close_ticket'];
    $msg = '';
    $upd_Q = $db->query("UPDATE `tickets` SET `status`='closed' WHERE `id`='$ctID'");
    if ($upd_Q):
        $msg = json_encode(["status" => "success", "msg" => "Ticket has been closed."]);
    else:
        $msg = json_encode(["status" => "error", "msg" => "Something went wrong!"]);
    endif;
    echo $msg;
endif;
