<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Message.php';

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
} else {
    header('Location: login-register.php');
}

$sentMessages = Message::loadSentMessagesByUser($conn, $_SESSION['user']);
$receivedMessages = Message::loadReceivedMessagesByUser($conn, $_SESSION['user']);

require_once 'templates/header.php';

?>



<div class="container main-content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Messages</h1>
            <p>
                <a href="messages.php">&laquo; Back to list</a>
            </p>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#received" role="tab">Received</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#sent" role="tab">Sent</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="received" role="tabpanel">
                    <?php foreach ($receivedMessages as $receivedMessage):
                        $sender = User::loadUserById($conn, $receivedMessage->getSenderId());
                        $date = date("F j, Y", $receivedMessage->getCreationDate())
                    ?>
                    <div class="tweet">
                        <p class="tweet-details"><strong><?php echo $date ?></strong> from <strong><a href="profile.php?id=<?php echo $sender->getId() ?>"><?php echo $sender->getUsername() ?></a></strong>  <?php if(!$receivedMessage->isRead()): ?><span class="badge badge-danger">NEW</span><?php endif;?></p>
                        <p class="tweet-content"><a href="message.php?id=<?php echo $receivedMessage->getId() ?>"><?php echo $receivedMessage->getMessage() ?></a></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane" id="sent" role="tabpanel">
                    <?php foreach ($sentMessages as $sentMessage):
                        $recipient = User::loadUserById($conn, $sentMessage->getRecipientId());
                        $date = date("F j, Y", $sentMessage->getCreationDate())
                        ?>
                        <div class="tweet">
                            <p class="tweet-details"><strong><?php echo $date ?></strong> to <strong><a href="profile.php?id=<?php echo $recipient->getId() ?>"><?php echo $recipient->getUsername() ?></a></strong></p>
                            <p class="tweet-content"><a href="message.php?id=<?php echo $sentMessage->getId() ?>"><?php echo $sentMessage->getMessage() ?></a></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php

require_once 'templates/footer.php';