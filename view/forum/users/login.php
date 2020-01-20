<?php

namespace Anax\View;

?>

<h1>Log in</h1>
<form method="POST" action="<?= url("users/login") ?>">
    <input type="text" name="username" placeholder="Username" value="<?= $username ?>" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Log in</button>
    <?php if ($error) { ?>
    <p><?= $error ?></p>
    <?php }; ?>
</form>
