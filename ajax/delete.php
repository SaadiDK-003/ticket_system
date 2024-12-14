<?php
require_once '../core/database.php';

if (isset($_POST['del_id']) && isset($_POST['del_table'])):
    $id = $_POST['del_id'];
    $table = $_POST['del_table'];
    delete($id, $table);
endif;
