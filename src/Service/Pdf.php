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

    function Header();

    function Footer();

    function showName();

    function showImages();

    function showParams();

    function showDescription();

    function showModifications();

    function showNote();
}