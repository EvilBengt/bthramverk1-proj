<?php

namespace Anax\View;

?>

<h1>Welcome to FunFunFun!</h1>

<h2>Latest questions</h2>
<ul>
    <?php foreach ($latestQuestions as $q) { ?>
    <li><a href="<?= url("questions/view/" . $q->getID()) ?>"><?= $q->getTitle() ?></a></li>
    <?php }; ?>
</ul>

<h2>Hottest tags</h2>
<ul>
    <?php foreach ($hottestTags as $t) { ?>
    <li><a href="<?= url("questions?tag=" . \urlencode($t->getName())) ?>">(<?= $t->getFrequency() ?>) <?= $t->getName() ?></a></li>
    <?php }; ?>
</ul>
