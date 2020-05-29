<?php

namespace Anax\View;

?>

<h1>Question overview</h1>

<a class="call-to-action" href="questions/ask">Ask a question!</a>

<ul>
    <?php foreach ($questions as $q) { ?>
    <li>
        <a href="<?= url("questions/view/" . $q->getID()) ?>">
            <span class="li-title"><?= $q->getTitle() ?></span>
        </a>
    </li>
    <?php }; ?>
</ul>

<?php if (\count($questions) > 10) { ?>
<a class="call-to-action" href="questions/ask">Ask a question!</a>
<?php }; ?>