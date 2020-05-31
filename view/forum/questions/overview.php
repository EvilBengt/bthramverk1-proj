<?php

namespace Anax\View;

?>

<h1>Questions</h1>

<a class="call-to-action" href="questions/ask">Ask a question!</a>

<ul class="question-list">
    <?php foreach ($questions as $q) { ?>
    <li class="question-list-item">
        <h2>
            <a href="<?= url("questions/view/" . $q->getID()) ?>"><?= $q->getTitle() ?></a>
            <strong class="right">[<?= $q->getRating() ?>]</strong>
        </h2>
        <?= \count($q->getAnswers()) . (\count($q->getAnswers()) == 1 ? " answer" : " answers") ?>
    </li>
    <?php }; ?>
</ul>

<?php if (\count($questions) > 10) { ?>
<a class="call-to-action" href="questions/ask">Ask a question!</a>
<?php }; ?>
