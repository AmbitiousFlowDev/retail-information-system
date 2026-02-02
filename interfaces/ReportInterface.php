<?php

/**
 * Adapter target: common interface for report generation.
 * Implementations adapt external libraries (e.g. FPDF) to this interface.
 */
interface ReportInterface
{
    public function setTitle(string $title): self;

    public function addPage(): self;

    /** @param list<string> $headers */
    public function setTableHeaders(array $headers): self;

    /** @param list<string|int|float> $row */
    public function addRow(array $row): self;

    public function setFooter(string $footer): self;

    /** Output to browser (download). */
    public function outputToBrowser(string $filename): void;
}
