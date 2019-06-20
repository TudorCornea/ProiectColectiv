<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/15/2019
 * Time: 12:00 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

  /**
   * @Route("/", name="app_home")
   */
  public function home()
  {
    return $this->render('home.html.twig');
  }

}