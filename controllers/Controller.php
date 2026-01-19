<?php

abstract class Controller
{
    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }
}

