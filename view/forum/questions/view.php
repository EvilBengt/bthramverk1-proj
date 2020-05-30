<?php

namespace Anax\View;

?>

<h1>
    <em>Question by</em>
    <a class="author question-author" href="<?= url("users/view/" . $question->getAuthor()->getID()) ?>">
        <img class="author-img" src="<?= $question->getAuthor()->getImageLink() ?>" alt="The user's profile picture">
        <span class="author-name"><?= $question->getAuthor()->getName() ?></span>
    </a>
    <br>
    &gt;
    <?= $question->getTitle() ?>
    <strong class="right">[<?= $question->getRating() ?>]</strong>
</h1>

<form class="right" action="<?= url("vote/question/" . $question->getID()) ?>" method="POST">
    <button type="submit" name="vote" value="up">+</button>
    <button type="submit" name="vote" value="down">-</button>
</form>

<ul class="question-tag-list">
    <?php foreach ($question->getTags() as $t) { ?>
    <li class="question-tag">
        <a title="Click to browse all questions tagged '<?= $t->getName() ?>'" href="<?= url("questions?tag=" . \urlencode($t->getName())) ?>"><?= $t->getName() ?></a>
    </li>
    <?php }; ?>
    <?php if (empty($question->getTags())) { ?>
        <li class="question-tag">[No tags]</li>
    <?php }; ?>
</ul>

<div class="question-body">
    <?= $question->getBody() ?>
</div>
<ul class="comments">
    <?php foreach ($question->getComments() as $c) { ?>
    <li class="comment" id="c<?= $c->getID() ?>">
        <div>
            <a class="author comment-author" href="<?= url("users/view/" . $c->getAuthor()->getID()) ?>">
                <img class="author-img" src="<?= $c->getAuthor()->getImageLink(20) ?>" alt="The user's profile picture">
                <span class="author-name"><?= $c->getAuthor()->getName() ?></span>
            </a>:
            <strong class="right">[<?= $c->getRating() ?>]</strong>
        </div>
        <form class="right" action="<?= url("vote/comment/" . $c->getID()) ?>" method="POST">
            <button type="submit" name="vote" value="up">+</button>
            <button type="submit" name="vote" value="down">-</button>
        </form>
        <p class="comment-body"><?= $c->getBody() ?></p>
    </li>
    <?php }; ?>
</ul>
<form class="comment-form" method="POST" action="<?= url("comments/create/" . $question->getCommentContainerID()) ?>">
<input type="text" name="body" placeholder="Comment" required>
    <button type="submit">Submit</button>
</form>

<h2>Answers</h2>
<form method="POST" action="<?= url("questions/answer/" . $question->getID()) ?>">
    <textarea name="body" placeholder="Your answer" required></textarea>
    <button type="submit">Submit</button>
</form>
<ul class="answers">
    <?php foreach ($question->getAnswers() as $a) { ?>
    <li class="answer <?= $a->getAccepted() ? "accepted-answer" : "" ?>" id="a<?= $a->getID() ?>">
        <h3>
            <em>Answer by</em>
            <a class="author answer-author" href="<?= url("users/view/" . $a->getAuthor()->getID()) ?>">
                <img class="author-img" src="<?= $a->getAuthor()->getImageLink(20) ?>" alt="The user's profile picture">
                <span class="author-name"><?= $a->getAuthor()->getName() ?></span>
            </a>
            <strong class="right">[<?= $a->getRating() ?>]</strong>
        </h3>
        <form class="right" action="<?= url("vote/answer/" . $a->getID()) ?>" method="POST">
            <button type="submit" name="vote" value="up">+</button>
            <button type="submit" name="vote" value="down">-</button>
        </form>
        <form method="POST" action="<?= url("questions/accept-answer/") ?>">
            <button type="submit" name="answer" value="<?= $a->getID() ?>" <?= !$isMyQuestion || $a->getAccepted() ? "disabled" : "" ?>>
                <?= $a->getAccepted() ? "Accepted" : "Accept" ?>
            </button>
        </form>
        <div class="answer-body"><?= $a->getBody() ?></div>
        <ul class="comments">
            <?php foreach ($a->getComments() as $c) { ?>
            <li class="comment" id="c<?= $c->getID() ?>">
                <div>
                    <a class="author comment-author" href="<?= url("users/view/" . $c->getAuthor()->getID()) ?>">
                        <img class="author-img" src="<?= $c->getAuthor()->getImageLink(20) ?>" alt="The user's profile picture">
                        <span class="author-name"><?= $c->getAuthor()->getName() ?></span>
                    </a>:
                    <strong class="right">[<?= $c->getRating() ?>]</strong>
                </div>
                <form class="right" action="<?= url("vote/comment/" . $c->getID()) ?>" method="POST">
                    <button type="submit" name="vote" value="up">+</button>
                    <button type="submit" name="vote" value="down">-</button>
                </form>
                <div class="comment-body"><?= $c->getBody() ?></div>
            </li>
            <?php }; ?>
        </ul>
        <form class="comment-form" method="POST" action="<?= url("comments/create/" . $a->getCommentContainerID()) ?>">
            <input type="text" name="body" placeholder="Comment" required>
            <button type="submit">Submit</button>
        </form>
    </li>
    <?php }; ?>
</ul>
