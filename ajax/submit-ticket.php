<?php
require_once '../core/database.php';

if (isset($_POST['t_title']) && isset($_POST['t_category'])):


    $targetDir = '../attachments/';
    $msg = '';

    $q = $db->query("SELECT `ticket_id` FROM `tickets` ORDER BY `id` DESC LIMIT 1");
    $ticket_id = '';
    if (mysqli_num_rows($q) > 0) {
        $get_last_t_id = mysqli_fetch_object($q);
        $get_last_t_id->ticket_id;
        $a = explode('INS', $get_last_t_id->ticket_id);
        $new_id =  (int)$a[1] + 1;
        $ticket_id = str_pad($new_id, 4, 0, STR_PAD_LEFT);
        $ticket_id = 'INS' . $ticket_id;
    } else {
        $ticket_id = str_pad(1, 4, 0, STR_PAD_LEFT);
        $ticket_id = 'INS' . $ticket_id;
    }

    $title = $_POST['t_title'];
    $desc = mysqli_real_escape_string($db, $_POST['t_desc']);
    $cat_id = $_POST['t_category'];
    $client_id = $_POST['client_id'];
    $subCategory = $_POST['subCat'] ?? '';
    if ($subCategory != '') {
        $subCategory = implode(',', $subCategory);
    }

    if (!empty($_FILES["attachment"]["name"])) {

        $fileName = basename($_FILES["attachment"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp', 'pdf');

        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
                $sub_ticket_Q = $db->query("INSERT INTO `tickets` (ticket_id,ticket_title,ticket_desc,cat_id,sub_cat,status,client_id,attachment,attachment_type) VALUES('$ticket_id','$title','$desc','$cat_id','$subCategory','new','$client_id','$fileName','$fileType')");
                if ($sub_ticket_Q):
                    $msg = json_encode(["status" => "success", "msg" => "Ticket submitted successfully."]);
                else:
                    $msg = json_encode(["status" => "error", "msg" => "Something went wrong."]);
                endif;
            } else {
                $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, there was an error uploading your file.", "status" => "error"]);
            }
        } else {
            $msg = json_encode(["class_" => "d-block alert alert-danger", "msg" => "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed to upload.", "status" => "error"]);
        }
    }

    echo $msg;

endif;
