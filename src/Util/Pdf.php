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

class Pdf extends TcPdfService
{
    private $product;
    private $request;

    public function __construct(Products $product, Request $request)
    {
        $this->product = $product;
        $this->request = $request;

        parent::__construct();
    }

    public function initHeader(): void
    {
        $this->SetFont('', 'B', 16);
        $this->Write(0, $this->product->getSku());
        $this->Ln();
        $this->SetFontSize(12);
        $this->Write(0, $this->product->getName());

        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color);
        $this->SetY(20);
        $this->Line($this->original_lMargin, $this->y, $this->getPageWidth() - $this->original_rMargin, $this->y, $style);
    }

    public function initFooter(): void
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->Image(K_PATH_IMAGES . 'alfa-hydro.png', $this->original_lMargin, $this->y, 50, '', 'PNG', '', 'M', true, 150, '', false, false, 0, false, false, false);

        $this->SetFontSize(10);
        $this->SetXY($this->x + 3, $this->y + 1);
        $this->SetFillColor(228, 228, 228);
        $numberPageWith = 20;
        $this->Cell($this->getPageWidth() - $this->x - $numberPageWith - 3, 7, 'www.' . $this->request->getHttpHost(), 0, 0, 'C', true, 'http://' . $this->request->getHttpHost() . '/catalog/' . $this->product->getFullPath(), 0, false, 'M');
        $this->SetX($this->x + 3);
        $this->SetFillColor(0, 148, 218);
        $this->SetTextColor(255);
        $this->SetFont('', 'B', 10);
        $this->Cell($numberPageWith, 7, $this->getAliasNumPage(), 0, 1, 'C', true, '', 0, false, 'M');
    }
}