<?php
/**
 * Created by PhpStorm.
 * User: Rytis
 * Date: 12/17/2018
 * Time: 1:27 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array('label'=> 'CSV failas'))
            ->add('save', SubmitType::class, array('label'=> 'Ikelti'));
    }
}