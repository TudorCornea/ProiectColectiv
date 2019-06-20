<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/19/2019
 * Time: 11:56 PM
 */

namespace App\Controller;


use App\Form\TextForm;
use App\Service\ApiHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    /**
     * @Route("/by/text", name="app_text")
     */
    public function textResults(Request $request, ApiHandler $apiHandler)
    {
        $form = $this->createForm(TextForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $text = $data['textField'];

            $process = $apiHandler->apiCall($text, 'text');

            return $this->render('layouts/table.html.twig', [
                'results' => $process->getResult(),
            ]);
        }
        return $this->render('form/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}