<?php
require_once '../core/database.php';

if (isset($_POST['t_title']) && isset($_POST['t_category'])):

    $title = $_POST['t_title'];
    $desc = mysqli_real_escape_string($db, $_POST['t_desc']);
    $cat_id = $_POST['t_category'];
    $client_id = $_POST['client_id'];
    $subCat = '';
    $subCategory = $_POST['subCat'];
    $subCat = implode(',', $subCategory);

    $sub_ticket_Q = $db->query("INSERT INTO `tickets` (ticket_title,ticket_desc,cat_id,sub_cat,status,client_id) VALUES('$title','$desc','$cat_id','$subCat','pending','$client_id')");
    if ($sub_ticket_Q):
        echo json_encode(["status" => "success", "msg" => "Ticket submitted successfully."]);
    else:
        echo json_encode(["status" => "error", "msg" => "Something went wrong."]);
    endif;
endif;
