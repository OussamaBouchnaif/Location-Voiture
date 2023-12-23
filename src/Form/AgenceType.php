<?php

namespace App\Form;


use App\Entity\Agence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('nomagence',TextType::class ,[
            'attr' => ['class' => 'mt-2'],
            
            ])
            ->add('adresse',TextType::class ,[
                ])
            ->add('ville',TextType::class ,[
                'attr' => ['class' => 'mt-2'],
                
                ])
            ->add('pays',TextType::class ,[
                'attr' => ['class' => 'mt-2'],
                
                ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary mt-3'], // Ajoute la classe "m-3" pour une marge autour du bouton
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}