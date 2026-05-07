<?php

function render($view, $data = [])
{
    extract($data);
    require $view;
}