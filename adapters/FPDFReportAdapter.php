<?php

/**
 * Adapter pattern: adapts FPDF to ReportInterface.
 * Controllers depend on ReportInterface; this class wraps the concrete FPDF library.
 */
final class FPDFReportAdapter implements ReportInterface
{
    private FPDF $pdf;
    private array $currentHeaders = [];
    private bool $rowFill = false;

    public function __construct()
    {
        $this->pdf = new FPDF();
    }

    public function setTitle(string $title): self
    {
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(0, 10, $title, 0, 1, 'C');
        $this->pdf->Ln(5);
        return $this;
    }

    public function addPage(): self
    {
        $this->pdf->AddPage();
        return $this;
    }

    public function setTableHeaders(array $headers): self
    {
        $this->currentHeaders = $headers;
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->SetFillColor(37, 99, 235);
        $this->pdf->SetTextColor(255, 255, 255);
        $count = count($headers);
        $w = $count > 0 ? 190 / $count : 40;
        foreach ($headers as $i => $h) {
            $this->pdf->Cell($w, 10, $h, 1, $i === $count - 1 ? 1 : 0, 'C', true);
        }
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFillColor(240, 240, 240);
        return $this;
    }

    public function addRow(array $row): self
    {
        $count = count($row);
        $w = $count > 0 ? 190 / $count : 40;
        foreach ($row as $i => $cell) {
            $text = is_numeric($cell) ? (string) $cell : substr((string) $cell, 0, 35);
            $this->pdf->Cell($w, 8, $text, 1, $i === $count - 1 ? 1 : 0, 'L', $this->rowFill);
        }
        $this->rowFill = !$this->rowFill;
        return $this;
    }

    public function setFooter(string $footer): self
    {
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial', 'I', 8);
        $this->pdf->Cell(0, 10, $footer, 0, 0, 'C');
        return $this;
    }

    public function outputToBrowser(string $filename): void
    {
        $this->pdf->Output('D', $filename);
        exit;
    }
}
