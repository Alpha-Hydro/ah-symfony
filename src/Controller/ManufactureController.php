<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/manufacture")
 * @Cache(expires="tomorrow", public=true)
 */
class ManufactureController extends Controller
{

}
