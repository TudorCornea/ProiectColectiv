<?php
/**
 * Created by PhpStorm.
 * User: DodoT
 * Date: 6/18/2019
 * Time: 3:55 PM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class MainForm extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('uploadFile', FileType::class, ['label' => 'Upload your file'])
      ->add('Submit', SubmitType::class)
    ;
  }
}