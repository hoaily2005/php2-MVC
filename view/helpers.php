<?php

function renderView($view, $data = [], $title = "My App")
{
    extract($data);
    ob_start();
    require $view;
    $content = ob_get_clean();
    require "view/layouts/master.php";
}
