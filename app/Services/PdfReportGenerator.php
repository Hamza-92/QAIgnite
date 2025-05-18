<?php

namespace App\Services;

use TCPDF;

class PdfReportGenerator
{
    private $pdf;

    public function __construct()
    {
        $this->pdf = new TCPDF();
        $this->pdf->SetMargins(15, 20, 15);
        $this->pdf->SetAutoPageBreak(true, 20);
        $this->pdf->SetFont('dejavusans', '', 10);
    }

    public function generate(string $title, array $headers, array $data, array $keys = [])
    {
        $this->pdf->AddPage();

        // Title
        $this->pdf->SetFont('dejavusans', 'B', 14);
        $this->pdf->Cell(0, 10, strtoupper($title), 0, 1, 'C');
        $this->pdf->Ln(5);

        // Loop through records
        foreach ($data as $recordIndex => $record) {
            if ($recordIndex > 0) $this->pdf->Ln(6);
            foreach ($headers as $i => $header) {
                // if($record['id']) continue;
                $fieldLabel = is_array($header) ? $header['name'] : $header;
                $fieldKey = $keys[$i] ?? strtolower(str_replace(' ', '_', $fieldLabel));
                $value = $record[$fieldKey] ?? '';

                if (is_array($value)) {
                    $value = implode(', ', $value);
                }

                $this->pdf->SetFillColor(240, 240, 240);
                $this->pdf->SetFont('', 'B');
                $this->pdf->Cell(50, 8, $fieldLabel, 1, 0, 'L', true);

                $this->pdf->SetFillColor(255, 255, 255);
                $this->pdf->SetFont('', '');
                $this->pdf->MultiCell(125, 8, $value, 1, 'L', true, 1);
            }
        }

        return $this;
    }

    public function download(string $filename = 'report.pdf')
    {
        $this->pdf->Output($filename, 'D');
    }

    public function stream()
    {
        $this->pdf->Output('report.pdf', 'I');
    }
}
