<?php

namespace Anax\View;

?>

<h1>Ask a question</h1>

<form method="POST" action="<?= url("questions/ask") ?>">
    <input type="text" name="title" placeholder="Title" required>
    <fieldset class="form-tag-list">
        <legend>Tags</legend>
        <?php foreach ($tags as $t) { ?>
        <label class="form-tag">
            <input type="checkbox" name="tags[]" value="<?= $t->id ?>">
            <span class="form-tag-label"><?= $t->name ?></span>
            <br>
        </label>
        <?php }; ?>
    </fieldset>
    <textarea name="body" placeholder="Question body" required></textarea>
    <button type="submit">Submit</button>
</form>
