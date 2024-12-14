<?php

define('HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'ticket_system');
define('DIR_PATH', __DIR__);
define('FILE_PATH', __FILE__);
define('TITLE', 'Ticket System');
define('FOLDER', 'ticket_system');
define('FOOTER_TEXT', ' Ticket System. All rights Reserved.');


date_default_timezone_set('Asia/Karachi');

$host = $_SERVER['HTTP_HOST'];
define('SITE_URL', ($host == 'localhost') ? 'http://' . $host . '/' . FOLDER : 'https://' . $host . '/' . FOLDER);
