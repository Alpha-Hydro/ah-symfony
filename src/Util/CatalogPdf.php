<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Util;


use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use TCPDF;

/**
 * Class CatalogPdf
 * @package App\Util
 */
class CatalogPdf extends TCPDF
{
    /**
     * @var Products
     */
    private $product;


    /**
     * @var Request
     */
    private $request;

    /**
     * CatalogPdf constructor.
     * @param Products $product
     * @param Request $request
     */
    public function __construct(Products $product, Request $request)
    {
        $this->product = $product;
        $this->request = $request;

        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $this->SetCreator(PDF_CREATOR);

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default font subsetting mode
        $this->setFontSubsetting(true);

        // remove default header/footer
        //$this->setPrintHeader(false);
        //$this->setPrintFooter(false);

        //$this->setWidthWorkspacePage($this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT);

        //$this->setHostName(Zend_Controller_Front::getInstance()->getRequest()->getServer('HTTP_HOST'));
    }


    public function Header()
    {
        $this->setHeaderPage();
    }


    /**
     *
     */
    public function Footer() {
        $this->setFooterPage();
    }

    public function setHeaderPage(): void
    {
        $this->SetFont('', 'B', 16);
        $this->Write(0, $this->product->getSku());
        $this->Ln();
        $this->SetFontSize(12);
        $this->Write(0, $this->product->getName());

        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color);
        $this->SetY(20);
        $this->Line($this->original_lMargin, $this->y, $this->getPageWidth()-$this->original_rMargin, $this->y, $style);
    }

    public function setFooterPage(): void
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->Image(K_PATH_IMAGES.'alfa-hydro.png', $this->original_lMargin, $this->y, 50, '', 'PNG', '', 'M', true, 150, '', false, false, 0, false, false, false);

        $this->SetFontSize(10);
        $this->SetXY($this->x + 3, $this->y + 1);
        $this->SetFillColor(228,228,228);
        $numberPageWith = 20;
        $this->Cell($this->getPageWidth() - $this->x - $numberPageWith - 3, 7, 'www.'.$this->request->getHttpHost(), 0, 0, 'C', true, 'http://'.$this->request->getHttpHost().'/catalog/'.$this->product->getFullPath(), 0, false, 'M');
        $this->SetX($this->x + 3);
        $this->SetFillColor(0,148,218);
        $this->SetTextColor(255);
        $this->SetFont('', 'B', 10);
        $this->Cell($numberPageWith, 7, $this->getAliasNumPage(), 0, 1, 'C', true, '', 0, false, 'M');
    }
}