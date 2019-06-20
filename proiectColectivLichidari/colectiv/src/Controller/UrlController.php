<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/20/2019
 * Time: 12:34 AM
 */

namespace App\Controller;


use App\Form\UrlForm;
use App\Service\ApiHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    /**
     * @Route("/by/url", name="app_url")
     * @throws \Exception
     */
    public function urlResults(Request $request, ApiHandler $apiHandler)
    {
        $form = $this->createForm(UrlForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $url = $data['urlField'];

            $process = $apiHandler->apiCall($url, 'url');

            return $this->render('layouts/table.html.twig', [
                'results' => $process->getResult(),
            ]);
        }
        return $this->render('form/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}