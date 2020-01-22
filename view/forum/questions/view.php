<?php

namespace Anax\View;

?>

<h1><?= $question->title ?></h1>

<h2>Question:</h2>
<div class="question-body">
    <?= $question->body ?>
</div>
<a class="question-author" href="<?= url("users/view/" . $question->authorObject->id) ?>"><?= $question->authorObject->username ?></a>
<ul class="comments">
    <?php foreach ($question->comments as $c) { ?>
    <li class="comment">
        <p class="comment-body"><?= $c->body ?></p>
        <a class="comment-author" href="<?= url("users/view/" . $question->authorObject->id) ?>"><?= $question->authorObject->username ?></a>
    </li>
    <?php }; ?>
</ul>

<h2>Answers:</h2>
<ul class="answers">
    <?php foreach ($question->answers as $a) { ?>
    <li class="answer">
        <p class="answer-body"><?= $a->body ?></p>
        <ul class="comments">
            <?php foreach ($a->comments as $c) { ?>
            <li class="comment">
                <p class="comment-body"><?= $c->body ?></p>
                <a class="comment-author" href="<?= url("users/view/" . $question->authorObject->id) ?>"><?= $question->authorObject->username ?></a>
            </li>
            <?php }; ?>
        </ul>
        <a class="answer-author" href="<?= url("users/view/" . $question->authorObject->id) ?>"><?= $question->authorObject->username ?></a>
    </li>
    <?php }; ?>
</ul>
