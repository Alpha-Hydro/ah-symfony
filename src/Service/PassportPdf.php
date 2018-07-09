<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Vladmeh\Bundle\TCPDFBundle\Service\TcPdfService;

class PassportPdf extends TcPdfService implements Pdf
{

    private $product;
    private $request;
    private $_last_page_flag = false;

    public function __construct(Products $product, Request $request)
    {
        $this->product = $product;
        $this->request = $request;

        parent::__construct();
    }

    public function Header()
    {
        $this->SetFont('', 'B', 16);

        $this->Image(K_PATH_IMAGES . 'alfa-hydro.png', $this->original_lMargin, 5, 50, '', 'PNG', '', 'M', true, 150, '', false, false, 0, false, false, false);

        // @Todo modifications count
        $title = 'Паспорт № ' . $this->product->getId(). '/' .$this->product->getModifications()->count() .' от '. date('d.m.Y') . ' г.';
        $this->Cell(0, 0, $title, 0, 1, 'C', false, '', 0, false, 'M');

        $this->Image(K_PATH_IMAGES . 'znak_rst.png', $this->getPageWidth()-$this->original_rMargin-10, 5, 11, '', 'PNG', '', 'M', true, 300, '', false, false, 0, false, false, false);

        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color);
        $this->SetY(17);
        $this->Line($this->original_lMargin, $this->y, $this->getPageWidth()-$this->original_rMargin, $this->y, $style);
    }

    public function Close()
    {
        $this->_last_page_flag = true;
        parent::Close();
    }

    public function Footer()
    {
        if($this->_last_page_flag){
            $this->SetY(-25);
            $this->showSignature();
        }
    }

    function showName()
    {
        $this->SetY(20);
        $this->SetFont('', '', 16);
        $this->Write(0, $this->product->getName());
        $this->Ln(5);

        return $this;
    }

    public function showImages()
    {
        $imageProduct = $this->product->getUploadPath() . $this->product->getImage();
        $this->Image($imageProduct, $this->x, $this->y,'', 45);
        $this->SetX($this->x + 50);

        $draft = $this->product->getDraft();
        if ($draft != '' && $draft != null) {
            $draftProduct = $this->product->getUploadPathDraft() . $draft;
            $this->Image($draftProduct, $this->x, $this->y, '', 45,'','','',true,190);
        }

        $this->SetY($this->getImageRBY());
        $this->ln(5);
    }

    public function showParams()
    {
        // TODO: Implement showParams() method.
    }

    public function showDescription()
    {
        // TODO: Implement showDescription() method.
    }

    public function showModifications()
    {
        // TODO: Implement showModifications() method.
    }

    public function showNote()
    {
        // TODO: Implement showNote() method.
    }

    private function showSignature(){
        $n = 3;
        for($i = 0; $i < $n; ++$i){
            $this->SetFont('','B',11);
            $this->Cell($this->getWidthWorkspacePage()/$n, 5, 'Генеральный директор', 0, 0, 'R', false);
            $this->SetFont('','',11);
            $this->Cell($this->getWidthWorkspacePage()/$n, 5, 'М.П.', 0, 0, 'C', false);
            $this->Cell($this->getWidthWorkspacePage()/$n, 5, 'Подпись', 0, 0, 'L', false);
        }
        $this->Cell($this->getWidthWorkspacePage(), 0, '', 0);
    }

    private function getWidthWorkspacePage()
    {
        return $this->getPageWidth()-$this->original_rMargin-$this->original_lMargin;
    }
}