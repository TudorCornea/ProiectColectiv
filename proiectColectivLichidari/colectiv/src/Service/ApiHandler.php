<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/19/2019
 * Time: 11:48 PM
 */

namespace App\Service;


use Copyleaks\CopyleaksCloud;
use Copyleaks\Products;
use http\Exception;

class ApiHandler
{
    /**
     * Function to call the Copyleaks Api and to get the results.
     *
     * @param String $data
     *      $data for a file will be the path , and for the text will be a string
     * @param String $type
     * @return \Copyleaks\CopyleaksProcess
     */
    public function apiCall($data, $type)
    {
        $email = 'tudor.cornea@yahoo.com';                  //dvata22@gmail.com
        $apiKey = 'CFEFE4DF-18FC-4C54-9E21-FAD54FD00E4A';   //3BE839D2-0E44-4FD4-BAE5-38D33D659DE7

        try {
            $clCloud = new CopyleaksCloud($email, $apiKey, Products::Education);
        } catch (Exception $e) {
            echo "<Br/>Failed to connect to Copyleaks Cloud with exception: " . $e->getMessage();
            die();
        }

        try {
            $additionalHeaders = array();

            if ($type == 'file') {
                $process = $clCloud->createByFile($data, $additionalHeaders);
            }elseif ($type == 'text'){
                $process = $clCloud->createByText($data);
            }elseif ($type == 'url'){
                try {
                    $process = $clCloud->createByURL($data, $additionalHeaders);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }

            while ($process->getStatus() != 100) {
                sleep(2);
            }

        } catch (Exception $e) {

            echo "<br/>Failed with exception: " . $e->getMessage();
        }

        return $process;
    }
}