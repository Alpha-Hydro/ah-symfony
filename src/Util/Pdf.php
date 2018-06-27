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

    public function showImages(): self
    {
        $imageProduct = $this->product->getUploadPath() . $this->product->getImage();
        $this->Image($imageProduct, $this->x, $this->y, '', 25, '', '', 'T');
        $this->SetX($this->getImageRBX() + 5);

        if ($this->product->getDraft() != '' && $this->product->getDraft() != null) {
            $draftProduct = $this->product->getUploadPathDraft() . $this->product->getDraft();
            $this->Image($draftProduct, $this->x, $this->y, '', 25, '', '', 'T', true, 190);
            $this->SetX($this->x + 5);
        }

        return $this;
    }

    public function showParams(): self
    {
        $x = $this->getImageRBX() + 5;
        $productParams = $this->product->getParams();
        if (!empty($productParams)) {
            $w = array(60, $this->getPageWidth() - $this->original_rMargin - $x - 60);
            foreach ($productParams as $param) {
                $this->SetFont('', 'B', 10);
                $this->MultiCell($w[0], 0, $param->getName(), 0, 'L', false, 0, $x, '', true, 0, false, true, 0);
                $this->SetFont('', '', 10);

                $this->MultiCell($w[1], 0, $param->getValue(), 0, 'L', false, 0, '', '', true, 0, false, true, 0);
                $this->Ln();
            }
        }

        $this->Ln(5);

        if ($this->y < $this->getImageRBY() + 5) {
            $this->SetX($x);
        }

        return $this;
    }

    public function showDescription(): self
    {
        if ($this->product->getDescription() != '' && $this->product->getDescription() != null) {
            $this->Write('', $this->product->getDescription());
            $this->Ln(5);
        }

        return $this;
    }
}