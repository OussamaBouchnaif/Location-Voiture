<?php
namespace App\Form;




use App\Entity\User;


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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username',TextType::class,['attr' => ['class' => 'mt-2']])
        ->add('email',TextType::class,['attr' => ['class' => 'mt-2']])
        ->add('password',TextType::class,[
            'attr' => ['class' => 'mt-2'],
        ])
        
        
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
            'data_class' => User::class,
        ]);
    }
}