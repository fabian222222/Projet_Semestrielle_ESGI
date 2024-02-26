<?php

namespace App\Service;


use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    public function __construct()
    {
//        $pdfOptions = new Options();
//        $pdfOptions->setChroot("/public/images");
        $domPdf = new Dompdf();
        $options = $domPdf->getOptions();
        $options->setDefaultFont('Helvetica');
        $domPdf->setOptions($options);
        $domPdf->setPaper('A4', 'portrait');
    }

    public function showPdfFile($html): void
    {
        $domPdf = new Dompdf();

        $domPdf->loadHtml($html);
        $domPdf->render();
        $domPdf->stream();
        exit;
    }


    public function generateBinaryPDF($html)
    {
        $domPdf = new Dompdf();

        $domPdf->loadHtml($html);
        $domPdf->render();
        $domPdf->output();
    }

    public function generatePDFFile($html, $fileName)
    {
        $domPdf = new Dompdf();

        $domPdf->loadHtml($html);
        $domPdf->render();

        file_put_contents($fileName . '.pdf', $domPdf->output());
    }
}