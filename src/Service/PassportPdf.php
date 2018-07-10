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

    function showName(): self
    {
        $this->SetY(20);
        $this->SetFont('', '', 14);
        $this->Write(0, $this->product->getName());
        $this->Ln(10);

        return $this;
    }

    public function showImages(): self
    {
        $this->SetY($this->y + 5);
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

        return $this;
    }

    public function showParams(): self
    {
        $productParams = $this->product->getParams();
        if (!empty($productParams)) {
            $this->SetFont('','B',11);
            $this->Write(0, 'Свойства');
            $this->Ln(8);

            $w = array(60, $this->getPageWidth() - $this->original_lMargin - $this->original_rMargin - 60);
            foreach ($productParams as $param) {
                $this->SetFont('', 'B', 10);
                $this->MultiCell($w[0], 0, $param->getName(), 0, 'L', false, 0, '', '', true, 0, false, true, 0);
                $this->SetFont('', '', 10);

                $this->MultiCell($w[1], 0, $param->getValue(), 0, 'L', false, 0, '', '', true, 0, false, true, 0);
                $this->Ln();
            }
        }

        $this->Ln(10);

        return $this;
    }

    public function showDescription(): self
    {
        $this->SetFont('','B',12);
        $modifications = $this->product->getModifications();

        if (!empty($modifications)){
            $total = count($modifications);
            $counter = 1;
            foreach($modifications as $modification){
                $comma = ($counter != $total)?', ':'';
                $this->Write(0, $modification->getSku().$comma);
                $counter++;
            }
        }
        else{
            $this->Write(0, $this->product->getSku());
        }

        $this->Ln(10);

        return $this;
    }

    public function showModifications(): self
    {
        $this->SetFont('', '', 8);


        $widthWorkspacePage = $this->getPageWidth() - PDF_MARGIN_LEFT - PDF_MARGIN_RIGHT;
        $widthName = 25;
        $widthColumn = ($widthWorkspacePage - $widthName) / $this->product->getModificationParams()->count();


        $this->setCellPaddings('', 1, '', 1);
        $this->SetFillColor(0, 148, 218);
        $this->SetTextColor(255);

        //table head
        $this->MultiCell($widthName, 17, 'Название', 0, 'C', true, 0, '', '', true, 0, false, true, 0, 'M', true);
        foreach ($this->product->getModificationParams() as $modificationParam) {
            $this->MultiCell($widthColumn, 17, $modificationParam->getName(), 0, 'C', true, 0, '', '', true, 0, false, true, 0, 'M', true);
        }
        $this->ln();
        //table body
        $this->SetTextColor(0);
        foreach ($this->product->getModifications() as $key => $modification) {
            //start row
            $this->SetFillColor(255, 255, 255);
            if ($key & 1) {
                $this->SetFillColor(228, 228, 228);
            }

            //first column (название)
            $this->SetFont('', 'B');
            $this->Cell($widthName, 0, $modification->getSku(), 0, 0, 'L', true, '', 1);

            //other columns (values)
            $this->SetFont('', '');
            foreach ($this->product->getModificationParams() as $modificationParam) {
                foreach ($modification->getParamValues() as $paramsValues) {
                    if ($paramsValues->getParamId() == $modificationParam->getId()) {
                        $this->Cell($widthColumn, 0, $paramsValues->getValue(), 0, 0, 'C', true, '', 1);
                    }
                }
            }
            //end row
            $this->ln();
        }

        $this->Ln(10);

        return $this;
    }

    public function showNote($title = '', $text = ''): self
    {
        $this->SetFont('','B',10);
        $this->Write(0, $title);
        $this->Ln(10);

        $this->SetFont('','',10);
        $this->Write(0, $text);
        $this->Ln(10);

        return $this;
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