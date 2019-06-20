<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/19/2019
 * Time: 9:27 PM
 */

namespace App\Controller;


use App\Form\FileForm;
use App\Service\ApiHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{

    /**
     * @Route("/upload/file", name="app_upload_file")
     *
     * @param Request $request
     * @param ApiHandler $apiHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadedFileResults(Request $request, ApiHandler $apiHandler)
    {
        $form = $this->createForm(FileForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $file = $data['uploadFile'];
            $fileName = $file->getClientOriginalName();
            $file->move($this->getParameter('files_directory'),
                $fileName
            );
            $filename = '../public/uploads/' . $fileName;

            $process = $apiHandler->apiCall($fileName, 'file');

            return $this->render('layouts/table.html.twig', [
                'results' => $process->getResult(),
            ]);
        }
        return $this->render('form/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}