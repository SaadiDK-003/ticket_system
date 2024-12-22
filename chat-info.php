<?php
require_once 'core/database.php';
$t_id = $_GET['t_id'];
?>
<div class="chat-wrapper">
    <?php
    $msg_Q = $db->query("CALL `get_chat_by_ticket_id`($t_id)");
    while ($msgs = mysqli_fetch_object($msg_Q)):
    ?>
        <div class="<?= $msgs->sender_status ?>">
            <span><?= $msgs->fullname ?></span>
            <h6><?= $msgs->messages ?></h6>
        </div>
    <?php endwhile; ?>
</div>