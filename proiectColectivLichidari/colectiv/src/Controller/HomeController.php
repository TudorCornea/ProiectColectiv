<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/15/2019
 * Time: 12:00 PM
 */

namespace App\Controller;


use App\Form\MainForm;
use Copyleaks\CopyleaksCloud;
use Copyleaks\Products;
use http\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Unicheck\Corporate\Check\CheckParam;
use Unicheck\Corporate\PayloadFile;
use Unicheck\Corporate\Unicheck;

class HomeController extends AbstractController
{

  /**
   * @Route("/home", name="app_home")
   */
  public function home(Request $request)
  {

   /* $client = new \GuzzleHttp\Client();

      $res = $client->request('POST', "https://api.unicheck.com/oauth/access-token", [
        'form_params' => [
          "grant_type" => "client_credentials",
          "client_id" => "9f6c70d7272b3ac7bc7d",
          "client_secret" => "fd4a33cd66f6732bc737b0d6684507813c11c7a5"
        ]
      ]);
      $data = json_decode($res->getBody()->getContents(), true);

      $res1 = $client->request('POST', "https://api.unicheck.com/files",
        [
          'multipart' =>[
            [
              'name' => "test",
              "contents" => fopen('E:/proiectColectivLichidari/colectiv/src/Controller/2007.pdf', 'r'),
          ],
          [
            'name'     => 'file',
            'contents' => fopen('E:/proiectColectivLichidari/colectiv/src/Controller/2007.pdf', 'r'),
          ]
        ],
          'headers' =>
          [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer ' . $data['access_token'],
            //"Content-Type" => "multipart/form-data"
          ]]);

      $data1 = json_decode($res1->getBody()->getContents(), true);

      return $data;*/

    $config = new \ReflectionClass('Copyleaks\Config');
    $clConst = $config->getConstants();

    $email = 'corneatudor1@gmail.com';
    $apiKey = 'FEA5D3B4-8F8F-40D4-975A-393E2E096E4C';

    $form = $this->createForm(MainForm::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $data = $form->getData();

      $file = $data['uploadFile'];
      $fileName = $file->getClientOriginalName();
      $file->move($this->getParameter('files_directory'),
        $fileName
      );
      $filename = '../public/uploads/' . $fileName;

      try {
        $clCloud = new CopyleaksCloud($email, $apiKey, Products::Education);
      } catch (Exception $e) {
        echo "<Br/>Failed to connect to Copyleaks Cloud with exception: " . $e->getMessage();
        die();
      }

      try {
        $additionalHeaders = array();

        // Create process using one of the following option.
        //$process  = $clCloud->createByURL("https://www.copyleaks.com", $additionalHeaders);
        // $process  = $clCloud->createByText('<ENTER YOUR STRING HERE>');
        $process = $clCloud->createByFile($filename, $additionalHeaders);
        //$processes = $clCloud->createByFiles(array(firstFile,
        //										     secondFile),
        //									 $additionalHeaders); // Array with 2 elements - the first([0]) is the successfully created processes
        //						 the second([1]) is the error happend
        //$process  = $clCloud->createByOCR(imagePath,'English',$additionalHeaders);
        while ($process->getStatus() != 100) {
          sleep(2);
        }

      } catch (Exception $e) {

        echo "<br/>Failed with exception: " . $e->getMessage();
      }

      return $this->render('layouts/table.html.twig',[
        'results' => $process->getResult(),
      ]);
    }
    return $this->render('form/form.html.twig', [
      'form' => $form->createView(),
    ]);



  }


}