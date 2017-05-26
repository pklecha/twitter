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


require_once 'templates/header.php';

?>

<div class="container">
    <div class="row">

    </div>
</div>

<?php

require_once 'templates/footer.php';