<?php

namespace Anax\View;

?>

<h1><?= $user->getName() ?></h1>

<p>
    <?= $user->getBio(true) ?>
</p>

<h2>Asked questions</h2>

<ul>
    <?php foreach ($asked as $q) { ?>
    <li><a href="<?= url("questions/view/" . $q->getID()) ?>"><?= $q->getTitle() ?></a></li>
    <?php }; ?>
</ul>

<h2>Answered questions</h2>

<ul>
    <?php foreach ($answers as $a) { ?>
    <li><a href="<?= url("questions/view/" . $answered[$a->getQuestionID()]->getID()) . "#a" . $a->getID() ?>"><?= $answered[$a->getQuestionID()]->getTitle() ?></a></li>
    <?php }; ?>
</ul>
