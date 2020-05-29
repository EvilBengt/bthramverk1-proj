<?php

namespace Anax\View;

?>

<h1><?= $user->getName() ?></h1>

<form method="POST" action="<?= url("users/me") ?>">
    <fieldset>
        <legend>
            Email
        </legend>
        <input type="email" name="email" value="<?= $user->getEmail() ?>">
        <small>Your email address will be used to fetch your profile picture from Gravatar.</small>
    </fieldset>
    <fieldset>
        <legend>
            Display name
        </legend>
        <input type="text" name="displayName" value="<?= $user->getDisplayName() ?>">
        <small>Until you choose a display name, your email address will be used instead.</small>
    </fieldset>
    <fieldset>
        <legend>
            Password
        </legend>
        <input type="password" name="password">
        <small>Leave this blank to keep your current password.</small>
    </fieldset>
    <fieldset>
        <legend>
            Biography
        </legend>
        <textarea name="bio"><?= $user->getBio() ?></textarea>
    </fieldset>

    <button type="submit">Save changes</button>
</form>
