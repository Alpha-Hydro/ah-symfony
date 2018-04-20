<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediaController
 * @package App\Controller
 *
 * @Route("/media")
 * @Cache(expires="tomorrow", public=true)
 */
class MediaController extends Controller
{

}
