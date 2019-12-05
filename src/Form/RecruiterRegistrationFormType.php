<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Field;
use App\Entity\User;
use App\Repository\FieldRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecruiterRegistrationFormType extends AbstractType
{

    private $fieldRepository;
    public function __construct(FieldRepository $fieldRepository)
    {
        $this->fieldRepository = $fieldRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Votre prénom'
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Votre nom'
        ])
        ->add('email')
        /*
        ->add('company', TextType::class, [
            'label'=> 'Société'
        ])
        ->add('fields', EntityType::class, [
            'class' => Field::class,
            'label' => 'Domaines',
            'choice_label' => 'name',
            'multiple' => true,
            'help' => "Utiliser la touche Ctrl pour sélectionner pluisieurs domaines",
            'choices'=> $this->fieldRepository->findAll(),
        ])
        */
        ->add('password', PasswordType::class, [
            'label' => 'Mot de passe'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
    

   
}