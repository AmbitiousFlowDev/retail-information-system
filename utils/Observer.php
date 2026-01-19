<?php

interface Observer
{
    public function update(string $event, $data = null): void;
}