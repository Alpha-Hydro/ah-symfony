<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;

interface Pdf
{

    public function Header();

    public function Footer();

    public function showImages();

    public function showParams();

    public function showDescription();

    public function showModifications();

    public function showNote();
}