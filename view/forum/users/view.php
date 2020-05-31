<?php

namespace Anax\View;

?>

<h1>
    <img width="40" height="40" src="<?= $user->getImageLink() ?>">
    <?= $user->getName() ?>
    <span class="right">
        <strong title="Reputation">[<?= $user->getRep() ?>]</strong>
    </span>
</h1>

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

<h2>Commented questions</h2>

<ul>
    <?php foreach ($commented as $value) { ?>
    <li><a href="<?= url("questions/view/" . $value["question"]->getID()) . "#c" . $value["comment"]->getID() ?>"><?= $value["question"]->getTitle() ?></a></li>
    <?php }; ?>
</ul>

<h2>Number of votes cast</h2>

<p><?= $user->getVotes() ?></p>

<?php if ($showEditLink) { ?>
<h2><a href="<?= url("users/me") ?>">Edit your information</a></h2>
<?php }; ?>
