<?php

namespace Anax\View;

/**
 * Template file to render a view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?><span class="site-logo-text" >
    <a href="<?= url($homeLink) ?>">
        <?= $siteLogoText ?>
    </a>
</span>
