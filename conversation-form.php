<?php
require_once 'core/database.php';

if (!isLoggedin()):
    header('Location: login.php');
endif;
if (!isset($_GET['t_id'])):
    header('Location: index.php');
endif;
$t_id = '';
$t_id = $_GET['t_id'];
if ($userRole == 'dev'):
    $u = 'dev_id';
else:
    $u = 'client_id';
endif;

$check_user = $db->query("SELECT $u FROM `tickets` WHERE `id`='$t_id'");
$cUser = mysqli_fetch_object($check_user);
if ($cUser->$u != $userID) {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <?php include 'includes/external_css.php'; ?>
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body id="conversationFormPage">
    <?php include_once 'includes/header.php'; ?>

    <main>
        <section class="mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-4">
                        <h1 class="text-center">Conversation</h1>
                    </div>
                    <div class="col-8 mx-auto mb-3">
                        <div id="chat-refresh">
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
                        </div>
                    </div>
                    <div class="col-8 mx-auto">
                        <form id="con-form">
                            <div class="form-group mb-3">
                                <label for="message" class="form-label">message</label>
                                <textarea name="message" id="message" placeholder="Enter your message." class="form-control"></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <input type="hidden" name="ticket_id" value="<?= $t_id ?>">
                                <input type="hidden" name="sender_id" value="<?= $userID ?>">
                                <input type="hidden" name="sender_role" value="<?= $userRole ?>">
                                <button type="submit" name="con_submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    <?php include 'includes/external_js.php'; ?>

    <script>
        $(document).ready(function() {
            $("#con-form").on("submit", function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "ajax/conversation-submit.php",
                    method: "post",
                    data: formData,
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#showDevMsg").html(res.msg);
                        if (res.status == 'success') {
                            window.location.reload();
                        }
                    }
                });
            });

            let chatRefreshInterval;

            function startChatRefresh() {
                chatRefreshInterval = setInterval(() => {
                    $("#chat-refresh").load('chat-info.php?t_id=<?= $t_id ?>');
                }, 1000);
            }

            function stopChatRefresh() {
                clearInterval(chatRefreshInterval);
            }

            $("#chat-refresh").on("click", () => {
                stopChatRefresh();
            });
            $("#chat-refresh").on("scroll", () => {
                stopChatRefresh();
            });

            // Restart refresh when clicking outside of #chat-refresh
            $(document).on("click", (e) => {
                if (!$(e.target).closest("#chat-refresh").length) {
                    startChatRefresh();
                    $('#chat-refresh').scrollTop(0);
                }
            });

            startChatRefresh();



        });
    </script>
</body>

</html>