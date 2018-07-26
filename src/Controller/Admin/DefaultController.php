<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * @throws \Exception
     */
    public function admin()
    {
        $bytes = random_bytes(4);

        return $this->render('admin/default_page.html.twig', ['password' => bin2hex($bytes)]);
    }
}