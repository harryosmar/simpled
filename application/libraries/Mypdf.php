<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require_once(APPPATH . 'config/tcpdf.php');
require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');

class Mypdf {

    private $pdf;
    private $pdf_header_title = 'PT.SEZ SMART CARD';
    private $pdf_header_string = '';
    private $pdf_header_logo = 'SimpLed.jpg';
    private $pdf_header_logo_width = '30';
    private $def_author = 'SimpLed';
    private $def_title = 'SimpLed';
    private $def_subject = 'SimpLed';
    private $def_keywords = 'Simple, Ledger, SimpLed';

    public function __construct($config = array()) {
        // create new PDF document
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $this->initialize($config);

        // set header and footer fonts
        $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }
    }

    public function initialize($config = array()) {
        //Set config variable
        if (is_array($config) && !empty($config)) {
            foreach ($config as $key => $val) {
                if (isset($this->{$key})) {
                    $this->{$key} = $val;
                }
            }
        }

        // set document information
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor($this->def_author);
        $this->pdf->SetTitle($this->def_title);
        $this->pdf->SetSubject($this->def_subject);
        $this->pdf->SetKeywords($this->def_keywords);

        // set default header data
        $this->pdf->SetHeaderData($this->pdf_header_logo, $this->pdf_header_logo_width, $this->pdf_header_title, $this->pdf_header_string);
    }

    public function generate($html = '', $filename = 'sez.pdf') {
        // set font
        $this->pdf->SetFont('dejavusans', '', 10);

        // add a page
        $this->pdf->AddPage();

        // output the HTML content
        $this->pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $this->pdf->lastPage();

        //Close and output PDF document
        $this->pdf->Output($filename, 'I');
    }

}

/* End of file Mypdf.php */
/* Location: ./application/libraries/Mypdf.php */