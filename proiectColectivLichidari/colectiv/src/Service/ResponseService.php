<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/20/2019
 * Time: 1:11 AM
 */

namespace App\Service;


use FOS\RestBundle\Serializer\Serializer;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Show validation errors.
     *
     * @param FormInterface $form
     * @param $statusCode
     *
     * @return View
     */
    public function showFormValidationErrors($form, $statusCode)
    {
        $errors = $form->getErrors();
        $response = array(
            'error' => array(
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'code' => 9000,
                'message' => 'One or more fields raised validation errors.',
                'validation_errors' => $errors,
            )
        );
        $context = new \FOS\RestBundle\Context\Context();
        $formData = $this->serializer->serialize($response, 'json', $context);
        return View::create(json_decode($formData, true), $statusCode);
    }
}