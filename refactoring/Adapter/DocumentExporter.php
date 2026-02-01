<?php

interface DocumentExporter
{
    public function addPage(): void;
    public function write(string $text): void;
    public function output(string $filename): void;
}
