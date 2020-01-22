<?php

namespace Anax\View;

?>

<h1>Ask a question</h1>

<form method="POST" action="<?= url("questions/ask") ?>">
    <input type="text" name="title" placeholder="Title">
    <ul class="tag-select">
        <li class="tag-option">
            <input type="checkbox">
            F#
        </li>
        <li class="tag-option">
            <input type="checkbox">
            Elm
        </li>
        <li class="tag-option">
            <input type="checkbox">
            Haskell
        </li>
    </ul>
    <textarea name="body" placeholder="Question body"></textarea>
    <button type="submit">Submit</button>
</form>
