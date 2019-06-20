<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/20/2019
 * Time: 2:59 AM
 */

namespace App\Controller\Api;

use App\Form\UrlForm;
use App\Service\ApiHandler;
use App\Service\ResponseService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UrlControllerApi extends AbstractFOSRestController
{
    /**
     * Plagiarism for an url.
     *
     * @Rest\Post("/url", name="api_create_url")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return View|Response
     */
    public function makeApiTextCall(Request $request, ResponseService $responseService, ApiHandler $apiHandler)
    {
        $form = $this->createForm(UrlForm::class);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $responseService->showFormValidationErrors($form, Response::HTTP_BAD_REQUEST);
        }

        $process = $apiHandler->apiCall($form->getData()['urlField'], 'url');
        return new Response(json_encode($process->getResult()), 200);
    }
}