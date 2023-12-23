<?php
namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Model;
use App\Entity\Voiture;
use Doctrine\DBAL\Types\FloatType;


use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\SmallIntType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('model',EntityType::class , [
            'class' => Model::class,
            'attr' => ['class' => 'mt-2']
        ])
        ->add('categorie',EntityType::class , [
            'class' => Categorie::class,
            'attr' => ['class' => 'mt-2']
        ])

        ->add('date_achat', DateType::class, [
            'widget' => 'single_text', // Utiliser un champ de texte avec icône de calendrier
            'label' => 'Date d\'achat',
            'attr' => ['class' => 'mt-2']
            // Autres options
        ])
        ->add('km_compteur',TextType::class,['attr' => ['class' => 'mt-2']])
        ->add('charge_max',TextType::class,['attr' => ['class' => 'mt-2']])
        ->add('prix_location',TextType::class,['attr' => ['class' => 'mt-2']])
        



        ->add('image', FileType::class, [
            'label' => 'Image (file)',
            'mapped' => false,
            'required' => false,
            
            
           
        ])
        ->add('Enregistrer', SubmitType::class,['attr' => ['class' => 'btn btn-primary mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}