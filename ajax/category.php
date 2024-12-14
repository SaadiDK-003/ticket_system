<?php
require_once '../core/database.php';

if (isset($_POST['category_name'])):
    echo add_category($_POST);
endif;
