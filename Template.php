<?php

namespace App;

function render($template, $args)
{
    extract($args);
    ob_start();
    include $template;
    return ob_get_clean();
}