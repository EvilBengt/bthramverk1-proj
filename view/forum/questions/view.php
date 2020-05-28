<?php

namespace Anax\View;

?>

<h1><?= $question->getTitle() ?></h1>
<ul class="question-tag-list">
    <?php foreach ($question->getTags() as $t) { ?>
    <li class="question-tag"><a href="<?= url("questions?tag=" . \urlencode($t->getName())) ?>"><?= $t->getName() ?></a></li>
    <?php }; ?>
</ul>

<div class="question-body">
    <?= $question->getBody() ?>
</div>
<a class="question-author" href="<?= url("users/view/" . $question->getAuthor()->getID()) ?>"><?= $question->getAuthor()->getUsername() ?></a>
<ul class="comments">
    <?php foreach ($question->getComments() as $c) { ?>
    <li class="comment">
        <p class="comment-body"><?= $c->getBody() ?></p>
        <a class="comment-author" href="<?= url("users/view/" . $c->getAuthor()->getID()) ?>"><?= $c->getAuthor()->getUsername() ?></a>
    </li>
    <?php }; ?>
</ul>

<h2>Answers</h2>
<ul class="answers">
    <?php foreach ($question->getAnswers() as $a) { ?>
    <li class="answer">
        <p class="answer-body"><?= $a->getBody() ?></p>
        <a class="answer-author" href="<?= url("users/view/" . $a->getAuthor()->getID()) ?>"><?= $a->getAuthor()->getUsername() ?></a>
        <ul class="comments">
            <?php foreach ($a->getComments() as $c) { ?>
            <li class="comment">
                <p class="comment-body"><?= $c->getBody() ?></p>
                <a class="comment-author" href="<?= url("users/view/" . $c->getAuthor()->getID()) ?>"><?= $c->getauthor()->getUsername() ?></a>
            </li>
            <?php }; ?>
        </ul>
    </li>
    <?php }; ?>
</ul>
