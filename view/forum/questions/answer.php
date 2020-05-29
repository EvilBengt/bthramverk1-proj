<?php

namespace Anax\View;

?>

<h1><?= $question->getTitle() ?></h1>
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
<a class="question-author" href="<?= url("users/view/" . $question->getAuthor()->getID()) ?>"><?= $question->getAuthor()->getUsername() ?></a>
<ul class="comments">
    <?php foreach ($question->getComments() as $c) { ?>
    <li class="comment">
        <p class="comment-body"><?= $c->getBody() ?></p>
        <a class="comment-author" href="<?= url("users/view/" . $c->getAuthor()->getID()) ?>"><?= $c->getAuthor()->getUsername() ?></a>
    </li>
    <?php }; ?>
</ul>

<form method="POST" action="<?= url("questions/answer/" . $question->getID()) ?>">
    <textarea name="body" placeholder="Your answer" required></textarea>
    <button type="submit">Submit</button>
</form>
