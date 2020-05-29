<?php

namespace Anax\View;

?>

<h1>Tag overview</h1>

<form method="POST" action="<?= url("tags/create") ?>">
    <input type="text" name="name" required>
    <button type="submit">Create new tag</button>
</form>

<ul>
    <?php foreach ($tags as $t) { ?>
    <li>
        <a title="Click to browse all questions tagged '<?= $t->getName() ?>'" href="<?= url("questions?tag=" . \urlencode($t->getName())) ?>">
            <span class="li-title"><?= $t->getName() ?></span>
        </a>
    </li>
    <?php }; ?>
</ul>
