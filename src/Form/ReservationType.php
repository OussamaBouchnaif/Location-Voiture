<?php
namespace App\Form;


use App\Entity\Agence;



use App\Entity\Client;
use App\Entity\Voiture;
use App\Entity\Reservation;
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

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('voiture',EntityType::class , [
            'class' => Voiture::class,
            'attr' => ['class' => 'mt-2']
        ])
        ->add('client',EntityType::class , [
            'class' => Client::class,
            'attr' => ['class' => 'mt-2']
        ])
        ->add('agence',EntityType::class , [
            'class' => Agence::class,
            'attr' => ['class' => 'mt-2']
        ])
       
       

        ->add('date_depart', DateType::class, [
            'widget' => 'single_text', // Utiliser un champ de texte avec icône de calendrier
            'attr' => ['class' => 'mt-2']
            // Autres options
        ])
        ->add('date_retour', DateType::class, [
            'widget' => 'single_text', // Utiliser un champ de texte avec icône de calendrier
            'attr' => ['class' => 'mt-2']
            // Autres options
        ])
     
        ->add('Enregistrer', SubmitType::class,['attr' => ['class' => 'btn btn-primary mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}