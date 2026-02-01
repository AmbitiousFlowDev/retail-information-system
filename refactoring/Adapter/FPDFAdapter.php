<?php

class FPDFAdapter implements DocumentExporter
{
    private FPDF $fpdf;

    public function __construct()
    {
        $this->fpdf = new FPDF();
    }

    public function addPage(): void
    {
        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Arial', '', 12);
    }

    public function write(string $text): void
    {
        $this->fpdf->MultiCell(0, 8, $text);
    }

    public function output(string $filename): void
    {
        $this->fpdf->Output('D', $filename);
    }
}
