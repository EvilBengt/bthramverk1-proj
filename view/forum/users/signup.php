<?php

namespace Anax\View;

?>

<h1>Sign up</h1>
<form action="<?= url("users/signup") ?>" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">
        Sign up!
    </button>
    <?php if ($error) { ?>
    <p><?= $error ?></p>
    <?php }; ?>
</form>
