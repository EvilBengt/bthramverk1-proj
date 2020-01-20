<?php

namespace Anax\View;

?>

<h1>Log in</h1>
<form method="POST" action="<?= url("users/login") ?>">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Log in</button>
</form>
