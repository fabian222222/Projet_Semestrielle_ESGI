<?php

namespace App\Service;

require '../vendor/autoload.php';

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
}